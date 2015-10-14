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

$pagination = $this->pagination;
$order_rows = $this->order_rows;


WDFDocument::set_title(WDFText::get('ORDERS'));
?>

<form name="wd_shop_main_form"
      action="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=displayorders'); ?>"
      method="POST">
    <input type="hidden" name="pagination_limit_start" value="<?php echo $pagination->limitstart; ?>">
    <input type="hidden" name="pagination_limit" value="<?php echo $pagination->limit; ?>">
</form>

<div class="container">
    <h1 class="wd_shop_header">
        <?php echo WDFText::get('ORDERS'); ?>
    </h1>

    <?php
    if (empty($order_rows) == false) {
        ?>
        <!-- orders -->
        <div class="row">
            <?php
            for ($i = 0; $i < count($order_rows); $i++) {
                $order_row = $order_rows[$i];
                ?>
                <div class="wd_shop_order_container col-sm-12"
                     order_id="<?php echo $order_row->id; ?>">
                    <div class="wd_shop_panel_product panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <!-- images -->
                                <div class="col-sm-3">
                                    <!-- images -->
                                    <div class="row">
                                        <?php
                                        // show big image if there is one product or 4 small images
                                        if (count($order_row->product_images) > 1) {
                                            $class_img_container_col = 'col-xs-6';
                                            $class_img_container_single = '';
                                        } else {
                                            $class_img_container_col = 'col-xs-12';
                                            $class_img_container_single = 'wd_shop_order_product_image_container_single';
                                        }

                                        // images
                                        $images_count_to_show = count($order_row->product_images) > 4 ? 3 : 4;
                                        for ($j = 0; $j < min(count($order_row->product_images), $images_count_to_show); $j++) {
                                            $product_image = $order_row->product_images[$j];
                                            ?>
                                            <div class="<?php echo $class_img_container_col; ?>">
                                                <div
                                                    class="wd_shop_order_product_image_container <?php echo $class_img_container_single; ?> wd_center_wrapper">
                                                    <div>
                                                        <?php
                                                        if ($product_image != '') {
                                                            ?>
                                                            <img class="wd_shop_order_product_image"
                                                                 src="<?php echo JURI::Root().$product_image; ?>">
                                                        <?php
                                                        } else {
                                                            ?>
                                                            <div class="wd_shop_order_product_no_image">
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
                                        <?php
                                        }

                                        // add ... image if there is more than 4 images
                                        if (count($order_row->product_images) > 4) {
                                            $product_image = $order_row->product_images[$j];
                                            ?>
                                            <div
                                                class="wd_shop_order_product_image_container <?php echo $class_img_container_col; ?> wd_center_wrapper">
                                                <div>
                                                    <div class="wd_shop_order_product_image_more">
                                                        <span>...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- details -->
                                <div class="col-sm-6">
                                    <a href="<?php echo $order_row->order_link; ?>"
                                       class="wd_shop_order_btn_product_names wd_shop_product_name btn btn-link">
                                        <!-- product names -->
                                        <?php echo $order_row->product_names; ?>

                                        <!-- order id -->
                                        <small>(<?php echo WDFText::get('ORDER_ID') . ': ' . $order_row->id; ?>)</small>
                                    </a>
									<p>
									<?php echo JText::_('COM_ECOMMERCEWD_SHOPER').':'.$order_row->name; ?>
									</p>
                                    <p>
                                        <!-- checkout date -->
                                        <small>
                                            <?php echo WDFText::get("CHECKOUT_DATE"); ?>:
                                        </small>
                                        <small>
                                            <?php echo date($options->option_date_format, strtotime($order_row->checkout_date)); ?>
                                        </small>

                                        <br>

                                        <!-- status -->
                                        <small>
                                            <?php echo WDFText::get("STATUS"); ?>:
                                        </small>
                                        <small>
                                            <?php echo $order_row->status_name; ?>
											<?php if(JRequest::getVar('product_id') != '') { 
											  $updLink = 'index.php?option=com_ecommercewd&controller=orders&task=update'.
											             '&product_id='.JRequest::getVar('product_id').
														 '&order_id='.$order_row->id.
														 '&Itemid='.JRequest::getVar('Itemid');
											?>
											<a href="<?php echo $updLink; ?>" class="btn btn-primary">
											  <?php echo JText::_('COM_ECOMMERCEWD_UPDATE'); ?>
											</a>
											<?php
											}
											?>
                                        </small>
                                    </p>
                                </div>

                                <div class="col-sm-3 text-right">
                                    <!-- price -->
                                    <p class="wd_shop_order_price_container">
                                        <span class="wd_shop_order_price_title wd_shop_product_price">
                                            <?php echo WDFText::get('PRICE'); ?>:
                                        </span>
                                        <br>
                                        <span class="wd_shop_order_price wd_shop_product_price">
                                            <?php echo $order_row->price_text; ?>
                                        </span>
                                    </p>

                                    <!-- tax price -->
                                    <p class="wd_shop_order_tax_price_container">
                                        <span class="wd_shop_order_tax_price_title">
                                            <?php echo WDFText::get('TAX'); ?>:
                                        </span>
                                        <br>
                                        <span class="wd_shop_order_tax_price">
                                            <?php echo $order_row->tax_price_text; ?>
                                        </span>
                                    </p>

                                    <!-- shipping price -->
                                    <p>
                                        <!-- shipping price -->
                                        <span class="wd_shop_order_shipping_price_title">
                                            <?php echo WDFText::get("SHIPPING"); ?>:
                                        </span>
                                        <br>
                                        <span class="wd_shop_order_shipping_price">
                                            <?php echo $order_row->shipping_price_text; ?>
                                        </span>
                                    </p>
									
									<div class="wd_divider"></div>	
										<!-- total price -->									
                                   <p>                                     
                                        <span class="wd_shop_order_price_title wd_shop_product_price">
                                            <?php echo WDFText::get("TOTAL_PRICE"); ?>:
                                        </span>
                                        <br>
                                        <span class="wd_shop_order_price wd_shop_product_price">
                                            <?php echo $order_row->total_price_text; ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <div class="wd_shop_order_ctrls">
                                        <a class="btn btn-link btn-sm"
                                           href="<?php echo $order_row->print_orders_link; ?>" target="_blank">
                                            <?php echo WDFText::get('BTN_PRINT_ORDER'); ?>
                                        </a>
										<?php
											$where_query = array( " published ='1' AND name='ecommercewd_pdfinvoice'" );
											$tools = WDFTool::get_tools( $where_query );
											if(empty($tools) == false){
										?>
											<a class="btn btn-link btn-sm"
											   href="<?php echo $order_row->pdf_invoice_link; ?>" >
												<?php echo WDFText::get('PDFINVOICE'); ?>
											</a>											
										<?php
										}
										?>
                                        <a class="btn btn-link btn-sm"
                                           href="<?php echo $order_row->order_link; ?>" >
                                            <?php echo WDFText::get('BTN_VIEW_ORDER_DETAILS'); ?>
                                        </a>
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

        <hr>

        <!-- pagination -->
        <?php echo $this->loadTemplate('barpagination') ?>
    <?php
    } else {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <?php echo WDFText::get('MSG_NO_ORDERS_YET') ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
