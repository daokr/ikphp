<?php
// 本类由系统自动生成，仅供测试用途
class helpAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'home_info' );
		$this->assign('arrMenu',$this->getMenu());

		$this->assign('infokey',ACTION_NAME);
		$where = array('infokey'=>ACTION_NAME);
		$strInfo = $this->mod->where($where)->find();
		$strInfo['infocontent'] = htmlspecialchars_decode($strInfo['infocontent']);
		$this->assign('strInfo',$strInfo);
	}
	public function about() {
		$this->_config_seo (array('title'=>'关于我们','subtitle'=>'首页'));
		$this->display('page');
	}
	public function contact() {
		$this->_config_seo (array('title'=>'联系我们','subtitle'=>'首页'));
		$this->display('page');
	}
	public function agreement() {
		$this->_config_seo (array('title'=>'用户条款','subtitle'=>'首页'));
		$this->display('page');
	}
	public function privacy() {
		$this->_config_seo (array('title'=>'隐私声明','subtitle'=>'首页'));
		$this->display('page');
	}
	function getMenu(){
		$arrMenu = array(
				'about' => array('text'=>'关于我们', 'url'=>U('help/about')),
				'contact' => array('text'=>'联系我们', 'url'=>U('help/contact')),
				'agreement' => array('text'=>'用户条款', 'url'=>U('help/agreement')),
				'privacy' => array('text'=>'隐私声明', 'url'=>U('help/privacy')),
		);
		return $arrMenu;
	}	
	
}