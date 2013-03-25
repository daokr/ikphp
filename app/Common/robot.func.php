<?php
defined('IN_IK') or die('Access Denied.');
//简单跳转的函数
function jumpurl($url, $time=1000, $mode='js') {
	if($mode == 'js') {
		echo "<script>
		function redirect() {
		window.location.replace('$url');
	}
	setTimeout('redirect();', $time);
	</script>";
	} else {
	$time = $time/1000;
	echo "<html><head><title></title><meta http-equiv=\"refresh\" content=\"$time;url=$url\"></head><body></body></html>";
	}
	exit;
}
function getrobotmeg($referurl, $robotlevel=2) {
	global $_SCONFIG;
	
	$searchcursory = array(
		"/\<(script|style|textarea)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<!*(--|doctype|html|head|meta|link|body)[^\>]*?\>/si",
		"/<\/(html|head|meta|link|body)\>/si",
		"/([\r\n])\s+/",
		"/\<(table|div)[^\>]*?\>/si",
		"/\<\/(table|div)\>/si"
	);
	$replacecursory = array(
		"",
		"",
		"",
		 "\\1",
		"\n\n###table div explode###\n\n",
		"\n\n###table div explode###\n\n"
	);
	$searchaborative = array(
		"/\<(iframe)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<[\/\!]*?[^\<\>]*?\>/si",
		"/\t/",
		"/[\r\n]+/",
		"/(^[\r\n]|[\r\n]$)+/",
		"/&(quot|#34);/i",
		"/&(amp|#38);/i",
		"/&(lt|#60);/i",
		"/&(gt|#62);/i",
		"/&(nbsp|#160|\t);/i",
		"/&(iexcl|#161);/i",
		"/&(cent|#162);/i",
		"/&(pound|#163);/i",
		"/&(copy|#169);/i",
		"/&#(\d+);/e"
	);
	$replaceaborative = array(
		"",
		"",
		"",
		"\n",
		"",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)"
	);
	$arrayrobotmeg = array();

	$sourcehtml = sreadfile($referurl, 'r', 1);	//读取网页
	$sourcecharset = postget('charset');
	if(empty($sourcecharset) && $sourcecharset == ''){
		preg_match_all("/\<meta[^\<\>]+charset=([^\<\>\"\'\s]+)[^\<\>]*\>/i", $sourcehtml, $temp, PREG_SET_ORDER);
		$sourcecharset = isset($temp) && !empty($temp) ? trim(strtoupper($temp[0][1])) : $_SCONFIG['charset'];
	}
	
	$sourcehtml = encodeconvert($sourcecharset, $sourcehtml);

	$sourcetext = getimageurl($referurl, preg_replace($searchcursory, $replacecursory, $sourcehtml));
	if($robotlevel == 1) {
		$leachsubject = '';
		preg_match_all("/\<title[^\>]*?\>(.*)\<\/title\>/is", $sourcetext, $temp, PREG_SET_ORDER);
		$leachsubject = $temp[0][1];
		$sourcetext = preg_replace("/\n\n###table div explode###\n\n/", '', $sourcetext);
		$leachmessage = preg_replace("/[\r\n]+/", '<br />', preg_replace($searchaborative, $replaceaborative, $sourcetext));
	} elseif($robotlevel == 2) {
		$arraysource = explode("\n\n###table div explode###\n\n", $sourcetext);
		
		$arraycell = array();
		foreach($arraysource as $value) {
			$cell = array(
				'code'	=>	$value,
				'text'	=>	preg_replace("/[\n\r\s]*?/is", "", preg_replace ($searchaborative, $replaceaborative, $value)),
				'pr'	=>	0,
				'title'	=>	'',
				'process'	=>''
			);
		
			if($cell['text'] != '') {
				$arraycell[] = getpr($cell, $searchaborative, $replaceaborative);
			}
		}
	
		$arraysubject = $arraymessage = array();
		$leachsubject = $leachmessage = '';
		foreach($arraycell as $value) {
			if($value['title'] == 'title') {
				$arraysubject[] = $value;
			} elseif($value['pr'] >= 0) {
				$arraymessage[] = $value['code'];
			}
		}
	
		$pr = '';
		foreach($arraysubject as $value) {
			if($pr < $value['pr'] || empty($pr)) {
				$leachsubject = $value['text'];
			}
			$pr = $value['pr'];
		}
		
		$leachmessage = preg_replace("/\<(p|br)[^\>]*?\>/si", "\n", implode("\n", $arraymessage));
		$arraymessage = explode("\n", preg_replace($searchaborative, $replaceaborative, $leachmessage));

		$leachmessage = '';
		foreach($arraymessage as $value) {
			if(trim($value) != '') {
				$leachmessage .= "<p>\t" . trim($value) . "</p>";
			}
		}
	}

	$arrayrobotmeg['leachsubject'] = $leachsubject;
	$arrayrobotmeg['leachmessage'] = $leachmessage;
	$arrayrobotmeg['charset'] = $sourcecharset;

	return $arrayrobotmeg;
}

function getimageurl($referurl, $subject) {
	preg_match_all("/<img.+src=('|\"|)?(.*)(\\1)([\s].*)?>/ismUe", $subject, $temp, PREG_SET_ORDER);

	$offset = '';
	$url = $imagereplace = array();
	$posturl = parse_url($referurl);
	if(is_array($temp) && !empty($temp)) {
		foreach($temp as $tempvalue) {
			$url = parse_url(str_replace('\"', '', $tempvalue[2]));
			$imagereplace['oldimageurl'][] = $tempvalue[0];
			if(isset($url['host']) && !empty($url['host'])){
				$imagereplace['newimageurl'][] = '&lt;img src="' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
			} else {
				$offset = strpos($tempvalue[2], '/');
				if(!is_bool($offset) && $offset == 0){
					$imagereplace['newimageurl'][] = '&lt;img src="' . $posturl['scheme'] . '://' . $posturl['host'] . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				} else {
					$imagereplace['newimageurl'][] = '&lt;img src="' . substr($referurl, 0, strrpos($referurl, '/')) . '/' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				}
			}
		}
	}

	return str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $subject);
}

