-- -----------------------------------------------------
-- Schema wedding
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `wedding` ;
CREATE SCHEMA IF NOT EXISTS `wedding` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `wedding` ;
-- -----------------------------------------------------
-- Table `wedding`.`site_logins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wedding`.`site_logins` ;

CREATE TABLE IF NOT EXISTS `wedding`.`site_logins` (
  `id` INT UNSIGNED NOT NULL,
  `login_id` VARCHAR(30) NOT NULL COMMENT 'ログインに用いるID',
  `password` MEDIUMBLOB NOT NULL COMMENT '暗号化済みパスワード',
  `update_password` MEDIUMBLOB NOT NULL COMMENT '暗号化済み更新用パスワード',
  `last_login_at` INT UNSIGNED NOT NULL COMMENT '最終ログイン時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

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