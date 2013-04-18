<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class eventAction extends frontendAction {
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
		$this->area_mod = D ( 'area' );
		$this->user_mod = D ( 'user' );
	}
		
	public  function index(){
		$this->display();
	}
	//创建
	public  function create(){
		$currtCity = array('areaid'=>1,'areaname'=>'北京'); //当前所在城市
		$arrCity = array();
		$arrCity[0]= array('id'=>1,'areaname'=>'北京');
		$arrCity[1]= array('id'=>2,'areaname'=>'上海');
	
		
		$this->_config_seo (array('title'=>'创建同城活动','subtitle'=>'北京'));
		$this->assign('currtCity',$currtCity);
		$this->assign('arrCity',$arrCity);
		$this->display();
	}
	
}