//获得PR值
function getpr($arraycell, $searchaborative, $replaceaborative) {
	$htmltags = array(
		array('title', 5),
		array('a', -1),
		array('iframe', -2),
		array('p', 1),
		array('li', -1),
		array('input', -0.1),
		array('select', -3),
		array('form', -0.1)
	);

	if(strlen($arraycell['text']) > 10) {
		if(strlen($arraycell['text']) > 200) {
			$arraycell['pr'] += 2;
		}

		foreach($htmltags as $tagsvalue) {
			$temp = array();
			preg_match_all("/\<$tagsvalue[0][^\>]*?\>/is", $arraycell['code'], $temp, PREG_SET_ORDER);
			$tagsnum = count($temp);

			$temp = array();
			if($tagsvalue[0] == 'title' && $tagsnum > 0) {
				$arraycell['title'] = 'title';
			} elseif($tagsvalue[0] == 'a' && $tagsnum > 0) {
				preg_match_all("/\<a[^\>]*?\>(.*?)\<\/a>/is", $arraycell['code'], $temp);
				$temp[2] = preg_replace("/[\n\r\s]*?/is", '', preg_replace ($searchaborative, $replaceaborative, implode('', $temp[1])));
				$ahretnum = strlen($temp[2]) / strlen($arraycell['text']);
				$tagsnum *= $ahretnum * 10;
			}

			$arraycell['pr'] += $tagsnum * $tagsvalue[1];
		}
	} else {
		$arraycell['pr'] -= 10;
	}

	if($arraycell['pr'] >= 0) {
		$g1 = preg_replace("/\<(p|br)[^\>]*?\>/si", "\n\n###p br explode###\n\n", $arraycell['code']);
		$arrayg1 = explode("\n\n###p br explode###\n\n", $g1);

		preg_match_all("/\n\n###p br explode###\n\n/is", $g1, $g4, PREG_SET_ORDER);

		if(count($g4) > 2) {
			$g3 = 0;
			foreach($arrayg1 as $value) {
				$g2 = preg_replace("/[\n\r\s]*?/is", "", preg_replace ($searchaborative, $replaceaborative, $value));

				if($g2 != '') {
					$g2num = strlen($g2);
					if($g2num <= 25) {
						$g3--;
					} elseif($g2num > 70 ) {
						$g3 = 10;
						continue;
					}
					else {
						$g3++;
					}
				}
			}
			
			if($g3 < 0) {
				$arraycell['pr'] += $g3;
			}
		}
	}

	return $arraycell;
}

function showrobotmsg($message, $type='error') {
	$message = addcslashes($message, '"');
	
	if(empty($message)) {
		$typestr = 'msg.style.display = "none";
					msgok.style.display = "none";';
	} else {
		if($type == 'ok') {
			$typestr = 'msg.style.display = "none";
						msgok.style.display = "";
						msgok.innerHTML = "'.$message.'";
						';
		} else {
			$typestr = 'msg.style.display = "";
						msgok.style.display = "none";
						msg.innerHTML =  "'.$message.'";
						';
		}
	}

	print <<<END
	<script language="javascript">
	<!--
	var msg = parent.document.getElementById("divshowrobotmsg");
	var msgok = parent.document.getElementById("divshowrobotmsgok");
	var pf = parent.document.getElementById("phpframe");
	pf.src = "about:blank";
	$typestr
	//-->
	</script>
END;
	exit;
}

function getrobotmessage($sourcehtml, $referurl, $robotlevel=1) {
	global $_SCONFIG;
	
	$searchcursory = array(
		"/\<(script|style|textarea)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<!*(--|doctype|html|head|meta|link|body)[^\>]*?\>/si",
		"/<\/(html|head|meta|link|body)\>/si",
		"/([\r\n])\s+/",
		"/\<(table|div)[^\>]*?\>/si",
		"/\<\/(table|div)\>/si"
	);
	$replacecursory = array(
		"",
		"",
		"",
		 "\\1",
		"\n\n###table div explode###\n\n",
		"\n\n###table div explode###\n\n"
	);
	$searchaborative = array(
		"/\<(iframe)[^\>]*?\>.*?\<\/(\\1)\>/si",
		"/\<[\/\!]*?[^\<\>]*?\>/si",
		"/\t/",
		"/[\r\n]+/",
		"/(^[\r\n]|[\r\n]$)+/",
		"/&(quot|#34);/i",
		"/&(amp|#38);/i",
		"/&(lt|#60);/i",
		"/&(gt|#62);/i",
		"/&(nbsp|#160|\t);/i",
		"/&(iexcl|#161);/i",
		"/&(cent|#162);/i",
		"/&(pound|#163);/i",
		"/&(copy|#169);/i",
		"/&#(\d+);/e"
	);
	$replaceaborative = array(
		"",
		"",
		"",
		"\n",
		"",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)"
	);
	$arrayrobotmeg = array();
	$sourcetext = replaceimageurl($referurl, preg_replace($searchcursory, $replacecursory, $sourcehtml));

	$arraysource = explode("\n\n###table div explode###\n\n", $sourcetext);
	$arraycell = array();
	foreach($arraysource as $value) {
		$cell = array(
			'code'	=>	$value,
			'text'	=>	preg_replace("/[\n\r\s]*?/is", "", preg_replace ($searchaborative, $replaceaborative, $value)),
			'pr'	=>	0,
			'title'	=>	'',
			'process'	=>''
		);
		if($cell['text'] != '') {
			if($robotlevel == 2) {
				$arraycell[] = getpr($cell, $searchaborative, $replaceaborative);
			} else {
				$arraycell[] = $cell;
			}
		}
	}

	$arraysubject = $arraymessage = array();
	$leachsubject = $leachmessage = '';
	foreach($arraycell as $value) {
		if($value['title'] == 'title') {
			$arraysubject[] = $value;
		} elseif($value['pr'] >= 0) {
			$arraymessage[] = $value['code'];
		}
	}

	$pr = '';
	foreach($arraysubject as $value) {
		if($pr < $value['pr'] || empty($pr)) {
			$leachsubject = $value['text'];
		}
		$pr = $value['pr'];
	}
	$leachmessage = preg_replace("/\<(p|br)[^\>]*?\>/si", "\n", implode("\n", $arraymessage));
	$arraymessage = explode("\n", preg_replace($searchaborative, $replaceaborative, $leachmessage));
	$leachmessage = '';
	foreach($arraymessage as $value) {
		if(trim($value) != '') {
			$leachmessage .= "<p>" . trim($value) . "</p>\n";
		}
	}

	$arrayrobotmeg['leachsubject'] = $leachsubject;
	$arrayrobotmeg['leachmessage'] = $leachmessage;
	return $arrayrobotmeg;
}

