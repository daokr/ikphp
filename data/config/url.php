<?php 
return array (
  'URL_MODEL' => 1,
  'URL_CASE_INSENSITIVE' => false,
  'URL_ROUTER_ON' => true,
  'URL_ROUTE_RULES' => 
  array (
    '/^people\/(\w+)$/' => 'people/index?id=:1',
    '/^group\/topic\/(\d+)$/' => 'group/topic?id=:1',
    '/^group\/(\d+)$/' => 'group/show?id=:1',
  ),
);