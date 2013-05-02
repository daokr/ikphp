<?php
/*
 * IKPHP 爱客开源社区 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class groupAction extends frontendAction {
	
	public function _initialize() {
		parent::_initialize ();
		// 访问者控制
		if (! $this->visitor->is_login && in_array ( ACTION_NAME, array (
				'add',
				'addcomment',
				'create',
				'deltopic',
				'isdigest',
				'isshow',
				'join',
				'mine',				
				'my_group_topics',
				'my_collect_topics',
				'my_replied_topics',				
				'my_topics',
				'publish',
				'recomment',
				'topic_edit',
				'topic_istop',
				'topic_recommend',
				'update',
				'updatetopic',

				
		) )) {
			$this->redirect ( 'user/login' );
		} else {
			$this->userid = $this->visitor->info ['userid'];
		}
		$this->_mod = D ( 'group' );
		$this->user_mod = D ( 'user' );
		$this->group_users_mod = D ( 'group_users' );
		$this->group_topics_mod = D ( 'group_topics' );
		$this->group_topics_collects = D ( 'group_topics_collects' );
		$this->group_topics_comments = D ( 'group_topics_comments' );
	}
	public function index() {
		if ($this->visitor->is_login) {
			$this->redirect ( 'group/my_group_topics' );
		}else{
			$this->redirect ( 'group/explore' );
		}
	}
	//我管理的小组
	public function mine(){
		$userid = $this->userid;
		// 用户信息
		$strUser = $this->user_mod->getOneUser ( $userid );
		$myGroup = $this->_mod->getUserJoinGroup( $userid );
		//我加入的小组
		if(is_array($myGroup)){
			$count_mygroup = 0;
			foreach($myGroup as $key=>$item){
				$arrMyGroup[] = $this->_mod->getOneGroup($item['groupid']);
				$count_mygroup ++;
			}
		}
		$myCreateGroup = $this->_mod->getUserGroup($userid);
		//我管理的小组
		if(is_array($myCreateGroup)){
			$count_Admingroup = 0;
			foreach($myCreateGroup as $key=>$item){
		
				$arrMyAdminGroup[] = $this->_mod->getOneGroup($item['groupid']);
				$count_Admingroup ++;
		
			}
		}		
		
		$this->assign ( 'strUser', $strUser );
		$this->assign ( 'arrMyGroup', $arrMyGroup );
		$this->assign ( 'count_mygroup', $count_mygroup );
		$this->assign ( 'arrMyAdminGroup', $arrMyAdminGroup );
		$this->assign ( 'count_Admingroup', $count_Admingroup );

		$this->_config_seo (array('title'=>'我管理/加入的小组','subtitle'=>'小组'));
		$this->display ();
	}
	//我收藏喜欢的帖子
	public function my_collect_topics(){
		$userid = $this->userid;
		// 用户信息
		$strUser = $this->user_mod->getOneUser ( $userid );
		// 我的小组
		$arrCollect = $this->group_topics_collects->getUserCollectTopic($userid,80);
		foreach($arrCollect as $item){
			$strTopic = $this->group_topics_mod->getOneTopic($item['topicid']);
			$arrTopics[] = $strTopic;
		}
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = $this->_mod->getOneGroup($item['groupid']);
		}
		$this->assign ( 'strUser', $strUser );
		$this->assign ( 'arrTopic', $arrTopic );
		$this->_config_seo (array('title'=>'我喜欢的话题','subtitle'=>'小组'));
		$this->display ();
	}
	// 我发起的话题
	public function my_topics(){
		$userid = $this->userid;
		// 用户信息
		$strUser = $this->user_mod->getOneUser ( $userid );
		//发布的帖子
		$arrMyTopics = $this->group_topics_mod->getUserTopic($userid,80);
		foreach($arrMyTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = $this->_mod->getOneGroup($item['groupid']);
		}		
		$this->assign ( 'strUser', $strUser );
		$this->assign ( 'arrTopic', $arrTopic );
		$this->_config_seo (array('title'=>'我发起的话题','subtitle'=>'小组'));
		$this->display ();
	}
	// 我的小组话题
	public function my_group_topics() {
		$userid = $this->userid;
		// 用户信息
		$strUser = $this->user_mod->getOneUser ( $userid );
		// 我的小组话题
		$myGroup = $this->_mod->getGroupUser ( $userid );
		
		//我加入的所有小组的话题
		if(is_array($myGroup)){
			foreach($myGroup as $item){
				$arrGroup[] = $item['groupid'];
			}
		}
		$strGroup = implode(',',$arrGroup);
		
		if($strGroup){
			$arrTopics = $this->group_topics_mod->getTopics($strGroup,80);
			foreach($arrTopics as $key=>$item){
				$arrTopic[] = $item;
				$arrTopic[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
				$arrTopic[$key]['group'] = $this->_mod->getOneGroup($item['groupid']);
			}
		}
		
		
		$this->assign ( 'strUser', $strUser );
		$this->assign ( 'arrTopic', $arrTopic );
		$this->_config_seo (array('title'=>'我的小组话题','subtitle'=>'小组'));
		$this->display ();
	
	}
	// 我回应的话题
	public function my_replied_topics(){
		$userid = $this->userid;
		// 用户信息
		$strUser = $this->user_mod->getOneUser ( $userid );
		$arrTopics = $this->group_topics_mod->getUserRepliedTopic($userid, 20);
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
			$arrTopic[$key]['group'] = $this->_mod->getOneGroup($item['groupid']);
		}
		$this->assign ( 'strUser', $strUser );
		$this->assign ( 'arrTopic', $arrTopic );
		$this->_config_seo (array('title'=>'我回应的话题','subtitle'=>'小组'));
		$this->display ();		
	}
	// 创建小组
	public function create() {
		if (IS_POST) {
			foreach ( $_POST as $key => $val ) {
				$_POST [$key] = Input::deleteHtmlTags ( $val );
			}
			if ($_POST ['grp_agreement'] != 1)
				$this->error ( '不同意社区指导原则是不允许创建小组的！' );
			$data ['userid'] = $this->visitor->info ['userid'];
			$data ['groupname'] = ikwords($this->_post ( 'groupname', 'trim' ));
			$data ['groupdesc'] = ikwords($this->_post ( 'groupdesc', 'trim' ));
			$data ['tag'] = $this->_post ( 'tag', 'trim' );
			$tags = str_replace ( ' ', ' ', $data ['tag'] );
			$arrtag = explode ( ' ', $tags );
			$data ['groupname'] = $this->_post ( 'groupname', 'trim' );
			$data ['isaudit'] = C('ik_group_isaudit');//是否要审核 0 不审核 1 审核
			$data ['addtime'] = time ();
			// 小组名唯一性判断
			if ($this->iscreate ( $data ['groupname'] ))
				$this->error ( '小组名称已经存在，请更换其他小组名称！' );
			if( mb_strlen($data ['groupname'],'utf8')>20)
			{
				$this->error ('小组名称太长啦，最多20个字...^_^！');
			
			}else if( mb_strlen($data ['groupdesc'], 'utf8') > 10000)
			{
				$this->error ('写这么多内容干啥，超出1万个字了都^_^');
			}else if(count($arrtag)>5)
			{
				$this->error ('最多 5 个标签，写的太多了...^_^！');
			}
			for($i=0; $i<count($arrtag); $i++)
			{
				if(mb_strlen($arrtag[$i], 'utf8') > 8)
				{
					$this->error ('小组标签太长啦，最多8个字...^_^！');
				}
			}

			if (false !== $this->_mod->create ( $data )) {
				$groupid = $this->_mod->add ();
				if ($groupid) {
					// 小组图标
					$groupicon = $_FILES ['picfile'];
					// 上传
					if (! empty ( $groupicon )) {
						//上传头像
						$result = savelocalfile($groupicon,'group/icon',
								array('width'=>'48','height'=>'48'),
								array('jpg','jpeg','png'),
								md5($groupid));
						if (!$result ['error']) {
							$data ['groupicon'] = $result['img_48_48'];
							//更新小组头像
							$this->_mod->where ( 'groupid=' . $groupid )->setField ( 'groupicon', $data ['groupicon'] );
						}
					}
					//添加tag
					D('tag')->addTag('group','groupid',$groupid,$tags);
					// 绑定成员
					$group_user_data ['userid'] = $this->visitor->info ['userid'];
					$group_user_data ['groupid'] = $groupid;
					$group_user_data ['addtime'] = time ();
					$this->group_users_mod->add ( $group_user_data );
					// 更新小组人数
					$this->_mod->where ( 'groupid=' . $groupid )->setField ( 'count_user', 1 );
					$this->redirect ( 'group/show', array (
							'id' => $groupid 
					) );
				}
			}
		}else{
			//判断权限
			if(C('ik_iscreate')==1) $this->error('您好，网站暂时关闭创建小组；如有疑问联系站长！');
			//获取该用户已经创建了多少个小组
			$maxgroup = $this->_mod->where(array('userid'=>$this->userid))->count();
			if($maxgroup>=C('ik_maxgroup')) $this->error('您好，您的积分不够，最多只能创建'.$maxgroup.'个小组！');
			$this->_config_seo ();
			$this->display ();
		}
	}
	public function iscreate($groupname) {
		if ($groupname) {
			return $this->_mod->email_exists ( $groupname );
		} else {
			$this->error ( '小组名不能为空！' );
		}
	}
	public function show() {
		$id = $this->_get ( 'id', 'intval' );
		$group = $this->_mod->getOneGroup ( $id );
		// 存在性检查
		! $group && $this->error ( '呃...你想要的东西不在这儿' );
		// 审核
		$user = $this->visitor->get ();
		if($group['isaudit']==1 && $group['userid']!=$user['userid'] && $_SESSION['admin']['userid']!=1) $this->error('该小组正在审核中，请稍后访问！');
		
		$strLeader = $this->user_mod->getOneUser ( $group ['userid'] );
		// 是否加入
		$isGroupUser = $this->_mod->isGroupUser ( $this->userid, $id );
		// 获取最新加入会员
		$arrGroupUser = $this->_mod->getNewGroupUser ( $id, 8 );
		// 获取最近小组话题 20 条
		$arrTopics = $this->group_topics_mod->newTopic($id, 20);
		if( is_array($arrTopics)){
			foreach($arrTopics as $key=>$item){
				$arrTopic[] = $item;
				$arrTopic[$key]['user'] = $this->user_mod->getOneUser($item['userid']);
			}
		}
		
		$this->assign ( 'arrTopic', $arrTopic );
		$this->assign ( 'isGroupUser', $isGroupUser );
		$this->assign ( 'strGroup', $group );
		$this->assign ( 'strLeader', $strLeader );
		$this->assign ( 'arrGroupUser', $arrGroupUser );
		$this->_config_seo ();
		$this->display ();
	}
	// 发布新帖
	public function add() {
		$userid = $this->userid;
		$groupid = $this->_get ( 'id' );
		// 是否加入
		$isGroupUser = $this->_mod->isGroupUser ( $this->userid, $groupid );
		if(!$isGroupUser){
			$this->error('只有小组成员才能发言，请先加入小组!');
		}
		// 获取小组信息
		$group = $this->_mod->getOneGroup ( $groupid );
		// 审核
		if($group['isaudit']==1) $this->error('该小组还在审核中，暂时还不能发帖！');
		// 预先执行添加一条记录
		$strLastTipic = $this->group_topics_mod->where ( array (
				'userid' => $userid,
				'groupid' => 0 
		) )->find ();
		if ($strLastTipic ['topicid'] > 0) {
			$topic_id = $strLastTipic ['topicid'];
		
		} else {
			$data = array (
					'userid' => $userid,
					'groupid' => 0,
					'title' => '0',
					'content' => '0' 
			);
			if (false !== $this->group_topics_mod->create ( $data )) {
				$topic_id = $this->group_topics_mod->add ();
			}
		
		}
		$this->assign ( 'topic_id', $topic_id );
		$this->assign ( 'action', U('group/publish') );
		$this->assign ( 'strGroup', $group );
		$this->assign ( 'isGroupUser', $isGroupUser );
		$this->_config_seo (array('title'=>$strGroup['groupname'].'发布帖子','subtitle'=>'小组'));
		$this->display ();
	}
	// 执行发布
	public function publish() {
		
		if (IS_POST) {
			$userid = $this->userid;
			$topic_id = $this->_post ( 'topic_id' );
			$groupid = $this->_post ( 'groupid' );
			
			$title = $this->_post ( 'title', 'trim' );
			$content =  $this->_post ( 'content');
			$iscomment = $this->_post ( 'iscomment'); // 是否允许评论
			
			if ($title == '') {
				$this->error ( '不要这么偷懒嘛，多少请写一点内容哦^_^' );
			} else if ($content == '') {
				$this->error ( '没有任何内容是不允许你通过滴^_^' );
			} elseif (mb_strlen ( $content, 'utf8' ) > 20000) {
				$this->error ( '发这么多内容干啥^_^' );
			}

			$uptime = time ();
			// 查看是否有视频
			$seqnum = D ( 'videos' )->countViedeos ( 'topic', $topic_id );
			$seqnum > 0 ? $isvideo = 1 : $isvideo = 0;
			$arrData = array (
					'groupid' => $groupid,
					'title' => ikwords(htmlspecialchars($title)),
					'content' => ikwords($content),
					'isaudit' => C('ik_topic_isaudit'), //审核
					'isvideo' => $isvideo,
					'iscomment' => $iscomment,
					'addtime' => time (),
					'uptime' => $uptime 
			);
			// 执行更新帖子
			$this->group_topics_mod->where ( array (
					'topicid' => $topic_id 
			) )->save ( $arrData );
			// 执行更新图片信息
			$arrSeqid = $this->_post ( 'seqid');
			$arrTitle = $this->_post ( 'photodesc');
			if(is_array($arrSeqid)){
				foreach($arrSeqid as $key=>$item){
					$seqid = $arrSeqid[$key];
					$imgtitle = empty($arrTitle[$key]) ? '' : $arrTitle[$key];
					$layout = $this->_post ( 'layout_'.$seqid);
					$dataimg = array('title'=>$imgtitle, 'align'=> $layout);
					$where = array('type'=>'topic','typeid'=>$topic_id,'seqid'=>$seqid);
					D('images')->updateImage($dataimg,$where);
				}
			}
			// 统计小组下帖子数并更新
			$count_topic = $this->group_topics_mod->countTopic ( $groupid );
			// 统计今天发布帖子数
			$count_topic_today = $this->group_topics_mod->countTodayTipic ( $groupid );
			// 更新帖子数
			$this->_mod->updateTodayTopic ( $groupid, $count_topic, $count_topic_today );
			// 积分记录
			$this->redirect ( 'group/topic', array (
					'id' => $topic_id 
			) );
		
		} else {
			$this->redirect ( 'group/index' );
		}
	
	}
	public function topic() { 
		$type = $this->_get ( 'd', 'trim' );
		if (! empty ( $type )) {
			switch ($type) {
				// 加入该小组
				case "topic_collect" :
					$topicid = $this->_post ( 'tid' );
					$groupid = $this->_post ( 'tkind' );
					if (empty ( $topicid )) {
						$this->error ( "非法操作！" );
					}
					$arrJson = $this->group_topics_collects->collectTopic ( $this->userid, $topicid );
					header ( "Content-Type: application/json", true );
					echo json_encode ( $arrJson );
					break;
				// 发表评论
				case "addcomment" :
					$this->addcomment();
					break;
				// 回复评论
				case "recomment" :
					$this->recomment();
					break;
				// 推荐
				case "topic_recommend" :
					$this->topic_recommend();
					break;	
				// 删除评论
				case "delcomment" :
					$this->delcomment();
					break;
				// 删除评论
				case "deltopic" :
					$this->deltopic();
					break;					
				// 置顶帖子
				case "topic_istop" :
					$this->topic_istop();
					break;
				// 精华帖子
				case "isdigest" :
					$this->isdigest();
					break;
				// 隐藏帖子
				case "isshow" :
					$this->isshow();
					break;
				// 移动帖子
				case "topic_move" :
					$this->topic_move();
					break;
				// 编辑帖子
				case "topic_edit" :
					$this->topic_edit();
					break;					
			}
		
		} else {
			$user = $this->visitor->get ();
			$topic_id = $this->_get ( 'id' );
			$strTopic = $this->group_topics_mod->getOneTopic ( $topic_id );
			! $strTopic && $this->error ( '呃...你想要的东西不在这儿' );
			//审核
			if($strTopic['isaudit']==1 && $strTopic ['userid']!=$user['userid'] && $_SESSION['admin']['userid']!=1) $this->error('该帖子正在审核中，请稍后访问！');
			$strTopic ['user'] = $this->user_mod->getOneUser ( $strTopic ['userid'] );
			$strTopic ['user'] ['signed'] = hview ( $strTopic ['user'] ['signed'] );
			
			$strTopic['tags'] = D('tag')->getObjTagByObjid('topic','topicid',$topic_id);
			// 小组信息
			$strGroup = $this->_mod->getOneGroup ( $strTopic ['groupid'] );
			// 是否已经加入
			$isGroupUser = $this->_mod->isGroupUser ( $this->userid, $strTopic ['groupid'] );
			// 最新话题
			$newTopic = $this->group_topics_mod->newTopic ( $strTopic ['groupid'], 6 );
			//帖子浏览量加 +1
			if($strTopic ['userid']!=$user['userid']){
				$this->group_topics_mod->where(array('topicid'=>$topic_id))->setInc('count_view');
			}
			// 喜欢收藏的人数
			$likenum = $this->group_topics_collects->countLike ( $topic_id );
			$is_Like = $this->group_topics_collects->isLike ( $user ['userid'], $topic_id );
			$strTopic ['islike'] = $is_Like;
			$strTopic ['likenum'] = $likenum;
			
			// 操作
			$action ['istop'] = $strTopic ['istop'] == 0 ? '置顶' : '取消置顶';
			$action ['isdigest'] = $strTopic ['isdigest'] == 0 ? '精华' : '取消精华';
			$action ['isshow'] = $strTopic ['isshow'] == 0 ? '隐藏' : '显示';
			$action ['move'] = '移动';
			
			// 喜欢该帖子的用户
			$arrCollectUser = $this->group_topics_collects->likeTopicUser ( $topic_id );
			
			//上一篇帖子
			$upTopic = $this->group_topics_mod->where(array('topicid'=>array('lt',$topic_id),'groupid'=>$strTopic ['groupid']))->find();
			
			//下一篇帖子
			$downTopic = $this->group_topics_mod->where(array('topicid'=>array('gt',$topic_id),'groupid'=>$strTopic ['groupid']))->find();
			
			//获取评论
			$page = $this->_get('p','intval',1);
			$sc = $this->_get('sc','trim','asc');

			//查询条件 是否显示
			$map = array('topicid'=>$strTopic ['topicid']);
			//显示列表
			$pagesize = 3;
			$count = $this->group_topics_comments->where($map)->order('addtime '.$sc)->count('topicid');
			$pager = $this->_pager($count, $pagesize);
			$arrComment =  $this->group_topics_comments->where($map)->order('addtime '.$sc)->limit($pager->firstRow.','.$pager->listRows)->select();
			foreach($arrComment as $key=>$item){
				$arrTopicComment[] = $item;
				$arrTopicComment[$key]['user'] = $this->user_mod->getOneUser($item['userid']); 
				$arrTopicComment[$key]['content'] = h($item['content']);
				$recomment = $this->group_topics_mod->recomment($item['referid']);
				$arrTopicComment[$key]['recomment'] = $recomment;
			}	
			
			$this->assign('pageUrl', $pager->fshow());
			$this->assign('arrTopicComment', $arrTopicComment);
						
			$this->assign ( 'user', $user );
			$this->assign ( 'page', $page );
			$this->assign ( 'sc', $sc );
			$this->assign ( 'upTopic', $upTopic );
			$this->assign ( 'downTopic', $downTopic );
			$this->assign ( 'strTopic', $strTopic );
			$this->assign ( 'newTopic', $newTopic );
			$this->assign ( 'strGroup', $strGroup );
			$this->assign ( 'action', $action );
			$this->assign ( 'isGroupUser', $isGroupUser );
			$this->assign ( 'arrCollectUser', $arrCollectUser );
			$this->_config_seo ();
			$this->display ();
		}
	
	}
	// 加入小组
	public function join() {
		$groupid = $this->_get ( 'id' );
		// 先统计用户有多少个小组了，20个封顶
		$userGroupNum = $this->group_users_mod->where ( array (
				'userid' => $this->userid 
		) )->count ( '*' );
		
		if ($userGroupNum >= C('ik_jionmax'))
			$this->error ( '你加入的小组总数已经到达'.$userGroupNum.'个，不能再加入小组！' );
		
		$groupUserNum = $this->group_users_mod->where ( array (
				'userid' => $this->userid,
				'groupid' => $groupid 
		) )->count ( '*' );
		
		if ($groupUserNum > 0)
			$this->error ( '你已经加入小组！' );
			// 执行加入
		$data = array (
				'userid' => $this->userid,
				'groupid' => $groupid,
				'addtime' => time () 
		);
		if (false !== $this->group_users_mod->create ( $data )) {
			$group_users_id = $this->group_users_mod->add ();
			if ($group_users_id) {
				// 更新会员数
				$this->_mod->where ( array (
						'groupid' => $groupid 
				) )->setInc ( 'count_user', 1 );
				$this->redirect ( 'group/show', array (
						'id' => $groupid 
				) );
			}
		}
	
	}
	// 退出小组
	public function quit() {
		$groupid = $this->_get('id');
		$userid = $this->userid;
		//判断是否是组长，是组长不能退出小组
		$strGroup = $this->_mod->getOneGroup($groupid);
		if($strGroup['userid'] == $userid){
			$this->error('组长任务艰巨，请坚持到底！');
		}
		// 删除小组会员
		$this->group_users_mod->where(array('userid'=>$userid,'groupid'=>$groupid))->delete();
		//计算小组会员数
		$count_user = $this->group_users_mod->where(array('groupid'=>$groupid))->count('*');
		//更新小组成员统计
		$this->_mod->where(array('groupid'=>$groupid))->setField(array('count_user'=>$count_user));
		
		$this->redirect ( 'group/show', array (
				'id' => $groupid
		) );
	
	}
	// 发现小组
	public function explore(){
		$tag = $this->_get('tag', 'trim,urldecode','');
		if(!empty($tag)){
			$strTag = D('tag')->getOneTagByName($tag);
			//查询
			$map = array('tagid'=>$strTag['tagid']); 
			$arrGroupid = D('tag_group_index')->field('groupid')->where($map)->order('groupid DESC')->select();
			foreach ($arrGroupid as $item){
				$groupid[] = $item['groupid']; 
			}
			$groupid = implode(',',$groupid);
			$where['groupid'] = array('exp',' IN ('.$groupid.') ');
			//显示列表
			$pagesize = 20;
			$count = $this->_mod->where($where)->order('isrecommend DESC')->count('groupid');
			$pager = $this->_pager($count, $pagesize);
			$arrGroups =  $this->_mod->where($where)->order('isrecommend DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
			$this->_config_seo (array('title'=>$tag.'相关的小组','subtitle'=>'小组'));
		}else{
			//查询
			$map = array('isopen'=>0); //开放公开
			$map = array('isaudit'=>0);//通过审核
			//显示列表
			$pagesize = 20;
			$count = $this->_mod->where($map)->order('isrecommend DESC')->count('groupid');
			$pager = $this->_pager($count, $pagesize);
			$arrGroups =  $this->_mod->where($map)->order('isrecommend DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
			$this->_config_seo (array('title'=>'发现小组','subtitle'=>'小组'));
		}
		
		foreach($arrGroups as $key=>$item){
			$arrData[] = $this->_mod->getOneGroup($item['groupid']);
		}
		foreach($arrData as $key=>$item){
			$exploreGroup[] =  $item;
			$exploreGroup[$key]['groupname'] = getsubstrutf8(t($item[groupname]),0,14);
			$exploreGroup[$key]['groupdesc'] = getsubstrutf8(t($item['groupdesc']),0,45);
		}
			
		$this->assign('pageUrl', $pager->fshow());
		$this->assign('list', $exploreGroup);
		
		$this->display ();

	}
	// 发现话题
	public function explore_topic(){
		//查询是否显示
		$map['ishow']  = '0';
		$map['isaudit']  = '0';
		$map['groupid'] =  array('gt',0);
		//显示列表
		$pagesize = 20;
		$count = $this->group_topics_mod->where($map)->order('addtime DESC')->count('topicid');
		$pager = $this->_pager($count, $pagesize);
		$arrTopics =  $this->group_topics_mod->where($map)->order('addtime DESC')->limit($pager->firstRow.','.$pager->listRows)->select();
			
		foreach($arrTopics as $key=>$item){
			$list[] = $item;
			$list[$key]['group'] = $this->_mod->getOneGroup($item['groupid']);
		}
			
		$this->assign('pageUrl', $pager->fshow());
		$this->assign('list', $list);
		$this->_config_seo (array('title'=>'发现话题','subtitle'=>'小组'));
		$this->display ();		
	}
	// 添加评论
	public function addcomment(){
		$topicid	= $this->_post('topicid','intval');
		$content	= $this->_post('content','trim');
		$page	= $this->_post('p','intval');
		//添加评论标签
		//doAction('group_comment_add','',$content,'');
		if($content==''){
		
			$this->error('没有任何内容是不允许你通过滴^_^');
				
		}else if(mb_strlen($content,'utf8')>10000){
				
			$this->error('发这么多内容干啥,最多只能写1000千个字^_^,回去重写哇！');
				
		}else{ 
			//执行添加
			$data = array(
					'topicid'	=> $topicid,
					'userid'	=> $this->userid,
					'content'	=> ikwords($content),
					'addtime'	=> time(),
			);
			if (false !== $this->group_topics_comments->create ( $data )) {
				$commentid = $this->group_topics_comments->add ();
			}
			if($commentid){
				//统计评论数
				$count_comment = $this->group_topics_comments->where(array('topicid'=>$topicid))->count('*');
				//更新帖子最后回应时间和评论数
				$uptime = time();
				$data = array(
						'uptime'	=> $uptime, //暂时这样
						'count_comment'	=> $count_comment,
				);
				$this->group_topics_mod->where(array('topicid'=>$topicid))->save($data);
				//积分记录
				//发送系统消息(通知楼主有人回复他的帖子啦)
				//feed开始
				$this->redirect ( 'group/topic', array (
						'id' => $topicid,
						'p'  => $page,
				) );				
			}
			
		}
		
	}
	// 回复评论
	public function recomment(){
		$topicid = $this->_post('topicid');
		$referid = $this->_post('referid');
		$content = $this->_post('content');		
		//安全性检查
		if( mb_strlen($content, 'utf8') > 10000)
		{
			echo 1;
			exit ();
		}
		//执行添加
		$data = array(
				'topicid'	=> $topicid,
				'userid'	=> $this->userid,
				'referid'	=> $referid,
				'content'	=> ikwords(htmlspecialchars_decode($content)), // ajax 提交过来数据的转一下
				'addtime'	=> time(),
		);
		if (false !== $this->group_topics_comments->create ( $data )) {
			$commentid = $this->group_topics_comments->add ();
		}
		if($commentid){
			//统计评论数
			$count_comment = $this->group_topics_comments->where(array('topicid'=>$topicid))->count('*');
			//更新帖子最后回应时间和评论数
			$uptime = time();
			$data = array(
					'uptime'	=> $uptime, //暂时这样
					'count_comment'	=> $count_comment,
			);
			$this->group_topics_mod->where(array('topicid'=>$topicid))->save($data);
			//发消息
			echo 0;
		}
		
		
	}
	//推荐帖子
	public function topic_recommend(){
		$topicid = $this->_post('tid');
		$groupid = $this->_post('tkind');
		$content = $this->_post('content','trim'); //推荐的话
		
		if(empty($topicid))
		{
			$this->error("非法操作！"); 
		}
		
		$recommendNum = D('group_topics_recommend')->where(array('topicid'=>$topicid))->count();
		
		$is_rec = D('group_topics_recommend')->where(array('userid'=>$this->userid, 'topicid'=>$topicid))->count();
		
		if($is_rec > 0){
			//已经推荐过了
			$arrJson = array('r'=>1, 'html'=>'你已经推荐过该帖子了！');
		}else{
			//执行
			$arrData = array('userid'=>$this->userid, 'topicid'=>$topicid, 'content'=>$content,'addtime'=>time());
			if (false !== D('group_topics_recommend')->create($arrData)) {
				D('group_topics_recommend')->add ();
				//帖子推荐数加1
				$this->group_topics_mod->where(array('topicid'=>$topicid))->setInc('count_recommend');
				$arrJson = array('r'=>0, 'num'=>$recommendNum+1);
			}	
		}
		
		header("Content-Type: application/json", true);
		echo json_encode($arrJson);
	}
	// 删除帖子的某条评论
	public function delcomment(){
		$commentid = $this->_get('commentid','intval');
		$userid = $this->userid;
		$strComment = D('group_topics_comments')->where(array('commentid'=>$commentid))->find();
		$strTopic = $this->group_topics_mod->getOneTopic($strComment['topicid']);
		$strGroup = $this->_mod->getOneGroup($strTopic['groupid']);
		
		// 发帖人 小组组长 管理员 可以删除 其他权限不允许删除
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid ){
			$this->group_topics_mod->delComment($commentid);
			$this->redirect ( 'group/topic', array (
					'id' => $strComment['topicid'],
			) );			
		}

	}
	// 删除帖子
	public function deltopic(){
		$topicid = $this->_get('topicid','intval');
		$user = $this->visitor->get ();
		
		$strTopic = $this->group_topics_mod->getOneTopic($topicid);
		
		$strGroup = $this->_mod->getOneGroup($strTopic['groupid']);
		
		// 发帖人 小组组长 管理员 可以删除 其他权限不允许删除
		if($strTopic['userid']== $user['userid'] || $strGroup['userid']== $user['userid'] || $user['isadmin'] == 1){
			$this->group_topics_mod->delTopic($topicid);
			$this->redirect ( 'group/show', array (
					'id' => $strGroup['groupid'],
			) );
		}else{
			$this->error('没有帖子可以删除，别瞎搞！');
		}
	
	}	
	// 置顶帖子
	public function topic_istop(){
		$topicid = $this->_get('topicid','intval');
		$userid = $this->userid;
		
		$strTopic = $this->group_topics_mod->getOneTopic($topicid);

		$istop = $strTopic['istop'];
		
		$istop == 0 ? $istop = 1 : $istop = 0;
		
		$strGroup = $this->_mod->getOneGroup($strTopic['groupid']);
		//只有组长可以置顶帖子
		if($userid == $strGroup['userid']){
			$this->group_topics_mod->where(array('topicid'=>$topicid))->setField('istop',$istop);
			$this->redirect ( 'group/topic', array (
					'id' => $topicid,
			) );
		}else{
			$this->error("只有小组组长才能置顶帖子！");
		}
	}
	// 精华帖子
	public function isdigest(){
		$topicid = $this->_get('topicid','intval');
		$userid = $this->userid;
	
		$strTopic = $this->group_topics_mod->getOneTopic($topicid);
	
		$isdigest = $strTopic['isdigest'];
	
		$isdigest == 0 ? $isdigest = 1 : $isdigest = 0;
	
		$strGroup = $this->_mod->getOneGroup($strTopic['groupid']);
		//只有组长可以精华帖子
		if($userid == $strGroup['userid']){
			$this->group_topics_mod->where(array('topicid'=>$topicid))->setField('isdigest',$isdigest);
			$this->redirect ( 'group/topic', array (
					'id' => $topicid,
			) );
		}else{
			$this->error("只有小组组长才可以设置为精华帖！");
		}
	}
	// 隐藏帖子
	public function isshow(){
		$topicid = $this->_get('topicid','intval');
		$userid = $this->userid;
	
		$strTopic = $this->group_topics_mod->getOneTopic($topicid);
	
		$isshow = $strTopic['isshow'];
	
		$isshow == 0 ? $isshow = 1 : $isshow = 0;
	
		$strGroup = $this->_mod->getOneGroup($strTopic['groupid']);
		//只有组长可以精华帖子
		if($userid == $strGroup['userid']){
			$this->group_topics_mod->where(array('topicid'=>$topicid))->setField('isshow',$isshow);
			$this->redirect ( 'group/topic', array (
					'id' => $topicid,
			) );
		}else{
			$this->error("只有小组组长才可以设置为隐藏帖！");
		}
	}
	// 编辑帖子
	public function topic_edit(){
		$topicid = $this->_get('topicid','intval');
		$userid = $this->userid;
		
		$strTopic = $this->group_topics_mod->where(array('topicid' => $topicid))->find();
		//$strTopic['content'] = 
		$strGroup = $this->_mod->getOneGroup($strTopic['groupid']);
		
		$groupid = $strGroup['groupid'];
		if($strTopic['userid']==$userid || $strGroup['userid']==$userid ){
			// 是否加入
			$isGroupUser = $this->_mod->isGroupUser ( $userid, $groupid );
			//浏览该topic_id下的照片
			$type = 'topic';
			$arrPhotos = D('images')->getImagesByTypeid($type, $topicid);
			//浏览改topic_id下的视频
			$arrVideos = D('videos')->getVideosByTypeid($type, $topicid);
			
			$this->assign ( 'action', U('group/updatetopic') );
			$this->assign ( 'arrPhotos', $arrPhotos );
			$this->assign ( 'arrVideos', $arrVideos );
			$this->assign ( 'isGroupUser', $isGroupUser );
			$this->assign ( 'strTopic', $strTopic );
			$this->assign ( 'strGroup', $strGroup );
			$this->assign ( 'topic_id', $topicid );
			$this->_config_seo (array('title'=>'编辑“'.$strTopic['title'].'”','subtitle'=>'小组'));
			$this->display ('add');
		}else{
			$this->error("您没有权限编辑帖子！");
		}

	}
	// 执行更新帖子
	public function updatetopic(){
		if(IS_POST){
			$userid = $this->userid;
			$topic_id = $this->_post ( 'topic_id' );
			$groupid = $this->_post ( 'groupid' );
				
			$title = $this->_post ( 'title', 'trim' );
			$content =  $this->_post ( 'content');
			$iscomment = $this->_post ( 'iscomment'); // 是否允许评论

			$strTopic = $this->group_topics_mod->getOneTopic($topic_id);
			$strGroup = $this->_mod->getOneGroup($groupid);
			// 只有小组管理员 或 帖子所有者 可以编辑
			if($strTopic['userid']==$userid || $strGroup['userid']==$userid ){
				
				$uptime = time ();
				$arrData = array (
						'groupid' => $groupid,
						'title' => ikwords(htmlspecialchars($title)),
						'content' => ikwords($content),
						'iscomment' => $iscomment,
						'uptime' => $uptime
				);
				// 执行更新帖子
				$this->group_topics_mod->where ( array (
						'topicid' => $topic_id
				) )->save ( $arrData );
				// 执行更新图片信息
				$arrSeqid = $this->_post ( 'seqid');
				$arrTitle = $this->_post ( 'photodesc');
				if(is_array($arrSeqid)){
					foreach($arrSeqid as $key=>$item){
						$seqid = $arrSeqid[$key];
						$imgtitle = empty($arrTitle[$key]) ? '' : $arrTitle[$key];
						$layout = $this->_post ( 'layout_'.$seqid);
						$dataimg = array('title'=>$imgtitle, 'align'=> $layout);
						$where = array('type'=>'topic','typeid'=>$topic_id,'seqid'=>$seqid);
						D('images')->updateImage($dataimg,$where);
					}
				}
				$this->redirect ( 'group/topic', array (
						'id' => $topic_id
				) );
				
			}else{
				$this->redirect ( 'group/index' );
			}
		}else{
			$this->redirect ( 'group/index' );
		}
	}
	// 地区的话题 北京话题
	public 	function nearby(){
		
		$this->show("内容还在建设中！");
	}
	// 编辑小组信息
	public function edit(){
		$userid = $this->userid;
		$type = $this->_get ( 'd', 'trim' );
		$groupid = $this->_get( 'groupid', 'intval');
		//生成菜单
		$menu = array(
				'base' => array('text'=>'基本信息', 'url'=>U('group/edit',array('d'=>'base','groupid'=>$groupid))),
				'icon' => array('text'=>'小组图标', 'url'=>U('group/edit',array('d'=>'icon','groupid'=>$groupid))),
		);
		if (! empty ( $type ) && $groupid > 0) {
			//小组信息
			$strGroup = $this->_mod->getOneGroup($groupid);
			if($userid != $strGroup['userid']){
				$this->error('您没有权限编辑小组信息！');
			}
			switch ($type) {
				case "base" :
					$arrtags = D('tag')->getObjTagByObjid('group','groupid',$groupid);
					foreach($arrtags as $key=>$item)
					{
						$tags .= $item['tagname'].' '; 
					}
					$strGroup['tags'] = trim($tags);
					$this->_config_seo (array('title'=>'编辑小组基本信息','subtitle'=>'小组'));
					break;
					
				case "icon" :
					$this->_config_seo (array('title'=>'修改小组头像','subtitle'=>'小组'));
					break;					
			}
			$this->assign ( 'menu', $menu );
			$this->assign ( 'type', $type );
			$this->assign ( 'strGroup', $strGroup );
			$this->display('edit_'.$type);
		}else{
			$this->redirect ( 'group/index' );
		}
	}
	// 执行更新操作
	public function update(){
		$userid = $this->userid;
		$type = $this->_get ( 'd', 'trim' );
		$groupid = $this->_post( 'groupid', 'intval');
		
		switch ($type) {
			case "base" :
				$data ['groupname'] = $this->_post ( 'groupname', 'trim' );
				$data ['groupdesc'] = $this->_post ( 'groupdesc', 'trim' );
				if($data ['groupname']=='' || $data ['groupdesc']=='') $this->error('小组名称和介绍不能为空！');
				$tags = $this->_post( 'tag', 'trim');
				$tags = str_replace(' ',' ',$tags);
				$arrtag = explode(' ',$tags);
				if( mb_strlen($data ['groupname'],'utf8')>20)
				{
					$this->error('小组名称太长啦，最多20个字...^_^！');
					
				}else if( mb_strlen($data ['groupdesc'], 'utf8') > 10000)
				{
					$this->error('写这么多内容干啥，超出1万个字了都^_^');
				}else if(count($arrtag)>5)
				{
					$this->error('最多 5 个标签，写的太多了...^_^！');
				}
				for($i=0; $i<count($arrtag); $i++)
				{
					if(mb_strlen($arrtag[$i], 'utf8') > 8)
					{
					  $this->error('小组标签太长啦，最多8个字...^_^！');
					}
				}
				//更新tag
				D('tag')->addTag('group','groupid',$groupid,$tags);
				$this->_mod->where(array('groupid'=>$groupid))->save($data);
				$this->success('基本信息修改成功！');
				
				break;
					
			case "icon" :
				// 小组图标
				$groupicon = $_FILES ['picfile'];
				// 上传
				if (! empty ( $groupicon )) {
					//上传头像
					$result = savelocalfile($groupicon,'group/icon',
							array('width'=>'48,60','height'=>'48,60'),
							array('jpg','jpeg','png'),
							md5($groupid));
					if (!$result ['error']) {
						$data ['groupicon'] = $result['img_48_48'];
						//更新小组头像
						$this->_mod->where ( 'groupid=' . $groupid )->setField ( 'groupicon', $data ['groupicon'] );
						$this->success('小组图标修改成功！');
					}
				}			
				
				break;
		}		
		
	}
	// 浏览所有成员
	public function group_user(){
		$groupid = $this->_get( 'groupid', 'intval');
		$strGroup = $this->_mod->getOneGroup ( $groupid );
		// 存在性检查
		! $strGroup && $this->error ( '呃...你想要的东西不在这儿' );
		
		//小组组长信息
		$leaderId = $strGroup['userid'];
		$strLeader = $this->user_mod->getOneUser($leaderId);
		//管理员信息
		$strAdmin =  $this->group_users_mod->field('userid')->where(array('groupid'=>$groupid,'isadmin'=>'1'))->select();		
		if(is_array($strAdmin)){
			foreach($strAdmin as $item){
				$arrAdmin[] = $this->user_mod->getOneUser($item['userid']);
			}
		}
		//小组会员分页
		$page = $this->_get('p','intval',1);
		//查询条件 是否显示
		$map = array('groupid'=>$groupid);
		//显示列表
		$pagesize = 10;
		$count = $this->group_users_mod->where($map)->count('*');
		$pager = $this->_pager($count, $pagesize);
		$groupUser =  $this->group_users_mod->where($map)->order('userid desc')->limit($pager->firstRow.','.$pager->listRows)->select();
		if(is_array($groupUser)){
			foreach($groupUser as $key=>$item){
				$arrGroupUser[] = $this->user_mod->getOneUser($item['userid']);
				$arrGroupUser[$key]['isadmin'] = $item['isadmin'];
			}
		}
			
		$this->assign('pageUrl', $pager->fshow());
		$this->assign('arrGroupUser', $arrGroupUser);
		$this->assign('arrAdmin', $arrAdmin);
		$this->assign('strLeader', $strLeader);
		$this->assign('strGroup', $strGroup);
		
		if($page > '1'){
			$titlepage = " - 第".$page."页";
		}else{
			$titlepage='';
		}
		
		$this->_config_seo (array('title'=>$strGroup['groupname'].'小组成员'.$titlepage,'subtitle'=>'小组'));
		$this->display();
		
	}
	// 设置成员
	public function group_user_set(){
		$type = $this->_get ( 'd', 'trim' );
		if (! empty ( $type )) {
			switch ($type) {
				// 设置为管理员和取消为管理员
				case "isadmin" :
					
					$userid  = $this->_get( 'userid', 'intval');
					$groupid = $this->_get( 'groupid', 'intval');
					$isadmin = $this->_get( 'isadmin', 'intval');					
					
					if($userid == '' && $groupid=='' && $isadmin=='') $this->error("请不要冒险进入危险境地！");
					
					$strGroup = $this->_mod->getOneGroup ( $groupid );					
					if($this->userid != $strGroup['userid']) $this->error("机房重地，闲人免进！");
					
					$this->group_users_mod->where(array('userid'=>$userid,'groupid'=>$groupid))->save(array('isadmin'=>$isadmin));
					$this->redirect ( 'group/group_user', array('groupid'=>$groupid));
				break;
				// 踢出小组成员
				case "isuser" :
					$userid  = $this->_get( 'userid', 'intval');
					$groupid = $this->_get( 'groupid', 'intval');
					$isuser =  $this->_get( 'isuser', 'intval');
					if($userid == '' && $groupid=='' && $isuser=='') $this->error("请不要冒险进入危险境地！");
					$strGroup = $this->_mod->getOneGroup ( $groupid );
					if($this->userid != $strGroup['userid']) $this->error("机房重地，闲人免进！");
					
					$this->group_users_mod->where(array('userid'=>$userid, 'groupid'=>$groupid))->delete();
					
					//计算小组会员数
					$groupUserNum = $this->group_users_mod->where(array('groupid'=>$groupid))->count();
					
					//更新小组成员统计
					$this->_mod->where(array('groupid'=>$groupid))->save(array('count_user'=>$groupUserNum));
					$this->redirect ( 'group/group_user', array('groupid'=>$groupid));
				break;	
			}
		}
		
	}
	//rss 订阅
	public function rss(){			
		$groupid = $this->_get('id');
		$strGroup = $this->_mod->getOneGroup($groupid);
		$arrTopics = $this->group_topics_mod->getTopics($groupid,30);
		
		foreach($arrTopics as $key=>$item){
			$arrTopic[] = $item;
			$arrTopic[$key]['content'] = ikhtml_text('topic', $item['topicid'], $item['content']);
		}
		
		$pubdate = time();
		$this->assign('pubdate', $pubdate);
		$this->assign('arrTopic', $arrTopic);
		$this->assign('strGroup', $strGroup);
		$this->assign('xmlheader','<?xml version="1.0" encoding="UTF-8" ?>');
		$this->display('rss','UTF-8','text/xml');
	}
		
}