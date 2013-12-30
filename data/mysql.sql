delimiter $$

CREATE TABLE `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) unsigned NOT NULL,
  `subject` int(11) NOT NULL,
  `message_text` blob NOT NULL,
  `created_date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8$$


delimiter $$

CREATE TABLE `message_receiver` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL,
  `receiver_id` int(10) unsigned NOT NULL,
  `sent_date_time` datetime NOT NULL,
  `received_or_not` decimal(1,0) NOT NULL DEFAULT '0',
  `starred_or_not` decimal(1,0) NOT NULL DEFAULT '0',
  `important_or_not` decimal(1,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `message_receivers_fk1_idx` (`message_id`),
  CONSTRAINT `message_receivers_fk1` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8$$


