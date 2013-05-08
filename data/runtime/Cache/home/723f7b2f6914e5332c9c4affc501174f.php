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
<div class="midder">
	<div class="mc">
    	<div class="cleft">
<div class="mod ui-slides" id="db-events-guess">
  <div class="hd">
    <h2>热门活动</h2>
      
  <div class="ui-slide-control" id="ui-control">
    <span class="ui-slide-counter pl">1/4</span>
    <a href="javascript:void(0)" class="btn-prev"></a>
    <a href="javascript:void(0)" class="btn-next"></a>
  </div>
  

  </div>
  <div class="bd ui-slide-screen">
    <ul class="ui-slide-contents gallery" id="ui-ul">  
		<?php if(is_array($hotEvent)): foreach($hotEvent as $key=>$item): ?><li>
          <div class="pic">
            <a tabindex="-1"  href="<?php echo U('event/show',array('id'=>$item[eventid]));?>">
            <img alt="<?php echo ($item[title]); ?>" src="<?php echo ($item[midimg]); ?>" height="165" width="120">
            </a>
          </div>
          <div class="title">
              <a href="<?php echo U('event/show',array('id'=>$item[eventid]));?>" title="<?php echo ($item[title]); ?>"><?php echo ($item[title]); ?></a>
          </div>
        </li><?php endforeach; endif; ?> 
     
    </ul>
  </div>
</div>

<!--cate-->
<div class="mod cats-board inline-list">
  <ul>
      <?php if(is_array($arrCateList)): foreach($arrCateList as $key=>$item): if($item[childCate]): ?><li class="entry">
        <h5>
          <a href="<?php echo U('event/lists',array('type'=>'week-'.$item[parentCate][enname]));?>"><?php echo ($item[parentCate][catename]); ?>&gt;&gt;</a>
        </h5>
        <ul>
            <?php if(is_array($item[childCate])): foreach($item[childCate] as $ckey=>$citem): ?><li>
                <a href="<?php echo U('event/lists',array('type'=>'week-'.$citem[cateid]));?>"><?php echo ($citem[catename]); ?></a>
                </li><?php endforeach; endif; ?>
        </ul>
      </li><?php endif; endforeach; endif; ?>
  </ul>
</div>

<div class="mod">
<script type="text/javascript">
     document.write('<a style="display:none!important" id="tanx-a-mm_11053146_4018392_13072168"></a>');
     tanx_s = document.createElement("script");
     tanx_s.type = "text/javascript";
     tanx_s.charset = "gbk";
     tanx_s.id = "tanx-s-mm_11053146_4018392_13072168";
     tanx_s.async = true;
     tanx_s.src = "http://p.tanx.com/ex?i=mm_11053146_4018392_13072168";
     tanx_h = document.getElementsByTagName("head")[0];
     if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
</script>
</div>

<div class="mod event-mod">
      <h2>
        <span class="pl fr">
          <a href="#">更多</a>
        </span>
        音乐
      </h2>
      <div class="bd">

     <ul class="events-list events-list-2col">
     
<?php if(is_array($hotEvent)): foreach($hotEvent as $key=>$item): ?><li class="list-entry">
      <div class="pic">
        <a tabindex="-1" href="<?php echo U('event/show',array('id'=>$item[eventid]));?>">
          <img alt="<?php echo ($item[title]); ?>" data-lazy="<?php echo ($item[smallimg]); ?>" src="__STATIC__/public/images/blank.gif" width="70">
        </a>
      </div>
      <div class="info">
        <div class="title">
          <a href="<?php echo U('event/show',array('id'=>$item[eventid]));?>" title="<?php echo ($item[title]); ?>">
          <?php echo ($item[title]); ?>
          </a>
        </div>
        <div class="datetime">
        	<span class="month"><?php echo date('m月',$item[begin_date]); ?></span>
            <span class="day"><?php echo date('d日',$item[begin_date]); ?> <?php echo ($item[begin_week_day]); ?></span>&nbsp;
            <span class="time"><?php echo ($item[begin_time]); ?> - <?php echo ($item[end_time]); ?></span>
        </div>
        <address title="<?php echo ($item[city]); ?> <?php echo ($item[district]); ?> <?php echo ($item[street_address]); ?>">
          <?php echo ($item[street_address]); ?>
        </address>
        <div>0人关注</div>
      </div>
      </li><?php endforeach; endif; ?>      
        
     </ul>

      </div>
    </div>







        
        </div><!--//left-->
        <div class="cright">
