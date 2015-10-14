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

$divider_color = $theme->divider_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* DIVIDER */
        <?php echo $prefix; ?>
        .wd_divider {
            background-color: <?php echo $divider_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
