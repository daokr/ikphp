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
			case "subcatelist" :
				$this->subcatelist();
				break;
			case "addcate" :
				$this->addcate();
				break;
			case "addsubcate" :
				$this->addsubcate();
				break;
			case "addtag" :
				$this->addtag();
				break;
			case "catetaglist" :
				$this->catetaglist();
				break;
		}
	}
	public function  catelist(){
		$arrCates = $this->cate_mod->getAllCate();
		foreach ($arrCates as $key=>$item){
			$arrCate[] = $item;
			$arrCate[$key]['tag'] = implode('，', unserialize($item['tag']));			
		}
		$this->assign('arrCate',$arrCate);
		$this->title ( '活动分类' );
		$this->display('cate_list');
	}
	public function  subcatelist(){
		$id = $this->_get('id');
		$strCate = $this->cate_mod->getOneCate($id);
		$arrCate = $this->cate_mod->getAllsubCate($id);
		$this->assign('arrCate',$arrCate);
		$this->assign('strCate',$strCate);
		$this->title ( $strCate['catename'].' - 活动分类' );
		$this->display('subcate_list');
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
	public function addsubcate(){
		$referid = $this->_get('id','trim');
		$strCate = $this->cate_mod->getOneCate($referid);
		$this->assign('strCate',$strCate);
		$this->assign('referid',$referid);
		if(IS_POST){
			$catename = $this->_post('catename','trim');
			if(!empty($catename)){
				$arrcatename = explode("\n", $catename); //换行
				$data = array();
				
				foreach($arrcatename as $value) {
					$data['catename'] = trim($value);
					$data['referid'] = $referid;
					$this->cate_mod->add($data);
				}
				$this->redirect('event/cate',array('ik'=>'subcatelist','id'=>$referid ));
			}
		}else{
			$this->title ( $strCate['catename'].' - 添加子分类' );
			$this->display('subcate_add');
		}		
	}
	//添加活动分类的标签
	public function addtag(){
		$cateid = $this->_get('id');
		$strCate = $this->cate_mod->getOneCate($cateid);	
		$this->assign('strCate',$strCate);
		if(IS_POST){
			$tagname = $this->_post('tagname','trim');
			if(!empty($tagname)){
				$arrtagname = explode("\n", $tagname); //换行
				$data = array();
			
				foreach($arrtagname as $key => $value) {
					$data[$key] = trim($value); 
				}
				$this->cate_mod->where(array('cateid'=>$cateid))->setField('tag',serialize($data));
				$this->redirect('event/cate',array('ik'=>'catelist'));
			}
		}else{
			$this->title ( $strCate['catename'].' - 添加标签' );
			$this->display('catetag_add');
		}
	}
}