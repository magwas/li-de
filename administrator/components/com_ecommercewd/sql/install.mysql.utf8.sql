 /*
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
/* categories */
DROP TABLE IF EXISTS `#__ecommercewd_categories`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_categories` (
  `id`               INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id`        INT(16) UNSIGNED DEFAULT NULL,
  `level`            INT(16) UNSIGNED DEFAULT NULL,
  `name`             VARCHAR(256)     NOT NULL,
  `alias`            VARCHAR(256)     NOT NULL,
  `description`      TEXT,
  `images`           TEXT,
  `meta_title`       TEXT             NOT NULL,
  `meta_description` TEXT             NOT NULL,
  `meta_keyword`     TEXT             NOT NULL,
  `ordering`         INT(16)          NOT NULL,
  `published`        TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* categoryparameters */
DROP TABLE IF EXISTS `#__ecommercewd_categoryparameters`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_categoryparameters` (
  `categoryparameters_id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id`           INT(16) UNSIGNED DEFAULT NULL,
  `parameter_id`    	  INT(16) UNSIGNED DEFAULT NULL,
  `parameter_value`  	  VARCHAR(256) NOT NULL,
  
	PRIMARY KEY (`categoryparameters_id`)
 )
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;


/* categorytags */
DROP TABLE IF EXISTS `#__ecommercewd_categorytags`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_categorytags` (
  `category_id` INT(16) UNSIGNED DEFAULT NULL,
  `tag_id`      INT(16) UNSIGNED DEFAULT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;


/* countries */
DROP TABLE IF EXISTS `#__ecommercewd_countries`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_countries` (
  `id`         INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(256)     NOT NULL,
  `code`       VARCHAR(256)     NOT NULL,
  `published`  TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* currencies */
DROP TABLE IF EXISTS `#__ecommercewd_currencies`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_currencies` (
  `id`            INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(256)     NOT NULL,
  `code`          VARCHAR(256)     NOT NULL,
  `sign`          VARCHAR(256)     NOT NULL,
  `sign_position` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `exchange_rate` DECIMAL(10, 5)   NOT NULL,
  `default`       TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;
  

/* discounts */
DROP TABLE IF EXISTS `#__ecommercewd_discounts`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_discounts` (
  `id`        INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(256)     NOT NULL,
  `rate`      DECIMAL(16, 2)   NOT NULL DEFAULT '0.00',
  `published` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* feedback */
DROP TABLE IF EXISTS `#__ecommercewd_feedback`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_feedback` (
  `id`              INT(16) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `j_user_id`       VARCHAR(256)            NOT NULL,
  `user_ip_address` VARCHAR(256)            NOT NULL,
  `user_name`       VARCHAR(256)            NOT NULL,
  `sender_name`       VARCHAR(256)            NOT NULL,
  `product_id`      INT(16)                 NOT NULL,
  `date`            TIMESTAMP               NULL DEFAULT CURRENT_TIMESTAMP,
  `text`            TEXT
                    CHARACTER SET utf8
                    COLLATE utf8_unicode_ci NOT NULL,
  `published`       TINYINT UNSIGNED        NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* labels */
DROP TABLE IF EXISTS `#__ecommercewd_labels`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_labels` (
  `id`             INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(256)     NOT NULL,
  `thumb`          TEXT,
  `thumb_position` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `published`      TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* manufacturers */
DROP TABLE IF EXISTS `#__ecommercewd_manufacturers`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_manufacturers` (
  `id`               INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`             VARCHAR(256)     NOT NULL,
  `alias`            VARCHAR(256)     NOT NULL,
  `logo`             TEXT,
  `description`      TEXT,
  `site`             VARCHAR(256)     NOT NULL,
  `meta_title`       TEXT             NOT NULL,
  `meta_description` TEXT             NOT NULL,
  `meta_keyword`     TEXT             NOT NULL,
  `published`        TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* options */
DROP TABLE IF EXISTS `#__ecommercewd_options`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_options` (
  `id`            INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(256)     NOT NULL,
  `value`         VARCHAR(256)     NOT NULL,
  `default_value` VARCHAR(256)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* orderproducts */
DROP TABLE IF EXISTS `#__ecommercewd_orderproducts`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_orderproducts` (
  `id`                       INT(16) UNSIGNED   NOT NULL AUTO_INCREMENT,
  `rand_id`                  INT(16) UNSIGNED   NOT NULL,
  `order_id`                 INT(16)   UNSIGNED NOT NULL,
  `j_user_id`                INT(16)   UNSIGNED NOT NULL,
  `user_ip_address`          INT(16)   UNSIGNED NOT NULL,
  `product_id`               INT(16)   UNSIGNED NOT NULL,
  `product_name`             VARCHAR(256)       NOT NULL,
  `product_image`            TEXT,
  `product_parameters`       TEXT,
  `product_parameters_price` VARCHAR(256) NOT NULL,
  `product_price`            DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
  `product_count`            INT(16)  UNSIGNED  NOT NULL,
  `tax_id`                   INT(16)   UNSIGNED NOT NULL,
  `tax_name`                 VARCHAR(1024)      NOT NULL,
  `tax_price`                DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
  `shipping_method_id`       INT(16)   UNSIGNED NOT NULL,
  `shipping_method_name`     VARCHAR(1024)      NOT NULL,
  `shipping_method_price`    DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
  `currency_id`              INT(16)   UNSIGNED NOT NULL,
  `currency_code`            VARCHAR(1024)      NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* orders */
DROP TABLE IF EXISTS `#__ecommercewd_orders`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_orders` (
  `id`                        INT(16) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `rand_id`                   INT(16) UNSIGNED        NOT NULL,
  `checkout_type`             VARCHAR(256)            NOT NULL,
  `checkout_date`             DATETIME,
  `date_modified`             TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `j_user_id`                 INT(16) UNSIGNED,
  `user_ip_address`           VARCHAR(256)            NOT NULL,
  `status_id`                 INT(16) UNSIGNED,
  `status_name`               VARCHAR(256)            NOT NULL,
  `payment_method`            VARCHAR(256)            NOT NULL,
  `payment_data`              TEXT
                              CHARACTER SET utf8
                              COLLATE utf8_unicode_ci NOT NULL,
  `payment_data_status`       VARCHAR(256)            NOT NULL,
  `billing_data_first_name`   VARCHAR(256)            NOT NULL,
  `billing_data_middle_name`  VARCHAR(256)            NOT NULL,
  `billing_data_last_name`    VARCHAR(256)            NOT NULL,
  `billing_data_company`      VARCHAR(256)            NOT NULL,
  `billing_data_email`        VARCHAR(256)            NOT NULL,
  `billing_data_country_id`   INT(16) UNSIGNED        NOT NULL,
  `billing_data_country`      VARCHAR(256)            NOT NULL,
  `billing_data_state`        VARCHAR(256)            NOT NULL,
  `billing_data_city`         VARCHAR(256)            NOT NULL,
  `billing_data_address`      VARCHAR(256)            NOT NULL,
  `billing_data_mobile`       VARCHAR(256)            NOT NULL,
  `billing_data_phone`        VARCHAR(256)            NOT NULL,
  `billing_data_fax`          VARCHAR(256)            NOT NULL,
  `billing_data_zip_code`     VARCHAR(256)            NOT NULL,  
  `shipping_data_first_name`  VARCHAR(256)            NOT NULL,
  `shipping_data_middle_name` VARCHAR(256)            NOT NULL,
  `shipping_data_last_name`   VARCHAR(256)            NOT NULL,
  `shipping_data_company`     VARCHAR(256)            NOT NULL,
  `shipping_data_country_id`  INT(16) UNSIGNED        NOT NULL,
  `shipping_data_country`     VARCHAR(256)            NOT NULL,
  `shipping_data_state`       VARCHAR(256)            NOT NULL,
  `shipping_data_city`        VARCHAR(256)            NOT NULL,
  `shipping_data_address`     VARCHAR(256)            NOT NULL,
  `shipping_data_zip_code`    VARCHAR(256)            NOT NULL,
  `currency_id`               INT(16)   UNSIGNED      NOT NULL,
  `currency_code`             VARCHAR(1024)           NOT NULL,
  `read`                      TINYINT UNSIGNED        NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* orderstatuses */
