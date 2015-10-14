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

$pill_link_content_color = $theme->pill_link_content_color;
$pill_link_hover_content_color = $theme->pill_link_hover_content_color;
$pill_link_hover_bg_color = $theme->pill_link_hover_bg_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* PILLS */
        <?php echo $prefix; ?>
        .nav-pills > li > a {
            color: <?php echo $pill_link_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .nav-pills > li > a:hover,
        <?php echo $prefix; ?> .nav-pills > li > a:focus {
            color: <?php echo $pill_link_hover_content_color; ?>;
            background-color: <?php echo $pill_link_hover_bg_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
