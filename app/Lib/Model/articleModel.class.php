<?php
class articleModel extends Model {
	
	public function getOneArticle($id){
		$where['aid'] = $id;
		$strArticle = $this->where($where)->find();
		if(is_array($strArticle)){
			$articleItem = D('article_item')->where(array('itemid'=>$strArticle['itemid']))->find();
			//array_merge() 函数把两个或多个数组合并为一个数组
			$result = array_merge($articleItem, $strArticle);
			$result['user'] = D('user')->getOneUser($articleItem['userid']);
			$result ['content'] = nl2br ( ikhtml('article',$id,$result['content']) );
			//获取 主图
			if($articleItem['isphoto']){
				$result ['photo'] = D('images')->getImageByseqid('article', $articleItem['itemid'], 1);
			}
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

}