DROP TABLE IF EXISTS `#__ecommercewd_orderstatuses`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_orderstatuses` (
  `id`        INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(256)     NOT NULL,
  `ordering`  INT(16)          NOT NULL,
  `published` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `default`   TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* pages */
DROP TABLE IF EXISTS `#__ecommercewd_pages`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_pages` (
  `id`                   INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_article`           TINYINT UNSIGNED NOT NULL,
  `article_id`           INT(16)          NOT NULL,
  `title`                VARCHAR(256)     NOT NULL,
  `text`                 TEXT             NOT NULL,
  `ordering`             INT(16)          NOT NULL,
  `use_for_all_products` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `published`            TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* parameters */
DROP TABLE IF EXISTS `#__ecommercewd_parameters`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_parameters` (
  `id`              INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`            VARCHAR(256)     NOT NULL,
  `type_id`         INT(16)          NOT NULL,
  `default_values`  VARCHAR(256)     NOT NULL,
  `required`        TINYINT UNSIGNED NOT NULL DEFAULT 0,

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
  
/* payments */
DROP TABLE IF EXISTS `#__ecommercewd_payments`;
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
  


/* productpages */
DROP TABLE IF EXISTS `#__ecommercewd_productpages`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_productpages` (
  `product_id` INT(16) UNSIGNED DEFAULT NULL,
  `page_id`    INT(16) UNSIGNED DEFAULT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;


/* productparameters */
DROP TABLE IF EXISTS `#__ecommercewd_productparameters`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_productparameters` (
  `productparameters_id`           INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id`      	           INT(16) UNSIGNED DEFAULT NULL,
  `parameter_id`    	           INT(16) UNSIGNED DEFAULT NULL,
  `parameter_value` 	           VARCHAR(256) NOT NULL,
  `parameter_value_price` 	 VARCHAR(256) NOT NULL,

   PRIMARY KEY (`productparameters_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

/* products */
DROP TABLE IF EXISTS `#__ecommercewd_products`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_products` (
  `id`                 INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`               VARCHAR(256)     NOT NULL,
  `alias`              VARCHAR(256)     NOT NULL,
  `model`              VARCHAR(256)     NOT NULL,
  `sku`                VARCHAR(256)     NOT NULL,
  `upc`                VARCHAR(256)     NOT NULL,
  `ean`                VARCHAR(256)     NOT NULL,
  `jan`                VARCHAR(256)     NOT NULL,
  `isbn`               VARCHAR(256)     NOT NULL,
  `mpn`                VARCHAR(256)     NOT NULL,
  `weight`             VARCHAR(256)     NOT NULL,
  `dimensions`         VARCHAR(256)     NOT NULL,
  `category_id`        INT(16)          NOT NULL,
  `manufacturer_id`    INT(16)          NOT NULL,
  `description`        TEXT,
  `images`             TEXT,
  `videos`             TEXT,
  `tax_id`             INT(16)          NOT NULL,
  `enable_shipping`    TINYINT UNSIGNED NOT NULL,
  `discount_id`        INT(16)          NOT NULL,
  `price`              DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
  `market_price`       DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
  `amount_in_stock`    INT(16)          NOT NULL,
  `unlimited`          TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `label_id`           INT(16)          NOT NULL,
  `meta_title`         TEXT             NOT NULL,
  `meta_description`   TEXT             NOT NULL,
  `meta_keyword`       TEXT             NOT NULL,
  `date_added`         DATETIME         NOT NULL DEFAULT 0,
  `ordering`           INT(16)          NOT NULL,
  `published`          TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* productshippingmethods */
DROP TABLE IF EXISTS `#__ecommercewd_productshippingmethods`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_productshippingmethods` (
  `product_id`         INT(16) UNSIGNED DEFAULT NULL,
  `shipping_method_id` INT(16) UNSIGNED DEFAULT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;


/* producttags */
DROP TABLE IF EXISTS `#__ecommercewd_producttags`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_producttags` (
  `product_id` INT(16) UNSIGNED DEFAULT NULL,
  `tag_id`     INT(16) UNSIGNED DEFAULT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;


/* ratings */
DROP TABLE IF EXISTS `#__ecommercewd_ratings`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_ratings` (
  `id`              INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `j_user_id`       INT(16) UNSIGNED,
  `user_ip_address` VARCHAR(256)     NOT NULL,
  `product_id`      INT(16)          NOT NULL,
  `rating`          INT(16)          NOT NULL,
  `date`            DATETIME         NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* shippingmethodcountries */
DROP TABLE IF EXISTS `#__ecommercewd_shippingmethodcountries`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_shippingmethodcountries` (
  `shipping_method_id` INT(16) UNSIGNED DEFAULT NULL,
  `country_id`         INT(16) UNSIGNED DEFAULT NULL
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;


/* shippingmethods */
DROP TABLE IF EXISTS `#__ecommercewd_shippingmethods`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_shippingmethods` (
  `id`                        INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`                      VARCHAR(256)     NOT NULL,
  `description`               VARCHAR(256)     NOT NULL,
  `price`                     DECIMAL(16, 2)   NOT NULL,
  `free_shipping`             INT(16) DEFAULT 0,
  `free_shipping_start_price` DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
  `ordering`                  INT(16)          NOT NULL,
  `published`                 TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* tags */
DROP TABLE IF EXISTS `#__ecommercewd_tags`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_tags` (
  `id`        INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(256)     NOT NULL,
  `ordering`  INT(16)          NOT NULL,
  `published` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* taxes */
DROP TABLE IF EXISTS `#__ecommercewd_taxes`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_taxes` (
  `id`        INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(256)     NOT NULL,
  `rate`      DECIMAL(16, 2)   NOT NULL DEFAULT '0.00',
  `published` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

