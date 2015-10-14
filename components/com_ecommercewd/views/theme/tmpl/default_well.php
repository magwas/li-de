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

$well_bg_color = $theme->well_bg_color;
$well_border_color = $theme->well_border_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* WELL */
        <?php echo $prefix; ?>
        .well {
            background-color: <?php echo $well_bg_color; ?>;
            border-color: <?php echo $well_border_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
