<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class eventAction extends frontendAction {
	
	public  function index(){
		$this->display();
	}
	//创建
	public  function create(){
		$this->_config_seo (array('title'=>'创建同城活动','subtitle'=>'北京'));
		$this->display();
	}
	
}