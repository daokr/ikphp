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
<td>区域名称</td>
<td>ZM</td>
<td>查看</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[areaid]); ?></td>
<td><?php echo ($item[areaname]); ?></td>
<td><?php echo ($item[zm]); ?></td>
<td><a href="<?php echo U('area/manage',array('ik'=>'city','id'=>$item[areaid]));?>">[查看二级区域]</a></td>
<td>
<a href="<?php echo U('area/add',array('ik'=>'city','id'=>$item[areaid]));?>">[添加二级区域]</a> &nbsp;&nbsp;
<a href="<?php echo U('area/edit',array('ik'=>'province','id'=>$item[areaid]));?>">[编辑]</a> &nbsp;&nbsp;
<a href="<?php echo U('area/delete',array('ik'=>'province','id'=>$item[areaid]));?>">[删除]</a>
</td>
<tr><?php endforeach; endif; ?>
</table>
</div>
</body>
</html>