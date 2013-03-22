<?php
class article_channelModel extends Model {
	
	// 根据频道nameid获取全部分类
	public function getAllChannel(){
		$result = $this->select ();
		return $result;
	}

}