<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class videosModel extends Model
{
	//根据type 获取 视频
	public function countViedeos($type, $typeid) {
		$where = array('type'=>$type, 'typeid'=>$typeid);
		$result = $this->where($where)->count('*');
		return $result;
	}
	
}