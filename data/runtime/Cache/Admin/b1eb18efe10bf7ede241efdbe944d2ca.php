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
	<a class="btn_a" href="<?php echo U('group/groups',array('isaudit'=>'0'));?>"><span>已审核的</span></a>
    <a class="btn_a" href="<?php echo U('group/groups',array('isaudit'=>'1'));?>">
    <span>未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></span></a>
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>ID</td>
<td>组名</td>
<td>描述</td>
<td>创建人</td>
<td>帖子统计</td>
<td>成员统计</td>
<td>创建时间</td>
<td>审核状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[groupid]); ?></td>
<td><a href="index.php?m=group&a=show&id=<?php echo ($item[groupid]); ?>" target="_blank"><?php echo ($item[groupname]); ?></a></td>
<td><?php echo ($item[groupdesc]); ?></td>
<td><?php echo ($item[user][username]); ?></td>
<td><?php echo ($item[count_topic]); ?></td>
<td><?php echo ($item[count_user]); ?></td>
<td><?php echo ($item[addtime]); ?></td>
<td>
<?php if($item[isaudit] == 0): ?>已审核
<?php else: ?>
未审核<?php endif; ?>
</td>
<td>
<a href="#">[编辑]</a> 
<?php if($item[isaudit] == 0): ?><a href="<?php echo U('group/isaudit',array('ik'=>'group','id'=>$item[groupid],'isaudit'=>'1'));?>">[取消审核]</a> 
<?php else: ?>
<a href="<?php echo U('group/isaudit',array('ik'=>'group','id'=>$item[groupid],'isaudit'=>'0'));?>">[审核]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>