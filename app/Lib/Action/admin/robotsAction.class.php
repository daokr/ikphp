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
	public function publish(){
		
		$postlisturl = serialize(array('manual'=>$_POST['listurl_manual'], 'auto'=>$_POST['listurl_auto']));
		$_POST['autotype'] = !empty($_POST['autotype']) && intval($_POST['autotype']) == 2 ? 2 : 1;
		if(empty($_POST['name'])) $this->error("采集器名称不能为空");
		$_POST['subjectreplace'] = !empty($_POST['subjectreplace']) ? implode("\n", $_POST['subjectreplace']) : '';
		$_POST['subjectreplaceto'] = !empty($_POST['subjectreplaceto']) ? implode("\n", $_POST['subjectreplaceto']) : '';
		$_POST['messagereplace'] = !empty($_POST['messagereplace']) ? implode("\n", $_POST['messagereplace']) : '';
		$_POST['messagereplaceto'] = !empty($_POST['messagereplaceto']) ? implode("\n", $_POST['messagereplaceto']) : '';
		$catarr = explode('_', $_POST['import']); //导入的目录
		
		$setsqlarr = array(
				'name' => $_POST['name'],
				'dateline' => $_SGLOBAL['timestamp'],
				'listurltype'=> 'new',
				'listurl' => $postlisturl,
				'listpagestart' => $_POST['listpagestart'],
				'listpageend' => $_POST['listpageend'],
				'allnum' => $_POST['allnum'],
				'pernum' => $_POST['pernum'],
				'importcatid' => intval($catarr[1]),  //目录id
				'importtype' => $catarr[0],
				'reverseorder' => intval($_POST['reverseorder']), //文章倒序采集 0 否 1是
				'encode' => $_POST['encode'],
				'savepic' => $_POST['savepic'], //保存内容中的图片到本地
				'saveflash' => $_POST['saveflash'],
				'subjecturlrule' => striptbr($_POST['subjecturlrule']),
				'subjecturllinkrule' => striptbr($_POST['subjecturllinkrule']),
				'subjecturllinkpre' => $_POST['subjecturllinkpre'],
				'subjectrule' => striptbr($_POST['subjectrule']),
				'subjectfilter' => striptbr($_POST['subjectfilter']),
				'subjectreplace' => $_POST['subjectreplace'],
				'subjectreplaceto' => $_POST['subjectreplaceto'],
				'subjectkey' => $_POST['subjectkey'],
				'subjectallowrepeat' => $_POST['subjectallowrepeat'],
				'datelinerule' => striptbr($_POST['datelinerule']),
				'fromrule' => striptbr($_POST['fromrule']),
				'authorrule' => striptbr($_POST['authorrule']),
				'messagerule' => striptbr($_POST['messagerule']),
				'messagefilter' => striptbr($_POST['messagefilter']),
				'messagepagetype' => $_POST['messagepagetype'],
				'messagepagerule' => striptbr($_POST['messagepagerule']),
				'messagepageurlrule' => striptbr($_POST['messagepageurlrule']),
				'messagepageurllinkpre' => $_POST['messagepageurllinkpre'],
				'messagereplace' => $_POST['messagereplace'],
				'messagereplaceto' => $_POST['messagereplaceto'],
				'picurllinkpre' => $_POST['picurllinkpre'],
				'autotype' => $_POST['autotype'],
				'wildcardlen' => $_POST['autotype'] == 1 ? $_POST['wildcardlen'] : '',
				'subjecturllinkcancel' => striptbr($_POST['subjecturllinkcancel']),
				'subjecturllinkfilter' => striptbr($_POST['subjecturllinkfilter']),
				'subjecturllinkpf' => $_POST['subjecturllinkpf'],
				'subjectkeycancel' => $_POST['subjectkeycancel'],
				'messagekey' => $_POST['messagekey'],
				'messagekeycancel' => $_POST['messagekeycancel'],
				'messageformat' => $_POST['messageformat'],
				'messagepageurllinkpf' => $_POST['messagepageurllinkpf'],
				'uidrule' => shtmlspecialchars($_POST['uidrule']), //发布者UID
				'defaultdateline' =>  empty($_POST['defaultdateline']) ? time() : sstrtotime($_POST['defaultdateline'])
				);
		
				//对于新增的采集器与编辑的采集器的分别处理
				if(empty($_POST['robotid'])) {
					$robotid = 0;
					$setsqlarr['uid'] = $_SESSION ['ikadmin']['userid'];
					$robotid = aac('robots') -> create('robots', $setsqlarr);
					updaterobot($robotid);	//更新采集器缓存
					$this->redirect ( 'robots/list');
				} else {
					//UPDATE
					$wheresqlarr = array(
							'robotid' => $_POST['robotid']
					);
					aac('robots') -> update('robots', $wheresqlarr, $setsqlarr);
					updaterobot($_POST['robotid']);	//更新采集器缓存
					$this->redirect ( 'robots/list');
				}
	}
	// 添加
	public function add_robot(){
		//添加新采集器初始值
		$thevalue = array(
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
		$this->assign ( 'thevalue', $thevalue );
		$this->display('add_robot');
	}
	// 调试
	public function debug_robot(){
		
		//采集器编辑调试用
		@ini_set ( 'max_execution_time', 2000 ); //设置超时时间
		//初始化
		$_POST ['listurl_manual'] = ! empty ( $_POST ['listurl_manual'] ) && is_array ( $_POST ['listurl_manual'] ) ? $_POST ['listurl_manual'] : array ();
		$_POST ['debugurl'] = ! empty ( $_POST ['debugurl'] ) ? trim ( $_POST ['debugurl'] ) : '';
		
		//start
		$listurlarr = $listurlarr2 = $infoarr = array (); //初始采集页面数组
		$output = '';
		$sourcehtml = '';
		$sourcecharset = '';
		$rule = '';
		$i = $urlorder = 0;
		
		//对采集数组进行整理
		if (empty ( $_POST ['debugurl'] )) {
			if(!empty($_POST['listurl_auto'])) {
				$_POST['autotype'] = !empty($_POST['autotype']) && intval($_POST['autotype']) == 2 ? 2 : 1;
				$_POST['listpagestart'] = !empty($_POST['autotype']) && $_POST['autotype'] == 1? intval($_POST['listpagestart']) : ord($_POST['listpagestart']);
				$_POST['listpageend'] = !empty($_POST['autotype']) && $_POST['autotype'] == 1? intval($_POST['listpageend']) : ord($_POST['listpageend']);
				$_POST['wildcardlen'] = !empty($_POST['wildcardlen']) ? intval($_POST['wildcardlen']) : 0;
				if($_POST['listpagestart'] > $_POST['listpageend']) {
					$urlorder = $_POST['listpagestart'];
					$_POST['listpagestart'] = $_POST['listpageend'];
					$_POST['listpageend'] = $urlorder;
					$urlorder = 1;
				}
				for($i = $_POST['listpagestart']; $i <= $_POST['listpageend']; $i++) {
					$strreplace = $i;
					if(!empty($_POST['wildcardlen']) && $_POST['autotype'] == 1) {
						$strreplace = str_pad($i, $_POST['wildcardlen'], 0, STR_PAD_LEFT);
					} elseif($_POST['autotype'] == 2) {
						$strreplace = chr($i);
					}
					if($_POST['autotype'] == 1 || ($_POST['autotype'] == 2 && preg_match("/[a-z]/i", $strreplace))) {
						$listurlarr2[] = preg_replace("/\[page\]/", $strreplace, $_POST['listurl_auto']);
					}
				}
				if($urlorder == 1) krsort($listurlarr2);//对数组按照键名逆向排序
					
			}
			if (! empty ( $_POST ['listurl_manual'] )) {
				$listurlarr = $_POST ['listurl_manual'];
			}
			if ($urlorder == 0) {
				$listurlarr = array_merge ( $listurlarr, $listurlarr2 );
			} else {
				$listurlarr = array_merge ( $listurlarr2, $listurlarr );
			}
		
		} else {
				
			$listurlarr [] = $_POST ['debugurl'];
		}
		
		if (empty ( $listurlarr )) {
			showprogress ( "没有连接地址", 1 ); //无连接
			exit ();
		}
		
		//开始调试
		if (empty ( $_POST ['debugurl'] ) || in_array ( $_POST ['debugprocess'], array ('showlisturl', 'pinglisturl', 'charset', 'subjecturlrule',
				'subjecturllinkrule', 'subjecturllinkcancel', 'subjecturllinkfilter', 'subjecturllinkpre', 'subjecturllinkpf' ) )) {
				//测试：显示链接
		if($_POST['debugprocess'] == 'showlisturl') {
			showprogress ( "链接列表", 1 );
			if($i >= 1000) {
				showprogress ( "由于链接列表大于1000条,程序调试程序只显示头1000条数据." );
			}
			$output = implode("<br />\n", $listurlarr);
			showprogress($output);
			exit();
		}
		//测试：尝试连接
		if($_POST['debugprocess'] == 'pinglisturl') {
			$i = 0;
			showprogress ( "链接列表", 1 );
			foreach($listurlarr as $tmpvalue) {
				$sourcehtml = geturlfile($tmpvalue, 0);
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
		if($_POST['debugprocess'] == 'charset')
		{
			$sourcehtml = geturlfile($listurlarr[0], 0);	//读取网页
			if(empty($sourcehtml)) {
				showprogress("无法读取到内容", 1);
				exit();
			}
			showprogress('被采集页面的编码', 1);
			preg_match_all("/\<meta[^\<\>]+charset=([^\<\>\"\'\s]+)[^\<\>]*\>/i", $sourcehtml, $temp, PREG_SET_ORDER);
			$sourcecharset = !empty($temp) ? trim(strtoupper($temp[0][1])) : '';//转化成大写
			if(!empty($sourcecharset)) {
				showprogress('被采集页面的编码:'.$sourcecharset);
				showprogress('您的网站编码为:'.$_SCONFIG['charset']);
				showprogress('如果两个编码相同无需进行设置.', 1);
			} else {
				showprogress($listurlarr[0].'没有识别出页面编码,请进行人工识别.');
			}
		
			exit();
		}
			
		//编码设置
		$sourcecharset = !empty($_POST['encode']) ? trim($_POST['encode']) : '';
		if(empty($sourcecharset)) {
			showprogress('采集页面编码未设置,系统不进行转码工作.如果调试区域为乱码时,请您设置"采集页面编码".', 1);
		}
		//开始读页面
		$listurlarr[0] = encodeconvert($sourcecharset, $listurlarr[0], 1);
		
		$sourcehtml = geturlfile($listurlarr[0], 0);	//读取网页
		if(empty($sourcehtml)) {
			showprogress($listurlarr[0].'无法读取页面', 1);
			exit();
		}
			
		$sourcehtml = encodeconvert($sourcecharset, $sourcehtml);
		
		//列表区域识别规则测试
		$_POST['subjecturlrule'] = !empty($_POST['subjecturlrule']) ? sstripslashes(trim($_POST['subjecturlrule'])) : '';
		if(empty($_POST['subjecturlrule'])) {
			showprogress('列表区域识别规则未设置,程序将自动识别"列表区域",此种方法会产生一定误差.', 1);
			$subjecturlarr[0] = $sourcehtml;
		} else {
			$subjecturlarr = pregmessage($sourcehtml, $_POST['subjecturlrule'], 'list');	//解析列表区域
		}
		
		if($_POST['debugprocess'] == 'subjecturlrule') {
			$infoarr = array(
					'code'	=>	$subjecturlarr[0],
					'url'	=>	$listurlarr[0],
					'rule'	=>	$_POST['subjecturlrule'],
					'source'	=>	$sourcehtml
			);
			printruledebug($infoarr);
		}	//$subjecturlarr[0]	识别出来的内容
			
		if(empty($subjecturlarr[0])) {
			showprogress('没识别出任何内容,请检查"列表区域识别规则"', 1);
			exit();
		}
		
		//文章链接URL识别规则
		$_POST['subjecturllinkrule'] = !empty($_POST['subjecturllinkrule']) ? sstripslashes(trim($_POST['subjecturllinkrule'])) : '';
		$newurlarr = array();
		if(empty($_POST['subjecturllinkrule'])) {
			showprogress('文章链接URL识别规则未设置,程序将自动识别"列表区域"所有链接,此种方法会产生一定误差.', 1);
			$subjecturlarr[0] = preg_replace(array("/[\n\r]+/", "/\<\/a\>/i", "/\<a/i") , array('', "</a>\n", "\n<a"), $subjecturlarr[0]);
			preg_match_all("/\<a.+href=('|\"|)?([^\s\<\>]*)(\\1)([\s].*)?\>(.*)\<\/a\>/i", $subjecturlarr[0], $ahreftemp);
			$newurlarr = sarray_unique($ahreftemp[2]);	//去重
		} else {
			$urlarr = pregmessage($subjecturlarr[0], $_POST['subjecturllinkrule'], 'url', -1);		//解析上步过虑后的结果
			$newurlarr = sarray_unique($urlarr);	//去重
		}
		if($_POST['debugprocess'] == 'subjecturllinkrule') {
			$infoarr = array(
					'code'	=>	$newurlarr,
					'url'	=>	$listurlarr[0],
					'rule'	=>	$_POST['subjecturllinkrule'],
					'source'	=>	$subjecturlarr[0]
			);
			printruledebug($infoarr);
		}	//$newurlarr 链接数组
		if(empty($newurlarr)) {
			showprogress('文章链接URL识别规则未设置,程序将自动识别"列表区域"所有链接,此种方法会产生一定误差.', 1);
			exit();
		}
			
		//文章链接URL剔除规则
		$_POST['subjecturllinkcancel'] = !empty($_POST['subjecturllinkcancel']) ? sstripslashes(trim($_POST['subjecturllinkcancel'])) : '';
		if($_POST['debugprocess'] == 'subjecturllinkcancel') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL剔除"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		if(!empty($_POST['subjecturllinkcancel'])) {
			$urlarr = $newurlarr;
			$newurlarr = array();
			$rule = '('.convertrule($_POST['subjecturllinkcancel']).')';
			foreach($urlarr as $tmpvalue) {
				if(!preg_match("/$rule/i", $tmpvalue)) {
					$newurlarr[] = $tmpvalue;
				}
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkcancel') {
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
		$_POST['subjecturllinkfilter'] = !empty($_POST['subjecturllinkfilter']) ? sstripslashes(trim($_POST['subjecturllinkfilter'])) : '';
		if($_POST['debugprocess'] == 'subjecturllinkfilter') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL过滤"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		if(!empty($_POST['subjecturllinkfilter'])) {
			$urlarr = $newurlarr;
			$newurlarr = array();
			$rule = '('.convertrule($_POST['subjecturllinkfilter']).')';
			foreach($urlarr as $tmpvalue) {
				$newurlarr[] = trim(preg_replace("/$rule/s", '', $tmpvalue));
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkfilter') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL过滤"后"链接为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($_POST['subjecturllinkfilter']).')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$newurlarr 链接数组
		if(empty($newurlarr)) {
			showprogress( '文章链接URL过滤后没链接' , 1);
			exit();
		}
		
		//文章链接URL补充前缀
		if($_POST['debugprocess'] == 'subjecturllinkpre') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL补充前缀"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$_POST['subjecturllinkpre'] = !empty($_POST['subjecturllinkpre']) ? sstripslashes(trim($_POST['subjecturllinkpre'])) : '';
		if(!empty($_POST['subjecturllinkpre'])) {
			foreach ($newurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					if(strpos($tmpvalue, '://') === false) {
						$newurlarr[$tmpkey] = $_POST['subjecturllinkpre'].$tmpvalue;
					} elseif(strpos($tmpvalue, '://')>10) {
						$newurlarr[$tmpkey] = $_POST['subjecturllinkpre'].$tmpvalue;
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
		if($_POST['debugprocess'] == 'subjecturllinkpre') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL补充前缀"后"链接为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$newurlarr 链接数组
			
		//文章链接URL补充后缀
		if($_POST['debugprocess'] == 'subjecturllinkpf') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL补充后缀"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$_POST['subjecturllinkpf'] = !empty($_POST['subjecturllinkpf']) ? sstripslashes(trim($_POST['subjecturllinkpf'])) : '';
		if(!empty($_POST['subjecturllinkpf'])) {
			foreach ($newurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					$newurlarr[$tmpkey] = $tmpvalue.$_POST['subjecturllinkpf'];
				}
			}
		}
		if($_POST['debugprocess'] == 'subjecturllinkpf') {
			$newurlarrtmp = implode("\n", $newurlarr);
			showprogress('文章链接URL补充后缀"后"链接为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$newurlarr 链接数组
		
		}else {
				
			$newurlarr[0] = $_POST['debugurl'];
		}
		
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
		$messagemsgtext = geturlfile($newurlarr[0], 0);	//读取网页
		$messagemsgtext = encodeconvert($sourcecharset, $messagemsgtext);
		if(empty($messagemsgtext)) {
			showprogress('无法读取'.' '.$newurlarr[0], 1);
			exit();
		}
		//文章标题识别规则
		$_POST['subjectrule'] = !empty($_POST['subjectrule']) ? sstripslashes(trim($_POST['subjectrule'])) : '';
		if(empty($_POST['subjectrule'])) {
			showprogress('文章标题识别规则未设置', 1);
			exit();
		}
		$subjectarr = array();
		$subjectarr = pregmessage($messagemsgtext, $_POST['subjectrule'], 'subject');
		if($_POST['debugprocess'] == 'subjectrule') {
			$infoarr = array(
					'code'	=>	$subjectarr[0],
					'url'	=>	$newurlarr[0],
					'rule'	=>	$_POST['subjectrule'],
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
		$_POST['subjectfilter'] = !empty($_POST['subjectfilter']) ? sstripslashes(trim($_POST['subjectfilter'])) : '';
		if(!empty($_POST['subjectfilter'])) {
			$rule = '('.convertrule($_POST['subjectfilter']).')';
			$subjectarr[0] = trim(preg_replace("/$rule/s", '', $subjectarr[0]));
		}
		
		if($_POST['debugprocess'] == 'subjectfilter') {
			showprogress('文章标题过滤后为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($_POST['subjectfilter']).')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//$subjectarr[0] 标题
		
		if(empty($subjectarr[0])) {
			showprogress('文章标题过滤后没有内容', 1);
			exit();
		}
		
		//文章标题文字替换
		if($_POST['debugprocess'] == 'subjectreplace') {
			showprogress('文章标题文字替换"前"为：', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
		}
		$_POST['subjectreplace'] = !empty($_POST['subjectreplace']) ? sstripslashes(strim($_POST['subjectreplace'])) : '';
		$_POST['subjectreplaceto'] = !empty($_POST['subjectreplaceto']) ? sstripslashes(strim($_POST['subjectreplaceto'])) : '';
		if(!empty($_POST['subjectreplace'])) {
			$subjectarr[0] = stringreplace($_POST['subjectreplace'], $_POST['subjectreplaceto'], $subjectarr[0]);
		}
		if($_POST['debugprocess'] == 'subjectreplace') {
			showprogress('文章标题文字替换"后"为：', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$subjectarr[0].'</textarea>');
			exit();
		}	//$subjectarr[0] 标题
		
		//文章标题包含关键字
		$_POST['subjectkey'] = !empty($_POST['subjectkey']) ? sstripslashes(trim($_POST['subjectkey'])) : '';
		if($_POST['debugprocess'] == 'subjectkey') {
			$newsubject = '';
			showprogress('文章标题', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$subjectarr[0].'">');
			$rule = convertrule($_POST['subjectkey']);
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
		$_POST['subjectkeycancel'] = !empty($_POST['subjectkeycancel']) ? sstripslashes(trim($_POST['subjectkeycancel'])) : '';
		if($_POST['debugprocess'] == 'subjectkeycancel') {
			$newsubject = '';
			showprogress('文章标题', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$subjectarr[0].'">');
			$rule = convertrule($_POST['subjectkeycancel']);
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
		
		
		//标题结束
		//内容开始
		//文章内容识别规则
		$messagearr = array();
		$_POST['messagerule'] = !empty($_POST['messagerule']) ? sstripslashes(trim($_POST['messagerule'])) : '';
		if(empty($_POST['messagerule'])) {
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
		
		//文章内容过滤规则
		if($_POST['debugprocess'] == 'messagefilter') {
			showprogress('文章内容过滤"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($_POST['messagefilter']).')');
		}
		$_POST['messagefilter'] = !empty($_POST['messagefilter']) ? sstripslashes(trim($_POST['messagefilter'])) : '';
		if(!empty($_POST['messagefilter'])) {
			$rule = '('.convertrule($_POST['messagefilter']).')';
			$messagearr[0] = trim(preg_replace("/$rule/s", '', $messagearr[0]));
		}
		if($_POST['debugprocess'] == 'messagefilter') {
			showprogress('文章内容过滤"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = shtmlspecialchars('('.convertrule($_POST['messagefilter']).')');
			showprogress('正则表达式', 1);
			showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
			exit();
		}	//messagefilter[0] 内容
		if(empty($messagearr[0])) {
			showprogress('文章内容过滤后没有内容.', 1);
			exit();
		}
		
		//文章内容文字替换
		if($_POST['debugprocess'] == 'messagereplace') {
			showprogress('文章内容文字替换"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		}
		$_POST['messagereplace'] = !empty($_POST['messagereplace']) ? sstripslashes(strim($_POST['messagereplace'])) : '';
		$_POST['messagereplaceto'] = !empty($_POST['messagereplaceto']) ? sstripslashes(strim($_POST['messagereplaceto'])) : '';
		if(!empty($_POST['subjectreplace'])) {
			$messagearr[0] = stringreplace($_POST['messagereplace'], $_POST['messagereplaceto'], $messagearr[0]);
		}
		if($_POST['debugprocess'] == 'messagereplace') {
			showprogress($_POST['messagereplaceto'].'文章内容文字替换"后"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			exit();
		}	//$messagearr[0] 标题
		
		//文章内容包含关键字
		$_POST['messagekey'] = !empty($_POST['messagekey']) ? sstripslashes(trim($_POST['messagekey'])) : '';
		if($_POST['debugprocess'] == 'messagekey') {
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
		$_POST['messagekeycancel'] = !empty($_POST['messagekeycancel']) ? sstripslashes(trim($_POST['messagekeycancel'])) : '';
		if($_POST['debugprocess'] == 'messagekeycancel') {
			$newsubject = '';
			showprogress('文章内容', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			$rule = convertrule($_POST['messagekeycancel']);
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
		$_POST['messageformat'] = !empty($_POST['messageformat']) ? intval($_POST['messageformat']) : 0;
		if($_POST['debugprocess'] == 'messageformat') {
			showprogress('文章内容格式化前为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
		}
		if(!empty($_POST['messageformat'])) {
			$rsmessagearr = getrobotmessage($messagearr[0], $newurlarr[0]);
			$messagearr[0] = $rsmessagearr['leachmessage'];
		}
		if($_POST['debugprocess'] == 'messageformat') {
			showprogress('文章内容格式化后为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$messagearr[0].'</textarea>');
			exit();
		}
		
		//文章内容分页区域识别规则
		$messagepagearr = array();
		$_POST['messagepagerule'] = !empty($_POST['messagepagerule']) ? sstripslashes(trim($_POST['messagepagerule'])) : '';
		if(!empty($_POST['messagepagerule'])) {
			$messagepagearr = pregmessage($messagemsgtext, $_POST['messagepagerule'], 'pagearea');
		}
		if($_POST['debugprocess'] == 'messagepagerule') {
			$infoarr = array(
					'code'	=>	$messagepagearr[0],
					'url'	=>	$newurlarr[0],
					'rule'	=>	$_POST['messagepagerule'],
					'source'	=>	$messagemsgtext
			);
			printruledebug($infoarr);
		}	//$messagepagearr[0]	识别出来的文章内容分页区域
		
		//文章内容分页链接识别规则
		$pageurlarr = array();
		$_POST['messagepageurlrule'] = !empty($_POST['messagepageurlrule']) ? sstripslashes(trim($_POST['messagepageurlrule'])) : '';
		if(!empty($_POST['messagepageurlrule'])) {
			$urlarr = pregmessage($messagepagearr[0], $_POST['messagepageurlrule'], 'page', -1);		//解析上步过虑后的结果
			$pageurlarr = sarray_unique($urlarr);	//去重
		}
		if($_POST['debugprocess'] == 'messagepageurlrule') {
			$infoarr = array(
					'code'	=>	$pageurlarr,
					'url'	=>	$newurlarr[0],
					'rule'	=>	$_POST['messagepageurlrule'],
					'source'	=>	$messagepagearr[0]
			);
			printruledebug($infoarr);
		}	//$pageurlarr 链接数组
		
		//文章内容分页链接URL补充前缀
		if($_POST['debugprocess'] == 'messagepageurllinkpre') {
			$newurlarrtmp = implode("\n", $pageurlarr);
			showprogress('文章内容分页链接URL补充前缀"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$_POST['messagepageurllinkpre'] = !empty($_POST['messagepageurllinkpre']) ? sstripslashes(trim($_POST['messagepageurllinkpre'])) : '';
		if(!empty($_POST['messagepageurllinkpre'])) {
			foreach ($pageurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					if(strpos($tmpvalue, '://') === false) {
						$pageurlarr[$tmpkey] = $_POST['messagepageurllinkpre'].$tmpvalue;
					} elseif(strpos($tmpvalue, '://')>10) {
						$pageurlarr[$tmpkey] = $_POST['messagepageurllinkpre'].$tmpvalue;
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
		if($_POST['debugprocess'] == 'messagepageurllinkpre') {
			$newurlarrtmp = implode("\n", $pageurlarr);
			showprogress('文章内容分页链接URL补充前缀"后"链接为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$pageurlarr 链接数组
		
		//文章内容分页链接URL补充后缀
		if($_POST['debugprocess'] == 'messagepageurllinkpf') {
			$newurlarrtmp = implode("\n", $pageurlarr);
			showprogress( '文章内容分页链接URL补充后缀"前"为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
		}
		$_POST['messagepageurllinkpf'] = !empty($_POST['messagepageurllinkpf']) ? sstripslashes(trim($_POST['messagepageurllinkpf'])) : '';
		if(!empty($_POST['messagepageurllinkpf'])) {
			foreach ($pageurlarr as $tmpkey => $tmpvalue) {
				if(!empty($tmpvalue)) {
					$pageurlarr[$tmpkey] = $tmpvalue.$_POST['messagepageurllinkpf'];
				}
			}
		}
		if($_POST['debugprocess'] == 'messagepageurllinkpf') {
			$newurlarrtmp = implode("\n", $pageurlarr);
			showprogress('文章内容分页链接URL补充后缀"后"链接为', 1);
			showprogress('<textarea style="width:95%;" rows="7">'.$newurlarrtmp.'</textarea>');
			exit();
		}	//$pageurlarr 链接数组
		
		
		//其他开始
		//信息来源识别规则
		if($_POST['debugprocess'] == 'fromrule') {
			$_POST['fromrule'] = !empty($_POST['fromrule']) ? sstripslashes(trim($_POST['fromrule'])) : '';
			if(empty($_POST['fromrule'])) {
				showprogress('信息来源识别规则未设置', 1);
				exit();
			}
			$fromarr = array();
			if(preg_match("/\[from\]/", $_POST['fromrule'])) {
				$fromarr = pregmessage($messagemsgtext, $_POST['fromrule'], 'from');
			} else {
				$fromarr[0] = $_POST['fromrule'];
			}
		
			if(preg_match("/\[from\]/", $_POST['fromrule'])) {
				$infoarr = array(
						'code'	=>	$fromarr[0],
						'url'	=>	$newurlarr[0],
						'rule'	=>	$_POST['fromrule'],
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
		if($_POST['debugprocess'] == 'authorrule') {
			$_POST['authorrule'] = !empty($_POST['authorrule']) ? sstripslashes(trim($_POST['authorrule'])) : '';
			if(empty($_POST['authorrule'])) {
				showprogress('作者识别规则未设置', 1);
				exit();
			}
			$authorarr = array();
			if(preg_match("/\[author\]/", $_POST['authorrule'])) {
				$authorarr = pregmessage($messagemsgtext, $_POST['authorrule'], 'author');
			} else {
				$tmpauthorrule = explode('|', $_POST['authorrule']);
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
						'rule'	=>	$_POST['authorrule'],
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
		if($_POST['debugprocess'] == 'uidrule') {
			$_POST['uidrule'] = !empty($_POST['uidrule']) ? sstripslashes(trim($_POST['uidrule'])) : '';
			if(empty($_POST['uidrule'])) {
				showprogress('发布者UID未设置', 1);
				exit();
			}
			$uidarr = array();
			$tmpuidrule = explode('|', $_POST['uidrule']);
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
}