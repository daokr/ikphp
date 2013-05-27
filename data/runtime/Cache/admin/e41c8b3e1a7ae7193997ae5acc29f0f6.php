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
<h2><span><a href="#">+添加文章</a></span><?php echo ($title); ?></h2>  
<div class="tabnav">
<ul>
<?php if(is_array($arrChannel)): foreach($arrChannel as $key=>$item): if($item[nameid] == $nameid): ?><li class="select"><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$item[nameid],'isaudit'=>'0'));?>"><?php echo ($item[name]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$item[nameid],'isaudit'=>'0'));?>"><?php echo ($item[name]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>

<div class="tabnav">
<ul>
	<?php if($isaudit == 0): ?><li class="select"><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>'0'));?>">已审核的</a></li>
	<?php else: ?>
   		 <li><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>'0'));?>">已审核的</a></li><?php endif; ?>
    <?php if($isaudit == 1): ?><li class="select"><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>'1'));?>">未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></a></li>   
    <?php else: ?>
 		<li><a href="<?php echo U('article/index',array('ik'=>'list','nameid'=>$nameid,'isaudit'=>'1'));?>">未审核的 <font style="color:red;">(<?php echo ($count_isaudit); ?>)</font></a></li><?php endif; ?>
    
</ul>
</div>
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_delete',array('ik'=>'article'));?>" onclick="Delete(this)">
<span>删除选中</span>
</a>

<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_setting',array('ik'=>'istop','type'=>1));?>" onclick="Audit(this)">
<span>置顶</span>
</a>  

<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_setting',array('ik'=>'isdigest','type'=>1));?>" onclick="Audit(this)">
<span>头条</span>
</a> 

<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_setting',array('ik'=>'isaudit','type'=>0));?>" onclick="Audit(this)">
<span>通过审核</span>
</a>  
&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_setting',array('ik'=>'istop','type'=>0));?>" onclick="Audit(this)">
<span>取消置顶</span>
</a> 
<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_setting',array('ik'=>'isdigest','type'=>0));?>" onclick="Audit(this)">
<span>取消头条</span>
</a> 
<a class="btn_a" href="javascript:;" data-url="<?php echo U('article/ajax_setting',array('ik'=>'isaudit','type'=>1));?>" onclick="Audit(this)">
<span>取消审核</span>
</a>

  
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td width="20"><input name="chkall" onclick="ToggleCheck(this)" type="checkbox"></td>
<td>itemid</td>
<td>标题</td>
<td>系统分类</td>
<td>添加人</td>
<td>发布日期</td>
<td>审核状态</td>
<td>状态</td>
<td>排序</td>
<td width="280">操作</td>
</tr>
<?php if(is_array($arrArticle)): foreach($arrArticle as $key=>$item): ?><tr class="odd">
<td><input type="checkbox" value="<?php echo ($item[itemid]); ?>" name="itemid"></td>
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
<?php if($item[istop] == 1): ?><font color="green">顶</font>&nbsp;<?php endif; ?>
<?php if($item[isdigest] == 1): ?><font color="blue">头</font><?php endif; ?>
</td>
<td><span class="tdedit" data-id="<?php echo ($item[itemid]); ?>" data-field="orderid" data-tdtype="edit" data-action="<?php echo U('article/ajax_setting',array('ik'=>'order','id'=>$item[itemid]));?>"><?php echo ($item[orderid]); ?></span></td>
<td>
<a href="#">[编辑]</a> 
<a href="#">[删除]</a> 
<?php if($item[isaudit] == 0): ?><a href="<?php echo U('article/index',array('ik'=>'isaudit','itemid'=>$item[itemid],'isaudit'=>'1'));?>">[取消审核]</a> 
<?php else: ?>
<a href="<?php echo U('article/index',array('ik'=>'isaudit','itemid'=>$item[itemid],'isaudit'=>'0'));?>">[审核]</a><?php endif; ?>

<?php if($item[istop] == 0): ?><a href="<?php echo U('article/index',array('ik'=>'istop','itemid'=>$item[itemid],'istop'=>'1'));?>">[置顶]</a> 
<?php else: ?>
<a href="<?php echo U('article/index',array('ik'=>'istop','itemid'=>$item[itemid],'istop'=>'0'));?>">[取消置顶]</a><?php endif; ?>

<?php if($item[isdigest] == 0): ?><a href="<?php echo U('article/index',array('ik'=>'isdigest','itemid'=>$item[itemid],'isdigest'=>'1'));?>">[头条]</a> 
<?php else: ?>
<a href="<?php echo U('article/index',array('ik'=>'isdigest','itemid'=>$item[itemid],'isdigest'=>'0'));?>">[取消头条]</a><?php endif; ?>

</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>