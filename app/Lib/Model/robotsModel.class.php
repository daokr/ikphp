<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class robotsModel extends Model
{
	//更新缓存
	public function updaterobot($robotid) {
		$where = array('robotid'=>$robotid);
		$tarr = $result = $userarr = array();
		$results = $this->field('uidrule')->where($where)->find();
		if(!empty($results)) {
			$results['uidrule'] = explode('|', $results['uidrule']);
			if(!empty($results['uidrule'])) {
				foreach($results['uidrule'] as $tmpkey => $tmpvalue) {
					if(empty($tmpvalue)) {
						unset($results['uidrule'][$tmpkey]);
					}
				}
			}
			$results['uidrule'] = saddslashes(shtmlspecialchars($results['uidrule']));
			$uids = simplode($results['uidrule']);
			
			$map['userid'] = array('exp',' IN ('.$uids.') ');
			$userquery = D('user')->where($map)->select();		
			foreach ($userquery as $item) {
				$userarr[$item['userid']] = $item['username'];
			}
		
			$tarr = array(
					'uids'	=>	$userarr
			);
			//存放目录
			$path = DATA_PATH.'robot';
			$cachefile = $path.'/robot_'.$robotid.'.cache.php';
			$text = '$cacheinfo = '.arrayeval($tarr).';';
			writefile($cachefile, $text, 'php');
			return $tarr;
		
		} else {
			return false;
		}
	}
	//插入数据库
	public function messageaddtodb($msgarr, $robotid, $itemid=0) {
		$filepath = DATA_PATH.'robot/robot_'.$robotid.'.cache.php';
		@include_once($filepath);
		if(!$itemid) {
			//var_dump($msgarr);
			$arrArticleItem['title'] = $msgarr['title'];
			$arrArticleItem['cateid'] = $msgarr['importcatid'];
			$arrArticleItem['addtime'] = $msgarr['addtime'];
			$arrArticleItem['userid'] = $msgarr['uid']; //发布者
			$arrArticleItem['isphoto'] = $msgarr['isphoto'];
			
			$arrArticle['newsfrom'] = $msgarr['itemfrom']; //来源
			$arrArticle['newsauthor'] = $msgarr['author']; //来源author
			$arrArticle['content'] = $msgarr['message']; //内容
			
			

			if(!false == D('article_item')->create($arrArticleItem)){
				$newitemid = D('article_item')->add();
				if($newitemid>0){
					$arrArticle['itemid'] = $newitemid; //内容
					if(!false == D('article')->create($arrArticle)){
						$id = D('article')->add();
					}
					//更新图片
					if(!empty($msgarr['arrphotoid'])){
						D('images')->where(array('type'=>'article','typeid'=>'0'))->setField(array('typeid'=>$id));
					}
				}
			}
			return empty($id) ? 0 : $id;
		}
	}
	
}