<?php
class indexAction extends backendAction {

    public function _initialize() {
        parent::_initialize();
       
    }

    public function index() {
    	$admin = array('username'=>$_SESSION['admin']['username'], 'rolename'=>$_SESSION['admin']['role_id']);
    	$this->assign('admin', $admin);
    			
    	$this->title('管理中心');
        $this->display();
    }
    //左侧菜单
    public function left() {
    	 
    	$ik = $this->_get ( 'ik', 'trim' );
    	if(empty($ik)){ $ik = 'index';}
    	
    	$this->assign('ik', $ik);
    	$this->display();
    }
    public function main(){
    	// 检测文件夹权限
    	$message = array();
    	if (is_dir('./install')) {
    		$message[] = array(
    				'type' => 'error',
    				'content' => "您还没有删除 install 文件夹，出于安全的考虑，我们建议您删除 install 文件夹。",
    		);
    	}
    	if (APP_DEBUG == true) {
    		$message[] = array(
    				'type' => 'error',
    				'content' => "您网站的 DEBUG 没有关闭，出于安全考虑，我们建议您关闭程序 DEBUG。",
    		);
    	}
    	if (!function_exists("curl_getinfo")) {
    		$message[] = array(
    				'type' => 'error',
    				'content' => "系统不支持 CURL ,将无法采集数据。",
    		);
    	}
    	$this->assign('message', $message);
    	//gd版本信息
    	if (! function_exists ( "gd_info" )) {
    		$gd = '不支持,无法处理图像';
    	}
    	if (function_exists ( gd_info )) {
    		$gd = @gd_info ();
    		$gd = $gd ["GD Version"];
    		$gd ? '&nbsp; 版本：' . $gd : '';
    	}
    	$system = array(
    			'pinphp_version' => IKPHP_VERSION . ' RELEASE '. IKPHP_RELEASE .' [<a href="'.IKPHP_SITEURL.'" class="blue" target="_blank">查看最新版本</a>]',
    			'server_domain' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
    			'server_os' => PHP_OS,
    			'web_server' => $_SERVER["SERVER_SOFTWARE"],
    			'php_version' => PHP_VERSION,
    			'mysql_ver' => mysql_get_server_info (),
    			'server_language' => $_SERVER[HTTP_ACCEPT_LANGUAGE],
    			'gd_info' => $gd,
    			'document_root' => $_SERVER[DOCUMENT_ROOT],
    			'upload_max_filesize' => '表单允许' . ini_get ( 'post_max_size' ) . '，上传总大小' . ini_get ( 'upload_max_filesize' ),
    			'max_execution_time' => ini_get('max_execution_time') . '秒',
    			'safe_mode' => (boolean) ini_get('safe_mode') ?  L('yes') : L('no'),
    			'zlib' => $_SERVER[HTTP_ACCEPT_ENCODING],
    			'curl' => function_exists("curl_getinfo") ? L('yes') : L('no'),
    			'timezone' => function_exists("date_default_timezone_get") ? date_default_timezone_get() : L('no')
    	);
    	$this->assign('system', $system);
    	$this->display();

    }
    //admin 登录
    public function login() {
    	if (IS_POST) {
    		$email = $this->_post('admin_email', 'trim');
    		$password = $this->_post('admin_password', 'trim');
    		$admin = M('admin')->where(array('email'=>$email, 'status'=>1))->find();
    		if (!$admin) {
    			$this->error(L('admin_not_exist'));
    		}
    		if ($admin['password'] != md5($password)) {
    			$this->error(L('password_error'));
    		}
    		session('admin', array(
    		'userid' => $admin['userid'],
    		'role_id' => $admin['role_id'],
    		'username' => $admin['username'],
    		'email' => $admin['email'],
    		));
    		M('admin')->where(array('userid'=>$admin['userid']))->save(array('last_time'=>time(), 'last_ip'=>get_client_ip()));
    		$this->success(L('login_success'), U('index/index'));
    	} else {
    		$this->display();
    	}
    }
    //admin 退出
    public function logout() {
    	session('admin', null);
    	$this->success(L('logout_success'), U('index/login'));
    	exit;
    }    
}