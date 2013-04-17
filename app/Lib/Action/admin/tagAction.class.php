<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class tagAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'tag' );
	}
	public function manage(){
		$ik = $this->_get ( 'ik', 'trim','tags');
		$menu = array(
				'tags' => array('text'=>'标签管理', 'url'=>U('tag/manage',array('ik'=>'tags'))),
				'addtag' => array('text'=>'添加标签', 'url'=>U('tag/manage',array('ik'=>'addtag'))),
		);
		
		$this->assign('menu', $menu);
		$this->assign('ik', $ik);		
		switch ($ik) {
			case "tags" :
				$this->tags();
				break;
			case "addtag" :
				$this->addtag();			
				break;
			case "delete" :
				$this->delete();			
				break;
		}
	}
	public function addtag(){
		if(IS_POST){
			$tags = $this->_post('tags','trim');
			$this->mod->addTag('','','',$tags);
			$this->success('添加成功',U('tag/manage',array('ik'=>'tags')));
		}else{
			$this->title ( '标签管理' );
			$this->display('tag_add');
		}
	}
	public function tags() {
		$isaudit = $this->_get('isaudit','intval','0');
		//查询条件
		$map = array();
		//显示列表
		$pagesize = 20;
		$count = $this->mod->where($map)->order('uptime DESC')->count();
		$pager = $this->_pager($count, $pagesize);
		$query =  $this->mod->where($map)->order('uptime DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
	
		foreach($query as $key=>$item){
			$list[] = $this->mod->getOneTag($item['tagid']);
			$list[$key]['uptime'] = date('Y-m-d H:i:s',$item['uptime']);
		}
		$this->assign('pageUrl', $pager->fshow());
		$this->assign('list', $list);
		$this->title ( '标签管理' );
		$this->display('tags');
	}
	//删除数据
	public function delete(){
		$id = $this->_get('id');
		if(!empty($id)){
			$this->mod->delTagById($id);
			$this->redirect('tag/manage');
		}
	}	
	//ajax删除数据
	public function ajax_delete(){
		$itemid = $this->_post('itemid');
		if(!empty($itemid)){
			if($this->mod->delTagById($itemid)){
				$arrJson = array('r'=>0, 'html'=> '删除成功');
			}else{
				$arrJson = array('r'=>1, 'html'=> '删除失败！');
			}
			echo json_encode($arrJson);			
		}
	}
	//审核
	public function isaudit(){
		$id = $this->_get ( 'id', 'intval');
		$isaudit = $this->_get('isenable','intval','0');
		$this->mod->where(array('tagid'=>$id))->setField(array('isenable'=>$isaudit));
		$this->redirect ( 'tag/manage');
	}
	//ajax批量审核
	public function ajax_audit(){
		$itemid = $this->_post('itemid');
		$isaudit = $this->_get('isenable','intval','0');
		if(!empty($itemid)){
			//审核小组
			$where['tagid'] = array('exp',' IN ('.$itemid.') ');
			$this->mod->where($where)->setField(array('isenable'=>$isaudit));
			$arrJson = array('r'=>0, 'html'=> '操作成功');
			echo json_encode($arrJson);
		}
	}
	

}