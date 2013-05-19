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
<!--main-->
<div class="midder">
  <div class="mc">
    <h1><?php echo ($strTopic[title]); if($strTopic[isaudit] == 1): ?><font class="red">[审核中]</font><?php endif; ?></h1>
    <div class="cleft"> 
      
<?php if($page==1){ ?>
      
      <div class="topic-content clearfix">
        <div class="user-face"> <a href="<?php echo U('people/index',array('id'=>$strTopic[user][doname]));?>"><img title="<?php echo ($strTopic[user][username]); ?>" alt="<?php echo ($strTopic[user][username]); ?>" src="<?php echo avatar($strTopic['userid'], 48);?>" width="48"></a></div>
        <div class="topic-doc">
          <h3> <span class="color-green"><?php echo date('Y-m-d H:i:s',$strTopic[addtime]) ?></span> <span class="pl20">来自：<a href="<?php echo U('people/index',array('id'=>$strTopic[user][doname]));?>"><?php echo ($strTopic[user][username]); ?></a></span> </h3>
          <div class="topic-view"><?php echo ($strTopic['content']); ?></div>
          
          <!--签名--> 
          <?php if($strTopic[user][signed] != ''): ?><div class="signed"><?php echo ($strTopic[user][signed]); ?></div><?php endif; ?>
          
         
          <?php if(($user[userid] == $strTopic[userid]) OR ($user[userid] == $strGroup[userid]) OR ($strGroupUser[isadmin] == 1) OR ($user[isadmin] == 1) ): ?><div style="text-align:right;"> 
                <?php if(($user[userid] == $strGroup[userid]) OR ($strGroupUser[isadmin] == 1) OR ($user[isadmin] == 1)): ?>&gt;&nbsp; 
                    <a href="<?php echo U('group/topic',array('d'=>'topic_istop','topicid'=>$strTopic[topicid]));?>"><?php echo ($action[istop]); ?></a> &gt;&nbsp; 
                    <a href="<?php echo U('group/topic',array('d'=>'isdigest','topicid'=>$strTopic[topicid]));?>"><?php echo ($action[isdigest]); ?></a> &gt;&nbsp; 
                    <a href="<?php echo U('group/topic',array('d'=>'isshow','topicid'=>$strTopic[topicid]));?>"><?php echo ($action[isshow]); ?></a>  
                    <!--&gt;&nbsp;<a href="<?php echo U('group/topic',array('d'=>'topic_move','groupid'=>$strTopic[groupid],'topicid'=>$strTopic[topicid]));?>"><?php echo ($action[move]); ?></a>--><?php endif; ?>
            	&gt;&nbsp; 
            	<a href="<?php echo U('group/topic',array('d'=>'topic_edit','topicid'=>$strTopic[topicid]));?>">编辑</a> &gt;&nbsp; 
            	<a href="<?php echo U('group/topic',array('d'=>'deltopic','topicid'=>$strTopic[topicid]));?>" onclick="return confirm('确定删除?')">删除</a> 

            </div><?php endif; ?>
          
        </div>
      </div>
      <?php if($visitor['userid']): ?><div class="sns-bar">
        	<div class="sns-bar-rec">
                <span class="rec">
                    <a class="bn-sharing  i a_share_btn" data-pic="<?php echo ($strTopic[content_photo][0]); ?>" data-title="<?php echo ($strTopic[title]); ?>" data-desc="<?php echo getsubstrutf8(t($strTopic[content]),0,150) ?>" data-url="<?php echo U('group/topic',array('id'=>$strTopic[topicid]));?>" href="#">分享到</a> &nbsp;&nbsp;
                </span>            
            	<div class="rec-sec"><a href="<?php echo U('group/topic',array('d'=>'topic_recommend'));?>" title="推荐" class="lnk-sharing i a_recommend_btn"  data-title="<?php echo getsubstrutf8(t($strTopic[title]),0,40); ?>"  data-desc="<?php echo getsubstrutf8(t($strTopic[content]),0,100) ?>"  data-tkind="<?php echo ($strTopic[groupid]); ?>" data-tid="<?php echo ($strTopic[topicid]); ?>" data-tuid="<?php echo ($IK_USER['user']['userid']); ?>" data-url="<?php echo U('group/topic',array('id'=>$strTopic[topicid]));?>">推荐</a> <span class="rec-num" id="rec-num"><?php echo ($strTopic[count_recommend]); ?>人</span></div>
            </div>
            <div class="sns-bar-fav">
            	<span  class="fav-num"><a href="javascript:;" id="like-num"><?php echo ($strTopic[count_collect]); ?>人</a> 喜欢 </span>
            	<?php if($strTopic[islike]): ?><a href="<?php echo U('group/topic',array('d'=>'topic_collect'));?>" title="取消喜欢" data-tkind="<?php echo ($strTopic[groupid]); ?>" data-tid="<?php echo ($strTopic[topicid]); ?>" data-tuid="<?php echo ($user['userid']); ?>" class="btn-fav fav-cancel i a_like_btn">喜欢</a> 
				<?php else: ?>
                <a href="<?php echo U('group/topic',array('d'=>'topic_collect'));?>" title="标为喜欢" data-tkind="<?php echo ($strTopic[groupid]); ?>" data-tid="<?php echo ($strTopic[topicid]); ?>" data-tuid="<?php echo ($user['userid']); ?>" class="btn-fav fav-add i a_like_btn">喜欢</a><?php endif; ?>
            </div>        
        </div><?php endif; ?>
      
      <div class="clear"></div>

      <div class="tags"> 
        <?php if(is_array($strTopic[tags])): $i = 0; $__LIST__ = $strTopic[tags];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a rel="tag" title="<?php echo ($item[tagname]); ?>" class="post-tag" href="<?php echo U('group/explore_topic',array('tag'=>$item[tagname]));?>"><?php echo ($item[tagname]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(($user[userid] == $strGroup[userid]) OR ($strGroupUser[isadmin] == 1) OR ($user[isadmin] == 1)): ?><a rel="tag" href="javascript:void(0);" onclick="showTagFrom()">+标签</a>
        <p id="tagFrom" style="display:none">
          <input class="tagtxt" type="text" name="tags" id="tags" />
          <button type="submit" class="subab" onclick="savaTag(<?php echo ($strTopic[topicid]); ?>)">添加</button>
          <a href="javascript:void(0);" onclick="showTagFrom()">取消</a> </p><?php endif; ?> 
      </div>
      
<?php } ?>
      
      <div class="clear"></div>
      <div> 
     	 <?php if(!empty($upTopic)): ?>上一篇：<a href="<?php echo U('group/topic',array('id'=>$upTopic['topicid']));?>"><?php echo ($upTopic['title']); ?></a><?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
         <?php if(!empty($downTopic)): ?>下一篇：<a href="<?php echo U('group/topic',array('id'=>$downTopic['topicid']));?>"><?php echo ($downTopic['title']); ?></a><?php endif; ?>
      </div>
      
      
      <div class="orderbar"> 
        <?php if(($page == 1) && ($strTopic[count_comment] > 3)): ?><a href="<?php echo U('group/topic',array('id'=>$strTopic[topicid],'sc'=>$sc,'isauthor'=>$author[isauthor]));?>"><?php echo ($author[text]); ?></a>&nbsp;&nbsp;
        <?php if($sc == 'asc'): ?><a href="<?php echo U('group/topic',array('id'=>$strTopic[topicid],'sc'=>'desc','isauthor'=>$isauthor));?>">倒序阅读</a> 
        <?php else: ?>
        	<a href="<?php echo U('group/topic',array('id'=>$strTopic[topicid],'sc'=>'asc','isauthor'=>$isauthor));?>">正序阅读</a><?php endif; endif; ?>
      </div>
      
      <!--comment评论-->
      <ul class="comment" id="comment">
       <?php if(!empty($arrTopicComment)): if(is_array($arrTopicComment)): foreach($arrTopicComment as $key=>$item): ?><li class="clearfix">
          <div class="user-face"> <a href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>"><img title="<?php echo ($item[user][username]); ?>" alt="<?php echo ($item[user][username]); ?>" src="<?php echo ($item[user][face]); ?>"></a> </div>
          <div class="reply-doc">
            <h4><span class="fr"></span><a href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>"><?php echo ($item[user][username]); ?></a> <?php echo date('Y-m-d H:i:s',$item[addtime]) ?></h4>
            
            <?php if($item[referid] != 0): ?><div class="recomment"><a href="<?php echo U('people/index',array('id'=>$item[recomment][user][doname]));?>"><img src="<?php echo ($item[recomment][user][face]); ?>" width="24" align="absmiddle"></a> <strong><a href="<?php echo U('people/index',array('id'=>$item[recomment][user][doname]));?>"><?php echo ($item[recomment][user][username]); ?></a></strong>：<?php echo ($item[recomment][content]); ?></div><?php endif; ?>
            
            <p> <?php echo ($item[content]); ?> </p>
            
            <!--签名--> 
            <?php if(!empty($item[user][signed])): ?><div class="signed"><?php echo ($item[user][signed]); ?></div><?php endif; ?>
            
            <div class="group_banned"> 
              <?php if($isGroupUser != 0): ?><span><a href="javascript:void(0)"  onclick="commentOpen(<?php echo ($item[commentid]); ?>,<?php echo ($item[topicid]); ?>)">回复</a></span><?php endif; ?>
              <?php if(($strTopic[userid] == $visitor[userid]) OR ($strGroup[userid] == $visitor[userid]) OR ($visitor[userid] == $item[userid]) OR ($strGroupUser[isadmin] == 1) OR ($visitor[userid] == 1)): ?><span><a class="j a_confirm_link" href="<?php echo U('group/topic',array('d'=>'delcomment','commentid'=>$item[commentid]));?>" rel="nofollow" onclick="return confirm('确定删除?')">删除</a> </span><?php endif; ?>
            </div>
            <div id="rcomment_<?php echo ($item[commentid]); ?>" style="display:none; clear:both; padding:0px 10px">
              <textarea style="width:550px;height:50px;font-size:12px; margin:0px auto;" id="recontent_<?php echo ($item[commentid]); ?>" type="text" onkeydown="keyRecomment(<?php echo ($item[commentid]); ?>,<?php echo ($item[topicid]); ?>,event)" class="txt"></textarea>
              <p style=" padding:5px 0px">
                <button onclick="recomment(<?php echo ($item[commentid]); ?>,<?php echo ($item[topicid]); ?>)" id="recomm_btn_<?php echo ($item[commentid]); ?>" class="subab">提交</button>
                &nbsp;&nbsp;<a href="javascript:;" onclick="$('#rcomment_<?php echo ($item[commentid]); ?>').slideToggle('fast');">取消</a> </p>
            </div>
          </div>
          <div class="clear"></div>
        </li><?php endforeach; endif; endif; ?>
      </ul>
      <div class="page"><?php echo ($pageUrl); ?></div>
      <h2>你的回应&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2>
      <div> 
        <?php if(!$visitor['userid']): ?><div style="border:solid 1px #DDDDDD; text-align:center;padding:20px 0"><a href="<?php echo U('user/login');?>">登录</a> | <a href="<?php echo U('user/register');?>">注册</a></div>
        <?php elseif(!$isGroupUser): ?> 
        不是本组成员不能回应此贴哦 
        <?php elseif($strTopic[iscomment] == 1 && $strTopic[userid] != $visitor['userid']): ?>
        本帖除作者外不允许任何人评论 
        <?php else: ?>
        <form method="POST" action="<?php echo U('group/topic',array('d'=>'addcomment'));?>" onSubmit="return checkComment('#formMini');" id="formMini" enctype="multipart/form-data">
          <textarea  style="width:100%;height:100px;" id="editor_mini" name="content" class="txt" onkeydown="keyComment('#formMini',event)"></textarea>
          <input type="hidden" name="topicid" value="<?php echo ($strTopic[topicid]); ?>" />
          <input type="hidden" name="p" value="<?php echo ($page); ?>" />
          <input class="submit" type="submit" value="加上去(Crtl+Enter)" style="margin:10px 0px">
        </form><?php endif; ?>
      </div>
    </div>
    <div class="cright">
       <?php if($isGroupUser): ?><div class="side-reg" id="g-side-info-member">
          <div class="bd">
              <div class="group-item">
                  <div class="pic">
                       <a href="<?php echo U('group/show',array('id'=>$strGroup[groupid]));?>" title="<?php echo ($strGroup[groupname]); ?>"><img src="<?php echo ($strGroup[icon_48]); ?>" alt="<?php echo ($strGroup[groupname]); ?>"></a>
                  </div>
                  <div class="info">
                      <div class="title">
                          <a href="<?php echo U('group/show',array('id'=>$strGroup[groupid]));?>" title="<?php echo ($strGroup[groupname]); ?>"><?php echo getsubstrutf8(t($strGroup[groupname]),0,14) ?></a>
                      </div>
                  <div class="member-info1">我是小组的成员</div>
              </div>
            </div>
          </div>
        </div>    
     <?php else: ?>
      <div class="side-reg" id="g-side-info">
        <div class="bd">
          <div class="group-item">
            <div class="pic"> <a href="<?php echo U('group/show',array('id'=>$strGroup[groupid]));?>"> <img src="<?php echo ($strGroup[icon_48]); ?>"> </a> </div>
            <div class="info">
              <div class="title"> <a href="<?php echo U('group/show',array('id'=>$strGroup[groupid]));?>"><?php echo getsubstrutf8(t($strGroup[groupname]),0,14) ?></a> </div>
              	<div class="member-info"> <i><?php echo ($strGroup[count_user]); ?></i> 人聚集在这个小组 </div>
              	<p><?php echo getsubstrutf8(t($strGroup[groupdesc]),0,46) ?></p>
            </div>
          </div>
        </div>
        <div class="ft">
          <div class="member-status"><a class="bn-join" href="<?php echo U('group/join', array('id'=>$strGroup['groupid']));?>">加入小组</a></div>
        </div>
      </div><?php endif; ?>
      
      <h2>喜欢该帖子的人</h2>
      
      <div id="collects">
         <div style="margin-bottom: 10px;overflow: hidden;">
<?php if(isset($arrCollectUser)): if(is_array($arrCollectUser)): foreach($arrCollectUser as $key=>$item): ?><dl class="obu">
        <dt>
        	<a href="<?php echo U('people/index',array('id'=>$item[doname]));?>" title="<?php echo ($item[username]); ?>">
        		<img  alt="<?php echo ($item[username]); ?>"  src="<?php echo avatar($item['userid'], 48);?>"class="m_sub_img"  >
            </a>
        </dt>
        <dd>
        	 <?php echo ($item[username]); ?><br>
            <span class="pl">(<a href="<?php echo U('location/area',array('areaid'=>$item[area][areaid]));?>"><?php echo ($item[area][areaname]); ?></a>)</span>
        </dd>
</dl><?php endforeach; endif; ?>
<?php else: ?>
<div style="color: #999999;padding: 20px 0">还没有人收藏，赶快来做第一个收藏者吧^_^</div><?php endif; ?>
<br clear="all">
</div>
      </div>
      <h2 class="usf">最新话题</h2>
      <div class="indent newtopic">
        <ul>
          <?php if(is_array($newTopic)): $i = 0; $__LIST__ = $newTopic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><a title="<?php echo ($item[title]); ?>" href="<?php echo U('group/topic', array('id'=>$item[topicid]));?>"><?php echo ($item[title]); ?></a> &nbsp; <span class="pl">(<a href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>"><?php echo ($item[user][username]); ?></a>) </span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
      <div class="clear"></div>
<script type="text/javascript">
     document.write('<a style="display:none!important" id="tanx-a-mm_11053146_4018392_13074166"></a>');
     tanx_s = document.createElement("script");
     tanx_s.type = "text/javascript";
     tanx_s.charset = "gbk";
     tanx_s.id = "tanx-s-mm_11053146_4018392_13074166";
     tanx_s.async = true;
     tanx_s.src = "http://p.tanx.com/ex?i=mm_11053146_4018392_13074166";
     tanx_h = document.getElementsByTagName("head")[0];
     if(tanx_h)tanx_h.insertBefore(tanx_s,tanx_h.firstChild);
</script>
      
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