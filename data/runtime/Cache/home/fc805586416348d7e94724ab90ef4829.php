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
        <?php if(empty($visitor)): ?><a href="<?php echo U('user/login');?>">登录</a> | <a href="<?php echo U('user/register');?>">注册</a> | <a href="<?php echo U('oauth/index', array('mod'=>'qq'));?>" target="_blank" style="margin-left:10px"><img  align="absmiddle" title="QQ登录" src="__STATIC__/public/images/connect_qq.png"> 登录</a> | <a href="<?php echo U('oauth/index', array('mod'=>'sina'));?>" target="_blank" style="margin-left:10px"><img  align="absmiddle" title="新浪微博" src="__STATIC__/public/images/connect_sina_weibo.png"> 登录</a>    
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
    
   	    <h1><?php echo ($seo["title"]); ?></h1>
       
        <div class="cleft w700">


            <div class="group_topics">
                <table class="olt">
                    <tbody>
            <?php if(!empty($arrTopic)): if(is_array($arrTopic)): foreach($arrTopic as $key=>$item): ?><tr class="pl">
               <td class="td-subject"><a title="<?php echo ($item[title]); ?>" href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>"><?php echo getsubstrutf8(t($item['title']),0,25); ?></a>
                <?php if($item[isvideo] == 1): ?><img src="__STATIC__/public/images/lc_cinema.png" align="absmiddle" title="[视频]" alt="[视频]" /><?php endif; ?>                
                <?php if($item[istop] == 1): ?><img src="__STATIC__/public/images/headtopic_1.gif" title="[置顶]" alt="[置顶]" /><?php endif; ?>
                <?php if($item[addtime] > (strtotime(date('Y-m-d 00:00:00')))): ?><img src="__STATIC__/public/images/topic_new.gif" align="absmiddle"  title="[新帖]" alt="[新帖]" /><?php endif; ?> 
                <?php if($item[isphoto] == 1): ?><img src="__STATIC__/public/images/image_s.gif" title="[图片]" alt="[图片]" align="absmiddle" /><?php endif; ?> 
                <?php if($item[isattach] == 1): ?><img src="__STATIC__/public/images/attach.gif" title="[附件]" alt="[附件]" /><?php endif; ?> 
                <?php if($item[isdigest] == 1): ?><img src="__STATIC__/public/images/posts.gif" title="[精华]" alt="[精华]" /><?php endif; ?>
                </td>
                <td class="td-reply" nowrap="nowrap"><?php if($item[count_comment] > 0): echo ($item[count_comment]); ?> 回应<?php endif; ?></td>
                <td class="td-time" nowrap="nowrap"><?php echo getTime($item[uptime],time()); ?></td>
                <td align="right"><a href="<?php echo U('group/show',array('id'=>$item[groupid]));?>"><?php echo getsubstrutf8(t($item[group][groupname]),0,10); ?></a></td>
                </tr><?php endforeach; endif; endif; ?>         
                </tbody>
              </table>
            </div>
            
             
            
            <div class="clear"></div>
    
    
    	</div>
    
        <div class="cright w250" id="cright">   
              
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
               
    <div class="group-nav">
     <ul>
		<?php if($action_name == 'my_group_topics'): ?><li class="on"><a href="<?php echo U('group/my_group_topics');?>">我的小组话题</a></li>
		<?php else: ?>
		<li class=""><a href="<?php echo U('group/my_group_topics');?>">我的小组话题</a></li><?php endif; ?>
        
		<?php if($action_name == 'my_topics'): ?><li class="on"><a href="<?php echo U('group/my_topics');?>">我发起的话题</a></li>
		<?php else: ?>
		<li class=""><a href="<?php echo U('group/my_topics');?>">我发起的话题</a></li><?php endif; ?>
        		
		<?php if($action_name == 'my_replied_topics'): ?><li class="on"><a href="<?php echo U('group/my_replied_topics');?>">我回应的话题</a></li>
		<?php else: ?>
		<li class=""><a href="<?php echo U('group/my_replied_topics');?>">我回应的话题</a></li><?php endif; ?>
		
		<?php if($action_name == 'my_collect_topics'): ?><li class="on"><a href="<?php echo U('group/my_collect_topics');?>">我喜欢的话题</a></li>
		<?php else: ?>
		<li class=""><a href="<?php echo U('group/my_collect_topics');?>">我喜欢的话题</a></li><?php endif; ?>
		
		<?php if($action_name == 'mine'): ?><li class="on"><a href="<?php echo U('group/mine');?>">我管理/加入的小组</a></li>
		<?php else: ?>
		<li class=""><a href="<?php echo U('group/mine');?>">我管理/加入的小组</a></li><?php endif; ?>
     </ul>
    </div>
             
</div> 
         
<div class="mod">
<?php if($visitor): ?><div class="create-group">
<a href="<?php echo U('group/create');?>"><i>+</i>申请创建小组</a>
</div><?php endif; ?>
</div>                 
        
        </div>
    
    </div><!--//mc-->


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