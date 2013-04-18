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
		$this->assign('ik', $ik);
		switch ($ik) {
			case "province" :
				$this->province();
				break;
			case "city" :
				$this->city();
				break;
			case "districts" :
				$this->districts();
				break;								
		}
	}
	public function province() {
		//查询条件
		$list = $this->mod->where(array('referid'=>'0'))->select();
		$this->assign('list', $list);
		$this->title ( '一级区域管理' );
		$this->display('province');
	}
	public function city() {
		$referid = $this->_get('id');
		//获取单个区域
		$str = $this->mod->getOneArea($referid);
		//查询条件
		$list = $this->mod->where(array('referid'=>$referid))->select();
		$this->assign('list', $list);
		$this->title ( $str['areaname'].' > 二级区域管理' );
		$this->display('city');
	}
	public function districts() {
		//查询条件
		$referid = $this->_get('id');
		//获取单个区域
		$str = $this->mod->getOneArea($referid);
		//查询条件
		$list = $this->mod->where(array('referid'=>$referid))->select();
		$this->assign('list', $list);
		$this->title ( $str['areaname'].' > 三级区域管理' );
		$this->display('districts');
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
			$id = $this->_post('id','intval');
			$areaname = $this->_post('areaname','trim');
			$areaname = explode("\n", $areaname); //换行
			$updatecount = $newcount = $ignorecount = 0;
			$data = array();
			
			foreach($areaname as $key=>$value) {
				list($name, $zm) = array_map('trim', explode('=', $value));
				$data['areaname'] = $name;
				$data['zm'] = $zm;
				$data['referid'] = $id;
				if(!empty($data)) {
					$this->mod->add($data);
				}
			}
			$this->redirect('area/manage',array('ik'=>'city','id'=>$id));
			
		}else{
			$this->title ( '添加['.$str['areaname'].']二级区域' );
			$this->display('area_add');
		}
	}
	public function adddistricts($str){
		if(IS_POST){
			$id = $this->_post('id','intval');
			$areaname = $this->_post('areaname','trim');
			$areaname = explode("\n", $areaname); //换行
			$updatecount = $newcount = $ignorecount = 0;
			$data = array();
				
			foreach($areaname as $key=>$value) {
				list($name, $zm) = array_map('trim', explode('=', $value));
				$data['areaname'] = $name;
				$data['zm'] = empty($zm) ? '' : $zm;
				$data['referid'] = $id;
				if(!empty($data)) {
					$this->mod->add($data);
				}
			}
			$this->redirect('area/manage',array('ik'=>'districts','id'=>$id));
				
		}else{
			$this->title ( '添加['.$str['areaname'].']三级区域' );
			$this->display('area_add');
		}
	}	

}