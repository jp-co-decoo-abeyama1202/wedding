-- -----------------------------------------------------
-- Schema wedding
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `wedding` ;
CREATE SCHEMA IF NOT EXISTS `wedding` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wedding` ;
-- -----------------------------------------------------
-- Table `wedding`.`fairs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fairs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `flg_gnavi` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `flg_mwed` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `flg_mynavi` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `flg_park` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `flg_rakuten` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `flg_sugukon` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `flg_zexy` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `fair_name` VARCHAR(30) NOT NULL,
  `start_h` TINYINT(3) UNSIGNED NOT NULL,
  `start_m` TINYINT(3) UNSIGNED NOT NULL,
  `end_h` TINYINT(3) UNSIGNED NOT NULL,
  `end_m` TINYINT(3) UNSIGNED NOT NULL,
  `description` VARCHAR(100) NOT NULL,
  `target` VARCHAR(50) NOT NULL,
  `other_description` VARCHAR(100) NOT NULL,
  `tour_flg` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `pack_flg` TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
  `image_id` INT(10) UNSIGNED DEFAULT 0 NOT NULL,
  `image_description` VARCHAR(14) NOT NULL, 
  `post_start` INT(10) UNSIGNED NOT NULL,
  `post_end` INT(10) UNSIGNED NOT NULL,
  `reverse` TINYINT(3) UNSIGNED NOT NULL,
  `reverse_net_day` TINYINT(3) UNSIGNED NOT NULL,
  `reserve_net_time` TINYINT(3) UNSIGNED NOT NULL,
  `reserve_tel_day` TINYINT(3) UNSIGNED NOT NULL,
  `reserve_tel_time` TINYINT(3) UNSIGNED NOT NULL,
  `reserve_description` VARCHAR(200) NOT NULL,
  `holl_id` TINYINT(3) UNSIGNED NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `parking` VARCHAR(50) NOT NULL,
  `tel1_1` VARCHAR(4) NOT NULL,
  `tel1_2` VARCHAR(4) NOT NULL,
  `tel1_3` VARCHAR(4) NOT NULL,
  `tel1_syubetsu` TINYINT(3) UNSIGNED NOT NULL,
  `tel2_1` VARCHAR(4) NOT NULL,
  `tel2_2` VARCHAR(4) NOT NULL,
  `tel2_3` VARCHAR(4) NOT NULL,
  `tel2_syubetsu` TINYINT(3) UNSIGNED NOT NULL,
  `support_name` VARCHAR(100) NOT NULL,
  `inquery_time` VARCHAR(50) NOT NULL,
  `inquery_support_name` VARCHAR(50) NOT NULL,
  `created_id` INT(10) UNSIGNED NOT NULL,
  `updated_id` INT(10) UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_dates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_dates` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fair_id` INT UNSIGNED NOT NULL,
  `fair_date` DATE NOT NULL,
  `gnavi_id` INT UNSIGNED NOT NULL,
  `mwed_id` INT UNSIGNED NOT NULL,
  `mynavi_id` INT UNSIGNED NOT NULL,
  `park_id` INT UNSIGNED NOT NULL,
  `rakuten_id` INT UNSIGNED NOT NULL,
  `sugukon_id` INT UNSIGNED NOT NULL,
  `zexy_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`),
  UNIQUE (`fair_id`,`fair_date`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_gnavis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_dates` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `fair_title` VARCHAR(35) NOT NULL,
    `fair_time_start_h` TINYINT(3) UNSIGNED NOT NULL,
    `fair_time_start_m` TINYINT(3) UNSIGNED NOT NULL,
    `fair_time_end_h` TINYINT(3) UNSIGNED NOT NULL,
    `fair_time_end_m` TINYINT(3) UNSIGNED NOT NULL,
    `registration_flg` TINYINT(1) UNSIGNED,
    `visible_end_day` TINYINT(3) UNSIGNED NOT NULL,
    `fair_img_alt` VARCHAR(30),
    `fair_catch` VARCHAR(30),
    `fair_read` VARCHAR(250),
    `icon_flg` TINYINT(1) UNSIGNED NOT NULL,
    `program_time_1_h` TINYINT(3) UNSIGNED,
    `program_time_1_m` TINYINT(3) UNSIGNED,
    `program_comment_1` VARCHAR(40),
    `program_time_2_h` TINYINT(3) UNSIGNED,
    `program_time_2_m` TINYINT(3) UNSIGNED,
    `program_comment_2` VARCHAR(40),
    `program_time_3_h` TINYINT(3) UNSIGNED,
    `program_time_3_m` TINYINT(3) UNSIGNED,
    `program_comment_3` VARCHAR(40),
    `program_time_4_h` TINYINT(3) UNSIGNED,
    `program_time_4_m` TINYINT(3) UNSIGNED,
    `program_comment_4` VARCHAR(40),
    `program_time_5_h` TINYINT(3) UNSIGNED,
    `program_time_5_m` TINYINT(3) UNSIGNED,
    `program_comment_5` VARCHAR(40),
    `fair_point` VARCHAR(30),
    `tour_flg`  TINYINT(1) UNSIGNED NOT NULL,
    `i_wedding_flg` TINYINT(1) UNSIGNED NOT NULL,
    `i_reception_flg` TINYINT(1) UNSIGNED NOT NULL,
    `show_flg` TINYINT(1) UNSIGNED NOT NULL,
    `fitting_flg` TINYINT(1) UNSIGNED NOT NULL,
    `hair_flg` TINYINT(1) UNSIGNED NOT NULL,
    `food_flg` TINYINT(1) UNSIGNED NOT NULL,
    `tasting_flg` TINYINT(1) UNSIGNED NOT NULL,
    `fair_tasteing_flg` TINYINT(1) UNSIGNED NOT NULL,
    `pay_tasting_price` INT(10) UNSIGNED,
    `option_tax` TINYINT(3) UNSIGNED NOT NULL,
    `option_round_tax` TINYINT(3) UNSIGNED NOT NULL,
    `item_flg` TINYINT(1) UNSIGNED NOT NULL,
    `counsel_flg` TINYINT(1) UNSIGNED NOT NULL,
    `perk_flg` TINYINT(1) UNSIGNED NOT NULL,
    `gnavi_limit_flg` TINYINT(1) UNSIGNED NOT NULL,
    `just_one_ok_flg` TINYINT(1) UNSIGNED NOT NULL,
    `estimate_bid_flg` TINYINT(1) UNSIGNED NOT NULL,
    `freeword_search` VARCHAR(512),
    `customer_count` SMALLINT UNSIGNED,
    `reserve_flg` TINYINT(1) UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_mweds`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_mweds` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `fair_name` VARCHAR(30),
    `st_hour` TINYINT(3) UNSIGNED NOT NULL,
    `st_min` TINYINT(3) UNSIGNED NOT NULL,
    `ed_hour` TINYINT(3) UNSIGNED NOT NULL,
    `ed_min` TINYINT(3) UNSIGNED NOT NULL,
    `type_ques` TINYINT(1) UNSIGNED NOT NULL,
    `type_wedding` TINYINT(1) UNSIGNED NOT NULL,
    `type_banquet` TINYINT(1) UNSIGNED NOT NULL,
    `type_sampling` TINYINT(1) UNSIGNED NOT NULL,
    `type_coordinate` TINYINT(1) UNSIGNED NOT NULL,
    `type_item` TINYINT(1) UNSIGNED NOT NULL,
    `type_tryon` TINYINT(1) UNSIGNED NOT NULL,
    `type_etc` TINYINT(1) UNSIGNED NOT NULL,
    `disp_sub_flg` TINYINT(1) UNSIGNED NOT NULL,
    `etc1_txt` VARCHAR(15),
    `etc2_txt` VARCHAR(15),
    `plan_txt` VARCHAR(300),
    `priv_txt` VARCHAR(50),
    `reserve` TINYINT(3) UNSIGNED NOT NULL,
    `reserve_txt` VARCHAR(20),
    `rate` TINYINT(3) UNSIGNED NOT NULL,
    `rate_txt` VARCHAR(20),
    `stpb_year` TINYINT(3) UNSIGNED,
    `stpb_month` TINYINT(3) UNSIGNED,
    `stpb_day` TINYINT(3) UNSIGNED,
    `stpb_hour` TINYINT(3) UNSIGNED,
    `web_rsv` TINYINT(3) UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_mwed_contents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_mwed_contents` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_mwed_id` INT UNSIGNED NOT NULL,
    `no` TINYINT(3) UNSIGNED NOT NULL,
    `dt_st_hour` TINYINT(3) UNSIGNED NOT NULL,
    `dt_st_min` TINYINT(3) UNSIGNED NOT NULL,
    `dt_ed_hour` TINYINT(3) UNSIGNED NOT NULL,
    `dt_ed_min` TINYINT(3) UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_mwed_id`) REFERENCES `fair_mweds`(`id`),
    UNIQUE (`fair_mwed_id`,`no`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_mynavis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_mynavis` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `text` VARCHAR(500),
    `image_title` VARCHAR(100),
    `access_location` VARCHAR(200) NOT NULL,
    `access_location_note` VARCHAR(500),
    `access_etc` VARCHAR(100),
    `answer_div` TINYINT(3) UNSIGNED NOT NULL,
    `answer_limit_net_div` TINYINT(3) UNSIGNED,
    `answer_limit_time_net` TINYINT(3) UNSIGNED,
    `answer_limit_tel_div` TINYINT(3) UNSIGNED,
    `answer_limit_time_tel` TINYINT(3) UNSIGNED,
    `target_note` VARCHAR(100),
    `etc_note` VARCHAR(500),
    `special_note` VARCHAR(500),
    `plura_flg` TINYINT(1) UNSIGNED,
    `max_open_time_row` TINYINT(3) UNSIGNED,
    `start_hour1` TINYINT(3) UNSIGNED,
    `start_minute1` TINYINT(3) UNSIGNED,
    `end_hour1` TINYINT(3) UNSIGNED,
    `end_minute1` TINYINT(3) UNSIGNED,
    `start_hour2` TINYINT(3) UNSIGNED,
    `start_minute2` TINYINT(3) UNSIGNED,
    `end_hour2` TINYINT(3) UNSIGNED,
    `end_minute2` TINYINT(3) UNSIGNED,
    `start_hour3` TINYINT(3) UNSIGNED,
    `start_minute3` TINYINT(3) UNSIGNED,
    `end_hour3` TINYINT(3) UNSIGNED,
    `end_minute3` TINYINT(3) UNSIGNED,
    `start_hour4` TINYINT(3) UNSIGNED,
    `start_minute4` TINYINT(3) UNSIGNED,
    `end_hour4` TINYINT(3) UNSIGNED,
    `end_minute4` TINYINT(3) UNSIGNED,
    `start_hour5` TINYINT(3) UNSIGNED,
    `start_minute5` TINYINT(3) UNSIGNED,
    `end_hour5` TINYINT(3) UNSIGNED,
    `end_minute5` TINYINT(3) UNSIGNED,
    `need_hour` TINYINT(3) UNSIGNED,
    `need_minute` TINYINT(3) UNSIGNED,
    `detail_unselect_flg` TINYINT(1) UNSIGNED,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_mynavi_contents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_mynavi_contents` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_mynavi_id` INT UNSIGNED NOT NULL,
    `no` TINYINT(3) UNSIGNED NOT NULL,
    `fair_detail_type` TINYINT(3) UNSIGNED NOT NULL,
    `fair_detail_etc_note` VARCHAR(100),
    `fair_detail_reserve_div` TINYINT(3) UNSIGNED,
    `fair_detail_price_div` TINYINT(3) UNSIGNED,
    `fair_detail_price` INT(10) UNSIGNED,
    `fair_detail_start_hour` TINYINT(3) UNSIGNED,
    `fair_detail_start_minute` TINYINT(3) UNSIGNED,
    `fair_detail_end_hour` TINYINT(3) UNSIGNED,
    `fair_detail_end_minute` TINYINT(3) UNSIGNED,
    `fair_detail_headline` VARCHAR(100),
    `fair_detail_complement` VARCHAR(500),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_mynavi_id`) REFERENCES `fair_mynavis`(`id`),
    UNIQUE (`fair_mynavi_id`,`no`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_parks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_parks` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `any_time_flag` TINYINT(1) UNSIGNED,
    `start_hour` TINYINT(3) UNSIGNED NOT NULL,
    `start_min` TINYINT(3) UNSIGNED NOT NULL,
    `end_hour` TINYINT(3) UNSIGNED NOT NULL,
    `end_min` TINYINT(3) UNSIGNED NOT NULL,
    `name` VARCHAR(35) NOT NULL,
    `description` VARCHAR(115),
    `fair_2_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_3_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_6_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_7_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_8_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_9_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_10_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_1_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_11_flag` TINYINT(1) UNSIGNED NOT NULL,
    `fair_12_flag` TINYINT(1) UNSIGNED NOT NULL,
    `award_flag` TINYINT(1) UNSIGNED NOT NULL,
    `award_note` VARCHAR(200),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_park_contents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_park_contents` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_park_id` INT UNSIGNED NOT NULL,
    `fair_type` TINYINT(3) UNSIGNED NOT NULL,
    `name` VARCHAR(30),
    `reservation_flag` TINYINT(1) UNSIGNED,
    `people` INT UNSIGNED,
    `price` INT UNSIGNED,
    `start_hour_1` TINYINT(3) UNSIGNED,
    `start_min_1` TINYINT(3) UNSIGNED,
    `start_hour_2` TINYINT(3) UNSIGNED,
    `start_min_2` TINYINT(3) UNSIGNED,
    `start_hour_3` TINYINT(3) UNSIGNED,
    `start_min_3` TINYINT(3) UNSIGNED,
    `note` VARCHAR(200),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_park_id`) REFERENCES `fair_parks`(`id`),
    UNIQUE (`fair_park_id`,`fair_type`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_rakutens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_rakutens` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `fair_name` VARCHAR(40) NOT NULL,
    `introduction` VARCHAR(200),
    `reserve_online_flag` TINYINT(1) UNSIGNED,
    `reception_cd` TINYINT(3) UNSIGNED,
    `reserve_phone_flag` TINYINT(1) UNSIGNED,
    `same_event_time_flg` TINYINT(1) UNSIGNED,
    `same_event_from_hour` TINYINT(3) UNSIGNED,
    `same_event_from_minute` TINYINT(3) UNSIGNED,
    `same_event_to_hour` TINYINT(3) UNSIGNED,
    `same_event_to_minute` TINYINT(3) UNSIGNED,
    `fair_rakuten_tokuten_id` INT UNSIGNED,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_rakuten_contents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_rakuten_contents` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_rakuten_id` INT UNSIGNED NOT NULL,
    `no` TINYINT(3) UNSIGNED NOT NULL,
    `kbn_2` TINYINT(3) UNSIGNED NOT NULL,
    `kbn_3` VARCHAR(100),
    `kbn_4` VARCHAR(100),
    `event_time_need` SMALLINT(3) UNSIGNED,
    `event_price` MEDIUMINT(6) UNSIGNED,
    `event_detail` VARCHAR(120),
    `event_time_from_hour` TINYINT(3) UNSIGNED,
    `event_time_from_minute` TINYINT(3) UNSIGNED,
    `event_time_to_hour` TINYINT(3) UNSIGNED,
    `event_time_to_minute` TINYINT(3) UNSIGNED,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_rakuten_id`) REFERENCES `fair_rakutens`(`id`),
    UNIQUE (`fair_rakuten_id`,`no`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_rakuten_tokutens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_rakuten_tokutens` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `tokuten_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`fair_id`,`tokuten_id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_sugukons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_sugukons` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(40) NOT NULL,
    `description` VARCHAR(300) NOT NULL,
    `content_1` TINYINT(1) UNSIGNED,
    `content_2` TINYINT(1) UNSIGNED,
    `content_3` TINYINT(1) UNSIGNED,
    `content_4` TINYINT(1) UNSIGNED,
    `content_5` TINYINT(1) UNSIGNED,
    `content_6` TINYINT(1) UNSIGNED,
    `caption` VARCHAR(14) NOT NULL,
    `reserve_time_type` TINYINT(3) UNSIGNED NOT NULL,
    `reserve_time_1_hour` TINYINT(3) UNSIGNED,
    `reserve_time_1_minute` TINYINT(3) UNSIGNED,
    `reserve_time_2_hour` TINYINT(3) UNSIGNED,
    `reserve_time_2_minute` TINYINT(3) UNSIGNED,
    `reserve_time_3_hour` TINYINT(3) UNSIGNED,
    `reserve_time_3_minute` TINYINT(3) UNSIGNED,
    `reserve_time_4_hour` TINYINT(3) UNSIGNED,
    `reserve_time_4_minute` TINYINT(3) UNSIGNED,
    `reserve_time_5_hour` TINYINT(3) UNSIGNED,
    `reserve_time_5_minute` TINYINT(3) UNSIGNED,
    `reserve_time_begin_hour` TINYINT(3) UNSIGNED,
    `reserve_time_begin_minute` TINYINT(3) UNSIGNED,
    `reserve_time_end_hour` TINYINT(3) UNSIGNED,
    `reserve_time_end_minute` TINYINT(3) UNSIGNED,
    `time_needed_hour` TINYINT(3) UNSIGNED NOT NULL,
    `time_needed_minute` TINYINT(3) UNSIGNED NOT NULL,
    `fee` INT UNSIGNED NOT NULL,
    `reserve_period_limit` TINYINT(3) UNSIGNED NOT NULL,
    `parking_explain` VARCHAR(27) NOT NULL,
    `is_recommend` TINYINT(1) UNSIGNED,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_zexys`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_zexys` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_id` INT UNSIGNED NOT NULL,
    `real_time_yoyaku_flg` TINYINT(1) UNSIGNED,
    `fair_start_hour` TINYINT(3) UNSIGNED NOT NULL,
    `fair_start_minute` TINYINT(3) UNSIGNED NOT NULL,
    `fair_end_hour` TINYINT(3) UNSIGNED NOT NULL,
    `fair_end_minute` TINYINT(3) UNSIGNED NOT NULL,
    `required_minute` SMALLINT(3) UNSIGNED NOT NULL,
    `secret_flg` TINYINT(1) UNSIGNED NOT NULL,
    `head_fair_flg` TINYINT(1) UNSIGNED NOT NULL,
    `fair_nm` VARCHAR(30) NOT NULL,
    `main_catch` VARCHAR(100) NOT NULL,
    `tour_flg` TINYINT(1) UNSIGNED,
    `tour_start_hour_1` TINYINT(3) UNSIGNED,
    `tour_start_minute_1` TINYINT(3) UNSIGNED,
    `tour_end_hour_1` TINYINT(3) UNSIGNED,
    `tour_end_minute_1` TINYINT(3) UNSIGNED,
    `tour_start_hour_2` TINYINT(3) UNSIGNED,
    `tour_start_minute_2` TINYINT(3) UNSIGNED,
    `tour_end_hour_2` TINYINT(3) UNSIGNED,
    `tour_end_minute_2` TINYINT(3) UNSIGNED,
    `tour_start_hour_3` TINYINT(3) UNSIGNED,
    `tour_start_minute_3` TINYINT(3) UNSIGNED,
    `tour_end_hour_3` TINYINT(3) UNSIGNED,
    `tour_end_minute_3` TINYINT(3) UNSIGNED,
    `tour_start_hour_4` TINYINT(3) UNSIGNED,
    `tour_start_minute_4` TINYINT(3) UNSIGNED,
    `tour_end_hour_4` TINYINT(3) UNSIGNED,
    `tour_end_minute_4` TINYINT(3) UNSIGNED,
    `tour_start_hour_5` TINYINT(3) UNSIGNED,
    `tour_start_minute_5` TINYINT(3) UNSIGNED,
    `tour_end_hour_5` TINYINT(3) UNSIGNED,
    `tour_end_minute_5` TINYINT(3) UNSIGNED,
    `pack_yoyaku_flg` TINYINT(1) UNSIGNED,
    `pack_yoyaku_kbn` TINYINT(3) UNSIGNED,
    `pack_yoyaku_unit_kbn` TINYINT(3) UNSIGNED,
    `pack_yoyaku_uketsuke_cnt` MEDIUMINT(5) UNSIGNED,
    `fair_perk_naiyo` VARCHAR(50),
    `fair_perk_period` VARCHAR(50),
    `fair_perk_remarks` VARCHAR(50),
    `free_config_question` VARCHAR(200),
    `free_config_answer_must_flg` TINYINT(1) UNSIGNED,
    `input_address` VARCHAR(100),
    `parking`  VARCHAR(50),
    `target_person` VARCHAR(50),
    `etc` VARCHAR(100),
    `tel_1_1` VARCHAR(4) NOT NULL,
    `tel_2_1` VARCHAR(4) NOT NULL,
    `tel_3_1` VARCHAR(4) NOT NULL,
    `tel_shubetsu_kbn_1` TINYINT(3) UNSIGNED NOT NULL,
    `tel_tanto_nm_1` VARCHAR(100),
    `tel_1_2` VARCHAR(4) NOT NULL,
    `tel_2_2` VARCHAR(4) NOT NULL,
    `tel_3_2` VARCHAR(4) NOT NULL,
    `tel_shubetsu_kbn_2` TINYINT(3) UNSIGNED NOT NULL,
    `tel_tanto_nm_2` VARCHAR(100),
    `toiawase` VARCHAR(50),
    `tanto` VARCHAR(50),
    `yoyaku_uketsuke_how_kbn` TINYINT(3) UNSIGNED NOT NULL,
    `yoyaku_uketsuke_possible_nissu_net` TINYINT(2),
    `yoyaku_uketsuke_end_time_net` TINYINT(3),
    `yoyaku_uketsuke_possible_nissu_tel` TINYINT(2),
    `request_change_config_kbn` TINYINT(2),
    `request_change_rem_frame_cnt` MEDIUMINT(5) UNSIGNED,
    `keisai_start_date` DATETIME NOT NULL,
    `keisai_end_date` DATETIME NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_id`) REFERENCES `fairs`(`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_zexy_contents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_zexy_contents` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_zexy_id` INT UNSIGNED NOT NULL,
    `fair_tkch_cd` TINYINT(3) UNSIGNED NOT NULL,
    `fair_tkch_etc_nm` VARCHAR(200),
    `fair_yoyaku_shubetsu_cd` TINYINT(3) UNSIGNED,
    `yuryo_flg` TINYINT(1) UNSIGNED,
    `entry_ninzu` SMALLINT(3) UNSIGNED,
    `entry_charge` INT UNSIGNED,
    `real_time_yoyaku_unit_kbn` TINYINT(3) UNSIGNED,
    `detail` VARCHAR(100),
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_zexy_id`) REFERENCES `fair_zexys`(`id`),
    UNIQUE (`fair_zexy_id`,`fair_tkch_cd`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`fair_zexy_content_details`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`fair_zexy_content_details` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fair_zexy_content_id` INT UNSIGNED NOT NULL,
    `no` TINYINT(3) UNSIGNED NOT NULL,
    `start_hour` TINYINT(3) UNSIGNED,
    `start_minute` TINYINT(3) UNSIGNED,
    `end_hour` TINYINT(3) UNSIGNED,
    `end_minute` TINYINT(3) UNSIGNED,
    `title` VARCHAR(100),
    `yoyaku_cnt` MEDIUMINT(5) UNSIGNED,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fair_zexy_content_id`) REFERENCES `fair_zexy_contents`(`id`),
    UNIQUE (`fair_zexy_content_id`,`no`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`administrators`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`administrators` (
  `id` INT UNSIGNED NOT NULL,
  `email` VARCHAR(255) NOT NULL COMMENT 'メールアドレス',
  `password` VARCHAR(255) NOT NULL COMMENT '暗号化済みパスワード',
  `nickname` VARCHAR(100) NOT NULL COMMENT '表示名',
  `roll` TINYINT(3) UNSIGNED NOT NULL COMMENT '権限',
  `created_at` DATETIME NOT NULL COMMENT '登録時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`site_logins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`site_logins` (
  `id` INT UNSIGNED NOT NULL,
  `login_id` VARCHAR(30) NOT NULL COMMENT 'ログインに用いるID',
  `password` MEDIUMBLOB NOT NULL COMMENT '暗号化済みパスワード',
  `update_password` MEDIUMBLOB NOT NULL COMMENT '暗号化済み更新用パスワード',
  `last_login_at` INT UNSIGNED NOT NULL COMMENT '最終ログイン時間',
  `created_at` DATETIME NOT NULL COMMENT '登録時間',
  `updated_id` INT UNSIGNED NOT NULL COMMENT '更新者ID',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`site_images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`images` (
  `id` INT UNSIGNED NOT NULL,
  `image_category_id` INT UNSIGNED NOT NULL COMMENT 'image_categorys.id',
  `rakuten_id` INT UNSIGNED NOT NULL COMMENT '楽天から発行されるID',
  `zexy_id` INT UNSIGNED NOT NULL COMMENT 'Zexyから発行されるID',
  `mynavi_id` INT UNSIGNED NOT NULL COMMENT 'マイナビから発行されるID',
  `created_id` INT UNSIGNED NOT NULL COMMENT '登録者ID',
  `created_at` DATETIME NOT NULL COMMENT '登録時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`site_image_categorys`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`image_categorys` (
  `id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(100) NOT NULL COMMENT 'カテゴリ名',
  `created_at` DATETIME NOT NULL COMMENT '登録時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`tokutens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wedding`.`tokutens` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` INT UNSIGNED,
    `type` TINYINT(3) UNSIGNED NOT NULL,
    `name` VARCHAR(20),
    `content` VARCHAR(200),
    `object` VARCHAR(100),
    `application_method` VARCHAR(100),
    `fd_span_from` DATETIME,
    `fd_span_to` DATETIME,
    `access_view` TINYINT(1) UNSIGNED,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`site_id`)
) ENGINE = InnoDB;
