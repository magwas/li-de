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

$panel_user_data_bg_color = $theme->panel_user_data_bg_color;
$panel_user_data_border_color = $theme->panel_user_data_border_color;
$panel_user_data_footer_bg_color = $theme->panel_user_data_footer_bg_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* PANEL USER DATA */
        <?php echo $prefix; ?>
        .panel.wd_shop_panel_user_data {
            background-color: <?php echo $panel_user_data_bg_color; ?>;
            border-color: <?php echo $panel_user_data_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .wd_shop_panel_user_data .panel-footer {
            background-color: <?php echo $panel_user_data_footer_bg_color; ?>;
            border-top-color: <?php echo $panel_user_data_border_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
