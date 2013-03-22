<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title><?php echo L('page_title');?></title><link rel="stylesheet" type="text/css" href="__TMPL__public/style.css" /><script type="text/javascript" src="__TMPL__public/jquery.js"></script></head><body><!--header--><div class="header"><div class="head"><div class="logo"><a href="index.php"><img src="__TMPL__public/logo.gif" alt="<?php echo L('page_title');?>" /></a></div><div class="menu"><?php echo L('page_title'); echo ($IK_VERSION); ?></div></div></div><style></style><!--main--><div class="midder"><div class="main"><form id="J_install_form" action="<?php echo U('finish_done');?>" method="post"><div class="c_main_title"><?php echo L('step_install_desc');?></div><div id="J_process" class="c_main_body process"></div><div id="J_link" class="act" style="display:none;"><div class="btn"><input type="button" value="<?php echo L('next');?>" class="btn_next" onclick="window.location.href='<?php echo U('finish');?>';" /></div></div><iframe src="about:blank" style="width:500px; height:300px;display:none;" name="post_target"></iframe></form></div></div><script>$(function(){
    $('#J_install_form').attr('target', 'post_target');
    $('#J_install_form').submit();
});
function show_process(html){
    $('#J_process').html($('#J_process').html() + html);
    var _t = $('#J_process').get(0);
    _t.scrollTop = _t.scrollHeight;
}
function install_successed(){
    $('#J_link').show();
}
</script><!--footer--><div class="footer">Powered by <a href="<?php echo (IKPHP_SITEURL); ?>" target="_blank"><?php echo (IKPHP_SITENAME); ?></a>&nbsp;版本 <?php echo (IKPHP_VERSION); ?> &copy; <?php echo (IKPHP_YEAR); ?></div></body></html>