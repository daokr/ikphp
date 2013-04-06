<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class userAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'user' );
	}
	//会员管理
	public function manage(){
		$ik = $this->_get ( 'ik', 'trim','users');

		$this->assign('ik', $ik);
		$this->title ( '会员管理' );
		switch ($ik) {
			case "users" :
				$this->users();
				break;
		}
	}
	//会员列表
	public function users(){
		//是否启用 0 启用 1 禁用
		$isenable = $this->_get('isenable','intval','0');
		//查询开放
		//$map = array('isenable'=>$isenable);
		$map = '';
		//显示列表
		$pagesize = 20;
		$count = $this->mod->where($map)->order('addtime DESC')->count();
		$pager = $this->_pager($count, $pagesize);
		$query =  $this->mod->field('userid')->where($map)->order('addtime DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
		
		foreach($query as $key=>$item){
			$list[] = $this->mod->getOneUser($item['userid']);
		}
		// 已经禁用的用户数目
		$count_isenable = $this->mod->where(array('isenable'=>'1'))->count();
		 
		$this->assign ( 'isenable', $isenable );
		$this->assign ( 'count_isenable', $count_isenable );
		$this->assign('pageUrl', $pager->fshow());
		$this->assign('list', $list);
		$this->display('users');
	}
	//审核
	public function isenable(){
		$ik = $this->_get ( 'ik', 'trim');
		$id = $this->_get ( 'id', 'intval');
		$isenable = $this->_get('isenable','intval','0');
		switch ($ik) {
			case "user" :
				$this->mod->where(array('userid'=>$id))->setField(array('isenable'=>$isenable));
				$isenable = $isenable == 0? 1 : 0;
				$this->redirect ( 'user/manage',array('ik'=>'users','isenable'=>$isenable));
				break;
		}
		 
	}
	//ajax批量审核
	public function ajax_isenable(){
		$itemid = $this->_post('itemid');
		$ik = $this->_get ( 'ik', 'trim');
		$isenable = $this->_get('isenable','intval','0');
		if(!empty($itemid)){
			 
			switch ($ik) {
				case "users" :
					//审核
					$where['userid'] = array('exp',' IN ('.$itemid.') ');
					$this->mod->where($where)->setField(array('isenable'=>$isenable));
					$arrJson = array('r'=>0, 'html'=> '操作成功');
					echo json_encode($arrJson);
					break;
			}
	
		}
	}
	
}