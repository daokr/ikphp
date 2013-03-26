<?php
class robotsAction extends backendAction {
	public function _initialize() {
		parent::_initialize ();
		if(is_file(COMMON_PATH.'robot.func.php')){
			include COMMON_PATH.'robot.func.php';
		}
		$this->robots_mod = D ( 'robots' );
		$this->cate_mod = D ( 'article_cate' );
		$this->channel_mod = D ( 'article_channel' );
		$this->$listarr = array();
		$this->$thevalue = array();
		$this->$importvalue = array();
	}
	//添加采集器
	public function add(){
		$ik = $this->_get ( 'ik', 'trim' ,'add_robot');
		//获取全部频道
		$arrChannel = $this->channel_mod->getAllChannel();
		$arrCate = ''; // 初始化下拉列表
		$arrCatename = array ();
		foreach ( $arrChannel as $key => $item ) {
			$arrCatename = $this->cate_mod->getCateByNameid ( $item ['nameid'] );
			$arrCate .= '<optgroup label="' . $item ['name'] . '">';
			foreach ( $arrCatename as $key1 => $item1 ) {
				$arrCate .= '<option  value="' . $item1 ['cateid'] . '" >' . $item1 ['catename'] . '</option>';
			}
			$arrCate .= '</optgroup>';
		}
		//
		
		$this->assign ( 'arrCate', $arrCate );
		$this->assign('ik',$ik);
		$this->title ( '采集器' );
		switch ($ik) {
			case "add_robot" :
				$this->add_robot();
				break;
			case "publish" :
				//执行添加
				$this->publish();
				break;
			case "debug_robot" :
				$this->debug_robot();
				break;
		}
	}
	//浏览列表
	public function lists(){
		echo 12;
	}
	public function publish(){
		
		$listurl_manual = $this->_post('listurl_manual','trim'); // listurl_manual[] http://blog.163.com/pub/channel/ent/ent_02.html
		$listurl_auto = $this->_post('listurl_auto','trim'); // http://blog.163.com/pub/channel/ent/ent_[page].html
		
		$postlisturl = serialize(array('manual'=>$listurl_manual, 'auto'=>$listurl_auto));
		$autotype = $this->_post('autotype');
		$autotype = !empty($autotype) && intval($autotype) == 2 ? 2 : 1;
		$name = $this->_post('name');
		if(empty($name)){
			$this->error('采集器名称不能为空');
		}		
		$subjectreplace = $this->_post('subjectreplace');
		$subjectreplace = !empty($subjectreplace) ? implode("\n", $subjectreplace) : '';

		$subjectreplaceto = $this->_post('subjectreplaceto');
		$subjectreplaceto = !empty($subjectreplaceto) ? implode("\n", $subjectreplaceto) : '';
		
		$messagereplace = $this->_post('messagereplace');
		$messagereplace = !empty($messagereplace) ? implode("\n", $messagereplace) : '';
		
		$messagereplaceto = $this->_post('messagereplaceto');
		$messagereplaceto = !empty($messagereplaceto) ? implode("\n", $messagereplaceto) : '';
		
		$importcatid = $this->_post('import'); //导入的目录
		
		$data = array(
				'name' => $this->_post('name'),
				'addtime' => time(), //添加机器人的时间
				'listurl' => $postlisturl,
				'listpagestart' => $this->_post('listpagestart'),
				'listpageend' => $this->_post('listpageend'),
				'allnum' => $this->_post('allnum'), //总的采集数
				'pernum' => $this->_post('pernum'),
				'importcatid' => intval($importcatid),  //目录id
				//'importtype' => $catarr[0], 小麦修改 这个不需要type了
				
				'reverseorder' => $this->_post('reverseorder','intval'), //文章倒序采集 0 否 1是
				'encode' => $this->_post('encode'),
				'savepic' => $this->_post('savepic'), //保存内容中的图片到本地
				'saveflash' => $this->_post('saveflash'),
				'subjecturlrule' => striptbr($this->_post('subjecturlrule')),
				'subjecturllinkrule' => striptbr($this->_post('subjecturllinkrule')),
				'subjecturllinkpre' => $this->_post('subjecturllinkpre'),
				'subjectrule' => striptbr($this->_post('subjectrule')),
				'subjectfilter' => striptbr($this->_post('subjectfilter')),
				'subjectreplace' => $this->_post('subjectreplace'),
				'subjectreplaceto' => $this->_post('subjectreplaceto'),
				'subjectkey' => $this->_post('subjectkey'),
				'subjectallowrepeat' => $this->_post('subjectallowrepeat'),
				'datelinerule' => striptbr($this->_post('datelinerule')),
				'fromrule' => striptbr($this->_post('fromrule')),
				'authorrule' => striptbr($this->_post('authorrule')),
				
				'messagerule' => striptbr($this->_post('messagerule')),
				'messagefilter' => striptbr($this->_post('messagefilter')),
				'messagepagetype' => $this->_post('messagepagetype'),
				'messagepagerule' => striptbr($this->_post('messagepagerule')),
				
				'messagepageurlrule' => striptbr($this->_post('messagepageurlrule')),
				'messagepageurllinkpre' => $this->_post('messagepageurllinkpre'),
				'messagereplace' => $this->_post('messagereplace'),
				'messagereplaceto' => $this->_post('messagereplaceto'),
				
				'picurllinkpre' => $this->_post('picurllinkpre'),
				'autotype' => $this->_post('autotype'),
				'wildcardlen' => $this->_post('autotype') == 1 ? $this->_post('wildcardlen') : '0',
				
				'subjecturllinkcancel' => striptbr($this->_post('subjecturllinkcancel')),
				'subjecturllinkfilter' => striptbr($this->_post('subjecturllinkfilter')),
				'subjecturllinkpf' => $this->_post('subjecturllinkpf'),
				'subjectkeycancel' => $this->_post('subjectkeycancel'),
				'messagekey' => $this->_post('messagekey'),
				'messagekeycancel' => $this->_post('messagekeycancel'),
				'messageformat' => $this->_post('messageformat'),
				
				'messagepageurllinkpf' => $this->_post('messagepageurllinkpf'),
				'uidrule' => shtmlspecialchars($this->_post('uidrule')), //发布者UID
				//'defaultdateline' =>  empty($this->_post('defaultdateline')) ? time() : sstrtotime($this->_post('defaultdateline')),
		);
		
		//对于新增的采集器与编辑的采集器的分别处理
		$robotid = $this->_post('robotid','intval');
		if(empty($robotid)) {
			$robotid = 0;
			$admin = session('admin');
			$data['userid'] = $admin['userid'];// 添加者id 就是管理员id
			
			echo $admin['userid'];
			if(!false == D('robots')->create($data)){
				echo 22;
				$robotid = D('robots')->add();
				echo D('robots')->getLastSql();
				echo $robotid;die;
			}
			//updaterobot($robotid);	//更新采集器缓存
			//$this->success("采集机器人成功添加",U('robots/lists'));
			
		} else {
			/* 122INSERT INTO `ik_robots` (`name`,`addtime`,`listurltype`,`listurl`,`listpagestart`,`listpageend`,
					`allnum`,`pernum`,`importcatid`,`reverseorder`,
					`encode`,`savepic`,`saveflash`,`subjecturlrule`,
					`subjecturllinkrule`,`subjecturllinkpre`,`subjectrule`,
					`subjectfilter`,`subjectkey`,`subjectallowrepeat`,`datelinerule`,
					`fromrule`,`authorrule`,`messagerule`,`messagefilter`,`messagepagetype`,`messagepagerule`,
					`messagepageurlrule`,`messagepageurllinkpre`,`picurllinkpre`,`autotype`,`wildcardlen`,`subjecturllinkcancel`,
					`subjecturllinkfilter`,`subjecturllinkpf`,`subjectkeycancel`,`messagekey`,`messagekeycancel`,
					`messageformat`,   `messagepageurllinkpf`,      `uidrule`,`userid`) VALUES ('新闻',1364317890,'new','a:2:{s:6:\"manual\";a:1:{i:0;s:47:\"http://blog.163.com/pub/channel/ent/ent_02.html\";}s:4:\"auto\";s:0:\"\";}',0,0,100,1,1,0,'',0,0,'','','','','','',1,'','','','','','page','','','','',
							
							
							null,0,'','','','','','',1,'',      '',1) */
			//UPDATE
			$where = array('robotid' => $this->_post('robotid','intval'));
			D('robots')->where($where)->save($data);
			//updaterobot($_POST['robotid']);	//更新采集器缓存
			//$this->success("采集机器人编辑成功",U('robots/lists'));
		}
		
		
	
	}
	// 添加
	public function add_robot(){
		//添加新采集器初始值
		$this->thevalue = array(
				'robotid' => '0',
				'name' => '',
				'encode' => '',
				'reverseorder' => '0',
				'listurl' => '',
				'listpagestart' => '0',
				'listpageend' => '0',
				'allnum' => '100',
				'pernum' => '1',
				'savepic' => '0',
				'saveflash' => '0',
				'subjecturlrule' => '',
				'subjecturllinkrule' => '',
				'subjecturllinkpre' => '',
				'subjectrule' => '',
				'subjectfilter' => '',
				'subjectreplace' => '',
				'subjectreplaceto' => '',
				'subjectkey' => '',
				'datelinerule' => '',
				'fromrule' => '',
				'authorrule' => '',
				'messagerule' => '',
				'messagefilter' => '',
				'messagepagetype' => 'page',
				'messagepagerule' => '',
				'messagepageurlrule' => '',
				'messagereplace' => '',
				'messagereplaceto' => '',
				'picurllinkpre' => '',
				'messagepageurllinkpre' => '',
				'subjectallowrepeat' => '1',
				'autotype' => '1',
				'wildcardlen' => '0',
				'subjecturllinkcancel' => '',
				'subjecturllinkfilter' => '',
				'subjecturllinkpf' => '',
				'subjectkeycancel' => '',
				'messagekey' => '',
				'messagekeycancel' => '',
				'messageformat' => '1',
				'messagepageurllinkpf' => '',
				'uidrule' => '',
				'listurl_auto' => '',
				'listurl_manual' => '',
				'defaultdateline' => ''
				);
		$this->assign ( 'thevalue', $this->thevalue);
		$this->display('add_robot');
	}
	// 调试
	public function debug_robot(){
		
		//采集器编辑调试用
		@ini_set ( 'max_execution_time', 2000 ); //设置超时时间
		//初始化
		$listurl_manual = $this->_post('listurl_manual');
		$debugurl = $this->_post('debugurl','trim');
		$listurl_auto = $this->_post('listurl_auto', 'trim');

		//start
		$listurlarr = $listurlarr2 = $infoarr = array (); //初始采集页面数组
		$output = '';
		$sourcehtml = ''; //原html代码
		$sourcecharset = '';
		$rule = '';
		$i = $urlorder = 0;
		
		//对采集数组进行整理
		if (empty($debugurl)) {
			if(!empty($listurl_auto)){ 
				$autotype = $this->_post('autotype','intval');
				$autotype = empty($autotype) && $autotype==2 ? 2:1;
				$listurl_manual = $this->_post('listurl_manual');
				$listpagestart = $this->_post('listpagestart','intval');
				$listpagestart = !empty($autotype) && $autotype==1 ? $listpagestart : ord($listpagestart);
				$listpageend = $this->_post('listpageend','intval');
				$listpageend = !empty($autotype) && $autotype==1 ? $listpageend : ord($listpageend);
				$wildcardlen = $this->_post('wildcardlen','intval','0');
				$listurl_auto = $this->_post('listurl_auto');
				if($listpagestart > $listpageend) {
					$urlorder = $listpagestart;
					$listpagestart = $listpageend;
					$listpageend = $urlorder;
					$urlorder = 1;
				}
				for($i = $listpagestart; $i <= $listpageend; $i++) {
					$strreplace = $i;
					if(!empty($wildcardlen) && $autotype == 1) {
						$strreplace = str_pad($i, $wildcardlen, 0, STR_PAD_LEFT);
					} elseif($autotype == 2) {
						$strreplace = chr($i);
					}
					if($autotype == 1 || ($autotype == 2 && preg_match("/[a-z]/i", $strreplace))) {
						$listurlarr2[] = preg_replace("/\[page\]/", $strreplace, $listurl_auto);
					}
				}
				if($urlorder == 1) krsort($listurlarr2);//对数组按照键名逆向排序
			
			}
			if (! empty ($listurl_manual)) {
				$listurlarr = $listurl_manual;
			}
			if ($urlorder == 0) {
				$listurlarr = array_merge ( $listurlarr, $listurlarr2 );
			} else {
				$listurlarr = array_merge ( $listurlarr2, $listurlarr );
			}
			
		}else{
			$listurlarr [] = $debugurl;
		}
		if (empty ($listurlarr)) {
			showprogress ( "没有连接地址", 1 ); //无连接
			exit ();
		}
		//开始调试
		$debugprocess = $this->_post('debugprocess');
		$haystack = array ('showlisturl', 'pinglisturl', 'charset', 'subjecturlrule', 
		'subjecturllinkrule', 'subjecturllinkcancel', 'subjecturllinkfilter', 'subjecturllinkpre', 'subjecturllinkpf' );
		if(empty($debugurl) || in_array($debugprocess, $haystack)){
			//测试：显示链接
			if($debugprocess == 'showlisturl') {
				showprogress ( "链接列表", 1 );
				if($i >= 1000) {
					showprogress ( "由于链接列表大于1000条,程序调试程序只显示头1000条数据." );
				}
				$output = implode("<br />\n", $listurlarr);
				showprogress($output);
				exit();
			}
			//测试：尝试连接
			if($debugprocess == 'pinglisturl') {
				$i = 0;
				showprogress ( "链接列表", 1 );
				foreach($listurlarr as $tmpvalue) {
					$sourcehtml = $this->geturlfile($tmpvalue, 0);
					if(!empty($sourcehtml)) {
						$output = "<font color='green'>连接成功</font>";
					} else {
						$output = "<font color='red'>连接失败</font>";
					}
					showprogress($tmpvalue.'--'.$output."\n");
					$i++;
					if($i >= 10) {
						break;
					}
				}
				exit();
			}
			//程序识别
			if($debugprocess == 'charset')
			{
				$sourcehtml = $this->geturlfile($listurlarr[0], 0);	//读取网页
				if(empty($sourcehtml)) {
					showprogress("无法读取到内容", 1);
					exit();
				}
				showprogress('被采集页面的编码', 1);
				preg_match_all("/\<meta[^\<\>]+charset=([^\<\>\"\'\s]+)[^\<\>]*\>/i", $sourcehtml, $temp, PREG_SET_ORDER);
				$sourcecharset = !empty($temp) ? trim(strtoupper($temp[0][1])) : '';//转化成大写
				if(!empty($sourcecharset)) {
					showprogress('被采集页面的编码:'.$sourcecharset);
					showprogress('您的网站编码为:'.C('ik_charset'));
					showprogress('如果两个编码相同无需进行设置.', 1);
				} else {
					showprogress($listurlarr[0].'没有识别出页面编码,请进行人工识别.');
				}
			
				exit();
			}
			//编码设置
			$sourcecharset = $this->_post('encode','trim','');
			if(empty($sourcecharset)) {
				showprogress('采集页面编码未设置,系统不进行转码工作.如果调试区域为乱码时,请您设置"采集页面编码".', 1);
			}
			//开始读页面
			$listurlarr[0] = encodeconvert($sourcecharset, $listurlarr[0], 1);
			$sourcehtml = $this->geturlfile($listurlarr[0], 0);	//读取网页
			if(empty($sourcehtml)) {
				showprogress($listurlarr[0].'无法读取页面', 1);
				exit();
			}
			//转码
			$sourcehtml = encodeconvert($sourcecharset, $sourcehtml);
			//列表区域识别规则测试
			$subjecturlrule = $this->_post('subjecturlrule','trim');
			if(!empty($subjecturlrule)){
				$subjecturlrule = sstripslashes($subjecturlrule);
				$subjecturlarr = pregmessage($sourcehtml, $subjecturlrule, 'list');	//解析列表区域
			}else {
				showprogress('列表区域识别规则未设置,程序将自动识别"列表区域",此种方法会产生一定误差.', 1);
				$subjecturlarr[0] = $sourcehtml;
			}
			if($debugprocess == 'subjecturlrule') {
				$infoarr = array(
						'code'	=>	$subjecturlarr[0], //识别出来的内容
						'url'	=>	$listurlarr[0],
						'rule'	=>	$subjecturlrule,
						'source'	=>	$sourcehtml
				);
				printruledebug($infoarr);
			}	//$subjecturlarr[0]	识别出来的内容
				
			if(empty($subjecturlarr[0])) {
				showprogress('没识别出任何内容,请检查"列表区域识别规则"', 1);
				exit();
			}
			
			//文章链接URL识别规则
			$subjecturllinkrule = $this->_post('subjecturllinkrule','trim','');
			$subjecturllinkrule = !empty($subjecturllinkrule) ? sstripslashes($subjecturllinkrule) : '';
			$newurlarr = array();
			if(empty($subjecturllinkrule)) {
				showprogress('文章链接URL识别规则未设置,程序将自动识别"列表区域"所有链接,此种方法会产生一定误差.', 1);
				$subjecturlarr[0] = preg_replace(array("/[\n\r]+/", "/\<\/a\>/i", "/\<a/i") , array('', "</a>\n", "\n<a"), $subjecturlarr[0]);
				preg_match_all("/\<a.+href=('|\"|)?([^\s\<\>]*)(\\1)([\s].*)?\>(.*)\<\/a\>/i", $subjecturlarr[0], $ahreftemp);
				$newurlarr = sarray_unique($ahreftemp[2]);	//去重
			} else {
				$urlarr = pregmessage($subjecturlarr[0], $_POST['subjecturllinkrule'], 'url', -1);		//解析上步过虑后的结果
				$newurlarr = sarray_unique($urlarr);	//去重
			}
			if($debugprocess == 'subjecturllinkrule') {
				$infoarr = array(
						'code'	=>	$newurlarr,
						'url'	=>	$listurlarr[0],
						'rule'	=>	$subjecturllinkrule,
						'source'	=>	$subjecturlarr[0]
				);
				printruledebug($infoarr);
			}	//$newurlarr 链接数组
			if(empty($newurlarr)) {
				showprogress('文章链接URL识别规则未设置,程序将自动识别"列表区域"所有链接,此种方法会产生一定误差.', 1);
				exit();
			}
			
			//文章链接URL剔除规则
			$subjecturllinkcancel = $this->_post('subjecturllinkcancel','trim','');
			$subjecturllinkcancel = !empty($subjecturllinkcancel) ? sstripslashes($subjecturllinkcancel) : '';
			if($debugprocess == 'subjecturllinkcancel') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL剔除"前"为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			}
			if(!empty($_POST['subjecturllinkcancel'])) {
				$urlarr = $newurlarr;
				$newurlarr = array();
				$rule = '('.convertrule($subjecturllinkcancel).')';
				foreach($urlarr as $tmpvalue) {
					if(!preg_match("/$rule/i", $tmpvalue)) {
						$newurlarr[] = $tmpvalue;
					}
				}
			}
			if($debugprocess == 'subjecturllinkcancel') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL剔除"后"链接为:', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
				$rule = shtmlspecialchars('('.convertrule($_POST['subjecturllinkcancel']).')');
				showprogress('正则表达式', 1);
				showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
				exit();
			}	//$newurlarr 链接数组
			if(empty($newurlarr)) {
				showprogress('文章链接URL剔除后没链接', 1);
				exit();
			}
			
