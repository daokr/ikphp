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
<li  <?php if($type == "index"): ?>class="select"<?php endif; ?> ><a href="<?php echo U('setting/index');?>">基本配置</a></li>
<li  <?php if($type == "site"): ?>class="select"<?php endif; ?> ><a href="<?php echo U('setting/index',array('type'=>'site'));?>">全局配置</a></li>
<li  <?php if($type == "attachment"): ?>class="select"<?php endif; ?> ><a href="<?php echo U('setting/index',array('type'=>'attachment'));?>">附件设置</a></li>
</ul>
</div>
<form method="POST" action="<?php echo U('setting/edit');?>">
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>网站标题：</th>
		<td><input style="width: 300px;" name="setting[site_title]"
			value="<?php echo C('ik_site_title');?>" /></td>
	</tr>
	<tr>
		<th>副标题：</th>
		<td><input style="width: 300px;" name="setting[site_subtitle]"
			value="<?php echo C('ik_site_subtitle');?>" /> (例如：又一个爱客(IKPHP)社区小组)</td>
	</tr>

	<tr>
		<th>关键词：</th>
		<td><input style="width: 300px;" name="setting[site_keywords]"
			value="<?php echo C('ik_site_keywords');?>" /> (关键词有助于SEO)</td>
	</tr>

	<tr>
		<th>网站说明：</th>
		<td><textarea
			style="width: 300px; height: 50px; font-size: 12px;" name="setting[site_desc]"><?php echo C('ik_site_desc');?></textarea>
		(用简洁的文字描述本站点。)</td>
	</tr>

	<tr>
		<th>站点地址（URL）：</th>
		<td><input style="width: 300px;" name="setting[site_url]"
			value="<?php echo C('ik_site_url');?>" />(必须以http://开头，以/结尾)</td>
	</tr>
	<tr>
		<th>网站编码：</th>
		<td><input style="width: 300px;" name="setting[charset]"
			value="<?php echo C('ik_charset');?>" disabled/> （默认UTF-8）请勿更改</td>
	</tr>    
	<tr>
		<th>电子邮件：</th>
		<td><input style="width: 300px;" name="setting[site_email]"
			value="<?php echo C('ik_site_email');?>" /></td>
	</tr>

	<tr>
		<th>ICP备案号：</th>
		<td><input style="width: 300px;" name="setting[site_icp]"
			value="<?php echo C('ik_site_icp');?>" /> （京ICP备09050100号）</td>
	</tr>

	<tr>
		<th>是否邀请注册：</th>
		<td>
		<input type="radio"  <?php if(C('ik_isinvite') == 0): ?>checked="select"<?php endif; ?> name="setting[isinvite]" value="0" />开放注册 
		<input type="radio"  <?php if(C('ik_isinvite') == 1): ?>checked="select"<?php endif; ?> name="setting[isinvite]" value="1" />邀请注册 
		<input type="radio"  <?php if(C('ik_isinvite') == 2): ?>checked="select"<?php endif; ?> name="setting[isinvite]" value="2" />关闭注册
		</td>
	</tr>
	<tr>
		<th>Gzip压缩：</th>
		<td>
		<input type="radio" <?php if(C('ik_isgzip') == 0): ?>checked="select"<?php endif; ?> name="setting[isgzip]" value="0" />关闭 
		<input type="radio" <?php if(C('ik_isgzip') == 1): ?>checked="select"<?php endif; ?> name="setting[isgzip]" value="1" />开启</td>
	</tr>

	<tr>
		<th>时区：</th>
		<td><select name="setting[timezone]">
			<?php if(is_array($arrTime)): foreach($arrTime as $k=>$vo): ?><option <?php if($k == C('ik_timezone')): ?>selected="selected"<?php endif; ?> value="<?php echo ($k); ?>" ><?php echo ($vo); ?></option><?php endforeach; endif; ?>
		</select></td>
	</tr>
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>