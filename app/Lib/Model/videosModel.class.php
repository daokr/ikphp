<?php
class videosModel extends Model
{
	//根据type 获取 视频
	public function countViedeos($type, $typeid) {
		$where = array('type'=>$type, 'typeid'=>$typeid);
		$result = $this->where($where)->count('*');
		return $result;
	}
	
}