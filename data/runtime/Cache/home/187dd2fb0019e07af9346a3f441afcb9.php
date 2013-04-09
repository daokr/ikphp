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
<link type="text/css" rel="stylesheet" href="__STATIC__/public/js/uploadify/uploadify.css" />
<script src="__STATIC__/public/js/uploadify/jquery.uploadify.v2.1.4.js" type="text/javascript"></script>

<script src="__STATIC__/public/js/uploadify/swfobject.js" type="text/javascript"></script>

<script type="text/javascript">

$(document).ready(function()
{		
	$("#uploadify").uploadify({
		'uploader': siteUrl + 'static/public/js/uploadify/uploadify.swf',
		'expressInstall': siteUrl + 'static/public/js/uploadify/expressInstall.swf',
		'script': "<?php echo U('index/upimg');?>",
		'scriptData':'',
		'method':'POST', 
		'cancelImg': siteUrl+'static/public/js/uploadify/cancel.png',
		'folder': 'UploadFile',
		'queueID': 'fileQueue',
		'auto': false,
		'multi': true,
		'buttonText': '',
		'buttonImg': siteUrl+'static/public/images/upload-btns.png',		
		'fileDesc':'jpg,gif,png图片格式',
		'fileExt':'*.jpg;*.gif;*.png',
		'onAllComplete' : function(event,data) {
			//window.location = jumpurl;
		}

	});

})

</script>

</head>

<body>
        <div>
            <div id="fileQueue"></div>
            <input type="file" id="uploadify" />

            <a href="javascript:$('#uploadify').uploadifyUpload()" class="submit">开始上传</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
            <a href="javascript:$('#uploadify').uploadifyClearQueue()" >取消上传</a>
            </p>
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