<?php

class backendAction extends baseAction
{
	protected $_name = '';
	protected $menuid = 0;
    public function _initialize() {
        parent::_initialize();
        $this->_name = $this->getActionName();
        $this->check_login();
        $this->assign('acname',strtolower($this->_name));
        //网站后台seo
        $this->assign('site_title','IKPHP网站管理');
        $ik_soft_info = array(
        		'ikphp_version' => IKPHP_VERSION,
        		'ikphp_year' => IKPHP_YEAR,
        		'ikphp_site_name' => IKPHP_SITENAME,
        		'ikphp_site_url' => IKPHP_SITEURL,
        		'ikphp_email' => IKPHP_EMAIL,
       		
        );
        $this->assign('ikphp', $ik_soft_info);
    }
    protected function title($title){
    	$this->assign('title', $title);
    }
    //检查登录状态
    public function check_login() {
    	if ( (!isset($_SESSION['admin']) || !$_SESSION['admin']) && !in_array(ACTION_NAME, array('login','verify_code')) ) {
    		$this->redirect('index/login');
    	}
    }    

    
}
