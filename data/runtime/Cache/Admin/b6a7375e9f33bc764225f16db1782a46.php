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
<?php if(is_array($menu)): foreach($menu as $key=>$item): if($key == $ik): ?><li class="select"><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<?php if($ik != 'comments'): ?><div class="tabnav">
<ul>
	<?php if($isaudit == 0): ?><li class="select"><a href="<?php echo U('group/manage',array('ik'=>$ik,'isaudit'=>'0'));?>">已审核的</a></li>
	<?php else: ?>
   		 <li><a href="<?php echo U('group/manage',array('ik'=>$ik,'isaudit'=>'0'));?>">已审核的</a></li><?php endif; ?>
    <?php if($isaudit == 1): ?><li class="select"><a href="<?php echo U('group/manage',array('ik'=>$ik,'isaudit'=>'1'));?>">未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></a></li>   
    <?php else: ?>
 <li><a href="<?php echo U('group/manage',array('ik'=>$ik,'isaudit'=>'1'));?>">未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></a></li><?php endif; ?>
    
</ul>
</div><?php endif; ?>
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_delete',array('ik'=>$ik));?>" onclick="Delete(this)">
<span>删除选中</span>
</a>
<?php if($ik != 'comments'): ?><a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_audit',array('ik'=>$ik,'isaudit'=>0));?>" onclick="Audit(this)">
<span>通过审核</span>
</a>  
<a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_audit',array('ik'=>$ik,'isaudit'=>1));?>" onclick="Audit(this)">
<span>取消审核</span>
</a><?php endif; ?>     
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
  <td width="20"><input name="chkall" onclick="ToggleCheck(this)" type="checkbox"></td>
<td>ID</td>
<td>帖子ID</td>
<td>内容</td>
<td>发布者</td>
<td>发布时间</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><input type="checkbox" value="<?php echo ($item[commentid]); ?>" name="itemid"></td>
<td><?php echo ($item[commentid]); ?></td>
<td><?php echo ($item[topicid]); ?></td>
<td><?php echo ($item[content]); ?></td>
<td><?php echo ($item[user][username]); ?></td>
<td><?php echo ($item[addtime]); ?></td>
<td>
<a href="<?php echo U('group/delete',array('ik'=>'comment','id'=>$item[commentid]));?>">[删除]</a> &nbsp;&nbsp;
</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_delete',array('ik'=>$ik));?>" onclick="Delete(this)">
<span>删除选中</span>
</a>
<?php if($ik != 'comments'): ?><a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_audit',array('ik'=>$ik,'isaudit'=>0));?>" onclick="Audit(this)">
<span>通过审核</span>
</a>  
<a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_audit',array('ik'=>$ik,'isaudit'=>1));?>" onclick="Audit(this)">
<span>取消审核</span>
</a><?php endif; ?>     
</div>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>