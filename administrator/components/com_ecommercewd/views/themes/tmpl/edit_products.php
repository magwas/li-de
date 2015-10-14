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

<!-- colors -->
<fieldset>
    <legend><?php echo WDFText::get('COLORS'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('COLORS'); ?>:</label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('NAME'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_name_color', '', $row->product_name_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>

                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CATEGORY'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_category_color', '', $row->product_category_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('MANUFACTURER'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_manufacturer_color', '', $row->product_manufacturer_color, '', '', 'onColorChange'); ?></span>
                    </li>
					 <li>
                        <span><?php echo WDFText::get('MODEL'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_model_color', '', $row->product_model_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>

                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('PRICE'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_price_color', '', $row->product_price_color, '', '', 'onColorChange'); ?></span>
                    </li>

                    <li>
                        <span><?php echo WDFText::get('MARKET_PRICE'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_market_price_color', '', $row->product_market_price_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
				<ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('PRODUCT_CODES'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('product_code_color', '', $row->product_code_color, '', '', 'onColorChange'); ?></span>
                    </li>

                </ul>
            </td>

            <td class="col_preview">
                <div class="wd_bs_container">
                    <?php $this->wd_bs_container_start(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="preview_product">
                                <div class="row">
                                    <!-- name -->
                                    <div class="col-sm-12">
                                        <h2 class="product_name text-left">
                                            <?php echo WDFText::get('PRODUCT'); ?>
                                        </h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- category -->
                                        <div>
                                            <span
                                                class="product_category"><?php echo WDFText::get('CATEGORY'); ?></span>
                                        </div>

                                        <!-- manufacturer -->
                                        <div>
                                        <span
                                            class="product_manufacturer"><?php echo WDFText::get('MANUFACTURER'); ?></span>
                                        </div>
										
										<!-- model -->
                                        <div>
                                        <span
                                            class="product_model"><?php echo WDFText::get('MODEL'); ?></span>
                                        </div>										
                                    </div>

                                    <!-- price -->
                                    <div class="product_prices_container col-sm-6 text-right">
                                        <span class="product_market_price">
                                            <?php echo WDFText::get('MARKET_PRICE'); ?>
                                        </span>

                                        <span class="product_price">
                                            <?php echo WDFText::get('PRICE'); ?>
                                        </span>
                                    </div>
									
                                    <!-- product codes -->
                                    <div class="col-sm-12 ">
                                        <span class="product_codes">
                                            <?php echo WDFText::get('PRODUCT_CODES'); ?>
                                        </span>
                                    </div>									
                                </div>

                                <!-- description -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="product_description">
                                            <?php echo WDFText::get('DESCRIPTION'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->wd_bs_container_end(); ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- filters position -->
<fieldset>
    <legend><?php echo WDFText::get('FILTERS'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('FILTERS_POSITION'); ?>:</label>
            </td>

            <td>
                <?php
                $filters_pos_0_checked = $row->products_filters_position == 0 ? 'checked="checked"' : '';
                $filters_pos_1_checked = $row->products_filters_position == 1 ? 'checked="checked"' : '';
                $filters_pos_2_checked = $row->products_filters_position == 2 ? 'checked="checked"' : '';
                ?>
                <ul class="list_inputs">
                    <li>
                        <label>
                            <input type="radio" name="products_filters_position"
                                   value="1" <?php echo $filters_pos_1_checked; ?>>
                            <span><?php echo WDFText::get('ON_TOP'); ?></span>
                        </label>
                    </li>

                    <li>
                        <label>
                            <input type="radio" name="products_filters_position"
                                   value="2" <?php echo $filters_pos_2_checked; ?>>
                            <span><?php echo WDFText::get('ON_LEFT'); ?></span>
                        </label>
                    </li>

                    <li>
                        <label>
                            <input type="radio" name="products_filters_position"
                                   value="0" <?php echo $filters_pos_0_checked; ?>>
                            <span><?php echo WDFText::get('HIDDEN'); ?></span>
                        </label>
                    </li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- number of products -->
<fieldset>
    <legend><?php echo WDFText::get('NUMBER_OF_PRODUCTS'); ?></legend>
    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('NUMBER_OF_PRODUCTS_IN_PAGE'); ?>:</label>
            </td>

            <td>
                <?php
                $products_count_12_checked = $row->products_count_in_page == 12 ? 'checked="checked"' : '';
                $products_count_24_checked = $row->products_count_in_page == 24 ? 'checked="checked"' : '';
                $products_count_36_checked = $row->products_count_in_page == 36 ? 'checked="checked"' : '';
                ?>
                <ul class="list_inputs">
                    <li>
                        <label>
                            <input type="radio" name="products_count_in_page"
                                   value="12" <?php echo $products_count_12_checked; ?>>
                            <span>12</span>
                        </label>
                    </li>

                    <li>
                        <label>
                            <input type="radio" name="products_count_in_page"
                                   value="24" <?php echo $products_count_24_checked; ?>>
                            <span>24</span>
                        </label>
                    </li>

                    <li>
                        <label>
                            <input type="radio" name="products_count_in_page"
                                   value="36" <?php echo $products_count_36_checked; ?>>
                            <span>36</span>
                        </label>
                    </li>
                </ul>
            </td>
        </tr>

        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('COLUMNS'); ?>:</label>
            </td>

            <td>
                <?php
                $products_columns_1_checked = $row->products_option_columns == 1 ? 'checked="checked"' : '';
                $products_columns_2_checked = $row->products_option_columns == 2 ? 'checked="checked"' : '';
                $products_columns_3_checked = $row->products_option_columns == 3 ? 'checked="checked"' : '';
                ?>
                <ul class="list_inputs">
                    <li>
                        <label>
                            <input type="radio" name="products_option_columns"
                                   value="1" <?php echo $products_columns_1_checked; ?>>
                            <h4>4</h4> (<?php echo WDFText::get('FOR_DESKTOP'); ?>) -
                            <h4>3</h4> (<?php echo WDFText::get('FOR_TABLETS'); ?>) -
                            <h4>1</h4> (<?php echo WDFText::get('FOR_PHONES'); ?>)
                        </label>
                    </li>

                    <li>
                        <label>
                            <input type="radio" name="products_option_columns"
                                   value="2" <?php echo $products_columns_2_checked; ?>>
                            <h4>3</h4> (<?php echo WDFText::get('FOR_DESKTOP'); ?>) -
                            <h4>2</h4> (<?php echo WDFText::get('FOR_TABLETS'); ?>) -
                            <h4>1</h4> (<?php echo WDFText::get('FOR_PHONES'); ?>)
                        </label>
                    </li>

                    <li>
                        <label>
                            <input type="radio" name="products_option_columns"
                                   value="3" <?php echo $products_columns_3_checked; ?>>
                            <h4>2</h4> (<?php echo WDFText::get('FOR_DESKTOP'); ?>) -
                            <h4>1</h4> (<?php echo WDFText::get('FOR_TABLETS'); ?>) -
                            <h4>1</h4> (<?php echo WDFText::get('FOR_PHONES'); ?>)
                        </label>
                    </li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- product data -->
<fieldset>
<legend><?php echo WDFText::get('VIEW_DATA'); ?></legend>
<table class="adminlist table product_views_data">
<thead>
<tr>
    <th class="col_key">
    </th>

    <th>
        <label><?php echo WDFText::get('THUMBNAIL_VIEW'); ?></label>
    </th>

    <th>
        <label><?php echo WDFText::get('LIST_VIEW'); ?></label>
    </th>

    <th>
        <label><?php echo WDFText::get('QUICK_VIEW'); ?></label>
    </th>

    <th>
        <label><?php echo WDFText::get('PRODUCT_VIEW'); ?></label>
    </th>
</tr>
</thead>

<tbody>
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('IMAGE'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_image == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_image" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_image == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_image" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_image == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_image" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_image == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_image" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('LABEL'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_label == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_label" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_label == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_label" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_label == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_label" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_label == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_label" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('NAME'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_name == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_name" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_name == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_name" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_name == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_name" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_name == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_name" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('RATING'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_rating == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_rating" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_rating == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_rating" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_rating == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_rating" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_rating == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_rating" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('CATEGORY'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_category == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_category" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_category == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_category" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('MANUFACTURER'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_manufacturer == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_manufacturer"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_manufacturer == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_manufacturer" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('MODEL'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_model == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_model"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_model == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_model" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('PRICE'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_price" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_price" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_price" value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_price" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('MARKET_PRICE'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_market_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_market_price"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_market_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_market_price"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_market_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_market_price"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_market_price == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_market_price" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('DESCRIPTION'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_description == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_description"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_description == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_description"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_description == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_description"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_description == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_description" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('BUTTON_QUICK_VIEW'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_button_quick_view == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_button_quick_view"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_button_quick_view == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_button_quick_view"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('BUTTON_COMPARE'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_button_compare == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_button_compare"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_button_compare == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_button_compare"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_button_compare == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_button_compare"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_button_compare == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_button_compare" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('BUTTON_WRITE_REVIEW'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_button_write_review == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_button_write_review"
               value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('BUTTON_BUY_NOW'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_button_buy_now == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_button_buy_now"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_button_buy_now == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_button_buy_now"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_button_buy_now == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_button_buy_now"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_button_buy_now == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_button_buy_now" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('BUTTON_ADD_TO_CART'); ?></label>
    </td>

    <td>
        <?php $product_data_checked = $row->products_thumbs_view_show_button_add_to_cart == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_thumbs_view_show_button_add_to_cart"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_list_view_show_button_add_to_cart == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_list_view_show_button_add_to_cart"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->products_quick_view_show_button_add_to_cart == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="products_quick_view_show_button_add_to_cart"
               value="1" <?php echo $product_data_checked; ?>>
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_button_add_to_cart == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_button_add_to_cart"
               value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('SOCIAL_BUTTONS'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_social_buttons == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_social_buttons" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('PARAMETERS'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_parameters == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_parameters" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('SHIPPING_INFO'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_shipping_info == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_shipping_info" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('REVIEWS'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_reviews == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_reviews" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>

<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('RELATED_PRODUCTS'); ?></label>
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        -
    </td>

    <td>
        <?php $product_data_checked = $row->product_view_show_related_products == 1 ? 'checked="checked"' : ''; ?>
        <input type="checkbox" name="product_view_show_related_products" value="1" <?php echo $product_data_checked; ?>>
    </td>
</tr>
</tbody>
</table>
</fieldset>