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
<!--main-->
<div class="midder">

<div class="mc">
<div id="group-info">
	<img align="left" alt="<?php echo ($strGroup[groupname]); ?>" src="<?php echo ($strGroup[icon_48]); ?>" class="pil mr10 groupicon"/>
    <h1 class="group_tit"><?php echo ($strGroup[groupname]); if($strGroup[isaudit] == 1): ?><font class="red">[审核中]</font><?php endif; ?></h1>

    <div class="group-misc">
    <?php if($isGroupUser && ($strGroup[userid]!=$visitor[userid])): ?><span class="fleft mr5 color-gray">我是这个小组的<?php echo ($strGroup['role_user']); ?> <a class="j a_confirm_link" href="<?php echo U('group/quit',array('id'=>$strGroup['groupid']));?>" style="margin-left: 6px;">&gt;退出小组</a></span>
    
    <?php elseif($isGroupUser && ($strGroup[userid]==$visitor[userid])): ?>
    
    <span class="fleft mr5 color-gray">我是这个小组的<?php echo ($strGroup['role_leader']); ?></span><?php endif; ?>
    <?php if($strGroup[joinway] == 0 && !$isGroupUser): ?><a rel="nofollow" class="button-join" href="<?php echo U('group/join',array('id'=>$strGroup['groupid']));?>">
                    <span>加入小组</span>
                </a><?php endif; ?>
	<?php if($strGroup[joinway] != 0): ?><span>本小组禁止加入</span><?php endif; ?>
	</div>
    
</div>

<div class="cleft">
<div class="infobox">

<div class="bd">
    <p>创建于<?php echo date('Y-m-d',$strGroup[addtime]) ?>&nbsp; &nbsp; <?php echo ($strGroup[role_leader]); ?>：<a href="<?php echo U('people/index',array('id'=>$strLeader[doname]));?>"><?php echo ($strLeader[username]); ?></a></p>
    <?php echo nl2br($strGroup[groupdesc]); ?>
</div>

</div>

<div class="box">

<div class="box_content">

    <h2 style="margin-top:10px">
                <a class="rr bn-post" href="<?php echo U('group/add',array('id'=>$strGroup[groupid]));?>"><span>+发言</span></a>
        最近小组话题  · · · · · ·
    </h2>

<div class="clear"></div>

            <div class="indent">
                <table class="olt">
                    <tbody>
                        <tr>
                            <td>话题</td>
                            <td nowrap="nowrap">作者</td>
                            <td nowrap="nowrap">回应</td>
                            <td align="right" nowrap="nowrap">最后回应</td>
                        </tr>
            <?php if(!empty($arrTopic)): if(is_array($arrTopic)): foreach($arrTopic as $key=>$item): ?><tr class="pl">
                                <td class="td-title">
                                <a title="<?php echo ($item[title]); ?>" href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>">
                                <?php echo getsubstrutf8(t($item['title']),0,25); ?>
                                </a>
                                <?php if($item[isvideo] == 1): ?><img src="__STATIC__/public/images/lc_cinema.png" align="absmiddle" title="[视频]" alt="[视频]" /><?php endif; ?>                
                                <?php if($item[istop] == 1): ?><img src="__STATIC__/public/images/headtopic_1.gif" title="[置顶]" alt="[置顶]" /><?php endif; ?>
                                <?php if($item[addtime] > (strtotime(date('Y-m-d 00:00:00')))): ?><img src="__STATIC__/public/images/topic_new.gif" align="absmiddle"  title="[新帖]" alt="[新帖]" /><?php endif; ?> 
                                <?php if($item[isphoto] == 1): ?><img src="__STATIC__/public/images/image_s.gif" title="[图片]" alt="[图片]" align="absmiddle" /><?php endif; ?> 
                                <?php if($item[isattach] == 1): ?><img src="__STATIC__/public/images/attach.gif" title="[附件]" alt="[附件]" /><?php endif; ?> 
                                <?php if($item[isdigest] == 1): ?><img src="__STATIC__/public/images/posts.gif" title="[精华]" alt="[精华]" /><?php endif; ?>
            					</td>
                                <td nowrap="nowrap"><a href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>"><?php echo ($item[user][username]); ?></a></td>
                                <td nowrap="nowrap" ><?php if($item[count_comment]): echo ($item[count_comment]); endif; ?></td>
                                <td nowrap="nowrap" class="time" align="right"><?php echo getTime($item[uptime],time()) ?></td>
                            </tr><?php endforeach; endif; endif; ?>         
                </tbody>
              </table>
            </div>

	<div class="clear"></div>
	<div class="page"><?php echo ($pageUrl); ?></div>

</div>
</div>

</div>


<div class="cright">
    <div>
        <h2>最新加入成员</h2>
        <?php if(is_array($arrGroupUser)): foreach($arrGroupUser as $key=>$item): ?><dl class="obu">
            <dt>
            <a href="<?php echo U('people/index',array('id'=>$item[doname]));?>"><img alt="<?php echo ($item[username]); ?>" class="m_sub_img" src="<?php echo ($item[face]); ?>" /></a>
            </dt>
            <dd><?php echo ($item[username]); ?><br>
                <span class="pl">(<a href="<?php echo U('location/area',array(areaid=>$item[area][areaid]));?>"><?php echo ($item[area][areaname]); ?></a>)</span>
            </dd>
     	 </dl><?php endforeach; endif; ?>
    
        <br clear="all">
    
        <?php if($visitor[userid] == $strGroup[userid]): ?><p class="pl2">&gt; <a href="<?php echo U('group/group_user',array(groupid=>$strGroup[groupid]));?>">成员管理 (<?php echo ($strGroup[count_user]); ?>)</a></p>
            
            <p class="pl2">&gt; <a href="<?php echo U('group/edit',array(d=>base,groupid=>$strGroup[groupid]));?>">修改小组设置 </a></p>
            
            <?php else: ?>
            
            <p class="pl2"><a href="<?php echo U('group/group_user',array(groupid=>$strGroup[groupid]));?>">浏览所有成员 (<?php echo ($strGroup[count_user]); ?>)</a></p><?php endif; ?>
        
       <div class="clear"></div>

        
    </div>
    
	<p class="pl">本页永久链接: <a href="<?php echo U('group/show',array(id=>$strGroup[groupid]));?>">http://www.ikphp.com<?php echo U('group/show',array(id=>$strGroup[groupid]));?></a></p>
    
    <p class="pl"><span class="feed"><a href="<?php echo U('group/rss',array(id=>$strGroup[groupid]));?>">feed: rss 2.0</a></span></p>
    
    <div class="clear"></div>
    
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