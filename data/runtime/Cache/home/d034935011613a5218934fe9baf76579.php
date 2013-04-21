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
<link rel="stylesheet" type="text/css" href="__STATIC__/theme/<?php echo C('ik_site_theme');?>/<?php echo ($module_name); ?>/images/show.css">
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
    	<h1><?php echo ($seo["title"]); ?></h1>
        <div class="cleft">
    
	  

<div class="eventwrap" itemscope="" itemtype="http://data-vocabulary.org/Event">
    <div class="poster">
      <a href="http://img3.douban.com/pview/event_poster/raw/public/1b1f226b77acac9.jpg">
        <img id="poster_img" itemprop="image" src="http://img3.douban.com/pview/event_poster/large/public/edf7b12feb39945.jpg" title="点击查看大图" height="260" width="175">
      </a>
      <script type="text/javascript">
        if (window.devicePixelRatio >= 1.5) {
          document.getElementById('poster_img').src = 'http://img3.douban.com/pview/event_poster/plarge/public/edf7b12feb39945.jpg';
        }
      </script>
    </div>
    <div id="event-info">
        <div class="event-info">
            <h1 itemprop="summary">活动待审核中...加或更改你的小站图标
            </h1>
            <div class="event-detail">
                <span class="pl">时间:&nbsp;&nbsp;</span>
  
  <ul class="calendar-strs ">
      
      <li class="calendar-str-item ">04月20日 周六 08:00-22:30</li>
  </ul>
  <script type="text/javascript">
    window._show_hidden_siblings = function(elem) {
      var prev = elem;
      while (true) {
        var prev = prev.previousSibling;
        if (!prev) break;
        if (prev.nodeValue) continue;
        if (prev.className) {
          prev.className = prev.className.replace('hide', '');
        }
      }
      elem.parentNode.removeChild(elem);
    };
  </script>

                <time itemprop="startDate" datetime="2013-04-20T08:00:00"></time>
                <time itemprop="endDate" datetime="2013-04-20T22:30:00"></time>
            </div>
            <div class="event-detail" itemprop="location" itemscope="" itemtype="http://data-vocabulary.org/Organization">
                <span class="pl">地点:&nbsp;</span>
    <span itemprop="address" itemscope="" itemtype="http://data-vocabulary.org/Address" class="micro-address">
         <span itemprop="region" class="micro-address">上海&nbsp;</span>
         <span itemprop="locality" class="micro-address">徐汇区&nbsp;</span>
         <span itemprop="street-address" class="micro-address">加或更改你的小站图标</span>
    </span>
    <span itemprop="geo" itemscope="" itemtype="http://data-vocabulary.org/Geo" class="micro-address">
        <meta itemprop="latitude" content="0.0">
        <meta itemprop="longitude" content="0.0">
    </span>

            </div>
            <div class="event-detail">
                  <span class="pl">费用:&nbsp;&nbsp;</span>免费
            </div>
            <div class="event-detail">
                <span class="pl">类型:&nbsp;&nbsp;</span><a href="http://shanghai.douban.com/events/future-music" itemprop="eventType">音乐-音乐会</a>
            </div>
            <div class="event-detail" itemscope="" itemtype="http://data-vocabulary.org/Organization">
                
                <span class="pl">发起人:</span>
                <a href="http://www.douban.com/location/people/charm_888/" itemprop="name">小麦狼</a>
            </div>
            <div class="interest-attend pl">
                <span class="num">0 </span><span>人感兴趣 &nbsp; </span><span class="num">1 </span><span>人参加</span>
            </div>
        </div>
        <div id="event-act">
            <p>
              <span class="ui-msg ui-warn">
                活动已创建，等待审核中... 审核通过后会有豆邮通知
              </span>
            </p>
        </div>
        

    </div>
</div>



