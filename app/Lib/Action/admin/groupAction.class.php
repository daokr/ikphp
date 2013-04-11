<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class groupAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'group' );
		$this->group_setting = D ( 'group_setting' );
		$this->user_mod = D ( 'user' );
		$this->topics_mod = D ( 'group_topics' );
		$this->topics_comments = D ( 'group_topics_comments' );
	}
	public function setting(){
		if(IS_POST){
			$setting = $this->_post('setting', ',');
			foreach ($setting as $key => $val) {
				$val = is_array($val) ? serialize($val) : $val;
				$this->group_setting->where(array('name' => $key))->save(array('data' => $val));
			}
			F('group_setting', NULL);//后台有更新 清楚前台缓存
			$this->success(L('operation_success'));
		}else{
			$this->title ( '小组配置' );
			$this->display();
		}
	}
	public function manage(){
		$ik = $this->_get ( 'ik', 'trim','groups');
		$menu = array(
				'groups' => array('text'=>'全部小组', 'url'=>U('group/manage',array('ik'=>'groups'))),
				'topics' => array('text'=>'帖子管理', 'url'=>U('group/manage',array('ik'=>'topics'))),
				'comments' => array('text'=>'帖子评论管理', 'url'=>U('group/manage',array('ik'=>'comments'))),
		);
		
		$this->assign('menu', $menu);
		$this->assign('ik', $ik);		
		switch ($ik) {
			case "groups" :
				$this->groups();
				break;
			case "topics" :
				$this->topics();			
				break;
			case "comments" :
				$this->comments();			
				break;
		}
	}
	//删除数据
	public function delete(){
		$isaudit = $this->_get('isaudit','intval','0');
		$id = $this->_get('id');
		$ik = $this->_get ( 'ik', 'trim');
		if(!empty($id)){
				
			switch ($ik) {
				case "group" :
					//删除小组
					if(D('group')->delGroup($id)){
						$this->redirect('group/manage',array('ik'=>'groups','isaudit'=>$isaudit));
					}else{
						$this->error('删除失败');
					}
					break;
				case "topic" :
					//删除话题
					if(D('group_topics')->delTopic($id)){
						$this->redirect('group/manage',array('ik'=>'topics','isaudit'=>$isaudit));
					}else{
						$this->error('删除失败');
					}
					break;
				case "comment" :
					$status = D('group_topics')->delComment($id);
					if($status){
						$this->redirect('group/manage',array('ik'=>'comments'));
					}else{
						$this->error('删除失败');
					}
					break;
			}
	
		}
	}	
	//ajax删除数据
	public function ajax_delete(){
		$itemid = $this->_post('itemid');
		$ik = $this->_get ( 'ik', 'trim'); 
		if(!empty($itemid)){
			
			switch ($ik) {
				case "groups" :
					//删除小组
					if(D('group')->delGroup($itemid)){
						$arrJson = array('r'=>0, 'html'=> '删除成功');
					}else{
						$arrJson = array('r'=>1, 'html'=> '删除失败！');
					}
					echo json_encode($arrJson);
					break;
				case "topics" :
					//删除话题
					if(D('group_topics')->delTopic($itemid)){
						$arrJson = array('r'=>0, 'html'=> '删除成功');
					}else{
						$arrJson = array('r'=>1, 'html'=> '删除失败！');
					}
					echo json_encode($arrJson);					
					break;
				case "comments" :
					if(D('group_topics')->delComment($itemid)){
						$arrJson = array('r'=>0, 'html'=> '删除成功');
					}else{
						$arrJson = array('r'=>1, 'html'=> '删除失败！');
					}
					echo json_encode($arrJson);	
					break;
			}
						
		}
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
    	
    	$this->assign ( 'isaudit', $isaudit );
    	$this->assign ( 'count_isaudit', $count_isaudit );
    	$this->assign('pageUrl', $pager->fshow());
    	$this->assign('list', $arrGroup);
    	$this->title ( '批量管理' );
    	$this->display('groups');
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
    			$this->redirect ( 'group/manage',array('ik'=>'groups','isaudit'=>$isaudit));
    			break;
    		case "topic" :
    			$this->topics_mod->where(array('topicid'=>$id))->setField(array('isaudit'=>$isaudit));
    			$isaudit = $isaudit == 0? 1 : 0;
    			$this->redirect ( 'group/manage',array('ik'=>'topics','isaudit'=>$isaudit));
    			break;
    	}
    	
    }
    //ajax批量审核
    public function ajax_audit(){
    	$itemid = $this->_post('itemid');
    	$ik = $this->_get ( 'ik', 'trim');
    	$isaudit = $this->_get('isaudit','intval','0');
    	if(!empty($itemid)){
    			
    		switch ($ik) {
    			case "groups" :
    				//审核小组
    				$where['groupid'] = array('exp',' IN ('.$itemid.') ');
    				$this->mod->where($where)->setField(array('isaudit'=>$isaudit));
    				$arrJson = array('r'=>0, 'html'=> '操作成功');
    				echo json_encode($arrJson);
    				break;
    			case "topics" :
    				//审核话题
    				$where['topicid'] = array('exp',' IN ('.$itemid.') ');
    				$this->topics_mod->where($where)->setField(array('isaudit'=>$isaudit));
    				$arrJson = array('r'=>0, 'html'=> '操作成功');
    				echo json_encode($arrJson);
    				break;
    		}
    
    	}
    }
    //ajax批量推荐
    public function ajax_recommend(){
    	$itemid = $this->_post('itemid');
    	$ik = $this->_get ( 'ik', 'trim');
    	$isrecommend = $this->_get('isrecommend','intval','0');
    	if(!empty($itemid)){
    		 
    		switch ($ik) {
    			case "groups" :
    				//推荐小组
    				$where['groupid'] = array('exp',' IN ('.$itemid.') ');
    				$this->mod->where($where)->setField(array('isrecommend'=>$isrecommend));
    				$arrJson = array('r'=>0, 'html'=> '操作成功');
    				echo json_encode($arrJson);
    				break;
    		}
    
    	}
    }
    //全部话题
    public function topics() {
    	$isaudit = $this->_get('isaudit','intval','0');
    	//查询
    	$map['isaudit'] = $isaudit;
    	$map['groupid']  = array('gt',0);
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
		
    	$this->assign ( 'isaudit', $isaudit );
    	$this->assign ( 'count_isaudit', $count_isaudit );
    	$this->assign('pageUrl', $pager->fshow());
    	$this->assign('list', $list);
    	
    	$this->title ( '批量管理' );
    	$this->display('topics');
    }
    //全部帖子评论
    public function comments() {
    	//查询条件
    	$map = '';
    	//显示列表
    	$pagesize = 20;
    	$count = $this->topics_comments->where($map)->order('addtime DESC')->count();
    	$pager = $this->_pager($count, $pagesize);
    	$arrData =  $this->topics_comments->where($map)->order('addtime DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
    	
    	foreach($arrData as $key=>$item){
    		$list[] =  $item;
    		$list[$key]['content'] = getsubstrutf8(t($item['content']),0,80);
    		$list[$key]['addtime'] = date('Y-m-d H:i:s',$item['addtime']);
    		$list[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
    	}
    	
    	$this->assign('pageUrl', $pager->fshow());
    	$this->assign('list', $list);
    	
    	$this->title ( '帖子评论管理' );
        $this->display('comments');
    }

}