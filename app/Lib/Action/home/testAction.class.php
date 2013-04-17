<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class testAction extends frontendAction {
	
	public  function index(){
		
		$arr =   unserialize('a:10:{i:47;s:6:"翻领";i:48;s:12:"毛呢大衣";i:49;s:6:"冬装";i:50;s:6:"专柜";i:51;s:6:"正品";i:1;s:6:"外套";i:52;s:6:"新款";i:53;s:6:"一身";i:54;s:6:"浪漫";i:55;s:9:"韩版大";}');
		foreach ($arr as $key=>$item){
			echo $key.'='.$item;
		}
	}
	
}