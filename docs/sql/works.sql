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

-- -----------------------------------------------------
-- Table `wedding`.`work_zexy_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wedding`.`work_zexy_images` ;

CREATE TABLE IF NOT EXISTS `wedding`.`work_zexy_images` (
  `id` INT UNSIGNED NOT NULL COMMENT '画像ID',
  `photo_title` VARCHAR(100) COMMENT '写真名',
  `photo_caption` TEXT COMMENT 'キャプション',
  `photo_kbn` TINYINT(3) UNSIGNED NOT NULL COMMENT 'カテゴリ選択',
  `is_linking` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`work_mynavi_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wedding`.`work_mynavi_images` ;

CREATE TABLE IF NOT EXISTS `wedding`.`work_mynavi_images` (
  `id` INT UNSIGNED NOT NULL COMMENT '画像ID',
  `name` VARCHAR(100) NOT NULL COMMENT '名前',
  `part_1` VARCHAR(2) NOT NULL COMMENT 'URL素材1',
  `title` VARCHAR(40) COMMENT 'キャプションタイトル', 
  `part_2` VARCHAR(2) NOT NULL COMMENT 'URL素材2',
  `photo_show_flg` TINYINT(1) UNSIGNED NOT NULL COMMENT 'フォトギャラリー 表示する=1,表示しない=0',
  `inspiration_search_flg` TINYINT(1) UNSIGNED NOT NULL COMMENT 'ウェディングフォト診断 対象=1,対象外=0',
  `image_category_id` TINYINT(3) UNSIGNED NOT NULL COMMENT 'フォトカテゴリ',
  `tag_id_1` INT UNSIGNED,
  `tag_id_2` INT UNSIGNED,
  `tag_id_3` INT UNSIGNED,
  `is_linking` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wedding`.`work_rakuten_images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `wedding`.`work_rakuten_images` ;

CREATE TABLE IF NOT EXISTS `wedding`.`work_rakuten_images` (
  `id` INT UNSIGNED NOT NULL COMMENT '画像ID',
  `genre_id` INT UNSIGNED NOT NULL COMMENT 'ジャンルID',
  `photo_description` TEXT COMMENT '紹介文',
  `created_at` DATETIME NOT NULL COMMENT '作成時間',
  `updated_at` DATETIME NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;