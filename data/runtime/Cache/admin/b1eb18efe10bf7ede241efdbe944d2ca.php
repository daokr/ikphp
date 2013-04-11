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
<?php if($ik == 'groups'): ?><a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_recommend',array('ik'=>$ik,'isrecommend'=>1));?>" onclick="Audit(this)">
<span>推荐</span>
</a>  
<a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_recommend',array('ik'=>$ik,'isrecommend'=>0));?>" onclick="Audit(this)">
<span>取消推荐</span>
</a><?php endif; ?>   
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
  <td width="20"><input name="chkall" onclick="ToggleCheck(this)" type="checkbox"></td>
<td>ID</td>
<td>组名</td>
<td>描述</td>
<td>创建人</td>
<td>帖子统计</td>
<td>成员统计</td>
<td>创建时间</td>
<td>推荐状态</td>
<td>审核状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><input type="checkbox" value="<?php echo ($item[groupid]); ?>" name="itemid"></td>
<td><?php echo ($item[groupid]); ?></td>
<td><a href="index.php?m=group&a=show&id=<?php echo ($item[groupid]); ?>" target="_blank"><?php echo ($item[groupname]); ?></a></td>
<td><?php echo ($item[groupdesc]); ?></td>
<td><?php echo ($item[user][username]); ?></td>
<td><?php echo ($item[count_topic]); ?></td>
<td><?php echo ($item[count_user]); ?></td>
<td><?php echo ($item[addtime]); ?></td>
<td>
<?php if($item[isrecommend] == 1): ?><font color="green">已推荐</font>
<?php else: ?>
未推荐<?php endif; ?>
</td>
<td>
<?php if($item[isaudit] == 0): ?>已审核
<?php else: ?>
未审核<?php endif; ?>
</td>
<td>
<a href="<?php echo U('group/delete',array('ik'=>'group','id'=>$item[groupid],'isaudit'=>$isaudit));?>">[删除]</a> &nbsp;&nbsp;
<?php if($item[isaudit] == 0): ?><a href="<?php echo U('group/isaudit',array('ik'=>'group','id'=>$item[groupid],'isaudit'=>'1'));?>">[取消审核]</a> 
<?php else: ?>
<a href="<?php echo U('group/isaudit',array('ik'=>'group','id'=>$item[groupid],'isaudit'=>'0'));?>">[通过审核]</a><?php endif; ?>
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
<?php if($ik == 'groups'): ?><a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_recommend',array('ik'=>$ik,'isrecommend'=>1));?>" onclick="Audit(this)">
<span>推荐</span>
</a>  
<a class="btn_a" href="javascript:;" data-url="<?php echo U('group/ajax_recommend',array('ik'=>$ik,'isrecommend'=>0));?>" onclick="Audit(this)">
<span>取消推荐</span>
</a><?php endif; ?>   
</div>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>