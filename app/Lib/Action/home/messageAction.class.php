<?php
/*
 * IKPHP 爱客网 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦 消息模块
 * @Email:160780470@qq.com
 */
class messageAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		// 访问者控制
		if (! $this->visitor->is_login) {
			$this->redirect ( 'user/login' );
		} else {
			$this->userid = $this->visitor->info ['userid'];
		}
		$this->mod = D ( 'message' );
		$this->user_mod = D ( 'user' );
	}
	//写邮件
	public function write() {
		$userid = $this->userid;
		$touserid = $this->_get ( 'touserid' );
		if ($userid == $touserid || ! $touserid)
			$this->error ( "Sorry！自己不能给自己发送消息的！& 对方为空!" );
		$strTouser = $this->user_mod->getOneUser ( $touserid );
		!$strTouser && $this->error ( '呃...你想要的东西不在这儿' );
		// 获取post
		if (IS_POST) {
			$msg_userid = $this->_post('userid');
			$msg_title = $this->_post('title','t');
			$msg_content = $this->_post('content');
			if($msg_title=='' || $msg_content=='') $this->error("标题和内容都不能为空！");
			if(mb_strlen($msg_title,'utf8')>64) $this->error('标题很长很长很长很长...^_^');
			if(mb_strlen($msg_content,'utf8')>500) $this->error('发这么多内容干啥^_^');
			
			$this->mod->sendMessage($msg_userid,$touserid,$msg_title,$msg_content);
			$this->redirect('message/ikmail',array('d'=>'outbox'));
			
		}
		$this->assign ( 'strTouser', $strTouser );
		$this->_config_seo ( array (
				'title' => '发送短消息',
				'subtitle' => '消息中心' 
		) );
		$this->display ();
	}
	//收件箱 发件箱
	public function ikmail(){
		$type = $this->_get ( 'd', 'trim' );
		$userid = $this->userid;
		$unreadnum = $this->mod->where(array('touserid'=>$userid,'isread'=>'0','isinbox'=>'0'))->count();//未读邮件数目
		$spamnum = $this->mod->where(array('touserid'=>$userid,'isspam'=>'1','isinbox'=>'0'))->count();//垃圾邮件数目
		$inmenu = array(
				'inbox' => array('url'=>U('message/ikmail',array('d'=>'inbox')),'text'=>'所有消息'),
				'unread' => array('url'=>U('message/ikmail',array('d'=>'unread')),'text'=>'未读消息('.$unreadnum.')'),
				'spam' => array('url'=>U('message/ikmail',array('d'=>'spam')),'text'=>'垃圾消息('.$spamnum.')'),
				);
		$this->assign ( 'ik', $type );
		$this->assign('unreadnum',$unreadnum);
		$this->assign ( 'inmenu', $inmenu );
		$this->assign ( 'userid', $userid );
		switch ($type) {
			// 我的发件箱
			case "outbox" :
				$where = array(
						'userid'=>$userid,
						'isoutbox'=>0,
				);
				$arrMessages = $this->mod->where($where)->order('addtime desc')->limit(10)->select();
				foreach($arrMessages as $key=>$item){
					$arrMessage[] = $item;
					$arrMessage[$key]['touser']	 = $this->user_mod->getOneUser($item['touserid']);
					$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
					$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
				}
				$this->assign ( 'arrMessage', $arrMessage );
				$this->_config_seo ( array (
						'title' => '我的发件箱',
						'subtitle' => '消息中心'
				) );
				$this->display ('outbox');				
				break;
			case "inbox" :
				$where['touserid'] = $userid;
				$where['isspam'] =  array('neq',1);
				$where['isinbox'] = 0;
				$arrMessages = $this->mod->where($where)->order('addtime desc')->limit(10)->select();
				foreach($arrMessages as $key=>$item){
					$arrMessage[] = $item;
					$arrMessage[$key]['user']	 = $this->user_mod->getOneUser($item['touserid']);
					$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
					$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
				}
				$this->assign ( 'arrMessage', $arrMessage );	
				$this->_config_seo ( array (
						'title' => '我的收件箱',
						'subtitle' => '消息中心'
				) );
				$this->display ('inbox');
				break;
			case "unread" :
				$where = array(
						'touserid'=>$userid,
						'isread'=>0,
						'isinbox'=>0,
				);
				$arrMessages = $this->mod->where($where)->order('addtime desc')->limit(10)->select();
				foreach($arrMessages as $key=>$item){
					$arrMessage[] = $item;
					$arrMessage[$key]['user']	 = $this->user_mod->getOneUser($item['touserid']);
					$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
					$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
				}
				$this->assign ( 'arrMessage', $arrMessage );
				$this->_config_seo ( array (
						'title' => '我的收件箱',
						'subtitle' => '消息中心'
				) );
				$this->display ('inbox');
				break;
			case "choose" :
				$followUsers = D('user_follow')->field('userid_follow')->where(array('userid'=>$userid))->order('addtime desc')->select();
				if(is_array($followUsers)){
					foreach($followUsers as $item){
						$arrFollowUser[] =  $this->user_mod->getOneUser($item['userid_follow']);
					}
				}
				$this->assign ( 'arrFollowUser', $arrFollowUser );
				$this->_config_seo ( array (
						'title' => '写信-选择收件人',
						'subtitle' => '消息中心'
				) );
				$this->display ('choose');				
				break;	
			case "spam" :
				$where = array(
						'touserid'=>$userid,
						'isspam'=>1,
						'isinbox'=>0,
				);
				$arrMessages = $this->mod->where($where)->order('addtime desc')->limit(10)->select();
				foreach($arrMessages as $key=>$item){
					$arrMessage[] = $item;
					$arrMessage[$key]['user']	 = $this->user_mod->getOneUser($item['touserid']);
					$arrMessage[$key]['content'] = getsubstrutf8(t($item['content']),0,200);
					$arrMessage[$key]['addtime'] =  date('Y-m-d H:i',$item['addtime']);
				}
				$this->assign ( 'arrMessage', $arrMessage );				
				$this->_config_seo ( array (
						'title' => '我的收件箱',
						'subtitle' => '消息中心'
				) );
				$this->display ('inbox');
				break;				
			// 默认
			default :
				$this->error ( '呃...你想要的东西不在这儿' );
		}
	}
	//操作
	public function doing(){
		$d = $this->_get ( 'd', 'trim' );
		$userid = $this->userid;
		$messageid = empty($_POST['messageid']) ? $_GET['messageid'] : $_POST['messageid'];
		switch($d){
		
			//删除
			case "del":
				$type = $this->_get('type');
				if($type=='inbox')
				{
					$status = $this->mod->where(array('touserid'=>$userid,'messageid'=>$messageid))->setField(array('isinbox'=>1));
				}
				if($type=='outbox')
				{
					$status = $this->mod->where(array('userid'=>$userid,'messageid'=>$messageid))->setField(array('isoutbox'=>1));
				}
				$this->redirect($_SERVER['HTTP_REFERER']);
				break;
		
			case "spam":
				$status = $this->mod->where(array('messageid'=>$messageid,'touserid'=>$userid))->setField(array('isspam'=>1));
				$this->redirect('message/ikmail',array('d'=>'spam'));
				break;
		
			case "all":
				$type = $this->_post('type');
				$mc_submit = $this->_post('mc_submit','trim');
				if($mc_submit=='删除' && $type=='inbox')
				{
					for($i=0; $i<count($messageid); $i++)
					{
						$this->mod->where(array('touserid'=>$userid,'messageid'=>$messageid[$i]))->setField(array('isinbox'=>1));
					}
					//删除
					$this->mod->where(array('isinbox'=>'1','isoutbox'=>'1'))->delete();
					$this->redirect($_SERVER['HTTP_REFERER']);
				}
				if($mc_submit =='删除' && $type=='outbox')
				{
					for($i=0; $i<count($messageid); $i++)
					{
						$this->mod->where(array('userid'=>$userid,'messageid'=>$messageid[$i]))->setField(array('isoutbox'=>1));
					}
					//删除
					$this->mod->where(array('isinbox'=>'1','isoutbox'=>'1'))->delete();
					$this->redirect($_SERVER['HTTP_REFERER']);
				}
				if($mc_submit =='垃圾消息')
				{
					for($i=0; $i<count($messageid); $i++)
					{
						$this->mod->where(array('messageid'=>$messageid[$i],'touserid'=>$userid))->setField(array('isspam'=>1));
					}
					$this->redirect('message/ikmail',array('d'=>'spam'));
				}
				if($mc_submit=='标记为已读')
				{
					for($i=0; $i<count($messageid); $i++)
					{
						$this->mod->where(array('messageid'=>$messageid[$i],'touserid'=>$userid))->setField(array('isread'=>1));
					}
					$this->redirect($_SERVER['HTTP_REFERER']);
				}
		
				break;
		}
	}
	//显示
	public function show(){
		$userid = $this->userid;
		$messageid = $this->_get('messageid','intval');
		
		$arrMessages = $this->mod->where(array('messageid'=>$messageid))->find();
		!$arrMessages && $this->error ( '呃...你想要的东西不在这儿' );
		$arrMessages['addtime'] = date('Y-m-d H:i',$arrMessages['addtime']);
		
		if($arrMessages['userid'] == $userid)
		{
			//发往对方
			if($arrMessages['isoutbox']==1){
				$this->redirect('message/ikmail',array('d'=>'inbox'));				
			}
			$touser = $this->user_mod->getOneUser($arrMessages['touserid']);//来自哪位用户
			$strUserinfo = '<span class="m">发往：'.$touser['username'].'（'.$touser['area']['areaname'].'）</span>';
			$type = 'outbox';
			$this->_config_seo ( array (
					'title' => '我发送的消息',
					'subtitle' => '消息中心'
			) );
		}
		if($arrMessages['touserid'] == $userid)
		{
			//接收的信息
			if($arrMessages['isinbox']==1){
				$this->redirect('message/ikmail',array('d'=>'inbox'));
			}
			$touser = $this->user_mod->getOneUser($arrMessages['userid']);//来自哪位用户
			$strUserinfo = '<span class="m">来自：'.$touser['username'].'（'.$touser['area']['areaname'].'）</span>';
			$type = 'inbox';
			//isread设为已读
			$this->mod->where(array('isread'=>0,'touserid'=>$userid,'messageid'=>$messageid))->setField('isread','1');
			$this->_config_seo ( array (
					'title' => '我接收的消息',
					'subtitle' => '消息中心'
			) );
		}
		if($arrMessages['userid'] == 0 && $arrMessages['touserid']==$userid)
		{
			//接收的信息 系统消息
			if($arrMessages['isinbox']==1){
				$this->redirect('message/ikmail',array('d'=>'inbox'));
			}
			$strUserinfo = '<span class="m">来自：<span class="sys_doumail_big">系统邮件</span> </span>';
			$touser = $this->user_mod->getOneUser($arrMessages['userid']);//来自哪位用户;
			//isread设为已读
			$this->mod->where(array('isread'=>0,'touserid'=>$userid,'messageid'=>$messageid))->setField('isread','1');
			$this->_config_seo ( array (
					'title' => '我接收的系统消息',
					'subtitle' => '消息中心'
			) );
		}
		
		$this->assign ( 'touser', $touser );
		$this->assign ( 'strUserinfo', $strUserinfo );
		$this->assign ( 'arrMessages', $arrMessages );
		$this->assign ( 'type', $type );
		
		$this->display ();
	}

}