function replaceimageurl($referurl, $subject) {
	preg_match_all("/<img.+src=('|\"|)?(.*)(\\1)([\s].*)?>/ismUe", $subject, $temp, PREG_SET_ORDER);

	$offset = '';
	$url = $imagereplace = array();
	$posturl = parse_url($referurl);
	if(is_array($temp) && !empty($temp)) {
		foreach($temp as $tempvalue) {
			$url = parse_url(str_replace('\"', '', $tempvalue[2]));
			$imagereplace['oldimageurl'][] = $tempvalue[0];
			if(isset($url['host']) && !empty($url['host'])){
				$imagereplace['newimageurl'][] = '&lt;img src="' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
			} else {
				$offset = strpos($tempvalue[2], '/');
				if(!is_bool($offset) && $offset == 0){
					$imagereplace['newimageurl'][] = '&lt;img src="' . $posturl['scheme'] . '://' . $posturl['host'] . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				} else {
					$imagereplace['newimageurl'][] = '&lt;img src="' . substr($referurl, 0, strrpos($referurl, '/')) . '/' . str_replace('\"', '', $tempvalue[2]) . '"&gt;';
				}
			}
		}
	}

	return str_replace($imagereplace['oldimageurl'], $imagereplace['newimageurl'], $subject);
}



//br 替换
function striptbr($text) {
	$text = preg_replace("/(\r\n|\r|\n)/s", '*', $text);
	$text = str_replace('**', '*', $text);
	return $text;
}
//FUNCTION
function showprogress($message, $title = 0) {
	if ($title) {
		echo '<div class="progress" style="background-color:#D6E0EF;border: 1px solid #698CC3;color: #F40914;font-weight: bold;margin: 0.5em 0;padding: 0.5em; font-size:12px">' . $message . '</div>';
	} else {
		echo '<div style="line-height:20px; font-size:14px;">'.$message . '</div><br>';
	}
}
function geturlfile($url, $encode=1) {
	global $thevalue, $_SCONFIG;

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
	if(!empty($thevalue['encode']) && $encode == 1) {
		if(function_exists('iconv')) {
			$text = iconv($thevalue['encode'], $_SCONFIG['charset'], $text);
		} else {
			$text = encodeconvert($thevalue['encode'], $text);
		}
	}
	return $text;
}
//转码
function encodeconvert($encode, $content, $to=0) {
	global $_SCONFIG;
	if($to) {
		$in_charset = strtoupper($_SCONFIG['charset']);
		$out_charset = strtoupper($encode);
	} else {
		$in_charset = strtoupper($encode);
		$out_charset = strtoupper($_SCONFIG['charset']);
	}
	if(!empty($encode) && $in_charset != $out_charset) {
		if (function_exists('iconv') && (@$outstr = iconv("$in_charset//IGNORE", "$out_charset//IGNORE", $content))) {
			$content = $outstr;
		} elseif (function_exists('mb_convert_encoding') && (@$outstr = mb_convert_encoding($content, $out_charset, $in_charset))) {
			$content = $outstr;
		}
	}
	return $content;
}


function printruledebug($infoarr) {
	$rule = '';
	if(is_array($infoarr['code'])) {
		$infoarr['code'] = implode("\n", $infoarr['code']);
	}
	if(!empty($infoarr['code'])) {
		showprogress('识别后有内容,区域源码', 1);
		showprogress('<textarea style="width:95%;" rows="7">'.$infoarr['code'].'</textarea>');
	} else {
		showprogress('没识别出任何内容,请检查识别规则', 1);
	}
	$rule = shtmlspecialchars(getregularstring($infoarr['rule'], 'from'));
	showprogress('测试网页地址', 1);
	showprogress('<input type="text" style="width: 95%" value="'.$infoarr['url'].'">');
	showprogress('正则表达式', 1);
	showprogress('<input type="text" style="width: 95%" value="'.$rule.'">');
	showprogress('网页源码', 1);
	showprogress('<textarea style="width:95%;" rows="7">'.shtmlspecialchars($infoarr['source']).'</textarea>');
	exit();
}
/**
 * 正则规则
 */
function getregularstring($rule, $getstr) {
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	return $rule;
}
/**
 * 转义正则表达式字符串
 */
