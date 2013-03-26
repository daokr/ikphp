<?php
class homeAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'home_info' );
	}
	// 分类管理
	public function page() {
		$infokey = $this->_get('infokey','trim','about');
		$where = array('infokey'=>$infokey);
		$strInfo = $this->mod->where($where)->find();
		$arrMenu = array(
				'about' => array('text'=>'关于我们', 'url'=>U('home/page',array('infokey'=>'about'))),
				'contact' => array('text'=>'联系我们', 'url'=>U('home/page',array('infokey'=>'contact'))),
				'agreement' => array('text'=>'用户条款', 'url'=>U('home/page',array('infokey'=>'agreement'))),
				'privacy' => array('text'=>'隐私声明', 'url'=>U('home/page',array('infokey'=>'privacy'))),
		);
		if(IS_POST){
			$data = $this->_post('infocontent'); 
			
			if(!empty($strInfo) && !empty($data)){
				
				$this->mod->where($where)->setField('infocontent',$data);
				$this->success('更新成功！');
			}
		}else{
			$this->assign('strInfo',$strInfo);
			$this->assign('infokey',$infokey);
			$this->assign('arrMenu',$arrMenu);
			$this->title ( '单页管理' );
			$this->display('page');
		}
	}

}