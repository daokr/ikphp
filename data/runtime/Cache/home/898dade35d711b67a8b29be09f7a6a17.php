<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($seo["title"]); ?> - <?php echo ($seo["subtitle"]); ?></title>
<meta name="keywords" content="<?php echo ($seo["keywords"]); ?>" /> 
<meta name="description" content="<?php echo ($seo["description"]); ?>" /> 
<meta property="wb:webmaster" content="c9fd7603df8ff038" />
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
<script src="__STATIC__/public/js/IK.js" type="text/javascript" data-cfg-autoload="false"></script>
<script src="__STATIC__/public/js/all.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="__STATIC__/public/js/html5.js"></script>
<![endif]-->
<script src="__STATIC__/public/js/dialog/jquery.artDialog.min5.js" type="text/javascript"></script> 
__EXTENDS_JS__
<script src="http://l.tbcdn.cn/apps/top/x/sdk.js?appkey=21509482"></script>
</head>

<body>
<!--头部开始-->
<header>
<?php if($module_name == 'index' && empty($visitor)): ?><div class="hd-wrap">
            <div class="hd">
                <div class="logo">
                    <h1><a href="__SITE_URL__" title="爱客开源">爱客开源</a></h1>
                </div>
                <div class="top-nav-items">
                <ul>
                <li><a href="http://www.ikphp.com" class="lnk-home" target="_blank">爱客首页</a></li>
                <li><a href="<?php echo U('group/index');?>" class="lnk-group" target="_blank">爱客小组</a></li>
                <li><a href="<?php echo U('article/index');?>" class="lnk-article" target="_blank">爱客阅读</a></li>
                <li><a href="<?php echo U('location/index');?>" class="lnk-location" target="_blank">爱客同城</a></li>
                <li><a href="<?php echo U('site/index');?>" class="lnk-site" target="_blank">爱客小站</a></li>
                <li><a href="<?php echo U('mall/index');?>" class="lnk-mall" target="_blank">爱客商城</a></li>
                </ul>
                </div>
            </div>
</div>
<?php else: ?>
<div class="top_nav">
  <div class="top_bd">
    
    <div class="top_info">
        <?php if(empty($visitor)): ?><a href="<?php echo U('user/login');?>">登录</a> | <a href="<?php echo U('user/register');?>">注册</a> | <a href="<?php echo U('oauth/index', array('mod'=>'qq'));?>" target="_blank" style="margin-left:10px"><img  align="absmiddle" title="QQ登录" src="__STATIC__/public/images/connect_qq.png"> 登录</a> | <a href="<?php echo U('oauth/index', array('mod'=>'sina'));?>" target="_blank" style="margin-left:10px"><img  align="absmiddle" title="新浪微博" src="__STATIC__/public/images/connect_sina_weibo.png"> 登录</a>    
        <?php else: ?>
        <a id="newmsg" href="<?php echo U('message/ikmail',array('d'=>'inbox'));?>">新消息(<?php echo ($count_new_msg); ?>)</a> | 
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
             
             <li><a href="<?php echo U('article/index');?>">阅读</a></li>  
             <li><a href="<?php echo U('location/index');?>">同城</a></li>
             <li><a href="<?php echo U('mall/index');?>">淘客</a></li>  
             <li><a href="<?php echo U('site/index');?>">小站</a></li>             
             <li><a href="<?php echo U('help/download');?>" style="color:#fff">IKPHP源码下载</a></li>                                                      

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
                    <?php if(is_array($arrNav)): foreach($arrNav as $key=>$item): ?><li><a href="<?php echo ($item[url]); ?>" class="a_<?php echo ($key); ?>"><?php echo ($item[name]); ?></a></li><?php endforeach; endif; ?>
			    </ul>
		   <form onsubmit="return searchForm(this);" method="GET" action="<?php echo U('search/index');?>">
                <input type="hidden" value="all" name="type">
                <div id="search_bar">
                    <div class="inp"><input type="text" placeholder="小组、话题、日志、成员、小站" value="" class="key" name="q"></div>
                    <div class="inp-btn"><input type="submit" class="search-button" value="搜索"></div>
                </div>
		    </form>
		</div>

        <div class="cl"></div>

	</div>
        
</div><?php endif; ?>

<!--APP NAV-->

