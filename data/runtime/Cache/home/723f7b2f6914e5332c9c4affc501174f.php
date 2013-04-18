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

        <li>
          <div class="pic">
            <a tabindex="-1"  href="http://www.douban.com/event/18561598/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/0937eedbb872a1f.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18561598/" title="《哥本哈根》" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">《哥本哈根》</a>
          </div>
        </li>
        <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18628091/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/d9e30dd63e5c0b5.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18628091/" title="【单向街·沙龙】第495期 朱天衣 史航：朱天衣的猫狗山居岁月" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">【单向街·沙龙】第495期 朱天...</a>
          </div>
        </li>
        <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18626827/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/081f680633d3d81.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18626827/" title="非非演出季第五季 • 地丁花剧社《我的劳动、尊严与梦想》" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">非非演出季第五季 • 地丁花...</a>
          </div>
        </li>
        <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18304407/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/b86ce47d9325919.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18304407/" title="艺术北京2013艺术博览会" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">艺术北京2013艺术博览会</a>
          </div>
        </li>
        
        <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18304407/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/b86ce47d9325919.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18304407/" title="艺术北京2013艺术博览会" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">艺术北京2013艺术博览会</a>
          </div>
        </li> 
                <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18304407/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/b86ce47d9325919.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18304407/" title="艺术北京2013艺术博览会" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">艺术北京2013艺术博览会</a>
          </div>
        </li> 
                <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18304407/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/b86ce47d9325919.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18304407/" title="艺术北京2013艺术博览会" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">艺术北京2013艺术博览会</a>
          </div>
        </li> 
                <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18304407/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/b86ce47d9325919.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18304407/" title="艺术北京2013艺术博览会" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">艺术北京2013艺术博览会</a>
          </div>
        </li> 
        
            
         <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18628091/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/d9e30dd63e5c0b5.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18628091/" title="【单向街·沙龙】第495期 朱天衣 史航：朱天衣的猫狗山居岁月" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">【单向街·沙龙】第495期 朱天...</a>
          </div>
        </li>
                <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18628091/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/d9e30dd63e5c0b5.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18628091/" title="【单向街·沙龙】第495期 朱天衣 史航：朱天衣的猫狗山居岁月" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">【单向街·沙龙】第495期 朱天...</a>
          </div>
        </li>
                <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18628091/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/d9e30dd63e5c0b5.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18628091/" title="【单向街·沙龙】第495期 朱天衣 史航：朱天衣的猫狗山居岁月" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">【单向街·沙龙】第495期 朱天...</a>
          </div>
        </li>
                <li>
          <div class="pic">
            <a tabindex="-1" onclick="moreurl(this, {from:'loc-index-guess-beijing'})" href="http://www.douban.com/event/18628091/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/d9e30dd63e5c0b5.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18628091/" title="【单向街·沙龙】第495期 朱天衣 史航：朱天衣的猫狗山居岁月" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">【单向街·沙龙】第495期 朱天...</a>
          </div>
        </li>       
        
      
              <li>
          <div class="pic">
            <a tabindex="-1"  href="http://www.douban.com/event/18561598/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/0937eedbb872a1f.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18561598/" title="《哥本哈根》" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">《哥本哈根》</a>
          </div>
        </li>
                <li>
          <div class="pic">
            <a tabindex="-1"  href="http://www.douban.com/event/18561598/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/0937eedbb872a1f.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18561598/" title="《哥本哈根》" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">《哥本哈根》</a>
          </div>
        </li>
                <li>
          <div class="pic">
            <a tabindex="-1"  href="http://www.douban.com/event/18561598/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/0937eedbb872a1f.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18561598/" title="《哥本哈根》" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">《哥本哈根》</a>
          </div>
        </li>
                <li>
          <div class="pic">
            <a tabindex="-1"  href="http://www.douban.com/event/18561598/"><img alt="" src="http://img3.douban.com/pview/event_poster/large/public/0937eedbb872a1f.jpg" height="165" width="120"></a>
          </div>
          <div class="title">
              <a href="http://www.douban.com/event/18561598/" title="《哥本哈根》" onclick="moreurl(this, {from:'loc-index-guess-beijing'})">《哥本哈根》</a>
          </div>
        </li>   
     
    </ul>
  </div>