			//文章链接URL过滤规则
			$subjecturllinkfilter = $this->_post('subjecturllinkfilter','trim','');
			$subjecturllinkfilter = !empty($subjecturllinkfilter) ? sstripslashes($subjecturllinkfilter) : '';
			if($debugprocess == 'subjecturllinkfilter') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL过滤"前"为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			}
			if(!empty($subjecturllinkfilter)) {
				$urlarr = $newurlarr;
				$newurlarr = array();
				$rule = '('.convertrule($subjecturllinkfilter).')';
				foreach($urlarr as $tmpvalue) {
					$newurlarr[] = trim(preg_replace("/$rule/s", '', $tmpvalue));
				}
			}
			if($debugprocess == 'subjecturllinkfilter') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL过滤"后"链接为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
				$rule = shtmlspecialchars('('.convertrule($subjecturllinkfilter).')');
				showprogress('正则表达式', 1);
				showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
				exit();
			}	//$newurlarr 链接数组
			if(empty($newurlarr)) {
				showprogress( '文章链接URL过滤后没链接' , 1);
				exit();
			}
			
			//文章链接URL补充前缀
			if($debugprocess == 'subjecturllinkpre') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL补充前缀"前"为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			}
			$subjecturllinkpre = $this->_post('subjecturllinkpre','trim','');
			$subjecturllinkpre = !empty($subjecturllinkpre) ? sstripslashes($subjecturllinkpre) : '';
			
			if(!empty($subjecturllinkpre)) {
				foreach ($newurlarr as $tmpkey => $tmpvalue) {
					if(!empty($tmpvalue)) {
						if(strpos($tmpvalue, '://') === false) {
							$newurlarr[$tmpkey] = $subjecturllinkpre.$tmpvalue;
						} elseif(strpos($tmpvalue, '://')>10) {
							$newurlarr[$tmpkey] = $subjecturllinkpre.$tmpvalue;
						}
					}
				}
			} else {
				$url = array();
				$posturl = parse_url($listurlarr[0]);
				foreach ($newurlarr as $tmpkey => $tmpvalue) {
					if(!empty($tmpvalue)) {
						$url = parse_url($tmpvalue);
						if(!empty($url['host'])){
							$newurlarr[$tmpkey] = $tmpvalue;
						} else {
							$offset = strpos($tmpvalue, '/');
							if(!is_bool($offset) && $offset == 0){
								$newurlarr[$tmpkey] = $posturl['scheme'].'://'.$posturl['host'].$tmpvalue;
							} else {
								$newurlarr[$tmpkey] = substr($listurlarr[0], 0, strrpos($listurlarr[0], '/')).'/'.$tmpvalue;
							}
						}
					}
				}
			}
			if($debugprocess == 'subjecturllinkpre') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL补充前缀"后"链接为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
				exit();
			}	//$newurlarr 链接数组
			
			//文章链接URL补充后缀
			if($debugprocess == 'subjecturllinkpf') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL补充后缀"前"为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			}
			$subjecturllinkpf = $this->_post('subjecturllinkpf','trim','');
			$subjecturllinkpf = !empty($subjecturllinkpf) ? sstripslashes($subjecturllinkpf) : '';
			
			if(!empty($subjecturllinkpf)) {
				foreach ($newurlarr as $tmpkey => $tmpvalue) {
					if(!empty($tmpvalue)) {
						$newurlarr[$tmpkey] = $tmpvalue.$subjecturllinkpf;
					}
				}
			}
			if($debugprocess == 'subjecturllinkpf') {
				$newurlarrtmp = implode("\n", $newurlarr);
				showprogress('文章链接URL补充后缀"后"链接为', 1);
				showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
				exit();
			}	//$newurlarr 链接数组
			
				
			//debug结束
		}else {
			$newurlarr[0] = $this->_post('debugurl');
		}
		// 开始调试标题
		foreach($newurlarr as $key => $value) {
			if(empty($value)) {
				continue;
			} else {
				$newurlarr[0] = $value;
				break;
			}
		}
		
		//读取第一篇文章
		$messagemsgtext = '';
		$newurlarr[0] = encodeconvert($sourcecharset, $newurlarr[0], 1);
		$messagemsgtext = $this->geturlfile($newurlarr[0], 0);	//读取网页
		$messagemsgtext = encodeconvert($sourcecharset, $messagemsgtext);
		if(empty($messagemsgtext)) {var_dump($newurlarr[0]);die;
			showprogress('无法读取'.' '.$newurlarr[0], 1);
			exit();
		}
		//文章标题识别规则
		$subjectrule = $this->_post('subjectrule','trim','');
		$subjectrule = !empty($subjectrule) ? sstripslashes($subjectrule) : '';
		if(empty($subjectrule)) {
			showprogress('文章标题识别规则未设置', 1);
			exit();
		}
		$subjectarr = array();
		$subjectarr = pregmessage($messagemsgtext, $subjectrule, 'subject');
		if($debugprocess == 'subjectrule') {
			$infoarr = array(
					'code'	=>	$subjectarr[0],
					'url'	=>	$newurlarr[0],
					'rule'	=>	$subjectrule,
					'source'	=>	$messagemsgtext
			);
			printruledebug($infoarr);
		}	//$subjectarr[0]	识别出来的标题
		
		//如果没有规则提示
		if(empty($subjectarr[0])) {
			showprogress('没识别出任何内容,请检查"文章标题识别规则"', 1);
			exit();
		}	//$subjectarr[0] 标题
		
		//文章标题过滤规则
		$subjectfilter = $this->_post('subjectfilter','trim','');
		$subjectfilter = !empty($subjectfilter) ? sstripslashes($subjectfilter) : '';
		if(!empty($subjectfilter)) {
			$rule = '('.convertrule($subjectfilter).')';
			$subjectarr[0] = trim(preg_replace("/$rule/s", '', $subjectarr[0]));
		}
		
		if($debugprocess == 'subjectfilter') {
			showprogress('文章标题过滤后为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($subjectfilter).')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$subjectarr[0] 标题
		
		if(empty($subjectarr[0])) {
			showprogress('文章标题过滤后没有内容', 1);
			exit();
		}
		
		//文章标题文字替换
		if($debugprocess == 'subjectreplace') {
			showprogress('文章标题文字替换"前"为：', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
		}
		$subjectreplace = $this->_post('subjectreplace');
		$subjectreplace = !empty($subjectreplace) ? sstripslashes(strim($subjectreplace)) : '';
		$subjectreplaceto = $this->_post('subjectreplaceto');
		$subjectreplaceto = !empty($subjectreplaceto) ? sstripslashes(strim($subjectreplaceto)) : '';
		if(!empty($subjectreplace)) {
			$subjectarr[0] = stringreplace($subjectreplace, $subjectreplaceto, $subjectarr[0]);
		}
		if($debugprocess == 'subjectreplace') {
			showprogress('文章标题文字替换"后"为：', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
			exit();
		}	//$subjectarr[0] 标题
		
		//文章标题包含关键字
		$subjectkey = $this->_post('subjectkey','trim','');
		$subjectkey = !empty($subjectkey) ? sstripslashes($subjectkey) : '';
		if($debugprocess == 'subjectkey') {
			$newsubject = '';
			showprogress('文章标题', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$subjectarr[0].'">');
			$rule = convertrule($subjectkey);
			$newsubject = preg_replace("/($rule)/s", '', $subjectarr[0]);
			if($newsubject == $subjectarr[0]) {
				showprogress( '文章标题不包含指定关键词,不会被采集.', 1);
			} else {
				showprogress('文章标题包含指定关键词,将被采集.', 1);
			}
			$rule = shtmlspecialchars('('.$rule.')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$subjectarr[0] 标题
		
		//文章标题关键字剔除过滤
		$subjectkeycancel = $this->_post('subjectkeycancel','trim','');
		$subjectkeycancel = !empty($subjectkeycancel) ? sstripslashes($subjectkeycancel) : '';		
		if($debugprocess == 'subjectkeycancel') {
			$newsubject = '';
			showprogress('文章标题', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$subjectarr[0].'">');
			$rule = convertrule($subjectkeycancel);
			$newsubject = preg_replace("/($rule)/s", '', $subjectarr[0]);
			if($newsubject == $subjectarr[0]) {
				showprogress('文章标题不包含指定关键词,将被采集.', 1);
			} else {
				showprogress('文章标题包含指定关键词,不会被采集.', 1);
			}
			$rule = shtmlspecialchars('('.$rule.')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$subjectarr[0] 标题
		
		//标题结束/////////////////////////////////////////////////////////////////////////////////////
		//内容开始/////////////////////////////////////////////////////////////////////////////////////
		//文章内容识别规则
		$messagearr = array();
		$messagerule = $this->_post('messagerule','trim','');
		$messagerule = !empty($messagerule) ? sstripslashes($messagerule) : '';	
		if(empty($messagerule)) {
			showprogress('文章内容识别规则未设置,程序将自动识别"文章内容",此种方法会产生一定误差.', 1);
			$rsmessagearr = getrobotmessage($messagemsgtext, $newurlarr[0], 2);
			$messagearr[0] = $rsmessagearr['leachmessage'];
		} else {
			$messagearr = pregmessage($messagemsgtext, $_POST['messagerule'], 'message');
		}
		if($_POST['debugprocess'] == 'messagerule') {
			$infoarr = array(
					'code'	=>	$messagearr[0],
					'url'	=>	$newurlarr[0],
					'rule'	=>	$_POST['messagerule'],
					'source'	=>	$messagemsgtext
			);
			printruledebug($infoarr);
			//$messagearr[0]	识别出来的文章内容
		}
		if(empty($messagearr[0])) {
			showprogress('没识别出任何文章内容,请检查"文章内容识别规则"', 1);
			exit();
		}
		$messagefilter = $this->_post('messagerule','trim','');
		$messagefilter = !empty($messagefilter) ? sstripslashes($messagefilter) : '';
		//文章内容过滤规则
		if($debugprocess == 'messagefilter') {
			showprogress('文章内容过滤"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($messagefilter).')');
		}
		
		if(!empty($messagefilter)) {
			$rule = '('.convertrule($messagefilter).')';
			$messagearr[0] = trim(preg_replace("/$rule/s", '', $messagearr[0]));
		}
		if($debugprocess == 'messagefilter') {
			showprogress('文章内容过滤"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($messagefilter).')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//messagefilter[0] 内容
		if(empty($messagearr[0])) {
			showprogress('文章内容过滤后没有内容.', 1);
			exit();
		}
		
		//文章内容文字替换
		if($debugprocess == 'messagereplace') {
			showprogress('文章内容文字替换"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		}
		$messagereplace = $this->_post('messagereplace');
		$messagereplace = !empty($messagereplace) ? sstripslashes(strim($messagereplace)) : '';
		$messagereplaceto = $this->_post('messagereplaceto');
		$messagereplaceto = !empty($messagereplaceto) ? sstripslashes(strim($messagereplaceto)) : '';
		$subjectreplace = $this->_post('subjectreplace');
		if(!empty($subjectreplace)) {
			$messagearr[0] = stringreplace($messagereplace, $messagereplaceto, $messagearr[0]);
		}
		if($debugprocess == 'messagereplace') {
			showprogress($messagereplaceto.'文章内容文字替换"后"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			exit();
		}	//$messagearr[0] 标题
		
		//文章内容包含关键字
		$messagekey = $this->_post('messagekey','trim','');
		$messagekey = !empty($messagekey) ? sstripslashes(trim($messagekey)) : '';
		if($debugprocess == 'messagekey') {
			$newsubject = '';
			showprogress('文章内容', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = convertrule($_POST['messagekey']);
			$newmessage = preg_replace("/($rule)/s", '', $messagearr[0]);
			if($newmessage == $messagearr[0]) {
				showprogress('文章内容不包含指定关键词,不会被采集.', 1);
			} else {
				showprogress('文章内容包含指定关键词,将被采集.', 1);
			}
			$rule = shtmlspecialchars('('.$rule.')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$messagearr[0] 标题
		
		//文章内容关键字剔除过滤
		$messagekeycancel = $this->_post('messagekeycancel','trim','');
		$messagekeycancel = !empty($messagekeycancel) ? sstripslashes(trim($messagekeycancel)) : '';
		if($debugprocess == 'messagekeycancel') {
			$newsubject = '';
			showprogress('文章内容', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = convertrule($messagekeycancel);
			$newmessage = preg_replace("/($rule)/s", '', $messagearr[0]);
			if($newmessage == $messagearr[0]) {
				showprogress('文章内容不包含指定关键词,将被采集.', 1);
			} else {
				showprogress('文章内容包含指定关键词,不会被采集.', 1);
			}
			$rule = shtmlspecialchars('('.$rule.')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$subjectarr[0] 标题
		
		//文章内容格式化
		$messageformat = $this->_post('messageformat','intval',0);
		if($debugprocess == 'messageformat') {
			showprogress('文章内容格式化前为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		}
		if(!empty($messageformat)) {
			$rsmessagearr = getrobotmessage($messagearr[0], $newurlarr[0]);
			$messagearr[0] = $rsmessagearr['leachmessage'];
		}
		if($debugprocess == 'messageformat') {
			showprogress('文章内容格式化后为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			exit();
		}
		
		//文章内容分页区域识别规则
		$messagepagearr = array();
		$messagepagerule = $this->_post('messagepagerule');
		$messagepagerule = !empty($messagepagerule) ? sstripslashes(trim($messagepagerule)) : '';
		if(!empty($messagepagerule)) {
			$messagepagearr = pregmessage($messagemsgtext, $messagepagerule, 'pagearea');
		}
		if($debugprocess == 'messagepagerule') {
			$infoarr = array(
					'code'	=>	$messagepagearr[0],
					'url'	=>	$newurlarr[0],
					'rule'	=>	$messagepagerule,
					'source'	=>	$messagemsgtext
			);
			printruledebug($infoarr);
		}	//$messagepagearr[0]	识别出来的文章内容分页区域
		
		//文章内容分页链接识别规则
		$pageurlarr = array();
		$messagepageurlrule = $this->_post('messagepageurlrule');
		$messagepageurlrule = !empty($messagepageurlrule) ? sstripslashes(trim($messagepageurlrule)) : '';
		if(!empty($messagepageurlrule)) {
			$urlarr = pregmessage($messagepagearr[0], $messagepageurlrule, 'page', -1);		//解析上步过虑后的结果
			$pageurlarr = sarray_unique($urlarr);	//去重
		}
		if($debugprocess == 'messagepageurlrule') {
			$infoarr = array(
					'code'	=>	$pageurlarr,
					'url'	=>	$newurlarr[0],
					'rule'	=>	$messagepageurlrule,
					'source'	=>	$messagepagearr[0]
			);
			printruledebug($infoarr);
		}	//$pageurlarr 链接数组
		
		//文章内容分页链接URL补充前缀
		if($debugprocess == 'messagepageurllinkpre') {
			$newurlarrtmp = implode("\n", $pageurlarr);
			showprogress('文章内容分页链接URL补充前缀"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$messagepageurllinkpre = $this->_post('messagepageurllinkpre');
		$messagepageurllinkpre = !empty($messagepageurllinkpre) ? sstripslashes(trim($messagepageurllinkpre)) : '';
		
		if(!empty($messagepageurllinkpre)) {
			foreach ($pageurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					if(strpos($tmpvalue, '://') === false) {
						$pageurlarr[$tmpkey] = $messagepageurllinkpre.$tmpvalue;
					} elseif(strpos($tmpvalue, '://')>10) {
						$pageurlarr[$tmpkey] = $messagepageurllinkpre.$tmpvalue;
					}
				}
			}
		} else {
			$url = array();
			$posturl = parse_url($newurlarr[0]);
			foreach ($pageurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					$url = parse_url($tmpvalue);
					if(!empty($url['host'])){
						$pageurlarr[$tmpkey] = $tmpvalue;
					} else {
						$offset = strpos($tmpvalue, '/');
						if(!is_bool($offset) && $offset == 0){
							$pageurlarr[$tmpkey] = $posturl['scheme'].'://'.$posturl['host'].$tmpvalue;
						} else {
							$pageurlarr[$tmpkey] = substr($newurlarr[0], 0, strrpos($newurlarr[0], '/')).'/'.$tmpvalue;
						}
					}
				}
			}
		}
		if($debugprocess == 'messagepageurllinkpre') {
			$newurlarrtmp = implode("\n", $pageurlarr);
			showprogress('文章内容分页链接URL补充前缀"后"链接为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$pageurlarr 链接数组
		
		//其他开始///////////////////////////////////////////////////////////////////////////////////////////
		//信息来源识别规则
		if($debugprocess == 'fromrule') {
			$fromrule = $this->_post('fromrule');
			$fromrule = !empty($fromrule) ? sstripslashes(trim($fromrule)) : '';
			if(empty($fromrule)) {
				showprogress('信息来源识别规则未设置', 1);
				exit();
			}
			$fromarr = array();
			if(preg_match("/\[from\]/", $fromrule)) {
				$fromarr = pregmessage($messagemsgtext, $fromrule, 'from');
			} else {
				$fromarr[0] = $fromrule;
			}
		
			if(preg_match("/\[from\]/", $fromrule)) {
				$infoarr = array(
						'code'	=>	$fromarr[0],
						'url'	=>	$newurlarr[0],
						'rule'	=>	$fromrule,
						'source'	=>	$messagemsgtext
				);
				printruledebug($infoarr);
			} else {
				showprogress('信息来源固定值', 1);
				showprogress(shtmlspecialchars($fromarr[0]));
			}
			//$fromarr[0]	识别出来的来源
		}
		
		
		//作者识别规则
		if($debugprocess == 'authorrule') {
			$authorrule = $this->_post('authorrule');
			$authorrule = !empty($authorrule) ? sstripslashes(trim($authorrule)) : '';
			if(empty($authorrule)) {
				showprogress('作者识别规则未设置', 1);
				exit();
			}
			$authorarr = array();
			if(preg_match("/\[author\]/", $authorrule)) {
				$authorarr = pregmessage($messagemsgtext, $authorrule, 'author');
			} else {
				$tmpauthorrule = explode('|', $authorrule);
				$tmpauthorrule = strim($tmpauthorrule);
				if(is_array($tmpauthorrule)) {
					foreach($tmpauthorrule as $tmpkey => $tmpvalue) {
						if(empty($tmpvalue)) {
							unset($tmpauthorrule[$tmpkey]);
						}
					}
					$tmprand = 0;
					$tmprand = rand(0, count($tmpauthorrule)-1);
					$authorarr[0] = $tmpauthorrule[$tmprand];
				} else {
					$authorarr[0] = $tmpauthorrule;
				}
			}
			if(preg_match("/\[author\]/", $_POST['authorrule'])) {
				$infoarr = array(
						'code'	=>	$authorarr[0],
						'url'	=>	$newurlarr[0],
						'rule'	=>	$authorrule,
						'source'	=>	$messagemsgtext
				);
				printruledebug($infoarr);
			} else {
				showprogress('作者固定值', 1);
				showprogress(shtmlspecialchars($authorarr[0]));
			}
			//$authorarr[0]	识别出来的作者
		}
		
		//发布者UID
		if($debugprocess == 'uidrule') {
			$uidrule = $this->_post('uidrule');
			$uidrule = !empty($uidrule) ? sstripslashes(trim($uidrule)) : '';
			if(empty($uidrule)) {
				showprogress('发布者UID未设置', 1);
				exit();
			}
			$uidarr = array();
			$tmpuidrule = explode('|', $uidrule);
			$tmpuidrule = strim($tmpuidrule);
			if(is_array($tmpuidrule)) {
				foreach($tmpuidrule as $tmpkey => $tmpvalue) {
					if(empty($tmpvalue)) {
						unset($tmpuidrule[$tmpkey]);
					}
				}
				$tmprand = 0;
				$tmprand = rand(0, count($tmpuidrule)-1);
				$uidarr[0] = $tmpuidrule[$tmprand];
			} else {
				$uidarr[0] = $tmpuidrule;
			}
			showprogress('发布者UID随机抽取值', 1);
			showprogress(shtmlspecialchars($uidarr[0]));
		}
		exit();

	}
	////////////////////////////////////////////////////////////////////////////////
	function geturlfile($url, $encode=1) {
		$text = '';
		if(!empty($url)) {
			if(function_exists('file_get_contents')) {
				@$text = file_get_contents($url);
			} else {
				@$carr = file($url);
				if(!empty($carr) && is_array($carr)) {
					$text = implode('',$carr);
				}
			}
		}
		$text = str_replace('·', '', $text);
		if(!empty($this->$thevalue['encode']) && $encode == 1) {
			if(function_exists('iconv')) {
				$text = iconv($this->$thevalue['encode'], C('ik_charset'), $text);
			} else {
				$text = encodeconvert($this->$thevalue['encode'], $text);
			}
		}
		return $text;
	}
}