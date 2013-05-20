<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class appAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		// 访问者控制
		if (! $this->visitor->is_login && in_array ( ACTION_NAME, array (
				'create',
		) )) {
			$this->redirect ( 'user/login' );
		} else {
			$this->userid = $this->visitor->info ['userid'];
		}
		$this->user_mod = D ( 'user' );
	}
	public function index() {
		
		$this->_config_seo (array('title'=>'发布/管理应用','subtitle'=>'应用商店'));
		$this->display();
	}		
		
	
}