/* tools */
DROP TABLE IF EXISTS `#__ecommercewd_tools`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_tools` (
  `id`        	         INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`      	         VARCHAR(256)     NOT NULL,
  `create_toolbar_icon`  INT(16) UNSIGNED NOT NULL,
  `author_url`           VARCHAR(256)     NOT NULL,
  `description`          VARCHAR(256)     NOT NULL,
  `tool_type`            VARCHAR(256)     NOT NULL,
  `creation_date`        DATE     		  NOT NULL,
  `published` 	         TINYINT UNSIGNED NOT NULL DEFAULT 1, 
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;
/* themes */
DROP TABLE IF EXISTS `#__ecommercewd_themes`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_themes` (
  `id`                                                  INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`                                                VARCHAR(256)     NOT NULL,
  `rounded_corners`                                     TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `content_main_color`                                  VARCHAR(15)      NOT NULL,

  `header_content_color`                                VARCHAR(15)      NOT NULL,

  `subtext_content_color`                               VARCHAR(15)      NOT NULL,

  `input_content_color`                                 VARCHAR(15)      NOT NULL,
  `input_bg_color`                                      VARCHAR(15)      NOT NULL,
  `input_border_color`                                  VARCHAR(15)      NOT NULL,
  `input_focus_border_color`                            VARCHAR(15)      NOT NULL,
  `input_has_error_content_color`                       VARCHAR(15)      NOT NULL,

  `button_default_content_color`                        VARCHAR(15)      NOT NULL,
  `button_default_bg_color`                             VARCHAR(15)      NOT NULL,
  `button_default_border_color`                         VARCHAR(15)      NOT NULL,
  `button_primary_content_color`                        VARCHAR(15)      NOT NULL,
  `button_primary_bg_color`                             VARCHAR(15)      NOT NULL,
  `button_primary_border_color`                         VARCHAR(15)      NOT NULL,
  `button_success_content_color`                        VARCHAR(15)      NOT NULL,
  `button_success_bg_color`                             VARCHAR(15)      NOT NULL,
  `button_success_border_color`                         VARCHAR(15)      NOT NULL,
  `button_info_content_color`                           VARCHAR(15)      NOT NULL,
  `button_info_bg_color`                                VARCHAR(15)      NOT NULL,
  `button_info_border_color`                            VARCHAR(15)      NOT NULL,
  `button_warning_content_color`                        VARCHAR(15)      NOT NULL,
  `button_warning_bg_color`                             VARCHAR(15)      NOT NULL,
  `button_warning_border_color`                         VARCHAR(15)      NOT NULL,
  `button_danger_content_color`                         VARCHAR(15)      NOT NULL,
  `button_danger_bg_color`                              VARCHAR(15)      NOT NULL,
  `button_danger_border_color`                          VARCHAR(15)      NOT NULL,
  `button_link_content_color`                           VARCHAR(15)      NOT NULL,

  `divider_color`                                       VARCHAR(15)      NOT NULL,

  `navbar_bg_color`                                     VARCHAR(15)      NOT NULL,
  `navbar_border_color`                                 VARCHAR(15)      NOT NULL,
  `navbar_link_content_color`                           VARCHAR(15)      NOT NULL,
  `navbar_link_hover_content_color`                     VARCHAR(15)      NOT NULL,
  `navbar_link_open_content_color`                      VARCHAR(15)      NOT NULL,
  `navbar_link_open_bg_color`                           VARCHAR(15)      NOT NULL,
  `navbar_badge_content_color`                          VARCHAR(15)      NOT NULL,
  `navbar_badge_bg_color`                               VARCHAR(15)      NOT NULL,
  `navbar_dropdown_link_content_color`                  VARCHAR(15)      NOT NULL,
  `navbar_dropdown_link_hover_content_color`            VARCHAR(15)      NOT NULL,
  `navbar_dropdown_link_hover_background_content_color` VARCHAR(15)      NOT NULL,
  `navbar_dropdown_divider_color`                       VARCHAR(15)      NOT NULL,
  `navbar_dropdown_background_color`                    VARCHAR(15)      NOT NULL,
  `navbar_dropdown_border_color`                        VARCHAR(15)      NOT NULL,

  `modal_backdrop_color`                                VARCHAR(15)      NOT NULL,
  `modal_bg_color`                                      VARCHAR(15)      NOT NULL,
  `modal_border_color`                                  VARCHAR(15)      NOT NULL,
  `modal_dividers_color`                                VARCHAR(15)      NOT NULL,

  `panel_user_data_bg_color`                            VARCHAR(15)      NOT NULL,
  `panel_user_data_border_color`                        VARCHAR(15)      NOT NULL,
  `panel_user_data_footer_bg_color`                     VARCHAR(15)      NOT NULL,

  `panel_product_bg_color`                              VARCHAR(15)      NOT NULL,
  `panel_product_border_color`                          VARCHAR(15)      NOT NULL,
  `panel_product_footer_bg_color`                       VARCHAR(15)      NOT NULL,

  `well_bg_color`                                       VARCHAR(15)      NOT NULL,
  `well_border_color`                                   VARCHAR(15)      NOT NULL,

  `rating_star_type`                                    VARCHAR(15)      NOT NULL,
  `rating_star_color`                                   VARCHAR(15)      NOT NULL,
  `rating_star_bg_color`                                VARCHAR(15)      NOT NULL,

  `label_content_color`                                 VARCHAR(15)      NOT NULL,
  `label_bg_color`                                      VARCHAR(15)      NOT NULL,

  `alert_info_content_color`                            VARCHAR(15)      NOT NULL,
  `alert_info_bg_color`                                 VARCHAR(15)      NOT NULL,
  `alert_info_border_color`                             VARCHAR(15)      NOT NULL,
  `alert_danger_content_color`                          VARCHAR(15)      NOT NULL,
  `alert_danger_bg_color`                               VARCHAR(15)      NOT NULL,
  `alert_danger_border_color`                           VARCHAR(15)      NOT NULL,

  `breadcrumb_content_color`                            VARCHAR(15)      NOT NULL,
  `breadcrumb_bg_color`                                 VARCHAR(15)      NOT NULL,

  `pill_link_content_color`                             VARCHAR(15)      NOT NULL,
  `pill_link_hover_content_color`                       VARCHAR(15)      NOT NULL,
  `pill_link_hover_bg_color`                            VARCHAR(15)      NOT NULL,

  `tab_link_content_color`                              VARCHAR(15)      NOT NULL,
  `tab_link_hover_content_color`                        VARCHAR(15)      NOT NULL,
  `tab_link_hover_bg_color`                             VARCHAR(15)      NOT NULL,
  `tab_link_active_content_color`                       VARCHAR(15)      NOT NULL,
  `tab_link_active_bg_color`                            VARCHAR(15)      NOT NULL,
  `tab_border_color`                                    VARCHAR(15)      NOT NULL,

  `pagination_content_color`                            VARCHAR(15)      NOT NULL,
  `pagination_bg_color`                                 VARCHAR(15)      NOT NULL,
  `pagination_hover_content_color`                      VARCHAR(15)      NOT NULL,
  `pagination_hover_bg_color`                           VARCHAR(15)      NOT NULL,
  `pagination_active_content_color`                     VARCHAR(15)      NOT NULL,
  `pagination_active_bg_color`                          VARCHAR(15)      NOT NULL,
  `pagination_border_color`                             VARCHAR(15)      NOT NULL,

  `pager_content_color`                                 VARCHAR(15)      NOT NULL,
  `pager_bg_color`                                      VARCHAR(15)      NOT NULL,
  `pager_border_color`                                  VARCHAR(15)      NOT NULL,

  `product_name_color`                                  VARCHAR(15)      NOT NULL,
  `product_category_color`                              VARCHAR(15)      NOT NULL,
  `product_manufacturer_color`                          VARCHAR(15)      NOT NULL,
  `product_model_color`                                 VARCHAR(15)      NOT NULL,
  `product_code_color`                                  VARCHAR(15)      NOT NULL,
  `product_price_color`                                 VARCHAR(15)      NOT NULL,
  `product_market_price_color`                          VARCHAR(15)      NOT NULL,

  `products_filters_position`                           INT(16) UNSIGNED NOT NULL,

  `products_count_in_page`                              INT(16) UNSIGNED NOT NULL,
  `products_option_columns`                             INT(16) UNSIGNED NOT NULL,

  `products_thumbs_view_show_image`                     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_label`                     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_name`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_rating`                    TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_price`                     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_market_price`              TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_description`               TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_button_quick_view`         TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_button_compare`            TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_button_buy_now`            TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_thumbs_view_show_button_add_to_cart`        TINYINT UNSIGNED NOT NULL DEFAULT 0,

  `products_list_view_show_image`                       TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_label`                       TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_name`                        TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_rating`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_price`                       TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_market_price`                TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_description`                 TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_button_quick_view`           TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_button_compare`              TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_button_buy_now`              TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_list_view_show_button_add_to_cart`          TINYINT UNSIGNED NOT NULL DEFAULT 0,

  `products_quick_view_show_image`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_label`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_name`                       TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_rating`                     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_category`                   TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_manufacturer`               TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_model`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_price`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_market_price`               TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_description`                TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_button_compare`             TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_button_buy_now`             TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `products_quick_view_show_button_add_to_cart`         TINYINT UNSIGNED NOT NULL DEFAULT 0,

  `product_view_show_image`                             TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_label`                             TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_name`                              TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_rating`                            TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_category`                          TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_manufacturer`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_model`                             TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_price`                             TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_market_price`                      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_button_compare`                    TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_button_write_review`               TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_button_buy_now`                    TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_button_add_to_cart`                TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_description`                       TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_social_buttons`                    TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_parameters`                        TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_shipping_info`                     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_reviews`                           TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `product_view_show_related_products`                  TINYINT UNSIGNED NOT NULL DEFAULT 0,

  `orders_count_in_page`                                INT(16) UNSIGNED NOT NULL,

  `basic`                                               TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `default`                                             TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* usergroups */
