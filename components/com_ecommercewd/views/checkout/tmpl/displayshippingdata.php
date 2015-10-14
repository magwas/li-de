<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

WDFHelper::add_script('js/framework/utils.js', true, true);

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;

$billing_form_fields = $this->billing_form_fields;
$shipping_form_fields = $this->shipping_form_fields;
$pager_data = $this->pager_data;


WDFDocument::set_title(WDFText::get('CHECKOUT'));
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- panel -->
            <div class="wd_shop_panel_user_data panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <!-- form -->
                            <form name="wd_shop_main_form"
                                  class="form-horizontal"
                                  role="form"
                                  action=""
                                  method="POST">
								<h3 class="wd_shop_header">
									<?php echo WDFText::get('BILLING_DATA'); ?>
								</h3>
                                <?php
                                foreach ($billing_form_fields as $form_field_name => $form_field) {
                                    switch ($form_field['type']) {
                                        case 'select':
                                            ?>
                                            <div class="form-group">
                                                <label for="<?php echo $form_field['name']; ?>"
                                                       class="col-sm-4 control-label">
                                                    <?php echo $form_field['label']; ?>:
                                                    <?php if ($form_field['required'] == true) { ?>
                                                        <span class="wd_star">*</span>
                                                    <?php } ?>
                                                </label>

                                                <div class="col-sm-8">
                                                    <?php
                                                    $class_required = $form_field['required'] == true ? 'wd_shop_required_field' : '';
                                                    echo JHtml::_('select.genericlist', $form_field['options'], $form_field['name'], 'class="form-control ' . $class_required . '"', 'id', 'name', $form_field['value']);
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            break;
                                        default:
                                            ?>
                                                <div class="form-group">
                                                    <label for="<?php echo $form_field['name']; ?>"
                                                           class="col-sm-4 control-label">
                                                        <?php echo $form_field['label']; ?>:
                                                        <?php if ($form_field['required'] == true) { ?>
                                                            <span class="wd_star">*</span>
                                                        <?php } ?>
                                                    </label>

                                                    <div class="col-sm-8">
                                                        <?php
                                                        $class_required = $form_field['required'] == true ? 'wd_shop_required_field' : '';
                                                        ?>
                                                        <input type="<?php echo $form_field['type']; ?>"
                                                               name="<?php echo $form_field['name']; ?>"
                                                               value="<?php echo $form_field['value']; ?>"
                                                               id="<?php echo $form_field['name']; ?>"
                                                               class="form-control <?php echo $class_required; ?>"
                                                               placeholder="<?php echo $form_field['placeholder']; ?>">
                                                    </div>
                                                </div>
                                            <?php
                                            break;
                                    }
                                }
                                ?>
								<h3 class="wd_shop_header">
									<?php echo WDFText::get('SHIPPING_DATA'); ?>
								</h3>
								<input type="checkbox" value="1" onclick="wd_ShopCopyBillingInformation(event,this);" id="wd_shop_copy_billing_info" />
								<label for="wd_shop_copy_billing_info"><?php echo WDFText::get('COPY_BILLING_INFO'); ?></label>			
                                <?php
                                foreach ($shipping_form_fields as $form_field_name => $form_field) {
                                    switch ($form_field['type']) {
                                        case 'select':
                                            ?>
                                            <div class="form-group">
                                                <label for="<?php echo $form_field['name']; ?>"
                                                       class="col-sm-4 control-label">
                                                    <?php echo $form_field['label']; ?>:
                                                    <?php if ($form_field['required'] == true) { ?>
                                                        <span class="wd_star">*</span>
                                                    <?php } ?>
                                                </label>

                                                <div class="col-sm-8">
                                                    <?php
                                                    $class_required = $form_field['required'] == true ? 'wd_shop_required_field' : '';
                                                    echo JHtml::_('select.genericlist', $form_field['options'], $form_field['name'], 'class="form-control ' . $class_required . '"', 'id', 'name', $form_field['value']);
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            break;
                                        default:
                                            ?>
                                                <div class="form-group">
                                                    <label for="<?php echo $form_field['name']; ?>"
                                                           class="col-sm-4 control-label">
                                                        <?php echo $form_field['label']; ?>:
                                                        <?php if ($form_field['required'] == true) { ?>
                                                            <span class="wd_star">*</span>
                                                        <?php } ?>
                                                    </label>

                                                    <div class="col-sm-8">
                                                        <?php
                                                        $class_required = $form_field['required'] == true ? 'wd_shop_required_field' : '';
                                                        ?>
                                                        <input type="<?php echo $form_field['type']; ?>"
                                                               name="<?php echo $form_field['name']; ?>"
                                                               value="<?php echo $form_field['value']; ?>"
                                                               id="<?php echo $form_field['name']; ?>"
                                                               class="form-control <?php echo $class_required; ?>"
                                                               placeholder="<?php echo $form_field['placeholder']; ?>">
                                                    </div>
                                                </div>
                                            <?php
                                            break;
                                    }
                                }
                                ?>								

                                <input type="hidden" name="data" value="shipping_data">
                            </form>
                        </div>
                    </div>

                    <!-- alert -->
                    <div class="wd_shop_checkout_alert_incorrect_data alert alert-danger hidden">
                        <p><?php echo WDFText::get('MSG_FILL_REQUIRED_FIELDS'); ?></p>
                    </div>
                </div>
            </div>

            <!-- pager -->
            <div>
                <ul class="pager">
                    <?php
                    $btn_cancel_checkout_data = $pager_data['btn_cancel_checkout_data'];
                    ?>
                    <li class="previous">
                        <a href="<?php echo $btn_cancel_checkout_data['url']; ?>">
                            <span><?php echo WDFText::get('BTN_CANCEL_CHECKOUT'); ?></span>
                        </a>
                    </li>

                    <?php
                    if (isset($pager_data['btn_prev_page_data'])) {
                        $btn_prev_page_data = $pager_data['btn_prev_page_data'];
                        ?>
                        <li class="previous">
                            <a href="<?php echo $btn_prev_page_data['action']; ?>"
                               onclick="onWDShop_pagerBtnClick(event, this); return false;">
                                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                                <span><?php echo $btn_prev_page_data['text']; ?></span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset($pager_data['btn_next_page_data'])) {
                        $btn_next_page_data = $pager_data['btn_next_page_data'];
                        ?>
                        <li class="next">
                            <a href="<?php echo $btn_next_page_data['action']; ?>"
                               onclick="onWDShop_pagerBtnClick(event, this); return false;">
                                <span><?php echo $btn_next_page_data['text']; ?></span>&nbsp;
                                <span class="glyphicon glyphicon-arrow-right"></span>
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