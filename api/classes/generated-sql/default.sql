
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- about
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `about`;

CREATE TABLE `about`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `about` TEXT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `about_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- audit_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `audit_log`;

CREATE TABLE `audit_log`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `parish_id` INTEGER NOT NULL,
    `user_id` INTEGER DEFAULT 0 NOT NULL,
    `message` TEXT NOT NULL,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bible_books
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bible_books`;

CREATE TABLE `bible_books`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `abbr` VARCHAR(10) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bible_chapters
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bible_chapters`;

CREATE TABLE `bible_chapters`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `book_id` INTEGER NOT NULL,
    `chapter` INTEGER NOT NULL,
    PRIMARY KEY (`value`),
    INDEX `book_id` (`book_id`),
    CONSTRAINT `bible_chapters_ibfk_1`
        FOREIGN KEY (`book_id`)
        REFERENCES `bible_books` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bible_verses
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bible_verses`;

CREATE TABLE `bible_verses`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `chapter_id` INTEGER NOT NULL,
    `verse` INTEGER NOT NULL,
    PRIMARY KEY (`value`),
    INDEX `chapter_id` (`chapter_id`),
    CONSTRAINT `bible_verses_ibfk_1`
        FOREIGN KEY (`chapter_id`)
        REFERENCES `bible_chapters` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- church
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `church`;

CREATE TABLE `church`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200),
    `short_name` VARCHAR(20),
    `logo` VARCHAR(250),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- devotions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `devotions`;

CREATE TABLE `devotions`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `devotion_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `topic` VARCHAR(250),
    `verse` VARCHAR(250),
    `content` TEXT NOT NULL,
    `has_media` TINYINT(1) NOT NULL,
    `type` INTEGER NOT NULL,
    `url` VARCHAR(200),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    INDEX `devotions_ibfk_2` (`type`),
    CONSTRAINT `devotions_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `devotions_ibfk_2`
        FOREIGN KEY (`type`)
        REFERENCES `media_type` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- econnect
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `econnect`;

CREATE TABLE `econnect`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `gender_category` VARCHAR(100),
    `age_category` VARCHAR(100),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `econnect_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- events
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `name` VARCHAR(200),
    `venue` TEXT,
    `start_date` DATETIME,
    `start_time` VARCHAR(50),
    `end_date` DATETIME,
    `end_time` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `events_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- facebook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `facebook`;

CREATE TABLE `facebook`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `page_id` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `facebook_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give`;

CREATE TABLE `give`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `profile_id` INTEGER NOT NULL,
    `parish_id` INTEGER NOT NULL,
    `method_id` INTEGER NOT NULL,
    `currency` VARCHAR(20) NOT NULL,
    `total` DECIMAL(10,2) NOT NULL,
    `txn_ref` VARCHAR(200),
    `txn_status` VARCHAR(200),
    `description` VARCHAR(250) NOT NULL,
    `card_id` VARCHAR(20),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `give_ibfk_1` (`parish_id`),
    INDEX `give_ibfk_2` (`profile_id`),
    INDEX `give_ibfk_3` (`method_id`),
    CONSTRAINT `give_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `give_ibfk_2`
        FOREIGN KEY (`profile_id`)
        REFERENCES `user_profile` (`value`),
    CONSTRAINT `give_ibfk_3`
        FOREIGN KEY (`method_id`)
        REFERENCES `give_parish_methods` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give_currency
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give_currency`;

CREATE TABLE `give_currency`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(20) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give_methods
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give_methods`;

CREATE TABLE `give_methods`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give_parish_currency
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give_parish_currency`;

CREATE TABLE `give_parish_currency`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `currency_id` INTEGER NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `give_parish_currency_ibfk_1` (`parish_id`),
    INDEX `give_parish_currency_ibfk_2` (`currency_id`),
    CONSTRAINT `give_parish_currency_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `give_parish_currency_ibfk_2`
        FOREIGN KEY (`currency_id`)
        REFERENCES `give_currency` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give_parish_methods
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give_parish_methods`;

