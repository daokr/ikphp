<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class groupModel extends Model {
	public function email_exists($name) {
		$where = "groupname='" . $name . "'";
		$result = $this->where ( $where )->count ( 'groupid' );
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	public function getNewGroup($limit){
		$where = array (
				'isshow' => 0,
		);
		$arrGroup = $this->field('groupid')->where ( $where )->order('addtime desc')->limit($limit)->select();
		if(is_array($arrGroup)){
			foreach($arrGroup as $item){
				$result[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $result;
	}
	public function getOneGroup($groupid) {
		if ($this->isGroup ( $groupid )) {
			$where = array (
					'groupid' => $groupid 
			);
			$result = $this->where ( $where )->find ();
			
			if (!is_file(C('ik_attach_path') . $result['groupicon'])) {
				$result['icon_48'] = __ROOT__ . "/static/public/images/group.jpg";
			}else{
				$result['icon_48'] = attach($result['groupicon']);
			}
			return $result;
		
		}
	}
	// 某用户创建的小组 
	public function getUserGroup($userid){
		$where = array (
				'userid' => $userid,
		);
		$result = $this->where ( $where )->select();
		return $result;		
	}
	// 某用户加入的小组 不包括自己创建的小组
	public function getUserJoinGroup($userid){
		$myCreateGroup = $this->getUserGroup($userid);
		if(is_array($myCreateGroup)){
			foreach($myCreateGroup as $item){
				$arrGroup[] = $item['groupid'];
			}
		}
		$strGroup = implode(',',$arrGroup);
		$where['userid'] = $userid;
		$where['groupid']  = array('not in',$strGroup);
		$result = D('group_users')->where ( $where )->select();
		return $result;		
	}
	// 某用户的小组包括 自己创建的
	public function getGroupUser($userid){
		$where = array('userid'=>$userid);
		$result = D('group_users')->where ( $where )->select();
		return $result;		
	}
	// 是否加入
	public function isGroupUser($userid, $groupid) {
		$where = array (
				'groupid' => $groupid,
				'userid' => $userid 
		);
		$result = M('group_users')->where ( $where )->count ( 'userid' );
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	// 判断是否存在小组
	public function isGroup($groupid) {
		$where = array (
				'groupid' => $groupid 
		);
		$result = $this->where ( $where )->count ( '*' );
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	// 更新当天帖子数
	public function updateTodayTopic($groupid, $count_topic, $count_topic_today) {
		$data = array (
				'count_topic' => $count_topic,
				'count_topic_today' => $count_topic_today,
				'uptime' => time ()
		);
		$where = array (
				'groupid' => $groupid
		);
		$result = $this->where ( $where )->save ( $data );
		return true;
	}
	// 小组内最新加入的会员
	public function getNewGroupUser($groupid,$limit){
		$where = array (
				'groupid' => $groupid,
		);
		$results = D('group_users')->where ( $where )->order('addtime desc')->limit($limit)->select();
		foreach($results as $key=>$item){
			$result[] = D('user')->getOneUser($item['userid']);
		}
		return $result;
	}
	//获取推荐的小组
	public function getRecommendGroup($limit){
		$where = array (
				'isrecommend' => 1,
		);
		$arrGroup = $this->where ( $where )->order('groupid asc')->limit($limit)->select();	
		if(is_array($arrGroup)){
			foreach($arrGroup as $item){
				$result[] = $this->getOneGroup($item['groupid']);
			}
		}
		return $result;
	}
	// 删除小组
	public function delGroup($groupid){
		$where['groupid'] = array('exp',' IN ('.$groupid.') ');
		//先删除帖子
		$arrTopic = D('group_topics')->field('topicid')->where($where)->select();
		foreach($arrTopic as $item){
			D('group_topics')->delTopic($item['topicid']);
		}
		//删除小组会员
		D('group_users')->where($where)->delete();
		//删除小组
		$this->where($where)->delete();
		return true;
	}

}