-- -----------------------------------------------------
-- Schema wedding
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wedding` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wedding` ;
-- -----------------------------------------------------
-- Table `wedding`.`work_*_fairs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wedding`.`work_mwed_fairs` ;
DROP TABLE IF EXISTS `wedding`.`work_zexy_fairs` ;
DROP TABLE IF EXISTS `wedding`.`work_park_fairs` ;
DROP TABLE IF EXISTS `wedding`.`work_gnavi_fairs` ;
DROP TABLE IF EXISTS `wedding`.`work_gnavi_fair_ids` ;
DROP TABLE IF EXISTS `wedding`.`work_rakuten_fairs` ;
DROP TABLE IF EXISTS `wedding`.`work_sugukon_fairs` ;
DROP TABLE IF EXISTS `wedding`.`work_mynavi_fairs` ;

CREATE TABLE IF NOT EXISTS `wedding`.`work_mwed_fairs` (
  `id` BIGINT UNSIGNED NOT NULL COMMENT 'フェアID',
  `data` LONGTEXT NOT NULL COMMENT '取得したフェア情報',
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `wedding`.`work_zexy_fairs` LIKE `wedding`.`work_mwed_fairs`;
CREATE TABLE IF NOT EXISTS `wedding`.`work_park_fairs` LIKE `wedding`.`work_mwed_fairs`;

CREATE TABLE IF NOT EXISTS `wedding`.`work_gnavi_fairs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` LONGTEXT NOT NULL COMMENT '取得したフェア情報',
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `wedding`.`work_gnavi_fair_ids` (
  `id` BIGINT UNSIGNED NOT NULL COMMENT 'フェアID',
  `work_gnavi_fairs_id` BIGINT UNSIGNED NOT NULL COMMENT 'work_gnavi_fairsの外部キー',
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`work_gnavi_fairs_id`)
  REFERENCES `work_gnavi_fairs`(`id`)
) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS `wedding`.`work_rakuten_fairs` LIKE `wedding`.`work_mwed_fairs`;
CREATE TABLE IF NOT EXISTS `wedding`.`work_sugukon_fairs` LIKE `wedding`.`work_mwed_fairs`;
CREATE TABLE IF NOT EXISTS `wedding`.`work_mynavi_fairs` LIKE `wedding`.`work_mwed_fairs`;

-- -----------------------------------------------------
-- Table `wedding`.`work_rakuten_tokutens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wedding`.`work_rakuten_tokutens` ;

CREATE TABLE IF NOT EXISTS `wedding`.`work_rakuten_tokutens` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '特典ID',
  `type` TINYINT UNSIGNED NOT NULL COMMENT '1=下見,2=成約',
  `type_no` TINYINT UNSIGNED NOT NULL COMMENT '0～4',
  `privilege_no` SMALLINT UNSIGNED NOT NULL COMMENT '特典No',
  `position` TINYINT UNSIGNED NOT NULL COMMENT '並び順 1～5',
  `privilege_name` VARCHAR(20) NOT NULL COMMENT '特典名',
  `privilege_content` VARCHAR(200) NOT NULL COMMENT '特典内容',
  `privilege_object` VARCHAR(100) NOT NULL COMMENT '特典対象',
  `application_method` VARCHAR(100) NOT NULL COMMENT '申込方法',
  `fd_span_from` DATE NOT NULL COMMENT '有効期限from',
  `fd_span_to` DATE NOT NULL COMMENT '有効期限to',
  `access_view` TINYINT(1) UNSIGNED NOT NULL COMMENT '共通特典',
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
