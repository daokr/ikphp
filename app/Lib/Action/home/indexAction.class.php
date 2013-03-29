<?php
/*
 * IKPHP 爱客开源社区 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class indexAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->group_mod = D ( 'group' );
		$this->user_mod = D ( 'user' );
		$this->group_topic_mod = D ( 'group_topics' );
		$this->article_mod = D('article');
	}
	public function index() {
		// 来路
		$ret_url = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : __APP__;
		
		//最新10个小组
		$arrNewGroup = $this->group_mod->getNewGroup ( 10 );
		$arrHotTopic = $this->group_topic_mod->getHotTopic(15);
		//活跃会员
		$arrHotUser = $this->user_mod->getHotUser(12);
		//获取最新的 8文章
		$arrNewArticle = $this->article_mod->getNewArticleItem(8);
		//推荐小组10个
		$arrRecommendGroups = $this->group_mod->getRecommendGroup ( 10 );
		foreach ( $arrRecommendGroups as $key => $item ) {
			$arrRecommendGroup [] = $item;
			$arrRecommendGroup [$key] ['groupdesc'] = getsubstrutf8 ( t ( $item ['groupdesc'] ), 0, 35 );
		}
		//统计用户数
		$count_user = $this->user_mod->count('*');
		
		$this->assign ( 'ret_url', $ret_url );
		$this->assign ( 'count_user', $count_user );
		$this->assign ( 'arrNewGroup', $arrNewGroup );
		$this->assign ( 'arrNewArticle', $arrNewArticle );
		$this->assign ( 'arrRecommendGroup', $arrRecommendGroup );
		$this->assign ( 'arrHotUser', $arrHotUser );
		$this->assign ( 'arrHotTopic', $arrHotTopic );
		$this->_config_seo ();
		$this->display ();
	}
	public function test(){
	/* 	$map['lasttime'] = time();
		$map['robotnum'] = array('exp','robotnum+1');
		D('robots')->where(array('robotid'=>1))->setField($map); */
		//D('robots')->where(array('robotid'=>1))->setInc('robotnum');
		//$strArticle = D('article')->field('aid')->order('aid desc')->find();
		//echo $res['aid'];
		//echo D('article')->getLastSql();die;
		$ss = '<p>李双江儿子李天一现在成了媒体的重的。</p><p>
		<img src="http://img1.ph.126.net/KT9Mocb_FuCwQsdpMtZ2rA==/1358116762646888701.jpg">我们是好样
		<img class="abd" src="http://img1.ph.126.net/KT9Mocb_FuCwQsdpMtZ2rA==/1358116762646888702.jpg" style="ad" >中国嘎嘎嘎
		<img src="http://img1.ph.126.net/KT9Mocb_FuCwQsdpMtZ2rA==/1358116762646888703.jpg" >大赌场</p>';
		//echo str_replace('/\[(图片)(\d+)\]/is', '[图片1]', $ss);
		preg_match_all("/\<img\s+.*?>/is", $ss, $picarr);
		//echo($picarr[0][1]);
		//开始替换
		foreach ($picarr[0] as $key=>$item){
			
			$ss = str_replace($item, '[图片1]', $ss);
			
		}
		echo $ss;
	
	}
}