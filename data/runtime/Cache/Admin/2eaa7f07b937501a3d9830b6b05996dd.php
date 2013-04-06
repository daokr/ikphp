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
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('user/ajax_isenable',array('ik'=>$ik,'isenable'=>1));?>" onclick="Audit(this)">
<span>禁用</span>
</a> 
<a class="btn_a" href="javascript:;" data-url="<?php echo U('user/ajax_isenable',array('ik'=>$ik,'isenable'=>0));?>" onclick="Audit(this)">
<span>启用</span>
</a> 
  
</div>
<table  cellpadding="0" cellspacing="0">
<tr class="old">
  <td width="20"><input name="chkall" onclick="ToggleCheck(this)" type="checkbox"></td>
<td>ID</td>
<td>Email</td>
<td>用户名</td>
<td>个性域名</td>
<td>注册时间</td>
<td>最后一次登录时间</td>
<td>登录IP</td>
<td>状态</td>
<td width="200">操作</td>
</tr>
<?php if(is_array($list)): foreach($list as $key=>$item): ?><tr class="odd">
<td><input type="checkbox" value="<?php echo ($item[userid]); ?>" name="itemid"></td>
<td><?php echo ($item[userid]); ?></td>
<td><?php echo ($item[email]); ?></td>
<td><a href="index.php?m=people&a=index&id=<?php echo ($item[doname]); ?>" target="_blank"><?php echo ($item[username]); ?></a></td>
<td><?php echo ($item[doname]); ?></td>
<td><?php echo date('Y-m-d H:i:s',$item['addtime']); ?></td>
<td><?php echo date('Y-m-d H:i:s',$item['uptime']); ?></td>
<td><?php echo ($item[ip]); ?></td>
<td>
<?php if($item[isenable] == 0): ?><font style="color:green;">已启用</font>
<?php else: ?>
<font style="color:red;">已禁用</font><?php endif; ?>
</td>
<td>
<?php if($item[isenable] == 0): ?><a href="<?php echo U('user/isenable',array('ik'=>'user','id'=>$item[userid],'isenable'=>'1'));?>">[禁用]</a> 
<?php else: ?>
<a href="<?php echo U('user/isenable',array('ik'=>'user','id'=>$item[userid],'isenable'=>'0'));?>">[启用]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>
<div class="Toolbar_inbox">
<a class="btn_a" href="javascript:;" data-url="<?php echo U('user/ajax_isenable',array('ik'=>$ik,'isenable'=>1));?>" onclick="Audit(this)">
<span>禁用</span>
</a> 
<a class="btn_a" href="javascript:;" data-url="<?php echo U('user/ajax_isenable',array('ik'=>$ik,'isenable'=>0));?>" onclick="Audit(this)">
<span>启用</span>
</a> 
  
</div>
<div class="pagebar"><?php echo ($pageUrl); ?></div>
</div>
</body>
</html>