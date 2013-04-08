<?php 
return array (
  'URL_MODEL' => 1,
  'URL_CASE_INSENSITIVE' => false,
  'URL_ROUTER_ON' => true,
  'URL_ROUTE_RULES' => 
  array (
    '/^people\/(\w+)$/' => 'people/index?id=:1',//个人主页
    '/^group\/topic\/(\d+)$/' => 'group/topic?id=:1',//帖子
  	'/^group\/topic\/(\d+)\/p\/(\d+)$/' => 'group/topic?id=:1&p=:2',//帖子
    '/^group\/(\d+)$/' => 'group/show?id=:1',//小组
  	'/^article\/(\d+)$/' => 'article/show?id=:1',//文章
  ),
  //如果开启模式 1 和 2 为了更好的SEO 可以修改URL_ROUTE_RULES 和 URL_IKPHP_RULES 配合使用
  'URL_IKPHP_RULES' => array(
  		'index/id/' =>'',
  		'show/id/' =>'',
  		'topic/id/' =>'topic/',//帖子
  ),
);