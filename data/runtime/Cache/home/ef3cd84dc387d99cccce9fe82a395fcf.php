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
             <a href="<?php echo U('site/index');?>">小站</a>
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
    <h1>申请创建小组</h1>
    <div class="mc">

        <div class="cleft">
        <form method="POST" action="<?php echo U('group/create');?>"  enctype="multipart/form-data" onsubmit="return createGroup(this);">
        <table width="100%" cellpadding="0" cellspacing="0" class="table_1">
            <tr>
                <th>小组名称：</th>
                <td><input type="text" value="" maxlength="63" size="31" name="groupname" tabindex="1" class="txt"    placeholder="请填写小组名称"></td>
            </tr>
            <tr>
                <th>小组介绍：</th>
                <td><textarea style="width:500px;height:200px;" name="groupdesc" tabindex="2" id="editor_mini" class="txt"   placeholder="请填写小组介绍"></textarea></td>
            </tr>
            <tr>
                <th>小组标签：</th>
                <td>
                	<input style="width:300px;" onKeyDown="checkTag(this)" onKeyUp="checkTag(this)"  onBlur="checkTag(this)" type="text" value=""  name="tag" id="tag" tabindex="3" class="txt" placeholder="请填写小组标签"> <span class="tip">最多 5 个标签</span>
                </td>
            </tr> 
			<tr>
        	<th>&nbsp;</th>
            <td><div class="site-tags">
            	<dl class="tag-items" id="tag-items">
                    <dd onClick="tags(this)">生活</dd>
                    <dd onClick="tags(this)">同城</dd>
                    <dd onClick="tags(this)">影视</dd>
                    <dd onClick="tags(this)">工作室</dd>
                    <dd onClick="tags(this)">艺术</dd>
                    <dd onClick="tags(this)">音乐</dd>
                    <dd onClick="tags(this)">品牌</dd>
                    <dd onClick="tags(this)">手工</dd>
                    <dd onClick="tags(this)">闲聊</dd>
                    <dd onClick="tags(this)">设计</dd>
                    <dd onClick="tags(this)">服饰</dd>
                    <dd onClick="tags(this)">摄影</dd>
                    <dd onClick="tags(this)">媒体</dd>
                    <dd onClick="tags(this)">美食</dd>
                    <dd onClick="tags(this)">读书</dd>
                    <dd onClick="tags(this)">公益</dd>
                    <dd onClick="tags(this)">互联网</dd>
                    <dd onClick="tags(this)">动漫</dd>
                    <dd onClick="tags(this)">旅行</dd>
                    <dd onClick="tags(this)">绘画</dd>
                    <dd onClick="tags(this)">美容</dd>
                    <dd onClick="tags(this)">购物</dd>
                    <dd onClick="tags(this)">电影</dd>
                    <dd onClick="tags(this)">教育公益</dd>
                    <dd onClick="tags(this)">游戏</dd>
                </dl>
            </div></td>
        	</tr> 
            <tr>
                <th>&nbsp;</th>
                <td style="padding-top:0px ">
                	<p class="tips">标签作为关键词可以被用户搜索到，多个标签之间用空格分隔开。</p>
                </td>
            </tr>                                               
            <tr>
                <th>小组图标：</th>
                <td><input type="file" name="picfile" class="txt" tabindex="4"><span class="tip">(仅支持jpg，gif，png格式图片)</span></td>
            </tr>           
            <tr>
                <th>&nbsp;</th>
                <td>
                <label><input type="checkbox" checked  name="grp_agreement" id="grp_agreement" value="1" tabindex="5">&nbsp;我已认真阅读并同意《社区指导原则》和《免责声明》</label>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td><input class="submit" type="submit" value="创建小组" tabindex="6"/></td>
            </tr>
        </table>
        </form>
        </div>
    
        <div class="cright"></div>

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