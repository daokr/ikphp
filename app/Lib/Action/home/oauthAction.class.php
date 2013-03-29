<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class oauthAction extends frontendAction {
    /**
     * 第三方帐号登陆和绑定
     */
    public function index() {
    	$mod = $this->_get('mod', 'trim');
    	$type = $this->_get('type', 'trim', 'login');
    	if(!$mod){$this->error('请求的第三方登录还在开发中；请稍后访问！');}
        if ('unbind' == $type) {
            !$this->visitor->is_login && $this->redirect('user/login');
            M('user_bind')->where(array('uid'=>$this->visitor->info['id'], 'type'=>$mod))->delete();
            $this->redirect('user/bind');
        }
        $oauth = new oauth($mod); 
        cookie('callback_type', $type);
        return $oauth->authorize();
    }

    /**
     * 登陆回调页面
     */
    function callback() {
        $mod = $this->_get('mod', 'trim');
        !$mod && $this->_404();
        $callback_type = cookie('callback_type');
        $oauth = new oauth($mod);
        $rk = $oauth->NeedRequest();
        $request_args = array();
        foreach ($rk as $v) {
            $request_args[$v] = $this->_get($v);
        }
        switch ($callback_type) {
            case 'login':
                $url = $oauth->callbackLogin($request_args);
                break;
            case 'bind':
                $url = $oauth->callbackbind($request_args);
                break;
            default:
                $url = U('index/index');
                break;
        }
        cookie('callback_type', null);
        redirect($url);
    }
}