CREATE TABLE `give_parish_methods`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `method_id` INTEGER NOT NULL,
    `settings` VARCHAR(250) NOT NULL,
    `enabled` TINYINT DEFAULT 1 NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `give_parish_methods_ibfk_1` (`parish_id`),
    INDEX `give_parish_methods_ibfk_3` (`method_id`),
    CONSTRAINT `give_parish_methods_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `give_parish_methods_ibfk_3`
        FOREIGN KEY (`method_id`)
        REFERENCES `give_methods` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give_split
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give_split`;

CREATE TABLE `give_split`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `give_id` INTEGER NOT NULL,
    `item` VARCHAR(200) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `give_split_ibfk_1` (`give_id`),
    CONSTRAINT `give_split_ibfk_1`
        FOREIGN KEY (`give_id`)
        REFERENCES `give` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- give_type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `give_type`;

CREATE TABLE `give_type`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `give_type_ibfk_1` (`parish_id`),
    CONSTRAINT `give_type_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- job_queue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `job_queue`;

CREATE TABLE `job_queue`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `letter_id` INTEGER NOT NULL,
    `recipients_id` INTEGER NOT NULL,
    `job_type` VARCHAR(50) NOT NULL,
    `scheduled_time` VARCHAR(50) NOT NULL,
    `status` VARCHAR(100),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `job_queue_ibfk_1` (`letter_id`),
    INDEX `job_queue_ibfk_2` (`recipients_id`),
    CONSTRAINT `job_queue_ibfk_1`
        FOREIGN KEY (`letter_id`)
        REFERENCES `letters` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- letter_queue
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `letter_queue`;

CREATE TABLE `letter_queue`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `job_id` INTEGER NOT NULL,
    `subject` VARCHAR(200) NOT NULL,
    `message` TEXT NOT NULL,
    `from_name` VARCHAR(100) NOT NULL,
    `from_email` VARCHAR(100) NOT NULL,
    `to_name` VARCHAR(200) NOT NULL,
    `to_email` VARCHAR(100) NOT NULL,
    `count` INTEGER DEFAULT 0,
    `last_status_msg` VARCHAR(200),
    `status` VARCHAR(100),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `letter_queue_ibfk_1` (`job_id`),
    CONSTRAINT `letter_queue_ibfk_1`
        FOREIGN KEY (`job_id`)
        REFERENCES `job_queue` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- letter_type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `letter_type`;

CREATE TABLE `letter_type`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- letters
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `letters`;

CREATE TABLE `letters`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `type_id` INTEGER NOT NULL,
    `name` VARCHAR(250) NOT NULL,
    `sender_name` VARCHAR(100) NOT NULL,
    `sender_email` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(250) NOT NULL,
    `letter` TEXT NOT NULL,
    `published` TINYINT(1) DEFAULT 1 NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `letters_ibfk_1` (`parish_id`),
    INDEX `letters_ibfk_2` (`type_id`),
    CONSTRAINT `letters_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `letters_ibfk_2`
        FOREIGN KEY (`type_id`)
        REFERENCES `letter_type` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- live_stream
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `live_stream`;

CREATE TABLE `live_stream`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `url` VARCHAR(250) NOT NULL,
    PRIMARY KEY (`value`),
    INDEX `live_ibfk_1` (`parish_id`),
    CONSTRAINT `live_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- media
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `category` INTEGER NOT NULL,
    `type` INTEGER NOT NULL,
    `url` VARCHAR(200),
    `publish_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    INDEX `category` (`category`),
    INDEX `media_ibfk_3` (`type`),
    CONSTRAINT `media_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `media_ibfk_2`
        FOREIGN KEY (`category`)
        REFERENCES `media_categories` (`value`),
    CONSTRAINT `media_ibfk_3`
        FOREIGN KEY (`type`)
        REFERENCES `media_type` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- media_categories
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `media_categories`;

CREATE TABLE `media_categories`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- media_type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `media_type`;

CREATE TABLE `media_type`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `link` VARCHAR(50),
    `parent` INTEGER DEFAULT 0 NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_roles`;

