<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_fbcomments.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_fbcomments.js');


$options = $this->options;

$product_row = $this->product_row;


WDFDocument::set_title($product_row->name);
WDFDocument::set_meta_data('title', $product_row->meta_title);
WDFDocument::set_meta_data('keywords', $product_row->meta_keyword);
WDFDocument::set_description($product_row->meta_description);

WDFDocument::set_meta_property('og:title', $product_row->meta_title);
WDFDocument::set_meta_property('og:image', urlencode($product_row->image));
WDFDocument::set_meta_property('og:description', $product_row->meta_description);

WDFFb::init();
?>

<!-- fb comments -->
<div class="wd_shop_write_review_container row">
    <!-- top divider -->
    <div class="col-sm-12">
        <div class="wd_divider"></div>
    </div>

    <!-- data -->
    <div class="col-sm-12 text-center">
        <?php
        echo WDFFb::comments($product_row->url_absolute, array('num_posts' => EcommercewdModelProducts::REVIEWS_COUNT_TO_LOAD, 'color_scheme' => $options->social_media_integration_fb_color_scheme));
        ?>
    </div>
</div>