function convertrule($rule) {
	$rule = preg_quote($rule, "/");		//转义正则表达式
	$rule = str_replace('\*', '.*?', $rule);
	$rule = str_replace('\|', '|', $rule);
	return $rule;
}
//替换字符串中的特殊字符
//去掉指定字符串中\\或\'前的\
function sstripslashes($string) {

	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = sstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}
/**
 * 解析内容
 */
function pregmessage($message, $rule, $getstr, $limit=1) {
	$result = array('0'=>'');
	$rule = convertrule($rule);		//转义正则表达式特殊字符串
	$rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule);	//解析为正则表达式
	if($limit == 1) {
		preg_match("/$rule/is", $message, $rarr);
		if(!empty($rarr[1])) {
			$result[0] = $rarr[1];
		}
	} else {
		preg_match_all("/$rule/is", $message, $rarr);
		if(!empty($rarr[1])) {
			$result = $rarr[1];
		}
	}
	return $result;
}
//去掉数组中重复值
function sarray_unique($array) {
	$newarray = array();
	if(!empty($array) && is_array($array)) {
		$array = array_unique($array);
		foreach ($array as $value) {
			$newarray[] = $value;
		}
	}
	return $newarray;
}
//去除空格
function strim($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = strim($val);
		}
	} else {
		$string = trim($string);
	}
	return $string;
}
//按规则替换
function stringreplace($replace, $replaceto, $message) {
	if(is_array($replace)) {
		foreach($replace as $key => $val) {
			$message = stringreplace($val, $replaceto[$key], $message);
		}
	} else {
		if(!empty($replace)) {
			$rule = convertrule($replace);
			if(strpos($replaceto, '[string]') === false) {
				$replacestr = $replaceto;
			} else {
				$replacestr = str_replace('[string]', "\${1}", $replaceto);
			}
			$message = preg_replace("/($rule)/s", $replacestr, $message);
		}
	}
	return $message;
}

function sstrtotime($timestamp) {
	global $_SCONFIG;

	$timestamp = trim($timestamp);
	if(empty($timestamp)) return 0;
	$hour = $minute = $second = $month = $day = $year = 0;
	$exparr = $timearr = array();
	if(strpos($timestamp, ' ') !== false && strpos($timestamp, '-') !== false) {
		$timearr = explode(' ', $timestamp);
		$exparr = explode('-', $timearr[0]);
		$year = empty($exparr[0])?0:intval($exparr[0]);
		$month = empty($exparr[1])?0:intval($exparr[1]);
		$day = empty($exparr[2])?0:intval($exparr[2]);
		$exparr = explode(':', $timearr[1]);
		$hour = empty($exparr[0])?0:intval($exparr[0]);
		$minute = empty($exparr[1])?0:intval($exparr[1]);
		$second = empty($exparr[2])?0:intval($exparr[2]);
	} elseif(strpos($timestamp, '-') !== false && strpos($timestamp, ' ') === false) {
		$exparr = explode('-', $timestamp);
		$year = empty($exparr[0])?0:intval($exparr[0]);
		$month = empty($exparr[1])?0:intval($exparr[1]);
		$day = empty($exparr[2])?0:intval($exparr[2]);
	} elseif(!strpos($timestamp, '-') === false && strpos($timestamp, ' ') !== false) {
		$exparr = explode(':', $timestamp);
		$hour = empty($exparr[0])?0:intval($exparr[0]);
		$minute = empty($exparr[1])?0:intval($exparr[1]);
		$second = empty($exparr[2])?0:intval($exparr[2]);
	} else {
		return 0;
	}
	return gmmktime($hour, $minute, $second, $month, $day, $year) - $_SGLOBAL['timezone'] * 3600;
}

/**
 * 获取或生成采集地址
 */
function cacherobotlist($type, $url, $robotid, $sarray=array(), $varname='newurlarr') {

	$cachefile = IKDATA.'/robot/'.$robotid.'_'.md5($url).'.php';
	
	if($type == 'get') {
		if(file_exists($cachefile)) {
			include_once($cachefile);
			showprogress('<font color=green>列表缓存文件成功读取'.' ('.srealpath($cachefile).')</font>', 1);	//srealpath是格式化URL地址
			return $$varname;
		} else {
			return false;
		}
	} else {
		$wtext = arrayeval($sarray);
		if(!@$fp = fopen($cachefile, 'w')) {
			showprogress('列表缓存文件无法写入'.' ('.srealpath($cachefile).')', 1);	//缓存无法写入
		} else {
			$text = "<?php\n\n";
			$text .= '$'.$varname.'=';
			$text .= $wtext;
			$text .= "\n\n?>";
			flock($fp, 2);
			fwrite($fp, $text);
			fclose($fp);
			showprogress('<font color=green>列表缓存文件成功写入'.' ('.srealpath($cachefile).')</font>', 1);
		}
	}

}


/**
 * 采集器方法 存入数据库
 */
