--
-- Table structure for table `boo_errors`
--

CREATE TABLE IF NOT EXISTS `boo_errors` (
  `error_id` int(10) unsigned NOT NULL auto_increment,
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  `domain` varchar(255) NOT NULL,
  `uuid` char(36) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `error` int(10) unsigned NOT NULL,
  `error_string` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `line` int(10) unsigned NOT NULL,
  `symbols` text NOT NULL,
  `globals` text NOT NULL,
  `server` text NOT NULL,
  `get` text NOT NULL,
  `post` text NOT NULL,
  `files` text NOT NULL,
  `cookie` text NOT NULL,
  `request` text NOT NULL,
  `session` text NOT NULL,
  `env` text NOT NULL,
  PRIMARY KEY  (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