</div>

<!--cate-->
<div class="mod cats-board inline-list">
  <ul>
      
      <li class="entry">
        <h5>
          <a href="events/week-music">音乐»</a>
        </h5>
        <ul>
            
            <li>
            <a href="events/week-1001">小型现场</a>
            </li>
            
            <li>
            <a href="events/week-1002">音乐会</a>
            </li>
            
            <li>
            <a href="events/week-1003">演唱会</a>
            </li>
            
            <li>
            <a href="events/week-1004">音乐节</a>
            </li>
        </ul>
      </li>
      
      <li class="entry">
        <h5>
          <a href="events/week-drama">戏剧»</a>
        </h5>
        <ul>
            
            <li>
            <a href="events/week-1101">话剧</a>
            </li>
            
            <li>
            <a href="events/week-1102">音乐剧</a>
            </li>
            
            <li>
            <a href="events/week-1103">舞剧</a>
            </li>
            
            <li>
            <a href="events/week-1104">歌剧</a>
            </li>
            
            <li>
            <a href="events/week-1105">戏曲</a>
            </li>
        </ul>
      </li>
      
      <li class="entry">
        <h5>
          <a href="events/week-party">聚会»</a>
        </h5>
        <ul>
            
            <li>
            <a href="events/week-1401">生活</a>
            </li>
            
            <li>
            <a href="events/week-1402">集市</a>
            </li>
            
            <li>
            <a href="events/week-1403">摄影</a>
            </li>
            
            <li>
            <a href="events/week-1404">外语</a>
            </li>
            
            <li>
            <a href="events/week-1405">桌游</a>
            </li>
            
            <li>
            <a href="events/week-1407">交友</a>
            </li>
                    </ul>
      </li>
      
      <li class="entry">
        <h5>
          <a href="events/week-film">电影»</a>
        </h5>
        <ul>
            
            <li>
            <a href="events/week-1801">主题放映</a>
            </li>
            
            <li>
            <a href="events/week-1802">影展</a>
            </li>
            
            <li>
            <a href="events/week-1803">影院活动</a>
            </li>
        </ul>
      </li>
    <li class="entry">
      <h5>
        <a href="events/week-all">
        其他»
        </a>
      </h5>
        <ul>
          
          <li>
            <a href="events/week-salon">讲座</a>
          </li>
          
          <li>
            <a href="events/week-exhibition">展览</a>
          </li>
          
          <li>
            <a href="events/week-sports">运动</a>
          </li>
          
          <li>
            <a href="events/week-travel">旅行</a>
          </li>
          
          <li>
            <a href="events/week-commonweal">公益</a>
          </li>
        </ul>
    </li>
  </ul>
</div>

<div class="mod"><img border="0" width="640" height="112" src="http://img3.douban.com/view/dale-online/dale_ad/public/fca5e918185cd26.jpg"></div>

<div class="mod event-mod">
      <h2>
        <span class="pl fr">
          <a href="events/week-music">更多</a>
        </span>
        音乐
      </h2>
      <div class="bd">

     <ul class="events-list events-list-2col">

      <li class="list-entry">
      <div class="pic">
        <a tabindex="-1" href="http://www.douban.com/event/18541268/">
          <img alt="" data-lazy="http://img3.douban.com/pview/event_poster/small/public/545eb9399d7867e.jpg" src="http://img3.douban.com/pics/blank.gif" width="70">
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
          <img alt="" data-lazy="http://img3.douban.com/pview/event_poster/small/public/ffc343b85f73f27.jpg" src="http://img3.douban.com/pics/blank.gif" width="70">
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
          <img alt="" data-lazy="http://img3.douban.com/pview/event_poster/small/public/c2cdb2f06d716a4.jpg" src="http://img3.douban.com/pics/blank.gif" width="70">
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
          <img alt="" data-lazy="http://img3.douban.com/pview/event_poster/small/public/07fb7d135eb3e09.jpg" src="http://img3.douban.com/pics/blank.gif" width="70">
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
    </div>







        
        </div><!--//left-->
        <div class="cright">
			<img border="0" width="300" height="250" src="http://img3.douban.com/view/dale-online/dale_ad/public/b062ce01109cfd8.jpg">  
