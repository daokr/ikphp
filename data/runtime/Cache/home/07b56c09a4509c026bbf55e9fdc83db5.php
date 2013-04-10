<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
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
<link rel="stylesheet" href="__STATIC__/public/js/editor/ueditor/themes/default/images/image.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="__STATIC__/public/js/uploadify/uploadify.css" />
<script>
$(function(){
	$('#picTab .tab').bind('click',function(){
		var i = $('#picTab .tab').index(this), items = $('#picHost .item'), h=0;
		h = items.eq(i).height();
		$('#picHost').animate({top: -h*i}, 100);
		$(this).find('a').addClass('selected');
		$(this).siblings().find('a').removeClass('selected');

	})
})
</script>
</head>
<body>
<div class="wrapper">
  <div class="container">
    <div id="picTab" class="tab-c"> 
        <span class="tab"><a class="selected" data_tab="local" onclick="return false;" href="javascript:;">本地图片</a></span> 
        <span class="tab"><a data_tab="album" onclick="return false;" href="javascript:;" class="">我的相册</a></span>
        <span class="tab"><a data_tab="net" onclick="return false;" href="javascript:;" class="">网络图片</a></span> 
    </div>
    <div class="tab-container_wrap">
    	<div id="picHost" class="tab-container" style="top: 0px;">
        	<div class="item" >
                <div id="imgList" class="img-content">
                	<div id="fileQueue"></div>
                </div>
            </div>
        	<div class="item" >
            	<div class="tit">我的相册</div>
                <div id="albumList" class="img-content">
<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>

<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>

<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>

<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>

<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>

<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>
<div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div><div class="content-album">
    <div class="cover">
         <a href="javascript:;" albumid="1222" title="12"><img class="content-album-img" src="http://www.etaoke.com.cn/images/case/case1.jpg"></a>
    </div>
    <div class="info">
         <a href="javascript:;" albumid="" title="12">12</a>
    </div>                     
</div>

                </div>
            </div>
            
            <div class="item" id="picNet" >
            	<div class="img-content">
                    <div class="element"> <span>网址1</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址2</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址3</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址4</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址5</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址6</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址7</span> <span><input type="text" class="txt"></span> </div>
                    <div class="element"> <span>网址8</span> <span><input type="text" class="txt"></span> </div>
                </div>
            </div>
                        
        </div>
    </div>
    <!--flash-->
    <div id="picUpFlash" class="tab-flash-c" style="display:block">
         <input type="file" id="uploadify" />
        <div class="tab-flash-tips">最多64张图片，JPG/JPEG/BMP/PNG，最大15M，GIF最大3M</div>
    </div>
    <!--//-->
  </div>
</div>
<span style="font-size:0.83em; display:none">{__RUNTIME__}</span>
<script src="__STATIC__/public/js/uploadify/jquery.uploadify.v2.1.4.js" type="text/javascript"></script>
<script src="__STATIC__/public/js/uploadify/swfobject.js" type="text/javascript"></script>   
<script src="__STATIC__/public/js/editor/ueditor/dialogs/internal.js" type="text/javascript" ></script>
<script src="__STATIC__/public/js/editor/ueditor/dialogs/image/image.js" type="text/javascript"></script>       
<script type="text/javascript">
$(document).ready(function()
{		
	
	$("#uploadify").uploadify({
		'uploader': siteUrl+'static/public/js/uploadify/uploadify.swf',
		'script': siteUrl+'index.php',
		'scriptData':{'m':'index','a':'up'},
		'method':'POST', 
		'cancelImg': siteUrl+'static/public/js/uploadify/cancel.png',
		'folder': 'UploadFile',
		'queueID': 'fileQueue',
		'auto': true,
		'multi': true,
		'buttonImg':siteUrl+'static/public/images/upload-btns.png',
		'sizeLimit' : 2097152,//文件的极限大小，以字节为单位，0为不限制。1MB:1*1024*1024
		'fileDesc':'jpg,gif,png图片格式',
		'fileExt':'*.jpg;*.gif;*.png',
		'onComplete' : function(event,ID,fileObj,response,data) {
			var obj = $.parseJSON(response);
			$('#uploadify'+ID).find('.percentage').html('<img width="130" height="130" src="'+obj.src+'">');
			$('#picUpFlash').hide();
			//window.location = siteUrl+"index.php?app=photo&ac=album&ts=info&albumid=<?php echo ($albumid); ?>&addtime=<?php echo ($addtime); ?>";
		},
		'onAllComplete' : function(event,data){
			
		}

	});

});
</script>  
</body>
</html>