--
-- Table structure for table `boo_users`
--

CREATE TABLE IF NOT EXISTS `boo_users` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(48) NOT NULL,
  `company` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `street` varchar(48) NOT NULL,
  `apartment_number` varchar(16) NOT NULL,
  `city` varchar(32) NOT NULL,
  `state_code` char(2) NOT NULL,
  `zip` varchar(9) NOT NULL,
  `country_code` char(3) NOT NULL,
  `website` varchar(255) NOT NULL,
  `fax_number` bigint(20) unsigned NOT NULL,
  `phone_number` bigint(20) unsigned NOT NULL,
  `sms_number` bigint(20) unsigned NOT NULL,
  `carrier_id` int(10) unsigned NOT NULL,
  `settings` text NOT NULL,
  `last_login` int(10) unsigned NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`user_id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;