function messageaddtodb($msgarr, $robotid, $itemid=0) {
	global $_SGLOBAL;
	$filepath = IKDATA.'/robot/robot_'.$robotid.'.cache.php';
	@include_once($filepath);

	if(!$itemid) { 
		$uid = empty($msgarr['uid']) ? $_SGLOBAL['admin_uid'] : $msgarr['uid'];
		$username = empty($cacheinfo['uids'][$msgarr['uid']]) ? $_SGLOBAL['admin_username'] : $cacheinfo['uids'][$msgarr['uid']];
		//判断是否直接入库操作
		if(empty($msgarr['importcatid'])) {
				echo '没有指定栏目';
		/* 
			$insertsqlarr = array(
				'uid' => $uid,
				'username' => saddslashes($username),
				'robotid' => $robotid,
				'robottime' => $_SGLOBAL['timestamp'],
				'subject' => saddslashes($msgarr['subject'])
			);
			if(!empty($msgarr['itemfrom'])) $insertsqlarr['itemfrom'] = saddslashes($msgarr['itemfrom']);
			if(!empty($msgarr['author'])) $insertsqlarr['author'] = saddslashes($msgarr['author']);
			if(!empty($msgarr['dateline'])) $insertsqlarr['dateline'] = $msgarr['dateline'];
			if(!empty($msgarr['patharr'])) $insertsqlarr['haveattach'] = 1;
			$itemid = inserttable('robotitems', $insertsqlarr, 1);
		 */} else{

				if($msgarr['importtype']=='album') {
				 	//相册
					$hashstr = smd5($_SGLOBAL['admin_uid'].'/'.rand(1000, 9999).$_SGLOBAL['timestamp']);
					$arrpath = explode('/', $msgarr['patharr'][0]['filepath']);
					for($i=0; $i<count($arrpath)-1; $i++)
					{
						$path .= $arrpath[$i].'/'; 
					}
					
				    $path = substr($path, 0,strlen($path)-1);
					$insertsqlarr = array(
						'albumid' => $msgarr['importcatid'],
						'userid' => $uid,
						'addtime' => $msgarr['dateline'],
						'hash' => $hashstr,
						//'photodesc' => saddslashes($msgarr['subject']),
						'photoname' => $msgarr['patharr'][0]['filename'],
						'phototype' => $msgarr['patharr'][0]['attachtype'],
						'photosize' => $msgarr['patharr'][0]['size'],
						'path' => $path,
					    'photourl' => $msgarr['patharr'][0]['filepath'],
					);
					
					//入库
					$itemid = aac('photo')->create('photo', $insertsqlarr);
					//开始上传图片
						
									
				}else{
					//文章
					$hashstr = smd5($_SGLOBAL['admin_uid'].'/'.rand(1000, 9999).$_SGLOBAL['timestamp']);
					$insertsqlarr = array(
							'catid' => $msgarr['importcatid'],
							'uid' => $uid,
							'username' => saddslashes($username),
							'type' => $msgarr['importtype'],
							'subject' => saddslashes($msgarr['subject']),
							'dateline' => $msgarr['dateline'],
							'lastpost' => $msgarr['dateline'],
							'hash' => $hashstr,
							'fromtype' => 'robotpost',
							'fromid' => $robotid,
							'haveattach' => (!empty($msgarr['patharr'])?1:0)
					);
					//入库
					$itemid = aac('robots')->create('article_spaceitems', $insertsqlarr);			
				}				
				
		}
		$hash = md5($msgarr['subject']);
		$_SGLOBAL['db']->query('REPLACE INTO '.dbprefix.'robotlog'." (hash) VALUES ('$hash')");	//插入起防重复操作
	}

	//INSERT MESSAGE
	if(empty($msgarr['importcatid'])) {/* 
		$insertsqlarr = array(
			'itemid' => $itemid,
			'robotid' => $robotid
		);
		if(!empty($msgarr['message'])) $insertsqlarr['message'] = saddslashes($msgarr['message']);
		if(!empty($msgarr['picarr'])) $insertsqlarr['picurls'] = saddslashes(serialize($msgarr['picarr']));
		if(!empty($msgarr['flasharr'])) $insertsqlarr['flashurls'] = saddslashes(serialize($msgarr['flasharr']));
		inserttable('robotmessages', $insertsqlarr, 0, 1);
	 */} else {
		
		if($msgarr['importtype']!='album') {
			
				$insertsqlarr = array(
					'itemid' => $itemid,
					'message' => saddslashes($msgarr['message']),
					'newsauthor' => saddslashes($msgarr['author']),
					'newsfrom' => saddslashes($msgarr['itemfrom'])
				);
				
				aac('robots')->create('article_spacenews', $insertsqlarr);
					
		}

	}

	//如果附件不为空 并且导入的是 文章不是相册
	if(!empty($msgarr['patharr']) && $msgarr['importtype']!='album') {
		
		$attacharr['hash'] = 'R'.$robotid.'I'.$itemid;
		$thevalue = array();
		if(empty($msgarr['importcatid'])) {
			//暂时不用
			//$query = $_SGLOBAL['db']->query("SELECT haveattach, uid FROM ".tname('robotitems')." WHERE itemid='$itemid'");
		} else {
			$thevalue = aac('robots')->find('article_spaceitems',array('itemid'=>$itemid),'haveattach, hash, uid');
		}
		
		//如果没有hash则插入
		if(!empty($thevalue['hash'])) {
			$attacharr['hash'] = $thevalue['hash'];
		}
		$uid = $thevalue['uid'];
		$insertkeysql = $comma = '';
		$insertvaluesql = '(';
		foreach ($msgarr['patharr'] as $key => $value) {
			$value['hash'] = $attacharr['hash'];
			$value['uid'] = $uid;
			$value['itemid'] = empty($msgarr['importcatid'])?0:$itemid;
			foreach($value as $insert_key => $insert_value) {
				if($key == 0) {
					$insertkeysql .= $comma.$insert_key;
				}
				$insertvaluesql .= $comma.'\''.$insert_value.'\'';
				$comma = ', ';
			}

			if(count($msgarr['patharr'])-1 > $key) {
				$insertvaluesql .= '), (';
				$comma = '';
			}
		}
		$insertvaluesql .= ')';


		$_SGLOBAL['db']->query('INSERT INTO '.dbprefix.'attachments'.' ('.$insertkeysql.') VALUES '.$insertvaluesql);
		
		if(isset($thevalue['hash'])) {
			
			$attvalue = aac('robots')->find('attachments',array('itemid'=>$itemid,'isimage'=>'1'),'aid');
			//更新
			aac('robots')->update('article_spaceitems',array('itemid'=>$itemid),array('haveattach'=>'1','picid'=>$attvalue[aid]));
			
		}
	}
	return $itemid;
}

