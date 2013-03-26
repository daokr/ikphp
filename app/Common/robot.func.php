<?php
function showprogress($message, $title = 0) {
	if ($title) {
		echo '<div class="progress" style="background-color:#D6E0EF;border: 1px solid #698CC3;color: #F40914;font-weight: bold;margin: 0.5em 0;padding: 0.5em; font-size:12px">' . $message . '</div>';
	} else {
		echo '<div style="line-height:20px; font-size:14px;">'.$message . '</div><br>';
	}
}
//转码
function encodeconvert($encode, $content, $to=0) {
	if($to) {
		$in_charset = strtoupper(C('ik_charset'));
		$out_charset = strtoupper($encode);
	} else {
		$in_charset = strtoupper($encode);
		$out_charset = strtoupper(C('ik_charset'));
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
function shtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = shtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
				str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
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