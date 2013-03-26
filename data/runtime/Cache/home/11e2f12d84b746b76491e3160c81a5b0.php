<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta property="qc:admins" content="12472730776130006375" />
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
    <?php if(empty($visitor[userid])): ?><div class="anony-nav">
            <div class="bd">
            <div class="reg">
            
            <strong>爱客社区</strong>
            <div>
            <b>爱客网开源社区程序，内容互动性强，交流更方便</b><br><em>简单</em><em>快捷</em><em>方便</em><em>建设本地化，垂直型社区；目前已有<cite><?php echo ($count_user); ?></cite>位用户加入！</em>
            </div>
            <a class="submit" href="<?php echo U('user/register');?>">加入我们</a>
            </div>
            
            <div class="login">
            <form action="<?php echo U('user/login');?>" method="post" name="lzform" id="lzform">
            <fieldset>
            <legend>登录</legend>
            <div class="item">
            <label>Email：</label><input type="email" tabindex="1" value="" name="email" class="txt">
            </div>
            <div class="item">
            <label>密码：</label><input type="password" tabindex="2" class="txt" name="password" > <a href="<?php echo U('user/forgetpwd');?>">忘记密码？</a>
            </div>
            
            <div class="item1">
            <label for="form_remember"><input type="checkbox" tabindex="3" id="form_remember" name="remember"> 记住我</label>
            </div>
            <div class="item1">
            <input type="hidden" name="cktime" value="2592000" />
            <input type="hidden" name="ret_url" value="<?php echo ($ret_url); ?>" />
            <input type="submit" tabindex="4" class="submit" value="登录" style="margin-left:10px">
            
            </div>
            </fieldset>
            </form>
            </div>
            
            </div>
        </div><?php endif; ?>

    <div class="mc">
    
        <div class="cleft">
        
            <h2>推荐小组<span class="pl">&nbsp;(<a href="<?php echo U('group/explore');?>">全部</a>) </span></h2>
        
            <div style="overflow:hidden;">
            <?php if(is_array($arrRecommendGroup)): foreach($arrRecommendGroup as $key=>$item): ?><div class="sub-item">
            <div class="pic">
            <a href="<?php echo U('group/show',array('id'=>$item[groupid]));?>">
            <img src="<?php echo ($item[icon_48]); ?>" alt="<?php echo ($item[groupname]); ?>">
            </a>
            </div>
            <div class="info">
            <a href="<?php echo U('group/show',array('id'=>$item[groupid]));?>"><?php echo ($item[groupname]); ?></a> (<?php echo ($item[count_user]); ?>/<font color="orange"><?php echo ($item[count_topic]); ?></font>)             
            <p><?php echo ($item[groupdesc]); ?></p>
            </div>
            </div><?php endforeach; endif; ?>
            </div>
            <div class="clear"></div>
        
            <h2>最热话题<span class="pl">&nbsp;(<a href="<?php echo U('group/explore_topic');?>">更多</a>) </span></h2>
            <div class="topic-list">
                <?php if(is_array($arrHotTopic)): foreach($arrHotTopic as $key=>$item): ?><dl>
                    <dt><a href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>"><img src="<?php echo ($item[user][face]); ?>"/></a></dt>
                    <dd>
                        <header class="title"><span><a href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>#comment" title="回复数"><?php echo ($item[count_comment]); ?></a></span><a href="<?php echo U('group/topic',array('id'=>$item[topicid]));?>" title="<?php echo ($time[title]); ?>"><?php echo ($item[title]); ?></a></header>
                         <a href="<?php echo U('people/index',array('id'=>$item[user][doname]));?>"><?php echo ($item[user][username]); ?></a> <summary><?php echo getTime($item[addtime],time()) ?> <?php echo ($item[count_view]); ?>次阅读</summary>
                        <p><?php echo ($item[content]); ?></p>
                    </dd>
                </dl><?php endforeach; endif; ?>
            </div>
        
        </div><!--//left-->
    
        <div class="cright">
            <h2>活跃用户</h2>
            <div class="indent">
            
           <?php if(is_array($arrHotUser)): foreach($arrHotUser as $key=>$item): ?><dl class="obu">
                <dt>
                    <a href="<?php echo U('people/index',array('id'=>$item[doname]));?>">
                    <img alt="<?php echo ($item[username]); ?>" class="m_sub_img" src="<?php echo ($item[face]); ?>" width="48" />
                    </a>
                </dt>
                <dd>
                    <a href="{U('hi','',array('id'=>$item[doname]))}"><?php echo ($item[username]); ?></a>
                </dd>
            </dl><?php endforeach; endif; ?>
            <br clear="all"/>
            </div>
            
            <h2>最新创建小组&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·<span class="pl">&nbsp;(<a href="<?php echo U('group/explore');?>">全部</a>) </span></h2>
            <div class="line23">
            <?php if(is_array($arrNewGroup)): foreach($arrNewGroup as $key=>$item): ?><a href="<?php echo U('group/show',array('id'=>$item[groupid]));?>"><?php echo ($item[groupname]); ?></a> (<?php echo ($item[count_user]); if($item[uptime] > strtotime(date('Y-m-d 00:00:00'))): ?>/<font color="orange"><?php echo ($item[count_topic_today]); ?></font><?php endif; ?>)<br><?php endforeach; endif; ?>
            </div>

			<h2>最新文章&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·<span class="pl">&nbsp;(<a href="<?php echo U('article/index');?>">全部</a>) </span></h2>
			<div class="line23">
			<?php if(is_array($arrNewArticle)): foreach($arrNewArticle as $key=>$item): ?><a href="<?php echo U('article/show',array('id'=>$item[itemid]));?>"><?php echo ($item[title]); ?></a><br><?php endforeach; endif; ?>
			</div>
        
        
            <div class="clear"></div>
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
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  <?php echo C('site_icp');?> <span style="color:green">ThinkPHP 版本 <?php echo (THINK_VERSION); ?></span><br /><span style="font-size:0.83em;"></span>
        
        <!--<script src="http://s21.cnzz.com/stat.php?id=2973516&web_id=2973516" language="JavaScript"></script>-->
        </p>   
    </div>
</div>
</footer>
</body>
</html>