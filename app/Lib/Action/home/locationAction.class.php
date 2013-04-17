<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class locationAction extends frontendAction {

	public function index() {
		// 处理html编码
		$this->_config_seo (array('title'=>'爱客同城','subtitle'=>'北京'));
		$this->display();
	}
	public function area() {
		// 处理html编码
		
		$this->error('APP模块还在建设中,请等待下一版本吧！') ;
	}
	
}