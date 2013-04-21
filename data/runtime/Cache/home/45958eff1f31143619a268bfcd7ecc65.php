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
<script>
	var SITEATTACH = "<?php echo C('ik_attach_path');?>";
	var settingUrl = "<?php echo U('event/upload_poster',array('id'=>$eventid));?>";
    IK.add('Jcrop-css', {path: '__STATIC__/public/css/lib/jquery.Jcrop.css', type: 'css'});
    IK.add('Jcrop', {path: '__STATIC__/public/js/lib/jquery.Jcrop.min.js', type: 'js', requires: ['Jcrop-css']});
    IK.add('iframe-post-form-css', {path: '__STATIC__/public/css/lib/iframe-post-form.css', type: 'css'});
    IK.add('iframe-post-form', {path: '__STATIC__/public/js/lib/iframe-post-form.min.js', type: 'js', requires: ['iframe-post-form-css']});
	
	//依赖于	Jcrop iframe-post-form 库
 	IK('Jcrop', 'iframe-post-form', function () {
        $(function(){
            var cropW = '',
                cropX = '',
                cropY = '',
                iconVer = 0,
                selectX = 0,
                selectY = 0,
                selectW = 100,
				selectH = 134,
                oJcropApi = {},
                css_cropbox = '#cropbox',
                css_preview = '#preview',
                css_tips = '#upload-tips',
                css_error_tips = '.error-tips',
                css_holder = '.jcrop-holder',
                css_file_icon = '#file-icon',
                oSubmit = $('#submit-crop'),
                oForm = $('#sp-setting-icon'),
                oFileInput = $('#file-icon'),
                oCancel = $('a[name=pf_cancel]'),
                defaultPos = [ 0, 0, 100, 134 ],
                siteName = $('body').attr('id'),
                currSize = $('.sp-icon').attr('id').split('_').slice(1, 4),
                //settingUrl = postUrl.split('/').slice(0, 3).join('/') + '/',
				//settingUrl = "{U('site','admins',array('ik'=>'info','siteid'=>$strSite[siteid]))}",
                tmpl_upload_tips = '<p id="upload-tips">上传中，请稍候...</p>',
                tmpl_error_tips = '<p class="error-tips">图片类型不对或图片短边尺寸不能小于100像素，请刷新页面重新上传。</p>',
                initJcrop = function () {
                    // init setSelect value
                    if (currSize) {
                        selectX = parseInt(currSize[0]),
                        selectY = parseInt(currSize[1]),
                        selectW = parseInt(currSize[2]);
						selectH = parseInt(currSize[3]);
                    }
                    // init Jcrop
                    setTimeout(function () {
                        oJcropApi = $.Jcrop(css_cropbox, {
                            onChange: showPreview,
                            onSelect: showPreview,
                            aspectRatio: 3/4
                        }),
                        oJcropApi.animateTo([
                            selectX, selectY,
                            selectW, selectH 
                        ]);
                    }, 500);
                };

               if (!currSize[0]) {
                  currSize = [0,0,selectW];
               }

            function showPreview (coords) {
                if (parseInt(coords.w) > 0) {  
                    var rx = 100 / coords.w,
                        ry = 134 / coords.h;

                    cropW = Math.ceil(coords.w),
					cropH = Math.ceil(coords.h),
                    cropX = coords.x,
                    cropY = coords.y;

                    $(css_preview).css({
                        width: Math.round(rx * $(css_cropbox).width()) + 'px',
                        height: Math.round(ry * $(css_cropbox).height()) + 'px',
                        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                        marginTop: '-' + Math.round(ry * coords.y) + 'px'
                    });
                }
            }

            initJcrop(); 

            // ajax upload
            oForm.iframePostForm({
                post: function () {
                    oJcropApi.destroy();
                    oJcropApi = {};
                    $(css_error_tips).remove(); 
                },
                complete: function (icon) { 
					
                   var data, realJson;
                    data = icon.match(/\{[^}]+\}/)[0];
                    oFileInput.attr('disabled', 0);
                    if (!data) { return; }
                    realJson = eval('(' + data + ')');
                    if (realJson.error && !$(css_error_tips).length) {
						
						$(css_tips).remove();
                        oFileInput.parent().after(tmpl_error_tips);
                    }else{
						$(css_tips).remove();
						$(css_cropbox + ', ' + css_preview).attr('src', SITEATTACH+realJson.file+'?v='+ Math.ceil(Math.random()*1000));
						$(css_cropbox).attr('rel',realJson.file);//标示是否是上传图片
						setTimeout(function () {
							oJcropApi = $.Jcrop(css_cropbox, { 
								onChange: showPreview,
								onSelect: showPreview,
								aspectRatio: 3/4
							});
							oJcropApi.animateTo(defaultPos);
						}, 500);
					}

                }
            }).find(css_file_icon).change(function () {
                if (!$(css_tips).length) {
                    oFileInput.after(tmpl_upload_tips);
                }
                //oFileInput.attr('disabled', 1);
                $(this).parents('form').submit();
            });

            // submit crop value
            oSubmit.click(function (e) {
                e.preventDefault();
				var file = $(css_cropbox).attr('rel');
				if(file=='')
				{
					//location.href = settingUrl;
					oFileInput.parent().after(tmpl_error_tips);
					$(css_error_tips).html('请上传一张图片在保存吧！');
				}else{
					$.post(settingUrl,{
						'file': file,
						'imgpos': cropX + '_' + cropY + '_' + cropW + '_' + cropH
						},function(res){
							if(res.r){
								location.href = res.url;
							}else{
								alert('保存图片失败！')
							}
					},'json');			
				}

            });
			/*
            oCancel.click(function (e) {
                e.preventDefault();
                location.href = '/' + siteName + '/admin/';
            });
			*/

        });
    });	
