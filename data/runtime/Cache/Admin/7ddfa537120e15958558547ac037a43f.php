<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="160780470@qq.com" />
<meta name="Copyright" content="<?php echo ($ikphp["ikphp_site_name"]); ?>" />
<title><?php echo ($title); ?> - <?php echo ($site_title); ?></title>
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/style.css" />
<script src="__STATIC__/public/js/jquery.js" type="text/javascript"></script>

</head>
<body>

<style>
.midder .maintable { width: 100%; border-collapse: collapse; border: solid; border-color: #86B9D6 #D8DDE5 #D8DDE5; border-width: 2px 1px 1px; }
.midder .maintable th, .maintable td { border: 1px solid #D8DDE5; padding: 5px; }
.midder .maintable th { background: #f8f9fa; width: 210px; text-align: left; color: #336699; font-weight: normal; }
.midder .maintable td th, .midder .maintable td td { border: none; }
.midder .maintable th p { margin: 0; color: #858585; }
.buttons{ text-align:center}
.degbugh3{ display:block; margin:5px 0px}
.colorarea02{ margin-bottom:10px}
.colorarea02 h3{ font-size:12px}
</style>
<script type="text/javascript" src="__STATIC__/public/js/date/WdatePicker.js"></script>
<script language="javascript">
//定义提交地址
function submitForm(obj)
{	
	var addurl = 'index.php?g=admin&m=robots&a=add&ik=publish';
	obj = $(obj);
	if($('#name').val()=='')
	{
		$('#name').focus(); $('#name').after('&nbsp;&nbsp;<font color=red>采集器名称不能为空！</font>');
		return false;
	}else if($('#import').val()==0){
		$('#import').focus(); $('#import').after('&nbsp;&nbsp;<font color=red>你想导入到哪里！</font>');
		return false;
	}else{
		obj.attr('action',addurl);
		return true;
	}
	
}
function insertitem(){
	var val = $.trim($('input[name=url]').val());
	var html = '<div>'+val+' <a href="javascript:;" onclick="$(this).parent().remove()">删除</a><input type="text" id="listurl_manual[]" name="listurl_manual[]" size="5" style="display: none;" value="'+val+'"></div>'	
	if(val!='')
	{
		$('#udiv').append(html);
		$('input[name=url]').val('');
	}
}

var objdebugframe;
function debugsubmit(obj, nodename, process) {
	var debugurl = '',editdoc;
	var allowurlnull = false;	
	if(objdebugframe == null) {
		objdebugframe = $('#tr_debugframe').clone(true); 
	}

	var objnode = $('#'+nodename);

	closedebugframe();
	//插入frame
	objnode.after(objdebugframe);
	editdoc = document.getElementById("debugframe").contentWindow.document;
	editdoc.open('text/html', 'replace');
	editdoc.write('loading...');
	editdoc.close();
	obj.form.target = 'debugframe';
	//跳转地址
	$('#theform').attr('action','index.php?g=admin&m=robots&a=add&ik=debug_robot');	
	
	//$('#f_debugurl').val(debugurl);
	//$('#f_allowurlnull').checked = allowurlnull;
	objsubmit = $('#valuesubmit');
	objsubmit.attr('name','debug');
	obj.form.target = 'debugframe';
	$('#debugurl').val(debugurl);
	$('#debugprocess').val(process); 
	
	obj.form.submit();
	objsubmit.attr('name','valuesubmit');
	obj.form.target = '';
	$('#debugurl').val('');
	$('#debugprocess').val('');
}

function closedebugframe() {
	var objnode = $('#tr_debugframe');
	if(objnode != null) {
		objnode.remove();
	}
}
function inputcheck(obj){
	var obj_listurl_auto = document.getElementById('listurl_auto');
	var obj_listpagestart = document.getElementById('listpagestart');
	var obj_listpageend = document.getElementById('listpageend');
	var obj_str_wc = document.getElementById('str_wc');
	var obj_len = document.getElementById('wildcardlen');
	var str_listpagestart = obj_listpagestart.value;
	var str_listpageend = obj_listpageend.value;
	var str_wc = '';

	if(obj.id != 'listurl_auto'){
		str_replace = /\D+/g; 
		obj.value = obj.value.replace(str_replace, '');
	}
	if(obj_listurl_auto.value.search(/\[page\]/g) >= 0 && obj_listpagestart.value != '' && obj_listpageend.value != ''){
		str_listpagestart = str_pad_left(obj_listpagestart.value, obj_len.value);
		str_listpageend = str_pad_left(obj_listpageend.value, obj_len.value);
		str_wc = obj_listurl_auto.value.replace(/\[page\]/, str_listpagestart) + '<br />......<br />' + obj_listurl_auto.value.replace(/\[page\]/, str_listpageend);
		obj_str_wc.innerHTML = str_wc;
		obj_str_wc.style.display = '';
	} else {
		obj_str_wc.style.display = 'none';
	}
}
function str_pad_left(input, pad_length){
	var pad_length = parseInt(pad_length);
	
	if(pad_length > input.length){
			input = (Math.pow(10, pad_length) + parseInt(input)) + '';
			input = input.substring(1, input);
	}
	return input;
}


function addreplace(str, replace, replaceto) {
	objtd = document.getElementById('td_'+str+'_title');	
}
</script>

<!--main-->
<div class="midder"> 
<h2><?php echo ($title); ?></h2>
<div class="tabnav">
<ul>
     <li class="select"><a href="<?php echo U('robots/add',array('ik'=>'add_robot'));?>">添加机器人</a></li>
     <li><a href="<?php echo U('robots/list');?>">浏览机器人</a></li>
</ul>
</div>
<form method="post" name="thevalueform" id="theform" action=""  enctype="multipart/form-data" onSubmit="return submitForm(this);">
<div class="colorarea02">
  <h3>基本配置</h3>  
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">
  <tbody style="display: none;" id="hiddendebugframe">
    <tr id="tr_debugframe">
      <td colspan="2">
      		<h3 class="degbugh3"><span style="float:right"><a onclick="closedebugframe();" href="javascript:;">关闭</a></span>调试窗口</h3>
      		<iframe width="100%" scrolling="auto" height="300" frameborder="0" src="about:blank" marginwidth="0" name="debugframe" id="debugframe"></iframe>
      </td>
    </tr>
  </tbody>
  <tbody>
    <tr id="tr_name">
      <th>机器人名</th>
      <td><input type="text" value="<?php echo ($thevalue[name]); ?>" size="30" id="name" name="name"></td>
    </tr>   
    <tr id="tr_allnum">
      <th>采集总个数</th>
      <td><input type="text" value="<?php echo ($thevalue[allnum]); ?>" size="10" id="allnum" name="allnum"></td>
    </tr>
    <tr id="tr_pernum">
      <th>单次采集个数
        <p>视网速而定，建议设置小一些，以免超时</p></th>
      <td><input type="text" value="<?php echo ($thevalue[pernum]); ?>" size="10" id="pernum" name="pernum"></td>
    </tr>
    <tr id="tr_import">
      <th>自动导入到
        <p>选择资讯分类，可以直接将采集的结果导入到资讯库中</p></th>
      <td><select name="import" id="import">
          <option value="0">-------</option>
           <?php echo ($arrCate); ?>
          </select></td>
    </tr>
    <tr id="tr_dateline">
      <th>预定义发布时间
        <p>导入资讯分类以后，定义的发布时间</p></th>
      <td><input type="text" readonly="" value="<?php echo ($thevalue[defaultaddtime]); ?>" size="30" id="defaultaddtime" name="defaultaddtime">
        <img src="__STATIC__/admin/images/time.gif" onclick="WdatePicker({el:'defaultaddtime',dateFmt:'yyyy-MM-dd HH:mm:ss'});">&nbsp;<a onclick="$('defaultaddtime').value='';" href="javascript:;">清空</a></td>
    </tr>
  </tbody>
</table>
</div>

<div class="colorarea02">
  <h3>列表页面采集设置</h3>
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">
  <tbody>
    <tr id="tr_robot_listurltype">
      <td width="50%" valign="top"> 手工输入<br>
        <div id="udiv">
        <?php echo ($thevalue[listurl_manual]); ?>
        </div>
        增加新的列表页面链接:
        <input type="text" size="40" name="url" id="url">
        <input type="button" onclick="insertitem();" value="添加">
        <br>
        例如:http://roll.mil.news.sina.com.cn/col/zgjq/index.shtml </td>
      <td width="50%" valign="top"> 自动增长<br>
        URL:
        <input type="text" onblur="inputcheck(this);" value="<?php echo ($thevalue[listurl_auto]); ?>" size="46" id="listurl_auto" name="listurl_auto">
        <br>
        例如: http://www.discuz.net/file_[page].htm<br>
        &nbsp;从:&nbsp;&nbsp;&nbsp;
        <input type="text" onkeyup="inputcheck(this);" maxlength="10" size="4" value="<?php echo ($thevalue[listpagestart]); ?>" name="listpagestart" id="listpagestart">
        &nbsp;&nbsp;到:&nbsp;&nbsp;
        <input type="text" onkeyup="inputcheck(this);" maxlength="10" size="4" value="<?php echo ($thevalue[listpageend]); ?>" name="listpageend" id="listpageend">
        <br>
        <span id="wildcard">通配符长度:&nbsp;&nbsp;
        <input type="text" onkeyup="inputcheck(this);" maxlength="1" size="3" value="<?php echo ($thevalue[wildcardlen]); ?>" name="wildcardlen" id="wildcardlen">
        说明: 长度不足时，前面补0. </span>
        <div style="color: #aaa; display: none" id="str_wc"></div></td>
    </tr>
    <tr id="tr_robot_debug">
      <td align="right" colspan="2"><input type="button" onclick="debugsubmit(this, 'tr_robot_debug', 'showlisturl');" value="测试:显示链接">
        <input type="button" onclick="debugsubmit(this, 'tr_robot_debug', 'pinglisturl');" value="测试:尝试连接"></td>
    </tr>
  </tbody>
</table>
</div>

<div class="colorarea02">
  <h3>列表页面规则</h3>
<table cellspacing="0" cellpadding="0" width="100%" class="maintable">
  <tbody>
    <tr id="tr_reverseorder">
      <th>文章倒序采集
        <p>设为此项后列表中的文章将从最后面的开始采集</p></th>
      <td>
      <?php if($thevalue[reverseorder] == 0): ?><input type="radio" checked="" value="0" name="reverseorder">
        否&nbsp;&nbsp;
        <input type="radio" value="1" name="reverseorder">
        是&nbsp;&nbsp;
      <?php else: ?>
      <input type="radio" value="0" name="reverseorder">
        否&nbsp;&nbsp;
        <input type="radio"  checked="" value="1" name="reverseorder">
        是&nbsp;&nbsp;<?php endif; ?> 
       </td>
    </tr>
    <tr id="tr_encode">
      <th>采集页面编码
        <p>请输入要采集页面的编码。比如：gbk、utf-8、big5。为空则不进行编码转换</p></th>
      <td>
        <input type="text" value="<?php echo ($thevalue[encode]); ?>" size="10" id="encode" name="encode">
        <input type="button" onclick="debugsubmit(this, 'tr_encode', 'charset');" value="程序辅助识别"></td>
    </tr>
    <tr id="tr_subjecturlrule">
      <th>列表区域识别规则
        <p>截取的地方加上
          <input type="input" disabled="disabled" value="[list]" size="10" name="tmp[]">
        </p>
        <p>如&lt;td&gt;文章列表&lt;/td&gt;</p>
        <p>规则就是&lt;td&gt;[list]&lt;/td&gt;</p>
        <p>用 * 来代替任意字符、换行、回车</p></th>
      <td>
        <textarea rows="2" style="width:75%;" name="subjecturlrule" id="subjecturlrule"><?php echo ($thevalue[subjecturlrule]); ?></textarea>
        <input type="button" onclick="debugsubmit(this, 'tr_subjecturlrule', 'subjecturlrule');" value="测试">
        <input type="button" onclick="$('#subjecturlrule').val(''); debugsubmit(this, 'tr_subjecturlrule', 'subjecturlrule');" value="自动识别">
        <br>
        <a onclick="$('subjecturlrule').value='';" href="javascript:;">自动识别</a> ("列表区域识别规则"为空时，程序自动识别"列表区域")</td>
    </tr>
    <tr id="tr_subjecturllinkrule">
      <th>文章链接URL识别规则
        <p>截取的地方加上
          <input type="input" disabled="disabled" value="[url]" size="10" name="tmp[]">
        </p>
        <p>用 * 来代替任意字符、换行、回车</p></th>
      <td><textarea rows="2" style="width:75%;" name="subjecturllinkrule" id="subjecturllinkrule"><?php echo ($thevalue[subjecturllinkrule]); ?></textarea>
        <input type="button" onclick="debugsubmit(this, 'tr_subjecturllinkrule', 'subjecturllinkrule');" value="测试">
        <input type="button" onclick="$('subjecturllinkrule').value=''; debugsubmit(this, 'tr_subjecturllinkrule', 'subjecturllinkrule');" value="自动识别">
        <br>
        <a onclick="$('subjecturllinkrule').value='';" href="javascript:;">自动识别</a> ("文章链接URL识别规则"为空时，程序自动识别"列表区域"所有链接)</td>
    </tr>
    <tr id="tr_subjecturllinkcancel">
      <th>文章链接URL剔除规则
        <p>功能:凡符合规则的链接不进行采集,区分大小写.用 * 来代替任意字符、换行、回车</p>
        <p>多个规则之间用 | 隔开</p></th>
      <td><textarea rows="2" style="width:75%;" name="subjecturllinkcancel" id="subjecturllinkcancel"><?php echo ($thevalue[subjecturllinkcancel]); ?></textarea>
        <input type="button" onclick="debugsubmit(this, 'tr_subjecturllinkcancel', 'subjecturllinkcancel');" value="测试"></td>
    </tr>
    <tr id="tr_subjecturllinkfilter">
      <th>文章链接URL过滤规则
        <p>功能:过滤掉链接中的字符串,可以用来整理链接,区分大小写.用 * 来代替任意字符、换行、回车</p>
        <p>多个规则之间用 | 隔开</p></th>
      <td><textarea rows="2" style="width:75%;" name="subjecturllinkfilter" id="subjecturllinkfilter"><?php echo ($thevalue[subjecturllinkfilter]); ?></textarea>
        <input type="button" onclick="debugsubmit(this, 'tr_subjecturllinkfilter', 'subjecturllinkfilter');" value="测试"></td>
    </tr>
    <tr id="tr_subjecturllinkpre">
      <th>文章链接URL补充前缀</th>
      <td><input type="text" value="<?php echo ($thevalue[subjecturllinkpre]); ?>" size="60" id="subjecturllinkpre" name="subjecturllinkpre" >
        <input type="button" onclick="debugsubmit(this, 'tr_subjecturllinkpre', 'subjecturllinkpre');" value="测试">
        <input type="button" onclick="$('subjecturllinkpre').value=''; debugsubmit(this, 'tr_subjecturllinkpre', 'subjecturllinkpre');" value="自动识别">
        <br>
        <a onclick="$('subjecturllinkpre').value='';" href="javascript:;">自动识别</a> ("文章链接URL补充前缀"为空时，程序自动补充前缀)</td>
    </tr>
    <tr id="tr_subjecturllinkpf">
      <th>文章链接URL补充后缀</th>
      <td><input type="text" value="<?php echo ($thevalue[subjecturllinkpf]); ?>" size="60" id="subjecturllinkpf" name="subjecturllinkpf">
        <input type="button" onclick="debugsubmit(this, 'tr_subjecturllinkpf', 'subjecturllinkpf');" value="测试"></td>
    </tr>
  </tbody>
</table>
</div>

<div class="colorarea02">
  <h3>文章标题设置</h3>
  <table cellspacing="0" cellpadding="0" width="100%" class="maintable">
    <tbody>
      <tr id="tr_subjectrule">
        <th>文章标题识别规则
          <p>截取的地方加上
            <input type="input" disabled="disabled" value="[subject]" size="10" name="tmp[]">
          </p>
          <p>用 * 来代替任意字符、换行、回车</p></th>
        <td><textarea rows="2" style="width:75%;" name="subjectrule" id="subjectrule"><?php echo ($thevalue[subjectrule]); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_subjectrule', 'subjectrule');" value="测试"></td>
      </tr>
      <tr id="tr_subjectfilter">
        <th>文章标题过滤规则
          <p>用 * 来代替任意字符、换行、回车</p>
          <p>多个规则之间用 | 隔开</p></th>
        <td><textarea rows="2" style="width:75%;" name="subjectfilter" id="subjectfilter"><?php echo ($thevalue[subjectfilter]); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_subjectfilter', 'subjectfilter');" value="测试"></td>
      </tr>
      <tr id="tr_subjectreplace_title">
        <th>文章标题文字替换</th>
        <td>
          <div id="td_subjectreplace_title">
            <div id="replace_1"><br>
              替换前的字符
              <input type="text" id="subjectreplace[]" name="subjectreplace[]" size="40">
              <br>
              (多个关键字用 | 隔开，用*代替任意符号。多条替换规则请点击"添加"按钮来创建多条替换规则)<br>
              替换后的字符
              <input type="text" id="subjectreplaceto[]" name="subjectreplaceto[]" size="40">
              <br>
              可以用[string]来表示替换前的字符</div>
          </div>
          <!--<input type="button" onclick="addreplace('subjectreplace', '', '');" value="添加">-->
          <input type="button" onclick="debugsubmit(this, 'tr_subjectreplace_title', 'subjectreplace');" value="测试">
          </td>
      </tr>
      <tr id="tr_subjectkey">
        <th>文章标题包含关键字
          <p>设置该选项后，则只采集标题包含关键字的文章</p>
          <p>多个关键字之间用 | 隔开</p></th>
        <td><textarea rows="2" style="width:75%;" name="subjectkey" id="subjectkey"><?php echo ($thevalue[subjectkey]); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_subjectkey', 'subjectkey');" value="测试"></td>
      </tr>
      <tr id="tr_subjectkeycancel">
        <th>文章标题关键字剔除过滤
          <p>设置该选项后，不会采集标题包含关键字的文章</p>
          <p>多个关键字之间用 | 隔开</p></th>
        <td><textarea rows="2" style="width:75%;" name="subjectkeycancel" id="subjectkeycancel"><?php echo ($thevalue[subjectkeycancel]); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_subjectkeycancel', 'subjectkeycancel');" value="测试"></td>
      </tr>
      <tr id="tr_subjectallowrepeat">
        <th>允许文章标题重复
          <p>(<strong style="color:red">如果启用自动入库再启用此项文章标题不允许重复将加重数据库的负载</strong>)</p></th>
        <td>
        <?php if($thevalue[subjectallowrepeat] == 1): ?><input type="radio" checked="" value="1" name="subjectallowrepeat">
          允许重复&nbsp;&nbsp;
          <input type="radio" value="0" name="subjectallowrepeat">
          不允许重复&nbsp;&nbsp;
        <?php else: ?>
          <input type="radio" value="1" name="subjectallowrepeat">
          允许重复&nbsp;&nbsp;
          <input type="radio" value="0" checked=""  name="subjectallowrepeat">
          不允许重复&nbsp;&nbsp;<?php endif; ?>  
          </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="colorarea02">
 <h3>文章内容设置</h3>
  <table width="100%" cellspacing="0" cellpadding="0" class="maintable">
    <tbody>
      <tr id="tr_messagerule">
        <th>文章内容识别规则
          <p>截取的地方加上
            <input type="input" disabled="disabled" value="[message]" size="10" name="tmp[]">
          </p>
          <p>用 * 来代替任意字符、换行、回车</p></th>
        <td><textarea rows="2" style="width:75%;" name="messagerule" id="messagerule"><?php echo ($thevalue['messagerule']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_messagerule', 'messagerule');" value="测试">
          <input type="button" onclick="$('messagerule').value=''; debugsubmit(this, 'tr_messagerule', 'messagerule');" value="自动识别">
          <br>
          <a onclick="$('messagerule').value='';" href="javascript:;">自动识别</a> ("文章内容识别规则"为空时，程序自动识别"文章内容")</td>
      </tr>
      <tr id="tr_messagefilter">
        <th>文章内容过滤规则
          <p>用 * 来代替任意字符、换行、回车</p>
          <p>多个规则之间用 | 隔开</p></th>
        <td><textarea rows="2" style="width:75%;" name="messagefilter" id="messagefilter"><?php echo ($thevalue['messagefilter']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_messagefilter', 'messagefilter');" value="测试"></td>
      </tr>
      <tr id="tr_messagereplace_title">
        <th>文章内容文字替换</th>
        <td>
          <div id="td_messagereplace_title">
                <div id="replace_1"><br>
                  替换前的字符
                  <input type="text" id="messagereplace[]" name="messagereplace[]" size="40">
                  <br>
                  (多个关键字用 | 隔开，用*代替任意符号。多条替换规则请点击"添加"按钮来创建多条替换规则)<br>
                  替换后的字符
                  <input type="text" id="messagereplaceto[]" name="messagereplaceto[]" size="40">
                  <br>
                  可以用[string]来表示替换前的字符
                </div>
          </div>
          <!--<input type="button" onclick="addreplace('messagereplace', '', '');" value="添加">-->
          <input type="button" onclick="debugsubmit(this, 'tr_messagereplace_title', 'messagereplace');" value="测试">
          </td>
      </tr>
      <tr id="tr_messagekey">
        <th>文章内容包含关键字
          <p>设置该选项后，则只采集文章内容包含关键字的文章</p>
          <p>多个关键字之间用 | 隔开</p></th>
        <td><textarea rows="2" style="width:75%;" name="messagekey" id="messagekey"><?php echo ($thevalue['messagekey']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_messagekey', 'messagekey');" value="测试"></td>
      </tr>
      <tr id="tr_messagekeycancel">
        <th>文章内容关键字剔除过滤
          <p>设置该选项后，不会采集文章内容包含关键字的文章</p>
          <p>多个关键字之间用 | 隔开</p></th>
        <td><textarea rows="2" style="width:75%;" name="messagekeycancel" id="messagekeycancel"><?php echo ($thevalue['messagekeycancel']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_messagekeycancel', 'messagekeycancel');" value="测试"></td>
      </tr>
      <tr id="tr_messageformat">
        <th>文章内容格式化
          <p>此操作将去除网页多余代码,并将文章内容按原有段落分段.格式化的过程为程序自动分析,会存在一些误差.</p></th>
        <td>
        <?php if($thevalue['messageformat'] == 1): ?><input type="radio" checked="checked" value="1" name="messageformat" id="messageformat">
          格式化&nbsp;&nbsp;
          <input type="radio" value="0" name="messageformat" id="messageformat">
          不格式化
        <?php else: ?>
        <input type="radio"  value="1" name="messageformat" id="messageformat">
          格式化&nbsp;&nbsp;
          <input type="radio" checked="checked" value="0" name="messageformat" id="messageformat">
          不格式化<?php endif; ?>
          <input type="button" onclick="debugsubmit(this, 'tr_messageformat', 'messageformat');" value="测试"></td>
      </tr>
      <tr id="tr_messagepagetype">
        <th>文章内容分页模式
          <p>当选择上下页导航时,"分页区域识别规则"请将下一页配置成识别区域.</p></th>
        <td>
        <?php if($thevalue['messagepagetype'] == 'page'): ?><input type="radio" checked="" value="page" name="messagepagetype">
            页码导航&nbsp;&nbsp;
            <input type="radio" value="next" name="messagepagetype">
            上下页导航&nbsp;&nbsp;
        <?php else: ?>
            <input type="radio" value="page" name="messagepagetype">
            页码导航&nbsp;&nbsp;
            <input type="radio" value="next"  checked=""  name="messagepagetype">
            上下页导航&nbsp;&nbsp;<?php endif; ?> 
       </td>
      </tr>
      <tr id="tr_messagepagerule">
        <th>文章内容分页区域识别规则
          <p>截取的地方加上
            <input type="input" disabled="disabled" value="[pagearea]" size="10" name="tmp[]">
          </p>
          <p>用 * 来代替任意字符、换行、回车</p></th>
        <td><textarea rows="2" style="width:75%;" name="messagepagerule" id="messagepagerule"><?php echo ($thevalue['messagepagerule']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_messagepagerule', 'messagepagerule');" value="测试"></td>
      </tr>
      <tr id="tr_messagepageurlrule">
        <th>文章内容分页链接识别规则
          <p>截取的地方加上
            <input type="input" disabled="disabled" value="[page]" size="10" name="tmp[]">
          </p>
          <p>用 * 来代替任意字符、换行、回车</p></th>
        <td><textarea rows="2" style="width:75%;" name="messagepageurlrule" id="messagepageurlrule"><?php echo ($thevalue['messagepageurlrule']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_messagepageurlrule', 'messagepageurlrule');" value="测试"></td>
      </tr>
      <tr id="tr_messagepageurllinkpre">
        <th>文章内容分页链接URL补充前缀</th>
        <td><input type="text" value="<?php echo ($thevalue['messagepageurllinkpre']); ?>" size="60" id="messagepageurllinkpre" name="messagepageurllinkpre">
          <input type="button" onclick="debugsubmit(this, 'tr_messagepageurllinkpre', 'messagepageurllinkpre');" value="测试">
          <input type="button" onclick="$('messagepageurllinkpre').value=''; debugsubmit(this, 'tr_messagepageurllinkpre', 'messagepageurllinkpre');" value="自动识别">
          <br>
          <a onclick="$('messagepageurllinkpre').value='';" href="javascript:;">自动识别</a> ("文章内容分页链接URL补充前缀"为空时，程序自动补充前缀)</td>
      </tr>
      <tr id="tr_messagepageurllinkpf">
        <th>文章内容分页链接URL补充后缀</th>
        <td><input type="text" value="<?php echo ($thevalue['messagepageurllinkpre']); ?>"  size="60" id="messagepageurllinkpf" name="messagepageurllinkpf">
          <input type="button" onclick="debugsubmit(this, 'tr_messagepageurllinkpf', 'messagepageurllinkpf');" value="测试"></td>
      </tr>
    </tbody>
  </table>
</div>


<div class="colorarea02">
  <h3>信息来源</h3>
  <table width="100%" cellspacing="0" cellpadding="0" class="maintable">
    <tbody>
      <tr id="tr_fromrule">
        <th>信息来源识别规则
          <p>截取的地方加上
            <input type="input" disabled="disabled" value="[from]" size="10" name="tmp[]">
          </p>
          <p>用 * 来代替任意字符、换行、回车</p></th>
        <td><textarea rows="4" style="width:75%;" name="fromrule" id="fromrule"><?php echo ($thevalue['fromrule']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_fromrule', 'fromrule');" value="测试">
          <br>
          当规则中不出现"标记符([from])"时,此值为"固定值"</td>
      </tr>
      <tr id="tr_authorrule">
        <th>作者识别规则
          <p>截取的地方加上
            <input type="input" disabled="disabled" value="[author]" size="10" name="tmp[]">
          </p>
          <p>用 * 来代替任意字符、换行、回车. 也可以指定多个作者,采集结果在入库时随机抽取其中的一个.多个作者之间用 | 隔开,在指定多个作者时,不能出现标记符([author]).</p></th>
        <td><textarea rows="4" style="width:75%;" name="authorrule" id="authorrule"><?php echo ($thevalue['authorrule']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_authorrule', 'authorrule');" value="测试">
          <br>
          当规则中不出现"标记符([author])"时,此值为"固定值"</td>
      </tr>
    </tbody>
  </table>
</div>

<div class="colorarea02">
  <table width="100%" cellspacing="0" cellpadding="0" class="maintable">
    <tbody>
      <tr id="tr_uidrule">
        <th>发布者UID
          <p>可以指定多个发布者UID,采集结果在入库时随机抽取其中的一个,UID必须是网站的真实用户UID.多个发布者UID之间用 | 隔开</p></th>
        <td><textarea rows="4" style="width:75%;" name="uidrule" id="uidrule"><?php echo ($thevalue['uidrule']); ?></textarea>
          <input type="button" onclick="debugsubmit(this, 'tr_uidrule', 'uidrule');" value="测试"></td>
      </tr>
      <tr id="tr_savepic">
        <th>保存内容中的图片到本地</th>
        <td>
        <?php if($thevalue['savepic'] == 0): ?><input type="radio" checked="" value="0" name="savepic">
          否&nbsp;&nbsp;
          <input type="radio" value="1" name="savepic">
          是&nbsp;&nbsp;
        <?php else: ?>
          <input type="radio"  value="0" name="savepic">
          否&nbsp;&nbsp;
          <input type="radio" value="1" checked="" name="savepic">
          是&nbsp;&nbsp;<?php endif; ?> 
        </td>
      </tr>
      <tr id="tr_saveflash">
        <th>保存内容中的FLASH到本地</th>
        <td>
          <?php if($thevalue['saveflash'] == 0): ?><input type="radio" checked="" value="0" name="saveflash">
          否&nbsp;&nbsp;
          <input type="radio" value="1" name="saveflash">
          是&nbsp;&nbsp;
          <?php else: ?>
          <input type="radio"  value="0" name="saveflash">
          否&nbsp;&nbsp;
          <input type="radio" checked="" value="1" name="saveflash">
          是&nbsp;&nbsp;<?php endif; ?>
          </td>
      </tr>
      <tr id="tr_picurllinkpre">
        <th>图片/FLASH链接的URL补充前缀</th>
        <td><input type="text" value="<?php echo ($thevalue['picurllinkpre']); ?>" size="60" id="picurllinkpre" name="picurllinkpre">
          <br>
          <a onclick="$('picurllinkpre').value='';" href="javascript:;">自动识别</a> ("图片/FLASH链接的URL补充前缀"为空时，程序自动补充前缀)</td>
      </tr>
    </tbody>
  </table>
</div>



<div class="buttons">
    <input type="submit" class="submit" value="提交保存" name="thevaluesubmit">&nbsp;&nbsp;&nbsp;&nbsp;<input  class="submit" type="reset" value="重置" name="thevaluereset" style="cursor:pointer">
</div>  
<input id="valuesubmit" name="valuesubmit" type="hidden" value="yes" />
<input id="robotid" name="robotid" type="hidden" value="<?php echo ($thevalue[robotid]); ?>" />
<input id="debugurl" name="debugurl" type="hidden" value="" />
<input id="debugprocess" name="debugprocess" type="hidden" value="" />


</form>  
</div>
</body>
</html>