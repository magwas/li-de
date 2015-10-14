<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelCheckout extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static $MAX_PAYPAL_DESCRIPTION_LENGTH = 127;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private $checkout_data;
    private $license_pages;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function init_checkout() {
        $db = JFactory::getDbo();
		$session = JFactory::getSession();
        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        $checkout_data = array();
        $checkout_data['session_id'] = time();
        $checkout_data['checkout_type'] = WDFInput::get_task() == 'quick_checkout' ? 'quick_checkout' : 'normal_checkout';
        $checkout_data['payment_method'] = '';
        $checkout_data['currency_id'] = $row_default_currency->id;
        $checkout_data['currency_code'] = $row_default_currency->code;
        $checkout_data['currency_sign'] = $row_default_currency->sign;
        $checkout_data['currency_sign_position'] = $row_default_currency->sign_position;
        $this->add_checkout_initial_billing_data($checkout_data);		
        $this->add_checkout_initial_shipping_data($checkout_data);
        $this->add_checkout_initial_products_data($checkout_data);
		$session->set( 'checkout_data_' . $checkout_data['session_id'], serialize($checkout_data) );

        return $checkout_data['session_id'];
    }

    public function get_checkout_data() {
		$session = JFactory::getSession();
        if ($this->checkout_data == null) {
            $session_id = WDFInput::get('session_id', 0, 'float');
            if ($session_id == 0) {
                WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=0');
            }
           
			$checkout_data = unserialize($session->get( 'checkout_data_' . $session_id ));
            $this->update_checkout_data($checkout_data);
			$session->set( 'checkout_data_' . $session_id, serialize($checkout_data) );
            $this->checkout_data = $checkout_data;

        }

        return $this->checkout_data;
    }

    public function is_final_checkout_data_valid($check_payment_method = true) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $options_model = WDFHelper::get_model('options');
        $options = $options_model->get_options();
		$checkout_options = $this->checkout_options();
        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        $checkout_data = $this->get_checkout_data();


        // validate checkout data
        $is_data_invalid = false;
        if ($checkout_data == null) {
            $is_data_invalid = true;
        }

        // validate checkout type
        if ($is_data_invalid == false) {
            switch ($checkout_data['checkout_type']) {
                case 'normal_checkout':
                case 'quick_checkout':
                    break;
                default:
                    $is_data_invalid = true;
                    break;
            }
        }

        // validate payment method
      /*  if (($check_payment_method == true) && ($is_data_invalid == false)) {
            if ((($checkout_options->without_online_payment == 0) && ($checkout_data['payment_method'] == 'without_online_payment')) || (($checkout_options->paypalexpress == 0) && ($checkout_data['payment_method'] == 'paypalexpress'))
            ) {
                $is_data_invalid = true;
            }
        }*/

        // validate currency
        if ($is_data_invalid == false) {
            if (($row_default_currency->id != $checkout_data['currency_id']) || ($row_default_currency->code != $checkout_data['currency_code'])
            ) {
                $is_data_invalid = true;
            }
        }

        // validate required fields
		
        if ($is_data_invalid == false) {
            if (
                ($checkout_data['billing_data_first_name'] == '')
                || (($options->user_data_middle_name == 2) && ($checkout_data['billing_data_middle_name'] == ''))
                || (($options->user_data_last_name == 2) && ($checkout_data['billing_data_last_name'] == ''))
                || (JMailHelper::isEmailAddress($checkout_data['billing_data_email']) == false)
                || (($options->user_data_company == 2) && ($checkout_data['billing_data_company'] == ''))
                || (($options->user_data_country == 2) && (!intval($checkout_data['billing_data_country_id'])))
                || (($options->user_data_state == 2) && ($checkout_data['billing_data_state'] == ''))
                || (($options->user_data_city == 2) && ($checkout_data['billing_data_city'] == ''))
                || (($options->user_data_address == 2) && ($checkout_data['billing_data_address'] == ''))
                || (($options->user_data_mobile == 2) && ($checkout_data['billing_data_mobile'] == ''))
                || (($options->user_data_phone == 2) && ($checkout_data['billing_data_phone'] == ''))
                || (($options->user_data_fax == 2) && ($checkout_data['billing_data_fax'] == ''))
                || (($options->user_data_zip_code == 2) && ($checkout_data['billing_data_zip_code'] == ''))
                || (($options->user_data_middle_name == 2) && ($checkout_data['shipping_data_middle_name'] == ''))
                || (($options->user_data_last_name == 2) && ($checkout_data['shipping_data_last_name'] == ''))
                || (($options->user_data_company == 2) && ($checkout_data['shipping_data_company'] == ''))
                || (($options->user_data_country == 2) && (!intval($checkout_data['shipping_data_country_id'])))
                || (($options->user_data_state == 2) && ($checkout_data['shipping_data_state'] == ''))
                || (($options->user_data_city == 2) && ($checkout_data['shipping_data_city'] == ''))
                || (($options->user_data_address == 2) && ($checkout_data['shipping_data_address'] == ''))
                || (($options->user_data_zip_code == 2) && ($checkout_data['shipping_data_zip_code'] == ''))				
            ) {
                $is_data_invalid = true;
            }
        }

        // validate country
        $row_country = WDFDb::get_row_by_id('countries', $checkout_data['shipping_data_country_id']);
        if ($is_data_invalid == false) {
            if ($row_country->id != $checkout_data['shipping_data_country_id']) {
                $is_data_invalid = true;
            }
        }

        // validate products
        if ($is_data_invalid == false) {
            $products_data = $checkout_data['products_data'];
            if (empty($products_data) == false) {
                foreach ($products_data as $product_data) {
                    // check product_exists
                    $row_product = WDFDb::get_row_by_id('products', $product_data->id);
                    if (($row_product->id == 0) || ($row_product->published == 0)) {
                        $is_data_invalid = true;
                        break;
                    }

                    // check product in shopping cart (for normal checkout)
                    if ($checkout_data['checkout_type'] == 'normal_checkout') {
                        $user_order_product_ids = $this->get_user_order_product_ids();
                        $row_order_product = WDFDb::get_row_by_id('orderproducts', $product_data->order_product_id);
                        if (($row_order_product->id == 0) || ($row_order_product->product_id != $row_product->id) || (in_array($row_order_product->id, $user_order_product_ids) == false)) {
                            $is_data_invalid = true;
                            break;
                        }
                    }

                    // check availability
                    if (($row_product->unlimited == 0) && ($row_product->amount_in_stock < $product_data->count)) {
                        $is_data_invalid = true;
                        break;
                    }

                    // check parameters
                    foreach ($product_data->parameters as $parameter_id => $parameter_value) {
                        $query->clear();
                        $query->select('T_PARAMETERS.type_id AS type_id');
                        $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
                        $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
                        $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_data->id);
                        $query->where('T_PRODUCT_PARAMETERS.parameter_id = ' . $parameter_id);
                        $db->setQuery($query);
                        $type_id = $db->loadResult();

                        if ($type_id != 1 && $type_id != 2) {

                            if (!is_array($parameter_value)) {
                                $parameter_value = array($parameter_value);
                            }
                            foreach ($parameter_value as $value) {
                                if($value != "" && $value != '0') {
                                    $query->clear();
                                    $query->select('COUNT(*)');
                                    $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
                                    $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
                                    $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_data->id);
                                    $query->where('T_PRODUCT_PARAMETERS.parameter_id = ' . $parameter_id);
                                    $query->where('T_PRODUCT_PARAMETERS.parameter_value = ' . $db->quote($value));

//                                    echo $query;
                                    $db->setQuery($query);
                                    $parameter_values_exists = (int)$db->loadResult() == 0 ? false : true;

                                    if (($db->getErrorNum()) || ($parameter_values_exists == false)) {
                                        $is_data_invalid = true;
                                        break 2;
                                    }
                                }

                            }

                        } else {
                            $is_data_invalid = false;
                        }
                    }

                    // check shipping method id
                    $query->clear();
                    $query->select('T_SHIPPING_METHODS.id');
                    $query->from('#__ecommercewd_shippingmethods AS T_SHIPPING_METHODS');
                    $query->leftJoin('#__ecommercewd_shippingmethodcountries AS T_SHIPPING_METHOD_COUNTRIES ON T_SHIPPING_METHOD_COUNTRIES.shipping_method_id = T_SHIPPING_METHODS.id');
                    $query->leftJoin('#__ecommercewd_productshippingmethods AS T_PRODUCT_SHIPPING_METHODS ON T_PRODUCT_SHIPPING_METHODS.shipping_method_id = T_SHIPPING_METHODS.id');
                    $query->where('T_SHIPPING_METHOD_COUNTRIES.country_id = ' . $row_country->id);
                    $query->where('T_PRODUCT_SHIPPING_METHODS.product_id = ' . $product_data->id);
                    $query->where('T_SHIPPING_METHODS.id = ' . $product_data->shipping_method_id);
                    $query->where('T_SHIPPING_METHODS.published = 1');
                    $db->setQuery($query);
                    $shipping_method_id = (int)$db->loadResult();

                    if (($db->getErrorNum()) || ($shipping_method_id != $product_data->shipping_method_id)) {
                        $is_data_invalid = true;
                        break;
                    }
                  
                    if (($row_product->enable_shipping == 0 or ($row_product->enable_shipping == 2 and $options->checkout_enable_shipping == 0)) && ($shipping_method_id != 0)) {
                        $is_data_invalid = true;
                        break;
                    }
                }
            }
        }
        return $is_data_invalid == false ? true : false;
    }
	

    public function get_final_checkout_data( $init = '' ) {
        $db = JFactory::getDbo();
		$session = JFactory::getSession();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        $options_model = WDFHelper::get_model('options');
        $options = $options_model->get_options();

        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        $decimals_supported = in_array($row_default_currency->code, WDFPaypal::$currencies_without_decimal_support) == true ? false : true;
        $decimals_to_show = (($options->option_show_decimals == 1) && ($decimals_supported == true)) ? 2 : 0;

        $session_id = WDFInput::get('session_id', 0, 'float');
      
		$final_checkout_data = unserialize($session->get( 'checkout_data_' . $session_id ));

        // additional data
        // country name
        $row_shipping_country = WDFDb::get_row_by_id('countries', $final_checkout_data['shipping_data_country_id']);
        $final_checkout_data['shipping_data_country'] = $row_shipping_country->name;
		
        $row_billing_country = WDFDb::get_row_by_id('countries', $final_checkout_data['billing_data_country_id']);
        $final_checkout_data['billing_data_country'] = $row_billing_country->name;		

        // products data and total price
        $products_data =& $final_checkout_data['products_data'];
        // shipping methods map. collect products with same shipping method to determine free shipping
        // (for shipping methods with free_shipping_price option)
        $shipping_method_products_map = array();
        $total_price = 0;
        $checkout_data = $this->checkout_data;
        $this->check_products_shipment($products_data, $checkout_data['shipping_data_country_id'], $init );
        $app = JFactory::getApplication();
		if (empty($final_checkout_data['products_data']) == true) 
		{
			$app->enqueueMessage(WDFText::get('MSG_NO_PRODUCTS_TO_CHECKOUT'), 'error');
			if ($final_checkout_data['checkout_type'] == 'quick_checkout')
				WDFHelper::redirect('products', 'displayproducts');
			else 
				WDFHelper::redirect('shoppingcart', 'displayshoppingcart');		
		}

        foreach ($products_data as $product_data) {
            $query->clear();
            $query->select('T_PRODUCTS.id');
            $query->select('T_PRODUCTS.name');
            $query->select('T_PRODUCTS.images');
            $query->select('T_PRODUCTS.enable_shipping');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->select('T_PRODUCTS.price
                             * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100)
                             * (1 - IFNULL(T_USERGROUP_DISCOUNTS.rate, 0) / 100) AS price');
                $query->select('T_PRODUCTS.price
                             * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100)
                             * (1 - IFNULL(T_USERGROUP_DISCOUNTS.rate, 0) / 100)
                             * (IFNULL(T_TAXES.rate, 0) / 100) AS tax_price');
            } else {
                $query->select('T_PRODUCTS.price
                             * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100) AS price');
                $query->select('price * (IFNULL(T_TAXES.rate, 0) / 100) AS tax_price');
            }
			$query->select('T_PRODUCTS.price AS price_without_t_d');
            $query->select('T_PRODUCTS.unlimited');
            $query->select('T_PRODUCTS.amount_in_stock');
            $query->select('IFNULL(T_TAXES.id, 0) AS tax_id');
			$query->select('IFNULL(T_TAXES.rate, 0) AS tax_rate');
            $query->select('IFNULL(T_TAXES.name, "") AS tax_name');
			$query->select('IFNULL(T_DISCOUNTS.name, "") AS discount_name');
            $query->select('IFNULL(T_DISCOUNTS.rate, 0) AS discount_rate');
            $query->from('#__ecommercewd_products AS T_PRODUCTS');
            $query->leftJoin('(SELECT * FROM #__ecommercewd_taxes WHERE published = 1) AS T_TAXES ON T_PRODUCTS.tax_id = T_TAXES.id');
            $query->leftJoin('(SELECT * FROM #__ecommercewd_discounts WHERE published = 1) AS T_DISCOUNTS ON T_PRODUCTS.discount_id = T_DISCOUNTS.id');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->leftJoin('#__ecommercewd_users AS T_USERS ON T_USERS.j_user_id = ' . $j_user->id);
                $query->leftJoin('#__ecommercewd_usergroups AS T_USERGROUPS ON T_USERS.usergroup_id = T_USERGROUPS.id');
                $query->leftJoin('(SELECT * FROM #__ecommercewd_discounts WHERE published = 1) AS T_USERGROUP_DISCOUNTS ON T_USERGROUPS.discount_id = T_USERGROUP_DISCOUNTS.id');
            }
            $query->where('T_PRODUCTS.id = ' . $product_data->id);
            $query->where('T_PRODUCTS.published = 1');
            $db->setQuery($query);
            $row_product = $db->loadObject();

            if ($db->getErrorNum()) {
                return false;
            }

            // name
            $product_data->name = $row_product->name;

            // url
            $product_data->url = WDFUrl::get_site_url() . '/index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproduct&product_id=' . $product_data->id;

            // image
            $images = WDFJson::decode($row_product->images);
            $product_data->image = empty($images) == false ? addslashes($images[0]) : '';

            // parameters
            $parameters_obj = $this->get_product_parameters_string($product_data);
            $parameters = $parameters_obj['str'];
            if ($parameters === false) {
                WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $final_checkout_data['session_id']);
            }
            $product_data->parameters = $parameters;
			$product_data->parameters_price = $parameters_obj['price'];
            $product_data->description = addslashes(WDFTextUtils::truncate($product_data->parameters, self::$MAX_PAYPAL_DESCRIPTION_LENGTH));

            // prices
			$product_data->price = round(floatval(($row_product->price_without_t_d + $product_data->parameters_price)*(1-($row_product->discount_rate===null?0:$row_product->discount_rate)/100)), $decimals_supported == true ? 2 : 0);
            $product_data->tax_price = round(floatval($product_data->price*(($row_product->tax_rate===null?0:$row_product->tax_rate)/100)), $decimals_supported == true ? 2 : 0);

            // tax
            $product_data->tax_id = $row_product->tax_id;
            $product_data->tax_name = $row_product->tax_name;

            // shipping method
            $row_shipping_method = WDFDb::get_row_by_id('shippingmethods', $product_data->shipping_method_id);
            $product_data->shipping_method_id = $row_shipping_method->id;
            $product_data->shipping_method_name = $row_shipping_method->name;
            if ($row_shipping_method->description != '') {
                $product_data->shipping_method_name .= '(' . $row_shipping_method->description . ')';
            }
            if ($row_shipping_method->free_shipping == 1) {
                $product_data->shipping_method_price = 0;
            } else {
                $product_data->shipping_method_price = round(floatval($row_shipping_method->price), $decimals_supported == true ? 2 : 0);
            }
			
			$product_data->enable_shipping = $row_product->enable_shipping;
			
            // shipping methods map
            if ($product_data->shipping_method_id != 0) {
                if (isset($shipping_method_products_map[$product_data->shipping_method_id]) == false) {
                    $shipping_method_products = array();
                    $shipping_method_products['shipping_method'] = $row_shipping_method;
                    $shipping_method_products['products'] = array();
                    $shipping_method_products_map[$product_data->shipping_method_id] = $shipping_method_products;
                }
                $shipping_method_products_map[$product_data->shipping_method_id]['products'][] = $product_data;
            }
			
        }


        // determine shipping method price for products
        foreach ($shipping_method_products_map as $shipping_method_products) {
            $shipping_method = $shipping_method_products['shipping_method'];

            if ($shipping_method->free_shipping == 2) {
                $free_shipping_start_price = $shipping_method->free_shipping_start_price;

                $products = $shipping_method_products['products'];
                $products_price = 0;
                foreach ($products as $product_data) {
                    $products_price += ($product_data->price + $product_data->tax_price) * $product_data->count;
                }

                if ($products_price >= $free_shipping_start_price) {
                    foreach ($products as $product_data) {
                        $product_data->shipping_method_price = 0;
                        $products_data[$product_data->id] = $product_data;
                    }
                }
            }
        }

        // subtotals, total and price texts
        foreach ($products_data as $product_id => $product_data) {
            // subtotal
            $product_data->subtotal_price = ($product_data->price + $product_data->tax_price + $product_data->shipping_method_price) * $product_data->count;

            // total price
            $total_price += $product_data->subtotal_price;

            // prices
            $product_data->price_text = number_format($product_data->price, $decimals_to_show);
            $product_data->tax_price_text = number_format($product_data->tax_price, $decimals_to_show);
			$product_data->parameters_price_text = number_format($product_data->parameters_price, $decimals_to_show);
            $product_data->shipping_method_price_text = number_format($product_data->shipping_method_price, $decimals_to_show);
            $product_data->subtotal_price_text = number_format($product_data->subtotal_price, $decimals_to_show);

            // currency signs
            if ($row_default_currency->sign_position == 0) {
                $product_data->price_text = $row_default_currency->sign . $product_data->price_text;
                $product_data->tax_price_text = $row_default_currency->sign . $product_data->tax_price_text;
				$product_data->parameters_price_text = $row_default_currency->sign . $product_data->parameters_price_text;
                $product_data->shipping_method_price_text = $row_default_currency->sign . $product_data->shipping_method_price_text;
                $product_data->subtotal_price_text = $row_default_currency->sign . $product_data->subtotal_price_text;
            } else {
                $product_data->price_text = $product_data->price_text . $row_default_currency->sign;
                $product_data->tax_price_text = $product_data->tax_price_text . $row_default_currency->sign;
				$product_data->parameters_price_text = $product_data->parameters_price_text . $row_default_currency->sign;
                $product_data->shipping_method_price_text = $product_data->shipping_method_price_text . $row_default_currency->sign;
                $product_data->subtotal_price_text = $product_data->subtotal_price_text . $row_default_currency->sign;
            }
        }

        $final_checkout_data['total_price'] = $total_price;
        $final_checkout_data['total_price_text'] = number_format($final_checkout_data['total_price'], $decimals_to_show);
        if ($row_default_currency->sign_position == 0) {
            $final_checkout_data['total_price_text'] = $row_default_currency->sign . $final_checkout_data['total_price_text'];
        } else {
            $final_checkout_data['total_price_text'] = $final_checkout_data['total_price_text'] . $row_default_currency->sign;
        }

        return $final_checkout_data;
    }

    public function store_checkout_data() {
        $db = JFactory::getDbo();
		$app = JFactory::getApplication();
		// check for 0 products checkout
 
        $model_orders = WDFHelper::get_model('orders');

        // is data valid
        if ($this->is_final_checkout_data_valid() == false) {
            return false;
        }
        $final_checkout_data = $this->get_final_checkout_data(1);
        if ($final_checkout_data === false) {
            return false;
        }

        // clear order session
        WDFSession::clear('checkout_data_' . $final_checkout_data['session_id'], true, false);

        if ($final_checkout_data === false) {
            return false;
        }

        $row_default_order_status = WDFDb::get_row('orderstatuses', $db->quoteName('default') . ' = 1');

        // create new order row
        $cur_date = JFactory::getDate();

        $rand_id = $model_orders->get_order_rand_id();
        if ($rand_id === false) {
            return false;
        }

        $row_order = WDFDb::get_row_by_id('orders');
        $row_order->rand_id = $rand_id;
        $row_order->checkout_type = $final_checkout_data['checkout_type'];
        $row_order->checkout_date = $cur_date->toSql();
        $row_order->date_modified = $cur_date->toSql();
        $row_order->j_user_id = $final_checkout_data['j_user_id'];
        $row_order->user_ip_address = $final_checkout_data['user_ip_address'];
        $row_order->status_id = $row_default_order_status->id;
        $row_order->status_name = $row_default_order_status->name;
        $row_order->payment_method = $final_checkout_data['payment_method'];
        $row_order->payment_data = WDFJson::encode(array());
        $row_order->payment_data_status = '';
        $row_order->billing_data_first_name = $final_checkout_data['billing_data_first_name'];
        $row_order->billing_data_middle_name = $final_checkout_data['billing_data_middle_name'];
        $row_order->billing_data_last_name = $final_checkout_data['billing_data_last_name'];
        $row_order->billing_data_email = $final_checkout_data['billing_data_email'];
        $row_order->billing_data_company = $final_checkout_data['billing_data_company'];
        $row_order->billing_data_country_id = $final_checkout_data['billing_data_country_id'];
        $row_order->billing_data_country = $final_checkout_data['billing_data_country'];
        $row_order->billing_data_state = $final_checkout_data['billing_data_state'];
        $row_order->billing_data_city = $final_checkout_data['billing_data_city'];
        $row_order->billing_data_address = $final_checkout_data['billing_data_address'];
        $row_order->billing_data_mobile = $final_checkout_data['billing_data_mobile'];
        $row_order->billing_data_phone = $final_checkout_data['billing_data_phone'];
        $row_order->billing_data_fax = $final_checkout_data['billing_data_fax'];
        $row_order->billing_data_zip_code = $final_checkout_data['billing_data_zip_code'];		
        $row_order->shipping_data_first_name = $final_checkout_data['shipping_data_first_name'];
        $row_order->shipping_data_middle_name = $final_checkout_data['shipping_data_middle_name'];
        $row_order->shipping_data_last_name = $final_checkout_data['shipping_data_last_name'];
        $row_order->shipping_data_company = $final_checkout_data['shipping_data_company'];
        $row_order->shipping_data_country_id = $final_checkout_data['shipping_data_country_id'];
        $row_order->shipping_data_country = $final_checkout_data['shipping_data_country'];
        $row_order->shipping_data_state = $final_checkout_data['shipping_data_state'];
        $row_order->shipping_data_city = $final_checkout_data['shipping_data_city'];
        $row_order->shipping_data_address = $final_checkout_data['shipping_data_address'];
        $row_order->shipping_data_zip_code = $final_checkout_data['shipping_data_zip_code'];
        $row_order->currency_id = $final_checkout_data['currency_id'];
        $row_order->currency_code = $final_checkout_data['currency_code'];
        $row_order->read = 0;
        if (!$row_order->store()) {
            return false;
        }
        $final_checkout_data['order_id'] = $row_order->id;
        $final_checkout_data['order_rand_id'] = $row_order->rand_id;
				
        $products_data =& $final_checkout_data['products_data'];
		
		// decrease products count
	   
        foreach ($products_data as $product_data) {
			
            $row_product = WDFDb::get_row_by_id('products', $product_data->id);
		
            if ($row_product->unlimited == 0) {
                $row_product->amount_in_stock = max(0, $row_product->amount_in_stock - $product_data->count);
            }
            if (!$row_product->store()) {
                //TODO: send failed to decrease products amount notification to admin
            }
        }

        // create order product rows if quick checkout, modify rows if not
        $updated_order_product_ids = array();
        foreach ($products_data as $product_id => $product_data) {
            $product_data =& $products_data[$product_id];

            $order_product_id = $final_checkout_data['checkout_type'] == 'quick_checkout' ? null : $product_data->order_product_id;
            $row_order_product = WDFDb::get_row_by_id('orderproducts', $order_product_id);
            $row_order_product->order_id = $final_checkout_data['order_id'];          
            $row_order_product->j_user_id = $final_checkout_data['j_user_id'];
            $row_order_product->user_ip_address = $final_checkout_data['user_ip_address'];
            $row_order_product->product_id = $product_data->id;
            $row_order_product->product_name = $product_data->name;
            $row_order_product->product_image = $product_data->image;
            $row_order_product->product_parameters = $product_data->parameters;
            $row_order_product->product_price = $product_data->price;
            $row_order_product->tax_id = $product_data->tax_id;
            $row_order_product->tax_name = $product_data->tax_name;
            $row_order_product->tax_price = $product_data->tax_price;
            $row_order_product->shipping_method_id = $product_data->shipping_method_id;
            $row_order_product->shipping_method_name = $product_data->shipping_method_name;
            $row_order_product->shipping_method_price = $product_data->shipping_method_price;
            $row_order_product->product_count = $product_data->count;
            $row_order_product->currency_id = $final_checkout_data['currency_id'];
            $row_order_product->currency_code = $final_checkout_data['currency_code'];
            if (!$row_order_product->store()) {
                // remove order row
                WDFDb::remove_rows('orders', $final_checkout_data['order_id']);

                // delete / restore order product rows
                if ($final_checkout_data['checkout_type'] == 'quick_checkout') {
                    WDFDb::remove_rows('orderproducts', $updated_order_product_ids);
                } else {
                    foreach ($updated_order_product_ids as $order_product_id) {
                        $row_order_product_to_update = WDFDb::get_row_by_id('orderproducts', $order_product_id);
                        $row_order_product_to_update->order_id = 0;
                        $row_order_product_to_update->product_parameters = WDFJson::encode(array());
                        $row_order_product_to_update->store();
                    }
                }
                return false;
            }
            $product_data->order_product_id = $row_order_product->id;
            $updated_order_product_ids[] = $row_order_product->id;
        }

        // if checkout is anonymouse store order ids in cookies
        if ($final_checkout_data['j_user_id'] == 0) {
            $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids', array());
            $order_rand_ids[] = $final_checkout_data['order_rand_id'];
            WDFInput::cookie_set_array('order_rand_ids', $order_rand_ids);
        }

        return $final_checkout_data;
    }
    public function get_billing_data_form_fields() {
        $options = WDFHelper::get_model('options')->get_options();

        $checkout_data = $this->get_checkout_data();

        $form_fields = array();

        // first name
        $form_field = array();
        $form_field['type'] = 'text';
        $form_field['name'] = 'billing_data_first_name';
        if (($options->user_data_middle_name == 0) && ($options->user_data_last_name == 0)) {
            $name_parts = array();
            if ($checkout_data['billing_data_first_name'] != '') {
                $name_parts[] = $checkout_data['shipping_data_first_name'];
            }
            if ($checkout_data['billing_data_middle_name'] != '') {
                $name_parts[] = $checkout_data['shipping_data_middle_name'];
            }
            if ($checkout_data['billing_data_last_name'] != '') {
                $name_parts[] = $checkout_data['shipping_data_last_name'];
            }
            $form_field['value'] = implode(',', $name_parts);
            $form_field['label'] = WDFText::get('NAME');
            $form_field['placeholder'] = WDFText::get('NAME');
        } else {
            $form_field['value'] = $checkout_data['billing_data_first_name'];
            $form_field['label'] = WDFText::get('FIRST_NAME');
            $form_field['placeholder'] = WDFText::get('FIRST_NAME');
        }
        $form_field['required'] = true;
        $form_fields['first_name'] = $form_field;

        // middle name
        if ($options->user_data_middle_name != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_middle_name';
            $form_field['value'] = $checkout_data['billing_data_middle_name'];
            $form_field['label'] = WDFText::get('MIDDLE_NAME');
            $form_field['placeholder'] = WDFText::get('MIDDLE_NAME');
            $form_field['required'] = $options->user_data_middle_name == 2 ? true : false;
            $form_fields['middle_name'] = $form_field;
        }

        // last name
        if ($options->user_data_last_name != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_last_name';
            $form_field['value'] = $checkout_data['billing_data_last_name'];
            $form_field['label'] = WDFText::get('LAST_NAME');
            $form_field['placeholder'] = WDFText::get('LAST_NAME');
            $form_field['required'] = $options->user_data_last_name == 2 ? true : false;
            $form_fields['last_name'] = $form_field;
        }

        // email
        $form_field = array();
        $form_field['type'] = 'text';
        $form_field['name'] = 'billing_data_email';
        $form_field['value'] = $checkout_data['billing_data_email'];
        $form_field['label'] = WDFText::get('EMAIL');
        $form_field['placeholder'] = WDFText::get('EMAIL');
        $form_field['required'] = true;
        $form_fields['email'] = $form_field;

        // company
        if ($options->user_data_company != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_company';
            $form_field['value'] = $checkout_data['billing_data_company'];
            $form_field['label'] = WDFText::get('COMPANY');
            $form_field['placeholder'] = WDFText::get('COMPANY');
            $form_field['required'] = $options->user_data_company == 2 ? true : false;
            $form_fields['company'] = $form_field;
        }

        // country id
        if ($options->user_data_country != 0) {
            $form_field = array();
            $form_field['type'] = 'select';
            $form_field['name'] = 'billing_data_country_id';
            $form_field['value'] = $checkout_data['billing_data_country_id'];
            $form_field['label'] = WDFText::get('COUNTRY');
            $form_field['required'] = $options->user_data_country == 2 ? true : false;
            $form_field['options'] = WDFDb::get_list('countries', 'id', 'name', array(' published = "1" '), 'name ASC', array(array('id' => '', 'name' => WDFText::get('SELECT_COUNTRY'))));
            $form_fields['country_id'] = $form_field;
        }

        // state
        if ($options->user_data_state != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_state';
            $form_field['value'] = $checkout_data['billing_data_state'];
            $form_field['label'] = WDFText::get('STATE');
            $form_field['placeholder'] = WDFText::get('STATE');
            $form_field['required'] = $options->user_data_state == 2 ? true : false;
            $form_fields['state'] = $form_field;
        }

        // city
        if ($options->user_data_city != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_city';
            $form_field['value'] = $checkout_data['billing_data_city'];
            $form_field['label'] = WDFText::get('CITY');
            $form_field['placeholder'] = WDFText::get('CITY');
            $form_field['required'] = $options->user_data_city == 2 ? true : false;
            $form_fields['city'] = $form_field;
        }

        // address
        if ($options->user_data_address != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_address';
            $form_field['value'] = $checkout_data['billing_data_address'];
            $form_field['label'] = WDFText::get('ADDRESS');
            $form_field['placeholder'] = WDFText::get('ADDRESS');
            $form_field['required'] = $options->user_data_address == 2 ? true : false;
            $form_fields['address'] = $form_field;
        }

        // mobile
        if ($options->user_data_mobile != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_mobile';
            $form_field['value'] = $checkout_data['billing_data_mobile'];
            $form_field['label'] = WDFText::get('MOBILE');
            $form_field['placeholder'] = WDFText::get('MOBILE');
            $form_field['required'] = $options->user_data_mobile == 2 ? true : false;
            $form_fields['mobile'] = $form_field;
        }

        // phone
        if ($options->user_data_phone != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_phone';
            $form_field['value'] = $checkout_data['billing_data_phone'];
            $form_field['label'] = WDFText::get('PHONE');
            $form_field['placeholder'] = WDFText::get('PHONE');
            $form_field['required'] = $options->user_data_phone == 2 ? true : false;
            $form_fields['phone'] = $form_field;
        }

        // fax
        if ($options->user_data_fax != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_fax';
            $form_field['value'] = $checkout_data['billing_data_fax'];
            $form_field['label'] = WDFText::get('FAX');
            $form_field['placeholder'] = WDFText::get('FAX');
            $form_field['required'] = $options->user_data_fax == 2 ? true : false;
            $form_fields['fax'] = $form_field;
        }

        // zip code
        if ($options->user_data_zip_code != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'billing_data_zip_code';
            $form_field['value'] = $checkout_data['billing_data_zip_code'];
            $form_field['label'] = WDFText::get('ZIP_CODE');
            $form_field['placeholder'] = WDFText::get('ZIP_CODE');
            $form_field['required'] = $options->user_data_zip_code == 2 ? true : false;
            $form_fields['zip_code'] = $form_field;
        }

        return $form_fields;
    }
    public function get_shipping_data_form_fields() {
        $options = WDFHelper::get_model('options')->get_options();

        $checkout_data = $this->get_checkout_data();

        $form_fields = array();

        // first name
        $form_field = array();
        $form_field['type'] = 'text';
        $form_field['name'] = 'shipping_data_first_name';
        if (($options->user_data_middle_name == 0) && ($options->user_data_last_name == 0)) {
            $name_parts = array();
            if ($checkout_data['shipping_data_first_name'] != '') {
                $name_parts[] = $checkout_data['shipping_data_first_name'];
            }
            if ($checkout_data['shipping_data_middle_name'] != '') {
                $name_parts[] = $checkout_data['shipping_data_middle_name'];
            }
            if ($checkout_data['shipping_data_last_name'] != '') {
                $name_parts[] = $checkout_data['shipping_data_last_name'];
            }
            $form_field['value'] = implode(',', $name_parts);
            $form_field['label'] = WDFText::get('NAME');
            $form_field['placeholder'] = WDFText::get('NAME');
        } else {
            $form_field['value'] = $checkout_data['shipping_data_first_name'];
            $form_field['label'] = WDFText::get('FIRST_NAME');
            $form_field['placeholder'] = WDFText::get('FIRST_NAME');
        }
        $form_field['required'] = true;
        $form_fields['first_name'] = $form_field;

        // middle name
        if ($options->user_data_middle_name != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_middle_name';
            $form_field['value'] = $checkout_data['shipping_data_middle_name'];
            $form_field['label'] = WDFText::get('MIDDLE_NAME');
            $form_field['placeholder'] = WDFText::get('MIDDLE_NAME');
            $form_field['required'] = $options->user_data_middle_name == 2 ? true : false;
            $form_fields['middle_name'] = $form_field;
        }

        // last name
        if ($options->user_data_last_name != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_last_name';
            $form_field['value'] = $checkout_data['shipping_data_last_name'];
            $form_field['label'] = WDFText::get('LAST_NAME');
            $form_field['placeholder'] = WDFText::get('LAST_NAME');
            $form_field['required'] = $options->user_data_last_name == 2 ? true : false;
            $form_fields['last_name'] = $form_field;
        }

        // company
        if ($options->user_data_company != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_company';
            $form_field['value'] = $checkout_data['shipping_data_company'];
            $form_field['label'] = WDFText::get('COMPANY');
            $form_field['placeholder'] = WDFText::get('COMPANY');
            $form_field['required'] = $options->user_data_company == 2 ? true : false;
            $form_fields['company'] = $form_field;
        }

        // country id
        if ($options->user_data_country != 0) {
            $form_field = array();
            $form_field['type'] = 'select';
            $form_field['name'] = 'shipping_data_country_id';
            $form_field['value'] = $checkout_data['shipping_data_country_id'];
            $form_field['label'] = WDFText::get('COUNTRY');
            $form_field['required'] = $options->user_data_country == 2 ? true : false;
            $form_field['options'] = WDFDb::get_list('countries', 'id', 'name', array(' published = "1" '), 'name ASC', array(array('id' => '', 'name' => WDFText::get('SELECT_COUNTRY'))));
            $form_fields['country_id'] = $form_field;
        }

        // state
        if ($options->user_data_state != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_state';
            $form_field['value'] = $checkout_data['shipping_data_state'];
            $form_field['label'] = WDFText::get('STATE');
            $form_field['placeholder'] = WDFText::get('STATE');
            $form_field['required'] = $options->user_data_state == 2 ? true : false;
            $form_fields['state'] = $form_field;
        }

        // city
        if ($options->user_data_city != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_city';
            $form_field['value'] = $checkout_data['shipping_data_city'];
            $form_field['label'] = WDFText::get('CITY');
            $form_field['placeholder'] = WDFText::get('CITY');
            $form_field['required'] = $options->user_data_city == 2 ? true : false;
            $form_fields['city'] = $form_field;
        }

        // address
        if ($options->user_data_address != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_address';
            $form_field['value'] = $checkout_data['shipping_data_address'];
            $form_field['label'] = WDFText::get('ADDRESS');
            $form_field['placeholder'] = WDFText::get('ADDRESS');
            $form_field['required'] = $options->user_data_address == 2 ? true : false;
            $form_fields['address'] = $form_field;
        }
       
        // zip code
        if ($options->user_data_zip_code != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'shipping_data_zip_code';
            $form_field['value'] = $checkout_data['shipping_data_zip_code'];
            $form_field['label'] = WDFText::get('ZIP_CODE');
            $form_field['placeholder'] = WDFText::get('ZIP_CODE');
            $form_field['required'] = $options->user_data_zip_code == 2 ? true : false;
            $form_fields['zip_code'] = $form_field;
        }

        return $form_fields;
    }

    public function get_products_page_products_data() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;


        $checkout_data = $this->get_checkout_data();
        $country_id = $checkout_data['shipping_data_country_id'];
        $products_data = $checkout_data['products_data'];


        $products_page_products_data = array();
        foreach ($products_data as $product_data) {
            // product name and availability
            $query->clear();
            $query->select('id');
            $query->select('name');
            $query->select('amount_in_stock');
            $query->select('unlimited');
            $query->select('enable_shipping');
            $query->from('#__ecommercewd_products');
            $query->where('id = ' . $product_data->id);
            $query->where('published = 1');
            $db->setQuery($query);
            $product_page_product_data = $db->loadObject();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }

            // count
            $product_page_product_data->count = $product_data->count;

            // availability msg
            $product_page_product_data->amount_in_stock = (int)$product_page_product_data->amount_in_stock;
            $product_page_product_data->unlimited = (int)$product_page_product_data->unlimited;
            if ($product_page_product_data->unlimited == 1) {
                $product_page_product_data->is_available = true;
                $product_page_product_data->available_msg = WDFText::get('IN_STOCK');
            } elseif ($product_page_product_data->amount_in_stock > 0) {
                $product_page_product_data->is_available = true;
                $product_page_product_data->available_msg = WDFText::get('IN_STOCK') . ': ' . $product_page_product_data->amount_in_stock;
            } else {
                $product_page_product_data->is_available = false;
                $product_page_product_data->available_msg = WDFText::get('OUT_OF_STOCK');
            }

            // shipping methods rows
            if ($country_id != 0) {
                $product_page_product_data->country_specified = true;

                $query->clear();
                $query->select('T_SHIPPING_METHODS.id');
                $query->select('T_SHIPPING_METHODS.name');
                $query->select('T_SHIPPING_METHODS.description');
                $query->select('T_SHIPPING_METHODS.price');
                $query->select('T_SHIPPING_METHODS.free_shipping');
                $query->select('T_SHIPPING_METHODS.free_shipping_start_price');
                $query->from('#__ecommercewd_shippingmethods AS T_SHIPPING_METHODS');
                $query->leftJoin('#__ecommercewd_productshippingmethods AS T_PRODUCT_SHIPPING_METHODS ON T_PRODUCT_SHIPPING_METHODS.shipping_method_id = T_SHIPPING_METHODS.id');
                $query->leftJoin('#__ecommercewd_shippingmethodcountries AS T_SHIPPING_METHOD_COUNTRIES ON T_SHIPPING_METHOD_COUNTRIES.shipping_method_id = T_SHIPPING_METHODS.id');
                $query->where('T_PRODUCT_SHIPPING_METHODS.product_id = ' . $product_data->id);
                $query->where('T_SHIPPING_METHOD_COUNTRIES.country_id = ' . $country_id);
                $query->where('T_SHIPPING_METHODS.published = 1');
                $query->order('T_SHIPPING_METHODS.ordering ASC');
                $db->setQuery($query);
                $shipping_method_rows = $db->loadObjectList();

                if ($db->getErrorNum()) {
                    echo $db->getErrorMsg();
                    die();
                }

                // additional data
                if (empty($shipping_method_rows) == false) {
                    $has_checked_shipping_method = false;
                    foreach ($shipping_method_rows as $shipping_method_row) {
                        if ($shipping_method_row->free_shipping == 1) {
                            $shipping_method_row->price = 0;
                        }

                        // prices
                        $shipping_method_row->price_text = number_format($shipping_method_row->price, $decimals);

                        // currency symbols
                        if ($checkout_data['currency_sign_position'] == 0) {
                            $shipping_method_row->price_text = $checkout_data['currency_sign'] . $shipping_method_row->price_text;
                        } else {
                            $shipping_method_row->price_text = $shipping_method_row->price_text . $checkout_data['currency_sign'];
                        }

                        // checked
                        if ($shipping_method_row->id == $product_data->shipping_method_id) {
                            $shipping_method_row->checked = true;
                            $has_checked_shipping_method = true;
                        } else {
                            $shipping_method_row->checked = false;
                        }

                        // label
                        if ($shipping_method_row->description != '') {
                            $shipping_method_row->label = $shipping_method_row->name . '(' . $shipping_method_row->description . ') ' . $shipping_method_row->price_text;
                        } else {
                            $shipping_method_row->label = $shipping_method_row->name . ' ' . $shipping_method_row->price_text;
                        }
                    }

                    // check first shipping method if there is no checked shipping methods
                    if ($has_checked_shipping_method == false) {
                        $shipping_method_rows[0]->checked = true;
                    }
                }

                $product_page_product_data->shipping_method_rows = $shipping_method_rows;
            } else {
                $product_page_product_data->country_specified = false;
            }


            // selectable parameters
            // get parameter ids and names
            $query->clear();
            $query->select('T_PARAMETERS.id');
            $query->select('T_PARAMETERS.name');
			$query->select('T_PARAMETERS.type_id');
            $query->from('#__ecommercewd_parameters AS T_PARAMETERS');
            $query->leftJoin('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
            $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_data->id);
            $query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
            $query->group('T_PARAMETERS.id');
            $query->having('COUNT(T_PRODUCT_PARAMETERS.parameter_value) > 1 OR T_PARAMETERS.type_id = 1 OR T_PARAMETERS.type_id = 2');
            $db->setQuery($query);

            $selectable_parameters_data = $db->loadObjectList();


            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }

            if ($selectable_parameters_data == null) {
                $selectable_parameters_data = array();
            }

            // validate parameter id and get parameter values
            foreach ($selectable_parameters_data as $key => $selectable_parameter_data) {
                $selectable_parameter_data->id = (int)$selectable_parameter_data->id;

                $query->clear();
                $query->select('parameter_value AS value');
				$query->select('parameter_value_price AS price');
                $query->from('#__ecommercewd_productparameters');
                $query->where('product_id = ' . $product_data->id);
                $query->where('parameter_id = ' . $selectable_parameter_data->id);
				$query->order('productparameters_id ASC');
                $db->setQuery($query);
                $values = $db->loadObjectList();

                if ($db->getErrorNum()) {
                    echo $db->getErrorMsg();
                    die();
                }

                if ($values == null) {
                    $values = array();
                }
                $empty_value_array = array( 'value' => '', 'price' => '');

                $selectable_parameter_data->values = $values;
                $selectable_parameter_data->value = $empty_value_array;
				
				$row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

                // create values list
                $values_list = array();
                foreach ($selectable_parameter_data->values as $value) {
                    if ($value->price != '+' && $value->price != '') {
						$price_sign = substr( $value->price,0,1);	
						$value->price = $price_sign.number_format(substr( $value->price,1), $decimals);
                  		if($row_default_currency->sign_position == 1){
							$values_list[] = array('value' => $value->value, 'text' => $value->value . ' (' . $value->price . $row_default_currency->sign . ')');
						}
						else{
							$values_list[] = array('value' => $value->value, 'text' => $value->value . ' (' . substr( $value->price,0, 1). $row_default_currency->sign . substr( $value->price, 1) . ')');
						}
                    
                    } else {
                        $values_list[] = array('value' => $value->value, 'text' => $value->value);
                    }

                }
                $selectable_parameter_data->values_list = $values_list;

                $selectable_parameters_data[$key] = $selectable_parameter_data;
            }


			//init_order_product_id
            $product_page_product_data->order_product_id = $product_data->order_product_id;


            // override values
            $override_parameters = $product_data->parameters;
            foreach ($selectable_parameters_data as $key => $selectable_parameter_data) {
                if (((isset($override_parameters[$selectable_parameter_data->id]) == true) && (in_array($override_parameters[$selectable_parameter_data->id], $selectable_parameter_data->values))) || (is_array($override_parameters[$selectable_parameter_data->id])) || (is_string($override_parameters[$selectable_parameter_data->id]))) {
                    $selectable_parameter_data->value = $override_parameters[$selectable_parameter_data->id];
                }

                $selectable_parameters_data[$key] = $selectable_parameter_data;
            }


            $product_page_product_data->selectable_parameters_data = $selectable_parameters_data;


            $products_page_products_data[] = $product_page_product_data;
        }

        return $products_page_products_data;
    }

    public function get_license_pages() {
        if ($this->license_pages == null) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $checkout_data = $this->get_checkout_data();
            $products_data = $checkout_data['products_data'];

            foreach ($products_data as $product_data) {
                $product_ids[] = $product_data->id;
            }

            $query->clear();
            $query->select('CASE
            WHEN T_PAGES.is_article = 0
            THEN T_PAGES.title
            ELSE T_ARTICLES.title
            END AS title');
            $query->select('CASE
            WHEN T_PAGES.is_article = 0
            THEN T_PAGES.text
            ELSE CONCAT(T_ARTICLES.introtext, T_ARTICLES.fulltext)
            END AS text');
            $query->from('#__ecommercewd_pages AS T_PAGES');
            $query->leftJoin('#__ecommercewd_productpages AS T_PRODUCT_PAGES ON T_PRODUCT_PAGES.page_id = T_PAGES.id');
            $query->leftJoin('#__content AS T_ARTICLES ON T_ARTICLES.id = T_PAGES.article_id');
            $query->where('(T_PAGES.use_for_all_products = 1 OR T_PRODUCT_PAGES.product_id IN (' . implode(',', $product_ids) . '))');
            $query->where('T_PAGES.published = 1');
            $query->order('T_PAGES.ordering ASC');
            $db->setQuery($query);
            $this->license_pages = $db->loadObjectList();
			
			$this->license_pages = array_unique($this->license_pages, SORT_REGULAR);
			$this->license_pages = array_values($this->license_pages);

            if ($db->getErrorNum()) {
                WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $checkout_data['session_id']);
            }
        }

        return $this->license_pages;
    }
	
    public function get_payment_buttons_data($total_price) {
        $options = WDFHelper::get_model('options')->get_options();
		$checkout_options = $this->checkout_options();
        $checkout_data = $this->get_checkout_data();
        $action_finish_checkout = WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&task=finish_checkout&session_id=' . $checkout_data['session_id'] . '&data=confirm_data';
        $action_show_form = WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&task=displaycheckoutform&session_id=' . $checkout_data['session_id'];	
		
		$payments_data_array = array();	
	
		if(isset($checkout_options->without_online_payment) == true){
			$payment_button_data_without_online_payment = new stdClass();
			$payment_button_data_without_online_payment->text = WDFText::get('BTN_WITHOUT_ONLINE_PAYMENT');
			$payment_button_data_without_online_payment->action = $action_finish_checkout . '&payment_method=without_online_payment&controller=withoutonline';
			$payments_data_array["without_online_payment"] = $payment_button_data_without_online_payment;
		}
		
		if(isset($checkout_options->paypalexpress) == true){
			$payment_button_data_paypal_express = new stdClass();
			$payment_button_data_paypal_express->text = WDFText::get('BTN_PAY_WITH_PAYPAL');
			$payment_button_data_paypal_express->action = $action_finish_checkout . '&payment_method=paypalexpress&controller=paypalexpress';
			$payments_data_array["paypalexpress"] = $payment_button_data_paypal_express;
		}
		
		if(isset($checkout_options->authorizenetaim) == true){
			$payment_button_data_authorizenet_aim = new stdClass();
			$payment_button_data_authorizenet_aim->text = WDFText::get('BTN_PAY_WITH_AUTHORIZENET_AIM');
			$payment_button_data_authorizenet_aim->action = $action_show_form . '&payment_method=authorizenetaim&controller=authorizenetaim';
			$payments_data_array["authorizenetaim"] = $payment_button_data_authorizenet_aim;
		}
		
		if(isset($checkout_options->authorizenetsim) == true){
			$checkout_api_options = $this->checkout_api_options('authorizenetsim');
			$payment_button_data_authorizenet_sim = new stdClass();
			$payment_button_data_authorizenet_sim->text = WDFText::get('BTN_PAY_WITH_AUTHORIZENET_SIM');         
			$sim_form_data = WDFHelper::get_model('authorizenetsim')->get_checkout_form_data();			
			$payment_button_data_authorizenet_sim->action = $sim_form_data['form_action'];
			$payments_data_array["authorizenetsim"] = $payment_button_data_authorizenet_sim;
		}
		
		if(isset($checkout_options->authorizenetdpm) == true){
		
			$payment_button_data_authorizenet_dpm = new stdClass();
			$payment_button_data_authorizenet_dpm->text = WDFText::get('BTN_PAY_WITH_AUTHORIZENET_DPM');
			$payment_button_data_authorizenet_dpm->action = $action_show_form . '&payment_method=authorizenetdpm&controller=authorizenetdpm';
			$payments_data_array["authorizenetdpm"] = $payment_button_data_authorizenet_dpm;
		}
		
		if(isset($checkout_options->stripe) == true){
		
			$payment_button_data_stripe = new stdClass();
			$payment_button_data_stripe->text = WDFText::get('BTN_PAY_WITH_STRIPE');
			$payment_button_data_stripe->action = $action_show_form . '&payment_method=stripe&controller=stripe';
			$payments_data_array["stripe"] = $payment_button_data_stripe;
		}
		// get available payment methods, check if count is more than 1
        $payment_buttons_data = array();
		foreach($checkout_options as $key => $value){
			if($value == 1 && ($total_price != 0 || $key == 'without_online_payment'))
				$payment_buttons_data[] = $payments_data_array[$key];
		}
        return $payment_buttons_data;
    }

    public function get_pager_data() {
        $checkout_data = $this->get_checkout_data();

        $license_pages = $this->get_license_pages();
        if ($license_pages === false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $checkout_data['session_id']);
        }
        $has_license_pages = empty($license_pages) == false ? true : false;

        $pager_data = array();

        $btn_cancel_checkout_data = array();
        $btn_cancel_checkout_data['url'] = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart');
        $pager_data['btn_cancel_checkout_data'] = $btn_cancel_checkout_data;

        $action_display_shipping_data = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=displayshippingdata&session_id=' . $checkout_data['session_id']);
        $action_display_products_data = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=displayproductsdata&session_id=' . $checkout_data['session_id']);
        $action_display_license_pages = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=displaylicensepages&session_id=' . $checkout_data['session_id']);
        $action_display_confirm_order = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=displayconfirmorder&session_id=' . $checkout_data['session_id']);
        switch (WDFInput::get_task()) {
            case 'displayshippingdata':
                $btn_next_page_data = array();
                $btn_next_page_data['text'] = WDFText::get('BTN_PRODUCTS_DATA');
                $btn_next_page_data['action'] = $action_display_products_data;
                $pager_data['btn_next_page_data'] = $btn_next_page_data;
                break;
            case 'displayproductsdata':
                $btn_prev_page_data = array();
                $btn_prev_page_data['text'] = WDFText::get('BTN_SHIPPING_DATA');
                $btn_prev_page_data['action'] = $action_display_shipping_data;
                $pager_data['btn_prev_page_data'] = $btn_prev_page_data;

                $btn_next_page_data = array();
                if ($has_license_pages == true) {
                    $btn_next_page_data['text'] = WDFText::get('BTN_LICENSING');
                    $btn_next_page_data['action'] = $action_display_license_pages;
                } else {
                    $btn_next_page_data['text'] = WDFText::get('BTN_CONFIRM_ORDER');
                    $btn_next_page_data['action'] = $action_display_confirm_order;
                }
                $pager_data['btn_next_page_data'] = $btn_next_page_data;
                break;
            case 'displaylicensepages':
                $btn_prev_page_data = array();
                $btn_prev_page_data['text'] = WDFText::get('BTN_PRODUCTS_DATA');
                $btn_prev_page_data['action'] = $action_display_products_data;
                $pager_data['btn_prev_page_data'] = $btn_prev_page_data;

                $btn_next_page_data = array();
                $btn_next_page_data['text'] = WDFText::get('BTN_CONFIRM_ORDER');
                $btn_next_page_data['action'] = $action_display_confirm_order;
                $pager_data['btn_next_page_data'] = $btn_next_page_data;
                break;
            case 'displayconfirmorder':
                $btn_prev_page_data = array();
                if ($has_license_pages == true) {
                    $btn_prev_page_data['text'] = WDFText::get('BTN_LICENSING');
                    $btn_prev_page_data['action'] = $action_display_license_pages;
                } else {
                    $btn_prev_page_data['text'] = WDFText::get('BTN_PRODUCTS_DATA');
                    $btn_prev_page_data['action'] = $action_display_products_data;
                }
                $pager_data['btn_prev_page_data'] = $btn_prev_page_data;
				break;
        }

        return $pager_data;
    }
	public function checkout_options(){
	
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('short_name');
        $query->select('published');
        $query->from('#__ecommercewd_payments');
        $query->order('ordering');
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }
		
		$payments = new stdClass();
		foreach($rows as $row){
			$property = $row->short_name;
			$payments->$property = $row->published;
		}
		
		return 	$payments;
	}
	
	public function checkout_api_options($short_name){
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('options');
        $query->from('#__ecommercewd_payments');
        $query->where('short_name = "' . $short_name .'"' );
        $db->setQuery($query);
        $options = $db->loadResult();		
        if ($db->getErrorNum()) {
            return false;
        }
		
		$options = WDFJson::decode($options);

		return 	$options;
	}


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function add_checkout_initial_shipping_data(&$checkout_data) {
        $j_user = JFactory::getUser();
        $user_row = WDFDb::get_row('users', 'j_user_id = ' . $j_user->id);
		
        $checkout_data['shipping_data_first_name'] = '';
        $checkout_data['shipping_data_middle_name'] = '';
        $checkout_data['shipping_data_last_name'] = '';
        $checkout_data['shipping_data_company'] = '';
        $checkout_data['shipping_data_country_id'] = (int)$user_row->country_id;;
        $checkout_data['shipping_data_state'] = '';
        $checkout_data['shipping_data_city'] = '';
        $checkout_data['shipping_data_address'] = '';
        $checkout_data['shipping_data_zip_code'] = '';
    }
    private function add_checkout_initial_billing_data(&$checkout_data) {
        $j_user = JFactory::getUser();
        $user_row = WDFDb::get_row('users', 'j_user_id = ' . $j_user->id);

        $checkout_data['billing_data_first_name'] = $user_row->first_name;
        $checkout_data['billing_data_middle_name'] = $user_row->middle_name;
        $checkout_data['billing_data_last_name'] = $user_row->last_name;
        $checkout_data['billing_data_email'] = $j_user->email;
        $checkout_data['billing_data_company'] = $user_row->company;
        $checkout_data['billing_data_country_id'] = (int)$user_row->country_id;
        $checkout_data['billing_data_state'] = $user_row->state;
        $checkout_data['billing_data_city'] = $user_row->city;
        $checkout_data['billing_data_address'] = $user_row->address;
        $checkout_data['billing_data_mobile'] = $user_row->mobile;
        $checkout_data['billing_data_phone'] = $user_row->phone;
        $checkout_data['billing_data_fax'] = $user_row->fax;
        $checkout_data['billing_data_zip_code'] = $user_row->zip_code;
    }	

    private function add_checkout_initial_products_data(&$checkout_data) {
        $app = JFactory::getApplication();

        $products_data = array();

        // if products data not inited
        $task = WDFInput::get_task();

        switch ($task) {
            case 'checkout_product':
                // ckeck if user has this product in shopping cart
                $order_product_id = WDFInput::get('order_product_id', 0, 'int');
				
                $order_product_ids = $this->get_user_order_product_ids();
				
                if (($order_product_ids === false) || (empty($order_product_ids) == true) || (in_array($order_product_id, $order_product_ids) == false)) {
                    WDFHelper::redirect('systempages', 'displayerror', '', 'code=1');
                }

                // add product data
                $product_data = $this->get_product_data_by_order_product_id($order_product_id);
                if ($product_data === false) {
                    WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $checkout_data['session_id']);
                }
                $products_data[$product_data->id] = $product_data;
                break;
            case 'checkout_all_products':
                // get shopping cart products
                $order_product_ids = $this->get_user_order_product_ids();
                if (($order_product_ids === false) || (empty($order_product_ids) == true)) {
                    WDFHelper::redirect('systempages', 'displayerror', '', 'code=1');
                }

                // add products data
                for ($i = 0; $i < count($order_product_ids); $i++) {
                    $order_product_id = $order_product_ids[$i];
                    $product_data = $this->get_product_data_by_order_product_id($order_product_id);
                    if ($product_data === false) {
                        WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $checkout_data['session_id']);
                    }

                    $products_data[$product_data->order_product_id] = $product_data;
                }
                break;
            case 'quick_checkout':
                $product_data = $this->get_product_data_from_input();
                if ($product_data === false) {
                    WDFHelper::redirect('systempages', 'displayerror', '', 'code=1');
                }
                $products_data[$product_data->id] = $product_data;
                break;
        }

        // check products availability
        $this->check_products_availability($products_data);
        // remove invalid products and check for 0 products checkout
        foreach ($products_data as $index => $product_data) {
            if ($product_data->id == 0) {
                unset($products_data[$index]);
            }
        }
        if (empty($products_data) == true) {
            $app->enqueueMessage(WDFText::get('MSG_NO_PRODUCTS_TO_CHECKOUT'), 'error');
            if ($checkout_data['checkout_type'] == 'quick_checkout') {
                WDFHelper::redirect('products', 'displayproducts');
            } else {
                WDFHelper::redirect('shoppingcart', 'displayshoppingcart');
            }
        }

        $checkout_data['products_data'] = $products_data;
    }

    private function get_user_order_product_ids() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        $query->select('id');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = 0');
        if (WDFHelper::is_user_logged_in()) {
            $query->where('j_user_id = ' . $j_user->id);
        } else {
            $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids', array());
			
            if (empty($order_product_rand_ids) == false) {
                $query->where('j_user_id = 0');
                $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
            } else {
                $query->where(0);
            }
        }
        $db->setQuery($query);
        $order_product_ids = WDFArrayUtils::to_integer($db->loadColumn());

        if ($db->getErrorNum()) {
            return false;
        }

        return $order_product_ids;
    }

    private function get_product_data_by_order_product_id($order_product_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('T_PRODUCTS.id');
        $query->select('T_ORDER_PRODUCTS.id AS order_product_id');
        $query->select('T_ORDER_PRODUCTS.product_count AS count');
        $query->select('T_ORDER_PRODUCTS.product_parameters AS parameters');
        $query->from('#__ecommercewd_products AS T_PRODUCTS');
        $query->leftJoin('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS ON T_ORDER_PRODUCTS.product_id = T_PRODUCTS.id');
        $query->where('T_PRODUCTS.published = 1');
        $query->where('T_ORDER_PRODUCTS.id = ' . $order_product_id);
        $db->setQuery($query);
        $product_data = $db->loadObject();

        if (($db->getErrorNum()) || ($product_data == null) || ($product_data->id == 0)) {
            return false;
        }

        // parameters
        $product_parameters = WDFJson::decode($product_data->parameters);
        $product_parameters = WDFArrayUtils::keys_to_integer($product_parameters, array());
        $product_selectable_parameters = $this->get_product_initial_selectable_parameters($product_data->id, $product_parameters);
        if ($product_selectable_parameters === false) {
            return false;
        }


        // validate
        $product_data->id = (int)$product_data->id;
        $product_data->order_product_id = (int)$product_data->order_product_id;
        $product_data->count = (int)$product_data->count;
        $product_data->parameters = $product_selectable_parameters;
        $product_data->shipping_method_id = 0;

        return $product_data;
    }

    private function get_product_data_from_input() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // get product data
        $product_id = WDFInput::get('product_id', 0, 'int');
        $product_count = max(1, WDFInput::get('product_count', 1, 'int'));
        $input_product_parameters = (array)WDFInput::get_parsed_json('product_parameters_json', array());
        $input_product_parameters = WDFArrayUtils::keys_to_integer($input_product_parameters, array());
        $product_selectable_parameters = $this->get_product_initial_selectable_parameters($product_id, $input_product_parameters);
        if ($product_selectable_parameters === false) {
            return false;
        }

        // check if product exists
        $query->clear();
        $query->select('id');
        $query->select('0 AS order_product_id');
        $query->select('1 AS count');
        $query->from('#__ecommercewd_products');
        $query->where('published = 1');
        $query->where('id = ' . $product_id);
        $db->setQuery($query);
        $product_data = $db->loadObject();

        if (($db->getErrorNum()) || ($product_data == null) || ($product_data->id == 0)) {
            return false;
        }

        // additional data
        $product_data->id = (int)$product_data->id;
        $product_data->order_product_id = (int)$product_data->order_product_id;
        $product_data->count = $product_count;
        $product_data->parameters = $product_selectable_parameters;
        $product_data->shipping_method_id = 0;

        return $product_data;
    }

    private function get_product_initial_selectable_parameters($product_id, $product_parameters) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // get initial selectable parameters and values
        $query->clear();
        $query->select('T_PRODUCT_PARAMETRS.parameter_id AS id');
        $query->select('T_PRODUCT_PARAMETRS.parameter_value AS value');
        $query->select('T_PARAMETERS.type_id as type_id');
        $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETRS');
        $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON  T_PRODUCT_PARAMETRS.parameter_id = T_PARAMETERS.id');
        $query->where('T_PRODUCT_PARAMETRS.product_id = ' . $product_id);
		$query->order('T_PRODUCT_PARAMETRS.productparameters_id ASC');
        $query->group('T_PRODUCT_PARAMETRS.parameter_id');
        $query->having('COUNT(T_PRODUCT_PARAMETRS.parameter_value) > 1 OR T_PARAMETERS.type_id = 1 OR T_PARAMETERS.type_id = 2');
        $db->setQuery($query);
        $selectable_parameter_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }

        // override with order product parameters
        $product_override_parameters = array();
        if (empty($selectable_parameter_rows) == false) {
            foreach ($selectable_parameter_rows as $selectable_parameter_row) {
                if ((empty($product_parameters) == false) && (isset($product_parameters[intval($selectable_parameter_row->id)]))) {
                    $product_override_parameters[intval($selectable_parameter_row->id)] = $product_parameters[intval($selectable_parameter_row->id)];
                } else {
                    $product_override_parameters[intval($selectable_parameter_row->id)] = '';
                }
            }
        }

        return $product_override_parameters;
    }

    private function check_products_availability(&$products_data) {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $unavailable_products_ids = array();
        foreach ($products_data as $id => $product_data) {
            $query->clear();
            $query->select('amount_in_stock');
            $query->select('unlimited');
            $query->from('#__ecommercewd_products ');
            $query->where('id = ' . $product_data->id);
            $query->where('published = 1');
            $db->setQuery($query);
            $row_product = $db->loadObject();

            if (($row_product->unlimited == 0) && ($row_product->amount_in_stock <= 0) ) {
                $unavailable_products_ids[] = $id;
                continue;
            }
        }

        if (empty($unavailable_products_ids) == false) {
            $app->enqueueMessage(WDFText::get('MSG_PRODUCTS_UNAVAILABLE'), 'error');
            foreach ($unavailable_products_ids as $id) {
                unset($products_data[$id]);
            }
        }
    }
	
	private function check_products_shipment(&$products_data, $field_country_id, $init ) {
		$app = JFactory::getApplication();
		$options = WDFHelper::get_model('options')->get_options();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
	
        $unavailable_products_ids = array();
        foreach ($products_data as $id => $product_data) {
            $query->clear();
            $query->select('T_PRODUCT_SHIPPING_METHOD_COUNTRIES.country_id');
			$query->from('#__ecommercewd_productshippingmethods AS T_PRODUCT_SHIPPING_METHODS');
			$query->leftJoin('#__ecommercewd_shippingmethodcountries AS T_PRODUCT_SHIPPING_METHOD_COUNTRIES ON  T_PRODUCT_SHIPPING_METHODS.shipping_method_id = T_PRODUCT_SHIPPING_METHOD_COUNTRIES.shipping_method_id');
            $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON T_PRODUCTS.id = T_PRODUCT_SHIPPING_METHODS.product_id' );           
			$query->where('T_PRODUCTS.id = ' . $product_data->id);
            $query->where('T_PRODUCTS.published = 1');

            $query->where('T_PRODUCT_SHIPPING_METHOD_COUNTRIES.shipping_method_id = ' . $product_data->shipping_method_id); 
            $query->where('(T_PRODUCTS.enable_shipping = 1 OR ( T_PRODUCTS.enable_shipping = 2 AND '.$options->checkout_enable_shipping.' = 1 ))');
        
			$db->setQuery($query);
            $result_country_ids = $db->loadObjectList();


			// get enable shipping
			$query->clear();
            $query->select('enable_shipping');
			$query->from('#__ecommercewd_products');
			$query->where('id = ' . $product_data->id);
           
			$db->setQuery($query);
            $enable_shipping = $db->loadResult();
			
			$country_ids = array();
			foreach( $result_country_ids as $result_country_id ) {
				$country_ids[] = $result_country_id->country_id;
            }
            if ( !in_array($field_country_id, $country_ids) &&  ($enable_shipping == 1 || ($enable_shipping == 2 && $options->checkout_enable_shipping == 1 )) ) {
                $unavailable_products_ids[] = $id;
                continue;
            }
			
        }
        if (empty($unavailable_products_ids) == false) {
			if( $init == 1 )
				$app->enqueueMessage(WDFText::get('MSG_PRODUCTS_WILL_NOT_SHIP_TO_YOUR_COUNTRY'), 'error');
            foreach ($unavailable_products_ids as $id) {
                unset($products_data[$id]);
            }
        }

	
	}

    private function update_checkout_data(&$checkout_data) {
        $data = WDFInput::get('data');
        switch ($data) {
            case 'shipping_data':
                $checkout_data['billing_data_first_name'] = WDFInput::get('billing_data_first_name', $checkout_data['billing_data_first_name']);
                $checkout_data['billing_data_middle_name'] = WDFInput::get('billing_data_middle_name', $checkout_data['billing_data_middle_name']);
                $checkout_data['billing_data_last_name'] = WDFInput::get('billing_data_last_name', $checkout_data['billing_data_last_name']);
                $checkout_data['billing_data_email'] = WDFInput::get('billing_data_email', $checkout_data['billing_data_email']);
                $checkout_data['billing_data_company'] = WDFInput::get('billing_data_company', $checkout_data['billing_data_company']);
                $checkout_data['billing_data_country_id'] = WDFInput::get('billing_data_country_id', $checkout_data['billing_data_country_id'], 'int');
                $checkout_data['billing_data_state'] = WDFInput::get('billing_data_state', $checkout_data['billing_data_state']);
                $checkout_data['billing_data_city'] = WDFInput::get('billing_data_city', $checkout_data['billing_data_city']);
                $checkout_data['billing_data_address'] = WDFInput::get('billing_data_address', $checkout_data['billing_data_address']);
                $checkout_data['billing_data_mobile'] = WDFInput::get('billing_data_mobile', $checkout_data['billing_data_mobile']);
                $checkout_data['billing_data_phone'] = WDFInput::get('billing_data_phone', $checkout_data['billing_data_phone']);
                $checkout_data['billing_data_fax'] = WDFInput::get('billing_data_fax', $checkout_data['billing_data_fax']);
                $checkout_data['billing_data_zip_code'] = WDFInput::get('billing_data_zip_code', $checkout_data['billing_data_zip_code']);						
                $checkout_data['shipping_data_first_name'] = WDFInput::get('shipping_data_first_name', $checkout_data['shipping_data_first_name']);
                $checkout_data['shipping_data_middle_name'] = WDFInput::get('shipping_data_middle_name', $checkout_data['shipping_data_middle_name']);
                $checkout_data['shipping_data_last_name'] = WDFInput::get('shipping_data_last_name', $checkout_data['shipping_data_last_name']);
                $checkout_data['shipping_data_company'] = WDFInput::get('shipping_data_company', $checkout_data['shipping_data_company']);
                $checkout_data['shipping_data_country_id'] = WDFInput::get('shipping_data_country_id', $checkout_data['shipping_data_country_id'], 'int') ;
                $checkout_data['shipping_data_state'] = WDFInput::get('shipping_data_state', $checkout_data['shipping_data_state']);
                $checkout_data['shipping_data_city'] = WDFInput::get('shipping_data_city', $checkout_data['shipping_data_city']);
                $checkout_data['shipping_data_address'] = WDFInput::get('shipping_data_address', $checkout_data['shipping_data_address']);
                $checkout_data['shipping_data_zip_code'] = WDFInput::get('shipping_data_zip_code', $checkout_data['shipping_data_zip_code']);      
			   break;
            case 'products_data':
                foreach ($checkout_data['products_data'] as $product_id => $product_data) {
                    $product_data->count = WDFInput::get('product_count_' . $product_data->id . '_' . $product_data->order_product_id, $product_data->count, 'int');
                    $product_parameters =& $product_data->parameters;

                    foreach ($product_parameters as $parameter_id => $parameter_value) {
                         $product_parameters[$parameter_id] = JRequest::getVar('product_parameter_' . $product_data->id . '_' . $parameter_id . '_' . $product_data->order_product_id, $product_parameters[$parameter_id]);
                    }
                    $product_data->shipping_method_id = WDFInput::get('product_shipping_method_id_' . $product_data->id . '_' . $product_data->order_product_id, 0, 'int');
                }
                break;
            case 'confirm_data':
                $j_user = JFactory::getUser();

                $checkout_data['payment_method'] = WDFInput::get('payment_method');
                $checkout_data['j_user_id'] = $j_user->id;
                $checkout_data['user_ip_address'] = WDFUtils::get_client_ip_address();
                break;
        }

    }

    private function get_product_parameters_string($product_data) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
		$decimals = $options->option_show_decimals == 1 ? 2 : 0;
        $query->clear();
        $query->select('T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
		$query->select('GROUP_CONCAT(T_PRODUCT_PARAMETERS.parameter_value) AS value');
        $query->from('#__ecommercewd_parameters AS T_PARAMETERS');
        $query->leftJoin('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
        $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_data->id);
		$query->group('T_PARAMETERS.id');
        $query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
        $db->setQuery($query);
        $product_parameters = $db->loadAssocList('id');

        if ($db->getErrorNum()) {
            return false;
        }
		
		$row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');
        $price_sum = 0;

        $str_parameters = array();
        $override_parameters = $product_data->parameters;
        foreach ($product_parameters as $parameter_id => $product_parameter) {
            $insert = true;
            if (isset($override_parameters[$parameter_id]) == false) {
                continue;
            }

            $product_parameter['value'] = $override_parameters[$parameter_id];
			$product_parameter['text'] = array();
			
            // check if value exists
            $query->clear();
            $query->select('T_PARAMETERS.type_id AS type_id');
            $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
            $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
            $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_data->id);
            $query->where('T_PRODUCT_PARAMETERS.parameter_id = ' . $parameter_id);
            $db->setQuery($query);
            $type_id = $db->loadResult();

            if ($type_id != 1 && $type_id != 2) {
                if (!is_array($product_parameter['value'])) {
                    $product_parameter_array = array($product_parameter['value']);
                } else {
                    if(sizeof($product_parameter['value']) != 0) {
                        $product_parameter_array = $product_parameter['value'];
                    } else {
                        $product_parameter_array = array();
                        $insert = false;
                    }
                }
                foreach ($product_parameter_array as $value) {
                    if( $value != '' && $value != '0' && sizeof($value) != 0){
                        $query->clear();
                        $query->select('COUNT(*)');
                        $query->from('#__ecommercewd_productparameters');
                        $query->where('product_id = ' . $product_data->id);
                        $query->where('parameter_id = ' . $product_parameter['id']);
                        $query->where('parameter_value = ' . $db->quote($value));
                        $db->setQuery($query);
                        $count = $db->loadResult();
                        if (($db->getErrorNum()) || ($count < 1)) {
                            return false;
                        }

                        //get the price
                        $query->clear();
                        $query->select('T_PRODUCT_PARAMETERS.parameter_value_price AS price');
                        $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
                        $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_data->id);
                        $query->where('T_PRODUCT_PARAMETERS.parameter_id = ' . $parameter_id);
                        $query->where('T_PRODUCT_PARAMETERS.parameter_value = "' . $value . '"');
                        $db->setQuery($query);
                        $price = $db->loadResult();
						$price_sign = substr( $price ,0,1);	
						$price  = $price_sign.number_format(substr( $price ,1), $decimals);
                        $param_data['value'] = $value;
                        $param_data['price'] = $price;
                        array_push($product_parameter['text'], $param_data);
                    } else {
                        $insert = false;
                    }
                }
            } else {
                if($product_parameter['value'] != '') {
                    $param_data['value'] = $product_parameter['value'];
                    $param_data['price'] = '';
                    array_push($product_parameter['text'], $param_data);
                } else {
                    $insert = false;
                }
            }


            $str_param_values_array = array();
            foreach ($product_parameter['text'] as $text) {
                if ($text['price'] != '' && $text['price'] != '+') {
                    if($row_default_currency->sign_position == 1){
						$str_param_values_array[] = $text['value'] . ' (' . $text['price'] . $row_default_currency->sign . ')';
					}
					else{
						$str_param_values_array[] = $text['value'] . ' (' . substr($text['price'],0,1 ). $row_default_currency->sign . substr($text['price'],1 ). ')';
					}
                    $price_sign = substr($text['price'], 0, 1);
                    $price = substr($text['price'], 1, strlen($text['price']));
                    if($price_sign == '+'){
                        $price_sum = sprintf("%.2f", $price_sum) + sprintf("%.2f", $price);
                    } else {
                        $price_sum = sprintf("%.2f", $price_sum) - sprintf("%.2f", $price);
                    }
                } else {
                    $str_param_values_array[] = $text['value'];
                }
            }
            if($insert){
                $str_param_value = implode(',', $str_param_values_array);
                $str_parameters[] = $product_parameter['name'] . ': ' . $str_param_value;
            }
        }
        $params['str'] = addslashes(implode(', ', $str_parameters));
        $params['price'] = sprintf("%.2f", $price_sum);

        return $params;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}
