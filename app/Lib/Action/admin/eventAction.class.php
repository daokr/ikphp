<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class eventAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->cate_mod = D ( 'event_cate' );
	}
	public function cate(){
		$ik = $this->_get ( 'ik', 'trim','catelist');
		$menu = array(
				'catelist' => array('text'=>'全部分类', 'url'=>U('event/cate',array('ik'=>'catelist'))),
				'addcate' => array('text'=>'添加分类', 'url'=>U('event/cate',array('ik'=>'addcate'))),
		);
		
		$this->assign('menu', $menu);
		$this->assign('ik', $ik);
		switch ($ik) {
			case "catelist" :
				$this->catelist();
				break;
			case "addcate" :
				$this->addcate();
				break;							
		}
	}
	public function  catelist(){
		$arrCate = $this->cate_mod->getAllCate();
		$this->assign('arrCate',$arrCate);
		$this->display('cate_list');
	}
	public function  addcate(){
		$referid = $this->_get('referid','trim','0');
		$this->assign('referid',$referid);
		if(IS_POST){
			$catename = $this->_post('catename','trim');
			if(!empty($catename)){
				$arrcatename = explode("\n", $catename); //换行
				$data = array();
				
				foreach($arrcatename as $value) {
					list($name, $enname) = array_map('trim', explode('=', $value));
					$data['catename'] = trim($name);
					$data['enname'] = trim($enname);
					$this->cate_mod->add($data);
				}
			 $this->redirect('event/cate',array('ik'=>'catelist'));
			}
		}else{
			$this->title ( '添加分类' );
			$this->display('cate_add');
		}
	}
}