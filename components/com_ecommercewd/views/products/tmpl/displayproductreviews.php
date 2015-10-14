<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;
$theme = $this->theme;

$product_row = $this->product_row;


WDFDocument::set_title(WDFText::get('PRODUCT_REVIEWS'));
?>

<div class="wd_shop_tooltip_container"></div>

<div class="container">
    <!-- header -->
    <h2 class="wd_shop_header">
        <?php echo WDFText::get('PRODUCT_REVIEWS'); ?>
    </h2>

    <!-- product data -->
    <div class="row">
        <!-- image -->
        <div class="col-sm-4">
            <div class="wd_shop_product_image_container wd_center_wrapper img-thumbnail">
                <div>
                    <?php
                    if ($product_row->image != '') {
                        ?>
                        <img src="<?php echo $product_row->image; ?>"
                             class="wd_shop_product_image"
                             alt="<?php echo $product_row->name; ?>">
                    <?php
                    } else {
                        ?>
                        <div class="wd_shop_product_no_image">
                            <span class="glyphicon glyphicon-picture"></span>
                            <br>
                            <span><?php echo WDFText::get('NO_IMAGE'); ?></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <!-- name -->
            <a href="<?php echo $product_row->url; ?>" class="wd_shop_product_name btn btn-link">
                <?php echo $product_row->name; ?>
            </a>

            <?php
            if ($options->feedback_enable_product_rating == 1) {
                ?>
                <p>
                    <?php echo WDFHTML::jf_bs_rater('', 'wd_shop_star_rater', '', $product_row->rating, $product_row->can_rate, $product_row->rating_url, $product_row->rating_msg, false, 5, 16, $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color);
                    ?>
                </p>
            <?php
            }
            ?>

            <!-- description -->
            <p class="text-justify">
                <?php echo $product_row->description; ?>
            </p>
        </div>
    </div>

    <?php
    if ($options->social_media_integration_use_fb_comments == 1) {
        echo $this->loadTemplate('fbcomments');
    } else {
        echo $this->loadTemplate('shopreviews');
    }
    ?>
</div>
