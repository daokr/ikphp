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
        
</div><?php endif; ?>

<!--APP NAV-->

</header>
<!--main-->
<div class="midder">
	<div class="mc">
    	<h1><?php echo ($seo["title"]); ?></h1>
    	<div class="cleft">
        	

  <table width="100%" cellpadding="0" cellspacing="0" class="showtable">
      <tr>
        <td width="75" valign="top">
        <?php if($touser[userid] > 0): ?><a href="<?php echo U('people/index',array('id'=>$touser[doname]));?>" class="nbg">
       	 <img alt="<?php echo ($touser[username]); ?>" style="padding:5px;" src="<?php echo ($touser[face]); ?>">
        </a>
        <?php else: ?>
         <img alt="<?php echo ($touser[username]); ?>" style="padding:5px;" src="<?php echo ($touser[face]); ?>"><?php endif; ?>
        </td>
        <td valign="top">
   
          <div class="pl2"><?php echo ($strUserinfo); ?></div>
          <div class="pl2">时间: <?php echo ($arrMessages[addtime]); ?></div>
          <div class="ul"><span class="pl2">话题: </span><span class="m"><?php echo ($arrMessages[title]); ?></span></div>
          <div class="messagebox">
          <?php echo nl2br($arrMessages[content]) ?>
          </div>
          <?php if($type == 'inbox'): if($arrMessages[userid] != 0): ?><a class="submit"  title="回信" href="<?php echo U('message/write',array('touserid'=>$touser[userid]));?>">回信</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?>
          <a class="gray-submit" onclick="return confirm('真的要删除消息吗?')" title="删除" href="<?php echo U('message/doing',array('d'=>'del','type'=>'inbox','messageid'=>$arrMessages[messageid]));?>">删除</a><?php endif; ?>
          <?php if($type == 'outbox'): ?><a class="gray-submit" onclick="return confirm('真的要删除消息吗?')" title="删除" href="<?php echo U('message/doing',array('d'=>'del','type'=>'outbox','messageid'=>$arrMessages[messageid]));?>">删除</a><?php endif; ?>
          </td>
      </tr>
  </table>

             
        </div>
        <div class="cright">
            <?php if($type == 'inbox'): ?><p class="pl2">&gt; <a href="<?php echo U('message/ikmail',array('d'=>'inbox'));?>">返回到我的收件箱</a></p>
			<p class="pl2">&gt; <a href="<?php echo U('people/index',array('id'=>$touser[doname]));?>">去<?php echo ($touser[username]); ?>的主页看看</a></p><?php endif; ?>
            <?php if($type == 'outbox'): ?><p class="pl2">&gt; <a href="<?php echo U('message/ikmail',array('d'=>'outbox'));?>">回我的发件箱</a></p>
            <p class="pl2">&gt; <a href="<?php echo U('message/ikmail',array('d'=>'inbox'));?>">去我的收件箱</a></p><br/>
			<p class="pl2">&gt; <a href="<?php echo U('people/index',array('id'=>$touser[doname]));?>">去<?php echo ($touser[username]); ?>的主页看看</a></p><?php endif; ?>           
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
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  <a href="http://www.miibeian.gov.cn/" target="_blank">京ICP备13018602号</a> <br />
        <span style="font-size:0.83em;">{__RUNTIME__}</span>
        
        <script src="http://s6.cnzz.com/stat.php?id=5262498&web_id=5262498" language="JavaScript"></script>
        </p>   
    </div>
</div>
</footer>
</body>
</html>