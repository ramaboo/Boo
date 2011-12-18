--
-- Table structure for table `boo_groups`
--

CREATE TABLE IF NOT EXISTS `boo_groups` (
  `group_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` tinytext NOT NULL,
  `permissions` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`group_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `boo_groups`
--

INSERT INTO `boo_groups` (`group_id`, `name`, `description`, `permissions`) VALUES
(0, 'empty', 'Empty group.', 7),
(1, 'root', 'Root group.', 7),
(2, 'admin', 'Administrators group.', 7),
(3, 'user', 'Users group.', 7),
(4, 'anonymous', 'Anonymous group.', 7);