CREATE TABLE `tl_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text,
  `timestamp_start` int(12) NOT NULL,
  `timestamp_end` int(12) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `is_validated` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(100) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;