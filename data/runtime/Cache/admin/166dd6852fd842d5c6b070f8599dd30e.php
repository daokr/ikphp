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
<form method="POST" action="<?php echo U('group/setting');?>">
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>创建群组：</th>
		<td>
		<input type="radio"  <?php if(C('ik_iscreate') == 0): ?>checked="select"<?php endif; ?> name="setting[iscreate]" value="0" />开启 
		<input type="radio"  <?php if(C('ik_iscreate') == 1): ?>checked="select"<?php endif; ?> name="setting[iscreate]" value="1" />关闭        
        </td>
	</tr>
	<tr>
		<th>小组是否要审核：</th>
		<td>
        <input type="radio"  <?php if(C('ik_group_isaudit') == 0): ?>checked="select"<?php endif; ?> name="setting[group_isaudit]" value="0" />不需要审核 
		<input type="radio"  <?php if(C('ik_group_isaudit') == 1): ?>checked="select"<?php endif; ?> name="setting[group_isaudit]" value="1" />需要审核 
        </td>
	</tr>
	<tr>
		<th>帖子是否要审核：</th>
		<td>
        <input type="radio"  <?php if(C('ik_topic_isaudit') == 0): ?>checked="select"<?php endif; ?> name="setting[topic_isaudit]" value="0" />不需要审核 
		<input type="radio"  <?php if(C('ik_topic_isaudit') == 1): ?>checked="select"<?php endif; ?> name="setting[topic_isaudit]" value="1" />需要审核 
        </td>
	</tr>
	<tr>
		<th>最多创建群组数：</th>
		<td><input style="width: 80px;" name="setting[maxgroup]" value="<?php echo C('ik_maxgroup');?>" /></td>
	</tr>

	<tr>
		<th>最多加入群组数：</th>
		<td><input style="width: 80px;" name="setting[jionmax]" value="<?php echo C('ik_jionmax');?>" /></td>
	</tr>

</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>