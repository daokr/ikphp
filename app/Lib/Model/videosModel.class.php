<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class videosModel extends Model
{
	//根据type 获取视频数量
	public function countViedeos($type, $typeid) {
		$where = array('type'=>$type, 'typeid'=>$typeid);
		$result = $this->where($where)->count('*');
		return $result;
	}
	// 根据type typeid 获取
	public function getVideosByTypeid($type, $typeid){
		$where = array('type'=>$type, 'typeid'=> $typeid);
		$arr = $this->where($where)->order('seqid asc')->select();
		foreach($arr as $item){
			$result[] = $this->getVideoById($item['videoid']);
		}
		return $result;
	}
	//根据用户videoid 图片
	public function getVideoById($videoid){
		$where = array('videoid'=>$videoid);
		$result = $this->where($where)->find();
		return $result;
	}
	//根据用户photoid 图片
	public  function getVideoByseqid($type, $typeid, $seqid){
		$where = array('type'=>$type, 'typeid'=> $typeid,'seqid'=>$seqid);
		$result = $this->where($where)->find();
		return $result;
	}
	// 根据type typeid 删除所有
	public function delAllVideo($type, $typeid){
		$result = $this->where(array('type'=>$type,'typeid'=>$typeid))->delete();
		if($result){
			return true;
		}else{
			return false;
		}
	}
	// 更新信息
	public function updateVideo($data,$where){
		$result = $this->where ( $where )->save ( $data );
		return true;
	}
}