<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class eventAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		// 访问者控制
		if (! $this->visitor->is_login && in_array ( ACTION_NAME, array (
				'create',
	
		) )) {
			$this->redirect ( 'user/login' );
		} else {
			$this->userid = $this->visitor->info ['userid'];
		}
		$this->area_mod = D ( 'area' );
		$this->user_mod = D ( 'user' );
		$this->cate_mod = D ( 'event_cate' );
	}
		
	public  function index(){
		$this->display();
	}
	//创建
	public  function create(){
		$loc = $this->_get('loc','trim');
		//获取分类
		$arrCate = $this->cate_mod->getAllCate();
		
		$currtCity = $this->area_mod->getOneAreaBypy($loc); //当前所在城市
		$arrCity = $this->area_mod->getHotCity();
	
		if(IS_POST){
			$id = 1;
			$jsonData = array();
			if($id>0){
				$jsonData = array(
					'r'=> true,
					'jumpurl' => U('event/upload_poster',array('id'=>$id)),	
				);
			}
			$this->ajaxReturn($jsonData);
		}
		
		$this->assign('arrCate',$arrCate);
		$this->assign('currtCity',$currtCity);
		$this->assign('arrCity',$arrCity);
		$this->_config_seo (array('title'=>'创建同城活动','subtitle'=>$currtCity['areaname']));
		$this->display();
	}
	//第二步 上传海报
	public function upload_poster(){
		$eventid = $this->_get('id','intval');
		if(IS_POST){
			if (! empty ( $_FILES ['picfile'] )) {
				//保存文件夹
				$data_dir = date ( 'Y/md/H' );
				//上传头像
				$result = savelocalfile(
						$_FILES['picfile'],
						'event/poster/'.$data_dir,
						array('width'=>'200','height'=>'300'),
						array('jpg','gif','png','jpeg'),
						md5($eventid)
						);

				$this->ajaxReturn($result,'JSON');

			}
			//获取截图位置
			$imgpos = $this->_post('imgpos','trim');
			$filepath = $this->_post('file','trim');
			if($imgpos){
				$imgpos = explode('_', $imgpos);
				$_IKIMAGECONFIG = array(
						'thumbcutmode' => 0, // 裁剪模式  0是默认模式     1左或上剪切模式    2中间剪切模式    3右或下剪切模式
						'thumbcutstartx' => $imgpos[0], //x 坐标
						'thumbcutstarty' => $imgpos[1], //y 坐标
						'thumboption' => 4, //8 宽度最佳缩放  4 综合最佳缩放 16 高度最佳缩放
				);
				$dsfile = makethumb($filepath, array($imgpos[2],$imgpos[3]), '',  $_IKIMAGECONFIG);
				//提交成功
				if($dsfile){
					$this->ajaxReturn(array('r'=>true,'url'=>U('event/preview',array('id'=>$eventid))));
				}
			}
		}else{
			$this->assign('eventid',$eventid);
			$this->_config_seo (array('title'=>'上传或更改海报','subtitle'=>'同城活动'));
			$this->display();
		}
	}
	public function preview(){
		$eventid = $this->_get('id');
		$this->assign('eventid',$eventid);
		$this->_config_seo (array('title'=>'成功创建活动','subtitle'=>'同城活动'));
		$this->display();
	}
	//ajax获取子分类
	public function ajax_subcate() {
		$type = $this->_post ( 'ik' );
		$oneid = $this->_post ( 'oneid' );
		switch ($type) {
			case 'two' :
				//获取标签
				$strTag = $this->cate_mod->field('tag')->where(array('cateid'=>$oneid))->find();
				$strTag = unserialize($strTag['tag']);
				$taghtml = $subcatehtml = '';
				if(!empty($strTag)){
					foreach ($strTag as $item){
						$taghtml .='<span class="event-tag">'.$item.'</span>';
					}
					$jsonData['tag'] =$taghtml;
				}else{
					$jsonData['tag'] ='';
				}
				//子类
				$arrCate = $this->cate_mod->getAllsubCate ( $oneid );
				if ($arrCate) {
					$subcatehtml .=  '<select id="subtype" class="basic-input" name="subcate">';
					$subcatehtml .=  '<option value="0">请选择</option>';
					foreach ( $arrCate as $item ) {
						$subcatehtml .=  '<option value="' . $item ['cateid'] . '">' . $item ['catename'] . '</option>';
					}
					$subcatehtml .=  "</select>";
					$jsonData['subcate'] = $subcatehtml;
				} else {
					$jsonData['subcate'] ='';
				}
				$this->ajaxReturn($jsonData,'JSON');
				break;
		}
	}

	
}