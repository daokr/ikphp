<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class tagModel extends Model
{
	// 通过topic获取tag
	function getObjTagByObjid($objname,$idname,$objid){
		$where = array($idname=>$objid);
		$arrTagIndex = D('tag_'.$objname.'_index')->where($where)->select();	
		if(is_array($arrTagIndex)){
			foreach($arrTagIndex as $item){
				$arrTag[] = $this->getOneTag($item['tagid']);
			}
		}
		return $arrTag;
	}
	//通过tagid获得tagname
	function getOneTag($tagid){
		$tagData = $this->where(array('tagid'=>$tagid))->find();	
		return $tagData;
	}
	//通过tagid获得tagname
	function getOneTagByName($tagname){
		$tagData = $this->where(array('tagname'=>$tagname))->find();
		return $tagData;
	}
	//添加多个标签
	function addTag($objname='',$idname='',$objid='',$tags){
	
		//前台添加
		if($objname != '' && $idname != '' && $objid!='' && $tags!=''){
			//$tags = str_replace ( '，', ',', $tags );
			$tag = preg_replace('/\s+/', ',',  $tags );//修正用空格 分割 tag标签
			$arrTag = explode(',', $tag);
			foreach($arrTag as $item){
				$tagname = t($item);
				if(strlen($tagname) < '32' && $tagname != ''){
					$uptime = time();
					$tagcount = $this->where(array('tagname'=>$tagname))->count();
					if($tagcount == 0){
						if (false !== $this->create ( array('tagname'=>$tagname,'uptime'=>$uptime) )){
							$tagid = $this->add();
							$tagIndexCount = D('tag_'.$objname.'_index')->where(array($idname=>$objid, 'tagid'=> $tagid))->count();
							if ($tagIndexCount==0){
								D('tag_'.$objname.'_index')->create(array($idname=>$objid,'tagid'=>$tagid));
								D('tag_'.$objname.'_index')->add();
							}
							$tagIdCount = D('tag_'.$objname.'_index')->where(array('tagid'=>$tagid))->count();
							$this->where(array('tagid'=>$tagid))->setField(array('count_'.$objname=>$tagIdCount, 'uptime'=>$uptime));							
						}
						
					}else{
						
						$tagData = $this->where(array('tagname'=>$tagname))->find();
						$tagIndexCount = D('tag_'.$objname.'_index')->where(array($idname=>$objid, 'tagid'=> $tagData['tagid']))->count();
						if ($tagIndexCount==0){
							D('tag_'.$objname.'_index')->create(array($idname => $objid,'tagid'=> $tagData['tagid']));
							D('tag_'.$objname.'_index')->add();
						}
						$tagIdCount = D('tag_'.$objname.'_index')->where(array('tagid'=>$tagData['tagid']))->count();
						$this->where(array('tagid'=>$tagData['tagid']))->setField(array('count_'.$objname=>$tagIdCount, 'uptime'=>$uptime));
					}					
				}
			}
			
		}elseif($tags!=''){
			//后台批量添加tag
			$arrTag =  explode("\n", $tags);
			foreach($arrTag as $item){
				$tagname = t($item);
				if(strlen($tagname) < '32' && $tagname != ''){
					$uptime = time();
					$tagcount = $this->where(array('tagname'=>$tagname))->count();
					if($tagcount == 0){
						if (false !== $this->create ( array('tagname'=>$tagname,'uptime'=>$uptime) )){
							$tagid = $this->add();							
						}
					}
				}
			}
		}
	}
	//通过指定索引删除tag 如：topic_index
	function delTagById($tagid)
	{
		$where['tagid'] = array('exp',' IN ('.$tagid.') ');
		//先删除tag
		$this->where($where)->delete();
		//删除索引 tag_obj_index 表
		D('tag_group_index')->where($where)->delete();
		D('tag_topic_index')->where($where)->delete();
		return true;
	}
	
}