CREATE TABLE `menu_roles`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `role_id` INTEGER NOT NULL,
    `menu_id` INTEGER NOT NULL,
    `access` TINYINT DEFAULT 0 NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `menu_roles_ibfk_1` (`menu_id`),
    INDEX `menu_roles_ibfk_2` (`role_id`),
    CONSTRAINT `menu_roles_ibfk_1`
        FOREIGN KEY (`menu_id`)
        REFERENCES `menu` (`value`),
    CONSTRAINT `menu_roles_ibfk_2`
        FOREIGN KEY (`role_id`)
        REFERENCES `roles` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- messages
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(200),
    `message` TEXT,
    `payload` TEXT,
    `group_id` INTEGER NOT NULL,
    `scheduled_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `status` TINYINT,
    `last_run` DATETIME,
    `last_device_id` INTEGER,
    `locked_out` TINYINT,
    `locked_out_time` DATETIME,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `group_id` (`group_id`),
    CONSTRAINT `messages_ibfk_2`
        FOREIGN KEY (`group_id`)
        REFERENCES `econnect` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ministry
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ministry`;

CREATE TABLE `ministry`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `name` VARCHAR(100),
    `contact_person` VARCHAR(100),
    `phone` VARCHAR(50),
    `email` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `ministry_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- parish
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parish`;

CREATE TABLE `parish`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `church_id` INTEGER NOT NULL,
    `name` VARCHAR(100),
    `address` VARCHAR(200),
    `city` VARCHAR(50),
    `state` VARCHAR(50),
    `zip` VARCHAR(10),
    `lat` VARCHAR(50) DEFAULT '0' NOT NULL,
    `lng` VARCHAR(50) DEFAULT '0' NOT NULL,
    `formatted_address` VARCHAR(250),
    `country` VARCHAR(50) DEFAULT 'USA',
    `phone` VARCHAR(20),
    `email` VARCHAR(50),
    `logo` VARCHAR(250),
    `overseer` VARCHAR(250) NOT NULL,
    `enabled` TINYINT(1) DEFAULT 0 NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `church_id` (`church_id`),
    CONSTRAINT `parish_ibfk_1`
        FOREIGN KEY (`church_id`)
        REFERENCES `church` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- parish_segment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parish_segment`;

CREATE TABLE `parish_segment`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `segment_id` INTEGER NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    INDEX `segment_id` (`segment_id`),
    CONSTRAINT `parish_segment_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `parish_segment_ibfk_2`
        FOREIGN KEY (`segment_id`)
        REFERENCES `segment` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- password_reset
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `password_reset`;

CREATE TABLE `password_reset`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(20) NOT NULL,
    `token` VARCHAR(20) NOT NULL,
    `attempts` INTEGER DEFAULT 0 NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- pastor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pastor`;

CREATE TABLE `pastor`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `fname` VARCHAR(50),
    `lname` VARCHAR(50),
    `phone` VARCHAR(50),
    `email` VARCHAR(50),
    `comment` TEXT,
    `contact_date` VARCHAR(50),
    `contact_time` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`user_id`),
    CONSTRAINT `pastor_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user_profile` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- prayer
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `prayer`;

CREATE TABLE `prayer`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `full_name` VARCHAR(200),
    `email` VARCHAR(50),
    `prayer` TEXT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`user_id`),
    CONSTRAINT `prayer_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user_profile` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- push_register
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `push_register`;

CREATE TABLE `push_register`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `group_id` INTEGER,
    `user_id` INTEGER,
    `enabled` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `push_register_ibfk_1` (`user_id`),
    INDEX `push_register_ibfk_2` (`group_id`),
    CONSTRAINT `push_register_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user_profile` (`value`),
    CONSTRAINT `push_register_ibfk_2`
        FOREIGN KEY (`group_id`)
        REFERENCES `econnect` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- segment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `segment`;

CREATE TABLE `segment`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `project_id` VARCHAR(255),
    `project_number` VARCHAR(255),
    `api_key` VARCHAR(255),
    `ssl_cert` VARCHAR(255),
    `pwd_cert` VARCHAR(255),
    `send_limit` INTEGER,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sessions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions`
