# Cute-Login-PHP


Table Accounts SQL

CREATE TABLE `nordech_challenge`.`accounts` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `first` varchar(25) DEFAULT NULL,
  `last` varchar(25) DEFAULT NULL,
  `wrong_logins` int(11) DEFAULT '0',
  `user_ip` varchar(45) DEFAULT NULL,
  `user_ip_x_fwd` varchar(45) DEFAULT NULL,
  `confirm_code` varchar(255) DEFAULT NULL,
  `comfirmed` int(11) DEFAULT NULL,
  `user_role` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `birthday` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `under_13` varchar(1) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `zodiac` varchar(45) DEFAULT NULL,
  `relationship_status` varchar(45) DEFAULT NULL,
  `user_description` varchar(255) DEFAULT NULL,
  `user_phone_raw` varchar(45) DEFAULT NULL,
  `user_phone` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `birth_month` varchar(10) DEFAULT NULL,
  `birth_day` varchar(2) DEFAULT NULL,
  `birth_year` varchar(4) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `postal` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
