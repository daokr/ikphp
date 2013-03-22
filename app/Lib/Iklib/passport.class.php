<?php
/**
 * 文章模板标签解析
 *
 * @author charm
 */
class passport
{
    private $_error = 0;
    private $_us = null;

    public function __construct($name) {
        $file = LIB_PATH . 'Iklib/passport/' . $name . '.php';
        include $file;
        $class = $name . '_passport';
        $this->_us  = new $class();
    }
    /**
     * 注册新用户
     */
    public function register($username, $password, $email) {
    	if (!$add_data = $this->_us->register($username, $password, $email)) {
    		$this->_error = $this->_us->get_error();
    		return false;
    	}
    	//添加到本地
    	return $this->_local_add($add_data);
    } 
    /**
     * 本地用户添加
     */
    private function _local_add($add_data) {
    	$user_mod = D('user');
    	if (false !== $user_mod->create($add_data)) {
    		$uid = $user_mod->add();
    		if (!$uid) {
    			$this->_error = $user_mod->getError();
    			return false;
    		} else {
    			return $uid;
    		}
    	} else {
    		$this->_error = $user_mod->getError();
    		return false;
    	}
    } 
    /**
     * 登陆验证
     */
    public function auth($email, $password) {
    	$uid = $this->_us->auth($email, $password);
    	if (!$uid) {
    		$this->_error = $this->_us->get_error();
    		return false;
    	}
/*     	if (is_array($uid)) {
    		$uid = $this->_local_sync($result);
    	} */
    	return $uid;
    }
    /**
     * 同步登陆
     */
    public function synlogin($uid) {
    	return $this->_us->synlogin($uid);
    }
    
    /**
     * 同步退出
     */
    public function synlogout() {
    	return $this->_us->synlogout();
    } 
    public function get_error() {
    	return $this->_error;
    }

   
}