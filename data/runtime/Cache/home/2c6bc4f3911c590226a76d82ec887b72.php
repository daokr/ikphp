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
             
             <li>
             <a href="<?php echo U('article/index');?>">阅读</a>
             </li>   
             
             <li>
             <a href="http://www.ikphp.com/down/IKPHP_Beta_1.5.zip" style="color:#fff" title="beta版1.5">IKPHP_Beta版1.5源码下载</a>
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

<div class="midder">
<div class="mc">
    <h1><?php echo ($seo["title"]); ?></h1>
    <div class="cleft w700">
		
        <div class="group-list">
        	<?php if(is_array($list)): foreach($list as $key=>$item): ?><div class="result">
                <div class="pic">
                <a title="<?php echo ($item[groupname]); ?>" href="<?php echo U('group/show',array('id'=>$item[groupid]));?>" class="nbg">
                	<img src="<?php echo ($item[icon_48]); ?>" alt="<?php echo ($item[groupname]); ?>" width="48" height="48">
                </a>
                </div>
                <div class="content">
                    <div class="title">
                        <h3><a href="<?php echo U('group/show',array('id'=>$item[groupid]));?>"><?php echo ($item[groupname]); ?></a></h3>
                    </div>
                    <div class="info"><?php echo ($item[count_user]); ?> 个成员 在此聚集 </div>
                    <div><p><?php echo ($item[groupdesc]); ?></p></div>
                </div>
            </div><?php endforeach; endif; ?>
                        
        </div>
        
        <div class="clear"></div>
        <div class="page"><?php echo ($pageUrl); ?></div>

    </div>



    <div class="cright w250">
		     <h2>
        按分类浏览    
    </h2>

   <div class="group-cate-bd">
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'兴趣'));?>"><b>•</b>兴趣</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'旅行'));?>">旅行</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'摄影'));?>">摄影</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'影视'));?>">影视</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'音乐'));?>">音乐</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'文学'));?>">文学</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'游戏'));?>">游戏</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'动漫'));?>">动漫</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'运动'));?>">运动</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'戏曲'));?>">戏曲</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'桌游'));?>">桌游</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'怪癖'));?>">怪癖</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'生活'));?>"><b>•</b>生活</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'健康'));?>">健康</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'美食'));?>">美食</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'宠物'));?>">宠物</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'美容'));?>">美容</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'化妆'));?>">化妆</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'护肤'));?>">护肤</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'服饰'));?>">服饰</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'公益'));?>">公益</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'家庭'));?>">家庭</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'育儿'));?>">育儿</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'汽车'));?>">汽车</a></li>
       </ul>
    </div>
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'购物'));?>"><b>•</b>购物</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'淘宝'));?>">淘宝</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'二手'));?>">二手</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'团购'));?>">团购</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'数码'));?>">数码</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'品牌'));?>">品牌</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'文具'));?>">文具</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'社会'));?>"><b>•</b>社会</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'求职'));?>">求职</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'租房'));?>">租房</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'励志'));?>">励志</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'留学'));?>">留学</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'出国'));?>">出国</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'理财'));?>">理财</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'传媒'));?>">传媒</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'创业'));?>">创业</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'考试'));?>">考试</a></li>
       </ul>
    </div>
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'艺术'));?>"><b>•</b>艺术</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'设计'));?>">设计</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'手工'));?>">手工</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'展览'));?>">展览</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'曲艺'));?>">曲艺</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'舞蹈'));?>">舞蹈</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'雕塑'));?>">雕塑</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'纹身'));?>">纹身</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'学术'));?>"><b>•</b>学术</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'人文'));?>">人文</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'社科'));?>">社科</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'自然'));?>">自然</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'建筑'));?>">建筑</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'国学'));?>">国学</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'语言'));?>">语言</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'宗教'));?>">宗教</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'哲学'));?>">哲学</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'软件'));?>">软件</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'硬件'));?>">硬件</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'互联网'));?>">互联网</a></li>
       </ul>
    </div>
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'情感'));?>"><b>•</b>情感</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'恋爱'));?>">恋爱</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'心情'));?>">心情</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'心理学'));?>">心理学</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'星座'));?>">星座</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'塔罗'));?>">塔罗</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'LES'));?>">LES</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'GAY'));?>">GAY</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore',array('tagname'=>'闲聊'));?>"><b>•</b>闲聊</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'吐槽'));?>">吐槽</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'笑话'));?>">笑话</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'直播'));?>">直播</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'八卦'));?>">八卦</a></li>
       <li><a href="<?php echo U('group/explore',array('tagname'=>'发泄'));?>">发泄</a></li>
       </ul>
    </div>
   </div>
  	
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
            <a href="<?php echo U('help/about');?>">关于爱客</a>
            · <a href="<?php echo U('help/contact');?>">联系我们</a>
            · <a href="<?php echo U('help/agreement');?>">用户条款</a>
            · <a href="<?php echo U('help/privacy');?>">隐私申明</a>
        </span>
        <div class="cl"></div>
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  <?php echo C('site_icp');?> <span style="color:green">ThinkPHP 版本 <?php echo (THINK_VERSION); ?></span><br />
        <span style="font-size:0.83em;">{__RUNTIME__}</span>
        
        <!--<script src="http://s21.cnzz.com/stat.php?id=2973516&web_id=2973516" language="JavaScript"></script>-->
        </p>   
    </div>
</div>
</footer>
</body>
</html>