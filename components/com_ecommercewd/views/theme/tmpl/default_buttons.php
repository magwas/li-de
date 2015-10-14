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

// button info
$button_default_content_color = $theme->button_default_content_color;
$button_default_bg_color = $theme->button_default_bg_color;
$button_default_border_color = $theme->button_default_border_color;
$button_default_hover_content_color = $theme->button_default_content_color;
$button_default_hover_bg_color = WDFColorUtils::adjust_brightness($theme->button_default_bg_color, -8);
$button_default_hover_border_color = WDFColorUtils::adjust_brightness($theme->button_default_border_color, -12);
$button_default_disabled_bg_color = $theme->button_default_bg_color;
$button_default_disabled_border_color = $theme->button_default_border_color;

// button primary
$button_primary_content_color = $theme->button_primary_content_color;
$button_primary_bg_color = $theme->button_primary_bg_color;
$button_primary_border_color = $theme->button_primary_border_color;
$button_primary_hover_content_color = $theme->button_primary_content_color;
$button_primary_hover_bg_color = WDFColorUtils::adjust_brightness($theme->button_primary_bg_color, -8);
$button_primary_hover_border_color = WDFColorUtils::adjust_brightness($theme->button_primary_border_color, -12);
$button_primary_disabled_bg_color = $theme->button_primary_bg_color;
$button_primary_disabled_border_color = $theme->button_primary_border_color;

// button success
$button_success_content_color = $theme->button_success_content_color;
$button_success_bg_color = $theme->button_success_bg_color;
$button_success_border_color = $theme->button_success_border_color;
$button_success_hover_content_color = $theme->button_success_content_color;
$button_success_hover_bg_color = WDFColorUtils::adjust_brightness($theme->button_success_bg_color, -8);
$button_success_hover_border_color = WDFColorUtils::adjust_brightness($theme->button_success_border_color, -12);
$button_success_disabled_bg_color = $theme->button_success_bg_color;
$button_success_disabled_border_color = $theme->button_success_border_color;

// button info
$button_info_content_color = $theme->button_info_content_color;
$button_info_bg_color = $theme->button_info_bg_color;
$button_info_border_color = $theme->button_info_border_color;
$button_info_hover_content_color = $theme->button_info_content_color;
$button_info_hover_bg_color = WDFColorUtils::adjust_brightness($theme->button_info_bg_color, -8);
$button_info_hover_border_color = WDFColorUtils::adjust_brightness($theme->button_info_border_color, -12);
$button_info_disabled_bg_color = $theme->button_info_bg_color;
$button_info_disabled_border_color = $theme->button_info_border_color;

// button warning
$button_warning_content_color = $theme->button_warning_content_color;
$button_warning_bg_color = $theme->button_warning_bg_color;
$button_warning_border_color = $theme->button_warning_border_color;
$button_warning_hover_content_color = $theme->button_warning_content_color;
$button_warning_hover_bg_color = WDFColorUtils::adjust_brightness($theme->button_warning_bg_color, -8);
$button_warning_hover_border_color = WDFColorUtils::adjust_brightness($theme->button_warning_border_color, -12);
$button_warning_disabled_bg_color = $theme->button_warning_bg_color;
$button_warning_disabled_border_color = $theme->button_warning_border_color;

// button danger
$button_danger_content_color = $theme->button_danger_content_color;
$button_danger_bg_color = $theme->button_danger_bg_color;
$button_danger_border_color = $theme->button_danger_border_color;
$button_danger_hover_content_color = $theme->button_danger_content_color;
$button_danger_hover_bg_color = WDFColorUtils::adjust_brightness($theme->button_danger_bg_color, -8);
$button_danger_hover_border_color = WDFColorUtils::adjust_brightness($theme->button_danger_border_color, -12);
$button_danger_disabled_bg_color = $theme->button_danger_bg_color;
$button_danger_disabled_border_color = $theme->button_danger_border_color;

// button link
$button_link_content_color = $theme->button_link_content_color;
$button_link_hover_content_color = WDFColorUtils::adjust_brightness($theme->button_link_content_color, -15);

