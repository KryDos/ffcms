SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `{$db_prefix}_com_feedback`;
CREATE TABLE `{$db_prefix}_com_feedback` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `from_name` varchar(128) NOT NULL,
  `from_email` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `time` int(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_com_feedback` (`id`, `from_name`, `from_email`, `title`, `text`, `time`) VALUES
(1,	'Mihail',	'ffcms@yandex.ru',	'Test message on feedback',	'This message is just a test generated by ffcms system.\r\nThanks for installing our system.',	1374667785);

DROP TABLE IF EXISTS `{$db_prefix}_com_news_category`;
CREATE TABLE `{$db_prefix}_com_news_category` (
  `category_id` int(24) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `path` varchar(320) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `link` (`path`),
  KEY `id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_com_news_category` (`category_id`, `name`, `path`) VALUES
(1,	'a:2:{s:2:\"en\";s:4:\"Main\";s:2:\"ru\";s:14:\"Главная\";}',	'');

DROP TABLE IF EXISTS `{$db_prefix}_com_news_entery`;
CREATE TABLE `{$db_prefix}_com_news_entery` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `title` varchar(512) NOT NULL,
  `text` text NOT NULL,
  `link` varchar(256) NOT NULL,
  `category` int(24) NOT NULL,
  `date` int(16) NOT NULL,
  `author` int(24) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `views` int(36) NOT NULL DEFAULT '0',
  `display` int(2) NOT NULL DEFAULT '1',
  `important` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  FULLTEXT KEY `title` (`title`,`text`),
  FULLTEXT KEY `title_2` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_com_news_entery` (`id`, `title`, `text`, `link`, `category`, `date`, `author`, `description`, `keywords`, `views`, `display`, `important`) VALUES
(1,	'a:2:{s:2:\"en\";s:41:\"Fast Flexibility content managment system\";s:2:\"ru\";s:56:\"FFCMS - система управления сайтом\";}',	'a:2:{s:2:\"en\";s:1838:\"<p style=\"text-align: center;\"><img alt=\"ffcms logo\" src=\"/resource/cmscontent/ffcms-box.png\" style=\"border: 0px rgb(0, 0, 0); width: 279px; height: 300px; cursor: default;\" title=\"ffcms box logo\" /></p>\r\n\r\n<p>FFCMS - fast flexibility content managment system. FFcms is a free content management writed on PHP5 using database mysql 5.&nbsp;</p>\r\n\r\n<hr />\r\n<p>FFCMS contains 3 type of extensions:</p>\r\n\r\n<ul>\r\n	<li>Components</li>\r\n	<li>Modules</li>\r\n	<li>Hooks</li>\r\n</ul>\r\n\r\n<div>\r\n<div><b>1. Components</b>&nbsp;- provide an implementation of the main content of the page (or multiple pages) at a specific url . FFCMS include 6 default components - News, Static pages, Usercontrol, Sitemap generator, Search engine, Feedback that implement the basic functionality of the site required for personal blogs, portals and corporate pages.\r\n\r\n<p><b>2. Modules</b>&nbsp;- provide an implementation of a particular position on the entire website or parts of it. In default package&nbsp;ffcms included modules:&nbsp;&nbsp;user comments, statick blocks, news and static pages on main page website and other modules.&nbsp;</p>\r\n\r\n<p><b>3. Hooks</b>&nbsp;- provide an implementation of some of the patterns of interaction with the site core modules and components.As example of hooks is realisation of captcha,&nbsp;methods of calculating comments count for objects, parsing&nbsp;bbcode, extending user profiles and other.&nbsp;</p>\r\n\r\n<p>FFCMS - its a free system realised under GNU GPL v3 license. System can be used on all projects if copyrights of author be saved.&nbsp;</p>\r\n\r\n<p>Official website:&nbsp;<a href=\"http://ffcms.ru/\" target=\"_blank\" title=\"ffcms website\">www.ffcms.ru</a></p>\r\n\r\n<p>Project on github:&nbsp;<a href=\"https://github.com/zenn1989/ffcms\" target=\"_blank\" title=\"git repository\">zenn1989/ffcms/</a></p>\r\n</div>\r\n</div>\r\n\";s:2:\"ru\";s:3231:\"<p style=\"text-align: center;\"><img alt=\"ffcms logo\" src=\"/resource/cmscontent/ffcms-box.png\" style=\"border: 0px rgb(0, 0, 0); width: 279px; height: 300px; cursor: default;\" title=\"ffcms box logo\" /></p>\r\n\r\n<p>FFCMS - быстрая и расширяемая система управления содержимым сайта. Наша система написана с использованием php5 и баз данных mysql.&nbsp;</p>\r\n\r\n<hr />\r\n<p>FFCMS содержит 3 типа расширений:</p>\r\n\r\n<ul>\r\n	<li>Компоненты</li>\r\n	<li>Модули</li>\r\n	<li>Хуки</li>\r\n</ul>\r\n\r\n<div><b>1. Компоненты</b> - предоставляют реализацию основного содержимого страницы(или же нескольких страниц) при определенном url. В систему ffcms по стандарту включено 6 основных модулей: Новости, Статические страницы, Идентификация пользователя, Поиск по сайту, Карта сайта, Обратная связь которые реализуют основной необходимый функционал сайта для личных блогов, порталов и корпоративных страничек.\r\n\r\n<p><b>2. Модули</b> - предоставляют реализацию определенной позиции на всем сайте или его частях. В стандартной комплектации ffcms включены такие модули как Комментарии пользователей, Статические блоки, Вывод новостей и статических страниц на главную а так же другие.&nbsp;</p>\r\n\r\n<p><b>3. Хуки</b> - предоставляют реализацию некоторых моделей взаимодействия ядра сайта с модулями и компонентами. Наглядным примером хука(включения) является реализация капчи, методов подсчета количества комментариев к тому или иному объекту, преобразование bbcode, дополнение профиля пользователя&nbsp;и прочие.&nbsp;</p>\r\n\r\n<p>Система FFCMS является абсолютно бесплатной и распространяется по лицензии GNU GPL V3, содержимое которой вы можете найти в корне вашего сайта. Система может использоваться на любых сайтах(коммерческой и не коммерческой деятельности) с учетом сохранения авторских прав создателя системы.&nbsp;</p>\r\n\r\n<p>Официальный сайт системы: <a href=\"http://ffcms.ru\" target=\"_blank\" title=\"ffcms website\">www.ffcms.ru</a></p>\r\n\r\n<p>Проект на github: <a href=\"https://github.com/zenn1989/ffcms\" target=\"_blank\" title=\"git repository\">zenn1989/ffcms/</a></p>\r\n</div>\r\n\";}',	'demo-ffcms.html',	1,	1373210580,	1,	'a:2:{s:2:\"en\";s:38:\"FFCMS - free content management system\";s:2:\"ru\";s:75:\"FFCMS - система управления содержимым сайта\";}',	'a:2:{s:2:\"en\";s:35:\"ffcms, free, cms, fast, flexibility\";s:2:\"ru\";s:34:\"ffcms, cms, fast, flexibility, php\";}',	438,	1,	0);

DROP TABLE IF EXISTS `{$db_prefix}_com_static`;
CREATE TABLE `{$db_prefix}_com_static` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `owner` int(32) NOT NULL,
  `pathway` varchar(256) NOT NULL,
  `date` int(16) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `pathway_2` (`pathway`),
  KEY `pathway` (`pathway`),
  KEY `pathway_3` (`pathway`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_com_static` (`id`, `title`, `text`, `owner`, `pathway`, `date`, `description`, `keywords`) VALUES
(1,	'a:2:{s:2:\"en\";s:13:\"About example\";s:2:\"ru\";s:13:\"О сайте\";}',	'a:2:{s:2:\"en\";s:142:\"<p>This page provide <strong>example</strong> of about page.</p>\r\n\r\n<p>You can modife it in admin panel-&gt;components-&gt;static pages.</p>\r\n\";s:2:\"ru\";s:364:\"<p>Данная страница является <strong>демонстрационной</strong> и демонстрирует работу системы ffcms.</p>\r\n\r\n<p>Вы можете изменить данную страницу в административной панели-&gt;компоненты-&gt;Статические страницы.</p>\r\n\";}',	1,	'about.html',	1373227200,	'a:2:{s:2:\"en\";s:0:\"\";s:2:\"ru\";s:0:\"\";}',	'a:2:{s:2:\"en\";s:0:\"\";s:2:\"ru\";s:0:\"\";}');

DROP TABLE IF EXISTS `{$db_prefix}_extensions`;
CREATE TABLE `{$db_prefix}_extensions` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `type` enum('components','modules','hooks') NOT NULL,
  `configs` text NOT NULL,
  `dir` varchar(128) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `path_choice` tinyint(1) NOT NULL,
  `path_allow` varchar(1024) NOT NULL,
  `path_deny` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_extensions` (`id`, `type`, `configs`, `dir`, `enabled`, `path_choice`, `path_allow`, `path_deny`) VALUES
(1,	'components',	'',	'static',	1,	0,	'',	''),
(2,	'components',	'a:12:{s:13:\"login_captcha\";s:1:\"0\";s:16:\"register_captcha\";s:1:\"1\";s:15:\"register_aprove\";s:1:\"0\";s:10:\"use_openid\";s:1:\"1\";s:12:\"profile_view\";s:1:\"1\";s:15:\"wall_post_count\";s:1:\"5\";s:16:\"marks_post_count\";s:1:\"5\";s:17:\"friend_page_count\";s:2:\"10\";s:15:\"wall_post_delay\";s:2:\"30\";s:8:\"pm_count\";s:1:\"5\";s:12:\"balance_view\";s:1:\"0\";s:14:\"userlist_count\";s:2:\"10\";}',	'user',	1,	0,	'',	''),
(3,	'components',	'a:9:{s:15:\"count_news_page\";s:1:\"5\";s:17:\"short_news_length\";s:3:\"200\";s:18:\"enable_views_count\";s:1:\"1\";s:14:\"multi_category\";s:1:\"1\";s:11:\"enable_tags\";s:1:\"1\";s:9:\"poster_dx\";s:3:\"200\";s:9:\"poster_dy\";s:3:\"200\";s:10:\"gallery_dx\";s:3:\"150\";s:10:\"gallery_dy\";s:3:\"150\";}',	'news',	1,	0,	'',	''),
(4,	'components',	'',	'sitemap',	1,	0,	'',	''),
(5,	'components',	'',	'feedback',	1,	0,	'',	''),
(6,	'components',	'',	'search',	1,	0,	'',	''),
(8,	'hooks',	'a:3:{s:12:\"captcha_type\";s:8:\"ccaptcha\";s:17:\"captcha_publickey\";s:40:\"6Lf5V-YSAAAAAHjZXfPuyetxodstkHEkIn621OdE\";s:18:\"captcha_privatekey\";s:40:\"6Lf5V-YSAAAAACmTdU4Fd0uUbLTdMtI4rYGenl-X\";}',	'captcha',	1,	0,	'',	''),
(9,	'hooks',	'',	'profile',	0,	0,	'',	''),
(10,	'hooks',	'',	'bbtohtml',	1,	0,	'',	''),
(11,	'hooks',	'',	'comment',	1,	0,	'',	''),
(12,	'hooks',	'',	'file',	1,	0,	'',	''),
(13,	'hooks',	'',	'mail',	1,	0,	'',	''),
(15,	'modules',	'',	'news_on_main',	1,	1,	'index',	''),
(16,	'modules',	'a:2:{s:7:\"news_id\";s:1:\"1\";s:9:\"show_date\";s:1:\"0\";}',	'static_on_main',	0,	1,	'index',	''),
(17,	'modules',	'a:5:{s:14:\"comments_count\";s:1:\"5\";s:10:\"time_delay\";s:2:\"60\";s:9:\"edit_time\";s:2:\"30\";s:10:\"min_length\";s:2:\"10\";s:10:\"max_length\";s:4:\"2000\";}',	'comments',	1,	1,	'news/*;static/*;extension/*',	''),
(18,	'modules',	'',	'usernotify',	1,	1,	'*',	''),
(19,	'modules',	'a:2:{s:10:\"last_count\";s:1:\"5\";s:11:\"text_length\";s:2:\"70\";}',	'lastcomments',	1,	1,	'*',	''),
(20,	'modules',	'a:3:{s:9:\"tag_count\";s:2:\"20\";s:22:\"template_position_name\";s:4:\"left\";s:23:\"template_position_index\";s:1:\"2\";}',	'tagcloud',	1,	1,	'*',	'');

DROP TABLE IF EXISTS `{$db_prefix}_mod_comments`;
CREATE TABLE `{$db_prefix}_mod_comments` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `comment` varchar(512) NOT NULL,
  `author` int(32) NOT NULL,
  `time` int(16) NOT NULL DEFAULT '0',
  `pathway` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `{$db_prefix}_mod_tags`;
CREATE TABLE `{$db_prefix}_mod_tags` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `object_type` varchar(128) NOT NULL,
  `object_id` int(32) NOT NULL,
  `tag` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`),
  KEY `object_type` (`object_type`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_mod_tags` (`object_type`, `object_id`, `tag`) VALUES
('news',	1,	' php'),
('news',	1,	' flexibility'),
('news',	1,	' fast'),
('news',	1,	' cms'),
('news',	1,	'ffcms'),
('news',	1,	' free');

DROP TABLE IF EXISTS `{$db_prefix}_statistic`;
CREATE TABLE `{$db_prefix}_statistic` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `ip` varchar(24) NOT NULL,
  `cookie` varchar(32) NOT NULL DEFAULT '0',
  `browser` varchar(64) NOT NULL,
  `os` varchar(16) NOT NULL,
  `time` int(32) NOT NULL,
  `referer` varchar(256) NOT NULL DEFAULT '0',
  `path` varchar(128) NOT NULL,
  `reg_id` int(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `{$db_prefix}_user`;
CREATE TABLE `{$db_prefix}_user` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `nick` varchar(36) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `access_level` int(2) NOT NULL DEFAULT '1',
  `token` varchar(32) NOT NULL,
  `token_start` int(16) NOT NULL,
  `aprove` varchar(128) NOT NULL DEFAULT '0',
  `openid` varchar(512) NOT NULL DEFAULT '',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$db_prefix}_user_access_level`;
CREATE TABLE `{$db_prefix}_user_access_level` (
  `group_id` int(12) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(12) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_user_access_level` (`group_id`, `group_name`, `permissions`) VALUES
(1,	'User',	'global/read;global/write;comment/add'),
(2,	'Moderator',	'global/read;global/write;comment/add;comment/edit;comment/delete;'),
(3,	'Admin',	'global/read;global/write;comment/add;comment/edit;comment/delete;global/owner;'),
(5,	'Banned',	''),
(4,	'Only Read',	'global/read;');

DROP TABLE IF EXISTS `{$db_prefix}_user_block`;
CREATE TABLE `{$db_prefix}_user_block` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `user_id` int(24) NOT NULL DEFAULT '0',
  `ip` varchar(24) NOT NULL,
  `express` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `{$db_prefix}_user_bookmarks`;
CREATE TABLE `{$db_prefix}_user_bookmarks` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `target` int(24) NOT NULL,
  `title` varchar(256) NOT NULL,
  `href` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `{$db_prefix}_user_custom`;
CREATE TABLE `{$db_prefix}_user_custom` (
  `id` int(24) NOT NULL,
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sex` tinyint(2) NOT NULL DEFAULT '0',
  `phone` varchar(16) NOT NULL,
  `friend_list` text NOT NULL,
  `friend_request` text NOT NULL,
  `status` varchar(128) NOT NULL,
  `webpage` varchar(128) NOT NULL,
  `lastpmview` int(16) NOT NULL DEFAULT '0',
  `forum_posts` int(32) NOT NULL DEFAULT '0',
  `forum_last_message` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$db_prefix}_user_log`;
CREATE TABLE `{$db_prefix}_user_log` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `owner` int(36) NOT NULL,
  `type` varchar(32) NOT NULL,
  `params` text NOT NULL,
  `message` varchar(256) NOT NULL,
  `time` int(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `{$db_prefix}_user_messages`;
CREATE TABLE `{$db_prefix}_user_messages` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `from` int(32) NOT NULL,
  `to` int(32) NOT NULL,
  `message` varchar(512) NOT NULL,
  `timeupdate` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$db_prefix}_user_messages_answer`;
CREATE TABLE `{$db_prefix}_user_messages_answer` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `topic` int(32) NOT NULL,
  `from` int(32) NOT NULL,
  `message` varchar(512) NOT NULL,
  `time` int(16) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$db_prefix}_user_recovery`;
CREATE TABLE `{$db_prefix}_user_recovery` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `password` varchar(32) NOT NULL,
  `hash` varchar(128) NOT NULL,
  `userid` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$db_prefix}_user_wall`;
CREATE TABLE `{$db_prefix}_user_wall` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `target` int(32) NOT NULL,
  `caster` int(32) NOT NULL,
  `message` varchar(256) NOT NULL,
  `time` int(24) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_user_wall` (`id`, `target`, `caster`, `message`, `time`) VALUES
(1,	1,	1,	'Demo wall post from ffcms',	1375004751);

DROP TABLE IF EXISTS `{$db_prefix}_user_wall_answer`;
CREATE TABLE `{$db_prefix}_user_wall_answer` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `wall_post_id` int(32) NOT NULL,
  `poster` int(32) NOT NULL,
  `message` varchar(256) NOT NULL,
  `time` int(24) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `{$db_prefix}_version`;
CREATE TABLE `{$db_prefix}_version` (
  `version` varchar(24) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `{$db_prefix}_version` (`version`) VALUES
('2.0.0');