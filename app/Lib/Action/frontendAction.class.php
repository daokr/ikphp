<?php
/**
 * 前台控制器基类
 *
 * @author 小麦
 */
class frontendAction extends baseAction {

    protected $visitor = null;
    
    public function _initialize() {
        parent::_initialize();
        //消除所有的magic_quotes_gpc转义
        Input::noGPC();
        //网站状态
        //初始化访问者
        $this->_init_visitor();
        //第三方登陆模块
        //$this->_assign_oauth();
        //网站导航选中
        //$this->assign('nav_curr', '');
        //网站导航
        $this->assign('arrNav',$this->_nav($this->module_name));
        $this->assign('logo',$this->_navlogo($this->module_name));
    }
    /**
     * 初始化访问者
     */
    private function _init_visitor() {
    	$this->visitor = new user_visitor();
    	$this->assign('visitor', $this->visitor->info);
    }
    /**
     * 连接用户中心
     */
    protected function _user_server() {
    	$passport = new passport(C('ik_integrate_code'));
    	return $passport;
    }
    /**
     * SEO设置
     */
    protected function _config_seo($seo_info = array(), $data = array()) {
    	$page_seo = array(
    			'title' => C('ik_site_title'),
    			'subtitle' => C('ik_site_subtitle'),
    			'keywords' => C('ik_site_keywords'),
    			'description' => C('ik_site_desc')
    	);
    	$page_seo = array_merge($page_seo, $seo_info);
    	//开始替换
    	$searchs = array('{site_name}', '{site_title}', '{site_keywords}', '{site_desc');
    	$replaces = array(C('ik_site_title'), C('ik_site_subtitle'), C('ik_site_keywords'), C('ik_site_desc'));
    	preg_match_all("/\{([a-z0-9_-]+?)\}/", implode(' ', array_values($page_seo)), $pageparams);
    	if ($pageparams) {
    		foreach ($pageparams[1] as $var) {
    			$searchs[] = '{' . $var . '}';
    			$replaces[] = $data[$var] ? strip_tags($data[$var]) : '';
    		}
    		//符号
    		$searchspace = array('((\s*\-\s*)+)', '((\s*\,\s*)+)', '((\s*\|\s*)+)', '((\s*\t\s*)+)', '((\s*_\s*)+)');
    		$replacespace = array('-', ',', '|', ' ', '_');
    		foreach ($page_seo as $key => $val) {
    			$page_seo[$key] = trim(preg_replace($searchspace, $replacespace, str_replace($searchs, $replaces, $val)), ' ,-|_');
    		}
    	}
    	$this->assign('seo', $page_seo);
    }
    /**
     * 前台分页统一
     */
    protected function _pager($count, $pagesize) {
    	$pager = new Page($count, $pagesize);
    	$pager->rollPage = 5;
    	$pager->setConfig('prev', '<前页');
    	$pager->setConfig('next', '后页>');
    	$pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
    	return $pager;
    } 
	// 网站导航
	protected  function _nav($module_name){
		if (! empty ( $module_name )) {
			$arrNav = array ();
			switch ($module_name) {
				case "group" :
					// 小组导航
					if($this->visitor->info['userid']){
						$arrNav['index'] = array('name'=>'我的小组', 'url'=>U('group/index'));
					}
					$arrNav['explore'] = array('name'=>'发现小组', 'url'=>U('group/explore'));
					$arrNav['explore_topic'] = array('name'=>'发现话题', 'url'=>U('group/explore_topic'));
					$arrNav['nearby'] = array('name'=>'北京话题', 'url'=>U('group/nearby'));
					break;
					
				case "article" :
					// 发表评论
				    $arrChannel = D('article_channel')->getAllChannel(array('isnav'=>'0'));
				    foreach($arrChannel as $item){
				    	$arrNav[$item['nameid']] = array('name'=>$item['name'], 'url'=>U('article/channel',array('nameid'=>$item['nameid'])));
				    }
					break;
				default:
					$arrNav['index'] = array('name'=>'首页', 'url'=>C('ik_site_url'));
					$arrNav['group'] = array('name'=>'小组', 'url'=>U('group/index'));
					$arrNav['article'] = array('name'=>'阅读', 'url'=>U('article/index'));
					break;
			}
			return $arrNav;
		}		
	}
	// 导航logo
	protected  function _navlogo($module_name){
		if (! empty ( $module_name )) {
			$arrLogo = array ();
			switch ($module_name) {
				case "group" :
					$arrLogo = array('name'=>'小组', 'url'=>U('group/index'), 'style'=>'site_logo nav_logo');
					break;
						
				case "article" :
					$arrLogo = array('name'=>'阅读', 'url'=>U('article/index'), 'style'=>'site_logo nav_logo');
					break;
				default:
					$arrLogo = array('name'=>'爱客开源', 'url'=>C('ik_site_url'), 'style'=>'site_logo');
					break;
			}
			return $arrLogo;
		}
	}
  
}