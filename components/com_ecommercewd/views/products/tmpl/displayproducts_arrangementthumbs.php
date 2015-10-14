<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_arrangementthumbs.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_arrangementthumbs.js');


$options = $this->options;

$theme = $this->theme;

$product_rows = $this->product_rows;

switch ($theme->products_option_columns) {
    case 1:
        $product_thumb_col = 'col-md-3 col-sm-4 col-xs-12';
        break;
    case 2:
        $product_thumb_col = 'col-md-4 col-sm-6 col-xs-12';
        break;
    case 3:
        $product_thumb_col = 'col-md-6 col-sm-12 col-xs-12';
        break;
}

?>

<div class="wd_shop_products_container row">
<?php
for ($i = 0; $i < count($product_rows); $i++) {
    $product_row = $product_rows[$i];
    if ($product_row->image != '') {
        $el_product_image = '<img class="wd_shop_product_image" src="' . $product_row->image . '">';
    } else {
        $el_product_image = '
            <div class="wd_shop_product_no_image">
                <span class="glyphicon glyphicon-picture"></span>
                <br>
                <span>' . WDFText::get('NO_IMAGE') . '</span>
            </div>
            ';
    }

    if ($product_row->label_thumb != '') {
        switch ($product_row->label_thumb_position) {
            case 0:
                $label_position_class = 'wd_align_tl';
                break;
            case 1:
                $label_position_class = 'wd_align_tr';
                break;
            case 2:
                $label_position_class = 'wd_align_bl';
                break;
            case 3:
                $label_position_class = 'wd_align_br';
                break;
        }
        $el_product_image_label = '
                <img class="wd_shop_product_image_label ' . $label_position_class . '"
                     src="' . $product_row->label_thumb . '"
                     title="' . $product_row->label_name . '">';
    } else {
        $el_product_image_label = '';
    }
	$id_for_width = $i == 0 ? "id='wd_shop_for_width'" : "";
    ?>
    <div class="wd_shop_product <?php echo $product_thumb_col; ?>" product_id="<?php echo $product_row->id; ?>" <?php echo $id_for_width;?>>
        <!-- product panel -->
        <div class="wd_shop_panel_product panel panel-default">
            <div class="panel-body">
                <!-- image -->
                <?php
                if ($theme->products_thumbs_view_show_image == 1) {
                    ?>
                    <a href="<?php echo $product_row->url; ?>" class="link">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="wd_shop_product_image_label_container">
                                    <div class="wd_shop_product_image_container wd_center_wrapper">
                                        <div>
                                            <?php echo $el_product_image; ?>
                                        </div>
                                    </div>

                                    <!-- label -->
                                    <?php
                                    if ($theme->products_thumbs_view_show_label == 1) {
                                        echo $el_product_image_label;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
                <!-- name -->
                <?php
                if ($theme->products_thumbs_view_show_name == 1) {
                    ?>
                    <div class="row">
                        <div class="col-sm-12">						
                            <a href="<?php echo $product_row->url; ?>"
                               class="wd_shop_product_name btn btn-link" title="<?php echo $product_row->name; ?>">
                                <?php echo $product_row->name; ?>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- rating -->
                <?php

                if (($options->feedback_enable_product_rating == 1) && ($theme->products_thumbs_view_show_rating == 1)) {
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            echo WDFHTML::jf_bs_rater('', 'wd_shop_star_rater', '', $product_row->rating, $product_row->can_rate, $product_row->rating_url, $product_row->rating_msg, false, 5, 16, $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color);
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- price -->
                <div class="wd_shop_product_prices_container row">
                    <div class="col-sm-12">
					    <?php
                        if ($theme->products_thumbs_view_show_price == 1) {
                            ?>
                            <span class="wd_shop_product_price"><?php echo $product_row->price_text; ?></span>
                        <?php
                        }
                        ?>
                        <?php
                        if (($theme->products_thumbs_view_show_market_price == 1) && ($theme->products_thumbs_view_show_price == 1)) {
                            ?>
                            <br>
                        <?php
                        }
                        ?>
						<?php
                        if ($theme->products_thumbs_view_show_market_price == 1) {
                            ?>
                            <span
                                class="wd_shop_product_market_price"><?php echo $product_row->market_price_text; ?></span>
                        <?php
                        }
                        ?>

    
                    </div>
                </div>


                <!-- description -->
                <?php
                if ($theme->products_thumbs_view_show_description == 1) {
                    ?>
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <div class="wd_shop_product_description">
                                <?php echo $product_row->description; ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- buttons -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- buttons on left -->
                        <div class="btn-group btn-group-sm">
                            <!-- btn quick view -->
                            <?php
                            if ($theme->products_thumbs_view_show_button_quick_view == 1) {
                                ?>
                                <a href="#" class="btn btn-default" data-toggle="tooltip" data-placement="top"
                                   title="<?php echo WDFText::get('BTN_QUICK_VIEW'); ?>"
                                   onclick="wdShop_onBtnQuickViewClick(event, this); return false;">
                                    &nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;
                                </a>
                            <?php
                            }
                            ?>

                            <!-- btn compare -->
                            <?php
                            if ($theme->products_thumbs_view_show_button_compare == 1) {
                                ?>
                                <a href="<?php echo $product_row->compare_url; ?>"
                                   class="btn btn-default"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="<?php echo WDFText::get('BTN_COMPARE'); ?>"
                                   onclick="wdShop_onBtnCompareClick(event, this); return false;">
                                    &nbsp;<span class="glyphicon glyphicon-stats"></span>&nbsp;
                                </a>
                            <?php
                            }
                            ?>
                        </div>

                        <!-- buttons on right -->
                        <div class="btn-group btn-group-sm pull-right wd_shop_bottom_checkout_buttons">
                            <!-- btn buy now -->
                            <?php
                            if (($options->checkout_enable_checkout == 1) && ($theme->products_thumbs_view_show_button_buy_now == 1) && ($product_row->can_checkout == true)
                            ) {
                                ?>
                                <a href="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=quick_checkout'; ?>"
                                   class="btn btn-default"
                                   onclick="wdShop_onBtnBuyNowClick(event, this); return false;">
                                    <?php echo WDFText::get('BTN_BUY_NOW'); ?>
                                </a>
                            <?php
                            }
                            ?>

                            <!-- btn add to cart -->
                            <?php
                            if ($theme->products_thumbs_view_show_button_add_to_cart == 1) {
                                ?>
                                <a class="wd_shop_btn_add_to_cart btn btn-primary"
                                   data-toggle="tooltip"                 
								   title="<?php echo ($product_row->added_to_cart == 1 && $options->checkout_redirect_to_cart_after_adding_an_item == 2) ? WDFText::get('MSG_PRODUCT_ALREADY_ADDED_TO_CART') : WDFText::get('BTN_ADD_TO_CART'); ?>" 
								   <?php echo ($product_row->added_to_cart == 1 && $options->checkout_redirect_to_cart_after_adding_an_item == 2) ? 'disabled="disabled"' : ''; ?> 
                                   onclick="wdShop_onBtnAddToCartClick(event, this); return false;" >
                                    &nbsp;<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
                                </a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
</div>

<?php
$product_params = array();
foreach ($product_rows as $product_row) {
    $product_params[$product_row->id] = $product_row->parameters;
}
$product_params_json  = json_encode($product_params);
//?>
<script>
    var products_parameters = JSON.parse( "<?php echo addslashes($product_params_json);?>");
</script>
