<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class oauth {

    private $_type = '';
    private $_setting = array();

    public function __construct($type) {
        $this->_type = $type;
        //加载登陆接口配置
        $setting = M('oauth')->where(array('code' => $type))->getField('config');
        $this->_setting = unserialize($setting);
      
        //导入接口文件
        include_once LIB_PATH . 'Iklib/oauth/' . $type . '/' . $type . '.php';
        $om_class = $type . '_oauth'; //echo $om_class;die;
        $this->_om = new $om_class($this->_setting);
    }

    /**
     * 跳转到授权页面
     */
    public function authorize() {
        redirect($this->_om->getAuthorizeURL());
    }

    /**
     * 登陆回调
     */
    public function callbackLogin($request_args) {
        $user = $this->_om->getUserInfo($request_args);
        $bind_user = $this->_checkBind($this->_type, $user['keyid']);
        if ($bind_user) {
            //已经绑定过则更新绑定信息 自动登陆
            $this->_updateBindInfo($user);
            $user_info = M('user')->field('userid,username,doname')->where(array('userid' => $bind_user['uid']))->find();
            //登陆
            $this->_oauth_visitor()->assign_info($user_info);
            return U('people/index',array('id'=>$user_info['doname']));
        } else {
            //处理用户名
            if (D('user')->where(array('username' => $user['keyname']))->count()) {
                $user['ik_user_name'] = $user['keyname'] . '_' . mt_rand(99, 9999);
            } else {
                $user['ik_user_name'] = $user['keyname'];
            }
            $user['keyname'] = $user['keyname'];
            //用户来源 type qq
            $user['type'] = $this->_type;
            $user['face'] = $user['keyavatar_big'];
            $user['bind_info'] = serialize($user['bind_info']); //数组要转换成可以存储的介质
           // $user['bind_info'] = $user['bind_info'];
           //var_dump($user);echo 22222222222222222222222222;die;
            //把第三方的数据存到COOKIE
            cookie('user_bind_info', $user);
            return U('user/binding'); //跳转到绑定注册页
        }
    }

    /**
     * 绑定回调
     */
    public function callbackBind($request_args) {
        if (!session('user_info')) {
            return U('user/login');
        }
        $ik_user = session('user_info');
        $user = $this->_om->getUserInfo($request_args);
        $bind_user = $this->_checkBind($this->_type, $user['keyid']);
        if ($bind_user['uid'] && $bind_user['uid'] != $ik_user['userid']) {
            die('此帐号已经绑定过本站');
        }
        $user['ik_uid'] = $ik_user['userid'];
        $this->bindUser($user);
        return U('user/bind');
    }

    /**
     * 更新绑定信息
     */
    private function _updateBindInfo($user) {
        $info = serialize($user['bind_info']);
        M('user_bind')->where(array('keyid' => $user['keyid']))->save(array('info' => $info));
    }

    /**
     * 绑定帐号
     */
    public function bindUser($user) {
        //$bind_info = serialize($user['bind_info']);
    	$bind_info = $user['bind_info'];
        $bind_user = array(
            'uid' => $user['ik_uid'],
            'type' => $this->_type,
            'keyid' => $user['keyid'],
            'info' => $bind_info
        );
        M('user_bind')->add($bind_user);
    }

    //用户完善信息之后绑定 需要手动增加qp_uid值
    public function bindByData($user) {
        $this->bindUser($user);
    }

    /**
     * 检测用户是否已经绑定过本站
     */
    private function _checkBind($type, $key_id) {
        return M('user_bind')->where(array('type' => $type, 'keyid' => $key_id))->find();
    }

    /**
     * 访问者
     */
    private function _oauth_visitor() {
        include_once (LIB_PATH . 'Iklib/user_visitor.class.php');
        return new user_visitor();
    }

    /**
     * 返回需要的参数
     */
    public function NeedRequest() {
        return $this->_om->NeedRequest();
    }

}