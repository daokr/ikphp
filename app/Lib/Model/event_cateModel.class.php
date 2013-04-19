<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class event_cateModel extends Model {
	public function getAllCate(){
		$result = $this->order('cateid asc')->select();
		return $result;
	}
}