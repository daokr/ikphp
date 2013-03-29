<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class article_cateModel extends Model {
	
	// 根据频道nameid获取全部分类
	public function getCateByNameid($nameid){
		$where = array('nameid'=>$nameid);
		$result = $this->where ( $where )->select ();
		return $result;
	}
	// 获取全部分类
	public function getAllCate($nameid=''){
		if(!empty($nameid)){
			$where = array('nameid'=>$nameid);
		}else{
			$where = '';
		}
		$result = $this->where($where)->order('orderid asc')->select ();
		return $result;		
	}
	// 根据cateid 获取分类
	public function getOneCate($cateid){
		$where = array('cateid'=>$cateid);
		$result = $this->where ( $where )->find ();
		return $result;		
	}

}