<div class="mod">  
<a href="<?php echo U('event/create',array('loc'=>'beijing'));?>" rel="nofollow" class="bn-big-action">
  ＋发起同城活动     
</a>     
</div>
            
<div class="mod event-mod">
  <h2>
    官方预售
    <span class="pl fr">
      <a href="http://beijing.douban.com/events/selling" title="北京的全部售票活动">
        更多》
      </a>
    </span>
  </h2>
    <ul class="simple-list-1col">
        
        <li class="list-entry">
        <a  href="http://www.douban.com/event/18266199/?icn=index-shopitem" class="ll"><img width="48" src="http://img3.douban.com/pview/event_poster/small/public/b6ec09a34774b2f.jpg" alt="情歌之巅&mdash;&mdash;胡里奥Julio lglesias中国巡回演唱会北京站"></a>
        <div class="info">
          <p class="event-title">
              <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-title'})" href="http://www.douban.com/event/18266199/?icn=index-shopitem">
              情歌之巅&mdash;&mdash;胡里奥Julio lglesias中国巡回演唱会北京站
            </a>
          </p>
          <p class="tip">
            04月21日 19:30-21:30<br>
            
            <span class="on-selling-events-price">¥ 380</span>
          </p>
        </div>
        </li>
        <li class="list-entry">
        <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-img'})" href="http://www.douban.com/event/18549999/?icn=index-shopitem" class="ll"><img width="48" src="http://img3.douban.com/pview/event_poster/small/public/e835b34b08d2565.jpg" alt="中国乐谷·2013北京迷笛音乐节"></a>
        <div class="info">
          <p class="event-title">
              <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-title'})" href="http://www.douban.com/event/18549999/?icn=index-shopitem">
              中国乐谷·2013北京迷笛音乐节
            </a>
          </p>
          <p class="tip">
            04月29日 ~ 05月01日 每天14:00-22:30<br>
            
            <span class="on-selling-events-price">¥ 100</span>
          </p>
        </div>
        </li>
        <li class="list-entry">
        <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-img'})" href="http://www.douban.com/event/18438811/?icn=index-shopitem" class="ll"><img width="48" src="http://img3.douban.com/pview/event_poster/small/public/4caf7c37294a06d.jpg" alt="2013北京草莓音乐节"></a>
        <div class="info">
          <p class="event-title">
              <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-title'})" href="http://www.douban.com/event/18438811/?icn=index-shopitem">
              2013北京草莓音乐节
            </a>
          </p>
          <p class="tip">
            04月29日 ~ 05月01日 每天10:30-21:30<br>
            
            <span class="on-selling-events-price">¥ 120</span>
          </p>
        </div>
        </li>
        <li class="list-entry">
        <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-img'})" href="http://www.douban.com/event/18376188/?icn=index-shopitem" class="ll"><img width="48" src="http://img3.douban.com/pview/event_poster/small/public/3c3592b371e91c8.jpg" alt="孟京辉监制 詹瑞文作品《桃色办公室》7月@蜂巢剧场"></a>
        <div class="info">
          <p class="event-title">
              <a onclick="moreurl(this, {from:'loc-event-ticket-108288-0-title'})" href="http://www.douban.com/event/18376188/?icn=index-shopitem">
              孟京辉监制 詹瑞文作品《桃色办公室》7月@蜂巢剧场
            </a>
          </p>
          <p class="tip">
            07月02日 ~ 07月21日 每周二至周日 19:30-21:30<br>
            
            <span class="on-selling-events-price">¥ 100</span>
          </p>

        </div>
        </li>
    </ul>
</div>            
  

<!--主办方-->
<div class="mod event-mod">
    <h2>
      <span class="pl fr">
        <a href="http://beijing.douban.com/hosts/active">更多》</a>
      </span>
      北京活跃的主办方
    </h2>
    
