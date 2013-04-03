<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class wordsAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->mod = D ( 'words' );
	}
	public function lists() {
		if(IS_POST){			
			$delwords = $this->_post('delwords');
			//单个新增
			$newfind = $this->_post('newfind');
			$newfind = trim(str_replace('=', '', $newfind));
			$newreplacemnet =  $this->_post('newreplacement','trim');
			if(!empty($newfind)) {
				if(strlen($newfind) < 3){
					$this->error('对不起，您添加的关键词长度过短，请返回修改.');
				}
				$newreplacemnet = addslashes(str_replace("\\\'", "\'", $newreplacemnet));
				$arrwords = $this->mod->field('admin')->where(array('find'=>$newfind))->find();
				
				if(!empty($arrwords)){
					$this->error('关键词已经存在');
				}else{
					$data['find'] = $newfind;
					$data['replacement'] = $newreplacemnet;
					$data['admin'] = $_SESSION['admin']['username'];
					$this->mod->add($data);
				}
			}
			//批量修改
			$find = $this->_post('find');
			$replacement = $this->_post('replacement');
			$updateword = array();
			if(!empty($find) && is_array($find)) {
				foreach($find as $id=>$value) {
					if(is_array($delwords) && in_array($id, $delwords)) {
						continue;
					} else {
						if(strlen($value) < 3) {
							$this->error('关键词太短了至少2个汉字');
						} elseif(in_array($value, $updateword)) {
							$this->error('['.$value.']关键词已经存在');
						}
						$updateword[] = $value;
						$replacement[$id] =  addslashes(str_replace("\\\'", "\'", $replacement[$id]));
						$find[$id] = $value = trim(str_replace('=', '', $value));
						$this->mod->where(array('id'=>$id))->setField(array('find'=>$value, 'replacement'=>$replacement[$id]));
					}
				}
			}
			//删除
			if(!empty($delwords) && is_array($delwords)) {
				$delwords = implode(',',$delwords);
				$where['id'] = array('exp',' IN ('.$delwords.') ');
				$result = $this->mod->where ( $where )->delete();
			}
			// 更新缓存
			$this->updatewords();
			$this->success('词语过滤更新成功');
		}else{
			//查询条件
			$map = '';
			//显示列表
			$pagesize = 20;
			$count = $this->mod->where($map)->count();
			$pager = $this->_pager($count, $pagesize);
			$arrData =  $this->mod->where($map)->limit($pager->firstRow.','.$pager->listRows)->select();
			
			foreach($arrData as $key=>$item){
				$list[] =  $item;
			}
			$this->assign('list',$list);
			$this->title ( '违禁词语过滤' );
			$this->display();
		}
	}
	//批量新增
	public function addwords(){
		
		if(IS_POST){
			$words = $this->_post('words');
			$overwrite = $this->_post('overwrite');
			$oldwords = array();
			if($overwrite == 2) {
				$this->mod->where ( array('id'=>array('gt',0)) )->delete();
			} else {
				$query = $this->mod->select();
				foreach($query as $item) {
					$oldwords[md5($item['find'])] = $item['replacement'];
				}
			}
			$badwords = explode("\n", $words); //换行
			$updatecount = $newcount = $ignorecount = 0;
			$data = array();
			
			foreach($badwords as $value) {
				list($newfind, $newreplacement) = array_map('trim', explode('=', $value));
				$newreplacement = empty($newreplacement) ? '**' : addslashes(str_replace("\\\'", "\'", $newreplacement));
				if(strlen($newfind) < 3) {
					$ignorecount++;
					continue;
				} elseif (isset($oldwords[md5($newfind)])) {
					if($overwrite == 1) {
						$updatecount++;
						$this->mod->where(array('find'=>$newfind))->setField(array('replacement'=>$newreplacement));	
					} else {
						$ignorecount++;
					}
				} else {
					$newcount++;
					$data['find'] = $newfind;
					$data['replacement'] = $newreplacement;
					$data['admin'] = $_SESSION['admin']['username'];
					$oldwords[md5($newfind)] = $newreplacement;
				}
			}
			if(!empty($data)) {
				$this->mod->add($data);
			}
			// 更新缓存
			$this->updatewords();
			$this->success('批量导入词语完毕。总共新增词语 (<b>'.$newcount.'</b>),更新词语(<b>'.$updatecount.'</b>),忽略词语(<b>'.$ignorecount.'</b>).',U('words/lists'));			
			
		}else{
			$this->title ( '违禁词语过滤' );
			$this->display();
		}		
	}
	//导出
	public function export(){
		ob_end_clean();//清空（擦除）缓冲区并关闭输出缓冲
		header('Cache-control: max-age=0');
		header('Expires: '.gmdate('D, d M Y H:i:s', time() - 31536000).' GMT');
		header('Content-Encoding: none');
		header('Content-Disposition: attachment; filename=BadWords.txt');
		header('Content-Type: text/plain');
		
		$query = $this->mod->field('find,replacement')->select();
		foreach ($query as $item){
			$item['replacement'] = str_replace('*', '', $item['replacement']) == '' ? '' : $item['replacement'];
			echo $item['find'].(empty($item['replacement']) ? '' : '='.stripslashes($item['replacement']))."\n";
		}
		exit;
	}
	//更新缓存
	protected  function updatewords(){
		$badwords = array('find' => array(), 'replace' => array(),);
		$query =$this->mod->select();
		foreach ($query as $item){
			$item['find'] = preg_replace("/\\\{(\d+)\\\}/", ".{0,\\1}", preg_quote($item['find'], '/'));
			$badwords['find'][] = '/'.$item['find'].'/i';
			$badwords['replace'][] = $item['replacement'];
		}
		F('badwords',$badwords);
	}

}