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
<?php if($ik != 'addsubcate' && $ik != 'subcatelist'): ?><div class="tabnav">
<ul>
<?php if(is_array($menu)): foreach($menu as $key=>$item): if($key == $ik): ?><li class="select"><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<?php else: ?>
<div class="Toolbar_inbox">
    <a class="btn_a" href="<?php echo U('event/cate',array('ik'=>'catelist'));?>"><span>返回</span></a>
	<a class="btn_a" href="<?php echo U('event/cate',array('ik'=>'addsubcate','id'=>$strCate[cateid]));?>"><span>添加子分类</span></a>
</div><?php endif; ?>

<form method="POST" action="<?php echo U('event/cate',array('ik'=>'addcate','referid'=>$referid));?>">
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>分类名称：</th>
		<td>
        <textarea cols="37" rows="8" name="catename"></textarea>
        (一行一个 分类=英文，英文名称请不要包含下划线；多个元素用"回车"格开。如：音乐=music)
        </td>
</td>
	</tr>    
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>