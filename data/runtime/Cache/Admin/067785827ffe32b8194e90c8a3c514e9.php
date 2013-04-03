<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="160780470@qq.com" />
<meta name="Copyright" content="<?php echo ($ikphp["ikphp_site_name"]); ?>" />
<title><?php echo ($title); ?> - <?php echo ($site_title); ?></title>
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/style.css" />
<script src="__STATIC__/public/js/jquery.js" type="text/javascript"></script>
<script src="__STATIC__/admin/js/common.js" type="text/javascript"></script>
</head>
<body>
<!--main-->
<div class="midder">
<h2><?php echo ($title); ?></h2>
<table cellspacing="2" cellpadding="2" class="helptable">
  <tbody>
    <tr>
      <td><ul>
          <strong>添加格式</strong>
          <li>每行一组过滤词语。</li>
          <li>不良词语和替换词语之间使用"="进行分割。 如： 爱客网=IKPHP官网</li>
          <li>如果只是想将某个词语直接替换成 **，则只输入词语即可。如：想替换 <b>爱客网</b> 这个三个字成 <b>**</b> 就直接输入 <u>爱客网</u> 后面不用写等号 =</li>
        </ul></td>
    </tr>
  </tbody>
</table>
<div class="tabnav">
<ul>
    <li><a href="<?php echo U('words/lists');?>">词语过滤</a></li>
    <li  class="select"><a href="<?php echo U('words/addwords');?>">批量添加</a></li>
</ul>
</div>
<form method="POST" action="<?php echo U('words/addwords');?>">
<table cellpadding="0" cellspacing="0">
	<tr>
		<th>词组：
        </th>
		<td>
        <textarea cols="37" rows="8" name="words"></textarea><br>
        <input name="overwrite" value="2" type="radio">清空当前词表后导入新词语，此操作不可恢复，建议首先 <a href="<?php echo U('words/export');?>">导出词表</a> , 做好备份。<br>
        <input name="overwrite" value="1" type="radio">使用新的设置覆盖已经存在的词语<br>
        <input name="overwrite" value="0" checked="" type="radio">不导入已经存在的词语
        </td>
	</tr>    
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>