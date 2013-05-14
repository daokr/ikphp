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
<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td>英文名称</td>
<td>频道名</td>
<td width="200">操作</td>
<td width="100">导航</td>
</tr>
<?php if(is_array($arrChannel)): foreach($arrChannel as $key=>$item): ?><tr class="odd">
<td><?php echo ($item[nameid]); ?></td>
<td><?php echo ($item[name]); ?></td>
<td>
<a href="<?php echo U('article/channel',array('ik'=>'edit','nameid'=>$item[nameid]));?>">[编辑]</a> 
<a href="index.php?m=article&a=channel&nameid=<?php echo ($item[nameid]); ?>" target="_blank">[访问]</a> 
</td>
<td>
<?php if($item[isnav] == 0): ?><a href="<?php echo U('article/channel',array('ik'=>'isnav','isnav'=>1,'nameid'=>$item[nameid]));?>">[取消导航]</a>
<?php else: ?>
<a href="<?php echo U('article/channel',array('ik'=>'isnav','isnav'=>0,'nameid'=>$item[nameid]));?>">[开启导航]</a><?php endif; ?>
</td>
<tr><?php endforeach; endif; ?>
</table>

</div>
</body>
</html>