<div class="related_info">

    <div class="mod" id="link-report">
      <h2>活动详情</h2>
        
        <div class="wr">
            加或更改你的小站图标 
        </div>
    </div>

	<div class="mod">
    <h2>活动相关小站</h2>
    <ul class="link-site-container">
    
        <li class="link-subject">
            <div class="photo">
                <a title="果壳网的小站" href="http://site.douban.com/guokr/"><img width="64" title="果壳网的小站" alt="" src="http://img3.douban.com/pview/event_poster/large/public/edf7b12feb39945.jpg"></a>
            </div>
            <div class="detail">
                <h3><a href="http://site.douban.com/guokr/">果壳网的小站</a> <span class="cate">推广</span></h3>
            </div>
        </li>
    </ul>
	</div>
    
<div class="mod">
      <h2>我来问主办方 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·
        <span class="pl">
          (<a href="qa/all">全部0个</a>
          )
        </span>
      </h2>
        <div class="pl">还没有人提问</div>
</div>
    
    

<div class="mod">
    <h2>这个活动论坛</h2><div class="indent">
    <table class="olt"><tbody><tr><td width="54%"></td><td width="22%"></td><td width="12%"></td><td wdith="12%"></td></tr>
    
        <tr><td><a title="活动具体内容？" href="http://www.douban.com/event/18636528/discussion/52825640/">活动具体内容？</a></td><td class="pl">来自<a href="http://www.douban.com/people/Lizyjs/">Lizyjs</a></td><td class="pl">6 回应</td><td class="pl">2013-04-19</td></tr>
        
        <tr><td><a title="白领专场&amp;告别单身主题派对" href="http://www.douban.com/event/18636528/discussion/52869366/">白领专场&amp;告别单身主题派对</a></td><td class="pl">来自<a href="http://www.douban.com/people/66356766/">睡虫</a></td><td class="pl"></td><td class="pl">2013-04-18</td></tr>
        
        <tr><td><a title="每次看见主页君的邀请都有悲从中来的感觉。" href="http://www.douban.com/event/18636528/discussion/52824873/">每次看见主页君的邀请都有悲从中来的感觉。</a></td><td class="pl">来自<a href="http://www.douban.com/people/12822970/">十日日食</a></td><td class="pl">13 回应</td><td class="pl">2013-04-17</td></tr>
        
        <tr><td><a title="难道不是应该很多妹子都感兴趣吗？" href="http://www.douban.com/event/18636528/discussion/52821831/">难道不是应该很多妹子都感兴趣吗？</a></td><td class="pl">来自<a href="http://www.douban.com/people/54751336/">猫杀</a></td><td class="pl">7 回应</td><td class="pl">2013-04-17</td></tr>
        
    </tbody></table>
    <p align="right" class="pl">&gt; <a rel="nofollow" href="http://www.douban.com/event/18636528/discussion/create">在这个活动论坛发言</a></p>
        </div>
</div>




