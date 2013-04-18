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
<script type="text/javascript">
  var IK_BASE_URL = siteUrl;
  var lowLevelBrowser = true;
  if($.browser.webkit || $.browser.safari || $.browser.opera || $.browser.mozilla || (parseInt($.browser.version,10) > 8)){
      lowLevelBrowser = false;
  }
  
  IK.add('dialog-css', {path: '__STATIC__/public/css/ui/dialog.css', type: 'css'});
  IK.add('dialog', {path: '__STATIC__/public/js/ui/dialog.js', type: 'js', requires: ['dialog-css']});
   // Editable Select
  IK.add('editable-select-css', {path: '__STATIC__/public/css/lib/jquery.editable-select.css', type: 'css'});
  IK.add('editable-select', {path: '__STATIC__/public/js/lib/jquery.editable-select.js', type:"js", requires: ['editable-select-css']});
  // Date Picker
  IK.add('datePickercss', {path: '__STATIC__/public/css/ui/datepicker.css', type: 'css'});
  IK.add('datePicker', {path: '__STATIC__/public/js/lib/jquery.ui.min.js', type: 'js', requires: ['datePickercss']}); 
  
  IK.add('validate', {path: '__STATIC__/public/js/lib/validate.js', type:'js'});
  
  
  window._pinicon_ = 'http://img3.douban.com/pics/loc/pin.png';


  IK.add('imap', {path: '__STATIC__/public/js/ui/imap.js', type: 'js', requires: ['jquery.ui', 'dialog']});
  IK.add('google_map', {path: 'http://maps.google.com/maps/api/js?sensor=false&language=zh-CN&libraries=places&callback=loadMap', type: 'js'});

  function loadMap(){
    IK('imap', 
    '__STATIC__/public/css/ui/jquery.ui.autocomplete.css',
    '__STATIC__/public/js/lib/jquery.ui.autocomplete.min.js',
    '__STATIC__/theme/<?php echo C("ik_site_theme");?>/<?php echo ($module_name); ?>/js/map.js');
  }

  IK('google_map');

  
  //离开页面
</script>
<script type="text/javascript" src="__STATIC__/theme/<?php echo C('ik_site_theme');?>/<?php echo ($module_name); ?>/js/create.js"></script>
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
    	<h1>创建同城活动</h1>
        <div class="cleft">
            <div class="nav-step">
              <span>1. 填写活动信息</span>
              <span class="pl">&gt;</span>
              <span class="pl">2. 上传活动海报</span>
              <span class="pl">&gt;</span>
              <span class="pl">3. 提交活动</span>
            </div>
<form id="eform" name="eform" action="" method="post" autocomplete="off" tagName="form">        
<div class="row">
  <label class="field" for="type">活动分类</label>
  <div class="item"><select name="type" class="basic-input" id="type">
      <option value="00">请选择</option>
      
        
        <option value="10">音乐</option>
        
        <option value="11">戏剧</option>
        
        <option value="13">讲座</option>
        
        <option value="14">聚会</option>
        
        <option value="18">电影</option>
        
        <option value="12">展览</option>
        
        <option value="15">运动</option>
        
        <option value="17">公益</option>
        
        <option value="16">旅行</option>
        
        <option value="99">其他</option>
    </select></div>
  <div id="subtype-select" class="hide"></div>
</div>
<div class="row row-title">
        <label class="field" for="title">活动标题</label>
        <div class="item">
            <input type="text" size="64" name="title" maxlength="70" class="basic-input " value="" id="title">
        </div>
</div>
<hr class="hrline">

