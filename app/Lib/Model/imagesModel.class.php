<?php
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
		$result['simg'] =  C('ik_attach_path').$result['path'].$ext[0].'_s.'.$ext[1];
		$result['mimg'] =  C('ik_attach_path').$result['path'].$ext[0].'_m.'.$ext[1];
		$result['bimg'] =  C('ik_attach_path').$result['path'].$ext[0].'_b.'.$ext[1];
		$result['img']  =   C('ik_attach_path').$result['path'].$ext[0].'.'.$ext[1];
		return $result;		
	}
	//根据用户photoid 图片
	public function getImageById($photoid){
		$where = array('id'=>$photoid);
		$result = $this->where($where)->find();
		$ext =  explode ( '.', $result['name']);
		//图片大小
		$result['simg'] =  C('ik_attach_path').$result['path'].$ext[0].'_s.'.$ext[1];
		$result['mimg'] =  C('ik_attach_path').$result['path'].$ext[0].'_m.'.$ext[1];
		$result['bimg'] =  C('ik_attach_path').$result['path'].$ext[0].'_b.'.$ext[1];
		$result['img']  =   C('ik_attach_path').$result['path'].$ext[0].'.'.$ext[1];
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