<div class="mod">  			
<script type="text/javascript">
     document.write('<a style="display:none!important" id="tanx-a-mm_11053146_4018392_13062841"></a>');
     tanx_s = document.createElement("script");
     tanx_s.type = "text/javascript";
     tanx_s.charset = "gbk";
     tanx_s.id = "tanx-s-mm_11053146_4018392_13062841";
     tanx_s.async = true;
     tanx_s.src = "http://p.tanx.com/ex?i=mm_11053146_4018392_13062841";
     tanx_h = document.getElementsByTagName("head")[0];
     if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
</script>
</div>

<div class="mod">  
<a href="<?php echo U('event/create',array('loc'=>'beijing'));?>" rel="nofollow" class="bn-big-action">
  ＋发起同城活动     
</a>     
</div>
            
<div class="mod event-mod">
  <h2>
    官方预售
    <span class="pl fr">
      <a href="#" title="北京的全部售票活动">
        更多》
      </a>
    </span>
  </h2>
    <ul class="simple-list-1col">
        
        <li class="list-entry">
        <a  href="#" class="ll"><img width="48" src="__STATIC__/public/images/defimg.gif" alt="情歌之巅&mdash;&mdash;胡里奥Julio lglesias中国巡回演唱会北京站"></a>
        <div class="info">
          <p class="event-title">
              <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-title'})" href="#">
              情歌之巅&mdash;&mdash;胡里奥Julio lglesias中国巡回演唱会北京站
            </a>
          </p>
          <p class="tip">
            04月21日 19:30-21:30<br>
            
            <span class="on-selling-events-price">¥ 380</span>
          </p>
        </div>
        </li>
        
    </ul>
</div>            
  

<!--主办方-->
<div class="mod event-mod">
    <h2>
      <span class="pl fr">
        <a href="#">更多》</a>
      </span>
      北京活跃的主办方
    </h2>
    
<ul class="simple-list-1col">
    <li class="list-entry">
    <a href="#" class="ll" target="db-host"><img width="48" height="48" src="__STATIC__/public/images/defimg.gif" alt="北京中山公园音乐堂"></a>
    <div class="info">
      <p class="title"><a href="#" target="db-host">北京中山公园音乐堂</a></p>
      <p class="tip">
      
      有<a href="#" target="db-host">18个活动</a>正在进行
      </p>
      <ul>
          <li>
          <a title="威尔第歌剧的光辉&mdash;女高音歌唱家李国玲和她的朋友们" href="#" class="gloomy">[音乐] 威尔第歌剧的光辉&mdash;女高音歌唱家...</a>
          </li>
          <li>
          <a title="浪漫竖琴之夜-俄罗斯竖琴家艾米丽亚·莫斯克维金娜独奏音乐会" href="#" class="gloomy">[音乐] 浪漫竖琴之夜-俄罗斯竖琴家艾米丽...</a>
          </li>
      </ul>
    </div>
    </li>
    
</ul>

  </div>
 

<div class="mod">
  <h2>更多发现</h2>
  <ul class="inline-list linkgrid">
  	<li>
    <a class="no-hover no-visited" href="#">
      <strong>
      同城活动小组
      </strong>
      <span class="info">
      发现玩活动的圈子
      </span>
    </a>
  	</li>
  	<li>
    <a  class="no-hover no-visited" href="#" style="border-left:none">
      <strong>
      主办方系列活动
      </strong>
      <span class="info">
      主办方的主题活动
      </span>
    </a>
  	</li>
  </ul>
</div>

<div class="mod">
<p style="font-size:14px;" class="pl">
<a href="#" class="lnk-rss" target="_blank">RSS</a>
&nbsp;
&nbsp;
&gt; <a href="#">申请主办方</a>
&nbsp;
&nbsp;
&gt; <a href="#">我要提建议</a>
</p>
</div>
  
        
        </div><!--//right-->
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