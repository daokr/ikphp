<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class imagesModel extends Model {
	// 根据用户 和 类型
	public function addImage($name, $path, $size, $title,$type, $typeid, $userid) {
		$photonum = $this->where(array('typeid'=>$typeid,'type'=>$type))->count();
		// 插入数据库
		$arrData = array (
				'seqid' => $photonum + 1,
				'userid' => $userid,
				'type' => $type,
				'typeid' => $typeid,
				'name' => $name,
				'title' => $title,
				'size' => $size,
				'align' => 'C',
				'path' => $path,
				'addtime' => time (),
		);
		if (false !== $this->create ( $arrData )){
			$photoid = $this->add();
			return $photoid;
		}
	}
	//根据用户photoid 图片
	public  function getImageByseqid($type, $typeid, $seqid){
		$where = array('type'=>$type, 'typeid'=> $typeid,'seqid'=>$seqid);
		$result = $this->where($where)->find();
		$ext =  explode ( '.', $result['name']);
		//图片大小
		$result['simg'] =  attach($result['path'].$ext[0].'_'.C('ik_simg.width').'_'.C('ik_simg.height').'.'.$ext[1]);
		$result['mimg'] =  attach($result['path'].$ext[0].'_'.C('ik_mimg.width').'_'.C('ik_mimg.height').'.'.$ext[1]);
		$result['bimg'] =  attach($result['path'].$ext[0].'_'.C('ik_bimg.width').'_'.C('ik_bimg.height').'.'.$ext[1]);
		$result['img']  =  attach($result['path'].$ext[0].'.'.$ext[1]);
		return $result;		
	}
	//根据用户photoid 图片
	public function getImageById($photoid){
		$where = array('id'=>$photoid);
		$result = $this->where($where)->find();
		$ext =  explode ( '.', $result['name']);
		//图片大小
		$result['simg'] =  attach($result['path'].$ext[0].'_'.C('ik_simg.width').'_'.C('ik_simg.height').'.'.$ext[1]);
		$result['mimg'] =  attach($result['path'].$ext[0].'_'.C('ik_mimg.width').'_'.C('ik_mimg.height').'.'.$ext[1]);
		$result['bimg'] =  attach($result['path'].$ext[0].'_'.C('ik_bimg.width').'_'.C('ik_bimg.height').'.'.$ext[1]);
		$result['img']  =  attach($result['path'].$ext[0].'.'.$ext[1]);
		return $result;
	}
	// 根据type typeid 获取图
	public function getImagesByTypeid($type, $typeid){
		$where = array('type'=>$type, 'typeid'=> $typeid);
		$arrImages = $this->where($where)->order('seqid asc')->select();
		foreach($arrImages as $item){
			$result[] = $this->getImageById($item['id']);
		}
		return $result;
	}
	// 更新图片信息
	public function updateImage($data,$where){
		$result = $this->where ( $where )->save ( $data );
		return true;	
	}
	// 根据photoid删除图片
	public function delImage($id){
		$result = $this->where(array('id'=>$id))->delete();
		if($result){
			return true;
		}else{
			return false;
		}
	}
	// 根据type typeid 删除所有图片
	public function delAllImage($type, $typeid){
		$result = $this->where(array('type'=>$type,'typeid'=>$typeid))->delete();
		if($result){
			return true;
		}else{
			return false;
		}
	}

}