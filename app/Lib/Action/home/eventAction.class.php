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
		$this->cate_mod = D ( 'event_cate' );
	}
		
	public  function index(){
		$this->display();
	}
	//创建
	public  function create(){
		$loc = $this->_get('loc','trim');
		//获取分类
		$arrCate = $this->cate_mod->getAllCate();
		
		
		$currtCity = $this->area_mod->getOneAreaBypy($loc); //当前所在城市
		$arrCity = $this->area_mod->getHotCity();

		
		$this->assign('arrCate',$arrCate);
		$this->assign('currtCity',$currtCity);
		$this->assign('arrCity',$arrCity);
		$this->_config_seo (array('title'=>'创建同城活动','subtitle'=>$currtCity['areaname']));
		$this->display();
	}
	
}