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
<!--main-->
<div class="midder">
<h2><?php echo ($title); ?></h2>  
<div class="tabnav">
<ul>
<?php if(is_array($arrChannel)): foreach($arrChannel as $key=>$item): if($item[nameid] == $nameid): ?><li class="select"><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$item[nameid],'isaudit'=>'0'));?>"><?php echo ($item[name]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$item[nameid],'isaudit'=>'0'));?>"><?php echo ($item[name]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<div class="Toolbar_inbox">
	<a class="btn_a" href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>'0'));?>"><span>已发布的</span></a>
    <a class="btn_a" href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>'1'));?>">
    <span>未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></span></a>
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>itemid</td>
<td>标题</td>
<td>系统分类</td>
<td>添加人</td>
<td>发布日期</td>
<td>审核状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($arrArticle)): foreach($arrArticle as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[itemid]); ?></td>
<td><a href="index.php?m=article&a=show&id=<?php echo ($item[itemid]); ?>" target="_blank"><?php echo ($item[title]); ?></a></td>
<td><?php echo ($item[cate][catename]); ?></td>
<td><?php echo ($item[user][username]); ?></td>
<td><?php echo ($item[addtime]); ?></td>
<td>
<?php if($item[isaudit] == 0): ?>已审核
<?php else: ?>
未审核<?php endif; ?>
</td>
<td>
<a href="#">[编辑]</a> 
<?php if($item[isaudit] == 0): ?><a href="<?php echo U('article/index',array('ik'=>'isaudit','itemid'=>$item[itemid],'isaudit'=>'1'));?>">[取消审核]</a> 
<?php else: ?>
<a href="<?php echo U('article/index',array('ik'=>'isaudit','itemid'=>$item[itemid],'isaudit'=>'0'));?>">[审核]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>