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

$tab_link_content_color = $theme->tab_link_content_color;
$tab_link_hover_content_color = $theme->tab_link_hover_content_color;
$tab_link_hover_bg_color = $theme->tab_link_hover_bg_color;
$tab_link_active_content_color = $theme->tab_link_active_content_color;
$tab_link_active_bg_color = $theme->tab_link_active_bg_color;
$tab_border_color = $theme->tab_border_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* TAB */
        <?php echo $prefix; ?>
        .nav-tabs {
            border-bottom-color: <?php echo $tab_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .nav-tabs > li > a {
            color: <?php echo $tab_link_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .nav-tabs > li > a:hover {
            color: <?php echo $tab_link_hover_content_color; ?>;
            background-color: <?php echo $tab_link_hover_bg_color; ?>;
            border-color: <?php echo $tab_link_hover_bg_color . ' ' . $tab_link_hover_bg_color . ' ' . $tab_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .nav-tabs > li.active > a,
        <?php echo $prefix; ?> .nav-tabs > li.active > a:hover,
        <?php echo $prefix; ?> .nav-tabs > li.active > a:focus {
            color: <?php echo $tab_link_active_content_color; ?>;
            background-color: <?php echo $tab_link_active_bg_color; ?>;
            border-color: <?php echo $tab_border_color; ?>;
            border-bottom-color: transparent;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