</script>	
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
    	<h1><?php echo ($seo["title"]); ?></h1>
        <div class="cleft">
            <div class="nav-step">
              <span>1. 填写活动信息</span>
              <span class="pl">&gt;</span>
              <span class="pl">2. 上传活动海报</span>
              <span class="pl">&gt;</span>
              <span class="pl">3. 提交活动</span>
            </div>


<form enctype="multipart/form-data" method="post" action="<?php echo U('event/upload_poster',array('id'=>$eventid));?>" id="sp-setting-icon" target="iframe-post-form">
                    <div class="sp-icon" id="icon_0_0_100_134}">
                         <img alt="" src="__STATIC__/public/images/raw_event_dft.jpg" id="cropbox" rel=''/> 
                    </div>
                    <ul class="sp-icon-opt">
                        <li>
                            <h2>从电脑中选择你喜欢的照片:</h2>
                            <p class="pl">你可以上传 JPG, JPEG, GIF, PNG 或 BMP 文件</p>
                            <p>
                                <input type="file" name="picfile" accept= "image/*" id="file-icon">
                            </p>
                        </li>
                        <li class="last">
                            <h2>这是你在爱客创建活动的海报图</h2>
                            <p class="clearfix">
                                <span class="icon-wrapper">
                                   <img src="__STATIC__/public/images/raw_event_dft.jpg" class="sp-icon-s" id="preview" />
                                </span>
                                随意拖拽或缩放大图中的虚线方格，预览的小图即图标。
                            </p>

            <p>
            <input type="submit" value="保存活动海报"  name="icon_submit" class="loc-btn" id="submit-crop">
            <a class="later-poster" href="<?php echo U('event/show',array('id'=>$eventid));?>">取消，以后再说</a>
            </p>
                        </li>
                    </ul>
</form>

  
            
        </div><!--//left-->
    
        <div class="cright">

            <h2>让你的活动更吸引人！</h2>
            <p>用一张适合的图片代表你的活动，即使你没有专业的设计师。</p>
            <p>随意拖拽或调整大图中的虚线区域，预览小图即为裁切后的效果。</p>
            <p>高宽比为3:2的图片会得到最完整的显示。</p>

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