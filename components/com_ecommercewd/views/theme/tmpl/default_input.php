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

$input_content_color = $theme->input_content_color;
$input_placeholder_color = WDFColorUtils::adjust_brightness($input_content_color, 25);
$input_bg_color = $theme->input_bg_color;
$input_border_color = $theme->input_border_color;
$input_focus_border_color = WDFColorUtils::adjust_brightness($theme->input_focus_border_color, 10);
$input_focus_border_color_rgba = WDFColorUtils::color_to_rgba($input_focus_border_color);
$input_focus_border_color_rgba['a'] = 0.6;
$input_focus_border_color_rgba = WDFColorUtils::color_to_rgba($input_focus_border_color, true);

$addon_content_color = WDFColorUtils::adjust_brightness($input_border_color, -20);
$addon_bg_color = WDFColorUtils::adjust_brightness($input_border_color, 35);
$addon_border_color = $input_border_color;

$input_has_error_content_color = $theme->input_has_error_content_color;
$input_has_error_border_color = $input_has_error_content_color;
$input_has_error_focus_border_color = WDFColorUtils::color_to_rgba(WDFColorUtils::adjust_brightness($input_has_error_content_color, -15), true);
$input_has_error_focus_shadow_color = WDFColorUtils::color_to_rgba(WDFColorUtils::adjust_saturation(WDFColorUtils::adjust_brightness($input_has_error_content_color, 10), -30), true);

$has_error_addon_content_color = WDFColorUtils::adjust_brightness($input_has_error_border_color, -20);
$has_error_addon_bg_color = WDFColorUtils::adjust_brightness($input_has_error_border_color, 35);
$has_error_addon_border_color = $input_has_error_border_color;

ob_start(); ?>
    <style>
        <?php ob_clean();?>

        /* INPUT */
        <?php echo $prefix; ?>
        .form-control::-webkit-input-placeholder {
            color: <?php echo $input_placeholder_color; ?>;
        }

        <?php echo $prefix; ?>
        .form-control {
            color: <?php echo $input_content_color ?>;
            background-color: <?php echo $input_bg_color; ?>;
            border-color: <?php echo $input_border_color; ?>;
        }

        <?php echo $prefix; ?>
        .form-control:focus {
            border-color: <?php echo $input_focus_border_color; ?>;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px <?php echo $input_focus_border_color_rgba; ?>;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px <?php echo $input_focus_border_color_rgba; ?>;
        }

        <?php echo $prefix; ?>
        .input-group-addon {
            color: <?php echo $addon_content_color; ?>;
            background-color: <?php echo $addon_bg_color; ?>;
            border-color: <?php echo $addon_border_color; ?>;
        }

        /* has error */
        <?php echo $prefix; ?>
        .has-error .control-label {
            color: <?php echo $input_has_error_content_color; ?>;
        }

        <?php echo $prefix; ?>
        .has-error .form-control {
            border-color: <?php echo $input_has_error_focus_border_color; ?>;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        <?php echo $prefix; ?>
        .has-error .form-control:focus {
            border-color: <?php echo $input_has_error_content_color; ?>;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px <?php echo $input_has_error_focus_shadow_color; ?>;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px <?php echo $input_has_error_focus_shadow_color; ?>;
        }

        <?php echo $prefix; ?>
        .has-error .input-group-addon {
            color: <?php echo $has_error_addon_content_color; ?>;
            background-color: <?php echo $has_error_addon_bg_color; ?>;
            border-color: <?php echo $has_error_addon_border_color; ?>;
        }

        <?php ob_start(); ?>
    </style>
<?php ob_clean();
