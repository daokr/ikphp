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
	public function setting(){
		$cityid = $this->_get('id');
		$str = $this->mod->getOneArea($cityid);
		$parentid = $str['referid'];
		$ishot = $this->_get('ishot');
		$this->mod->where(array('areaid'=>$cityid))->setField('ishot',$ishot);
		$this->redirect('area/manage',array('ik'=>'city','id'=>$parentid));
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
			$data = array();
			foreach($areaname as $key=>$value) {
				$data['areaname'] = trim($value);
				$data['zm'] = $this->getfirstchar(trim($value)); //添加索引
				$data['pinyin'] = Pinyin(trim($value)); //全拼
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
			$data = array();
				
			foreach($areaname as $key=>$value) {
				$data['areaname'] = trim($value);
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
	//获取首字母
	function getfirstchar($s0){
		$fchar=ord($s0{0});
		if($fchar>=ord("A") and $fchar<=ord("z") )return strtoupper($s0{0});
		$s=mb_convert_encoding($s0,"gb2312", "UTF-8");
		$asc=ord($s{0})*256+ord($s{1})-65536;
		if($asc>=-20319 and $asc<=-20284)return "A";
		if($asc>=-20283 and $asc<=-19776)return "B";
		if($asc>=-19775 and $asc<=-19219)return "C";
		if($asc>=-19218 and $asc<=-18711)return "D";
		if($asc>=-18710 and $asc<=-18527)return "E";
		if($asc>=-18526 and $asc<=-18240)return "F";
		if($asc>=-18239 and $asc<=-17923)return "G";
		if($asc>=-17922 and $asc<=-17418)return "H";
		if($asc>=-17417 and $asc<=-16475)return "J";
		if($asc>=-16474 and $asc<=-16213)return "K";
		if($asc>=-16212 and $asc<=-15641)return "L";
		if($asc>=-15640 and $asc<=-15166)return "M";
		if($asc>=-15165 and $asc<=-14923)return "N";
		if($asc>=-14922 and $asc<=-14915)return "O";
		if($asc>=-14914 and $asc<=-14631)return "P";
		if($asc>=-14630 and $asc<=-14150)return "Q";
		if($asc>=-14149 and $asc<=-14091)return "R";
		if($asc>=-14090 and $asc<=-13319)return "S";
		if($asc>=-13318 and $asc<=-12839)return "T";
		if($asc>=-12838 and $asc<=-12557)return "W";
		if($asc>=-12556 and $asc<=-11848)return "X";
		if($asc>=-11847 and $asc<=-11056)return "Y";
		if($asc>=-11055 and $asc<=-10247)return "Z";
		return '';
	}
}