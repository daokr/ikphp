<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class user_visitor {

    public $is_login = false; //登陆状态
    public $info = null;

    public function __construct() {
        if (session('user_info')) {
            //已经登陆
            $this->info = session('user_info');
            $this->is_login = true;
        } elseif ($user_info = (array)cookie('user_info')) {
            $user_info = M('user')->field('userid,username')->where(array('userid'=>$user_info['userid'], 'password'=>$user_info['password']))->find();
            if ($user_info) {
                //记住登陆状态
                $this->assign_info($user_info);
                $this->is_login = true;
            }
        } else {
            $this->is_login = false;
        }
    }
    /**
     * 登陆会话
     */
    public function assign_info($user_info) {
    	session('user_info', $user_info);
    	$this->info = $user_info;
    }

    /**
     * 登陆
     */
    public function login($uid, $remember = null) {
        $user_mod = M('user');
        //更新用户信息
        $user_mod->where(array('userid' => $uid))->save(array('uptime' => time(), 'ip' => get_client_ip()));
        $user_info = $user_mod->field('userid,username,password,doname')->find($uid);
        //保持状态
        $this->assign_info($user_info);
        $this->remember($user_info, $remember);
    }
    /**
     * 记住密码
     */
    public function remember($user_info, $remember = null) {
    	if ($remember) {
    		$time = 3600 * 24 * 14; //两周
    		cookie('user_info', array('userid'=>$user_info['userid'], 'password'=>$user_info['password']), $time);
    	}
    }

    /**
     * 退出
     */
    public function logout() {
        session('user_info', null);
        cookie('user_info', null);
    }
    /**
     * 获取用户信息
     */
    public function get($key = null) {
    	$info = null;
    	if (is_null($key) && $this->info['userid']) {
    		$info = M('user')->find($this->info['userid']);
    	} else {
    		if (isset($this->info[$key])) {
    			return $this->info[$key];
    		} else {
    			//获取用户表字段
    			$fields = M('user')->getDbFields();
    			if (!is_null(array_search($key, $fields))) {
    				$info = M('user')->where(array('userid' => $this->info['userid']))->getField($key);
    			}
    		}
    	}
    	return $info;
    }

}