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
                <li> <a href="http://www.ikphp.com" class="lnk-home" target="_blank">爱客首页</a></li>
                <li> <a href="<?php echo U('group/index');?>" class="lnk-group" target="_blank">爱客小组</a></li>
                <li> <a href="<?php echo U('article/index');?>" class="lnk-article" target="_blank">爱客阅读</a></li>
                <li> <a href="<?php echo U('location/index');?>" class="lnk-location" target="_blank">爱客同城</a></li>
                <li> <a href="<?php echo U('site/index');?>" class="lnk-site" target="_blank">爱客小站</a></li>
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
             
             <li>
             <a href="<?php echo U('article/index');?>">阅读</a>
             </li>   
             <li>
             <a href="<?php echo U('location/index');?>">同城</a>
             </li> 
             <li>
             <a href="<?php echo U('help/download');?>" style="color:#fff">IKPHP源码下载</a>
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
		<div id="search_menubar">
        	<div class="s_menu">
    <?php if(is_array($menu)): foreach($menu as $key=>$item): if($type == $key): ?><a class="s_select" href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a>
        <?php else: ?>
        <a href="<?php echo ($item[url]); ?>"><?php echo ($item[text]); ?></a><?php endif; endforeach; endif; ?>
</div>

<div class="mod-search">
  <form method="get" action="<?php echo U('search/index',array('type'=>$type));?>">
    <fieldset>
      <legend>搜索：</legend>
      <div class="inp"><input name="q" value="<?php echo ($kw); ?>" maxlength="60" size="22" ></div>
      <div class="inp-btn"><input type="submit" value="搜索"></div>
    </fieldset>
  </form>
</div>
        </div>
 		<div class="s_top">获得约 <?php echo ($total); ?> 条结果</div>

<?php if(is_array($arrGroup)): foreach($arrGroup as $key=>$item): ?><div class="result">
    <div class="pic">
    <a title="<?php echo ($item[groupname]); ?>" href="<?php echo U('group/show',array('id'=>$item[groupid]));?>" class="nbg"><img alt="<?php echo ($item[groupname]); ?>" src="<?php echo ($item[icon_48]); ?>" width="48" /></a>
    </div>
    <div class="content">
    <h3><span>[小组] </span>&nbsp;<a  href="<?php echo U('group/show',array('id'=>$item[groupid]));?>"><?php echo ($item[groupname]); ?></a></h3>
    <div class="info">创建于 <?php echo date('Y-m-d',$item[addtime]) ?> &nbsp; <?php echo ($item[count_user]); ?> 成员</div>
    <p><?php echo ($item[groupdesc]); ?></p>
    </div>
    </div><?php endforeach; endif; ?>  
<?php if(is_array($arrTopic)): foreach($arrTopic as $key=>$item): ?><div class="result">
    <div class="pic">
    <a title="<?php echo ($item[user][username]); ?>" href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>" class="nbg"><img alt="<?php echo ($item[user][username]); ?>" src="<?php echo ($item[user][face]); ?>" width="48" /></a>
    </div>
    <div class="content">
    <h3><span>[话题] </span>&nbsp;<a  href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>"><?php echo ($item[title]); ?></a></h3>
    <div class="info">小组：<a href="<?php echo U('group/show',array('id'=>$item[group][groupid]));?>"><?php echo ($item[group][groupname]); ?></a> 发表于 <?php echo date('Y-m-d',$item[addtime]); ?> &nbsp; <a href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>#comment"><?php echo ($item[count_comment]); ?> 回复</a></div>
    <p><?php echo ($item[content]); ?></p>
    </div>
    </div><?php endforeach; endif; ?> 
<?php if(is_array($arrUser)): foreach($arrUser as $key=>$item): ?><div class="result">
    <div class="pic">
    <a title="<?php echo ($item[username]); ?>" href="<?php echo U('people/index',array('id'=>$item[doname]));?>" class="nbg"><img alt="<?php echo ($item[username]); ?>" src="<?php echo ($item[face]); ?>" width="48" /></a>
    </div>
    <div class="content">
    <h3><span>[用户] </span>&nbsp;<a  href="<?php echo U('people/index',array('id'=>$item[doname]));?>"><?php echo ($item[username]); ?></a></h3>
    <div class="info"><?php echo date('Y-m-d',$item[addtime]); ?> 加入&nbsp; <a href="<?php echo U('user/followed',array('userid'=>$item[userid]));?>"><?php echo ($item[count_followed]); ?> 人关注</a></div>
    <p><?php echo ($item[signed]); ?></p>
    </div>
    </div><?php endforeach; endif; ?> 
      
		<div class="page"><?php echo ($pageUrl); ?></div>		
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