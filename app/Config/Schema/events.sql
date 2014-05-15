-- Create syntax for TABLE 'dreamhack_events'
CREATE TABLE `dreamhack_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `timestamp_start` int(12) NOT NULL,
  `timestamp_end` int(12) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Create syntax for TABLE 'mlg_events'
CREATE TABLE `mlg_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `timestamp_start` int(12) NOT NULL,
  `timestamp_end` int(12) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Create syntax for TABLE 'taketv_events'
CREATE TABLE `taketv_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `timestamp_start` int(12) NOT NULL,
  `timestamp_end` int(12) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Create syntax for TABLE 'wcs_events'
CREATE TABLE `wcs_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `timestamp_start` int(12) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);