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
<table cellspacing="2" cellpadding="2" class="helptable">
<tbody><tr><td>
<ul>
<li>系统内置了文章频道。您可以为这些频道进行重新命名，并确定是否显示在站点菜单上面。</li>
<li>如果您在站点 <u>文章管理</u> 里面未开启某个频道功能，则该频道不会显示在站点菜单上面。</li>
<li>您也可以添加自己的频道，频道将会在站点的文章首页显示，也可以指定频道访问地址为其他网站页面。</li>
<li>自己添加的频道名称请用英文表示 如：新闻 <u><em>news</em></u> 并且不要使用下划线等特殊字符；这样有助于SEO。</li>
</ul>
</td></tr>
</tbody>
</table>
<div class="tabnav">
<ul>
<?php if(is_array($menu)): foreach($menu as $key=>$item): if($key == $ik): ?><li class="select"><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<form method="POST" action="<?php echo U('article/channel',array('ik'=>'add'));?>">
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>频道名称：</th>
		<td><input name="name" value="" /></td>
	</tr>
	<tr>
		<th>英文名称ID：</th>
		<td><input name="nameid" value=""/> (请不要包含下划线)</td>
	</tr>
	<tr>
		<th>文章分类：</th>
		<td><textarea cols="37" rows="8" name="catename"></textarea> (一行一个分类，多个元素用"回车"格开。)</td>
</td>
	</tr>    
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>