<div class="row" id="eventTimeHook">
  <label for="time" class="field">活动时间</label>
  <div class="item">
    <select id="repeat_type" name="repeat_type" class="basic-input">
      <option value="0" selected>当天结束</option>
      <option value="1" >连续多天</option>
      <option value="2" >每周举行</option>
      <option value="3" >自定义</option>
    </select>
    <input type="hidden" name="begin_date" id="begin_date" value=""/>
    <input type="hidden" name="begin_time" id="begin_time" value=""/>
    <input type="hidden" name="end_date" id="end_date" value=""/>
    <input type="hidden" name="end_time" id="end_time" value=""/>
    <input type="hidden" name="repeat_time" id="repeat_time" value=""/>
  </div>
  <div>
    <div id="evnetDateOnedayHook" class="item inner-back hide">
      <input placeholder="活动日期" class="basic-input event_calendar" id="one_begin_day" type="text" size="12" value=""/>

      <input type="hidden" class="editableHook" data-id="one_begin_time" data-start="true" data-time="" /> 至&nbsp;&nbsp;
      <input type="hidden" class="editableHook" data-id="one_end_time" data-time=""/>
    </div>
    <div id="eventDateContinueHook" class="item inner-back hide">
      <div class="con_item">
        <label for="week_start_day" class="inner">起止日期</label>
        <div class="inner-item">
          <input class="basic-input event_calendar" id="more_begin_day" name="more_begin_day" type="text" size="12" value=""/> 至&nbsp;&nbsp;
          <input class="basic-input event_calendar" id="more_end_day" name="more_end_day" type="text" size="12" value=""/>
        </div>
      </div>
      <div class="con_item">
        <label for="week_start_time" class="inner">活动时间</label>
        <div class="inner-item">
          <input type="hidden" class="editableHook" data-id="more_begin_time" data-start="true" data-time=""/> 至&nbsp;&nbsp;
          <input type="hidden" class="editableHook" data-id="more_end_time" data-time=""/>
        </div>
      </div>
      <div class="con_item clearfix">
        <label class="inner">活动描述</label>
        <div id="eventContinueDescHook">
        </div>
      </div>
    </div>
    <div id="eventDateWeekHook" class="item inner-back hide">
      <div class="con_item">
        <label for="" class="inner">活动频率</label>
        <div class="inner-item week-label">
          
          <label for="week_mon">一<input type="checkbox" name="week_mon" id="week_mon" /></label>
          <label for="week_tue">二<input type="checkbox" name="week_tue" id="week_tue" /></label>
          <label for="week_wed">三<input type="checkbox" name="week_wed" id="week_wed" /></label>
          <label for="week_thu">四<input type="checkbox" name="week_thu" id="week_thu" /></label>
          <label for="week_fri">五<input type="checkbox" name="week_fri" id="week_fri" /></label>
          <label for="week_sat">六<input type="checkbox" name="week_sat" id="week_sat" /></label>
          <label for="week_sun">日 <input type="checkbox" name="week_sun" id="week_sun" /></label>
        </div>
      </div>
      <div class="con_item">
        <label for="week_start_day" class="inner">起止日期</label>
        <div class="inner-item">
          <input class="basic-input event_calendar" id="week_begin_day" name="week_begin_day" type="text" size="12" value="" /> 至&nbsp;&nbsp;
          <input class="basic-input event_calendar" id="week_end_day" name="week_end_day" type="text" size="12" value=""/>
        </div>
      </div>
      <div class="con_item">
        <label for="week_start_time" class="inner">活动时间</label>
        <div class="inner-item">
          <input type="hidden" class="editableHook" data-id="week_begin_time" data-start="true" data-time=""/> 至&nbsp;&nbsp;
          <input type="hidden" class="editableHook" data-id="week_end_time" data-time=""/>
        </div>
      </div>
      <div class="con_item clearfix">
        <label class="inner">活动描述</label>
        <div id="eventWeekDescHook">
        </div>
      </div>
    </div>
    <div id="eventDateIntermHook" class="item inner-back hide">
      <div class="con_item">
        <label for="" class="inner">举办时间</label>
          <div class="inner-item interm-item">
            <input class="basic-input event_calendar interm_day" type="text" size="12" />
            <input type="hidden" class="editableHook" data-class="intermBeginTime" data-start="true"/> 至&nbsp;&nbsp;
            <input type="hidden" class="editableHook" data-class="intermEndTime"/>
          </div>
          <div class="inner-item interm-item">
            <input class="basic-input event_calendar interm_day" type="text" size="12" />
            <input type="hidden" class="editableHook" data-class="intermBeginTime" data-start="true"/> 至&nbsp;&nbsp;
            <input type="hidden" class="editableHook" data-class="intermEndTime"/>
          </div>
        <div class="inner-item">
          <a href="#" id="addEventDaysHook">添加时间</a>
        </div>
      </div>
      <div class="con_item clearfix">
        <label class="inner">活动描述</label>
        <div id="eventIntermDescHook">
        </div>
      </div>
    </div>
  </div>
</div>



<div class="row" id="pageAddressHook">
  
  <label class="field" for="page_address">活动地点<em class="man">*</em></label>
  <div class="item map-item-error">
    <span class="validate-error map-error-fix" style="display: inline;"></span>
    <input id="coordinate" type="hidden" name="coordinate" value="" />
  </div>
  <div class="item page-address">
    <input id="loc_id" name="loc_id" type="hidden" value="<?php echo ($currtCity[areaid]); ?>" data-url="<?php echo U('location/getarea');?>"/>
    <div class="all-address-field">
      <div id="events-new-address" class="item">
        <div class="address-field-scope">
          <span class="ui-drop-input">
            <input id="city" name="city" class="basic-input drop-input" size="6" max="8" value="<?php echo ($currtCity[areaname]); ?>" />
            <s class="tri-down"></s>
          </span>
          <select class="basic-input address-select" id="district_id" name="district_id">

          </select>
          <select class="basic-input address-select" id="region_id" name="region_id">
            <option value="0">商圈(可选)</option>
          </select>
        </div>
        <div class="item street-address">
          <input class="basic-input" id="street_address" name="street_address" type="text" size="56" placeholder="详细地址" value="" maxlength="100"/>
        </div>
        <div id="new-map-card" class="map-card">
          <div class="bd">
              <a href="javascript:void(0);" data-type="new_mark" class="lnk-modify-addr">
                <img src="http://maps.google.cn/maps/api/staticmap?size=388x106&amp;zoom=6&amp;center=北京,CN&amp;sensor=false&amp;language=zh-CN" width="388" height="106">
                <span class="map-card-nomark">在地图上标注活动地点</span>
              </a>
            <div class="map-card-modify" style=display:none>
              已标注地点 <a href="javascript:void(0);" data-type="new_mark" class="no-visited lnk-modify-addr">修改</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="item">
    <a href="javascript:void(0)" id="addDirectionHook">设置乘车路线</a>
  </div>


