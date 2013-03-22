<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($seo["title"]); ?> - <?php echo ($seo["subtitle"]); ?></title>
<meta name="keywords" content="<?php echo ($seo["keywords"]); ?>" /> 
<meta name="description" content="<?php echo ($seo["description"]); ?>" /> 
<link rel="shortcut icon" href="__STATIC__/public/images/fav.ico" type="image/x-icon">
<style>__SITE_THEME_CSS__</style>
<!--[if gte IE 7]><!-->
    <link href="__STATIC__/public/js/dialog/skins5/idialog.css" rel="stylesheet" />
<!--<![endif]-->
<!--[if lt IE 7]>
    <link href="__STATIC__/public/js/dialog/skins5/idialog.css" rel="stylesheet" />
<![endif]-->
<script>var siteUrl = '__SITE_URL__';</script>
<script src="__STATIC__/public/js/jquery.js" type="text/javascript"></script>
<script src="__STATIC__/public/js/common.js" type="text/javascript"></script>
<script src="__STATIC__/public/js/all.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="__STATIC__/public/js/html5.js"></script>
<![endif]-->
<script src="__STATIC__/public/js/dialog/jquery.artDialog.min5.js" type="text/javascript"></script>
__EXTENDS_JS__
</head>

<body>
<!--头部开始-->
<header>
<div class="top_nav">
  <div class="top_bd">
    
    <div class="top_info">
        <?php if(empty($visitor)): ?><a href="<?php echo U('user/login');?>">登录</a> | <a href="<?php echo U('user/register');?>">注册</a>       
        <?php else: ?>
        <a id="newmsg" href="<?php echo U('message/inbox');?>">123</a> | 
        <a href="<?php echo U('people/index', array('id'=>$visitor['doname']));?>">
        	<?php echo ($visitor["username"]); ?>
        </a> | 
        <a href="<?php echo U('user/setbase');?>">设置</a> | 
        <a href="<?php echo U('user/logout');?>">退出</a><?php endif; ?>
    </div>


    <div class="top_items">
        <ul>
             <li>
             <a href="__SITE_URL__">爱客</a>
             </li>             

             <li>
             <a href="<?php echo U('group/index');?>">小组</a>
             </li>
             
             <li>
             <a href="<?php echo U('article/index');?>">文章</a>
             </li>                                          

        </ul>
    </div>
  	<div class="cl"></div>
    
  </div>
  
</div>
<!--header-->


<div id="header">
    
	<div class="site_nav">
        <div class="<?php echo ($logo[style]); ?>">
            <a href="<?php echo ($logo[url]); ?>"><?php echo ($logo[name]); ?></a>
        </div>
		<div class="appnav">
			    <ul id="nav_bar">
                    <?php if(is_array($arrNav)): foreach($arrNav as $key=>$item): ?><li><a href="<?php echo ($item[url]); ?>"><?php echo ($item[name]); ?></a></li><?php endforeach; endif; ?>
			    </ul>
		   <form onsubmit="return searchForm(this);" method="get" action="http://www.ik.com/index.php">
		   <input type="hidden" value="search" name="app"><input type="hidden" value="q" name="ac">
		    <div id="search_bar">
		        <div class="inp"><input type="text" placeholder="小组、话题、日志、成员、小站" value="小组、话题、日志、成员、小站" class="key" name="kw"></div>
		        <div class="inp-btn"><input type="submit" class="search-button" value="搜索"></div>
		    </div>
		    </form>
		</div>
        
        
		
        <div class="cl"></div>

	</div>
        
</div>
<!--APP NAV-->

</header>
<script>
$(document).ready(function() {
//选择一级区域
$('#oneid').change(function(){
	$("#stwoid").html('<img src="'+siteUrl+'static/public/images/loading.gif" />');
	var oneid = $(this).children('option:selected').val();  //弹出select的值
	
	if(oneid==0){
		$("#stwoid").html('');
		$("#sthreeid").html('');
	}else{
		$("#sthreeid").html('');
		$.ajax({
			type: "GET",
			url:  "<?php echo U('user/area',array('ik'=>'two'));?>",
			data: "oneid="+oneid,
			success: function(msg){
				$("#stwoid").html(msg);
				
				//选择二级区域
				$('#twoid').change(function(){
					$("#sthreeid").html('<img src="'+siteUrl+'static/public/images/loading.gif" />');
					var twoid = $(this).children('option:selected').val();  //弹出select的值
					
					if(twoid == 0){
						$("#sthreeid").html('');
					}else{
					
						//ajax
						$.ajax({
							type: "GET",
							url:  "<?php echo U('user/area',array('ik'=>'three'));?>",
							data: "twoid="+twoid,
							success: function(msg){
								$('#sthreeid').html(msg);
							}
						});
					
					}

				});
				
			}
		});
	
	}
	
});

});
</script>

<!--main-->
<div class="midder">
<div class="mc">
<h1 class="set_tit">用户信息管理</h1>
<div class="tabnav">
<ul>
<?php if(is_array($user_menu_list)): $i = 0; $__LIST__ = $user_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if($user_menu_curr == $key): ?><li class="select"><a href="<?php echo ($menu["url"]); ?>" ><?php echo ($menu["text"]); ?></a></li>
<?php else: ?>
<li><a href="<?php echo ($menu["url"]); ?>" ><?php echo ($menu["text"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>

<div class="utable">
<form method="POST" action="<?php echo U('user/setcity');?>">
<table cellpadding="0" cellspacing="0" width="100%" class="table_1">
<tr>
<th>常居地：</th>
<td>
<?php if(!empty($strarea)): echo ($strarea[one][areaname]); ?> 
<?php echo ($strarea[two][areaname]); ?> 
<?php echo ($strarea[three][areaname]); endif; ?>
</td>
</tr>

<tr>
<th>修改常居地：</th>
<td>
<select id="oneid" name="oneid" class="txt">
<option value="0">请选择</option>
<?php if(is_array($arrOne)): $i = 0; $__LIST__ = $arrOne;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo[areaid]); ?>"><?php echo ($vo[areaname]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
<span id="stwoid"></span>
<span id="sthreeid"></span>
</td>
</tr>
<tr>
	<th></th>
    <td><input class="submit" type="submit" value="修改"  /></td>
</tr>
</table>
</form>


</div>
</div>
</div>
<!--footer-->
<footer>
<div id="footer">
	<div class="f_content">
        <span class="fl gray-link" id="icp">
            &copy; 2012－2015 IKPHP.COM, all rights reserved
        </span>
        
        <span class="fr">
            <a href="<?php echo U('home/about');?>">关于爱客</a>
            · <a href="<?php echo U('home/contact');?>">联系我们</a>
            · <a href="<?php echo U('home/agreement');?>">用户条款</a>
            · <a href="<?php echo U('home/privacy');?>">隐私申明</a>
        </span>
        <div class="cl"></div>
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  <?php echo C('site_icp');?> <span style="color:green">ThinkPHP 版本 <?php echo (THINK_VERSION); ?></span><br /><span style="font-size:0.83em;"></span>
        
        <!--<script src="http://s21.cnzz.com/stat.php?id=2973516&web_id=2973516" language="JavaScript"></script>-->
        </p>   
    </div>
</div>
</footer>
</body>
</html>