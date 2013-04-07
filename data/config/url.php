<?php 
return array (
  'URL_MODEL' => 1,
  'URL_CASE_INSENSITIVE' => false,
  'URL_ROUTER_ON' => true,
  'URL_ROUTE_RULES' => 
  array (
    '/^people$/' => 'people/index',
    '/^people\/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*$/' => 'people/index?id=:1',
  ),
);