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

$header_content_color = $theme->header_content_color;
$header_border_color = WDFColorUtils::color_to_rgba($theme->header_content_color);
$header_border_color['a'] = 0.15;
$header_border_color = WDFColorUtils::color_to_rgba($header_border_color, true);

$subtext_content_color = $theme->subtext_content_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* HEADER */
        <?php echo $prefix; ?>
        .wd_shop_header {
            color: <?php echo $header_content_color; ?>;
            border-bottom-color: <?php echo $header_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .wd_shop_header_sm {
            color: <?php echo $header_content_color; ?>;
            border-bottom-color: <?php echo $header_border_color; ?>;
        }

        /* SUBTEXT */
        <?php echo $prefix; ?>
        small {
            color: <?php echo $subtext_content_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
