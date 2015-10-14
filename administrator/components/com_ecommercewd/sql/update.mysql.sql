/* payments */
CREATE TABLE IF NOT EXISTS `#__ecommercewd_payments` (
  `id`         INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tool_id`    INT(16) UNSIGNED NOT NULL,
  `name`       VARCHAR(256)     NOT NULL,
  `options`    LONGTEXT         NOT NULL,
  `short_name` VARCHAR(256)     NOT NULL,
  `base_name`  VARCHAR(256)     NOT NULL,
  `ordering`   INT(16)          NOT NULL,
  `published`  TINYINT UNSIGNED NOT NULL DEFAULT 0,

  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;
  
 

/* parametertypes */
DROP TABLE IF EXISTS `#__ecommercewd_parametertypes`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_parametertypes` (
  `id`       INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`     VARCHAR(256)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1; 

INSERT INTO `#__ecommercewd_parametertypes` (`id`, `name`) VALUES
	('', 'Input'),  
  	('', 'Single value'), 
    ('', 'Select'),
    ('', 'Radio'),
    ('', 'Checkbox');  
    