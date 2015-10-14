<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_script('js/framework/items_slider.js');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;

$row = $this->row;

$products = $row->products;


WDFDocument::set_title($row->name);
WDFDocument::set_meta_data('title', $row->meta_title);
WDFDocument::set_meta_data('keywords', $row->meta_keyword);
WDFDocument::set_description($row->meta_description);
?>

<div class="container">
    <!-- header -->
    <h1 class="wd_shop_manufacturer_name wd_shop_header">
        <?php echo $row->name; ?>
    </h1>

    <!-- info -->
    <?php
    if ($row->show_info == 1) {
        ?>
        <div class="row ">
            <div class="col-sm-5">
                <div class="wd_shop_manufacturer_logo_container wd_center_wrapper img-thumbnail">
                    <div>
                        <?php
                        if ($row->logo != '') {
                            ?>
                            <img class="wd_shop_manufacturer_logo"
                                 src="<?php echo $row->logo; ?>"
                                 alt="<?php echo $row->name; ?>">
                        <?php
                        } else {
                            ?>
                            <div class="wd_shop_manufacturer_no_image">
                                <span class="glyphicon glyphicon-picture"></span>
                                <br>
                                <span><?php echo WDFText::get('NO_IMAGE'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-7">
                <!-- website -->
                <p class="text-right">
                    <?php
                    if ($row->site != '') {
                        ?>
                        <a href="<?php echo $row->site; ?>" class="wd_shop_manufacturer_link btn btn-link"
                           target="_blank">
                            <?php echo WDFText::get('BTN_VISIT_SITE'); ?>
                        </a>
                    <?php
                    }
                    ?>
                </p>

                <!-- description -->
                <p class="text-justify">
                    <?php echo $row->description; ?>
                </p>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- divider -->
    <?php
    if (($row->show_info == 1) && ($row->show_products == 1)) {
        ?>
        <div class="wd_divider"></div>
    <?php
    }
    ?>

    <!-- products -->
    <?php
    if ($row->show_products == 1) {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="wd_shop_header_sm">
                    <?php echo WDFText::get('PRODUCTS'); ?>
                </h4>

                <div class="wd_shop_products_slider">
                    <a class="wd_items_slider_btn_prev btn btn-link pull-left">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>

                    <a class="wd_items_slider_btn_next btn btn-link pull-right">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>

                    <div class="wd_items_slider_mask">
                        <ul class="wd_items_slider_items_list">
                            <?php
                            for ($i = 0; $i < count($products); $i++) {
                                $product = $products[$i];
                                if ($product->image != '') {
                                    $el_related_product_image = '<img src="' . $product->image . '">';
                                } else {
                                    $el_related_product_image = '
                                    <div class="wd_shop_product_no_image">
                                        <span class="glyphicon glyphicon-picture"></span>
                                        <br>
                                        <span>' . WDFText::get('NO_IMAGE') . '</span>
                                    </div>
                                    ';
                                }
                                ?>
                                <li>
                                    <a class="wd_shop_product_container btn btn-link"
                                       href="<?php echo $product->url; ?>"
                                       title="<?php echo $product->name; ?>">
                                        <!-- image -->
                                        <div class="wd_shop_product_image_container wd_center_wrapper">
                                            <div>
                                                <?php echo $el_related_product_image; ?>
                                            </div>
                                        </div>

                                        <!-- name -->
                                        <div class="wd_shop_product_link_name text-center">
                                            <?php echo $product->name; ?>
                                        </div>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- button show all products -->
        <?php
        if ($options->filter_manufacturers == 1) {
            ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a class="btn btn-primary"
                       href="<?php echo $row->url_view_products; ?>">
                        <?php echo WDFText::get('BTN_VIEW_ALL_PRODUCTS'); ?>
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
    <?php
    }
    ?>
</div>