<div class="mod">
  <h2 class="related_h2">喜欢这个活动的人也喜欢</h2>
 <ul class="events-list events-list-2col">

      <li class="list-entry">
      <div class="pic">
        <a tabindex="-1" href="http://www.douban.com/event/18541268/">
          <img alt=""  src="http://img3.douban.com/pview/event_poster/small/public/ffc343b85f73f27.jpg" width="70">
        </a>
      </div>
      <div class="info">
        <div class="title">
          <a href="http://www.douban.com/event/18541268/" title="噪音冲撞 Vol 3 - After Argument、DICE、Mr.Graceless">
            噪音冲撞 Vol 3 - After Argument、DICE、Mr.Graceless
            
          </a>
        </div>
        <div class="datetime">
          
      
      <span class="month">4月</span><span class="day">20日 周六</span>&nbsp;<span class="time">20:30 - 22:30</span>

        </div>
        <address title="北京 朝阳区 麻雀瓦舍">
          麻雀瓦舍
        </address>
        <div>
          282人关注
        </div>
      </div>
      </li>
      <li class="list-entry">
      <div class="pic">
        <a tabindex="-1" href="http://www.douban.com/event/18454183/">
          <img alt="" src="http://img3.douban.com/pview/event_poster/small/public/ffc343b85f73f27.jpg" width="70">
        </a>
      </div>
      <div class="info">
        <div class="title">
          <a href="http://www.douban.com/event/18454183/" title="清歈暮春——李建傧江湖弹唱会">
            清歈暮春——李建傧江湖弹唱会
            
          </a>
        </div>
        <div class="datetime">
          
      
      <span class="month">4月</span><span class="day">19日 周五</span>&nbsp;<span class="time">21:00 - 23:30</span>

        </div>
        <address title="北京 东城区 交道口南大街东棉花胡同7号">
          交道口南大街东棉花胡同7号
        </address>
        <div>
          158人关注
        </div>
      </div>
      </li>
      <li class="list-entry">
      <div class="pic">
        <a tabindex="-1" href="http://www.douban.com/event/18453882/">
          <img alt="" src="http://img3.douban.com/pview/event_poster/small/public/ffc343b85f73f27.jpg" width="70">
        </a>
      </div>
      <div class="info">
        <div class="title">
          <a href="http://www.douban.com/event/18453882/" title="碎蛋之夜--Punk'n'Core Night">
            碎蛋之夜--Punk'n'Core Night
            
          </a>
        </div>
        <div class="datetime">
          
      
      <span class="month">4月</span><span class="day">21日 周日</span>&nbsp;<span class="time">21:00 - 23:30</span>

        </div>
        <address title="北京 东城区 安定门 SCHOOL学校酒吧">
          SCHOOL学校酒吧
        </address>
        <div>
          139人关注
        </div>
      </div>
      </li>
      <li class="list-entry">
      <div class="pic">
        <a tabindex="-1" href="http://www.douban.com/event/18386784/">
           <img alt="" src="http://img3.douban.com/pview/event_poster/small/public/ffc343b85f73f27.jpg" width="70">
        </a>
      </div>
      <div class="info">
        <div class="title">
          <a href="http://www.douban.com/event/18386784/" title="麻油叶独立厂牌《麻油叶？我不能说！》2周年专场大趴">
            麻油叶独立厂牌《麻油叶？我不能说！》2周年专场大趴
            
          </a>
        </div>
        <div class="datetime">
          
      
      <span class="month">4月</span><span class="day">19日 周五</span>&nbsp;<span class="time">20:00 - 23:30</span>

        </div>
        <address title="北京 朝阳区 麻雀瓦舍 双井家乐福对面劲松口腔胡同内50米 红点艺术工厂内">
          麻雀瓦舍 双井家乐福对面劲松...
        </address>
        <div>
          1186人关注
        </div>
      </div>
      </li>
        
     </ul>
</div>    



</div><!--//related_info-->
 

        </div><!--//left-->
    
        <div class="cright">



  <div id="dale_event_page_top_right">
  <iframe style="overflow: hidden; margin: 0px 0px 20px;" id="dale_event_page_top_right_frame" frameborder="0" height="250" scrolling="no" width="300"></iframe>
  </div>
  

  <script type="text/javascript">
    Do.add('getaddr', { type: 'js', path: 'http://img3.douban.com/js/packed_getaddr7214326851.js', depends: ['google.map'] });
    Do.ready(function() { Do('getaddr'); });
  </script>


<div class="mod">
    <h2>活动相关标签 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
    <ul class="aside-event-tags">
        <li><a href="/event/search?loc=shanghai&amp;search_text=%E9%9F%B3%E4%B9%90%E8%8A%82&amp;p=c">音乐节</a>&nbsp;</li>
            · &nbsp;
        <li><a href="/event/search?loc=shanghai&amp;search_text=%E8%8D%89%E8%8E%93%E9%9F%B3%E4%B9%90%E8%8A%82&amp;p=c">草莓音乐节</a>&nbsp;</li>
            · &nbsp;
        <li><a href="/event/search?loc=shanghai&amp;search_text=%E6%91%87%E6%BB%9A&amp;p=c">摇滚</a>&nbsp;</li>
    </ul>
