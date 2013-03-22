<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="160780470@qq.com" />
<meta name="Copyright" content="<?php echo ($ikphp["ikphp_site_name"]); ?>" />
<title><?php echo ($title); ?> - <?php echo ($site_title); ?></title>
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/style.css" />
<script src="__STATIC__/public/js/jquery.js" type="text/javascript"></script>

</head>
<body>
<div class="midder">
<h2><?php echo ($title); ?></h2>
    <div>
    <form method="POST" action="<?php echo U('setting/edit');?>">
    <table>
        <tr>
            <td width="100">形式1：</td>
            <td>
            <label><input type="radio" <?php if(C('ik_site_urltype') == 1): ?>checked="select"<?php endif; ?>
            name="setting[site_urltype]" value="1" /> index.php?m=article&a=show&id=1
            </label>
            </td>
        </tr>
        <tr>
            <td>形式2：</td>
            <td>
            <label><input type="radio" <?php if(C('ik_site_urltype') == 2): ?>checked="select"<?php endif; ?> 
            name="setting[site_urltype]" value="2" />
            /article/show/id/1 (暂只支持apache环境的rewrite，非apache环境勿动)
            </label>
            </td>
        </tr>           
    </table>
    <div class="page_btn"><input type="submit" value="提 交" class="submit" /></div>
    </form>
    </div>

</div>
</body>
</html>