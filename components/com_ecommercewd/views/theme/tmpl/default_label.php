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

$label_content_color = $theme->label_content_color;
$label_bg_color = $theme->label_bg_color;
$label_bg_hover_color = WDFColorUtils::adjust_brightness($label_bg_color, -10);

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* LABEL */
        <?php echo $prefix; ?>
        .label-default {
            color: <?php echo $label_content_color; ?>;
            background-color: <?php echo $label_bg_color; ?>;
        }

        <?php echo $prefix; ?>
        .label-default[href]:hover,
        <?php echo $prefix; ?> .label-default[href]:focus {
            background-color: <?php echo $label_bg_hover_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
