<?php
return array(
    'APP_GROUP_LIST' => 'home,admin', //分组
    'DEFAULT_GROUP' => 'home', //默认分组
    'DEFAULT_MODULE' => 'index', //默认控制器
	//'TAGLIB_PRE_LOAD' => 'ik', //自动加载标签    
	'APP_AUTOLOAD_PATH' => '@.Iklib,@.ORG',//自动加载项目类库


	
    'TMPL_ACTION_SUCCESS' => 'public:success',
    'TMPL_ACTION_ERROR' => 'public:error',
	'LOAD_EXT_CONFIG' => 'url,db', //扩展配置
	'SHOW_PAGE_TRACE' => false,
	
	//'SESSION_PREFIX'=>'ik',
	//'COOKIE_PREFIX'=>'ik_',

	'APP_DEBUG'=>true,
	'DB_FIELD_CACHE'=>false,
	'HTML_CACHE_ON'=>false,

			
);
?>