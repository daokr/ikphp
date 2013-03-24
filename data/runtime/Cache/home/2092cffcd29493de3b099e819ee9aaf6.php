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
             <a href="<?php echo U('article/index');?>">阅读</a>
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
    <div class="cleft">
        <div class="art-body">
            <h1 class="title"><?php echo ($strArticle[title]); ?></h1>
            <div class="art-info">
            作者：<a href="<?php echo U('people/index',array('id'=>$strArticle[user][doname]));?>"><?php echo ($strArticle[newsauthor]); ?></a>&nbsp;&nbsp;<?php echo date('Y-m-d H:i',$strArticle[addtime]) ?>&nbsp;&nbsp;<a href="#comments"><?php echo ($strArticle[count_comment]); ?>条回复</a>&nbsp;&nbsp;浏览<?php echo ($strArticle[count_view]); ?>次&nbsp;&nbsp;<a href="#formMini">我要回复</a> 
            </div>
        
            <div class="art-text">
                 <?php echo ($strArticle[content]); ?>
            </div>
            <div class="control-btns">
            <?php if($visitor[userid] == $strArticle[userid]): ?><a href="<?php echo U('article/edit',array('id'=>$strArticle['aid']));?>">编辑</a>&nbsp; &gt;&nbsp; <a href="<?php echo U('article/delete',array('id'=>$strArticle['aid']));?>" onclick="return confirm('确定删除?')">删除</a><?php endif; ?>
            <br/>
            本文由<a href="<?php echo U('people/index',array('id'=>$strArticle[user][doname]));?>"><?php echo ($strArticle[user][username]); ?></a>授权（爱客网）发表，文章著作权为原作者所有
            </div>
            
      	  <div class="clear"></div>
          <div class="art-titles"> 
             <span class="fl"><?php if(!empty($upArticle)): ?>上一篇：<a href="<?php echo U('article/show',array('id'=>$upArticle['aid']));?>"><?php echo ($upArticle['title']); ?></a><?php endif; ?></span>
             <span class="fr"><?php if(!empty($downArticle)): ?>下一篇：<a href="<?php echo U('article/show',array('id'=>$downArticle['aid']));?>"><?php echo ($downArticle['title']); ?></a><?php endif; ?></span>
          </div>
      </div>
    
    
    
    </div>


    <div class="cright">
    
        <div class="mod" id="g-user-profile">

    <div class="usercard">
      <div class="pic">
            <a href="<?php echo U('people/index',array('id'=>$strUser[doname]));?>"><img alt="<?php echo ($strUser[username]); ?>" src="<?php echo ($strUser[face]); ?>"></a>
      </div>
      <div class="info">
           <div class="name">
               <a href="<?php echo U('people/index',array('id'=>$strUser[doname]));?>"><?php echo ($strUser[username]); ?></a>
           </div>
                <?php if($strUser[area] != ''): echo ($strUser[area][areaname]); else: ?>火星<?php endif; ?>                        
                <br>
       </div>
    </div>
               
  
             
</div> 
         
<div class="mod">
    <?php if($visitor): ?><div class="create-group">
    <a href="<?php echo U('article/add');?>"><i>+</i>去投稿</a>
    </div><?php endif; ?>
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