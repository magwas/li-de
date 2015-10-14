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

$navbar_bg_color = $theme->navbar_bg_color;
$navbar_border_color = $theme->navbar_border_color;
$navbar_link_content_color = $theme->navbar_link_content_color;
$navbar_link_hover_content_color = $theme->navbar_link_hover_content_color;
$navbar_link_open_content_color = $theme->navbar_link_open_content_color;
$navbar_link_open_bg_color = $theme->navbar_link_open_bg_color;
$navbar_badge_content_color = $theme->navbar_badge_content_color;
$navbar_badge_bg_color = $theme->navbar_badge_bg_color;
$navbar_dropdown_link_content_color = $theme->navbar_dropdown_link_content_color;
$navbar_dropdown_link_hover_content_color = $theme->navbar_dropdown_link_hover_content_color;
$navbar_dropdown_link_hover_background_content_color = $theme->navbar_dropdown_link_hover_background_content_color;
$navbar_dropdown_divider_color = $theme->navbar_dropdown_divider_color;
$navbar_dropdown_background_color = $theme->navbar_dropdown_background_color;
$navbar_dropdown_border_color = $theme->navbar_dropdown_border_color;

ob_start(); ?>
    <style>
        <?php ob_clean(); ?>

        /* NAVBAR */
        <?php echo $prefix; ?>
        .navbar-default {
            background-color: <?php echo $navbar_bg_color; ?>;
            border-color: <?php echo $navbar_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav > li > a {
            color: <?php echo $navbar_link_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav > li > a .caret {
            border-top-color: <?php echo $navbar_link_content_color; ?>;
            border-bottom-color: <?php echo $navbar_link_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav > li > a:hover,
        <?php echo $prefix; ?> .navbar-default .navbar-nav > li > a:focus {
            color: <?php echo $navbar_link_hover_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav > li > a:hover .caret,
        <?php echo $prefix; ?> .navbar-default .navbar-nav > li > a:focus .caret {
            border-top-color: <?php echo $navbar_link_hover_content_color; ?>;
            border-bottom-color: <?php echo $navbar_link_hover_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav > .open > a,
        <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:hover,
        <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:focus {
            color: <?php echo $navbar_link_open_content_color; ?>;
            background-color: <?php echo $navbar_link_open_bg_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav > .open > a .caret,
        <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:hover .caret,
        <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:focus .caret {
            border-top-color: <?php echo $navbar_link_open_content_color; ?>;
            border-bottom-color: <?php echo $navbar_link_open_content_color; ?>;
        }

        /* badge */
        <?php echo $prefix; ?>
        .badge {
            color: <?php echo $navbar_badge_content_color; ?>;
            background-color: <?php echo $navbar_badge_bg_color; ?>;
        }

        /* navbar dropdown */
        <?php echo $prefix; ?>
        .navbar-default .navbar-nav .open .bs_dropdown-menu {
            background-color: <?php echo $navbar_dropdown_background_color; ?>;
            border-color: <?php echo $navbar_dropdown_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav .open .bs_dropdown-menu > li.divider {
            background-color: <?php echo $navbar_dropdown_divider_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav .open .bs_dropdown-menu > li > a {
            color: <?php echo $navbar_dropdown_link_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .navbar-default .navbar-nav .open .bs_dropdown-menu > li > a:hover,
        <?php echo $prefix; ?> .navbar-default .navbar-nav .open .bs_dropdown-menu > li > a:focus {
            color: <?php echo $navbar_dropdown_link_hover_content_color; ?>;
            background-color: <?php echo $navbar_dropdown_link_hover_background_content_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
