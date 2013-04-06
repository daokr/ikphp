<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class group_topicsModel extends Model {
	// 统计小组下帖子数
	public function countTopic($groupid) {
		$where = array (
				'groupid' => $groupid 
		);
		$result = $this->where ( $where )->count ( '*' );
		return $result;
	}
	// 统计当天发布的帖子数
	public function countTodayTipic($groupid) {
		$today_start = strtotime ( date ( 'Y-m-d 00:00:00' ) );
		$today_end = strtotime ( date ( 'Y-m-d 23:59:59' ) );
		$where = "groupid='" . $groupid . "' AND addtime >'" . $today_start . "'";
		$result = $this->where ( $where )->count ( '*' );
		return $result;
	}
	public function getOneTopic($topic_id) {
		if ($this->isTopic ( $topic_id )) {
			$where = array (
					'topicid' => $topic_id
			);
			$result = $this->where ( $where )->find ();
			$result ['content'] = nl2br ( ikhtml('topic',$topic_id,$result ['content']) );
			
			return $result;
		}
	}
	// 最热话题 评论最多的
	public function getHotTopic($limit){
		$where['groupid']  = array('gt',0);
		$where['isshwo'] = 0;
		$where['isaudit']  = '0';
		//$arrList = $this->field('userid,topicid,groupid')->where ( $where )->order('count_comment desc')->limit($limit)->select();
		$arrList = $this->field('userid,topicid,groupid')->where ( $where )->order('istop desc,addtime desc')->limit($limit)->select();
		
		if(is_array($arrList)){
			foreach($arrList as $key=>$item){
				$result[] = $this->getOneTopic($item['topicid']);
				$result[$key]['user'] = D('user')->getOneUser($item['userid']);
				$result[$key]['content'] = getsubstrutf8(t($item['content']),0,50);
			}
		}
		return $result;
	}	
	// 是否存在帖子
	public function isTopic($topic_id) {
		$where = array (
				'topicid' => $topic_id 
		);
		$result = $this->where ( $where )->count ( '*' );
		if ($result > 0) {
			return true;
		} else {
			return false;
		}
	}
	//最新话题
	public function newTopic($groupid, $limit){
		$where = array (
				'groupid' => $groupid,
				'isshow' =>0,
		);
		$results = $this->where ( $where )->order('istop desc,addtime desc')->limit($limit)->select();
		foreach($results as $key=>$item){
			$result[] = $item;
			$result[$key]['user'] = D('user')->getOneUser($item['userid']);
		}
		return $result;	
	}
	// 获取小组话题
	public function getTopics($strgroupid,$limit){
		$where['groupid'] = array('exp',' IN ('.$strgroupid.') ');
		$where['isshow'] = 0;
		$where['isaudit'] = 0;//审核
		$result = $this->where ( $where )->order('uptime desc')->limit($limit)->select();
		return $result;	
	}
	// 获取用户回应的话题
	public function getUserRepliedTopic($userid, $limit){
		$myTopics = D('group_topics_comments')->field('topicid')->where(array('userid'=>$userid))->group('topicid')->order('addtime desc')->limit($limit)->select();		
		foreach($myTopics as $item){
			$strTopic = $this->getOneTopic($item['topicid']);
			$arrTopics[] = $strTopic;
		}
		return $arrTopics;
	}
	// 获取用户发表话题
	public function getUserTopic($userid, $limit){
		$where['groupid']  = array('gt',0);
		$where['userid'] = $userid;
		$result = $this->where ( $where )->order('addtime desc')->limit($limit)->select();
		return $result;		
	}
	//Refer二级循环，三级循环暂时免谈 获取评论
	public function recomment($referid){
		$where = array (
				'commentid' => $referid,
		);
		$strComment = D('group_topics_comments')->where( $where )->find();
		$strComment['user'] = D('user')->getOneUser($strComment['userid']);
		$strComment['content'] = h($strComment['content']);
	
		return $strComment;
	}
	// 删除话题的单个或多个评论$commentid='1,2,3' 以逗号分隔
	public function delComment($commentid){
		$where['commentid'] = array('exp',' IN ('.$commentid.') ');
		$arrComment = D('group_topics_comments')->field('topicid')->where($where)->select();
		if($arrComment){
			D('group_topics_comments')->where($where)->delete();
			//更新帖子评论统计
			foreach ($arrComment as $item){
				$map['topicid'] = $item['topicid'];
				$map['count_comment'] = array('gt','0');
				$this->where($map)->setDec('count_comment');
			}
			return true;
		}else{
			return false;
		}
	}
	// 根据topicid删除话题的所有评论
	public function delTopicComment($topicid){
		$where['topicid']  = $topicid;
		$arrComment = D('group_topics_comments')->where($where)->select();
	
		foreach($arrComment as $item){
			$this->delComment($item['commentid']);
		}
		return true;
	}
    /**
     * 通过$topicid删除话题
     * @access public
     * @param string $topicid 要删除的id字符串如：id=1,2,3
     * @return boolean
     */
	public function delTopic($topicid){
		$where['topicid'] = array('exp',' IN ('.$topicid.') ');
		$arrTopic = $this->where($where)->find();
		if($arrTopic){
			//删除帖子表
			$this->where($where)->delete();
			//更新group表帖子数
			$group = D('group')->where($where)->select();
			foreach ($group as $item){
				if($item['count_topic']>0){
					D('group')->where(array('groupid'=>$item['groupid']))->setDec('count_topic');
				}
			}
			//删除评论表
			D('group_topics_comments')->where($where)->delete();
			//删除喜欢收藏表
			D('group_topics_collects')->where($where)->delete();
			//删除tag标签表
			D('tag_topic_index')->where($where)->delete();
			//删除图片
			D('images')->delAllImage('topic',$topicid);
			//删除视频
			//D('videos')->delAllVideos('topic',$topicid);
			return true;
		}else{
			return false;
		}
	}
}