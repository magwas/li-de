<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$row = $this->row;
?>

<!-- navbar -->
<fieldset>
    <legend><?php echo WDFText::get('NAVBAR'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BAR'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_bg_color', '', $row->navbar_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_border_color', '', $row->navbar_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview" rowspan="4">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <nav class="preview_navbar navbar navbar-default" role="navigation">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="#" onclick="return false;">
                                        &nbsp;<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
                                        <span class="badge">2</span>
                                    </a>
                                </li>

                                <li class="dropdown">
                                    <a href="#"
                                       class="bs_dropdown-toggle"
                                       data-toggle="bs_dropdown">
                                        <?php echo WDFText::get('TOGGLE'); ?>
                                        <span class="glyphicon glyphicon-user"></span>
                                        <b class="caret"></b>
                                    </a>

                                    <ul class="bs_dropdown-menu" role="menu">
                                        <li>
                                            <a href="#" onclick="return false;">
                                                <?php echo WDFText::get('ITEM') . ' 1'; ?>
                                            </a>
                                        </li>

                                        <li class="divider">
                                        </li>

                                        <li>
                                            <a href="#" onclick="return false;">
                                                <?php echo WDFText::get('ITEM') . ' 2'; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LINK'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_link_content_color', '', $row->navbar_link_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('HOVER_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_link_hover_content_color', '', $row->navbar_link_hover_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('OPEN_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_link_open_content_color', '', $row->navbar_link_open_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('OPEN_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_link_open_bg_color', '', $row->navbar_link_open_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BADGE'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_badge_content_color', '', $row->navbar_badge_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_badge_bg_color', '', $row->navbar_badge_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('DROPDOWN'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('ITEM_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_dropdown_link_content_color', '', $row->navbar_dropdown_link_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('ITEM_HOVER_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_dropdown_link_hover_content_color', '', $row->navbar_dropdown_link_hover_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('ITEM_HOVER_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_dropdown_link_hover_background_content_color', '', $row->navbar_dropdown_link_hover_background_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('DIVIDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_dropdown_divider_color', '', $row->navbar_dropdown_divider_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_dropdown_background_color', '', $row->navbar_dropdown_background_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('navbar_dropdown_border_color', '', $row->navbar_dropdown_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- modal -->
<fieldset>
    <legend><?php echo WDFText::get('MODAL'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('MODAL'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BACKDROP'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('modal_backdrop_color', '', $row->modal_backdrop_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('modal_bg_color', '', $row->modal_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('modal_border_color', '', $row->modal_border_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('DIVIDERS'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('modal_dividers_color', '', $row->modal_dividers_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="preview_modal modal">
                            <div class="modal-backdrop fade in"></div>

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo WDFText::get('MODAL_HEADER'); ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo WDFText::get('MODAL_BODY'); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <p><?php echo WDFText::get('MODAL_FOOTER'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- panel user data -->
<fieldset>
    <legend><?php echo WDFText::get('USER_DATA_PANEL'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USER_DATA_PANEL'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('panel_user_data_bg_color', '', $row->panel_user_data_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('panel_user_data_border_color', '', $row->panel_user_data_border_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('FOOTER_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('panel_user_data_footer_bg_color', '', $row->panel_user_data_footer_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="preview_panel_user_data panel panel-default">
                            <div class="panel-body">
                                <h3 class="wd_shop_header"><?php echo WDFText::get('PANEL_HEADER'); ?></h3>

                                <div class="row">
                                    <div class="col-md-4 text-right">
                                        <p><strong><?php echo WDFText::get('NAME'); ?>:</strong></p></dt>
                                    </div>
                                    <div class="col-md-8">
                                        <p><?php echo WDFText::get('VALUE'); ?></p></dt>
                                    </div>

                                    <div class="col-md-4 text-right">
                                        <p><strong><?php echo WDFText::get('NAME'); ?>:</strong></p></dt>
                                    </div>
                                    <div class="col-md-8">
                                        <p><?php echo WDFText::get('VALUE'); ?></p></dt>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer text-right">
                                <?php echo WDFText::get('PANEL_FOOTER'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- panel product -->
<fieldset>
    <legend><?php echo WDFText::get('PRODUCT_PANEL'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PRODUCT_PANEL'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('panel_product_bg_color', '', $row->panel_product_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('panel_product_border_color', '', $row->panel_product_border_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('FOOTER_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('panel_product_footer_bg_color', '', $row->panel_product_footer_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="preview_panel_product panel panel-default">
                            <div class="panel-body">
                                <h3><?php echo WDFText::get('DATA'); ?></h3>
                            </div>

                            <div class="panel-footer text-right">
                                <?php echo WDFText::get('PANEL_FOOTER'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- well -->
<fieldset>
    <legend><?php echo WDFText::get('WELL'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('WELL'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('well_bg_color', '', $row->well_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('well_border_color', '', $row->well_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="preview_well well">
                            <?php echo WDFText::get('WELL_CONTENT') ?>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- rating stars -->
<fieldset>
    <legend><?php echo WDFText::get('RATING'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('TYPE'); ?>:</label>
            </td>

            <td class="col_value">
                <?php
                $star_checked = $row->rating_star_type == 'star' ? 'checked="checked"' : '';
                $star_empty_checked = $row->rating_star_type == 'star-empty' ? 'checked="checked"' : '';
                ?>
                <ul class="list_color_pickers">
                    <li>
                        <label>
                            <?php $this->wd_bs_container_start();
                            echo WDFHTML::jf_bs_rater('', '', '', 1, false, '', '', true, 1, 20, WDFHTML::WD_BS_RATER_STAR_TYPE_STAR);
                            $this->wd_bs_container_end(); ?>
                            <input type="radio" name="rating_star_type" class="checkbox_rating_star"
                                   value="star" <?php echo $star_checked; ?> onchange="onStarTypeChange(event, this);">
                        </label>
                    </li>

                    <li>
                        <label>
                            <?php $this->wd_bs_container_start();
                            echo WDFHTML::jf_bs_rater('', '', '', 1, false, '', '', true, 1, 20, WDFHTML::WD_BS_RATER_STAR_TYPE_STAR_EMPTY);
                            $this->wd_bs_container_end(); ?>
                            <input type="radio" name="rating_star_type" class="checkbox_rating_star"
                                   value="star-empty" <?php echo $star_empty_checked; ?>
                                   onchange="onStarTypeChange(event, this);">
                        </label>
                    </li>
                </ul>
            </td>

            <td class="col_preview" rowspan="2">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php $this->wd_bs_container_start();
                        echo WDFHTML::jf_bs_rater('', 'preview_rating_stars', '', 3.5, false, '', '', true, 5, 20, $row->rating_star_type);
                        $this->wd_bs_container_end(); ?>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('COLORS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('STAR'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('rating_star_color', '', $row->rating_star_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('rating_star_bg_color', '', $row->rating_star_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- labels -->
<fieldset>
    <legend><?php echo WDFText::get('LABEL'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LABEL'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('label_content_color', '', $row->label_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('label_bg_color', '', $row->label_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="preview_label">
                            <h6>
                                <span class="label label-default"><?php echo WDFText::get('LABEL') . ' 1'; ?></span>
                                <span class="label label-default"><?php echo WDFText::get('LABEL') . ' 2'; ?></span>
                            </h6>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- alert -->
<fieldset>
    <legend><?php echo WDFText::get('ALERT'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <!-- info -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('INFO'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('alert_info_content_color', '', $row->alert_info_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('alert_info_bg_color', '', $row->alert_info_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('alert_info_border_color', '', $row->alert_info_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="preview_alert_info alert alert-info">
                            <span><?php echo WDFText::get('INFO'); ?></span>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <!-- danger -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('DANGER'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('alert_danger_content_color', '', $row->alert_danger_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('alert_danger_bg_color', '', $row->alert_danger_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('alert_danger_border_color', '', $row->alert_danger_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="preview_alert_danger alert alert-danger">
                            <span><?php echo WDFText::get('DANGER'); ?></span>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- breadcrumb -->
<fieldset>
    <legend><?php echo WDFText::get('BREADCRUMB'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BREADCRUMB'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('breadcrumb_content_color', '', $row->breadcrumb_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('breadcrumb_bg_color', '', $row->breadcrumb_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <ul class="preview_breadcrumb breadcrumb">
                            <li>
                                <a href="#" onclick="return false;">
                                    <?php echo WDFText::get('BREADCRUMB') . ' 1'; ?>
                                </a>
                            </li>

                            <li>
                                <?php echo WDFText::get('BREADCRUMB') . ' 2'; ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- pills -->
<fieldset>
    <legend><?php echo WDFText::get('PILLS'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LINKS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pill_link_content_color', '', $row->pill_link_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('HOVER_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pill_link_hover_content_color', '', $row->pill_link_hover_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('HOVER_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pill_link_hover_bg_color', '', $row->pill_link_hover_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <ul class="preview_pills nav nav-pills nav-stacked">
                            <li>
                                <a href="#" onclick="return false;"><?php echo WDFText::get('PILL') . ' 1'; ?></a>
                            </li>

                            <li>
                                <a href="#" onclick="return false;"><?php echo WDFText::get('PILL') . ' 2'; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- tabs -->
<fieldset>
    <legend><?php echo WDFText::get('TABS'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LINKS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('tab_link_content_color', '', $row->tab_link_content_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>

                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('HOVER_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('tab_link_hover_content_color', '', $row->tab_link_hover_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('HOVER_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('tab_link_hover_bg_color', '', $row->tab_link_hover_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>

                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('ACTIVE_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('tab_link_active_content_color', '', $row->tab_link_active_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('ACTIVE_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('tab_link_active_bg_color', '', $row->tab_link_active_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview" rowspan="2">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <ul class="preview_tabs nav nav-tabs">
                            <li class="active">
                                <a href="#" onclick="return false;">
                                    <?php echo WDFText::get('TAB') . ' 1'; ?>
                                </a>
                            </li>

                            <li>
                                <a href="#" onclick="return false;">
                                    <?php echo WDFText::get('TAB') . ' 2'; ?>
                                </a>
                            </li>

                            <li>
                                <a href="#" onclick="return false;">
                                    <?php echo WDFText::get('TAB') . ' 3'; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BORDER'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('tab_border_color', '', $row->tab_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- pagination -->
<fieldset>
    <legend><?php echo WDFText::get('PAGINATION'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LINKS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_content_color', '', $row->pagination_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_bg_color', '', $row->pagination_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>

                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('HOVER_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_hover_content_color', '', $row->pagination_hover_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('HOVER_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_hover_bg_color', '', $row->pagination_hover_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>

                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('ACTIVE_CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_active_content_color', '', $row->pagination_active_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('ACTIVE_BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_active_bg_color', '', $row->pagination_active_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview" rowspan="2">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="preview_pagination pagination pagination-sm">
                            <li class="disabled">
                                <a href="#" onclick="return false;">&laquo;</a>
                            </li>
                            <li>
                                <a href="#" onclick="return false;">1</a>
                            </li>
                            <li>
                                <a href="#" onclick="return false;">2</a>
                            </li>
                            <li class="active">
                                <a href="#" onclick="return false;">3</a>
                            </li>
                            <li>
                                <a href="#" onclick="return false;">4</a>
                            </li>
                            <li>
                                <a href="#" onclick="return false;">&raquo;</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BORDER'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pagination_border_color', '', $row->pagination_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- pager -->
<fieldset>
    <legend><?php echo WDFText::get('PAGER'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LINKS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pager_content_color', '', $row->pager_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pager_bg_color', '', $row->pager_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('pager_border_color', '', $row->pager_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="preview_pager pager">
                            <li>
                                <a href="#" onclick="return false;"><?php echo WDFText::get('PREVIOUS'); ?></a>
                            </li>

                            <li>
                                <a href="#" onclick="return false;"><?php echo WDFText::get('NEXT'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>
