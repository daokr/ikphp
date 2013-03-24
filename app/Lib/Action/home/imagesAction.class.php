<?php
// 本类由系统自动生成，仅供测试用途
class imagesAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		// 访问者控制
		if (! $this->visitor->is_login && in_array ( ACTION_NAME, array (
				'add',
				'delete'	
		) )) {
			$this->redirect ( 'user/login' );
		} else {
			$this->userid = $this->visitor->info ['userid'];
		}
		$this->_mod = D('images');		
	}
	public function add() {
		$typeid  = $this->_post('typeid','intval','0');
		$file = $_FILES ['file'];
		$type = $this->_post('type','trim');
		$userid = $this->userid;
		// 上传
		if (! empty ( $file )) {
			$data_dir = date ( 'Y/md/H' );
			$result = savelocalfile($file,$type . '/' . $data_dir,
					array (
					'width'=>C('ik_simg.width').','.C('ik_mimg.width').','.C('ik_bimg.width'),
					'height'=>C('ik_simg.height').','.C('ik_mimg.height').','.C('ik_bimg.height')
					),
					array('jpg','jpeg','png','gif'));
			if ($result ['error']) {
				$arrJson = array('r'=>1, 'html'=> $result ['error']);
				return $arrJson;
			} else {
				$name = $result ['filename'];
				$path = $type . '/'.$data_dir . '/' ;
				$size = $result ['size'];
				$title = $result ['name'];
				$photoid = D('images')->addImage($name,$path,$size,$title,$type,$typeid,$userid);
				//浏览该$photoid下的照片
				$arrPhoto = D('images')->getImageById($photoid);
				$arrJson = array(
						'id'=> $photoid,
						'layout'=> $arrPhoto['align'],
						'title'=>'',
						'seq_id'=> $arrPhoto['seqid'],
						'small_photo_url'=> $arrPhoto['simg'],
						'ajaxurl' => U('images/delete'),
				);
				echo json_encode($arrJson);
			}
		}else{
			$arrJson = array('r'=>1, 'html'=> '请选择图片再上传！');
			return $arrJson;
		}
	}
	// 删除图片
	public function delete(){
		$id = $this->_post('id','intval');
		$seqid = $this->_post('seq_id','intval');
		if($id>0){
			$this->_mod->delImage($id);
			$arrJson = array('r'=>0, 'html'=> '删除成功');
			echo json_encode($arrJson);
		}
	}
		
}