ob_start(); ?>
    <style>
    <?php ob_clean(); ?>

    /* BUTTON DEFAULT */
    <?php echo $prefix; ?>
    .btn-default {
        border-color: <?php echo $button_default_border_color?>;
        background-color: <?php echo $button_default_bg_color?>;
        color: <?php echo $button_default_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-default:hover,
    <?php echo $prefix; ?> .btn-default:focus,
    <?php echo $prefix; ?> .btn-default:active,
    <?php echo $prefix; ?> .btn-default.active,
    <?php echo $prefix; ?> .open .dropdown-toggle.btn-default {
        border-color: <?php echo $button_default_hover_border_color ?>;
        background-color: <?php echo $button_default_hover_bg_color ?>;
        color: <?php echo $button_default_hover_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-default.disabled,
    <?php echo $prefix; ?> .btn-default[disabled],
    <?php echo $prefix; ?> fieldset[disabled] .btn-default,
    <?php echo $prefix; ?> .btn-default.disabled:hover,
    <?php echo $prefix; ?> .btn-default[disabled]:hover,
    <?php echo $prefix; ?> fieldset[disabled] .btn-default:hover,
    <?php echo $prefix; ?> .btn-default.disabled:focus,
    <?php echo $prefix; ?> .btn-default[disabled]:focus,
    <?php echo $prefix; ?> fieldset[disabled] .btn-default:focus,
    <?php echo $prefix; ?> .btn-default.disabled:active,
    <?php echo $prefix; ?> .btn-default[disabled]:active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-default:active,
    <?php echo $prefix; ?> .btn-default.disabled.active,
    <?php echo $prefix; ?> .btn-default[disabled].active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-default.active {
        border-color: <?php echo $button_default_disabled_border_color; ?>;
        background-color: <?php echo $button_default_disabled_bg_color; ?>;
    }

    /* BUTTON PRIMARY */
    <?php echo $prefix; ?>
    .btn-primary {
        border-color: <?php echo $button_primary_border_color?>;
        background-color: <?php echo $button_primary_bg_color?>;
        color: <?php echo $button_primary_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-primary:hover,
    <?php echo $prefix; ?> .btn-primary:focus,
    <?php echo $prefix; ?> .btn-primary:active,
    <?php echo $prefix; ?> .btn-primary.active,
    <?php echo $prefix; ?> .open .dropdown-toggle.btn-primary {
        border-color: <?php echo $button_primary_hover_border_color ?>;
        background-color: <?php echo $button_primary_hover_bg_color ?>;
        color: <?php echo $button_primary_hover_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-primary.disabled,
    <?php echo $prefix; ?> .btn-primary[disabled],
    <?php echo $prefix; ?> fieldset[disabled] .btn-primary,
    <?php echo $prefix; ?> .btn-primary.disabled:hover,
    <?php echo $prefix; ?> .btn-primary[disabled]:hover,
    <?php echo $prefix; ?> fieldset[disabled] .btn-primary:hover,
    <?php echo $prefix; ?> .btn-primary.disabled:focus,
    <?php echo $prefix; ?> .btn-primary[disabled]:focus,
    <?php echo $prefix; ?> fieldset[disabled] .btn-primary:focus,
    <?php echo $prefix; ?> .btn-primary.disabled:active,
    <?php echo $prefix; ?> .btn-primary[disabled]:active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-primary:active,
    <?php echo $prefix; ?> .btn-primary.disabled.active,
    <?php echo $prefix; ?> .btn-primary[disabled].active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-primary.active {
        border-color: <?php echo $button_primary_disabled_border_color; ?>;
        background-color: <?php echo $button_primary_disabled_bg_color; ?>;
    }

    <?php echo $prefix; ?>
    .btn-default .caret {
        border-top-color: <?php echo $button_default_content_color ?>;
        border-bottom-color: <?php echo $button_default_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-default:hover .caret,
    <?php echo $prefix; ?> .btn-default:focus .caret,
    <?php echo $prefix; ?> .btn-default:active .caret,
    <?php echo $prefix; ?> .btn-default.active .caret {
        border-top-color: <?php echo $button_default_hover_content_color ?>;
        border-bottom-color: <?php echo $button_default_hover_content_color ?>;
    }

    /* BUTTON SUCCESS */
    <?php echo $prefix; ?>
    .btn-success {
        border-color: <?php echo $button_success_border_color?>;
        background-color: <?php echo $button_success_bg_color?>;
        color: <?php echo $button_success_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-success:hover,
    <?php echo $prefix; ?> .btn-success:focus,
    <?php echo $prefix; ?> .btn-success:active,
    <?php echo $prefix; ?> .btn-success.active,
    <?php echo $prefix; ?> .open .dropdown-toggle.btn-success {
        border-color: <?php echo $button_success_hover_border_color ?>;
        background-color: <?php echo $button_success_hover_bg_color ?>;
        color: <?php echo $button_success_hover_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-success.disabled,
    <?php echo $prefix; ?> .btn-success[disabled],
    <?php echo $prefix; ?> fieldset[disabled] .btn-success,
    <?php echo $prefix; ?> .btn-success.disabled:hover,
    <?php echo $prefix; ?> .btn-success[disabled]:hover,
    <?php echo $prefix; ?> fieldset[disabled] .btn-success:hover,
    <?php echo $prefix; ?> .btn-success.disabled:focus,
    <?php echo $prefix; ?> .btn-success[disabled]:focus,
    <?php echo $prefix; ?> fieldset[disabled] .btn-success:focus,
    <?php echo $prefix; ?> .btn-success.disabled:active,
    <?php echo $prefix; ?> .btn-success[disabled]:active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-success:active,
    <?php echo $prefix; ?> .btn-success.disabled.active,
    <?php echo $prefix; ?> .btn-success[disabled].active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-success.active {
        border-color: <?php echo $button_success_disabled_border_color; ?>;
        background-color: <?php echo $button_success_disabled_bg_color; ?>;
    }

    <?php echo $prefix; ?>
    .btn-success .caret {
        border-top-color: <?php echo $button_success_content_color ?>;
        border-bottom-color: <?php echo $button_success_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-success:hover .caret,
    <?php echo $prefix; ?> .btn-success:focus .caret,
    <?php echo $prefix; ?> .btn-success:active .caret,
    <?php echo $prefix; ?> .btn-success.active .caret {
        border-top-color: <?php echo $button_success_hover_content_color ?>;
        border-bottom-color: <?php echo $button_success_hover_content_color ?>;
    }

    /* BUTTON INFO */
    <?php echo $prefix; ?>
    .btn-info {
        border-color: <?php echo $button_info_border_color?>;
        background-color: <?php echo $button_info_bg_color?>;
        color: <?php echo $button_info_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-info:hover,
    <?php echo $prefix; ?> .btn-info:focus,
    <?php echo $prefix; ?> .btn-info:active,
    <?php echo $prefix; ?> .btn-info.active,
    <?php echo $prefix; ?> .open .dropdown-toggle.btn-info {
        border-color: <?php echo $button_info_hover_border_color ?>;
        background-color: <?php echo $button_info_hover_bg_color ?>;
        color: <?php echo $button_info_hover_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-info.disabled,
    <?php echo $prefix; ?> .btn-info[disabled],
    <?php echo $prefix; ?> fieldset[disabled] .btn-info,
    <?php echo $prefix; ?> .btn-info.disabled:hover,
    <?php echo $prefix; ?> .btn-info[disabled]:hover,
    <?php echo $prefix; ?> fieldset[disabled] .btn-info:hover,
    <?php echo $prefix; ?> .btn-info.disabled:focus,
    <?php echo $prefix; ?> .btn-info[disabled]:focus,
    <?php echo $prefix; ?> fieldset[disabled] .btn-info:focus,
    <?php echo $prefix; ?> .btn-info.disabled:active,
    <?php echo $prefix; ?> .btn-info[disabled]:active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-info:active,
    <?php echo $prefix; ?> .btn-info.disabled.active,
    <?php echo $prefix; ?> .btn-info[disabled].active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-info.active {
        border-color: <?php echo $button_info_disabled_border_color; ?>;
        background-color: <?php echo $button_info_disabled_bg_color; ?>;
    }

    <?php echo $prefix; ?>
    .btn-info .caret {
        border-top-color: <?php echo $button_info_content_color ?>;
        border-bottom-color: <?php echo $button_info_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-info:hover .caret,
    <?php echo $prefix; ?> .btn-info:focus .caret,
    <?php echo $prefix; ?> .btn-info:active .caret,
    <?php echo $prefix; ?> .btn-info.active .caret {
        border-top-color: <?php echo $button_info_hover_content_color ?>;
        border-bottom-color: <?php echo $button_info_hover_content_color ?>;
    }

    /* BUTTON WARNING */
    <?php echo $prefix; ?>
    .btn-warning {
        border-color: <?php echo $button_warning_border_color?>;
        background-color: <?php echo $button_warning_bg_color?>;
        color: <?php echo $button_warning_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-warning:hover,
    <?php echo $prefix; ?> .btn-warning:focus,
    <?php echo $prefix; ?> .btn-warning:active,
    <?php echo $prefix; ?> .btn-warning.active,
    <?php echo $prefix; ?> .open .dropdown-toggle.btn-warning {
        border-color: <?php echo $button_warning_hover_border_color ?>;
        background-color: <?php echo $button_warning_hover_bg_color ?>;
        color: <?php echo $button_warning_hover_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-warning.disabled,
    <?php echo $prefix; ?> .btn-warning[disabled],
    <?php echo $prefix; ?> fieldset[disabled] .btn-warning,
    <?php echo $prefix; ?> .btn-warning.disabled:hover,
    <?php echo $prefix; ?> .btn-warning[disabled]:hover,
    <?php echo $prefix; ?> fieldset[disabled] .btn-warning:hover,
    <?php echo $prefix; ?> .btn-warning.disabled:focus,
    <?php echo $prefix; ?> .btn-warning[disabled]:focus,
    <?php echo $prefix; ?> fieldset[disabled] .btn-warning:focus,
    <?php echo $prefix; ?> .btn-warning.disabled:active,
    <?php echo $prefix; ?> .btn-warning[disabled]:active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-warning:active,
    <?php echo $prefix; ?> .btn-warning.disabled.active,
    <?php echo $prefix; ?> .btn-warning[disabled].active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-warning.active {
        border-color: <?php echo $button_warning_disabled_border_color; ?>;
        background-color: <?php echo $button_warning_disabled_bg_color; ?>;
    }

    <?php echo $prefix; ?>
    .btn-warning .caret {
        border-top-color: <?php echo $button_warning_content_color ?>;
        border-bottom-color: <?php echo $button_warning_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-warning:hover .caret,
    <?php echo $prefix; ?> .btn-warning:focus .caret,
    <?php echo $prefix; ?> .btn-warning:active .caret,
    <?php echo $prefix; ?> .btn-warning.active .caret {
        border-top-color: <?php echo $button_warning_hover_content_color ?>;
        border-bottom-color: <?php echo $button_warning_hover_content_color ?>;
    }

    /* BUTTON DANGER */
    <?php echo $prefix; ?>
    .btn-danger {
        border-color: <?php echo $button_danger_border_color?>;
        background-color: <?php echo $button_danger_bg_color?>;
        color: <?php echo $button_danger_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-danger:hover,
    <?php echo $prefix; ?> .btn-danger:focus,
    <?php echo $prefix; ?> .btn-danger:active,
    <?php echo $prefix; ?> .btn-danger.active,
    <?php echo $prefix; ?> .open .dropdown-toggle.btn-danger {
        border-color: <?php echo $button_danger_hover_border_color ?>;
        background-color: <?php echo $button_danger_hover_bg_color ?>;
        color: <?php echo $button_danger_hover_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-danger.disabled,
    <?php echo $prefix; ?> .btn-danger[disabled],
    <?php echo $prefix; ?> fieldset[disabled] .btn-danger,
    <?php echo $prefix; ?> .btn-danger.disabled:hover,
    <?php echo $prefix; ?> .btn-danger[disabled]:hover,
    <?php echo $prefix; ?> fieldset[disabled] .btn-danger:hover,
    <?php echo $prefix; ?> .btn-danger.disabled:focus,
    <?php echo $prefix; ?> .btn-danger[disabled]:focus,
    <?php echo $prefix; ?> fieldset[disabled] .btn-danger:focus,
    <?php echo $prefix; ?> .btn-danger.disabled:active,
    <?php echo $prefix; ?> .btn-danger[disabled]:active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-danger:active,
    <?php echo $prefix; ?> .btn-danger.disabled.active,
    <?php echo $prefix; ?> .btn-danger[disabled].active,
    <?php echo $prefix; ?> fieldset[disabled] .btn-danger.active {
        border-color: <?php echo $button_danger_disabled_border_color; ?>;
        background-color: <?php echo $button_danger_disabled_bg_color; ?>;
    }

    <?php echo $prefix; ?>
    .btn-danger .caret {
        border-top-color: <?php echo $button_danger_content_color ?>;
        border-bottom-color: <?php echo $button_danger_content_color ?>;
    }

    <?php echo $prefix; ?>
    .btn-danger:hover .caret,
    <?php echo $prefix; ?> .btn-danger:focus .caret,
    <?php echo $prefix; ?> .btn-danger:active .caret,
    <?php echo $prefix; ?> .btn-danger.active .caret {
        border-top-color: <?php echo $button_danger_hover_content_color ?>;
        border-bottom-color: <?php echo $button_danger_hover_content_color ?>;
    }

    /* BUTTON LINK */
    <?php echo $prefix; ?>
    .link,
    <?php echo $prefix; ?> .btn-link {
        color: <?php echo $button_link_content_color; ?>;
    }

    <?php echo $prefix; ?>
    .link:hover,
    <?php echo $prefix; ?> .btn-link:hover,
    <?php echo $prefix; ?> .link:focus,
    <?php echo $prefix; ?> .btn-link:focus {
        color: <?php echo $button_link_hover_content_color; ?>;
    }

    <?php echo $prefix; ?>
    .link.disabled,
    <?php echo $prefix; ?> .btn-link.disabled,
    <?php echo $prefix; ?> .link[disabled],
    <?php echo $prefix; ?> .btn-link[disabled],
    <?php echo $prefix; ?> .link.disabled:hover,
    <?php echo $prefix; ?> .btn-link.disabled:hover,
    <?php echo $prefix; ?> .link[disabled]:hover,
    <?php echo $prefix; ?> .btn-link[disabled]:hover,
    <?php echo $prefix; ?> .link.disabled:focus,
    <?php echo $prefix; ?> .btn-link.disabled:focus,
    <?php echo $prefix; ?> .link[disabled]:focus,
    <?php echo $prefix; ?> .btn-link[disabled]:focus {
        color: <?php echo $button_link_content_color; ?>;
        opacity: 0.5;
    }

    <?php ob_start(); ?>
    </style>
<?php ob_clean();
