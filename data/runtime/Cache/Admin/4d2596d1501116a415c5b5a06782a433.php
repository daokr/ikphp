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
<style>.fbox{float:left;width:45%;margin-right:10px;}</style>
<script>
$(document).ready(function(){
	$.getJSON("http://www.ikphp.com/ikphp/index.php?m=notice&a=isupdate&v=<?php echo (IKPHP_VERSION); ?>&callback=?", 
	function(data){
		$('#IKPHP_Notice').html(data);
	}); 
});
</script>
</head>
<body>

<div class="midder">
	<?php if(!empty($message)): ?><ul id="message_list">
    	<?php if(is_array($message)): $i = 0; $__LIST__ = $message;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="message"><?php echo ($val["content"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul><?php endif; ?>
<div class="fbox">
<h2>目录权限</h2>
<table>
<tr><td width="100">data目录</td><td>
<?php if(!is_writable('data')): ?><font color="red">不可写</font>(请设置为可写777权限)<?php else: ?>可写<?php endif; ?></td></tr>
<tr><td>data/static目录</td><td><?php if(!is_writable('./data/static')): ?><font color="red">不可写</font>(请设置为可写777权限)<?php else: ?>可写<?php endif; ?></td></tr>
<tr><td>data/upload目录</td><td><?php if(!is_writable('./data/upload')): ?><font color="red">不可写</font>(请设置为可写777权限)<?php else: ?>可写<?php endif; ?></td></tr>
<tr><td>data/config目录</td><td><?php if(!is_writable('./data/config')): ?><font color="red">不可写</font>(请设置为可写777权限)<?php else: ?>可写<?php endif; ?></td></tr>
</table>
</div>

<div class="fbox">
<h2>软件信息</h2>
<table>
<tr><td width="100">系统支持：</td><td><?php echo ($ikphp["ikphp_site_name"]); ?></td></tr>
<tr><td>程序版本：</td><td><?php echo ($ikphp["ikphp_version"]); ?></td></tr>
<tr><td>联系方式：</td><td><?php echo ($ikphp["ikphp_email"]); ?></td></tr>
<tr><td>官方网址：</td><td><a href="<?php echo ($ikphp["ikphp_site_url"]); ?>" target='_blank'><?php echo ($ikphp["ikphp_site_url"]); ?></a></td></tr>
</table>
</div>

<div class="fbox"> 
<h2>服务器信息</h2>
<table>
    <tr><td width="100">服务器软件：</td><td><?php echo ($system["web_server"]); ?></td></tr>
    <tr><td>操作系统：</td><td><?php echo ($system["server_os"]); ?></td></tr>
    <tr><td>PHP版本：</td><td><?php echo ($system["php_version"]); ?></td></tr>
    <tr><td>MySQL版本：</td><td><?php echo ($system["mysql_ver"]); ?></td></tr>
    <tr><td>物理路径：</td><td><?php echo ($system["document_root"]); ?></td></tr>
	 <tr><td>附件上传限制：</td><td><?php echo ($system["upload_max_filesize"]); ?></td></tr>
    <tr><td>图像处理：</td><td><?php echo ($system["gd_info"]); ?> </td></tr>
    <tr><td>语言：</td><td><?php echo ($system["server_language"]); ?></td></tr>
    <tr><td>gzip压缩：</td><td><?php echo ($system["zlib"]); ?></td></tr>
    <tr><td>CURL支持：</td><td><?php echo ($system["curl"]); ?></td></tr>
    <tr><td>执行时间限制：</td><td><?php echo ($system["max_execution_time"]); ?></td></tr>
    <tr><td>时区设置：</td><td><?php echo ($system["timezone"]); ?></td></tr>
</table>
</div>

<div class="fbox" id="admindex_msg">
<h2>爱客(<?php echo ($ikphp["ikphp_site_name"]); ?>)官方消息</h2>
<table id="IKPHP_Notice"></table>
</div>

</div>

</body>
</html>