</div>
  

<div class="mod">
        <h2>活动地图 <span class="pl">( <a href="http://www.douban.com/event/18636528/full_map">查看大图</a> )</span></h2>
</div>

<div class="mod">
    <h2>活动组织者
    </h2>
    <ul class="member_photo">
        
            
        <li class="">
            <a href="http://www.douban.com/location/people/charm_888/"><img src="http://img3.douban.com/icon/u38672004-18.jpg" alt="" data-title="小麦狼" data-relation="False" width="35"></a>
            <div class="member-tip">
            <a href="http://www.douban.com/location/people/charm_888/" class="pic"><img src="http://img3.douban.com/icon/u38672004-18.jpg" title="小麦狼"></a>
            <div class="detail"><a href="http://www.douban.com/location/people/charm_888/" title="小麦狼">小麦狼</a></div>
                <div class="pl detail">组织者</div>
            <div class="relation pl"></div>
            <span class="arrow inner"></span>
            <span class="arrow outer"></span>
            </div>
        </li>
    </ul>
</div>

<div class="mod">
    <h2>活动成员 <span class="pl">( <a href="http://www.douban.com/event/18697995/participant">1人参加 </a>· <a href="http://www.douban.com/event/18697995/wisher">0人感兴趣</a>
            )</span></h2>
    <ul class="member_photo">
        
        
        <li class="">
            <a href="http://www.douban.com/location/people/charm_888/"><img src="http://img3.douban.com/icon/u38672004-18.jpg" alt="小麦狼" width="35"></a>
            <div class="member-tip">
                <a href="http://www.douban.com/location/people/charm_888/" class="pic"><img src="http://img3.douban.com/icon/u38672004-18.jpg" title="小麦狼"></a>
                <div class="detail"><a href="http://www.douban.com/location/people/charm_888/" title="小麦狼">小麦狼</a></div>
                <div class="pl detail">要参加</div>
                <div class="relation pl"></div>
                <span class="arrow inner"></span>
                <span class="arrow outer"></span>
            </div>
        </li>
    </ul>
</div>



  

  
  <!-- douban app begin -->
  





<div class="mobile-app-entrance block5 app-location">

    <a class="entrance-link first-link" href="http://www.douban.com/mobile/location">
        <span class="app-icon icon-location"></span>
        <span class="main-title">豆瓣活动客户端</span>
        <span class="sub-title">发现精彩活动，探索城市生活</span>
    </a>
</div>

  <!-- douban app end -->
  





<script type="text/javascript">
    (function (global) {
        var newNode = global.document.createElement('script'),
            existingNode = global.document.getElementsByTagName('script')[0],
            adSource = 'http://erebor.douban.com/',
            userId = '38672004',
            browserId = 'B883Ui8I4x4',
            ipAddress = '27.189.10.184',
            criteria = '3:/event/18697995/',
            preview = '',
            debug = false,
            adSlots = ['dale_event_page_top_right'];

        global.DoubanAdRequest = {src: adSource, uid: userId, bid: browserId, ip: ipAddress, crtr: criteria, prv: preview, debug: debug};
        global.DoubanAdSlots = (global.DoubanAdSlots || []).concat(adSlots);

        newNode.setAttribute('type', 'text/javascript');
        newNode.setAttribute('src', 'http://img3.douban.com/js/packed_ad1227872440.js');
        newNode.setAttribute('async', true);
        existingNode.parentNode.insertBefore(newNode, existingNode);
    })(this);
</script>






        


        </div><!--//right-->
    
    </div><!--//mc-->
</div><!--//midder-->
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