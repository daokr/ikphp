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
<div class="tabnav">
<ul>
<?php if(is_array($arrChannel)): foreach($arrChannel as $key=>$item): if($item[nameid] == $nameid): ?><li class="select"><a href="<?php echo U('article/cate',array('ik'=>'list','nameid'=>$item[nameid]));?>"><?php echo ($item[name]); ?></a></li>
    <?php else: ?>
    <li><a href="<?php echo U('article/cate',array('ik'=>'list','nameid'=>$item[nameid]));?>"><?php echo ($item[name]); ?></a></li><?php endif; endforeach; endif; ?>
</ul>
</div>
<div class="Toolbar_inbox">
	<a class="btn_a" href="<?php echo U('article/cate',array('ik'=>'add','nameid'=>$nameid));?>"><span>添加分类</span></a>
</div>
<form method="POST" action="<?php echo U('article/cate',array('ik'=>'delete','cateid'=>$strCate[cateid]));?>">
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>请选择您的动作：</th>
		<td>
            <select name="newcateid" style="float:left;" >
                <?php echo ($arrCate); ?>
            </select>&nbsp;&nbsp;(合并将删除原有的分类,原有分类内的文章将全部移动到新分类中。)</td>
	</tr>
	</tr>    
</table>
<div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>

</form>
</div>
</body>
</html>