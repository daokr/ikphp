-- --------------------------------------------------------

--
-- 表的结构 `ik_home_info`
--
DROP TABLE IF EXISTS `ik_home_info`;
CREATE TABLE `ik_home_info` (
  `infoid` int(11) NOT NULL AUTO_INCREMENT,
  `infokey` char(32) NOT NULL DEFAULT '',
  `infocontent` text NOT NULL,
  PRIMARY KEY (`infoid`),
  UNIQUE KEY `infokey` (`infokey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ik_home_info`
--

INSERT INTO `ik_home_info` (`infoid`, `infokey`, `infocontent`) VALUES
(1, 'about', '<h2>爱客网（IKPHP.COM）</h2>
<p  style="margin:5px 0px">爱客网是开放、多元的泛科技兴趣社区，并提供负责任、有智趣的科技内容。你可以在这里：</p> 
<ul style="margin:5px 0px">
<li style="list-style: disc inside none;">依兴趣关注不同的小站和小组，阅读有意思的科技内容；</li> 
<li style="list-style: disc inside none;">在"爱客问答"里提出困惑你的科技问题，或提供靠谱的答案；</li> 
<li style="list-style: disc inside none;">关注各个门类和领域的爱客达人，加入兴趣小组讨论，分享智趣话题。</li> 
</ul>      
<p  style="margin:5px 0px">爱客网的创始人是小麦，他是一位IT爱好者；热衷于PHP和前端开发，经过不懈的努力和追求；他在不断的完善爱客网；为广大爱好互联网科技者提供点点贡献。</p>
<p  style="margin:5px 0px">爱客网(IKPHH)社区将不断完善社区系统的建设，以简单和高扩展的形式为用户提供各种不同功能的社区应用，爱客网(IKPHH)开源社区将不断满足用户对社区建设和运营等方面的需求。</p>
<p  style="margin:5px 0px">爱客网是一个非盈利性个人网站， 它是在不违背社会主义道德底线的公益网站！它有着和其他社区同仁一样的激情！</p>
<p  style="margin:5px 0px">官方网站：<a href="http://www.ikphp.com/">http://www.ikphp.com</a></p>'),
(2, 'contact', '<p>Email:160780470#qq.com(#换@)</p>\r\n<p>QQ号:160780470</p>\r\n<p>QQ群:141611512 、288584398</p>\r\n<p>Location:北京 朝阳区 </p>'),
(3, 'agreement', '<p>1、爱客网(IKPHP)开源社区免费开源</p>\r\n<p>2、你可以免费使用爱客网(IKPHP)开源社区</p>\r\n<p>3、你可以在爱客网(IKPHP)开源社区基础上进行二次开发和修改</p>\r\n<p>4、你可以拿爱客网(IKPHP)开源社区建设你的商业运营网站</p>\r\n\r\n<p>5、在爱客网(IKPHP)开源社区未进行商业运作之前，爱客网(IKPHP)开源社区(小麦)将拥有对爱客网(IKPHP)开源社区的所有权，任何个人，公司和组织不得以任何形式和目的侵犯爱客网(IKPHP)开源社区的版权和著作权</p>\r\n<p>6、爱客网(IKPHP)开源社区拥有对此协议的修改和不断完善。</p>'),
(4, 'privacy', '<p>爱客网(IKPHP)开源社区（ikphp.com）以此声明对本站用户隐私保护的许诺。爱客网(IKPHP)开源社区的隐私声明正在不断改进中，随着本站服务范围的扩大，会随时更新隐私声明。我们欢迎你随时查看隐私声明。</p>');

-- --------------------------------------------------------

--
-- 表的结构 `ik_admin`
--

DROP TABLE IF EXISTS `ik_admin`;
CREATE TABLE `ik_admin` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role_id` smallint(5) NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `last_time` int(10) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `user_name` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
--
-- 表的结构 `ik_user`
--
DROP TABLE IF EXISTS `ik_user`;
CREATE TABLE `ik_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',  
  `username` char(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '用户email',
  `fuserid` int(11) NOT NULL DEFAULT '0' COMMENT '来自邀请用户',
  `doname` char(32) NOT NULL DEFAULT '',  
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `phone` char(16) NOT NULL DEFAULT '' COMMENT '电话号码',
  `roleid` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `areaid` int(11) NOT NULL DEFAULT '0' COMMENT '区县ID',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '头像路径',
  `face` char(64) NOT NULL DEFAULT '' COMMENT '会员头像',
  `signed` char(64) NOT NULL DEFAULT '' COMMENT '签名',
  `blog` char(32) NOT NULL DEFAULT '' COMMENT '博客',
  `about` char(255) NOT NULL DEFAULT '' COMMENT '关于我',
  `ip` varchar(16) NOT NULL DEFAULT '' COMMENT '登陆IP',
  `address` char(64) NOT NULL DEFAULT '',
  `qq_openid` char(32) NOT NULL DEFAULT '',
  `qq_access_token` char(32) NOT NULL DEFAULT '' COMMENT 'access_token',
  `count_score` int(11) NOT NULL DEFAULT '0' COMMENT '统计积分',
  `count_follow` int(11) NOT NULL DEFAULT '0' COMMENT '统计用户跟随的',
  `count_followed` int(11) NOT NULL DEFAULT '0' COMMENT '统计用户被跟随的',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是管理员',
  `isenable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用：0启用1禁用',
  `isverify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未验证1验证',
  `verifycode` char(11) NOT NULL DEFAULT '' COMMENT '验证码',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) DEFAULT '0' COMMENT '登陆时间',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `qq_openid` (`qq_openid`),
  KEY `fuserid` (`fuserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户';

-- --------------------------------------------------------

--
-- 表的结构 `ik_setting`
--
DROP TABLE IF EXISTS `ik_setting`;
CREATE TABLE `ik_setting` (
  `name` char(32) NOT NULL DEFAULT '' COMMENT '选项名字',
  `data` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统管理配置';

--
-- 转存表中的数据 `ik_system_options`
--

INSERT INTO `ik_setting` (`name`, `data`) VALUES
('site_title', '爱客网(IKPHP)开源社区'),
('site_subtitle', '又一个爱客网(IKPHP)开源社区'),
('site_url', 'http://'),
('site_email', 'admin@admin.com'),
('site_icp', '正在备案中'),
('site_keywords', '12ik'),
('site_desc', '又一个爱客网(IKPHP)开源社区'),
('site_theme', 'blue'),
('isgzip', '0'),
('timezone', '8'),
('isinvite', '0'),
('charset', 'UTF-8'),
('integrate_code', 'default'),
('integrate_config', ''),
('avatar_size', '24,32,48,64,100,200'),
('attr_allow_exts', 'jpg,gif,png,jpeg'),
('attr_allow_size', '2048'),
('attach_path', 'data/upload/'),
('simg', 'a:2:{s:5:"width";s:3:"120";s:6:"height";s:3:"120";}'),
('mimg', 'a:2:{s:5:"width";s:3:"500";s:6:"height";s:3:"500";}'),
('bimg', 'a:2:{s:5:"width";s:4:"1000";s:6:"height";s:4:"1000";}');
-- --------------------------------------------------------

--
-- 表的结构 `ik_nav`
--

DROP TABLE IF EXISTS `ik_nav`;
CREATE TABLE `ik_nav` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alias` varchar(20) NOT NULL,
  `link` varchar(255) NOT NULL,
  `target` tinyint(1) NOT NULL DEFAULT '1',
  `ordid` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `mod` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- 表的结构 `ik_area`
--
DROP TABLE IF EXISTS `ik_area`;
CREATE TABLE `ik_area` (
  `areaid` int(11) NOT NULL AUTO_INCREMENT,
  `areaname` varchar(32) NOT NULL DEFAULT '',
  `zm` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
  `referid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`areaid`),
  KEY `referid` (`referid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='本地化' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `ik_area`
--
INSERT INTO `ik_area` (`areaid`, `areaname`, `zm`, `referid`) VALUES
(1,'广东','G','0'),
(2,'北京','B','0'),
(3,'上海','S','0'),
(4,'江苏','J','0'),
(5,'浙江','Z','0'),
(6,'山东','S','0'),
(7,'四川','S','0'),
(8,'湖北','H','0'),
(9,'福建','F','0'),
(10,'河南','H','0'),
(11,'辽宁','L','0'),
(12,'陕西','S','0'),
(13,'湖南','H','0'),
(14,'河北','H','0'),
(15,'安徽','A','0'),
(16,'黑龙江','H','0'),
(17,'重庆','C','0'),
(18,'天津','T','0'),
(19,'广西','G','0'),
(20,'山西','S','0'),
(21,'江西','J','0'),
(22,'吉林','J','0'),
(23,'云南','Y','0'),
(24,'内蒙古','N','0'),
(25,'贵州','G','0'),
(26,'甘肃','G','0'),
(27,'新疆','X','0'),
(28,'海南','H','0'),
(29,'宁夏','N','0'),
(30,'青海','Q','0'),
(31,'西藏','X','0'),
(32,'香港','X','0'),
(33,'澳门','A','0'),
(34,'台湾','T','0'),
(35,'钓鱼岛','D','0');

-- --------------------------------------------------------

--
-- 表的结构 `ik_group`
--
DROP TABLE IF EXISTS `ik_group`;
CREATE TABLE `ik_group` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT COMMENT '小组ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `groupname` char(32) NOT NULL DEFAULT '' COMMENT '群组名字',
  `groupname_en` char(32) NOT NULL DEFAULT '' COMMENT '小组英文名称',
  `groupdesc` text NOT NULL COMMENT '小组介绍',
  `groupicon` char(255) DEFAULT '' COMMENT '小组图标',
  `count_topic` int(11) NOT NULL DEFAULT '0' COMMENT '帖子统计',
  `count_topic_today` int(11) NOT NULL DEFAULT '0' COMMENT '统计今天发帖',
  `count_user` int(11) NOT NULL DEFAULT '0' COMMENT '小组成员数',
  `joinway` tinyint(1) NOT NULL DEFAULT '0' COMMENT '加入方式',
  `role_leader` char(32) NOT NULL DEFAULT '组长' COMMENT '组长角色名称',
  `role_admin` char(32) NOT NULL DEFAULT '管理员' COMMENT '管理员角色名称',
  `role_user` char(32) NOT NULL DEFAULT '成员' COMMENT '成员角色名称',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `isrecommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否公开或者私密',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `ispost` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许会员发帖',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  PRIMARY KEY (`groupid`),
  KEY `userid` (`userid`),
  KEY `isshow` (`isshow`),
  KEY `groupname` (`groupname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_group_setting`
--
DROP TABLE IF EXISTS `ik_group_setting`;
CREATE TABLE `ik_group_setting` (
  `name` char(32) NOT NULL DEFAULT '' COMMENT '选项名字',
  `data` char(255) NOT NULL DEFAULT '' COMMENT '选项内容',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理配置';
--
-- 转存表中的数据 `ik_system_options`
--

INSERT INTO `ik_group_setting` (`name`, `data`) VALUES
('iscreate', '0'),
('group_isaudit', '0'),
('topic_isaudit', '0'),
('maxgroup', '10'),
('jionmax', '50');
-- --------------------------------------------------------

--
-- 表的结构 `ik_group_users`
--
DROP TABLE IF EXISTS `ik_group_users`;
CREATE TABLE `ik_group_users` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '群组ID',
  `isadmin` int(11) NOT NULL DEFAULT '0' COMMENT '是否管理员',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '加入时间',
  UNIQUE KEY `userid_2` (`userid`,`groupid`),
  KEY `userid` (`userid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='群组和用户对应关系' ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics`
--
DROP TABLE IF EXISTS `ik_group_topics`;
CREATE TABLE `ik_group_topics` (
  `topicid` int(11) NOT NULL AUTO_INCREMENT COMMENT '话题ID',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '帖子分类ID',
  `groupid` int(11) NOT NULL DEFAULT '0' COMMENT '小组ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(64) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复统计',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '帖子展示数',
  `count_collect` int(11) NOT NULL DEFAULT '0' COMMENT '喜欢收藏数',  
  `count_attach` int(11) NOT NULL DEFAULT '0' COMMENT '统计附件',
  `count_recommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人数',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `iscomment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许评论',
  `isphoto` tinyint(1) NOT NULL DEFAULT '0',
  `isattach` tinyint(1) NOT NULL DEFAULT '0',
  `isnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否通知',
  `isdigest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖子',
  `isvideo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有视频',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`topicid`),
  KEY `groupid` (`groupid`),
  KEY `userid` (`userid`),
  KEY `title` (`title`),
  KEY `groupid_2` (`groupid`,`isshow`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组话题' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics_collects`
--
DROP TABLE IF EXISTS `ik_group_topics_collects`;
CREATE TABLE `ik_group_topics_collects` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `topicid` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '收藏时间',
  UNIQUE KEY `userid_2` (`userid`,`topicid`),
  KEY `userid` (`userid`),
  KEY `topicid` (`topicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='帖子收藏';

-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics_comments`
--
DROP TABLE IF EXISTS `ik_group_topics_comments`;
CREATE TABLE `ik_group_topics_comments` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `topicid` int(11) NOT NULL DEFAULT '0' COMMENT '话题ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` text NOT NULL COMMENT '回复内容',
  `addtime` int(11) DEFAULT '0' COMMENT '回复时间',
  PRIMARY KEY (`commentid`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`topicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题回复/评论' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_group_topics_recommend`
--
DROP TABLE IF EXISTS `ik_group_topics_recommend`;
CREATE TABLE `ik_group_topics_recommend` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `topicid` int(11) NOT NULL DEFAULT '0',
  `content` char(250) NOT NULL DEFAULT '',  
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '推荐时间',
  UNIQUE KEY `userid_2` (`userid`,`topicid`),
  KEY `userid` (`userid`),
  KEY `topicid` (`topicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='帖子推荐';
-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- 表的结构 `ik_images`
--
DROP TABLE IF EXISTS `ik_images`;
CREATE TABLE `ik_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `seqid` int(11) NOT NULL DEFAULT '0' COMMENT 'seqid',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '日记ID或帖子id',
  `type` char(64) NOT NULL DEFAULT '0' COMMENT '日记或帖子或其他组件',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` char(64) NOT NULL DEFAULT '' COMMENT '文件名',
  `path` char(32) NOT NULL DEFAULT '' COMMENT '源文件路径',
  `size` char(32) NOT NULL DEFAULT '',
  `title` char(120) NOT NULL DEFAULT '' COMMENT '图片描述',
  `align` char(32) NOT NULL DEFAULT 'C' COMMENT '图片对齐方式',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_videos`
--
DROP TABLE IF EXISTS `ik_videos`;
CREATE TABLE `ik_videos` (
  `videoid` int(11) NOT NULL AUTO_INCREMENT COMMENT '视频id',
  `seqid` int(11) NOT NULL DEFAULT '0' COMMENT '顺序id',
  `typeid` int(11) NOT NULL DEFAULT '0' COMMENT '日记ID或帖子id',
  `type` char(64) NOT NULL DEFAULT '0' COMMENT '日记或帖子或其他组件',
  `userid` int(11) NOT NULL DEFAULT '0',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '视频网址',
  `imgurl` char(255) NOT NULL DEFAULT '' COMMENT '视频截图',
  `videourl` char(255) NOT NULL DEFAULT '' COMMENT 'swf地址',
  `title` char(120) NOT NULL DEFAULT '' COMMENT '视频标题',
  `count_view` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`videoid`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `ik_user_follow`
--
DROP TABLE IF EXISTS `ik_user_follow`;
CREATE TABLE `ik_user_follow` (
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `userid_follow` int(11) NOT NULL DEFAULT '0' COMMENT '被关注的用户ID',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  UNIQUE KEY `userid_2` (`userid`,`userid_follow`),
  KEY `userid` (`userid`),
  KEY `userid_follow` (`userid_follow`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户关注跟随';
-- --------------------------------------------------------

--
-- 表的结构 `ik_tag`
--
DROP TABLE IF EXISTS `ik_tag`;
CREATE TABLE `ik_tag` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` char(16) NOT NULL DEFAULT '',
  `count_user` int(11) NOT NULL DEFAULT '0',
  `count_group` int(11) NOT NULL DEFAULT '0',
  `count_topic` int(11) NOT NULL DEFAULT '0',
  `count_bang` int(11) NOT NULL DEFAULT '0',
  `count_article` int(11) NOT NULL DEFAULT '0',
  `count_note` int(11) NOT NULL DEFAULT '0',
  `count_site` int(11) NOT NULL DEFAULT '0',
  `isenable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`tagid`),
  UNIQUE KEY `tagname` (`tagname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_group_index`
--
DROP TABLE IF EXISTS `ik_tag_group_index`;
CREATE TABLE `ik_tag_group_index` (
  `groupid` int(11) NOT NULL DEFAULT '0',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `groupid_2` (`groupid`,`tagid`),
  KEY `groupid` (`groupid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ik_tag_group_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `ik_tag_topic_index`
--
DROP TABLE IF EXISTS `ik_tag_topic_index`;
CREATE TABLE `ik_tag_topic_index` (
  `topicid` int(11) NOT NULL DEFAULT '0' COMMENT '帖子ID',
  `tagid` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `topicid_2` (`topicid`,`tagid`),
  KEY `topicid` (`topicid`),
  KEY `tagid` (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- 第三方登陆 `ik_oauth`
--
DROP TABLE IF EXISTS `ik_oauth`;
CREATE TABLE `ik_oauth` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `config` text NOT NULL,
  `desc` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `ordid` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `ik_oauth` (`id`, `code`, `name`, `config`, `desc`, `author`, `ordid`, `status`) VALUES
(1, 'qq', 'QQ登录', 'a:2:{s:7:"app_key";s:9:"100401235";s:10:"app_secret";s:32:"567e145f267ccde6694acb2c2582cf42";}', '申请地址：http://connect.opensns.qq.com/', 'IKPHP TEAM', 1, 1),
(2, 'sina', '微博登陆', 'a:2:{s:7:"app_key";s:10:"1001094537";s:10:"app_secret";s:32:"4228d0fe4e7000c37aad1727c1cca385";}', '申请地址：http://open.weibo.com/', 'IKPHP TEAM', 2, 1);


-- --------------------------------------------------------

--
-- 表的结构 `ik_user_bind`
--

DROP TABLE IF EXISTS `ik_user_bind`;
CREATE TABLE `ik_user_bind` (
  `uid` int(10) unsigned NOT NULL,
  `type` varchar(60) NOT NULL,
  `keyid` varchar(100) NOT NULL,
  `info` text NOT NULL,
  KEY `uid` (`uid`),
  KEY `uid_type` (`uid`,`type`),
  KEY `type_keyid` (`type`,`keyid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ik_article`
--
DROP TABLE IF EXISTS `ik_article`;
CREATE TABLE `ik_article` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `itemid` int(11) NOT NULL DEFAULT '0' COMMENT '信息ID',
  `content` text NOT NULL COMMENT '内容',
  `postip` varchar(15) NOT NULL DEFAULT '' COMMENT '发布者ip',
  `newsauthor` varchar(20) NOT NULL DEFAULT '' COMMENT '作者',
  `newsfrom` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `newsfromurl` varchar(150) NOT NULL DEFAULT '' COMMENT '来源连接',
  PRIMARY KEY (`aid`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `ik_article_item`
--
DROP TABLE IF EXISTS `ik_article_item`;
CREATE TABLE `ik_article_item` (
  `itemid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `cateid` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '标题',
  `count_comment` int(11) NOT NULL DEFAULT '0' COMMENT '回复统计',
  `count_view` int(11) NOT NULL DEFAULT '0' COMMENT '展示数',
  `photoid` int(11) NOT NULL DEFAULT '0' COMMENT '文章主图id',
  `isphoto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有图片',
  `isvideo` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有视频',  
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `iscomment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许评论',
  `isdigest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖子',
  `isaudit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核', 
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `uptime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`itemid`),
  KEY `userid` (`userid`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `ik_article_cate`
--
DROP TABLE IF EXISTS `ik_article_cate`;
CREATE TABLE `ik_article_cate` (
  `cateid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `catename` char(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `nameid` char(30) NOT NULL DEFAULT '' COMMENT '频道id',  
  `orderid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cateid`),
  KEY `nameid` (`nameid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_article_channel`
--
DROP TABLE IF EXISTS `ik_article_channel`;
CREATE TABLE `ik_article_channel` (
  `nameid` char(30) NOT NULL DEFAULT '' COMMENT '频道英文名称',
  `name` char(50) NOT NULL DEFAULT '' COMMENT '频道名',
  `isnav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启导航',  
  PRIMARY KEY (`nameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章频道';

-- --------------------------------------------------------
--
-- 表的结构 `ik_article_comment`
--
DROP TABLE IF EXISTS `ik_article_comment`;
CREATE TABLE `ik_article_comment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `referid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `content` text NOT NULL COMMENT '评论内容',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`commentid`),
  KEY `aid` (`aid`),
  KEY `userid` (`userid`),
  KEY `referid` (`referid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章评论' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 'ik_robots'
--
DROP TABLE IF EXISTS `ik_robots`;
CREATE TABLE `ik_robots` (
  `robotid` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '机器人名称',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加者id',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加机器人的时间',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次采集时间',
  `importcatid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '插入的分类ID',
  `robotnum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `listurltype` varchar(10) NOT NULL DEFAULT '' COMMENT '索引列表方式',
  `listurl` text NOT NULL COMMENT '索引列表链接',
  `listpagestart` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '索引列表开始页码',
  `listpageend` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '索引列表结束页码',
  `reverseorder` tinyint(1) NOT NULL DEFAULT '1' COMMENT '索引列表结束页码',
  `allnum` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '总的采集数目',
  `pernum` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '每次采集信息数目',
  `savepic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否保存信息内的图片',
  `encode` varchar(20) NOT NULL DEFAULT '' COMMENT '采集页面的字符集编码',
  `picurllinkpre` text NOT NULL,
  `saveflash` tinyint(1) NOT NULL DEFAULT '0',
  `subjecturlrule` text NOT NULL,
  `subjecturllinkrule` text NOT NULL,
  `subjecturllinkpre` text NOT NULL,
  `subjectrule` text NOT NULL,
  `subjectfilter` text NOT NULL,
  `subjectreplace` text NOT NULL,
  `subjectreplaceto` text NOT NULL,
  `subjectkey` text NOT NULL,
  `subjectallowrepeat` tinyint(1) NOT NULL DEFAULT '0',
  `datelinerule` text NOT NULL,
  `fromrule` text NOT NULL,
  `authorrule` text NOT NULL,
  `messagerule` text NOT NULL,
  `messagefilter` text NOT NULL,
  `messagepagetype` varchar(10) NOT NULL DEFAULT '',
  `messagepagerule` text NOT NULL,
  `messagepageurlrule` text NOT NULL,
  `messagepageurllinkpre` text NOT NULL,
  `messagereplace` text NOT NULL,
  `messagereplaceto` text NOT NULL,
  `autotype` tinyint(1) NOT NULL DEFAULT '0',
  `wildcardlen` tinyint(1) NOT NULL DEFAULT '0',
  `subjecturllinkcancel` text NOT NULL,
  `subjecturllinkfilter` text NOT NULL,
  `subjecturllinkpf` text NOT NULL,
  `subjectkeycancel` text NOT NULL,
  `messagekey` text NOT NULL,
  `messagekeycancel` text NOT NULL,
  `messageformat` tinyint(1) NOT NULL DEFAULT '0',
  `messagepageurllinkpf` text NOT NULL,
  `uidrule` text NOT NULL COMMENT '发布者UID',
  `defaultaddtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '默认发布时间',
  PRIMARY KEY  (robotid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='采集器' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ik_message`
--
DROP TABLE IF EXISTS `ik_message`;
CREATE TABLE `ik_message` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `userid` int(11) NOT NULL DEFAULT '0' COMMENT '发送用户ID',
  `touserid` int(11) NOT NULL DEFAULT '0' COMMENT '接收消息的用户ID',
  `title` char(64) NOT NULL DEFAULT '' COMMENT '标题',  
  `content` text NOT NULL COMMENT '内容',
  `isread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  `isspam` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否垃圾邮件',  
  `isinbox` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在收件箱显示',  
  `isoutbox` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在发件箱显示',  
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`messageid`),
  KEY `touserid` (`touserid`,`isread`),
  KEY `userid` (`userid`,`touserid`,`isread`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短消息表' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- 表的结构 `ik_words`
--
DROP TABLE IF EXISTS `ik_words`;
CREATE TABLE `ik_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin` varchar(50) NOT NULL,
  `find` varchar(255) NOT NULL DEFAULT '' COMMENT '违禁词语',  
  `replacement` varchar(255) NOT NULL DEFAULT '' COMMENT '替换词',  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='词组过滤' AUTO_INCREMENT=1 ;


