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
<div class="tabnav">
<ul>
<li  <?php if($type == "index"): ?>class="select"<?php endif; ?> ><a href="<?php echo U('setting/index');?>">基本配置</a></li>
<li  <?php if($type == "site"): ?>class="select"<?php endif; ?> ><a href="<?php echo U('setting/index',array('type'=>'site'));?>">全局配置</a></li>
<li  <?php if($type == "attachment"): ?>class="select"<?php endif; ?> ><a href="<?php echo U('setting/index',array('type'=>'attachment'));?>">附件设置</a></li>
</ul>
</div>
<form method="POST" action="<?php echo U('setting/edit');?>">
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>会员头像规格：</th>
		<td><input style="width: 300px;" name="setting[avatar_size]"  size="40" value="<?php echo C('ik_avatar_size');?>" /> 用户头像规格，用","隔开</td>
	</tr> 
	<tr>
		<th>全站小图规格：</th>
		<td>
         <input type="text" name="setting[simg][width]"  size="5" value="<?php echo C('ik_simg.width');?>"> X 
         <input type="text" name="setting[simg][height]"  size="5" value="<?php echo C('ik_simg.height');?>"> 如：100x100
        </td>
	</tr> 
	<tr>
		<th>全站中图规格：</th>
		<td>
         <input type="text" name="setting[mimg][width]"  size="5" value="<?php echo C('ik_mimg.width');?>"> X 
         <input type="text" name="setting[mimg][height]"  size="5" value="<?php echo C('ik_mimg.height');?>"> 如：600x600
        </td>
	</tr>    
	<tr>
		<th>全站大图规格：</th>
		<td>
         <input type="text" name="setting[bimg][width]"  size="5" value="<?php echo C('ik_bimg.width');?>"> X 
         <input type="text" name="setting[bimg][height]"  size="5" value="<?php echo C('ik_bimg.height');?>"> 如：1024x800
        </td>
	</tr>                 

</table>

<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>