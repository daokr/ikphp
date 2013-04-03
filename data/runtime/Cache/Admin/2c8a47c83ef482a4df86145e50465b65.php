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
<div class="Toolbar_inbox">
	<a class="btn_a" href="<?php echo U('group/topics',array('isaudit'=>'0'));?>"><span>已审核的</span></a>
    <a class="btn_a" href="<?php echo U('group/topics',array('isaudit'=>'1'));?>">
    <span>未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></span></a>
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>ID</td>
<td>标题</td>
<td>发布人</td>
<td>所在小组</td>
<td>评论数</td>
<td>浏览数</td>
<td>创建时间</td>
<td>审核状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[topicid]); ?></td>
<td><a href="index.php?m=group&a=topic&id=<?php echo ($item[topicid]); ?>" target="_blank"><?php echo ($item[title]); ?></a></td>
<td><?php echo ($item[user][username]); ?></td>
<td><?php echo ($item[count_comment]); ?></td>
<td><?php echo ($item[count_view]); ?></td>
<td><?php echo ($item[count_user]); ?></td>
<td><?php echo ($item[addtime]); ?></td>
<td>
<?php if($item[isaudit] == 0): ?>已审核
<?php else: ?>
未审核<?php endif; ?>
</td>
<td>
<a href="#">[编辑]</a> 
<?php if($item[isaudit] == 0): ?><a href="<?php echo U('group/isaudit',array('ik'=>'topic','id'=>$item[topicid],'isaudit'=>'1'));?>">[取消审核]</a> 
<?php else: ?>
<a href="<?php echo U('group/isaudit',array('ik'=>'topic','id'=>$item[topicid],'isaudit'=>'0'));?>">[审核]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>