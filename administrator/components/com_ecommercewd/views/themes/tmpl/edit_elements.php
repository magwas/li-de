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

<!-- headings -->
<fieldset>
    <legend><?php echo WDFText::get('TEXT'); ?></legend>
    <table class="adminlist table">
        <!-- header -->
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('HEADER'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('header_content_color', '', $row->header_content_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <div class="wd_bs_container">
                    <?php $this->wd_bs_container_start(); ?>
                    <h1 class="preview_header wd_shop_header"><?php echo WDFText::get('HEADER'); ?></h1>
                    <?php $this->wd_bs_container_end(); ?>
                </div>
            </td>
        </tr>
        </tbody>

        <!-- subtext -->
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('SUBTEXT'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('subtext_content_color', '', $row->subtext_content_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <div class="wd_bs_container">
                    <?php $this->wd_bs_container_start(); ?>
                    <h3><?php echo WDFText::get('TEXT'); ?>
                        <small class="preview_subtext"><?php echo WDFText::get('SUBTEXT'); ?></small>
                    </h3>
                    <?php $this->wd_bs_container_end(); ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- input -->
<fieldset>
    <legend><?php echo WDFText::get('INPUT'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('INPUT'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('input_content_color', '', $row->input_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('input_bg_color', '', $row->input_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('input_border_color', '', $row->input_border_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER_ON_FOCUS'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('input_focus_border_color', '', $row->input_focus_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="preview_form_group form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       value="<?php echo WDFText::get('INPUT'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('INPUT_WITH_ERROR'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('COLOR'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('input_has_error_content_color', '', $row->input_has_error_content_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="preview_form_group form-group has-error">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       value="<?php echo WDFText::get('INPUT_WITH_ERROR'); ?>">
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

<!-- buttons -->
<fieldset>
    <legend><?php echo WDFText::get('BUTTONS'); ?></legend>

    <table class="adminlist table">
        <tbody>
        <!-- button default -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BUTTON_DEFAULT'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_default_content_color', '', $row->button_default_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_default_bg_color', '', $row->button_default_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_default_border_color', '', $row->button_default_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <div class="wd_bs_container">
                    <?php $this->wd_bs_container_start(); ?>
                    <div class="text-center">
                        <a class="preview_button_default btn btn-default"><?php echo WDFText::get('DEFAULT'); ?></a>
                    </div>
                    <?php $this->wd_bs_container_end(); ?>
                </div>
            </td>
        </tr>

        <!-- button primary -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BUTTON_PRIMARY'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_primary_content_color', '', $row->button_primary_content_color, '', '', 'onColorChange') ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_primary_bg_color', '', $row->button_primary_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_primary_border_color', '', $row->button_primary_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="text-center">
                    <a class="preview_button_primary btn btn-primary"><?php echo WDFText::get('PRIMARY'); ?></a>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <!-- button success -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BUTTON_SUCCESS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_success_content_color', '', $row->button_success_content_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BACKGROUND'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_success_bg_color', '', $row->button_success_bg_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('BORDER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_success_border_color', '', $row->button_success_border_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="text-center">
                    <a class="preview_button_success btn btn-success"><?php echo WDFText::get('SUCCESS'); ?></a>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>

        <!-- button info -->
        <!-- button warning -->
        <!-- button danger -->

        <!-- button link -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('BUTTON_LINK'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('button_link_content_color', '', $row->button_link_content_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <?php $this->wd_bs_container_start(); ?>
                <div class="text-center">
                    <a class="preview_button_link btn btn-link"><?php echo WDFText::get('LINK'); ?></a>
                </div>
                <?php $this->wd_bs_container_end(); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- divider -->
<fieldset>
    <legend><?php echo WDFText::get('DIVIDER'); ?></legend>
    <table class="adminlist table">
        <!-- divider -->
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('DIVIDER'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('COLOR'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('divider_color', '', $row->divider_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>

            <td class="col_preview">
                <div class="wd_bs_container">
                    <?php $this->wd_bs_container_start(); ?>
                    <div class="preview_divider wd_divider"></div>
                    <?php $this->wd_bs_container_end(); ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>