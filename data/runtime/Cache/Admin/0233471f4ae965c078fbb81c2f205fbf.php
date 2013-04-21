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
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('tag/ajax_delete');?>" onclick="Delete(this)">
<span>删除选中</span>
</a>


<a class="btn_a" href="javascript:;" data-url="<?php echo U('tag/ajax_audit',array('isenable'=>0));?>" onclick="Audit(this)">
<span>启用</span>
</a>  

<a class="btn_a" href="javascript:;" data-url="<?php echo U('tag/ajax_audit',array('isenable'=>1));?>" onclick="Audit(this)">
<span>停用</span>
</a>

  
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td width="20"><input name="chkall" onclick="ToggleCheck(this)" type="checkbox"></td>
<td>ID</td>
<td>标签名称</td>
<td>创建时间</td>
<td>状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><input type="checkbox" value="<?php echo ($item[tagid]); ?>" name="itemid"></td>
<td><?php echo ($item[tagid]); ?></td>
<td><?php echo ($item[tagname]); ?></td>
<td><?php echo ($item[uptime]); ?></td>
<td>
<?php if($item[isenable] == 0): ?><font color="green">已启用</font>
<?php else: ?>
<font color="red">已停用</font><?php endif; ?>
</td>
<td>
<a href="<?php echo U('tag/delete',array('id'=>$item[tagid]));?>">[删除]</a> &nbsp;&nbsp;
<?php if($item[isenable] == 0): ?><a href="<?php echo U('tag/isaudit',array('id'=>$item[tagid],'isenable'=>1));?>">[停用]</a> 
<?php else: ?>
<a href="<?php echo U('tag/isaudit',array('id'=>$item[tagid],'isenable'=>0));?>">[启用]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('tag/ajax_delete');?>" onclick="Delete(this)">
<span>删除选中</span>
</a>


<a class="btn_a" href="javascript:;" data-url="<?php echo U('tag/ajax_audit',array('isenable'=>0));?>" onclick="Audit(this)">
<span>启用</span>
</a>  

<a class="btn_a" href="javascript:;" data-url="<?php echo U('tag/ajax_audit',array('isenable'=>1));?>" onclick="Audit(this)">
<span>停用</span>
</a>

  
</div>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>