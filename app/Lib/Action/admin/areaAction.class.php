<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class areaAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'area' );
	}
	public function manage(){
		$ik = $this->_get ( 'ik', 'trim','province');
		$menu = array(
				'province' => array('text'=>'全部省份', 'url'=>U('area/manage',array('ik'=>'province'))),
				'addprovince' => array('text'=>'添加省份', 'url'=>U('area/manage',array('ik'=>'addprovince'))),
		);
		
		$this->assign('menu', $menu);
		$this->assign('ik', $ik);
		switch ($ik) {
			case "province" :
				$this->province();
				break;
			case "city" :
				$this->city();
				break;				
		}
	}
	public function province() {
		//查询条件
		$list = $this->mod->where(array('referid'=>'0'))->select();
		$this->assign('list', $list);
		$this->title ( '省份管理' );
		$this->display('province');
	}
	public function city() {
		$referid = $this->_get('id');
		//获取单个区域
		$str = $this->mod->getOneArea($referid);
		//查询条件
		$list = $this->mod->where(array('referid'=>$referid))->select();
		$this->assign('list', $list);
		$this->title ( $str['areaname'].'的城市管理' );
		$this->display('city');
	}
	public function add() {
		//查询条件
		$ik = $this->_get ( 'ik', 'trim','province');
		$id = $this->_get('id');
		//获取单个区域
		$str = $this->mod->getOneArea($id);
		$this->assign('str', $str);
		$this->assign('ik', $ik);
		switch ($ik) {
			case "province" :
				$this->addprovince($str);
				break;
			case "city" :
				$this->addcity($str);
				break;
			case "districts" :
				$this->adddistricts($str);
				break;
		}
	}
	public function addcity($str){
		if(IS_POST){
			//$tags = $this->_post('tags','trim');
			//$this->mod->addTag('','','',$tags);
			//$this->success('添加成功',U('tag/manage',array('ik'=>'tags')));
		}else{
			$this->title ( '在添加['.$str['areaname'].']二级区域' );
			$this->display('area_add');
		}
	}	

}