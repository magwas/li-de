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

$alert_info_content_color = $theme->alert_info_content_color;
$alert_info_bg_color = $theme->alert_info_bg_color;
$alert_info_border_color = $theme->alert_info_border_color;
$alert_info_link_color = WDFColorUtils::adjust_brightness($theme->alert_info_border_color, -15);

$alert_danger_content_color = $theme->alert_danger_content_color;
$alert_danger_bg_color = $theme->alert_danger_bg_color;
$alert_danger_border_color = $theme->alert_danger_border_color;
$alert_danger_link_color = WDFColorUtils::adjust_brightness($theme->alert_danger_border_color, -15);

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* ALERT */
        /* info */
        <?php echo $prefix; ?>
        .alert-info {
            color: <?php echo $alert_info_content_color; ?>;
            background-color: <?php echo $alert_info_bg_color; ?>;
            border-color: <?php echo $alert_info_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .alert-info * {
            color: <?php echo $alert_info_content_color; ?>;
            border-color: <?php echo $alert_info_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .alert-info .alert-link {
            color: <?php echo $alert_info_link_color; ?>;
        }

        /* danger */
        <?php echo $prefix; ?>
        .alert-danger {
            color: <?php echo $alert_danger_content_color; ?>;
            background-color: <?php echo $alert_danger_bg_color; ?>;
            border-color: <?php echo $alert_danger_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .alert-danger * {
            color: <?php echo $alert_danger_content_color; ?>;
            border-color: <?php echo $alert_danger_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .alert-danger .alert-link {
            color: <?php echo $alert_danger_link_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
