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
<?php if($ik != 'addsubcate' && $ik != 'subcatelist'): ?><div class="tabnav">
<ul>
<?php if(is_array($menu)): foreach($menu as $key=>$item): if($key == $ik): ?><li class="select"><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<?php else: ?>
<div class="Toolbar_inbox">
    <a class="btn_a" href="<?php echo U('event/cate',array('ik'=>'catelist'));?>"><span>返回</span></a>
	<a class="btn_a" href="<?php echo U('event/cate',array('ik'=>'addsubcate','id'=>$strCate[cateid]));?>"><span>添加子分类</span></a>
</div><?php endif; ?>

<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>ID</td>
<td>分类名称</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($arrCate)): foreach($arrCate as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[cateid]); ?></td>
<td><?php echo ($item[catename]); ?></td>
<td>
<a href="<?php echo U('event/cate',array('ik'=>'edit','id'=>$item[cateid]));?>">[编辑]</a> &nbsp;&nbsp;
<a href="<?php echo U('event/cate',array('ik'=>'delete','id'=>$item[cateid]));?>">[合并/删除]</a> &nbsp;&nbsp;
</td>
<tr><?php endforeach; endif; ?>
</table>

</div>
</body>
</html>