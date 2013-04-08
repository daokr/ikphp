<?php
/**
 * 用户控制器基类
 *
 * @author 小麦
 */
class userbaseAction extends frontendAction {
	
	public function _initialize() {
		parent::_initialize ();
		//访问者控制
		/* if (!$this->visitor->is_login && !in_array(ACTION_NAME, array('login', 'register','check'))) {
			$this->redirect('user/login');
		} */		
		//当前设置项
		$this->_curr_menu(ACTION_NAME);
	}
	protected function _curr_menu($menu = 'setbase') {
		$menu_list = $this->_get_menu ();
		$this->assign ( 'user_menu_list', $menu_list );
		$this->assign ( 'user_menu_curr', $menu );
	}
	private function _get_menu() {
		$menu = array ();
    	$menu = array(
    				'setbase' => array('text'=>'基本信息', 'url'=>U('user/setbase')),
    				'setface' => array('text'=>'会员头像', 'url'=>U('user/setface')),
    				'setdoname' => array('text'=>'个性域名', 'url'=>U('user/setdoname')),
    				'setcity' => array('text'=>'常居地', 'url'=>U('user/setcity')),
    				'setpassword' => array('text'=>'修改密码', 'url'=>U('user/setpassword')),
    				//'bind' => array('text'=>'第三方绑定', 'url'=>U('user/bind')),
    			);
		return $menu;
	}

}