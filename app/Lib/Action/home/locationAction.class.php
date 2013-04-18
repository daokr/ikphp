<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class locationAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->area_mod = D ( 'area' );
		$this->user_mod = D ( 'user' );
	}
	public function index() {
		// 处理html编码
		$this->_config_seo (array('title'=>'爱客同城','subtitle'=>'北京'));
		$this->display();
	}
	public function area() {
		// 处理html编码
		
		$this->error('APP模块还在建设中,请等待下一版本吧！') ;
	}
	public function getarea(){
		$id = $this->_post('areaid');
		$arrStrict = $this->area_mod->field('areaid,areaname')->where(array('referid'=>$id))->select();
		if($arrStrict){
			$arrJson = array(
					'id'=> $id,
					'r'=> true,
					'children'=>$arrStrict,
			);
		}else{
			$arrJson = array(
					'id'=> $id,
					'r'=> false,
			);
		}
		$this->ajaxReturn($arrJson,'JSON');
	}

	
}