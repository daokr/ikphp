<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class groupAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'group' );
		$this->user_mod = D ( 'user' );
		$this->topics_mod = D ( 'group_topics' );
		$this->topics_comments = D ( 'group_topics_comments' );
	}
	//全部小组
    public function groups() {
    	$isaudit = $this->_get('isaudit','intval','0');
    	//查询开放
    	$map = array('isaudit'=>$isaudit);
    	//显示列表
    	$pagesize = 20;
    	$count = $this->mod->where($map)->order('addtime DESC')->count('groupid');
    	$pager = $this->_pager($count, $pagesize);
    	$arrGroups =  $this->mod->where($map)->order('addtime DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
    		
    	foreach($arrGroups as $key=>$item){
    		$arrData[] = $this->mod->getOneGroup($item['groupid']);
    	}
    	foreach($arrData as $key=>$item){
    		$arrGroup[] =  $item;
    		$arrGroup[$key]['groupname'] = getsubstrutf8(t($item[groupname]),0,14);
    		$arrGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,45);
    		$arrGroup[$key]['addtime'] = date('Y-m-d H:i:s',$item['addtime']);
    		$arrGroup[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
    	}
    	// 未审核数目
    	$count_isaudit = $this->mod->where(array('isaudit'=>'1'))->count();
    	
    	$this->assign ( 'count_isaudit', $count_isaudit );
    	$this->assign('pageUrl', $pager->fshow());
    	$this->assign('list', $arrGroup);
    	
    	$this->title ( '全部小组' );
        $this->display();
    }
    //审核
    public function isaudit(){
    	$ik = $this->_get ( 'ik', 'trim');
    	$id = $this->_get ( 'id', 'intval');
    	$isaudit = $this->_get('isaudit','intval','0');
    	switch ($ik) {
    		case "group" :
    			$this->mod->where(array('groupid'=>$id))->setField(array('isaudit'=>$isaudit));
    			$isaudit = $isaudit == 0? 1 : 0;
    			$this->redirect ( 'group/groups',array('isaudit'=>$isaudit));
    			break;
    		case "topic" :
    			$this->topics_mod->where(array('topicid'=>$id))->setField(array('isaudit'=>$isaudit));
    			$isaudit = $isaudit == 0? 1 : 0;
    			$this->redirect ( 'group/topics',array('isaudit'=>$isaudit));
    			break;
    	}
    	
    }
    //全部话题
    public function topics() {
    	$isaudit = $this->_get('isaudit','intval','0');
    	//查询开放
    	$map = array('isaudit'=>$isaudit);
    	//显示列表
    	$pagesize = 20;
    	$count = $this->topics_mod->where($map)->order('addtime DESC')->count();
    	$pager = $this->_pager($count, $pagesize);
    	$arrData =  $this->topics_mod->where($map)->order('addtime DESC')->limit($pager->firstRow.','.$pager->listRows)->select();

    	foreach($arrData as $key=>$item){
    		$list[] =  $item;
    		$list[$key]['title'] = getsubstrutf8(t($item[title]),0,14);
    		$list[$key]['addtime'] = date('Y-m-d H:i:s',$item['addtime']);
    		$list[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
    	}
    	// 未审核数目
    	$count_isaudit = $this->topics_mod->where(array('isaudit'=>'1'))->count();
    	
    	$this->assign ( 'count_isaudit', $count_isaudit );
    	$this->assign('pageUrl', $pager->fshow());
    	$this->assign('list', $list);
    	
    	$this->title ( '全部帖子' );
        $this->display();
    }
    //全部帖子评论
    public function topiccomments() {

    	$this->title ( '帖子评论管理' );
        $this->display();
    }

}