//正则表达式匹配 简析抓取
function pregmessagearray($messagetext, $rulearr, $mnum, $getpage=0, $getsubject=0, $msgurl='') {
	global $_SGLOBAL, $alang;
	
	if($getsubject) $mnum = $mnum+1;
	$msgarr = array(
		'subject' => '',
		'dateline' => '',
		'itemfrom' => '',
		'author' => '',
		'message' => '',
		'importcatid' => $rulearr['importcatid'],
		'importtype' => $rulearr['importtype'],
		'pagearr' => array(),
		'picarr' => array(),
		'flasharr' => array(),
		'patharr' => array()
	);
	$nextprogress = true;

	//文章标题识别
	if($getsubject && $messagetext && !empty($rulearr['subjectrule'])) {
		$subjectarr = pregmessage($messagetext, $rulearr['subjectrule'], 'subject');
		$msgarr['subject'] = $subjectarr[0];
	}
	//文章标题过滤
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectfilter'])) {
		$rule = convertrule($rulearr['subjectfilter']);
		$msgarr['subject'] = preg_replace("/($rule)/s", '', $msgarr['subject']);
	}
	//文章标题文字替换
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectreplace'])) {
		$rulearr['subjectreplace'] = explode("\n", $rulearr['subjectreplace']);
		$rulearr['subjectreplaceto'] = explode("\n", $rulearr['subjectreplaceto']);
		$msgarr['subject'] = stringreplace($rulearr['subjectreplace'], $rulearr['subjectreplaceto'], $msgarr['subject']);
	}
	//文章标题包含关键字
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectkey'])) {
		$rule = convertrule($rulearr['subjectkey']);
		$newsubject = preg_replace("/($rule)/s", '', $msgarr['subject']);
		if($newsubject == $msgarr['subject']) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' 标题不包含关键字，跳过');
			$nextprogress = false;
			$msgarr['subject'] = '';
		}					
	}
	//文章标题关键字剔除过滤
	if($getsubject && $msgarr['subject'] && !empty($rulearr['subjectkeycancel'])) {
		$rule = convertrule($rulearr['subjectkeycancel']);
		$newsubject = preg_replace("/($rule)/s", '', $msgarr['subject']);
		if($newsubject != $msgarr['subject']) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' 标题包含关键字，跳过');
			$nextprogress = false;
			$msgarr['subject'] = '';
		}				
	}
	$msgarr['subject'] = trim($msgarr['subject']);

	if($getsubject && $nextprogress && empty($msgarr['subject']) && $msgarr['importtype']!='album') {
		showprogress('['.$mnum.'] 标题经处理后为空，跳过');
		$nextprogress = false;
	}
	if($getsubject && $nextprogress && !$rulearr['subjectallowrepeat']) {
		$query = $_SGLOBAL['db']->query('SELECT COUNT(*) FROM '.tname('robotlog').' WHERE hash=\''.md5($msgarr['subject']).'\'');
		if($_SGLOBAL['db']->result($query, 0)) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' 文章已经存在，跳过');
			$nextprogress = false;
		}
	}
	if($nextprogress && $getsubject && $msgarr['subject']) {
		showprogress('<font color=green>['.$mnum.'] ['.$msgarr['subject'].'] 处理标题成功</font>');
	}
	if(!$nextprogress) {
		$msgarr['subject'] = '';
	}
	
	//DATELINE
	if(empty($rulearr['defaultdateline'])) {
		$msgarr['dateline'] = $_SGLOBAL['timestamp'];
	} else {
		$msgarr['dateline'] = intval($rulearr['defaultdateline']);
	}
	
	//信息来源识别
	if($getsubject && $nextprogress && !empty($rulearr['fromrule'])) {
		if(preg_match("/\[from\]/", $rulearr['fromrule'])) {
			$fromarr = pregmessage($messagetext, $rulearr['fromrule'], 'from');
		} else {
			$fromarr[0] = $rulearr['fromrule'];
		}
		$msgarr['itemfrom'] = $fromarr[0];
		if($msgarr['itemfrom']) {
			showprogress('<font color=green>['.$mnum.'] ['.$msgarr['itemfrom'].'] 处理文章来源成功</font>');
		} else {
			showprogress('<font color=red>['.$mnum.'] 处理文章来源失败</font>');
		}
	}
	//作者识别
	if($getsubject && $nextprogress && !empty($rulearr['authorrule'])) {
		if(preg_match("/\[author\]/", $rulearr['authorrule'])) {
			$authorarr = pregmessage($messagetext, $rulearr['authorrule'], 'author');
		} else {
			$rulearr['authorrule'] = explode('|', $rulearr['authorrule']);
			$rulearr['authorrule'] = strim($rulearr['authorrule']);
			if(is_array($rulearr['authorrule'])) {
				foreach($rulearr['authorrule'] as $tmpkey => $tmpvalue) {
					if(empty($tmpvalue)) {
						unset($rulearr['authorrule'][$tmpkey]);
					}
				}
				$tmprand = 0;
				$tmprand = rand(0, count($rulearr['authorrule'])-1);
				$authorarr[0] = $rulearr['authorrule'][$tmprand];
			} else {
				$authorarr[0] = $rulearr['authorrule'];
			}
		}
		$msgarr['author'] = $authorarr[0];
		if($msgarr['author']) {
			showprogress('<font color=green>['.$mnum.'] ['.$msgarr['author'].'] 处理作者成功</font>');
		} else {
			showprogress('<font color=red>['.$mnum.'] 处理作者失败</font>');
		}
	}
	//发布者UID
	if($getsubject && $nextprogress && !empty($rulearr['uidrule'])) {
		$rulearr['uidrule'] = explode('|', $rulearr['uidrule']);
		$rulearr['uidrule'] = strim($rulearr['uidrule']);
		if(is_array($rulearr['uidrule'])) {
			foreach($rulearr['uidrule'] as $tmpkey => $tmpvalue) {
				if(empty($tmpvalue)) {
					unset($rulearr['uidrule'][$tmpkey]);
				}
			}
			$tmprand = 0;
			$tmprand = rand(0, count($rulearr['uidrule'])-1);
			$msgarr['uid'] = intval($rulearr['uidrule'][$tmprand]);
		} else {
			$msgarr['uid'] = intval($rulearr['uidrule']);
		}
	}
	
	//文章内容识别
	if($nextprogress && !empty($rulearr['messagerule'])) {
		if(empty($rulearr['messagerule'])) {
			$rsmessagearr = getrobotmessage($messagetext, $msgurl, 2);
			$messagearr[0] = $rsmessagearr['leachmessage'];
		} else {
			$messagearr = pregmessage($messagetext, $rulearr['messagerule'], 'message');
		}
		$msgarr['message'] = $messagearr[0];
	}
	//文章内容过滤
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagefilter'])) {
		$rule = convertrule($rulearr['messagefilter']);
		$msgarr['message'] = preg_replace("/($rule)/s", '', $msgarr['message']);
	}
	//文章内容文字替换
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagereplace'])) {
		$rulearr['messagereplace'] = explode("\n", $rulearr['messagereplace']);
		$rulearr['messagereplaceto'] = explode("\n", $rulearr['messagereplaceto']);
		$msgarr['message'] = stringreplace($rulearr['messagereplace'], $rulearr['messagereplaceto'], $msgarr['message']);
	}
	//文章内容包含关键字
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagekey'])) {
		$rule = convertrule($rulearr['messagekey']);
		$newmessage = preg_replace("/($rule)/s", '', $msgarr['message']);
		if($newmessage == $msgarr['message']) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' 内容不包含关键字，跳过');
			$nextprogress = false;
			$msgarr['message'] = '';
		}					
	}
	//文章内容关键字剔除过滤
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messagekeycancel'])) {
		$rule = convertrule($rulearr['messagekeycancel']);
		$newmessage = preg_replace("/($rule)/s", '', $msgarr['message']);
		if(md5($newmessage) != md5($msgarr['message'])) {
			showprogress('['.$mnum.'] '.$msgarr['subject'].' 内容包含关键字，跳过');
			$nextprogress = false;
			$msgarr['message'] = '';
		}					
	}
	//文章内容格式化
	if($nextprogress && $msgarr['message'] && !empty($rulearr['messageformat'])) {
		$rsmessagearr = getrobotmessage($msgarr['message'], $msgurl);
		$msgarr['message'] = $rsmessagearr['leachmessage'];
	}
	
	if($nextprogress) {
		if($msgarr['message']) {
			showprogress('<font color=green>['.$mnum.'] 处理内容成功</font>');
		} else {
			$msgarr['subject'] = '';
			$nextprogress = false;
			showprogress('<font color=red>['.$mnum.'] 处理内容失败</font>');
		}
	}
	
	//LOCAL PIC URL
	if($nextprogress && (!empty($rulearr['picurllinkpre']) || $rulearr['savepic'])) {
		preg_match_all("/\<img\s+.*?src=[\'\"]*([a-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+)[\'\"\s\>]+/is", $msgarr['message'], $picurlarr);
		if(!empty($picurlarr[1])) $msgarr['picarr'] = sarray_unique($picurlarr[1]);
		if(!empty($rulearr['picurllinkpre'])) {
			foreach($msgarr['picarr'] as $pickey => $picurl) {
				if(strpos($picurl, '://') === false) {
					$msgarr['picarr'][$pickey] = $rulearr['picurllinkpre'].$picurl;
					$msgarr['message'] = str_replace($picurl, $rulearr['picurllinkpre'].$picurl, $msgarr['message']);
				}
			}
		} else {
			$url = array();
			$posturl = parse_url($msgurl);
			foreach ($msgarr['picarr'] as $pickey => $picurl) {
				if(!empty($picurl)) {
					$url = parse_url($picurl);
					if(!empty($url['host'])){
						$msgarr['picarr'][$pickey] = $picurl;
					} else {
						$offset = strpos($picurl, '/');
						if(!is_bool($offset) && $offset == 0){
							$msgarr['picarr'][$pickey] = $posturl['scheme'].'://'.$posturl['host'].$picurl;
						} else {
							$msgarr['picarr'][$pickey] = substr($msgurl, 0, strrpos($msgurl, '/')).'/'.$picurl;
						}
					}
					$msgarr['message'] = str_replace($picurl, $msgarr['picarr'][$pickey], $msgarr['message']);
				}
			}
		}
		if($rulearr['savepic']) {
			$msgarr = saveurlarr($msgarr, 'picarr');
			showprogress('<font color=green>['.$mnum.'] '.'处理图片链接成功！</font>');
		}
	}
	
	//LOCAL FLASH URL
	if($nextprogress && (!empty($rulearr['picurllinkpre']) || $rulearr['saveflash'])) {/* 
		preg_match_all("/\<embed\s+.*?src=[\'\"]*([a-z0-9\/\-_+=.~!%@?#%&;:$\\()|])[\'\"\s\>]+/is", $msgarr['message'], $flashurlarr);
		if(!empty($flashurlarr[1])) $msgarr['flasharr'] = sarray_unique($flashurlarr[1]);
		if(!empty($rulearr['picurllinkpre'])) {
			foreach($msgarr['flasharr'] as $flashkey => $flashurl) {
				if(strpos($flashurl, '://') === false) {
					$msgarr['flasharr'][$flashkey] = $rulearr['picurllinkpre'].$flashurl;
					$msgarr['message'] = str_replace($flashurl, $rulearr['picurllinkpre'].$flashurl, $msgarr['message']);
				}
			}
		} else {
			$url = array();
			$posturl = parse_url($msgurl);
			foreach ($msgarr['flasharr'] as $flashkey => $flashurl) {
				if(!empty($flashurl)) {
					$url = parse_url($flashurl);
					if(!empty($url['host'])){
						$msgarr['flasharr'][$flashkey] = $flashurl;
					} else {
						$offset = strpos($flashurl, '/');
						if(!is_bool($offset) && $offset == 0){
							$msgarr['flasharr'][$flashkey] = $posturl['scheme'].'://'.$posturl['host'].$flashurl;
						} else {
							$msgarr['flasharr'][$flashkey] = substr($msgurl, 0, strrpos($msgurl, '/')).'/'.$flashurl;
						}
					}
					$msgarr['message'] = str_replace($flashurl, $msgarr['flasharr'][$flashkey], $msgarr['message']);
				}
			}
		}
		if($rulearr['saveflash']) {
			$msgarr = saveurlarr($msgarr, 'flasharr');
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_flasharr'].'</b>'.$alang['robot_robot_success']);
		}
	 */}

	//PAGE URL
	if($getpage && $nextprogress && !empty($rulearr['messagepagerule'])) {/* 
		$messagepagearr = pregmessage($messagetext, $rulearr['messagepagerule'], 'pagearea');
		$messagepage = $messagepagearr[0];
		if($messagepage && !empty($rulearr['messagepageurlrule'])) {
			$msgarr['pagearr'] = pregmessage($messagepage, $rulearr['messagepageurlrule'], 'page', -1);
			$msgarr['pagearr'] = sarray_unique($msgarr['pagearr']);
		}
		if($msgarr['pagearr']) {
			if(!empty($rulearr['messagepageurllinkpre'])) {
				foreach($msgarr['pagearr'] as $pkey => $purl) {
					if(strpos($purl, '://') === false) {
						$msgarr['pagearr'][$pkey] = $rulearr['messagepageurllinkpre'].$purl;
					}
				}
			} else {
				$url = array();
				$posturl = parse_url($msgurl);
				foreach($msgarr['pagearr'] as $pkey => $purl) {
					if(!empty($purl)) {
						$url = parse_url($purl);
						if(!empty($url['host'])){
							$msgarr['pagearr'][$pkey] = $purl;
						} else {
							$offset = strpos($purl, '/');
							if(!is_bool($offset) && $offset == 0){
								$msgarr['pagearr'][$pkey] = $posturl['scheme'].'://'.$posturl['host'].$purl;
							} else {
								$msgarr['pagearr'][$pkey] = substr($msgurl, 0, strrpos($msgurl, '/')).'/'.$purl;
							}
						}
					}
				}
			}
			if(!empty($rulearr['messagepageurllinkpf'])) {
				foreach ($msgarr['pagearr'] as $pkey => $purl) {
					if(!empty($purl)) {
						$msgarr['pagearr'][$pkey] = $purl.$rulearr['messagepageurllinkpf'];
					}
				}
			}
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_pagearr'].'</b>'.$alang['robot_robot_success']);
		} else {
			showprogress('['.$mnum.'] '.$alang['robot_robot_deal'].'<b>'.$alang['robot_robot_pagearr'].'</b>'.$alang['robot_robot_failed']);
		}
	 */}
	return $msgarr;
}
function saveurlarr($msgarr, $varname) {
	global $_SGLOBAL;
	global $thevalue, $_SCONFIG;

	include_once(IKCORE.'/function/IKUpload.php');
	$isimage = 0;
	if($varname == 'picarr') {
		$isimage = 1; 
	}
	
	if(!empty($msgarr[$varname]) && is_array($msgarr[$varname])) {	
	
		foreach ($msgarr[$varname] as $ukey => $url) {
			//保存图片
			if($isimage) {
				
				$patharr = saveremotefile($url, $_SCONFIG['thumbarray']['news']);
				 
			} else {
				$patharr = saveremotefile($url, array(), 0);
			}
			$subject = strtolower(trim(substr($patharr['name'], 0, strrpos($patharr['name'], '.'))));
			$msgarr['patharr'][] = array(
					'uid' => $_SGLOBAL['admin_uid'],
					'dateline' => $_SGLOBAL['timestamp'],
					'catid' => $msgarr['importcatid'],
					'itemid' => 0,
					'filename' => saddslashes($patharr['name']),
					'subject' => trim(shtmlspecialchars($subject)),
					'attachtype' => $patharr['type'],
					'type' => $msgarr['importtype'],//news
					'isimage' => (in_array($patharr['type'], array('jpg','jpeg','gif','png'))?1:0),
					'size' => $patharr['size'],
					'filepath' => $patharr['file'],
					'thumbpath' => $patharr['thumb'],
					'isavailable' => 1,
					'hash' => ''
			);
			if(!empty($patharr['file'])) {
				
				$msgarr['message'] = str_replace($url, ATT_URL.'/'.$patharr['file'], $msgarr['message']);
				$msgarr[$varname][$ukey] = str_replace($url, IKUPLOADPATH.'/'.$patharr['file'], $msgarr[$varname][$ukey]);

			}
		} 
	}
	return $msgarr;
}
?>