</div>

<div class="citypicker ui-ftip ui-ftip-cb" id="city-picker" style="display: none;">
    <i class="pointer tri-up"><i class="tri-up"></i></i>
    <div class="cities">
      <div class="hd">
        <span class="tab on">热门</span>
        <span class="tab">A - G</span>
        <span class="tab">H - L</span>
        <span class="tab">M - T</span>
        <span class="tab">W - Z</span>
      </div>
      <div class="bd hot">
          <?php if(is_array($arrCity)): foreach($arrCity as $key=>$item): ?><span><a data-uid="" data-value="<?php echo ($item[id]); ?>" href="javascript:;"><?php echo ($item[areaname]); ?></a></span><?php endforeach; endif; ?>
      </div>
        
        
        
        
    </div>
  </div>

    
<div class="row">
  <label class="field" for="desc">活动详情<em class="man">*</em></label>
  <div class="item desc">
    <textarea class="basic-input" id="desc" name="desc" rows="10" cols="54" max_length="4000" ></textarea>
  </div>
</div>

<hr class="hrline" />
    

<div class="row" id="activeFeeHook">
  <label class="field" for="fee">活动费用</label>
  <div class="item fee">

    <label class="no-need-fee">                                              
      <input name="fee" type="radio" class="fee-value" checked value="0"/>免费
    </label>                                                                 
    <label>                                                                  
      <input name="fee" type="radio" class="fee-value" value="1"  />收费
    </label> 

    <input type="hidden" name="fee_detail" id="fee_detail" value=""/>
  </div>
  <div id="active_fee" class="item inner-back hide" style="display:block">
    <div class="con_item">
      <span>名称 </span><span class="pl">（如：预售票等）</span> <span style="margin-left:15px;">费用（元）</span>
    </div>
    <div class="con_item fee_item">
      <input type="text" class="basic-input fee-name" maxlength="15" placeholder="选填"/> <input type="text" class="basic-input fee-num" maxlength="6"/>
    </div>
    <a href="#" id="addFeeHook">添加费用</a>
  </div>
  <div id="tickets_field" class="item inner-back hide">
    在接下来的"发售电子票"环节里，设置详细的票务信息。
  </div>
</div>


    <hr class="hrline" />
    <div class="row">
        <label for="priv" class="field">参加权限<em class="man">*</em></label>
        <div class="item floatbug">
            <label for="allow_others">
                <input id="allow_others" name="priv" type="checkbox"  />只有被邀请的成员才能参加
            </label>
        </div>
        <div class="item">
            <label for="need_apply">
                <input id="need_apply" name="need_apply" type="checkbox" />参加者需要提前填写报名表
            </label>
        </div>
    </div>
    <div class="row">
        <label for="label" class="field">活动标签<em class="man">*</em></label>
        <div class="item">
            <input id="tags" name="tags" class="basic-input" size="55" value="">
        </div>
        <div id="tagsContainer" class="item">
        <span class="event-tag">放映</span><span class="event-tag selected-tag">锅匠</span><span class="event-tag">锅匠，裁缝，士兵，间谍</span><span class="event-tag">奥斯卡</span><span class="event-tag">咖啡</span><span class="event-tag">戛纳电影节</span><span class="event-tag">威尼斯电影节</span><span class="event-tag">吕布</span><span class="event-tag">天堂电影院</span><span class="event-tag">观影</span>
        </div>
    </div>
    <hr class="hrline" />
    <div class="row footer">
        <div class="item">
            <input class="loc-btn" type="button" id="submit_form" value="下一步：上传活动海报" />
            <a id="cancel_form" class="lnk-flat">取消</a>
        </div>
    </div>
    </form>   
            
        </div><!--//left-->
    
        <div class="cright">
          <h2>什么是合适的同城活动？</h2>
          <ol class="pl">
              <li>有能最终确定的活动起止日期</li>
              <li>具备现实中能集体参与的活动地点</li>
              <li>是多人在现实中能碰面的活动</li>
          </ol>
          
          <br>
          <h2>如何才能让你的活动更吸引人？</h2>
          <ol class="pl">
            <li>标题简单明了 </li>
            <li>活动内容和特点介绍详细 </li>
            <li>活动海报吸引人眼球 </li>
          </ol>
          <p class="pl"> 更重要的是，邀请好友们都来参与！ </p>    
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