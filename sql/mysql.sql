CREATE TABLE `xmfaq_question` (
  `question_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question_cid` int(11) NOT NULL DEFAULT '0',
  `question_title` varchar(255) NOT NULL DEFAULT '',
  `question_answer` text NOT NULL,
  `question_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`question_id`),
  KEY `request_name` (`question_title`)
) ENGINE=MyISAM;

CREATE TABLE `xmfaq_category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL DEFAULT '',
  `category_description` text NOT NULL,
  `category_weight` int(11) NOT NULL DEFAULT '0',
  `category_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `category_title` (`category_title`)
) ENGINE=MyISAM;