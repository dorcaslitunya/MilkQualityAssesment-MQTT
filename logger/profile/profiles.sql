-- Active: 1673904548832@@127.0.0.1@3306

CREATE TABLE `kiri_entitee`.`profiles_sumary` (
  `entry_id` int(6) NOT NULL AUTO_INCREMENT,
  `create_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_by` varchar(128) DEFAULT NULL,
  `user_name` varchar(128) DEFAULT NULL,
  `user_id` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_phone_nu` int(16) DEFAULT NULL,
  `user_active_state` varchar(64) DEFAULT 'registered',
  `user_active_state_code` int(4) DEFAULT 1,
  `user_access_state` varchar(64) DEFAULT 'guest',
  `user_access_state_code` int(4) DEFAULT 1,
  `user_access_rank` varchar(64) DEFAULT 'guest',
  `user_access_rank_code` int(4) DEFAULT 1,
  `institution_name` varchar(128) DEFAULT NULL,
  `grp_handle` varchar(128) DEFAULT NULL,
  `grp_id` varchar(128) DEFAULT NULL,
  `institution_id` varchar(128) DEFAULT NULL,
  `user_institution_role` varchar(128) DEFAULT NULL,
  `user_institution_role_code` varchar(4) DEFAULT NULL,
  `user_avatar_file` varchar(256) DEFAULT NULL,
  `user_avatar_data` text DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`entry_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `grp_id` (`grp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4