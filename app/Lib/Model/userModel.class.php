<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class userModel extends Model
{

	protected $_auto = array(
		    array('password','md5',1,'function')
	);
	
	public function email_exists($email, $id = 0) {
		$where = "email='" . $email . "' AND userid<>'" . $id . "'";
		$result = $this->where($where)->count('userid');
		
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	public function name_exists($name, $id = 0) {
		$where = "username='" . $name . "' AND userid<>'" . $id . "'";
		$result = $this->where($where)->count('userid');
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	//唯一性判断存在doname
	public function haveDoname($doname)
	{
		$donamenum =  $this->where(array('doname'=>$doname))->count('*');
		if($donamenum==0)
		{
			return false;
		}else{
			return true;
		}
	}
	//获取活跃会员
	public function getHotUser($limit){
		$where = array (
				'isenable' => 0, // 0 表示正常 1停用
		);
		$arrUserid = $this->field('userid')->where($where)->order('uptime desc')->limit($limit)->select();
		foreach($arrUserid as $item){
			$result[] = $this->getOneUser($item['userid']);
		}
		return $result;
	}
	//获取一个用户的信息
	public function getOneUser($userid){
	
		$strUser = $this->where(array('userid'=>$userid))->find();
		if(empty($strUser)){
			return false;
		}
		$strUser['face'] = avatar($userid, 48);
		$strUser['face_160'] = avatar($userid, 160);
		
		//地区
		if($strUser['areaid'] > 0){
			$strUser['area'] = D('area')->getOneArea($strUser['areaid']);
		}else{
			$strUser['area'] = array(
				'areaid'	=> '0',
				'areaname' => '火星',
			);
		}
		//在线状态
		$time = time() - 15 * 60;
		$isonline = D('user_online')->where(array('userid'=>$userid,'ctime'=>array('gt',$time)))->count();
		$strUser['isonline'] = $isonline > 0 ? 1 : 0 ;

		//签名
		$pattern='/(http:\/\/|https:\/\/|ftp:\/\/)([\w:\/\.\?=&-_]+)/is';

		$strUser['signed'] = hview(preg_replace($pattern, '<a rel="nofollow" target="_blank" href="\1\2">\1\2</a>', $strUser['signed']));
		
		return $strUser;
	}
	// 判断是否存在该用户
	public function isUser($userid){
		$where = array (
				'userid' => $userid,
		);
		$result = $this->where($where)->count('userid');
		if($result){
			return true;
		}else{
			return false;
		}
	}
	// 判断我是否已经关注过他
	public function isFollow($userid,$userid_follow){
		$where = array (
				'userid' => $userid,
				'userid_follow' => $userid_follow,
		);
		$result = D('user_follow')->where($where)->count('*');
		if($result){
			return true;
		}else{
			return false;
		}
	}
	// 关注用户
	public function follow_user($userid, $userid_follow){
		$data = array (
				'userid' => $userid,
				'userid_follow' => $userid_follow,
		);		
		$user_follow_mod = D('user_follow'); 
		if (false !== $user_follow_mod->create ( $data )) {
			$id = $user_follow_mod->add ();
			//更新关注数
			$this->where(array('userid'=>$userid))->setInc('count_follow'); //关注数
			$this->where(array('userid'=>$userid_follow))->setInc('count_followed'); //被关注数
		}
		return true;
	}
	// 取消关注用户
	public function unfollow_user($userid, $userid_follow){
		$where = array (
				'userid' => $userid,
				'userid_follow' => $userid_follow,
		);
		D('user_follow')->where($where)->delete();
		//更新关注数
		$this->where(array('userid'=>$userid))->setDec('count_follow'); //关注数
		$this->where(array('userid'=>$userid_follow))->setDec('count_followed'); //被关注数

		return true;
	}
	// 判断是否已经取消
	public function isunFollow($userid,$userid_follow){
		$where = array (
				'userid' => $userid,
				'userid_follow' => $userid_follow,
		);
		$result = D('user_follow')->where($where)->count('*');
		if($result){
			return true;
		}else{
			return false;
		}
	}
	// 获取我关注的用户
	public function getfollow_user($userid, $limit){
		$where = array (
				'userid' => $userid,
		);
		$followUsers = D('user_follow')->where($where)->order('addtime desc')->limit($limit)->select();
		if(is_array($followUsers)){
			foreach($followUsers as $item){
				$result[] =  $this->getOneUser($item['userid_follow']);
			}
		}
		return $result;
	}
	// 获取某人被关注 用户
	public function getUserFollow($userid_follow,$limit){
		$where = array (
				'userid_follow' => $userid_follow,
		);
		$arrUser = D('user_follow')->where($where)->order('addtime desc')->limit($limit)->select();
		if(is_array($arrUser)){
			foreach($arrUser as $key=>$item){
				$result[$key] =  $this->getOneUser($item['userid']);
			}
		}
		return $result;
	}
}