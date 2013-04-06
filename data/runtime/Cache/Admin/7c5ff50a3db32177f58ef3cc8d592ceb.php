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
<?php if(is_array($arrMenu)): $i = 0; $__LIST__ = $arrMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($key == $infokey): ?><li class="select"><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<form method="POST" action="<?php echo U('home/page',array('infokey'=>$infokey));?>" enctype="multipart/form-data">
<table  cellpadding="0" cellspacing="0">
<tr><td><?php echo ($title); ?></td></tr>
<tr><td><textarea style="width:600px;height:300px" name="infocontent" class="uinput"><?php echo ($strInfo[infocontent]); ?></textarea></td></tr>
<tr><td>
<input type="submit" value="提 交"  class="submit"/></td></tr>
</table>
</form>
</div>
</body>
</html>