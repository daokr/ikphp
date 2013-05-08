<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class articleModel extends Model {
	
	public function getOneArticle($id){
		$where['aid'] = $id;
		$strArticle = $this->where($where)->find();
		if(is_array($strArticle)){
			$articleItem = D('article_item')->where(array('itemid'=>$strArticle['itemid']))->find();
			//array_merge() 函数把两个或多个数组合并为一个数组
			$result = array_merge($articleItem, $strArticle);
			$result['user'] = D('user')->getOneUser($articleItem['userid']);
			//获取 主图
			if($articleItem['isphoto']){
				$result ['photo'] = ikhtml_img('article', $articleItem['itemid'], $result ['content']);
			}
			$result ['content'] = nl2br ( ikhtml('article',$id,$result['content'],1));

			return $result;
		}
		return false;
	}
	// 删除一篇文章
	public function delOneArticle($id){
		$where['aid'] = $id;
		$strArticle = $this->where($where)->find();
		if(is_array($strArticle)){
			// 删除信息表
			D('article_item')->where(array('itemid'=>$strArticle['itemid']))->delete();
			$this->where($where)->delete();
			// 删除照片
			D('images')->delAllImage('article',$id);
			// 删除照片
			D('videos')->delAllVideo('article',$id);
		}
	}
	// 获取一篇文章的信息
	public function getOneArticleItem($itemid){
		$where['itemid'] = $itemid;
		$strItem = D('article_item')->where($where)->find();
		if(!empty($strItem)){
			return $strItem;
		}else{
			return false;
		}
	}
	// 获取最新发表的文章
	public function getNewArticleItem($limit){
		$where['isaudit'] = '0';
		$strItem = D('article_item')->where($where)->order('addtime desc')->limit($limit)->select();
		if(!empty($strItem)){
			return $strItem;
		}else{
			return false;
		}		
	}

}