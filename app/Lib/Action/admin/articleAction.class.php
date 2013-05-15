<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class articleAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'article' );
		$this->cate_mod = D ( 'article_cate' );
		$this->item_mod = D ( 'article_item' );
		$this->channel_mod = D ( 'article_channel' );
	}
	public function index() {
		$ik = $this->_get ( 'ik', 'trim' ,'list');
		$nameid = $this->_get ( 'nameid', 'trim');
		//获取全部频道
		$arrChannel = $this->channel_mod->getAllChannel();
		if(empty($nameid)){
			$nameid = $arrChannel[0]['nameid'];
		}
		$this->assign('nameid',$nameid);
		$this->assign('arrChannel',$arrChannel);
		$this->assign('ik',$ik);
		$this->title ( '文章管理' );
		switch ($ik) {
			case "isaudit" :
				$this->article_isaudit($nameid);
				break;
			case "istop" :
				$this->article_istop($nameid);
				break;
			case "isdigest" :
				$this->article_isdigest($nameid);
				break;
			case "list" :
				$this->article_list($nameid);
				break;
		}
	}
	// 文章列表
	public function article_list($nameid){
		$isaudit = $this->_get('isaudit','intval','0');
		$strChannel = $this->channel_mod->where(array('nameid'=>$nameid))->find();
		!$strChannel && $this->error ( '呃...你想要的东西不在这儿' );
		// 获取分类
		$arrCate = $this->cate_mod->getAllCate($nameid);
		
		if(is_array($arrCate)){
			foreach($arrCate as $item){
				$arrCates[] = $item['cateid'];
			}
		}
		$strCates = implode(',',$arrCates);
		//查询条件 是否审核
		$map['cateid'] = array('exp',' IN ('.$strCates.') ');
		$map['isaudit'] = $isaudit;
		//显示列表
		$pagesize = 20;
		$count = $this->item_mod->where($map)->order('addtime desc')->count('itemid');
		$pager = $this->_pager($count, $pagesize);
		$arrArticleItem =  $this->item_mod->where($map)->order('addtime desc')->limit($pager->firstRow.','.$pager->listRows)->select();
		foreach($arrArticleItem as $key=>$item){
			$arrArticle [] = $item;
			$arrArticle [$key]['cate'] = $this->cate_mod->getOneCate($item['cateid']);
			$arrArticle [$key]['user'] = D('user')->getOneUser($item['userid']);
			$arrArticle [$key]['addtime'] = date('Y-m-d H:i:s',$item['addtime']);
		}
		// 未审核数目
		$count_isaudit = $this->item_mod->where(array('isaudit'=>'1'))->count('itemid');
		
		
		$this->assign('pageUrl', $pager->fshow());
		$this->assign ( 'arrArticle', $arrArticle );
		$this->assign ( 'count_isaudit', $count_isaudit );
		$this->assign ( 'isaudit', $isaudit );
		
		
		$this->display('article_list');
	}
	//单个审核
	public function article_isaudit($nameid){
		$itemid = $this->_get('itemid','intval');
		$isaudit = $this->_get('isaudit','intval','0');
		$strItem = $this->mod->getOneArticleItem($itemid);
		if($strItem){
			$this->item_mod->where(array('itemid'=>$itemid))->setField(array('isaudit'=>$isaudit));
			$isaudit = $isaudit == 0? 1 : 0;
			$this->redirect ( 'article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>$isaudit));
		}else{
			$this->error('文章不存在或已被删除！');
		}
	}
	//单个置顶
	public function article_istop($nameid){
		$itemid = $this->_get('itemid','intval');
		$istop = $this->_get('istop','intval','0');
		$strItem = $this->mod->getOneArticleItem($itemid);
		if($strItem){
			$this->item_mod->where(array('itemid'=>$itemid))->setField(array('istop'=>$istop));
			$this->redirect ( 'article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>$strItem['isaudit']));
		}else{
			$this->error('文章不存在或已被删除！');
		}
	}	
	//单个头条精华
	public function article_isdigest($nameid){
		$itemid = $this->_get('itemid','intval');
		$isdigest = $this->_get('isdigest','intval','0'); 
		$strItem = $this->mod->getOneArticleItem($itemid);
		if($strItem){
			$this->item_mod->where(array('itemid'=>$itemid))->setField(array('isdigest'=>$isdigest));
			$this->redirect ( 'article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>$strItem['isaudit']));
		}else{
			$this->error('文章不存在或已被删除！');
		}
	}	
	//ajax 设置 头条 置顶 审核 等操作
	public function ajax_setting(){
		$itemid = $this->_get('id');//信息id 
		$ik = $this->_get ( 'ik', 'trim');
		$field = $this->_post('field');
		$fieldval = $this->_post('fieldval');
		switch ($ik) {
			case "order" :
					$result = $this->item_mod->where(array('itemid'=>$itemid))->setField($field,$fieldval);
					if($result){
						$arrJson = array('r'=>0, 'html'=> '操作成功');
					}else{
						$arrJson = array('r'=>1, 'html'=> '操作失败！');
					}
					echo json_encode($arrJson);
				break;
			case "istop" :
				
				break;
		}
	}
	//ajax删除数据
	public function ajax_delete(){
		$itemid = $this->_post('itemid');
		$ik = $this->_get ( 'ik', 'trim');
		if(!empty($itemid)){
				
			switch ($ik) {
				case "article" :
					//删除
					if($this->mod->delArticle($itemid)){
						$arrJson = array('r'=>0, 'html'=> '删除成功');
					}else{
						$arrJson = array('r'=>1, 'html'=> '删除失败！');
					}
					echo json_encode($arrJson);
					break;
			}
	
		}
	}
	public function channel() {
		$ik = $this->_get ( 'ik', 'trim' ,'list');
		$menu = array(
				'list' => array('text'=>'频道设置', 'url'=>U('article/channel',array('ik'=>'list'))),
				'add' => array('text'=>'新建频道', 'url'=>U('article/channel',array('ik'=>'add'))),
		);
		$this->assign('menu',$menu);
		$this->assign('ik',$ik);
		$this->title ( '频道管理' );
		switch ($ik) {
				case "edit" :
					$this->channel_edit();
					break;
				case "add" :
					$this->channel_add();
					break;	
				case "list" :
					$this->channel_list();
					break;	
				case "isnav" :
					$this->channel_nav();
					break;
		}
	}
	// 取消或设置为导航
	public function channel_nav(){
		$isnav  = $this->_get('isnav','intval','0');
		$nameid = $this->_get('nameid','trim');
		if(!empty($nameid)){
			$this->channel_mod->where(array('nameid'=>$nameid))->setField(array('isnav'=>$isnav));
			$this->redirect ( 'article/channel',array('ik'=>'list'));
		}
		
	}
	public function channel_list(){
		//获取全部频道
		$arrChannel = $this->channel_mod->getAllChannel();
		$this->assign('arrChannel',$arrChannel);
		$this->display('channel_list');
	}
	public function channel_edit(){
		$nameid = $this->_get('nameid');
		$strChannel = $this->channel_mod->getOneChannel($nameid);
		if($strChannel){
			$this->assign('strChannel',$strChannel);
		}else{
			$this->error('频道不存在！');
		}
		if(IS_POST){
			$name = $this->_post('name','trim');
			if(!empty($name)){
				$this->channel_mod->where(array('nameid'=>$nameid))->setField(array('name'=>$name));
				$this->redirect ( 'article/channel',array('ik'=>'list'));
			}
		}
		$this->display('channel_edit');
	}
	public function channel_add(){
		
		if(IS_POST){
			$nameid = $this->_post('nameid','trim');
			$name = $this->_post('name','trim');
			$cate = $this->_post('catename','trim','');
			if(empty($nameid) || empty($name)){
				$this->error('英文名和名称必须填写！');
			}
			if(!preg_match('/^[a-zA-Z]+$/', $nameid)) {
				$this->error('指定的频道英文ID包含非英文字母，请返回检查');
			}
			// 是否已经存在nameid
			$ishave = $this->channel_mod->where(array('nameid'=>$nameid))->find();
			if($ishave){
				$this->error('指定的频道英文ID已经存在，请换一个吧');
			}
			// 添加
			$arrdata = array(
					'name' => strtolower($name),
					'nameid' => $nameid,
			);
			if($this->channel_mod->create($arrdata)){
				$this->channel_mod->add();
				// 添加分类
				if(!empty($cate)){
					$cates = explode("\n", $cate);
					foreach($cates as $value) {
						$value = t(trim($value));
						if($value) {
							$data['catename'] = $value;
							$data['nameid']	  = $nameid;
							if($this->cate_mod->create($data)){
								$this->cate_mod->add();
							}
						}
					}

				}
				$this->redirect ( 'article/channel',array('ik'=>'list'));
			}
		}
				
		$this->display('channel_add');
	}
	// 分类管理
	public function cate() {
		$ik = $this->_get ( 'ik', 'trim' ,'list');
		$nameid = $this->_get ( 'nameid', 'trim');
		//获取全部频道
		$arrChannel = $this->channel_mod->getAllChannel();
		if(empty($nameid)){
			$nameid = $arrChannel[0]['nameid'];
		}
		$this->assign('nameid',$nameid);
		$this->assign('arrChannel',$arrChannel);
		$this->assign('ik',$ik);
		$this->title ( '分类管理' );
		switch ($ik) {
			case "edit" :
				$this->cate_edit();
				break;
			case "add" :
				$this->cate_add($nameid);
				break;
			case "list" :
				$this->cate_list($nameid);
				break;
			case "delete" :
				$this->cate_delete();
				break;
		}
	}
	// 单个频道的分类列表
	public function cate_list($nameid){
		$arrCate = $this->cate_mod->getCateByNameid($nameid);
		$this->assign('arrCate',$arrCate);
		$this->display('cate_list');
	}
	public function cate_add($nameid){
		if(IS_POST){
			$nameid = $this->_post('nameid');
			$catename = $this->_post('catename','trim');
			if(!empty($nameid) && !empty($catename)){
				//执行添加
				if(!false == $this->cate_mod->create(array('catename'=>$catename,'nameid'=>$nameid))){
					$this->cate_mod->add();
					$this->redirect ( 'article/cate',array('ik'=>'list','nameid'=>$nameid));
				}
			}else{
				$this->error('添加失败，分类名称不能为空');
			}
			
		}else{
			$this->display('cate_add');
		}
	}
	public function cate_edit(){
		$cateid = $this->_get('cateid','intval');
		$strCate = $this->cate_mod->getOneCate($cateid);
		if($strCate){
			if(IS_POST){
				$catename =  $this->_post('catename','trim');
				$this->cate_mod->where(array('cateid'=>$cateid))->setField(array('catename'=>$catename));
				$this->redirect ( 'article/cate',array('ik'=>'list','nameid'=>$strCate['nameid']));
			}else{
				$this->assign('strCate',$strCate);
				$this->display('cate_edit');
			}
		}else{
			$this->error('错误操作');
		}
	}
	public function cate_delete(){
		$cateid = $this->_get('cateid','intval');
		$strCate = $this->cate_mod->getOneCate($cateid); // 旧的分类
		if($strCate){
			if(IS_POST){
				$newcateid = $this->_post('newcateid','intval');
				// 删除旧分类
				$this->cate_mod->where(array('cateid'=>$strCate['cateid']))->delete();
				// 设置新分类
				$this->item_mod->where(array('cateid'=>$strCate['cateid']))->setField(array('cateid'=>$newcateid));
				// 新的分类
				$newCate =$this->cate_mod->getOneCate($newcateid); 
				
				$this->redirect ( 'article/cate',array('ik'=>'list','nameid'=>$newCate['nameid']));
			}else{

				// 获取资讯分类
				$arrChannel = $this->channel_mod->getAllChannel();
				$arrCate = ''; // 初始化下拉列表
				$arrCatename = array ();
				foreach ( $arrChannel as $key => $item ) {
					$arrCatename = $this->cate_mod->getCateByNameid ( $item ['nameid'] );
					$arrCate .= '<optgroup label="' . $item ['name'] . '">';
					foreach ( $arrCatename as $key1 => $item1 ) {
						if($strCate['cateid']!=$item1 ['cateid']){
							$arrCate .= '<option  value="' . $item1 ['cateid'] . '" >' . $item1 ['catename'] . '</option>';
						}
					}
					$arrCate .= '</optgroup>';
				}
				$this->assign('strCate',$strCate);
				$this->assign ( 'arrCate', $arrCate );				
				$this->display('cate_delete');
			}
		}else{
			$this->error('错误操作');
		}
	}	
}