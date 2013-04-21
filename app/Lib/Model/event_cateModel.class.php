<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class event_cateModel extends Model {
	//获取一级分类
	public function getAllCate(){
		$result = $this->where(array('referid'=>'0'))->order('cateid asc')->select();
		return $result;
	}
	//获取单个分类
	public function  getOneCate($cateid){
		$result = $this->where(array('cateid'=>$cateid))->find();
		return $result;
	}
	//获取二级级分类
	public function getAllsubCate($cateid){
		$result = $this->where(array('referid'=>$cateid))->order('cateid asc')->select();
		return $result;		
	}
}