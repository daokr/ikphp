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
<?php if(is_array($arrChannel)): foreach($arrChannel as $key=>$item): if($item[nameid] == $nameid): ?><li class="select"><a href="<?php echo U('article/cate',array('ik'=>'list','nameid'=>$item[nameid]));?>"><?php echo ($item[name]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo U('article/cate',array('ik'=>'list','nameid'=>$item[nameid]));?>"><?php echo ($item[name]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<div class="Toolbar_inbox">
	<a class="btn_a" href="<?php echo U('article/cate',array('ik'=>'add','nameid'=>$nameid));?>"><span>添加分类</span></a>
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>分类名称</td>
<td>显示顺序</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($arrCate)): foreach($arrCate as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[catename]); ?></td>
<td><?php echo ($item[orderid]); ?></td>
<td>
<a href="<?php echo U('article/cate',array('ik'=>'edit','cateid'=>$item[cateid]));?>">[编辑]</a> 
<a href="<?php echo U('article/cate',array('ik'=>'delete','cateid'=>$item[cateid]));?>">[合并/删除]</a> 
<a href="index.php?m=article&a=category&cateid=<?php echo ($item[cateid]); ?>" target="_blank">[访问]</a> 
</td>
<tr><?php endforeach; endif; ?>
</table>

</div>
</body>
</html>