<?php
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
			
		}
	}
	
}