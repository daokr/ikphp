<?php

defined('THINK_PATH') or exit();
/**
 * 行为扩展：模板内容输出替换
 */
class content_replaceBehavior extends Behavior {

    public function run(&$content){
        $content = $this->_replace($content);
    }

    private function _replace($content) {
        $replace = array();
        //静态资源地址
        $statics_url = C('ik_statics_url');
        if ($statics_url != '') {
            $replace['__STATIC__'] = $statics_url;
        } else {
            $replace['__STATIC__'] = __ROOT__.'/static';
        }
        //附件地址
        $replace['__UPLOAD__'] = __ROOT__.'/data/upload';
        //网站地址 带 / 如：http://www.12ik.com/
        $replace['__SITE_URL__'] = C('ik_site_url');
        //网站基本风格
        $basecss = 'static/theme/'.C('ik_site_theme').'/base.css';
        //APP风格样式
        $appcss = 'static/theme/'.C('ik_site_theme').'/'.strtolower(MODULE_NAME).'/images/style.css';
        $appextendjs = 'static/theme/'.C('ik_site_theme').'/'.strtolower(MODULE_NAME).'/js/extend.func.js';
        if(is_file($basecss)){
        	$sitecss = '@import url('.C('ik_site_url').$basecss.');';
        }
        if(is_file($appcss)){
        	$sitecss .= '@import url('.C('ik_site_url').$appcss.');';
        }
        //开始替换css
        $replace['__SITE_THEME_CSS__'] = $sitecss;
        //扩展js
        if(is_file($appextendjs)){ 
        	$replace['__EXTENDS_JS__'] = '<script src="'.C('ik_site_url').$appextendjs.'" type="text/javascript"></script>';
        }else{
        	$replace['__EXTENDS_JS__'] = '';
        }
        $content = str_replace(array_keys($replace),array_values($replace),$content);
        return $content;
    }
}