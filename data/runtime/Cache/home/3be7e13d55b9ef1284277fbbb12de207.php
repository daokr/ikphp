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
        <h1>
        <?php echo ($seo["title"]); ?>
        </h1>    
<form method="POST" action="<?php echo U('article/publish');?>"  onsubmit="return checkForm(this);"  enctype="multipart/form-data" id="form_tipic">
<table width="100%" cellpadding="0" cellspacing="0" class="table_1">

	<tr>
    	<th>标题：</th>
		<td><input style="width:400px;" type="text" value="<?php echo ($strArticle[title]); ?>" maxlength="100" size="50" name="title" tabindex="1" class="txt" placeholder="请填写标题"></td>
    </tr>	
    <tr>
        <th>发表到：</th>
        <td>
            <select name="cateid" class="txt" id="cate_select" style="float:left;" tabindex="2" >
                <option  value="0">默认分类</option>
                <?php echo ($arrCate); ?>
            </select>            
        </td>
    </tr>
    <tr><th>&nbsp;</th>
        <td align="left" style="padding:0px 10px">
        <a href="javascript:;" id="addImg">添加图片</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:;" id="addVideo">添加视频</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:;" id="addLink">添加链接</a>
        </td>
    </tr>
    <tr>
        <th>内容：</th>
        <td style="padding-bottom:0px">
        <input type="hidden" name="id" value="<?php echo ($strArticle[aid]); ?>"/>
        <textarea tabindex="3"  style="width:99.5%;height:300px;" maxlength="10000" id="editor_full" cols="55" rows="20" name="content" class="txt"   placeholder="请填写内容"><?php echo ($strArticle[content]); ?></textarea>
        <div class="ik_toolbar" id="ik_toolbar"><span class="textnum" id="textnum"><em>0</em> / <em>10000</em> 受欢迎的字数 </span></div>
        </td>
    </tr> 
    <tr>
    	<th>&nbsp;</th>
        <td style="padding-top:0px">
        <input class="submit" type="submit" value="好啦，发表" tabindex="4" > <a href="<?php echo U('article/index');?>">返回</a>
        </td>
    </tr>
</table>

<div id="thumblst" class="item item-thumb-list">
    <?php if(is_array($arrPhotos)): foreach($arrPhotos as $key=>$item): ?><div class="thumblst">
      <div class="details">
        <p>图片描述（30字以内）</p>
        <textarea name="photodesc[]" maxlength="30"><?php echo ($item[title]); ?></textarea>
        <input type="hidden" name="seqid[]" value="<?php echo ($item[seqid]); ?>" >
        <br>
        <br>
        图片位置<br>
        <a onclick="javascript:removePhoto(this, '<?php echo ($item[seqid]); ?>');return false;" class="minisubmit rr j a_remove_pic" name="rm_p_<?php echo ($item[seqid]); ?>" ajaxurl="<?php echo U('images/delete');?>" imgid="<?php echo ($item[id]); ?>">删除</a>
        <label>
         <?php if($item[align] == 'L'): ?><input type="radio" name="layout_<?php echo ($item[seqid]); ?>"  checked  value="L" >
         <?php else: ?>
         <input type="radio" name="layout_<?php echo ($item[seqid]); ?>"   value="L" ><?php endif; ?>
          <span class="alignleft">居左</span></label>
        <label>
          <?php if($item[align] == 'C'): ?><input type="radio" name="layout_<?php echo ($item[seqid]); ?>" checked value="C" >
          <?php else: ?>
          <input type="radio" name="layout_<?php echo ($item[seqid]); ?>" value="C" ><?php endif; ?>
          <span class="aligncenter">居中</span></label>
        <label>
          <?php if($item[align] == 'R'): ?><input type="radio" name="layout_<?php echo ($item[seqid]); ?>" checked value="R" >
          <?php else: ?>
          <input type="radio" name="layout_<?php echo ($item[seqid]); ?>" value="R" ><?php endif; ?>
          <span class="alignright">居右</span></label>
      </div>
      <div class="thumb">
        <div class="pl">[图片<?php echo ($item[seqid]); ?>]</div>
        <img src="<?php echo ($item[simg]); ?>">
      </div>
      	<div class="clear"></div>
    </div><?php endforeach; endif; ?>

</div>
<div id="videosbar"  class="item item-thumb-list">
   <?php if(is_array($arrVideos)): foreach($arrVideos as $key=>$item): ?><div class="thumblst">
    <div class="details">
    <p>视频标题（30字以内）</p>
    <textarea name="video_<?php echo ($item[seqid]); ?>_title" maxlength="30">人在囧途</textarea>
    <input type="hidden" value="<?php echo ($item[seqid]); ?>" name="video_<?php echo ($item[seqid]); ?>">
    <br>
    <br>
    视频网址：<br>
    <a onclick="javascript:removeVideo(this, '<?php echo ($item[seqid]); ?>');return false;" class="minisubmit rr j a_remove_pic" name="rm_p_1" ajaxurl="<?php echo U('images/delete');?>">删除</a>
    <p><?php echo ($item[url]); ?></p>
    </div>
    <div class="thumb">
    <div class="pl">[视频<?php echo ($item[seqid]); ?>]</div>
    <img src="<?php echo ($item[imgurl]); ?>"> </div>
    <div class="clear"></div>
    </div><?php endforeach; endif; ?>
</div>
<!--加载编辑器-->
<script type="text/javascript" src="__STATIC__/public/js/lib/ajaxfileupload.js"></script>
<script type="text/javascript" src="__STATIC__/public/js/lib/IKEditor.js"></script>

<script language="javascript">
$(function(){
	$('#addImg').bind('click',function(){
		var ajaxurl = "<?php echo U('images/add');?>";
		var typeid = '<?php echo ($strArticle[aid]); ?>';
		var data = "{'type':'article','typeid':'"+typeid+"'}";		
		addPhoto(ajaxurl, data);
	});
	$('#addLink').bind('click',function(){	
		addLink();
	})
	$('#addVideo').bind('click',function(){
		addVideo();	
	})
});
</script>

</form>

    
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
        <p>Powered by <a class="softname" href="<?php echo (IKPHP_SITEURL); ?>"><?php echo (IKPHP_SITENAME); ?></a> <?php echo (IKPHP_VERSION); ?>  <?php echo C('site_icp');?> <span style="color:green">ThinkPHP 版本 <?php echo (THINK_VERSION); ?></span><br /><span style="font-size:0.83em;"></span>
        
        <!--<script src="http://s21.cnzz.com/stat.php?id=2973516&web_id=2973516" language="JavaScript"></script>-->
        </p>   
    </div>
</div>
</footer>
</body>
</html>