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
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>ID</td>
<td>接口标识</td>
<td>接口名称</td>
<td>接口描述</td>
<td>App Key</td>
<td>App Code</td>
<td>作者</td>
<td>状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[id]); ?></td>
<td><?php echo ($item[code]); ?></td>
<td><?php echo ($item[name]); ?></td>
<td><?php echo ($item[desc]); ?></td>
<td><?php echo ($item[key]); ?></td>
<td><?php echo ($item[keycode]); ?></td>
<td><?php echo ($item[author]); ?></td>
<td>
<?php if($item[status] == 1): ?><font color="green">已启用</font>
<?php else: ?>
<font color="red">已停用</font><?php endif; ?>
</td>
<td>
<a href="<?php echo U('oauth/edit',array('ik'=>'unitelogin','id'=>$item[id]));?>">[编辑]</a> &nbsp;&nbsp;
<?php if($item[status] == 1): ?><a href="<?php echo U('oauth/status',array('ik'=>'unitelogin','id'=>$item[id],'status'=>'0'));?>">[停用]</a> 
<?php else: ?>
<a href="<?php echo U('oauth/status',array('ik'=>'unitelogin','id'=>$item[id],'status'=>'1'));?>">[启用]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>

<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>