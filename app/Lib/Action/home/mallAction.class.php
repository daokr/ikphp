<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class mallAction extends frontendAction {
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
	public function share() {
	
		$this->_config_seo (array('title'=>'我要分享','subtitle'=>'淘客'));
		$this->display();
	}	
	public function index() {
		
		$this->_config_seo (array('title'=>'淘商品','subtitle'=>'淘客'));
		$this->display();
	}
	
	public function explore_goods() {
	
	
		$this->_config_seo (array('title'=>'发现宝贝','subtitle'=>'淘客'));
		$this->display();
	}	
	public function explore_album() {
	
		
		$this->_config_seo (array('title'=>'发现专辑','subtitle'=>'淘客'));
		$this->display();
	}
	
	public function album() {
	
	
		$this->_config_seo (array('title'=>'发现专辑','subtitle'=>'淘客'));
		$this->display('explore_album');
	}	
	
}