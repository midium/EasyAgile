/*Table structure for table `epics` */

DROP TABLE IF EXISTS `epics`;

CREATE TABLE `epics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `color` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `project_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `priorities` */

DROP TABLE IF EXISTS `priorities`;

CREATE TABLE `priorities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `priorities` */

insert  into `priorities`(`id`,`name`) values 
(1,'Blocker'),
(2,'Urgent'),
(3,'High'),
(4,'Medium'),
(5,'Low'),
(6,'Lower'),
(7,'Nice to have');

/*Table structure for table `privileges` */

DROP TABLE IF EXISTS `privileges`;

CREATE TABLE `privileges` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `privileges` */

insert  into `privileges`(`id`,`name`) values 
(1,'Administrator'),
(2,'Project Manager'),
(3,'User');

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `manager_id` bigint(20) NOT NULL,
  `icon` varchar(255) COLLATE utf8_bin NOT NULL,
  `status_id` bigint(20) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `projects_statuses` */

DROP TABLE IF EXISTS `projects_statuses`;

CREATE TABLE `projects_statuses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `projects_statuses` */

insert  into `projects_statuses`(`id`,`name`) values 
(1,'Created'),
(2,'Ongoing'),
(3,'Maintenance'),
(4,'Closed'),
(5,'Died');

/*Table structure for table `projects_teams` */

DROP TABLE IF EXISTS `projects_teams`;

CREATE TABLE `projects_teams` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `team_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `sprints` */

DROP TABLE IF EXISTS `sprints`;

CREATE TABLE `sprints` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `project_id` bigint(20) NOT NULL,
  `sprint_status_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `sprints_statuses` */

DROP TABLE IF EXISTS `sprints_statuses`;

CREATE TABLE `sprints_statuses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `sprints_statuses` */

insert  into `sprints_statuses`(`id`,`name`) values 
(1,'In Progress'),
(2,'Planned'),
(3,'Finished');

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) NOT NULL,
  `owned_by` bigint(20) NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `priority_id` bigint(20) NOT NULL DEFAULT '3',
  `status_id` bigint(20) NOT NULL DEFAULT '1',
  `task_type_id` bigint(20) NOT NULL,
  `epic_id` bigint(20) DEFAULT '-1',
  `sprint_id` bigint(20) DEFAULT '-1',
  `subject` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` mediumtext COLLATE utf8_bin,
  `estimates` int(11) DEFAULT NULL,
  `parent_task_id` bigint(20) DEFAULT NULL,
  `order_number` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `tasks_attachments` */

DROP TABLE IF EXISTS `tasks_attachments`;

CREATE TABLE `tasks_attachments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `stored_filename` varchar(50) COLLATE utf8_bin NOT NULL,
  `filename` varchar(50) COLLATE utf8_bin NOT NULL,
  `size` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `tasks_comments` */

DROP TABLE IF EXISTS `tasks_comments`;

CREATE TABLE `tasks_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `body` text COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `tasks_logs` */

DROP TABLE IF EXISTS `tasks_logs`;

CREATE TABLE `tasks_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `time_logged` int(11) NOT NULL,
  `log_description` text COLLATE utf8_bin NOT NULL,
  `log_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`created_at`,`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `tasks_statuses` */

DROP TABLE IF EXISTS `tasks_statuses`;

CREATE TABLE `tasks_statuses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `tasks_statuses` */

insert  into `tasks_statuses`(`id`,`name`) values 
(1,'Open'),
(2,'In Progress'),
(3,'Resolved'),
(4,'Reopened'),
(5,'Closed'),
(6,'ToDo'),
(7,'Blocked'),
(8,'Invalid'),
(9,'Testing'),
(10,'Done'),
(11,'Fixed');

/*Table structure for table `tasks_types` */

DROP TABLE IF EXISTS `tasks_types`;

CREATE TABLE `tasks_types` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `tasks_types` */

insert  into `tasks_types`(`id`,`name`) values 
(1,'Bug'),
(2,'Task'),
(3,'Epic'),
(4,'Improvement'),
(5,'Story'),
(6,'Sub Task');

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `teams_users` */

DROP TABLE IF EXISTS `teams_users`;

CREATE TABLE `teams_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `privilege_id` bigint(20) NOT NULL DEFAULT '3',
  `role_id` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `use_gravatar` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(20) NOT NULL DEFAULT 'default',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
