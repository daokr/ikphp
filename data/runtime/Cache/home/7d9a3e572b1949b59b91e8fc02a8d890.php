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
        	<div class="cleft"></div>
            <div class="cright">
            
            </div>
        </div>
        
    	<div class="floor">
			<h2>1F 服饰内衣</h2>
            <div class="floorTop">
                    <ul class="floorTop-nav">
                        
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.1.aewDEi&amp;q=%C3%C0%B0%D7&amp;user_action=initiative&amp;at_topsearch=1&amp;sort=st&amp;type=p&amp;cat=&amp;style=" data-spm-anchor-id="3.1000473.295813.1">美白</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.2.aewDEi&amp;active=1&amp;from=sn_1_rightnav&amp;area_code=330100&amp;search_condition=7&amp;style=g&amp;sort=s&amp;n=60&amp;s=0&amp;cat=50043479" data-spm-anchor-id="3.1000473.295813.2">洗护</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.3.aewDEi&amp;start_price=&amp;end_price=&amp;zk_type=0&amp;wwonline=1&amp;search_condition=16&amp;cat=50026506&amp;sort=s&amp;style=g&amp;vmarket=0&amp;active=1&amp;q=" data-spm-anchor-id="3.1000473.295813.3">男士</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.4.aewDEi&amp;cat=50031564&amp;acm=08227.1003.1.50031564_6&amp;scm=1003.3.08227.1" data-spm-anchor-id="3.1000473.295813.4">BB霜</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.5.aewDEi&amp;cat=50031562&amp;acm=08227.1003.1.50031562_6&amp;scm=1003.3.08227.1" data-spm-anchor-id="3.1000473.295813.5">粉底</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.6.aewDEi&amp;cat=50040799&amp;acm=08225.1003.1.50040799_6&amp;scm=1003.3.08225.1" data-spm-anchor-id="3.1000473.295813.6">脱毛膏</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.7.aewDEi&amp;start_price=&amp;end_price=&amp;zk_type=0&amp;wwonline=1&amp;search_condition=16&amp;cat=50043345&amp;sort=s&amp;style=g&amp;vmarket=0&amp;from=sn_1_cat&amp;q=" data-spm-anchor-id="3.1000473.295813.7">珍珠</a></li>
                                            <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295813.8.aewDEi&amp;q=&amp;area_code=310000&amp;sort=s&amp;style=g&amp;vmarket=0&amp;from=sn_1_guide&amp;guideType=0&amp;guide=266%3A1103&amp;cat=50862010" data-spm-anchor-id="3.1000473.295813.8">户外专业表</a></li>
                                        
                    </ul>
            </div>
            <div class="floorCon clearfix">
            	<ul class="plist">
                	<li><a href="#"><img src="http://img03.taobaocdn.com/tps/i3/T1mDGGXx8XXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img03.taobaocdn.com/tps/i3/T1mDGGXx8XXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img03.taobaocdn.com/tps/i3/T1mDGGXx8XXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img03.taobaocdn.com/tps/i3/T1mDGGXx8XXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img03.taobaocdn.com/tps/i3/T1mDGGXx8XXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
               
                </ul>
            </div>
                
        </div>

		<div class="floor">
			<h2>2F 鞋包运动</h2>
            <div class="floorTop">
                    <ul class="floorTop-nav">
                    
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.1.aewDEi&amp;zk_type=0&amp;pic_detail=1&amp;cat=50025829&amp;sort=s&amp;style=g&amp;vmarket=0&amp;active=1&amp;q=" data-spm-anchor-id="3.1000473.295828.1">女鞋</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.2.aewDEi&amp;zk_type=0&amp;pic_detail=1&amp;cat=50026637&amp;sort=s&amp;style=g&amp;vmarket=0&amp;from=sn_1_leftnav&amp;active=1&amp;q=" data-spm-anchor-id="3.1000473.295828.2">男鞋</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.3.aewDEi&amp;cat=50040639&amp;s=0&amp;n=60&amp;sort=s&amp;style=g&amp;zk_type=0&amp;vmarket=0&amp;pic_detail=1&amp;area_code=310000&amp;from=sn_1_cat&amp;active=1" data-spm-anchor-id="3.1000473.295828.3">凉鞋</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.4.aewDEi&amp;cat=50106425&amp;s=0&amp;n=60&amp;sort=s&amp;style=g&amp;zk_type=0&amp;vmarket=0&amp;pic_detail=1&amp;area_code=310000&amp;from=sn_1_cat&amp;active=1#J_crumbs" data-spm-anchor-id="3.1000473.295828.4">低帮鞋</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.5.aewDEi&amp;cat=50023743&amp;search_condition=16&amp;sort=s&amp;style=g&amp;vmarket=0&amp;nav=spu-cat&amp;navlog=4&amp;from=sn_1_cat&amp;active=1&amp;prt=1340263457208&amp;prc=1" data-spm-anchor-id="3.1000473.295828.5">跑步</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.6.aewDEi&amp;active=1&amp;from=sn_1_cat&amp;area_code=330100&amp;search_condition=23&amp;vmarket=0&amp;style=g&amp;sort=s&amp;n=60&amp;s=0&amp;cat=50105051#J_crumbs" data-spm-anchor-id="3.1000473.295828.6">骑行</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.7.aewDEi&amp;active=1&amp;from=sn_1_cat&amp;area_code=330100&amp;search_condition=23&amp;vmarket=0&amp;style=g&amp;sort=s&amp;n=60&amp;s=0&amp;cat=50106524#J_crumbs" data-spm-anchor-id="3.1000473.295828.7">游泳</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.8.aewDEi&amp;q=&amp;area_code=330100&amp;sort=s&amp;style=g&amp;vmarket=0&amp;from=sn_1_cat&amp;cat=51052003" data-spm-anchor-id="3.1000473.295828.8">女包</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.9.aewDEi&amp;q=&amp;area_code=330100&amp;sort=s&amp;style=g&amp;vmarket=0&amp;from=sn_1_cat&amp;cat=51042006" data-spm-anchor-id="3.1000473.295828.9">男包</a></li>
                                        <li><a target="_blank" href="http://list.tmall.com/search_product.htm?spm=3.1000473.295828.10.aewDEi&amp;q=%C0%AD%B8%CB%CF%E4&amp;type=p&amp;cat=all&amp;userBucket=2&amp;userBucketCell=2" data-spm-anchor-id="3.1000473.295828.10">旅行箱</a></li>
                                    
                  </ul>
            </div>
            <div class="floorCon clearfix">
            	<ul class="plist">
                	<li><a href="#"><img src="http://img04.taobaocdn.com/tps/i4/T1L3unXxhbXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img04.taobaocdn.com/bao/uploaded/i4/16199022373144806/T13yGmXBhiXXXXXXXX_!!0-item_pic.jpg_b.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img01.taobaocdn.com/bao/uploaded/i1/16199021026987146/T1ZUdVXrpcXXXXXXXX_!!0-item_pic.jpg_b.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img04.taobaocdn.com/tps/i4/T1L3unXxhbXXXHoWL4-200-300.jpg_q90.jpg" width="180" height="270"></a></li>
                    <li><a href="#"><img src="http://img04.taobaocdn.com/bao/uploaded/i4/16199021750891882/T1pBJuXB8aXXXXXXXX_!!0-item_pic.jpg_b.jpg" width="180" height="270"></a></li>
               
                </ul>
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