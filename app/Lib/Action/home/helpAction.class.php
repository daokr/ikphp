<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class helpAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'home_info' );
		$this->down_mod = D ( 'downcount' );
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
				'download' => array('text'=>'源码下载', 'url'=>U('help/download')),
		);
		return $arrMenu;
	}
	public function download(){
		$from = $this->_get('id');
		$countdown = $this->down_mod->count(); 
		if(empty($from)){
			$this->_config_seo (array('title'=>'IKPHP源码下载','subtitle'=>'首页'));
			$this->assign('count', $countdown);	
			$this->display('down');
		}else{
			
			if($from == 1)
			{ 
				$data = array('userip'=>get_client_ip(),'downfrom'=>'本地下载','downtime'=>time());
				if(!false == $this->down_mod->create($data)){
					$this->down_mod->add(); 
					header('Location: http://www.ikphp.com/down/IKPHP_V1.5.1.zip');
				}
			}
			if($from == 2)
			{
				$data = array('userip'=>get_client_ip(),'downfrom'=>'admin5下载','downtime'=>time());
				if(!false == $this->down_mod->create($data)){
					$this->down_mod->add();
					header('Location: http://down.admin5.com/php/102536.html');
				}
			}
			if($from == 3)
			{
				$data = array('userip'=>get_client_ip(),'downfrom'=>'中国站长下载','downtime'=>time());
				if(!false == $this->down_mod->create($data)){
					$this->down_mod->add();
					header('Location: http://down.cnzz.cn/info/89353.aspx');
				}
			}			
		}
	}	
	
}