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
<form method="POST" action="<?php echo U('area/add',array('ik'=>$ik));?>">
<table cellpadding="0" cellspacing="0">
    <tr>
        <th>名称：</th>
        <td><input type="hidden" value="<?php echo ($str[areaid]); ?>" name="id"/>
        <textarea cols="37" rows="8" name="areaname"></textarea> (一行一个，名称=索引字母，多个元素用"回车"格开。如：北京=B)</td>
    </tr>    
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>