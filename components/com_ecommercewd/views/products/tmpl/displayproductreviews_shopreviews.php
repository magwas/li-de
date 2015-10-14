<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_shopreviews.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_shopreviews.js');


$options = $this->options;

$user_row = $this->user_row;

$product_row = $this->product_row;

?>

<!-- write review -->
<?php
if (($options->feedback_enable_guest_feedback == 0) && (WDFHelper::is_user_logged_in() == false)) {
    ?>
    <div class="wd_shop_write_review_container row">
        <div class="col-sm-12">
            <div class="wd_divider"></div>
        </div>

        <div class="col-sm-12">
            <div class="alert alert-info">
                <span><?php echo WDFText::get('MSG_LOG_IN_TO_WRITE_A_REVIEW', JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=displaylogin')); ?></span>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="wd_divider"></div>
        </div>
    </div>
<?php
} else {
    ?>
    <div class="wd_shop_write_review_container row">
        <!-- top divider -->
        <div class="col-sm-12">
            <div class="wd_shop_write_review_top_divider wd_divider"></div>
        </div>

        <!-- data -->
        <div class="wd_shop_write_review_data_container wd_hidden col-sm-12">
            <form name="wd_shop_form_write_review" id="wd_shop_form_write_review"
                  action="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=save_product_review&product_id=' . $product_row->id; ?>"
                  method="POST">
                <!-- user name -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="wd_shop_user_name" class="col-sm-12 control-label">
                                <?php echo WDFText::get("YOUR_NAME"); ?>:
                            </label>

                            <div class="col-sm-4">
                                <input class="form-control"
                                       id="wd_shop_user_name"
                                       name="user_name"
                                       value="<?php echo $user_row->name; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- text -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="wd_shop_review_text" class="col-sm-12 control-label">
                                <?php echo WDFText::get("REVIEW"); ?>:
                            </label>

                            <div class="col-sm-12">
                                <textarea name="review_text"
                                          id="wd_shop_review_text"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- alert -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="wd_shop_alert_fill_fields alert alert-danger hidden">
                                <p><?php echo WDFText::get('MSG_FILL_NAME_AND_REVIEW'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- bottom divider -->
        <div class="col-sm-12">
            <div class="wd_shop_write_review_bottom_divider wd_divider"></div>
        </div>

        <!-- buttons -->
        <div class="wd_shop_write_review_buttons col-sm-12 text-center">
            <div class="wd_shop_btn_group_reviews_closed btn-group btn-group-xs">
                <a class="btn btn-primary" onclick="wdShop_onBtnWriteReviewClick(event, this); return false;">
                    <?php echo WDFText::get('BTN_WRITE_REVIEW'); ?>
                </a>
            </div>

            <div class="wd_shop_btn_group_reviews_opened wd_hidden btn-group btn-group-xs">
                <a class="btn btn-primary" onclick="wdShop_onBtnSubmitReviewClick(event, this); return false;">
                    <?php echo WDFText::get('BTN_SUBMIT_REVIEW'); ?>
                </a>

                <a class="btn btn-default" onclick="wdShop_onBtnCancelReviewClick(event, this); return false;">
                    <?php echo WDFText::get('BTN_CANCEL_REVIEW'); ?>
                </a>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- reviews -->
<div class="wd_shop_reviews_container row">
    <div class="wd_shop_review_template col-sm-12">
        <div class="wd_shop_panel_user_data panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <!-- user name -->
                    <div class="col-sm-8">
                        <h4 class="wd_shop_review_user_name">
                        </h4>
                    </div>

                    <!-- date -->
                    <div class="col-sm-4 text-right">
                        <h4>
                            <small class="wd_shop_review_date"></small>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <!-- text -->
                    <div class="col-sm-12">
                        <p class="wd_shop_review_text text-justify">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-center">
        <a class="wd_shop_btn_load_more btn btn-default"
           onclick="wdShop_onBtnLoadMoreClick(event, this); return false;">
            <?php echo WDFText::get('BTN_LOAD_MORE'); ?>
        </a>
    </div>
</div>

<script>
    var wdShop_writeReview = <?php echo WDFInput::get('write_review', 0, 'int') == 1 ? 'true' : 'false'; ?>;

    var wdShop_productId = <?php echo $product_row->id; ?>;

    var wdShop_urlGetProductReviews = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=ajax_getproductreviews'; ?>";
</script>