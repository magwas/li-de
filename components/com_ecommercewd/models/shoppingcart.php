<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdModelShoppingcart extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private $order_product_rows;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_order_product_rows() {
        if ($this->order_product_rows == null) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $j_user = JFactory::getUser();

            $model_options = WDFHelper::get_model('options');
            $options = $model_options->get_options();

            $decimals = $options->option_show_decimals == 1 ? 2 : 0;

            $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

            $query->clear();
            $query->select('T_ORDER_PRODUCTS.id');
            $query->select('T_ORDER_PRODUCTS.product_id');
            $query->select('T_ORDER_PRODUCTS.product_parameters');
			$query->select('T_ORDER_PRODUCTS.product_parameters_price');
            $query->select('T_ORDER_PRODUCTS.product_count');
            $query->select('T_PRODUCTS.name AS product_name');
            $query->select('T_PRODUCTS.images AS product_images_json');
            $query->select('T_PRODUCTS.price AS product_price');
            $query->select('T_TAXES.rate AS product_tax_rate');
            $query->select('T_DISCOUNTS.rate AS product_discount_rate');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->select('T_USERGROUP_DISCOUNTS.rate AS usergroup_discount_rate');
            } else {
                $query->select('0 AS usergroup_discount_rate');
            }
            $query->select('T_PRODUCTS.amount_in_stock AS product_amount_in_stock');
            $query->select('T_PRODUCTS.unlimited AS product_unlimited');
            $query->select('T_ORDER_PRODUCTS.product_parameters AS product_parameters_json');
            $query->from('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS');
            $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON T_ORDER_PRODUCTS.product_id = T_PRODUCTS.id');
            $query->leftJoin('(SELECT * FROM #__ecommercewd_taxes WHERE published = 1) AS T_TAXES ON T_PRODUCTS.tax_id = T_TAXES.id');
            $query->leftJoin('(SELECT * FROM #__ecommercewd_discounts WHERE published = 1) AS T_DISCOUNTS ON T_PRODUCTS.discount_id = T_DISCOUNTS.id');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->leftJoin('#__ecommercewd_users AS T_USERS ON T_USERS.j_user_id = ' . $j_user->id);
                $query->leftJoin('#__ecommercewd_usergroups AS T_USERGROUPS ON T_USERS.usergroup_id = T_USERGROUPS.id');
                $query->leftJoin('(SELECT * FROM #__ecommercewd_discounts WHERE published = 1) AS T_USERGROUP_DISCOUNTS ON T_USERGROUPS.discount_id = T_USERGROUP_DISCOUNTS.id');
            }
            $query->where('T_ORDER_PRODUCTS.order_id = 0');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->where('T_ORDER_PRODUCTS.j_user_id = ' . $j_user->id);
            } else {
                $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');
                if (empty($order_product_rand_ids) == false) {
                    $query->where('T_ORDER_PRODUCTS.j_user_id = 0');
                    $query->where('T_ORDER_PRODUCTS.rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
                } else {
                    $query->where('0');
                }
            }
            $query->order('T_ORDER_PRODUCTS.id ASC');
            $db->setQuery($query);
            $order_product_rows = $db->loadObjectList();


            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                return false;
            }

            // additional data
            foreach ($order_product_rows as $order_product_row) {
                // product image
                $product_images = WDFJson::decode($order_product_row->product_images_json);
                $order_product_row->product_image = count($product_images) > 0 ? $product_images[0] : '';

                // product url
                $order_product_row->product_url = JRoute::_('index.php?option=com_' . WDFHelper::get_com_name() . '&controller=products&task=displayproduct&product_id=' . $order_product_row->product_id);

                // taxes and discounts
                $order_product_row->product_discount_rate = floatval($order_product_row->product_discount_rate);
                $order_product_row->usergroup_discount_rate = floatval($order_product_row->usergroup_discount_rate);
                $order_product_row->product_tax_rate = floatval($order_product_row->product_tax_rate);

                // price data
				$order_product_row->product_price_text = number_format($order_product_row->product_price + $order_product_row->product_parameters_price, $decimals);
                $order_product_row->product_final_price = ($order_product_row->product_price + $order_product_row->product_parameters_price) * (1 - $order_product_row->product_discount_rate / 100) * (1 - $order_product_row->usergroup_discount_rate / 100) * (1 + $order_product_row->product_tax_rate / 100);

				$order_product_row->product_final_price_text = number_format($order_product_row->product_final_price, $decimals);
                ob_start();
                $discount = $order_product_row->product_discount_rate == 0 ? '-' : $order_product_row->product_discount_rate . '%';
				$user_discount = $order_product_row->usergroup_discount_rate == 0 ? '-' : $order_product_row->usergroup_discount_rate . '%';
                $tax = $order_product_row->product_tax_rate == 0 ? '-' : $order_product_row->product_tax_rate . '%';
                ?>
<!--                <span>--><?php //echo WDFText::get('PRICE') . ':&nbsp;' . $order_product_row->product_price_text; ?><!--</span>-->
<!--                <br>-->
                <?php if ($discount != '-'): ?>
                    <span><?php echo WDFText::get('DISCOUNT') . ':&nbsp;' . $discount; ?></span>
                    <br>
                <?php endif; ?>
                <?php if ($user_discount != '-'): ?>
                    <span><?php echo WDFText::get('USER_DISCOUNT') . ':&nbsp;' . $user_discount; ?></span>
                    <br>
                <?php endif; ?>
                <?php if ($tax != '-'): ?>
                    <span><?php echo WDFText::get('TAX') . ':&nbsp;' . $tax; ?></span>
                <?php endif; ?>
                <?php
                $order_product_row->product_final_price_info = WDFTextUtils::remove_html_spaces(ob_get_clean());

                // amount in stock
                if ($order_product_row->product_unlimited == 1) {
                    $order_product_row->product_available = true;
                    $order_product_row->product_availability_msg = WDFText::get('IN_STOCK');
					$order_product_row->stock_class = 'wd_in_stock';
                } elseif ($order_product_row->product_amount_in_stock > 0) {
                    $order_product_row->product_available = true;
                    $order_product_row->product_availability_msg = WDFText::get('IN_STOCK') . ': ' . $order_product_row->product_amount_in_stock;
					$order_product_row->stock_class = 'wd_in_stock';
				} else {
                    $order_product_row->product_available = false;
                    $order_product_row->product_availability_msg = WDFText::get('OUT_OF_STOCK');
					$order_product_row->stock_class = 'wd_out_of_stock';
                }

                // parameter datas
                $product_parameter_datas = $this->get_product_parameter_datas($order_product_row->product_id, $order_product_row->id, $order_product_row->product_parameters_json);
                if ($product_parameter_datas === false) {
                    WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
                }
                $order_product_row->product_parameter_datas = $product_parameter_datas;

                // subtotal
                $order_product_row->subtotal = $order_product_row->product_final_price * $order_product_row->product_count;
                $order_product_row->subtotal_text = number_format($order_product_row->subtotal, $decimals);

                // add currency symbols
                if ($row_default_currency->sign_position == 0) {
                    $order_product_row->product_price_text = $row_default_currency->sign . $order_product_row->product_price_text;
                    $order_product_row->product_final_price_text = $row_default_currency->sign . $order_product_row->product_final_price_text;
                    $order_product_row->subtotal_text = $row_default_currency->sign . $order_product_row->subtotal_text;
                } else {
                    $order_product_row->product_price_text = $order_product_row->product_price_text . $row_default_currency->sign;
                    $order_product_row->product_final_price_text = $order_product_row->product_final_price_text . $row_default_currency->sign;
                    $order_product_row->subtotal_text = $order_product_row->subtotal_text . $row_default_currency->sign;
                }
            }

            $this->order_product_rows = $order_product_rows;
			
        }

        return $this->order_product_rows;
    }

    public function get_order_products_total_price_text() {
        $db = JFactory::getDbo();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        $order_product_rows = $this->get_order_product_rows();

        $total = 0;
        foreach ($order_product_rows as $order_product_row) {
            $total += $order_product_row->subtotal;
        }
        $decimals = $options->option_show_decimals == 1 ? 2 : 0;
        $total_text = number_format($total, $decimals);
        if ($row_default_currency->sign_position == 0) {
            $total_text = $row_default_currency->sign . $total_text;
        } else {
            $total_text = $total_text . $row_default_currency->sign;
        }
		
        return $total_text;
    }

    public function get_order_product_rand_id() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('rand_id');
        $query->from('#__ecommercewd_orderproducts');
        $db->setQuery($query);
        $existing_rand_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            return false;
        }

        do {
            $rand_id = rand(10000000, 99999999);
        } while (in_array($rand_id, $existing_rand_ids) == true);

        return $rand_id;
    }

	public function get_minicart_params(){
	
		$minicart_params = WDFModuleHelper::get_module_params('mod_ecommercewd_minicart');
		$minicart_params->go_to_cart_url = JRoute::_( 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart' );
										   
		return $minicart_params;
	}

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_product_parameter_datas($product_id, $product_row_id, $order_product_parameters_json) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
		$decimals = $options->option_show_decimals == 1 ? 2 : 0;
        // get product parameters
        $query->select('T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
		$query->select('T_PARAMETERS.type_id');
        $query->select('T_PRODUCT_PARAMETERS.parameter_value AS value');
		$query->select('T_PRODUCT_PARAMETERS.parameter_value_price AS value_price');
        $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
        $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
        $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_id);
        $query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
        $db->setQuery($query);
        $parameter_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }

        // order product parameter values map
        $order_product_parameters = WDFJson::decode($order_product_parameters_json);
        $order_product_prameter_values = array();


        foreach ($order_product_parameters as $parameter_id_product_row_id => $parameter_value) {
            $order_product_prameter_values[$parameter_id_product_row_id] = $parameter_value;
        }


        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        // parameter datas map
        $parameter_datas_map = array();
        foreach ($parameter_rows as $parameter_row) {
            $parameter_id = $parameter_row->id;
			$price_sign = substr($parameter_row->value_price,0,1);	
			$parameter_row->value_price = $price_sign.number_format(substr($parameter_row->value_price,1), $decimals);	
            if (isset($parameter_datas_map[$parameter_id])) {
                $parameter_datas_map[$parameter_id]->values[] = array('value' => $parameter_row->value, 'price' => $parameter_row->value_price);
            } else {
                $parameter_data = new stdClass();
                $parameter_data->id = $parameter_row->id;
                $parameter_data->name = $parameter_row->name;
                $parameter_data->type_id = $parameter_row->type_id;
                $parameter_data->values[] = array('value' => $parameter_row->value, 'price' => $parameter_row->value_price);
                if (isset($order_product_prameter_values[$parameter_data->id . '_' . $product_row_id])) {
                    $parameter_data->value = $order_product_prameter_values[$parameter_data->id . '_' . $product_row_id];
                }
//                else if (count($parameter_data->values) > 0) {
//                    $parameter_data->value = $parameter_data->values[0]['value'];
//                }
                else {
                    $parameter_data->value = '';
                }
                $parameter_datas_map[$parameter_id] = $parameter_data;          
            }
        }

        $parameter_datas = array();
        foreach ($parameter_datas_map as $parameter_data) {
             if (count($parameter_data->values) <= 1 && $parameter_data->type_id != 1 && $parameter_data->type_id != 2)  {
                continue;
            }
            for ($i = 0; $i < count($parameter_data->values); $i++) {
                if ($parameter_data->values[$i]['price'] != '+' && $parameter_data->values[$i]['price'] != '') {
					if($row_default_currency->sign_position == 1){
						$parameter_data->values[$i]['text'] = $parameter_data->values[$i]['value'] . ' (' . $parameter_data->values[$i]['price'] . $row_default_currency->sign . ')';
					}
					else{
						$parameter_data->values[$i]['text'] = $parameter_data->values[$i]['value'] . ' (' . substr($parameter_data->values[$i]['price'],0,1). $row_default_currency->sign . substr($parameter_data->values[$i]['price'],1) .  ')';					
					}                
				} else {
                    $parameter_data->values[$i]['text'] = $parameter_data->values[$i]['value'];
                }
            }
            $parameter_datas[] = $parameter_data;
        }
        return $parameter_datas;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}