<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class captchaAction extends frontendAction {

    public function _empty() {
		$captcha = new Captcha();
		$captcha->CreateImage();
    }
}