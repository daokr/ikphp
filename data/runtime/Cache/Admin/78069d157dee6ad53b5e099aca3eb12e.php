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
          <li>替换前的内容可以使用限定符 {x} 以限定相邻两字符间可忽略的文字，x 是忽略字符的个数。如 "a{1}s{2}s"(不含引号) 可以过滤 "ass" 也可过滤 "axsxs" 和 "axsxxs" 等等。</li>
          <li><strong>一个中文占用两个字符</strong></li>
          <li>为不影响程序效率，请不要设置过多不需要的过滤内容。</li>
          <li>为了过滤的准确性，过滤词不能少于两个字</li>
        </ul></td>
    </tr>
  </tbody>
</table>
<div class="tabnav">
<ul>
    <li class="select"><a href="<?php echo U('words/lists');?>">词语过滤</a></li>
    <li><a href="<?php echo U('words/addwords');?>">批量添加</a></li>
</ul>
</div>
<form enctype="multipart/form-data" action="<?php echo U('words/lists');?>" method="post">
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>删除</td>
<td width="300">不良词语</td>
<td width="300">替换为</td>
<td width="">操作者</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><input type="checkbox" value="<?php echo ($item[id]); ?>" name="delwords[]"></td>
<td><input type="text" value="<?php echo ($item[find]); ?>" name="find[<?php echo ($item[id]); ?>]"></td>
<td><input type="text" value="<?php echo ($item[replacement]); ?>" name="replacement[<?php echo ($item[id]); ?>]"></td>
<td><?php echo ($item[admin]); ?></td>
<tr><?php endforeach; endif; ?>
<tr class="odd">
<td>新增</td>
<td><input type="text" value="" name="newfind"></td>
<td><input type="text" value="" name="newreplacement"></td>
<td></td>
<tr>
</table>
<div class="Toolbar_inbox">
<input name="chkall" onclick="ToggleCheck(this)" type="checkbox">全选
<input name="worddelete" value="1" checked="" type="radio"> 删除
</div>
<div class="page_btn"><input type="submit" value="提交保存" class="submit" /></div>
</form>
</div>
</body>
</html>