(
    `id` VARCHAR(32) NOT NULL,
    `access` int(10) unsigned,
    `data` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- settings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings`
(
    `name` VARCHAR(50) NOT NULL,
    `value` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- testimonials
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `testimonials`;

CREATE TABLE `testimonials`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `full_name` VARCHAR(200),
    `email` VARCHAR(50),
    `testimony` TEXT NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`user_id`),
    CONSTRAINT `testimonials_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user_profile` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- twitter
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `twitter`;

CREATE TABLE `twitter`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `handle_id` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `twitter_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_family
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_family`;

CREATE TABLE `user_family`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `fname` VARCHAR(50),
    `lname` VARCHAR(50),
    `relationship` VARCHAR(50),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `user_id` (`user_id`),
    CONSTRAINT `user_family_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_login
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_login`;

CREATE TABLE `user_login`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `envelope` VARCHAR(50) DEFAULT 'Guest',
    `email` VARCHAR(50),
    `password` binary(60),
    `salt` VARCHAR(20),
    `parish_id` INTEGER DEFAULT 0 NOT NULL,
    `role_id` INTEGER DEFAULT 0 NOT NULL,
    `last_login` DATETIME,
    `enabled` TINYINT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_admin_ibfk_1` (`parish_id`),
    INDEX `user_login_ibfk_2` (`role_id`),
    CONSTRAINT `user_login_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`),
    CONSTRAINT `user_login_ibfk_2`
        FOREIGN KEY (`role_id`)
        REFERENCES `roles` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_payment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_payment`;

CREATE TABLE `user_payment`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(200) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `status` VARCHAR(100),
    `reference` VARCHAR(100),
    `log` TEXT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `user_payment_ibfk_1` (`user_id`),
    CONSTRAINT `user_payment_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user_login` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_plan
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_plan`;

CREATE TABLE `user_plan`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `params` TEXT NOT NULL,
    `cost` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `parish_id` INTEGER NOT NULL,
    `fname` VARCHAR(50),
    `lname` VARCHAR(50),
    `address` VARCHAR(200),
    `city` VARCHAR(50),
    `state` VARCHAR(50),
    `zip` VARCHAR(20),
    `country` VARCHAR(50) DEFAULT 'USA',
    `phone` VARCHAR(20),
    `email` VARCHAR(50),
    `dob` VARCHAR(50),
    `married` TINYINT(1) NOT NULL,
    `wedding` VARCHAR(50),
    `push_id` VARCHAR(250) NOT NULL,
    `platform` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`value`),
    INDEX `parish_id` (`parish_id`),
    CONSTRAINT `user_profile_ibfk_1`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_subscription
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_subscription`;

CREATE TABLE `user_subscription`
(
    `value` INTEGER NOT NULL AUTO_INCREMENT,
    `plan_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `parish_id` INTEGER NOT NULL,
    `status` TINYINT(1),
    `start_date` DATETIME,
    `end_date` DATETIME,
    `pay_id` INTEGER,
    `customer_ref` VARCHAR(100) NOT NULL,
    `mileage` TEXT,
    PRIMARY KEY (`value`),
    INDEX `user_subscription_ibfk_1` (`user_id`),
    INDEX `user_subscription_ibfk_2` (`plan_id`),
    INDEX `user_subscription_ibfk_3` (`pay_id`),
    INDEX `user_subscription_ibfk_4` (`parish_id`),
    CONSTRAINT `user_subscription_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user_login` (`value`),
    CONSTRAINT `user_subscription_ibfk_2`
        FOREIGN KEY (`plan_id`)
        REFERENCES `user_plan` (`value`),
    CONSTRAINT `user_subscription_ibfk_3`
        FOREIGN KEY (`pay_id`)
        REFERENCES `user_payment` (`value`),
    CONSTRAINT `user_subscription_ibfk_4`
        FOREIGN KEY (`parish_id`)
        REFERENCES `parish` (`value`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
