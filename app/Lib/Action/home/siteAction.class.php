<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class siteAction extends frontendAction {
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
		$this->site_mod = D ( 'site' );
		$this->user_mod = D ( 'user' );
	}
	public function index() {
		
		$this->_config_seo (array('subtitle'=>'爱客小站'));
		$this->display();
	}
	//发下小站
	public function explore(){
		
		$this->display();
	}
	//创建小站
	public function create(){
		if(IS_POST){
			
			$data['sitename'] = $sitename = $this->_post('sitename','trim,t','');
			$data['sitedesc'] = $sitedesc = $this->_post('sitedesc','trim,t','');
			//安全新检查
			if(mb_strlen($sitename,'utf8') > 15)  $this->error('小站名称最多15个汉字或30个英文字母^_^');
			if(mb_strlen($sitedesc,'utf8') > 250) $this->error('小站描述最多250个汉字^_^');
			//重复性检查
			$ishave = $this->site_mod->where(array('sitename'=>$sitename))->count();
			if($ishave > 0) $this->error("小站名称已经存在，请更换其他名称！");
			//拼合数据
			$data['isaudit'] = 0;
			$data['isaudit'] = time();
			//$siteid = $this->site_mod->
			
				
			
		}else{
			
			$this->_config_seo (array('title'=>'创建小站','subtitle'=>'小站'));
			$this->display();
		}
	}
	
}