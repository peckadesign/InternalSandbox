CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `git_hub_id` int(11) NOT NULL,
  `git_hub_name` varchar(255) NOT NULL,
  `git_hub_token` varchar(255) NOT NULL,
  `administrator` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
