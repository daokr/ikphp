<?php
class article_channelModel extends Model {
	
	// 获取全部频道
	public function getAllChannel($where =''){
		$result = $this->where($where)->select ();
		return $result;
	}
	// 获取指定nameid的频道
	public function getOneChannel($nameid){
		$where = array('nameid'=>$nameid);
		$result = $this->where($where)->find ();
		return $result;
	}	

}