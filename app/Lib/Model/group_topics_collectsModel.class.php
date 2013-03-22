<?php
class group_topics_collectsModel extends Model {
	// 喜欢收藏的人数
	public function countLike($topicid) {
		$where = array('topicid'=>$topicid);
		$result = $this->where ( $where )->count ( '*' );
		return $result;
	}
	// 是否已经喜欢过
	public function isLike($userid,$topicid) {
		$where = array('userid'=>$userid, 'topicid'=>$topicid);
		$result = $this->where ( $where )->count ( '*' );
		if($result){
			return true;
		}else{
			return false;
		}
	}
	// 谁收藏或喜欢了该帖
	public function likeTopicUser($topicid,$limit = 6){
		
		$where = array('topicid'=>$topicid);
		$arrCollectUser = $this->where ( $where )->order('addtime')->limit($limit)->select();
		if(is_array($arrCollectUser)){
			foreach($arrCollectUser as $item){
				$strUser = D('user')->getOneUser($item['userid']);
				$arrUser[] = $strUser;
			}
		}
		return $arrUser;		
	}
	//根据用户id 查询他收藏的帖子
	public function getUserCollectTopic($userid, $limit){
		$where = array('userid'=>$userid);
		$result = $this->where ( $where )->order('addtime desc')->limit($limit)->select();
		return  $result;
	}
	//收藏/取消收藏 该帖子
	public function collectTopic($userid, $topicid){
		$is_like = $this->where(array('userid'=>$userid, 'topicid'=>$topicid))->count('*');
		if($is_like > 0){
			//已经喜欢过了 执行取消操作
			$is_del = $this->where(array('userid'=>$userid, 'topicid'=>$topicid))->delete();
			if($is_del){
				D('group_topics')->where ( array ('topicid' => $topicid) )->setDec ('count_collect');
				$collectNum = D('group_topics')->where ( array ('topicid' => $topicid) )->getField('count_collect');
				$arrJson = array('r'=>1, 'num'=>$collectNum);
			}
		}else{
			//执行喜欢
			$data = array('userid'=>$userid, 'topicid'=>$topicid, 'addtime'=>time());
			if (false !== $this->create ( $data )) {
				$cid = $this->add ();
				if ($cid) {
					// 更新收藏数
					D('group_topics')->where ( array ('topicid' => $topicid) )->setInc ('count_collect');
					$collectNum = D('group_topics')->where ( array ('topicid' => $topicid) )->getField('count_collect');
					$arrJson = array('r'=>0, 'num'=>$collectNum);
				}
			}	
		}
		return $arrJson;
	}
	//根据topicid删除 收藏
	public function delCollectTopic($topicid){
		$where = array('topicid'=>$topicid);
		$this->where($where)->delete();
		return true;
	}

}