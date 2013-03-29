<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class peopleAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		if ($this->visitor->is_login) {
			$this->userid = $this->visitor->info ['userid'] > 0 ? $this->visitor->info ['userid'] : 0;
		}
		$this->group_mod = D ( 'group' );
		$this->user_mod = D ( 'user' );
		$this->group_users_mod = D ( 'group_users' );
		$this->group_topics_mod = D ( 'group_topics' );
		$this->group_topics_collects = D ( 'group_topics_collects' );
		$this->group_topics_comments = D ( 'group_topics_comments' );
	}
	public function index() {
		$doname = $this->_get ( 'id' );
		$userid = $this->user_mod->where ( array (
				'doname' => $doname 
		) )->getField ( 'userid' );
		if (empty ( $userid )) {
			$this->error ( '呃...你想要的东西不在这儿' );
		}
		
		$strUser = $this->user_mod->getOneUser ( $userid );
		$strUser['isfollow'] = $this->user_mod->isFollow($this->userid, $userid);
		//他关注的用户
		$strUser['followUser'] = $this->user_mod->getfollow_user($userid, 8);
		// 发布的帖子
		$arrMyTopic = $this->group_topics_mod->getUserTopic ( $userid, 10 );
		// 用户喜欢的帖子
		$MyCollects = $this->group_topics_collects->getUserCollectTopic ( $userid, 10 );
		if (is_array ( $MyCollects )) {
			foreach ( $MyCollects as $key => $item ) {
				$arrMyCollect [$key] = $this->group_topics_mod->getOneTopic ( $item ['topicid'] );
			}
		}
		// 回复的帖子
		$arrComments = $this->group_topics_comments->field ( 'topicid' )->where ( array (
				'userid' => $userid 
		) )->group ( 'topicid' )->order ( 'addtime DESC' )->select ();
		if (is_array ( $arrComments )) {
			foreach ( $arrComments as $item ) {
				$oneTopic = $this->group_topics_mod->getOneTopic($item ['topicid']);
				if ($oneTopic ['userid'] != $userid) {
					$arrMyComment [] = $oneTopic;
				}
			}
		}
		// 我加入的小组
		$myGroup = $this->group_mod->getUserJoinGroup( $userid );
		if(is_array($myGroup)){
			foreach($myGroup as $key=>$item){
				$arrMyGroup[] = $this->group_mod->getOneGroup($item['groupid']);
			}
		}
		
		$this->assign ( 'strUser', $strUser );
		$this->assign ( 'arrMyTopic', $arrMyTopic );
		$this->assign ( 'arrMyCollect', $arrMyCollect );
		$this->assign ( 'arrMyComment', $arrMyComment );
		$this->assign ( 'arrMyGroup', $arrMyGroup );
		
		$this->_config_seo ( array (
				'title' => $strUser ['username'],
				'subtitle' => '个人主页' 
		) );
		$this->display ();
	}
}