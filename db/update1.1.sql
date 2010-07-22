-- doc
CREATE TABLE IF NOT EXISTS `zt_doc` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `company` smallint(5) unsigned NOT NULL,
  `lib` varchar(30) NOT NULL,
  `module` varchar(30) NOT NULL,
  `title` varchar(120) NOT NULL,
  `digest` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` smallint(5) unsigned NOT NULL,
  `addedBy` varchar(30) NOT NULL,
  `addedDate` datetime NOT NULL,
  `editedBy` varchar(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- doc lib
CREATE TABLE IF NOT EXISTS `zt_docLib` (
    `id` smallint(5) unsigned NOT NULL auto_increment,
    `company` smallint(5) unsigned NOT NULL,
    `name` varchar(60) NOT NULL,
    PRIMARY KEY  (`id`),
    KEY `site` (`company`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- module
ALTER TABLE `zt_module` CHANGE `product` `root` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `zt_module` CHANGE `view` `type` CHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
update zt_module set `type` = 'story' where `type` = 'product';
