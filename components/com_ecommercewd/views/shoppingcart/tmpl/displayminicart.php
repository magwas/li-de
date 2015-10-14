<?php 
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined( '_JEXEC' ) or die( 'Restricted access' ); 

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/displayminicart.css');
$options = $this->options;

$order_product_rows = $this->order_product_rows;
$total_price_text = $this->total_price_text;
$minicart_params = $this->minicart_params;

?>

<div class="wd_shop_tooltip_container"></div>
<div class="minicart_module_container" id="minicart_module_container" >
	<div class="container">
		<?php
		if (empty($order_product_rows) == false) {
			?>
			<form name="wd_shop_minicart_main_form" action="" method="POST">
				<input type="hidden" name="order_product_id" value="">
			</form>

			<form name="wd_shop_form_products" action="" method="POST">
				<!-- products -->
				<div class="row mod_panel">
					<?php 
					for ($i = 0; $i < count($order_product_rows); $i++) {
						$order_product_row = $order_product_rows[$i];
						if ($order_product_row->product_image != '') {
							$el_order_product_image = '<img class="wd_shop_order_product_image" src="' . $order_product_row->product_image . '">';
						} else {
							$el_order_product_image = '
							<div class="wd_shop_order_product_no_image">
								<span class="glyphicon glyphicon-picture"></span>
								<br>
								<span>' . WDFText::get('NO_IMAGE') . '</span>
							</div>
							';
						}
						?>
						<div class="wd_shop_order_product_container"
							 order_product_id="<?php echo $order_product_row->id; ?>">
							<div class="wd_shop_panel_product  panel-default">
								<div class="panel-body ">
									<div class="spidershopminicart_table">
										<!-- image -->
										<div class="spidershopminicart_cell">
											<div
												class="wd_shop_order_product_image_container">
												<div>
													<?php echo $el_order_product_image; ?>
												</div>
											</div>
										</div>

										<!-- details -->
										<div class="spidershopminicart_cell spidershopminicart_special_cell">
											<div class="">
												<!-- count -->                                  
												<input type="hidden"
													   class="wd_shop_order_product_quantity form-control wd-input-xs"
													   value="<?php echo $order_product_row->product_count; ?>" >												
												<!-- name -->
												<a href="<?php echo $order_product_row->product_url; ?>"
												   class="wd_mod_shop_order_product_name wd_shop_product_name btn-link">
													<?php echo $order_product_row->product_name; ?>
												</a>
											</div>          
										</div>

										<div class="spidershopminicart_cell">
											<!-- price -->
											<p>
											<span>
												<span class="wd_shop_order_product_final_price wd_shop_product_price">
													<?php echo $order_product_row->product_final_price_text; ?>
												</span>
											</span>
											</p>
											<!-- subtotal -->
											<p>
											<span class="wd_shop_order_product_subtotal_title wd_shop_product_price">
												<?php echo WDFText::get('SUBTOTAL'); ?>:
											</span>
											<span class="wd_shop_order_product_subtotal wd_shop_product_price">
												<?php echo $order_product_row->subtotal_text; ?>
											</span>
											</p>
										</div>
									</div>
									<div class="text-right">
										<span class="wd_shop_quantity"> <?php echo WDFText::get('QUANTITY').': '. $order_product_row->product_count; ?> </span>
									</div>
									<!-- loading and alerts -->
									<div class="row">
										<div class="wd_shop_loading_clip_container wd_hidden  text-right">
											<span><?php echo WDFText::get('MSG_UPDATING'); ?></span>

											<div class="wd_loading_clip_small"></div>
										</div>

										<div class="wd_shop_alert_failed_to_update_container wd_hidden ">
											<div class="alert alert-danger">
											</div>
										</div>
									</div>
								</div>
								<?php if($minicart_params->show_remove_item == 1 or $minicart_params->show_checkout_item == 1):?>
									<div class="panel-footer">
										<div class="minicart_module_padding">
											<div class=" text-right">
												<div class="wd_shop_order_product_ctrls">
													<?php
													if (($options->checkout_enable_checkout == 1) && ($order_product_row->product_available == true) && ($minicart_params->show_checkout_item == 1) ) {
														?>
														<a class="btn-link btn-sm"
														   onclick="wdShop_onBtnCheckoutProductClick(event, this); return false;">
															<?php echo WDFText::get('BTN_CHECKOUT_THIS_ITEM'); ?>
														</a>
													<?php
													}
													?>
													<?php if($minicart_params->show_remove_item == 1):?>
														<a class="btn-link btn-sm"
														   onclick="wdShop_mod_onBtnRemoveProductClick(event, this); return false;">
															<?php echo WDFText::get('BTN_REMOVE_THIS_ITEM'); ?>
														</a>
													<?php endif;?>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>
							</div>
						</div>
					<?php
					}
					?>
					<div class="wd_divider"></div>

					<!-- total -->
					<div class="minicart_module_padding">
						<div class="text-right">
							<span class="wd_mod_shop_total_title wd_shop_product_price">
								<?php echo WDFText::get('TOTAL_PRICE'); ?>:
							</span>
							<span class="wd_mod_shop_total wd_shop_product_price">
								<?php echo $total_price_text; ?>
							</span>
						</div>
					</div>

					

					<!-- ctrls -->				
					<div class="minicart_module_padding">
						<div class="text-right">						
							<?php if($minicart_params->show_remove_all == 1):?>
								<a class="btn btn-default btn-sm"
								   data-toggle="tooltip"
								   onclick="wdShop_onBtnRemoveAllProductsClick(event, this); return false;">
									<?php echo WDFText::get('BTN_REMOVE_ALL'); ?>
								</a>
							<?php endif;?>
							<?php
							if ($options->checkout_enable_checkout == 1) {
								?>
								<a class="btn btn-primary btn-sm"
								   onclick="wdShop_onBtnCheckoutAllProductsClick(event, this); return false;">
									<?php echo WDFText::get('BTN_CHECKOUT_ALL'); ?>
								</a>
							<?php
							}
							?>
						</div>
					</div>
					<?php if($minicart_params->show_go_to_cart == 1):?>
						<div class="text-right wd_shop_go_to_cart ">
							<a href="<?php echo $minicart_params->go_to_cart_url;?>"><?php echo WDFText::get('GO_TO_CART') ?></a>
						</div>
					<?php endif;?>
				</div>


			</form>
		<?php
		} else {
			?>
			<div class="row">
				<div class="">
					<div class="alert alert-info">
						<?php echo WDFText::get('MSG_YOUR_CART_IS_EMPTY') ?>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>