<ul class="simple-list-1col">
    <li class="list-entry">
    <a href="http://site.douban.com/fcchbj/" class="ll" target="db-host"><img width="48" height="48" src="__STATIC__/public/images/defimg.gif" alt="北京中山公园音乐堂"></a>
    <div class="info">
      <p class="title"><a href="http://site.douban.com/fcchbj/" target="db-host">北京中山公园音乐堂</a></p>
      <p class="tip">
      
      有<a href="http://site.douban.com/fcchbj/widget/events/1482647/" target="db-host">18个活动</a>正在进行
      </p>
      <ul>
          <li>
          <a title="威尔第歌剧的光辉&mdash;女高音歌唱家李国玲和她的朋友们" href="http://www.douban.com/event/18660729/" class="gloomy">[音乐] 威尔第歌剧的光辉&mdash;女高音歌唱家...</a>
          </li>
          <li>
          <a title="浪漫竖琴之夜-俄罗斯竖琴家艾米丽亚·莫斯克维金娜独奏音乐会" href="http://www.douban.com/event/18660580/" class="gloomy">[音乐] 浪漫竖琴之夜-俄罗斯竖琴家艾米丽...</a>
          </li>
      </ul>
    </div>
    </li>
    <li class="list-entry">
    <a href="http://site.douban.com/dongparty/" class="ll" target="db-host"><img width="48" height="48" src="http://img3.douban.com/view/site/small/public/243c2f84958ab23.jpg" alt="东派民谣音乐节"></a>
    <div class="info">
      <p class="title"><a href="http://site.douban.com/dongparty/" target="db-host">东派民谣音乐节</a></p>
      <p class="tip">
      
      有<a href="http://site.douban.com/dongparty/widget/events/1466427/" target="db-host">1个活动</a>正在进行
      </p>
      <ul>
          <li>
          <a title="MINI东派民谣音乐节" href="http://www.douban.com/event/18601447/" class="gloomy">[音乐] MINI东派民谣音乐节</a>
          </li>
      </ul>
    </div>
    </li>
    <li class="list-entry">
    <a href="http://site.douban.com/ucca/" class="ll" target="db-host"><img width="48" height="48" src="http://img3.douban.com/view/site/small/public/17e5cc70a4dce0f.jpg" alt="尤伦斯当代艺术中心"></a>
    <div class="info">
      <p class="title"><a href="http://site.douban.com/ucca/" target="db-host">尤伦斯当代艺术中心</a></p>
      <p class="tip">
      
      有<a href="http://site.douban.com/ucca/widget/events/7190046/" target="db-host">37个活动</a>正在进行
      </p>
      <ul>
          <li>
          <a title="【讲座与论坛】"杜尚与/或/在中国"现代艺术史讲堂系列" href="http://www.douban.com/event/18674161/" class="gloomy">[讲座] 【讲座与论坛】"杜尚与/或/在中...</a>
          </li>
          <li>
          <a title=""一样的艺术 不一样的角度"特殊儿童艺术作品展开幕仪式暨主题论坛" href="http://www.douban.com/event/18674106/" class="gloomy">[其他] "一样的艺术 不一样的角度"特殊...</a>
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
    <a class="no-hover no-visited" href="groups/">
      <strong>
      同城活动小组
      </strong>
      <span class="info">
      发现玩活动的圈子
      </span>
    </a>
  	</li>
  	<li>
    <a  class="no-hover no-visited" href="series" style="border-left:none">
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
<a href="http://www.douban.com/location/beijing/events/feed/weekly" class="lnk-rss" target="_blank">RSS</a>
&nbsp;
&nbsp;
&gt; <a href="http://site.douban.com/apply/host/">申请主办方</a>
&nbsp;
&nbsp;
&gt; <a href="http://help.douban.com/help/ask">我要提建议</a>
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
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  <?php echo C('site_icp');?> <span style="color:green">ThinkPHP 版本 <?php echo (THINK_VERSION); ?></span><br />
        <span style="font-size:0.83em;">{__RUNTIME__}</span>
        
        <!--<script src="http://s21.cnzz.com/stat.php?id=2973516&web_id=2973516" language="JavaScript"></script>-->
        </p>   
    </div>
</div>
</footer>
</body>
</html>