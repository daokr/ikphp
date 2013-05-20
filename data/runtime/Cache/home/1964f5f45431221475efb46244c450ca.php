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
             <li><a href="<?php echo U('app/index');?>">应用商店</a></li>             
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
    <h1><?php echo ($seo["title"]); ?></h1>
    <div class="cleft w700">
		       
        <div class="topics">
        <ul>
            <?php if(is_array($list)): foreach($list as $key=>$item): ?><li>
            <div class="content">
            <div class="title">
            <a href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>"><?php echo ($item[title]); ?></a>
            </div>
        
            <p><?php echo getsubstrutf8(t($item['content']),0,100) ?></p>
            <div class="from"><span class="reply-num"><a href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>#comment"><?php echo ($item[count_comment]); ?> 回应</a></span> <span class="fav-num"><a href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>#like"><?php echo ($item[count_collect]); ?> 喜欢</a></span>
            <div class="from-group">来自: <span class="group-name"><a href="<?php echo U('group/show',array('id'=>$item[groupid]));?>"><?php echo ($item[group][groupname]); ?></a> 小组</span></div>
            </div>
            </div>
            </li><?php endforeach; endif; ?>
        </ul>
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
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'兴趣'));?>"><b>•</b>兴趣</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'旅行'));?>">旅行</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'摄影'));?>">摄影</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'影视'));?>">影视</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'音乐'));?>">音乐</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'文学'));?>">文学</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'游戏'));?>">游戏</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'动漫'));?>">动漫</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'运动'));?>">运动</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'戏曲'));?>">戏曲</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'桌游'));?>">桌游</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'怪癖'));?>">怪癖</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'生活'));?>"><b>•</b>生活</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'健康'));?>">健康</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'美食'));?>">美食</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'宠物'));?>">宠物</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'美容'));?>">美容</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'化妆'));?>">化妆</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'护肤'));?>">护肤</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'服饰'));?>">服饰</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'公益'));?>">公益</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'家庭'));?>">家庭</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'育儿'));?>">育儿</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'汽车'));?>">汽车</a></li>
       </ul>
    </div>
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'购物'));?>"><b>•</b>购物</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'淘宝'));?>">淘宝</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'二手'));?>">二手</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'团购'));?>">团购</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'数码'));?>">数码</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'品牌'));?>">品牌</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'文具'));?>">文具</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'社会'));?>"><b>•</b>社会</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'求职'));?>">求职</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'租房'));?>">租房</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'励志'));?>">励志</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'留学'));?>">留学</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'出国'));?>">出国</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'理财'));?>">理财</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'传媒'));?>">传媒</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'创业'));?>">创业</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'考试'));?>">考试</a></li>
       </ul>
    </div>
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'艺术'));?>"><b>•</b>艺术</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'设计'));?>">设计</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'手工'));?>">手工</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'展览'));?>">展览</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'曲艺'));?>">曲艺</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'舞蹈'));?>">舞蹈</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'雕塑'));?>">雕塑</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'纹身'));?>">纹身</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'学术'));?>"><b>•</b>学术</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'人文'));?>">人文</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'社科'));?>">社科</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'自然'));?>">自然</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'建筑'));?>">建筑</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'国学'));?>">国学</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'语言'));?>">语言</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'宗教'));?>">宗教</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'哲学'));?>">哲学</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'软件'));?>">软件</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'硬件'));?>">硬件</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'互联网'));?>">互联网</a></li>
       </ul>
    </div>
   <div class="group-cate">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'情感'));?>"><b>•</b>情感</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'恋爱'));?>">恋爱</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'心情'));?>">心情</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'心理学'));?>">心理学</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'星座'));?>">星座</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'塔罗'));?>">塔罗</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'LES'));?>">LES</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'GAY'));?>">GAY</a></li>
       </ul>
    </div>
   <div class="group-cate odd">
       <ul>
           <li class="cate-label"><a href="<?php echo U('group/explore_topic',array('tag'=>'闲聊'));?>"><b>•</b>闲聊</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'吐槽'));?>">吐槽</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'笑话'));?>">笑话</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'直播'));?>">直播</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'八卦'));?>">八卦</a></li>
       <li><a href="<?php echo U('group/explore_topic',array('tag'=>'发泄'));?>">发泄</a></li>
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