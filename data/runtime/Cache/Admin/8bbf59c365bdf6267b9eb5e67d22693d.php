<?php if (!defined('THINK_PATH')) exit(); if($ik == 'index'): ?><li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">系统首页</a>
    <ul class="submenu" style="display: block;">
        <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('index/main');?>" target="MainIframe">首页</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('cache/index');?>" target="MainIframe">缓存管理</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('words/lists');?>" target="MainIframe">违禁词过滤</a></li>
    </ul>   
</li>
<li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">前台管理</a>
    <ul class="submenu" style="display: block;">
        <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('home/page');?>" target="MainIframe">单页管理</a></li>
    </ul> 
</li><?php endif; ?>
<?php if($ik == 'setting'): ?><li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">全局配置</a>
    <ul class="submenu" style="display: block;">
<li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('setting/index');?>" target="MainIframe">站点设置</a></li>
<li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('setting/url');?>" target="MainIframe">链接形式</a></li>
     </ul>
</li> 
<li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">前台界面</a>
    <ul class="submenu" style="display: block;">
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('nav/index');?>" target="MainIframe">导航设置</a></li>
        <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('setting/theme');?>" target="MainIframe">前台风格</a></li>        
     </ul>
</li><?php endif; ?>
<?php if($ik == 'user'): ?><li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">用户管理</a>
    <ul class="submenu" style="display: block;">
    <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('user/index');?>" target="MainIframe">会员列表</a></li>
    </ul>
</li><?php endif; ?>

<?php if($ik == 'article'): ?><li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">文章管理</a>
    <ul class="submenu" style="display: block;">
    <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('article/index');?>" target="MainIframe">文章管理</a></li>
    <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('article/channel');?>" target="MainIframe">文章频道</a></li>
    <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('article/cate');?>" target="MainIframe">文章分类</a></li>
    </ul>
</li> 
<li class="treemenu_on">
<a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">采集管理</a>
<ul class="submenu" style="display: block;">
<li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('robots/add');?>" target="MainIframe">添加新机器人</a></li>
<li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('robots/lists');?>" target="MainIframe">采集器</a></li>
</ul>
</li><?php endif; ?>

<?php if($ik == 'group'): ?><li class="treemenu_on">
    <a style="outline:none;" hidefocus="true" href="javascript:void(0)" class="actuator">小组管理</a>
    <ul class="submenu" style="display: block;">
    <li><a style="outline:none;" hidefocus="true" class="submenuB" href="<?php echo U('group/groups');?>" target="MainIframe">全部小组</a></li>
    <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('group/topics');?>" target="MainIframe">帖子管理</a></li>
    <li><a style="outline:none;" hidefocus="true" class="submenuA" href="<?php echo U('group/topiccomments');?>" target="MainIframe">帖子评论管理</a></li>
    </ul>
</li><?php endif; ?>