</header>
<div class="midder">
	<div class="mc">
    	
        <div class="focus_bar">
        	<div class="cleft">
            	<ul>
                	<li><a href="#"><img src="http://static.guang.com/img/event/zhutiset08/zhuti-banner.jpg" width="640" height="200"></a></li>
                </ul>
            </div>
            <div class="cright">
            	<a href="#" class="create">+创建新专辑</a>
                <a href="#" class="post marl">+发布心得</a>
                <div class="hotuser">
                	<ul>
                    	<li><img src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg" width="60" height="60"></li>
                        <li><img src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg" width="60" height="60"></li>
                        <li><img src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg" width="60" height="60"></li>
                        <li><img src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg" width="60" height="60"></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="mod">
       	 <h1>居家</h1>
        <div class="album_wrap clearfix">
            <ul class="album_list clearfix">


		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>


		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>                        
            
	  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>


		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>                        
                        
                            
            </ul>
        </div>         
        </div>
        
<div class="mod">
       	 <h1>美妆</h1>
        <div class="album_wrap clearfix">
            <ul class="album_list clearfix">


		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>


		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>                        
            
	  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>


		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>
            
		  <li class="album_item">
                    <div class="album_author">
                        <a target="_blank" href="#">
                        <img src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172" class="fl" data-uid="<?php echo ($album["uid"]); ?>" alt="<?php echo ($album["uname"]); ?>">
                        </a>
                        <div class="album_info">
                            <p><a title="" href="" class="album_title" target="_blank">夏日阳光专辑</a></p>
                            <p class="u_link"><a href="#"  target="_blank">每个菇凉都是高跟控。</a></p>
                        </div>
                    </div>
                    <ul class="album_bd">
                        
                        <li class="big">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s6.img.guang.com/p/2345821_1_4378231_470X470.jpg" width="220" height="220"/></a>
                        </li>
                        <li class="left small">
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s9.img.guang.com/p/1934924_1_7523393_80X80.jpg"/></a>
                        </li>
                        <li class="small">    
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s4.img.guang.com/p/2067614_1_4307113_71X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s0.img.guang.com/p/2067750_1_3306059_59X80.jpg"/></a>
                        </li>
                        <li class="small">  
                            <a href="#" target="_blank"><img class="" data-uri="" src="http://s2.img.guang.com/p/2034545_1_9987317_79X80.jpg"/></a>
                        </li>
    
                 </ul>
            </li>                        
                        
                            
            </ul>
        </div>         
        </div>    	
     
        
    </div>
</div>

<div class="user_card">
	<div class="card_bd">
            <div class="card_info">
                <a href="#" target="_blank" class="fl uava">
                	<img class="avatar" src="http://www.ikphp.com/data/upload/face/000/00/00/c81e728d9d4c2f636f067f89cc14862c_48_48.jpg?v=1368784172">
                </a>
                <div class="info fl">
                    <p><a href="#" class="uname" target="_blank">小麦</a></p>
                    <p>北京 朝阳</p>
                    <p>
                        宝贝 <a target="_blank" href="#"><span>12</span></a>
                        专辑 <a target="_blank" class="ml10" href="#"><span>60</span></a> 
                        粉丝 <a target="_blank" class="ml10" href="#"><span>300</span></a>
                     </p>
                </div>
                <div class="intro">
                   <p>这个家伙太懒，什么都木留下~</p>
                   <!--<p>简约字母棒球衣 不同于以往的短袖 长款 带点小透哦 真的很休闲哦！而且超百搭！</p>-->
                </div>
            </div>
            <div class="card_toolbar">
                    <a href="javascript:;" class="follow">+关注</a> <a target="_blank" class="sendmsg" href="#">发私信</a>
            </div>
     </div>
     <div class="card_arrow"></div>
</div>


  
<!--footer-->
<footer>
<div id="footer">
	<div class="f_content">
        <span class="fl gray-link" id="icp">
            &copy; 2012－2015 IKPHP.COM, all rights reserved <span><a href="http://www.miibeian.gov.cn/" target="_blank">京ICP备13018602号</a></span>
        </span>
        
        <span class="fr">
            <a href="<?php echo U('help/about');?>">关于爱客</a>
            · <a href="<?php echo U('help/contact');?>">联系我们</a>
            · <a href="<?php echo U('help/agreement');?>">用户条款</a>
            · <a href="<?php echo U('help/privacy');?>">隐私申明</a>
        </span>
        <div class="cl"></div>
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  目前有 <?php echo ($count_online_user); ?> 人在线<br />
        <span style="font-size:0.83em;">{__RUNTIME__}          </span>

        <script src="http://s6.cnzz.com/stat.php?id=5262498&web_id=5262498" language="JavaScript"></script>
       
        </p>   
    </div>
</div>
</footer>
</body>
</html>