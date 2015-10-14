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

$rounded_corners = $theme->rounded_corners;
$content_main_color = $theme->content_main_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* ROUNDED CORNERS */
        <?php if ($rounded_corners == 0) { ?>
        <?php echo $prefix; ?>
        * {
            -moz-border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
            -khtml-border-radius: 0 !important;
            border-radius: 0 !important;
        }

        <?php } ?>

        /* CONTENT MAIN COLOR */
        <?php echo $prefix; ?>
        ,
        <?php echo $prefix; ?>
        h1,
        <?php echo $prefix; ?> h2,
        <?php echo $prefix; ?> h3,
        <?php echo $prefix; ?> h4,
        <?php echo $prefix; ?> h5,
        <?php echo $prefix; ?> h6 {
            color: <?php echo $content_main_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
