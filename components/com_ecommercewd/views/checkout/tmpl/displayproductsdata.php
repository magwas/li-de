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

$products_data = $this->products_data;
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
                        <div class="col-sm-12">
                            <h2 class="wd_shop_header">
                                <?php echo WDFText::get('PRODUCTS_DATA'); ?>
                            </h2>

                            <!-- product data form -->
                            <form name="wd_shop_main_form" action="" method="POST">
                                <ul class="wd_shop_product_containers_list">
                                    <?php
                                    foreach ($products_data as $product_data) {
											$order_product_id = $product_data->order_product_id;
                                        ?>
                                        <!-- product data container -->
                                        <li class="wd_shop_product_data_container"
                                            count_is_unlimited="<?php echo $product_data->unlimited; ?>"
                                            count_available="<?php echo $product_data->amount_in_stock; ?>">
                                            <div class="row">
                                                <!-- name -->
                                                <div class="col-sm-12">
                                                    <h4 class="wd_shop_header_sm">
                                                        <?php echo $product_data->name; ?>
                                                    </h4>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row">
                                                        <!-- count -->
                                                        <div class="form-group col-sm-12">
                                                            <?php
                                                            if ($product_data->is_available == true) {
                                                                ?>
                                                                <label
                                                                    for="wd_shop_product_<?php echo $product_data->id; ?>_data_quantity"
                                                                    class="control-label">
                                                                    <?php echo WDFText::get('QUANTITY') ?>:
                                                                </label>

																 <input type="number"
																   name="product_count_<?php echo $product_data->id . '_' . $order_product_id; ?>"
																   id="wd_shop_product_<?php echo $product_data->id  . '_' . $order_product_id; ?>_data_quantity"
																   class="wd_shop_product_data_count form-control wd-input-xs"
																   value="<?php echo $product_data->count; ?>" min="1">
															<?php
                                                            }
                                                            ?>

                                                            <div>
                                                                <small><?php echo $product_data->available_msg; ?></small>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <!-- parameters -->
                                                        <?php
                                                        foreach ($product_data->selectable_parameters_data as $selectable_parameter_data) {
															$parameter_id = $selectable_parameter_data->id;
															$name = $selectable_parameter_data->name;
															$values_list = $selectable_parameter_data->values_list;
															$value = $selectable_parameter_data->value;
															$type_id = $selectable_parameter_data->type_id;
                                                            ?>
                                                            <div class="form-group col-sm-12">
                                                                <label
                                                                    for="wd_shop_product_data_parameter_<?php echo $name; ?>">
                                                                    <?php echo $name; ?>:
                                                                </label>
																<div>

																<?php
																switch ($type_id) {
																	// Input field
																	case 2:
																		?>
																		<input type="text" name='product_parameter_<?php echo $product_data->id . '_' . $parameter_id. '_' . $order_product_id; ?>' id=""
																			   class=" wd_shop_parameter_input form-control wd-input-xs"
																			   value="<?php echo $value; ?>">
																		<?php
																		break;
																	// Select
																	case 3:
																		$default_value = array();
																		$default_value['value'] = 0;
																		$default_value['text'] = '- Select -';
																		$default_value['type_id'] = 0;
																		array_unshift($values_list, $default_value);

																		?>
																		<select id="wd_shop_selectable_parameter_<?php echo $name  . '_' . $order_product_id; ?>"
																				name='product_parameter_<?php echo $product_data->id . '_' . $parameter_id  . '_' . $order_product_id; ?>'
																				class=" wd_shop_parameter_select form-control wd-input-xs">
																			<?php
																			foreach ($values_list as $value_list) {
																				?>
																				<option
																					value="<?php echo $value_list['value'] ?>"
																												<?php echo ($value_list['value'] == $value) ? 'Selected="selected"' : '';?>">
																												<?php echo $value_list['text']; ?>
																											</option>
																										<?php
																										}
																			?>
																		</select>
																		<?php
																		break;
																	// Radio
																	case 4:
																		foreach ($values_list as $value_list) {
																			?>
																			<input type="radio"
																				   id="wd_shop_checkbox_parameter_<?php echo $name . $value_list['value'] . '_' . $order_product_id; ?>"
																				   name='product_parameter_<?php echo $product_data->id . '_' . $parameter_id . '_' . $order_product_id; ?>'
																				   value="<?php echo $value_list['value'] ?>"
																				   class="   parameters_input wd_shop_parameter_radio"
																											   <?php echo ($value_list['value'] == $value) ? 'checked="checked"' : '';?>">
																									<label
																										for="wd_shop_checkbox_parameter_<?php echo $name . $value_list['value'] . '_' . $order_product_id; ?>"
																										id="wd_shop_checkbox_parameter_<?php echo $name; ?>"
																										class="parameters_label">
																										<?php echo $value_list['text'] ?>
																									</label>

																								<?php
																								}
																		break;
																	// Checkbox
																	case 5:
																		foreach ($values_list as $value_list) {
																			?>
																			<input type="checkbox"
																				   id="wd_shop_checkbox_parameter_<?php echo $name . $value_list['value'] . '_' . $order_product_id; ?>"
																				   name='product_parameter_<?php echo $product_data->id . '_' . $parameter_id . '_' . $order_product_id; ?>[]'
																				   value="<?php echo $value_list['value'] ?>"
																				   class=" parameters_input wd_shop_parameter_checkbox"
																											   <?php
																												if (gettype($value) != 'string') {
																													echo in_array($value_list['value'], $value) ? 'checked="checked"' : '';
																												}
																									?>"
																										>
																										<label
																											for="wd_shop_checkbox_parameter_<?php echo $name . $value_list['value'] . '_' . $order_product_id; ?>"
																											id="label_<?php echo $name; ?>"
																											class="parameters_label">
																											<?php echo $value_list['text'] ?>
																										</label>
																									<?php
																									}
																		break;
																}?>
																</div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <!-- shipping methods -->
                                                <?php
                                                if (($product_data->enable_shipping == 1 or ($product_data->enable_shipping == 2 && $options->checkout_enable_shipping == 1)) && ($product_data->country_specified == true)) {
                                                    ?>
                                                    <div class="col-sm-8">
                                                        <div class="row">
                                                            <div class="form-group col-sm-12">
                                                                <?php
                                                                if (empty($product_data->shipping_method_rows) == false) {
                                                                    ?>
                                                                    <label>Shipping method</label>
                                                                    <?php
                                                                    for ($i = 0; $i < count($product_data->shipping_method_rows); $i++) {
                                                                        $shipping_method = $product_data->shipping_method_rows[$i];
                                                                        $checked = $shipping_method->checked == true ? 'checked="checked"' : '';
                                                                        ?>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio"
                                                                                       name="product_shipping_method_id_<?php echo $product_data->id . '_' . $product_data->order_product_id; ?>"
                                                                                       class="wd_shop_product_data_shipping_method_id"
                                                                                       value="<?php echo $shipping_method->id; ?>"
                                                                                    <?php echo $checked; ?>>
                                                                                <?php
                                                                                echo $shipping_method->label; ?>
                                                                            </label>
                                                                        </div>
                                                                        <?php
                                                                        $checked = '';
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <div class="alert alert-danger">
                                                                        <?php echo WDFText::get('MSG_THIS_ITEM_WILL_NOT_SHIP_TO_YOUR_COUNTRY'); ?>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>

                                <input type="hidden" name="data" value="products_data">
                            </form>

                            <!-- alert -->
                            <div class="wd_shop_checkout_alert_incorrect_data alert alert-danger hidden">
                                <p><?php echo WDFText::get('MSG_FILL_REQUIRED_FIELDS'); ?></p>
                            </div>
                        </div>
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
					
                    if (isset($pager_data['btn_next_page_data']) ) {
						
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