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

$breadcrumb_content_color = $theme->breadcrumb_content_color;
$breadcrumb_bg_color = $theme->breadcrumb_bg_color;
$breadcrumb_active_content_color = WDFColorUtils::adjust_brightness($breadcrumb_bg_color, 8);

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* BREADCRUMB */
        <?php echo $prefix; ?>
        .breadcrumb {
            background-color: <?php echo $breadcrumb_bg_color; ?>;
        }

        <?php echo $prefix; ?>
        .breadcrumb > li + li:before {
            color: <?php echo $breadcrumb_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .breadcrumb > li {
            color: <?php echo $breadcrumb_content_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