DROP TABLE IF EXISTS `#__ecommercewd_usergroups`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_usergroups` (
  `id`          INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(256)     NOT NULL,
  `discount_id` INT(16)          NOT NULL,
  `default`     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* users */
DROP TABLE IF EXISTS `#__ecommercewd_users`;
CREATE TABLE IF NOT EXISTS `#__ecommercewd_users` (
  `id`                 INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
  `j_user_id`          INT(16) UNSIGNED NOT NULL,
  `first_name`         VARCHAR(256)     NOT NULL,
  `middle_name`        VARCHAR(256)     NOT NULL,
  `last_name`          VARCHAR(256)     NOT NULL,
  `company`            VARCHAR(256)     NOT NULL,
  `country_id`         INT(16)          NOT NULL,
  `state`              VARCHAR(256)     NOT NULL,
  `city`               VARCHAR(256)     NOT NULL,
  `address`            VARCHAR(256)     NOT NULL,
  `mobile`             VARCHAR(256)     NOT NULL,
  `phone`              VARCHAR(256)     NOT NULL,
  `fax`                VARCHAR(256)     NOT NULL,
  `zip_code`           VARCHAR(256)     NOT NULL,
  `usergroup_id`       INT(16)          NOT NULL,
  `stripe_customer_id` VARCHAR(256)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


/* insert values */

/* categories */
INSERT INTO `#__ecommercewd_categories` (`id`, `parent_id`, `level`, `name`, `alias`, `description`, `images`, `meta_title`, `meta_description`, `meta_keyword`, `ordering`, `published`) 
  VALUES
  ('', 0, 1, 'Tablets', 'tablets', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '["media/com_ecommercewd/uploads/images/categories/thumb/tablets.jpg"]', '', '', '', 1, 1),
  ('', 0, 1, 'Phones', 'phones', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '["media/com_ecommercewd/uploads/images/categories/thumb/phones.jpg"]', '', '', '', 2, 1);

/* category tags */
INSERT INTO `#__ecommercewd_categorytags` (`category_id`, `tag_id`)
  VALUES
  (1, 3),
  (2, 5);
  
/* labels */
INSERT INTO `#__ecommercewd_labels` (`id`, `name`, `thumb`, `thumb_position`, `published`)
  VALUES
  ('', 'Sale', '["media/com_ecommercewd/uploads/images/labels/thumb/03.png"]', 0, 1),
  ('', 'New', '["media/com_ecommercewd/uploads/images/labels/thumb/01.png"]', 1, 1),
  ('', 'Best Offer', '["media/com_ecommercewd/uploads/images/labels/thumb/02.png"]', 0, 1); 
  
/* manufacturers */
INSERT INTO `#__ecommercewd_manufacturers` (`id`, `name`, `alias`, `logo`, `description`, `site`, `meta_title`, `meta_description`, `meta_keyword`, `published`)
  VALUES
  ('', 'Apple', 'apple', '["media/com_ecommercewd/uploads/images/manufacturers/thumb/apple.jpg"]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', 1),
  ('', 'Samsung', 'samsung', '["media/com_ecommercewd/uploads/images/manufacturers/thumb/samsung.jpg"]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', '', '', 1);
 

  
/* parametertypes*/
INSERT INTO `#__ecommercewd_parametertypes` (`id`, `name`) VALUES
	('', 'Single value'),  
  	('', 'Input'), 
    ('', 'Select'),
    ('', 'Radio'),
    ('', 'Checkbox');  
  

  
/* products */
INSERT INTO `#__ecommercewd_products` (`id`, `name`, `alias`, `category_id`, `manufacturer_id`, `description`, `images`, `tax_id`, `enable_shipping`, `discount_id`, `price`, `market_price`, `amount_in_stock`, `unlimited`, `label_id`, `meta_title`, `meta_description`, `meta_keyword`, `date_added`, `ordering`, `published`)
  VALUES
  ('', 'iPad', 'ipad',1, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '["media/com_ecommercewd/uploads/images/products/ipad/thumb/01.jpg","media/com_ecommercewd/uploads/images/products/ipad/thumb/02.jpg","media/com_ecommercewd/uploads/images/products/ipad/thumb/03.jpg","media/com_ecommercewd/uploads/images/products/ipad/thumb/04.jpg"]', 0, 0, 0, 499.00, 600.00, 0, 1, 1, '', '', '', NOW(), 1, 1),
  ('', 'Samsung Galaxy Note3', 'samsung-galaxy-note3', 2, 2, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '["media/com_ecommercewd/uploads/images/products/note3/thumb/01.jpg","media/com_ecommercewd/uploads/images/products/note3/thumb/02.jpg"]', 0, 0, 0, 400.00, 0.00, 0, 1, 3, '', '', '', NOW(), 2, 1);

/* product tags */
INSERT INTO `#__ecommercewd_producttags` (`product_id`, `tag_id`)
  VALUES
  (1, 2),
  (1, 1),
  (2, 3);
  
/* tags */
INSERT INTO `#__ecommercewd_tags` (`id`, `name`, `ordering`, `published`)
  VALUES
  ('', 'ipad', 2, 1),
  ('', 'tablet', 1, 1),
  ('', 'phone', 3, 1); 

/* currencies */
INSERT INTO `#__ecommercewd_currencies` (`id`, `name`, `code`, `sign`, `sign_position`, `exchange_rate`, `default`)
  VALUES
  ('', 'U.S. Dollar', 'USD', '&#36;', 0, 1.00, 1);

/* payments */
INSERT INTO `#__ecommercewd_payments` (`id`, `tool_id` ,`name`, `short_name`, `base_name`, `ordering`, `options`, `published`)
  VALUES
  ('','', 'Without Online Payment', 'without_online_payment', '',1, '', 1),
  ('', '', 'Paypal Express Checkout','paypalexpress', 'paypal', 2, '{"mode":"","paypal_user":"","paypal_password":"","paypal_signature":""}', 1);
  
 
/* options */
INSERT INTO `#__ecommercewd_options` (`id`, `name`, `value`, `default_value`) VALUES
/* products data options */
('', 'enable_sku', 1, 1),
('', 'enable_upc', 1, 1),
('', 'enable_ean', 1, 1),
('', 'enable_jan', 1, 1),
('', 'enable_isbn', 1, 1),
('', 'enable_mpn', 1, 1),
('', 'weight_unit', 'kg', 'kg'),
('', 'dimensions_unit', 'cm', 'cm'),


/* registration options */
('', 'registration_administrator_email', '', ''),
('', 'registration_captcha_use_captcha', 0, 0),
('', 'registration_captcha_public_key', '', ''),
('', 'registration_captcha_private_key', '', ''),
('', 'registration_captcha_theme', 'white', 'white'),

/* user data fields */
('', 'user_data_middle_name', 1, 1),
('', 'user_data_last_name', 1, 1),
('', 'user_data_company', 1, 1),
('', 'user_data_country', 2, 2),
('', 'user_data_state', 1, 1),
('', 'user_data_city', 1, 1),
('', 'user_data_address', 1, 1),
('', 'user_data_mobile', 1, 1),
('', 'user_data_phone', 1, 1),
('', 'user_data_fax', 1, 1),
('', 'user_data_zip_code', 1, 1),

/* checkout options */
('', 'checkout_enable_checkout', 1, 1),
('', 'checkout_allow_guest_checkout', 1, 1),
('', 'checkout_redirect_to_cart_after_adding_an_item', 0, 0),
('', 'checkout_enable_shipping', 0, 0),

/* customer feedback options */
('', 'feedback_enable_guest_feedback', 1, 1),
('', 'feedback_enable_product_rating', 1, 1),
('', 'feedback_enable_product_reviews', 1, 1),
('', 'feedback_publish_review_when_added', 0, 0),

/* search and sort options */
('', 'search_enable_user_bar', 1, 1),
('', 'search_enable_search', 1, 1),
('', 'search_by_category', 1, 1),
('', 'search_include_subcategories', 1, 1),
('', 'filter_manufacturers', 1, 1),
('', 'filter_price', 1, 1),
('', 'filter_date_added', 1, 1),
('', 'filter_minimum_rating', 1, 1),
('', 'filter_tags', 1, 1),
('', 'sort_by_name', 1, 1),
('', 'sort_by_manufacturer', 1, 1),
('', 'sort_by_price', 1, 1),
('', 'sort_by_count_of_reviews', 1, 1),
('', 'sort_by_rating', 1, 1),

/* social media integration options */
/* share buttons */
('', 'social_media_integration_enable_fb_like_btn', 1, 1),
('', 'social_media_integration_enable_twitter_tweet_btn', 1, 1),
('', 'social_media_integration_enable_g_plus_btn', 1, 1),
/* facebook comments */
('', 'social_media_integration_use_fb_comments', 0, 0),
('', 'social_media_integration_fb_color_scheme', 'light', 'light'),

/* other options */
('', 'option_date_format', 'd/m/Y', 'd/m/Y'),
('', 'option_include_discount_in_price', 1, 1),
('', 'option_include_tax_in_price', 1, 1),
('', 'option_show_decimals', 1, 1);


/* orderstatuses */
INSERT INTO `#__ecommercewd_orderstatuses` (`id`, `name`, `ordering`, `published`, `default`)
  VALUES
  ('', 'Pending', '', 1, 1),
  ('', 'Confirmed by shopper', '', 1, 0),
  ('', 'Confirmed', '', 1, 0),
  ('', 'Cancelled', '', 1, 0),
  ('', 'Refunded', '', 1, 0),
  ('', 'Shipped', '', 1, 0);



/* themes */

INSERT INTO `#__ecommercewd_themes` (`id`, `name`, `rounded_corners`, `content_main_color`, `header_content_color`, `subtext_content_color`, `input_content_color`, `input_bg_color`, `input_border_color`, `input_focus_border_color`, `input_has_error_content_color`, `button_default_content_color`, `button_default_bg_color`, `button_default_border_color`, `button_primary_content_color`, `button_primary_bg_color`, `button_primary_border_color`, `button_success_content_color`, `button_success_bg_color`, `button_success_border_color`, `button_info_content_color`, `button_info_bg_color`, `button_info_border_color`, `button_warning_content_color`, `button_warning_bg_color`, `button_warning_border_color`, `button_danger_content_color`, `button_danger_bg_color`, `button_danger_border_color`, `button_link_content_color`, `divider_color`, `navbar_bg_color`, `navbar_border_color`, `navbar_link_content_color`, `navbar_link_hover_content_color`, `navbar_link_open_content_color`, `navbar_link_open_bg_color`, `navbar_badge_content_color`, `navbar_badge_bg_color`, `navbar_dropdown_link_content_color`, `navbar_dropdown_link_hover_content_color`, `navbar_dropdown_link_hover_background_content_color`, `navbar_dropdown_divider_color`, `navbar_dropdown_background_color`, `navbar_dropdown_border_color`, `modal_backdrop_color`, `modal_bg_color`, `modal_border_color`, `modal_dividers_color`, `panel_user_data_bg_color`, `panel_user_data_border_color`, `panel_user_data_footer_bg_color`, `panel_product_bg_color`, `panel_product_border_color`, `panel_product_footer_bg_color`, `well_bg_color`, `well_border_color`, `rating_star_type`, `rating_star_color`, `rating_star_bg_color`, `label_content_color`, `label_bg_color`, `alert_info_content_color`, `alert_info_bg_color`, `alert_info_border_color`, `alert_danger_content_color`, `alert_danger_bg_color`, `alert_danger_border_color`, `breadcrumb_content_color`, `breadcrumb_bg_color`, `pill_link_content_color`, `pill_link_hover_content_color`, `pill_link_hover_bg_color`, `tab_link_content_color`, `tab_link_hover_content_color`, `tab_link_hover_bg_color`, `tab_link_active_content_color`, `tab_link_active_bg_color`, `tab_border_color`, `pagination_content_color`, `pagination_bg_color`, `pagination_hover_content_color`, `pagination_hover_bg_color`, `pagination_active_content_color`, `pagination_active_bg_color`, `pagination_border_color`, `pager_content_color`, `pager_bg_color`, `pager_border_color`, `product_name_color`, `product_category_color`, `product_manufacturer_color`, `product_price_color`, `product_market_price_color`, `products_filters_position`, `products_count_in_page`, `products_option_columns`, `products_thumbs_view_show_image`, `products_thumbs_view_show_label`, `products_thumbs_view_show_name`, `products_thumbs_view_show_rating`, `products_thumbs_view_show_price`, `products_thumbs_view_show_market_price`, `products_thumbs_view_show_description`, `products_thumbs_view_show_button_quick_view`, `products_thumbs_view_show_button_compare`, `products_thumbs_view_show_button_buy_now`, `products_thumbs_view_show_button_add_to_cart`, `products_list_view_show_image`, `products_list_view_show_label`, `products_list_view_show_name`, `products_list_view_show_rating`, `products_list_view_show_price`, `products_list_view_show_market_price`, `products_list_view_show_description`, `products_list_view_show_button_quick_view`, `products_list_view_show_button_compare`, `products_list_view_show_button_buy_now`, `products_list_view_show_button_add_to_cart`, `products_quick_view_show_image`, `products_quick_view_show_label`, `products_quick_view_show_name`, `products_quick_view_show_rating`, `products_quick_view_show_category`, `products_quick_view_show_manufacturer`,`products_quick_view_show_model`, `products_quick_view_show_price`, `products_quick_view_show_market_price`, `products_quick_view_show_description`, `products_quick_view_show_button_compare`, `products_quick_view_show_button_buy_now`, `products_quick_view_show_button_add_to_cart`, `product_view_show_image`, `product_view_show_label`, `product_view_show_name`, `product_view_show_rating`, `product_view_show_category`, `product_view_show_manufacturer`,`product_view_show_model`, `product_view_show_price`, `product_view_show_market_price`, `product_view_show_button_compare`, `product_view_show_button_write_review`, `product_view_show_button_buy_now`, `product_view_show_button_add_to_cart`, `product_view_show_description`, `product_view_show_social_buttons`, `product_view_show_parameters`, `product_view_show_shipping_info`, `product_view_show_reviews`, `product_view_show_related_products`, `orders_count_in_page`, `basic`, `default`,`product_model_color`,`product_code_color`) VALUES
('', 'Default', 1, '#555555', '#555555', '#999999', '#555555', '#ffffff', '#cccccc', '#66afe9', '#a94442', '#333333', '#ffffff', '#cccccc', '#ffffff', '#428bca', '#357ebd', '#ffffff', '#5cb85c', '#4cae4c', '#ffffff', '#5bc0de', '#46b8da', '#ffffff', '#f0ad4e', '#eea236', '#ffffff', '#d9534f', '#d43f3a', '#428bca', '#eeeeee', '#f8f8f8', '#e7e7e7', '#777777', '#333333', '#555555', '#e7e7e7', '#ffffff', '#d9534f', '#777777', '#ffffff', '#428bca', '#e5e5e5', '#ffffff', '#d9d9d9', '#000000', '#ffffff', '#9f9f9f', '#e5e5e5', '#ffffff', '#dddddd', '#f5f5f5', '#ffffff', '#dddddd', '#f5f5f5', '#f5f5f5', '#e3e3e3', 'star', '#ffcc33', '#dadada', '#ffffff', '#999999', '#31708f', '#d9edf7', '#bce8f1', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#428bca', '#2a6496', '#eeeeee', '#428bca', '#2a6496', '#eeeeee', '#555555', '#ffffff', '#dddddd', '#428bca', '#ffffff', '#2a6496', '#eeeeee', '#ffffff', '#428bca', '#dddddd', '#428bca', '#ffffff', '#dddddd', '#00568d', '#808080', '#808080', '#8d0000', '#808080', 1, 12, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 12, 1, 0, '#808080', '#808080'),
('', 'Theme 1', 1, '#555555', '#555555', '#999999', '#555555', '#ffffff', '#cccccc', '#66afe9', '#a94442', '#333333', '#ffffff', '#cccccc', '#ffffff', '#428bca', '#357ebd', '#ffffff', '#5cb85c', '#4cae4c', '#ffffff', '#5bc0de', '#46b8da', '#ffffff', '#f0ad4e', '#eea236', '#ffffff', '#d9534f', '#d43f3a', '#428bca', '#eeeeee', '#f8f8f8', '#e7e7e7', '#777777', '#333333', '#555555', '#e7e7e7', '#ffffff', '#d9534f', '#777777', '#ffffff', '#428bca', '#e5e5e5', '#ffffff', '#d9d9d9', '#000000', '#ffffff', '#9f9f9f', '#e5e5e5', '#ffffff', '#dddddd', '#f5f5f5', '#ffffff', '#dddddd', '#f5f5f5', '#f5f5f5', '#e3e3e3', 'star', '#ffcc33', '#dadada', '#ffffff', '#999999', '#31708f', '#d9edf7', '#bce8f1', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#428bca', '#2a6496', '#eeeeee', '#428bca', '#2a6496', '#eeeeee', '#555555', '#ffffff', '#dddddd', '#428bca', '#ffffff', '#2a6496', '#eeeeee', '#ffffff', '#428bca', '#dddddd', '#428bca', '#ffffff', '#dddddd', '#00568d', '#808080', '#808080', '#8d0000', '#808080', 1, 12, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 12, 0, 1, '#808080', '#808080'),
('', 'Theme 2', 1, '#000000', '#000000', '#cccccc', '#cccccc', '#ffffff', '#e0e0e0', '#4cae4c', '#630707', '#333333', '#ffffff', '#cccccc', '#ffffff', '#4cae4c', '#4cae4c', '#ffffff', '#428bca', '#428bca', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#368c36', '#cccccc', '#f8f8f8', '#e0e0e0', '#000000', '#000000', '#555555', '#e0e0e0', '#ffffff', '#4cae4c', '#000000', '#ffffff', '#4cae4c', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star-empty', '#ffcc33', '#dadada', '#ffffff', '#999999', '#368c36', '#def7de', '#c9f2c9', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#4cae4c', '#4cae4c', '#eeeeee', '#4cae4c', '#4cae4c', '#eeeeee', '#000000', '#ffffff', '#dddddd', '#4cae4c', '#ffffff', '#368c36', '#eeeeee', '#ffffff', '#4cae4c', '#dddddd', '#368c36', '#ffffff', '#dddddd', '#000000', '#808080', '#808080', '#368c36', '#808080', 1, 12, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,  1, 1, 1, 1, 1, 1, 1, 1, 1, 12, 0, 0, '#808080', '#808080'),
('', 'Theme 3', 1, '#9c9c9c', '#5c5c5c', '#cccccc', '#cccccc', '#ffffff', '#e0e0e0', '#d9d9d9', '#630707', '#000000', '#ffffff', '#e0e0e0', '#ffffff', '#e6a500', '#d99c00', '#ffffff', '#428bca', '#428bca', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#d99c00', '#e8e5e8', '#f8f8f8', '#e0e0e0', '#000000', '#000000', '#555555', '#e0e0e0', '#ffffff', '#a94442', '#000000', '#ffffff', '#e6a500', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star-empty', '#6bc6ff', '#e0e0e0', '#ffffff', '#999999', '#428bca', '#d2e8fc', '#b8d8f5', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#e6a500', '#d99c00', '#eeeeee', '#e6a500', '#d99c00', '#eeeeee', '#000000', '#ffffff', '#e0e0e0', '#000000', '#ffffff', '#000000', '#eeeeee', '#ffffff', '#e6a500', '#e0e0e0', '#000000', '#ffffff', '#e0e0e0', '#d49904', '#808080', '#808080', '#000000', '#808080', 1, 12, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,  1, 1, 1, 1, 1, 1, 1, 1, 1, 12, 0, 0, '#808080', '#808080'),
('', 'Theme 4', 1, '#9c9c9c', '#000000', '#949494', '#cccccc', '#ffffff', '#e0e0e0', '#d9d9d9', '#e60000', '#000000', '#ffffff', '#949494', '#ffffff', '#a80303', '#990303', '#ffffff', '#424242', '#000000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#990303', '#e8e5e8', '#f8f8f8', '#e0e0e0', '#000000', '#000000', '#555555', '#e0e0e0', '#ffffff', '#a80303', '#000000', '#ffffff', '#a80303', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star', '#ffd56b', '#e0e0e0', '#ffffff', '#999999', '#428bca', '#d2e8fc', '#b8d8f5', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#a94442', '#990303', '#eeeeee', '#000000', '#878787', '#eeeeee', '#000000', '#ffffff', '#e0e0e0', '#000000', '#ffffff', '#000000', '#eeeeee', '#ffffff', '#000000', '#e0e0e0', '#000000', '#ffffff', '#e0e0e0', '#000000', '#808080', '#808080', '#a94442', '#808080', 1, 12, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 12, 0, 0, '#808080', '#808080'),
('', 'Theme 5', 1, '#9c9c9c', '#000000', '#949494', '#cccccc', '#ffffff', '#e0e0e0', '#d9d9d9', '#e60000', '#000000', '#f0f0f0', '#949494', '#ffffff', '#45343d', '#402d37', '#ffffff', '#424242', '#000000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#402d37', '#e8e5e8', '#f8f8f8', '#e0e0e0', '#737373', '#737373', '#555555', '#e0e0e0', '#ffffff', '#a80303', '#000000', '#ffffff', '#45343d', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star', '#ffd56b', '#e0e0e0', '#ffffff', '#999999', '#428bca', '#d2e8fc', '#b8d8f5', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#45343d', '#402d37', '#eeeeee', '#000000', '#878787', '#eeeeee', '#45343d', '#f2f2f2', '#e0e0e0', '#000000', '#ffffff', '#000000', '#eeeeee', '#ffffff', '#45343d', '#e0e0e0', '#45343d', '#eeeeee', '#e0e0e0', '#45343d', '#808080', '#808080', '#ab0300', '#808080', 1, 12, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 12, 0, 0, '#808080', '#808080');


/* usergroups */
INSERT INTO `#__ecommercewd_usergroups` (`id`, `name`, `discount_id`, `default`)
  VALUES
  ('', 'Default usergroup', '', 1);
 
/* countries */
INSERT INTO `#__ecommercewd_countries` (`id`, `code` ,`name`, `published` )
 VALUES
 ('', 'US', 'United States',1),
 ('', 'CA', 'Canada',1),
 ('', 'AF', 'Afghanistan',''),
 ('', 'AL', 'Albania',''),
 ('', 'DZ', 'Algeria',''),
 ('', 'DS', 'American Samoa',''),
 ('', 'AD', 'Andorra',''),
 ('', 'AO', 'Angola',''),
 ('', 'AI', 'Anguilla',''),
 ('', 'AQ', 'Antarctica',''),
 ('', 'AG', 'Antigua and/or Barbuda',''),
 ('', 'AR', 'Argentina',''),
 ('', 'AM', 'Armenia',1),
 ('', 'AW', 'Aruba',''),
 ('', 'AU', 'Australia',''),
 ('', 'AT', 'Austria',''),
 ('', 'AZ', 'Azerbaijan',''),
 ('', 'BS', 'Bahamas',''),
 ('', 'BH', 'Bahrain',''),
 ('', 'BD', 'Bangladesh',''),
 ('', 'BB', 'Barbados',''),
 ('', 'BY', 'Belarus',''),
 ('', 'BE', 'Belgium',1),
 ('', 'BZ', 'Belize',''),
 ('', 'BJ', 'Benin',''),
 ('', 'BM', 'Bermuda',''),
 ('', 'BT', 'Bhutan',''),
 ('', 'BO', 'Bolivia',''),
 ('', 'BA', 'Bosnia and Herzegovina',''),
 ('', 'BW', 'Botswana',''),
 ('', 'BV', 'Bouvet Island',''),
 ('', 'BR', 'Brazil',''),
 ('', 'IO', 'British lndian Ocean Territory',''),
 ('', 'BN', 'Brunei Darussalam',''),
 ('', 'BG', 'Bulgaria',''),
 ('', 'BF', 'Burkina Faso',''),
 ('', 'BI', 'Burundi',''),
 ('', 'KH', 'Cambodia',''),
 ('', 'CM', 'Cameroon',''),
 ('', 'CV', 'Cape Verde',''),
 ('', 'KY', 'Cayman Islands',''),
 ('', 'CF', 'Central African Republic',''),
 ('', 'TD', 'Chad',''),
 ('', 'CL', 'Chile',''),
 ('', 'CN', 'China',1),
 ('', 'CX', 'Christmas Island',''),
 ('', 'CC', 'Cocos (Keeling) Islands',''),
 ('', 'CO', 'Colombia',''),
 ('', 'KM', 'Comoros',''),
 ('', 'CG', 'Congo',''),
 ('', 'CK', 'Cook Islands',''),
 ('', 'CR', 'Costa Rica',''),
 ('', 'HR', 'Croatia (Hrvatska)',''),
 ('', 'CU', 'Cuba',''),
 ('', 'CY', 'Cyprus',''),
 ('', 'CZ', 'Czech Republic',''),
 ('', 'DK', 'Denmark',1),
 ('', 'DJ', 'Djibouti',''),
 ('', 'DM', 'Dominica',''),
 ('', 'DO', 'Dominican Republic',''),
 ('', 'TP', 'East Timor',''),
 ('', 'EC', 'Ecuador',''),
 ('', 'EG', 'Egypt',''),
 ('', 'SV', 'El Salvador',''),
 ('', 'GQ', 'Equatorial Guinea',''),
 ('', 'ER', 'Eritrea',''),
 ('', 'EE', 'Estonia',''),
 ('', 'ET', 'Ethiopia',''),
 ('', 'FK', 'Falkland Islands (Malvinas)',''),
 ('', 'FO', 'Faroe Islands',''),
 ('', 'FJ', 'Fiji',''),
 ('', 'FI', 'Finland',''),
 ('', 'FR', 'France',1),
 ('', 'FX', 'France, Metropolitan',''),
 ('', 'GF', 'French Guiana',''),
 ('', 'PF', 'French Polynesia',''),
 ('', 'TF', 'French Southern Territories',''),
 ('', 'GA', 'Gabon',''),
 ('', 'GM', 'Gambia',''),
 ('', 'GE', 'Georgia',''),
 ('', 'DE', 'Germany',1),
 ('', 'GH', 'Ghana',''),
 ('', 'GI', 'Gibraltar',''),
 ('', 'GR', 'Greece',''),
 ('', 'GL', 'Greenland',''),
 ('', 'GD', 'Grenada',''),
 ('', 'GP', 'Guadeloupe',''),
 ('', 'GU', 'Guam',''),
 ('', 'GT', 'Guatemala',''),
 ('', 'GN', 'Guinea',''),
 ('', 'GW', 'Guinea-Bissau',''),
 ('', 'GY', 'Guyana',''),
 ('', 'HT', 'Haiti',''),
 ('', 'HM', 'Heard and Mc Donald Islands',''),
 ('', 'HN', 'Honduras',''),
 ('', 'HK', 'Hong Kong',''),
 ('', 'HU', 'Hungary',''),
 ('', 'IS', 'Iceland',''),
 ('', 'IN', 'India',''),
 ('', 'ID', 'Indonesia',''),
 ('', 'IR', 'Iran (Republic of Islamic)',''),
 ('', 'IQ', 'Iraq',''),
 ('', 'IE', 'Ireland',''),
 ('', 'IL', 'Israel',''),
 ('', 'IT', 'Italy',1),
 ('', 'CI', 'Ivory Coast',''),
 ('', 'JM', 'Jamaica',''),
 ('', 'JP', 'Japan',1),
 ('', 'JO', 'Jordan',''),
 ('', 'KZ', 'Kazakhstan',''),
 ('', 'KE', 'Kenya',''),
 ('', 'KI', 'Kiribati',''),
 ('', 'KP', 'Democratic People''s Republic of Korea',''),
 ('', 'KR', 'Republic of Korea',''),
 ('', 'XK', 'Kosovo',''),
 ('', 'KW', 'Kuwait',''),
 ('', 'KG', 'Kyrgyzstan',''),
 ('', 'LA', 'Lao People''s Democratic Republic',''),
 ('', 'LV', 'Latvia',''),
 ('', 'LB', 'Lebanon',''),
 ('', 'LS', 'Lesotho',''),
 ('', 'LR', 'Liberia',''),
 ('', 'LY', 'Libyan Arab Jamahiriya',''),
 ('', 'LI', 'Liechtenstein',''),
 ('', 'LT', 'Lithuania',''),
 ('', 'LU', 'Luxembourg',''),
 ('', 'MO', 'Macau',''),
 ('', 'MK', 'Macedonia',''),
 ('', 'MG', 'Madagascar',''),
 ('', 'MW', 'Malawi',''),
 ('', 'MY', 'Malaysia',''),
 ('', 'MV', 'Maldives',''),
 ('', 'ML', 'Mali',''),
 ('', 'MT', 'Malta',''),
 ('', 'MH', 'Marshall Islands',''),
 ('', 'MQ', 'Martinique',''),
 ('', 'MR', 'Mauritania',''),
 ('', 'MU', 'Mauritius',''),
 ('', 'TY', 'Mayotte',''),
 ('', 'MX', 'Mexico',''),
 ('', 'FM', 'Federated States of Micronesia',''),
 ('', 'MD', 'Moldova',''),
 ('', 'MC', 'Monaco',''),
 ('', 'MN', 'Mongolia',''),
 ('', 'ME', 'Montenegro',''),
 ('', 'MS', 'Montserrat',''),
 ('', 'MA', 'Morocco',''),
 ('', 'MZ', 'Mozambique',''),
 ('', 'MM', 'Myanmar',''),
 ('', 'NA', 'Namibia',''),
 ('', 'NR', 'Nauru',''),
 ('', 'NP', 'Nepal',''),
 ('', 'NL', 'Netherlands',1),
 ('', 'AN', 'Netherlands Antilles',''),
 ('', 'NC', 'New Caledonia',''),
 ('', 'NZ', 'New Zealand',''),
 ('', 'NI', 'Nicaragua',''),
 ('', 'NE', 'Niger',''),
 ('', 'NG', 'Nigeria',''),
 ('', 'NU', 'Niue',''),
 ('', 'NF', 'Norfork Island',''),
 ('', 'MP', 'Northern Mariana Islands',''),
 ('', 'NO', 'Norway',''),
 ('', 'OM', 'Oman',''),
 ('', 'PK', 'Pakistan',''),
 ('', 'PW', 'Palau',''),
 ('', 'PA', 'Panama',''),
 ('', 'PG', 'Papua New Guinea',''),
 ('', 'PY', 'Paraguay',''),
 ('', 'PE', 'Peru',''),
 ('', 'PH', 'Philippines',''),
 ('', 'PN', 'Pitcairn',''),
 ('', 'PL', 'Poland',''),
 ('', 'PT', 'Portugal',''),
 ('', 'PR', 'Puerto Rico',''),
 ('', 'QA', 'Qatar',''),
 ('', 'RE', 'Reunion',''),
 ('', 'RO', 'Romania',''),
 ('', 'RU', 'Russian Federation',''),
 ('', 'RW', 'Rwanda',''),
 ('', 'KN', 'Saint Kitts and Nevis',''),
 ('', 'LC', 'Saint Lucia',''),
 ('', 'VC', 'Saint Vincent and the Grenadines',''),
 ('', 'WS', 'Samoa',''),
 ('', 'SM', 'San Marino',''),
 ('', 'ST', 'Sao Tome and Principe',''),
 ('', 'SA', 'Saudi Arabia',''),
 ('', 'SN', 'Senegal',''),
 ('', 'RS', 'Serbia',''),
 ('', 'SC', 'Seychelles',''),
 ('', 'SL', 'Sierra Leone',''),
 ('', 'SG', 'Singapore',''),
 ('', 'SK', 'Slovakia',''),
 ('', 'SI', 'Slovenia',''),
 ('', 'SB', 'Solomon Islands',''),
 ('', 'SO', 'Somalia',''),
 ('', 'ZA', 'South Africa',''),
 ('', 'GS', 'South Georgia South Sandwich Islands',''),
 ('', 'ES', 'Spain',1),
 ('', 'LK', 'Sri Lanka',''),
 ('', 'SH', 'St. Helena',''),
 ('', 'PM', 'St. Pierre and Miquelon',''),
 ('', 'SD', 'Sudan',''),
 ('', 'SR', 'Suriname',''),
 ('', 'SJ', 'Svalbarn and Jan Mayen Islands',''),
 ('', 'SZ', 'Swaziland',1),
 ('', 'SE', 'Sweden',1),
 ('', 'CH', 'Switzerland',''),
 ('', 'SY', 'Syrian Arab Republic',''),
 ('', 'TW', 'Taiwan',''),
 ('', 'TJ', 'Tajikistan',''),
 ('', 'TZ', 'Tanzania, United Republic of',''),
 ('', 'TH', 'Thailand',''),
 ('', 'TG', 'Togo',''),
 ('', 'TK', 'Tokelau',''),
 ('', 'TO', 'Tonga',''),
 ('', 'TT', 'Trinidad and Tobago',''),
 ('', 'TN', 'Tunisia',''),
 ('', 'TR', 'Turkey',''),
 ('', 'TM', 'Turkmenistan',''),
 ('', 'TC', 'Turks and Caicos Islands',''),
 ('', 'TV', 'Tuvalu',''),
 ('', 'UG', 'Uganda',''),
 ('', 'UA', 'Ukraine',''),
 ('', 'AE', 'United Arab Emirates',''),
 ('', 'GB', 'United Kingdom',1),
 ('', 'UM', 'United States minor outlying islands',''),
 ('', 'UY', 'Uruguay',''),
 ('', 'UZ', 'Uzbekistan',''),
 ('', 'VU', 'Vanuatu',''),
 ('', 'VA', 'Vatican City State',''),
 ('', 'VE', 'Venezuela',''),
 ('', 'VN', 'Vietnam',''),
 ('', 'VG', 'Virigan Islands (British)',''),
 ('', 'VI', 'Virgin Islands (U.S.)',''),
 ('', 'WF', 'Wallis and Futuna Islands',''),
 ('', 'EH', 'Western Sahara',''),
 ('', 'YE', 'Yemen',''),
 ('', 'YU', 'Yugoslavia',''),
 ('', 'ZR', 'Zaire',''),
 ('', 'ZM', 'Zambia',''),
 ('', 'ZW', 'Zimbabwe','');
