<?php

class captchaAction extends frontendAction {

    public function _empty() {
		$captcha = new Captcha();
		$captcha->CreateImage();
    }
}