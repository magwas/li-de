<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$prefix = $this->prefix;
$theme = $this->theme;

$product_name_color = $theme->product_name_color;
$product_category_color = $theme->product_category_color;
$product_manufacturer_color = $theme->product_manufacturer_color;
$product_price_color = $theme->product_price_color;
$product_market_price_color = $theme->product_market_price_color;
$product_model_color = $theme->product_model_color;
$product_codes_color = $theme->product_code_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* PRODUCT */
        <?php echo $prefix; ?>
        .wd_shop_product_name,
        <?php echo $prefix; ?> .wd_shop_product_name:hover,
        <?php echo $prefix; ?> .wd_shop_product_name:focus,
        <?php echo $prefix; ?> .wd_shop_product_name.disabled,
        <?php echo $prefix; ?> .wd_shop_product_name[disabled],
        <?php echo $prefix; ?> .wd_shop_product_name.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_name[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_name.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_name[disabled]:focus {
            color: <?php echo $product_name_color; ?>;
        }

        <?php echo $prefix; ?>
        .wd_shop_product_category,
        <?php echo $prefix; ?> .wd_shop_product_category:hover,
        <?php echo $prefix; ?> .wd_shop_product_category:focus,
        <?php echo $prefix; ?> .wd_shop_product_category.disabled,
        <?php echo $prefix; ?> .wd_shop_product_category[disabled],
        <?php echo $prefix; ?> .wd_shop_product_category.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_category[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_category.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_category[disabled]:focus {
            color: <?php echo $product_category_color; ?>;
        }
		
		<?php echo $prefix; ?>
        .wd_shop_product_category_name,
        <?php echo $prefix; ?> .wd_shop_product_category_name:hover,
        <?php echo $prefix; ?> .wd_shop_product_category_name:focus,
        <?php echo $prefix; ?> .wd_shop_product_category_name.disabled,
        <?php echo $prefix; ?> .wd_shop_product_category_name[disabled],
        <?php echo $prefix; ?> .wd_shop_product_category_name.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_category_name[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_category_name.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_category_name[disabled]:focus {
            color: <?php echo $product_category_color; ?>;
        }
        <?php echo $prefix; ?>
        .wd_shop_product_manufacturer,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer:hover,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer:focus,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer.disabled,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer[disabled],
        <?php echo $prefix; ?> .wd_shop_product_manufacturer.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer[disabled]:focus {
            color: <?php echo $product_manufacturer_color; ?>;
        }
		
        <?php echo $prefix; ?>
        .wd_shop_product_manufacturer_name,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name:hover,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name:focus,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name.disabled,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name[disabled],
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_manufacturer_name[disabled]:focus {
            color: <?php echo $product_manufacturer_color; ?>;
        }

        <?php echo $prefix; ?>
        .wd_shop_product_price,
        <?php echo $prefix; ?> .wd_shop_product_price:hover,
        <?php echo $prefix; ?> .wd_shop_product_price:focus,
        <?php echo $prefix; ?> .wd_shop_product_price.disabled,
        <?php echo $prefix; ?> .wd_shop_product_price[disabled],
        <?php echo $prefix; ?> .wd_shop_product_price.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_price[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_price.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_price[disabled]:focus {
            color: <?php echo $product_price_color; ?>;
        }

        <?php echo $prefix; ?>
        .wd_shop_product_market_price,
        <?php echo $prefix; ?> .wd_shop_product_market_price:hover,
        <?php echo $prefix; ?> .wd_shop_product_market_price:focus,
        <?php echo $prefix; ?> .wd_shop_product_market_price.disabled,
        <?php echo $prefix; ?> .wd_shop_product_market_price[disabled],
        <?php echo $prefix; ?> .wd_shop_product_market_price.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_market_price[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_market_price.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_market_price[disabled]:focus {
            color: <?php echo $product_market_price_color; ?>;
        }
		
		<?php echo $prefix; ?>
        .wd_shop_product_model,
        <?php echo $prefix; ?> .wd_shop_product_model:hover,
        <?php echo $prefix; ?> .wd_shop_product_model:focus,
        <?php echo $prefix; ?> .wd_shop_product_model.disabled,
        <?php echo $prefix; ?> .wd_shop_product_model[disabled],
        <?php echo $prefix; ?> .wd_shop_product_model.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_model[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_model.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_model[disabled]:focus {
            color: <?php echo $product_model_color; ?>;
        }
		
		<?php echo $prefix; ?>
        .wd_shop_product_model_name,
        <?php echo $prefix; ?> .wd_shop_product_model_name:hover,
        <?php echo $prefix; ?> .wd_shop_product_model_name:focus,
        <?php echo $prefix; ?> .wd_shop_product_model_name.disabled,
        <?php echo $prefix; ?> .wd_shop_product_model_name[disabled],
        <?php echo $prefix; ?> .wd_shop_product_model_name.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_model_name[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_model_name.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_model_name[disabled]:focus {
            color: <?php echo $product_model_color; ?>;
        }
		
		<?php echo $prefix; ?>
        .wd_shop_product_codes,
        <?php echo $prefix; ?> .wd_shop_product_codes:hover,
        <?php echo $prefix; ?> .wd_shop_product_codes:focus,
        <?php echo $prefix; ?> .wd_shop_product_codes.disabled,
        <?php echo $prefix; ?> .wd_shop_product_codes[disabled],
        <?php echo $prefix; ?> .wd_shop_product_codes.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_codes[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_codes.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_codes[disabled]:focus {
            color: <?php echo $product_codes_color; ?>;
        }
		
		<?php echo $prefix; ?>
        .wd_shop_product_codes_name,
        <?php echo $prefix; ?> .wd_shop_product_codes_name:hover,
        <?php echo $prefix; ?> .wd_shop_product_codes_name:focus,
        <?php echo $prefix; ?> .wd_shop_product_codes_name.disabled,
        <?php echo $prefix; ?> .wd_shop_product_codes_name[disabled],
        <?php echo $prefix; ?> .wd_shop_product_codes_name.disabled:hover,
        <?php echo $prefix; ?> .wd_shop_product_codes_name[disabled]:hover,
        <?php echo $prefix; ?> .wd_shop_product_codes_name.disabled:focus,
        <?php echo $prefix; ?> .wd_shop_product_codes_name[disabled]:focus {
            color: <?php echo $product_codes_color; ?>;
        }		
		
		
        <?php ob_start(); ?>
    </style>
<?php ob_clean();
