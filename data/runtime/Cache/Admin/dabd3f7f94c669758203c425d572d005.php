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
<td>拼音</td>
<td>查看</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[areaid]); ?></td>
<td><?php echo ($item[areaname]); ?> <?php if($item[ishot] == 1): ?><font color="#ff6600">[热]</font><?php endif; ?></td>
<td><?php echo ($item[zm]); ?></td>
<td><?php echo ($item[pinyin]); ?></td>
<td><a href="<?php echo U('area/manage',array('ik'=>'districts','id'=>$item[areaid]));?>">[查看三级区域]</a></td>
<td width="300">
<a href="<?php echo U('area/add',array('ik'=>'districts','id'=>$item[areaid]));?>">[添加三级区域]</a> &nbsp;&nbsp;
<a href="<?php echo U('area/edit',array('ik'=>'city','id'=>$item[areaid]));?>">[编辑]</a> &nbsp;&nbsp;
<a href="<?php echo U('area/delete',array('ik'=>'city','id'=>$item[areaid]));?>">[删除]</a> &nbsp;&nbsp;
<?php if($item[ishot] == 0): ?><a href="<?php echo U('area/setting',array('id'=>$item[areaid],'ishot'=>1));?>">[设为热门]</a>
<?php else: ?>
<a href="<?php echo U('area/setting',array('id'=>$item[areaid],'ishot'=>0));?>">[取消热门]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>
</div>
</body>
</html>