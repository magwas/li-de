<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelOrders extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    const MAX_PRODUCT_NAME_LENGTH = 20;
    const MAX_PRODUCT_NAMES_LENGTH = 30;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_order_row($order_id = 0) {
        if ($order_id == 0) {
            $order_id = WDFInput::get('order_id', 0, 'int');
        }
			
        $app = JFactory::getApplication();

        $j_user = JFactory::getUser();

        // get order row
        $row_order = WDFDb::get_row_by_id('orders', $order_id);
        if ($row_order->id == 0) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('systempages', 'displayerror', '&tmpl=component', 'code=2');
            else
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        // check if user can access this order
        $can_user_access = false;
        if (WDFHelper::is_user_logged_in() == true) {
            if ($row_order->j_user_id == $j_user->id) {
                $can_user_access = true;
            }
        } else {
            $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids');
            if ((empty($order_rand_ids) == false) && (in_array($row_order->rand_id, $order_rand_ids))) {
                $can_user_access = true;
            }
        }
        if ($can_user_access == false) {
            $app->enqueueMessage(WDFText::get('MSG_WRONG_REQUEST'), 'error');
            if(WDFInput::get('type'))
                WDFHelper::redirect('orders', '&tmpl=component', 'displayorders');
            else
                WDFHelper::redirect('orders', 'displayorders');
        }
        // add order products data, total price and currency
        $row_order = $this->add_order_products_data($row_order, true);
        if ($row_order === false) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('systempages', 'displayerror', '&tmpl=component', 'code=2');
            else
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        return $row_order;
    }

    public function add_order_products_data($row_order, $max_product_name_length = false ) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        // order products
        $query->clear();
        $query->select('T_ORDERP_RODUCTS.product_id AS id');
        $query->select('T_ORDERP_RODUCTS.product_name AS name');
        $query->select('T_ORDERP_RODUCTS.product_image AS image');
        $query->select('T_ORDERP_RODUCTS.currency_code');
        $query->select('T_ORDERP_RODUCTS.product_price AS price');
        $query->select('T_ORDERP_RODUCTS.tax_price');
        $query->select('T_ORDERP_RODUCTS.shipping_method_name');
        $query->select('T_ORDERP_RODUCTS.shipping_method_price');
        $query->select('T_ORDERP_RODUCTS.product_count AS count');
        $query->select('T_ORDERP_RODUCTS.product_parameters AS parameters');
		$query->select('T_PRODUCTS.enable_shipping');
        $query->from('#__ecommercewd_orderproducts AS T_ORDERP_RODUCTS');
		$query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON T_ORDERP_RODUCTS.product_id = T_PRODUCTS.id');
        $query->where('T_ORDERP_RODUCTS.order_id = ' . $row_order->id);
        $db->setQuery($query);
        $row_order->product_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
			
        }

        $products_price = 0;
        $tax_price = 0;
        $shipping_price = 0;
        $total_price = 0;
        foreach ($row_order->product_rows as $product_row) {
			if( $max_product_name_length == false)
				if (strlen($product_row->name) > self::MAX_PRODUCT_NAME_LENGTH) {
					$product_row->name = WDFTextUtils::truncate($product_row->name, self::MAX_PRODUCT_NAME_LENGTH);
				}

            // subtotal
            $product_row->subtotal = ($product_row->price + $product_row->tax_price + $product_row->shipping_method_price) * $product_row->count;

            // prices
            $product_row->price_text = number_format($product_row->price, $decimals);
            $product_row->tax_price_text = number_format($product_row->tax_price, $decimals);
            $product_row->shipping_method_price_text = number_format($product_row->shipping_method_price, $decimals);
            $product_row->subtotal_text = number_format($product_row->subtotal, $decimals);

            // currency codes
            $product_row->price_text .= $product_row->currency_code;
            $product_row->tax_price_text .= $product_row->currency_code;
            $product_row->shipping_method_price_text .= $product_row->currency_code;
            $product_row->subtotal_text .= $product_row->currency_code;

            // order prices
            $products_price += $product_row->price * $product_row->count;
            $tax_price += $product_row->tax_price * $product_row->count;
            $shipping_price += $product_row->shipping_method_price * $product_row->count;
            $total_price += $product_row->subtotal;
        }

        // total price text and currency symbol
        $row_order->products_price = $products_price;
        $row_order->tax_price = $tax_price;
        $row_order->shipping_price = $shipping_price;
        $row_order->total_price = $total_price;
        $row_order->products_price = number_format($row_order->products_price, $decimals) . $row_order->currency_code;
        $row_order->tax_price = number_format($row_order->tax_price, $decimals) . $row_order->currency_code;
        $row_order->shipping_price = number_format($row_order->shipping_price, $decimals) . $row_order->currency_code;
        $row_order->total_price_text = number_format($row_order->total_price, $decimals) . $row_order->currency_code;

        return $row_order;
    }

    public function get_orders_data() {
        $pagination = $this->get_orders_pagination();
        $order_rows = $this->get_order_rows($pagination);

        $data = array();
        $data['pagination'] = $pagination;
        $data['order_rows'] = $order_rows;
        return $data;
    }

    public function get_order_rand_id() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('rand_id');
        $query->from('#__ecommercewd_orders');
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
	
	public function get_print_order(){
	
        $order_row = $this->get_order_row();	
		$product_names_invoice = array();
		$row =  new stdClass();
		$row->id =  $order_row->id;
		$row->checkout_date =  $order_row->checkout_date;
		$row->payment_method =  $order_row->payment_method;
		$row->billing_data_first_name =  $order_row->billing_data_first_name;
		$row->billing_data_middle_name =  $order_row->billing_data_middle_name;
		$row->billing_data_last_name =  $order_row->billing_data_last_name;
		$row->billing_data_address =  $order_row->billing_data_address;
		$row->billing_data_state =  $order_row->billing_data_state;
		$row->billing_data_zip_code =  $order_row->billing_data_zip_code;
		$row->billing_data_city =  $order_row->billing_data_city;
		$row->billing_data_country =  $order_row->billing_data_country;
		$row->billing_data_email =  $order_row->billing_data_email;
		$row->billing_data_phone =  $order_row->billing_data_phone;
		$row->billing_data_fax =  $order_row->billing_data_fax;
		$row->shipping_data_first_name =  $order_row->shipping_data_first_name;
		$row->shipping_data_middle_name =  $order_row->shipping_data_middle_name;
		$row->shipping_data_last_name =  $order_row->shipping_data_last_name;
		$row->shipping_data_address =  $order_row->shipping_data_address;
		$row->shipping_data_state =  $order_row->shipping_data_state;
		$row->shipping_data_zip_code =  $order_row->shipping_data_zip_code;
		$row->shipping_data_city =  $order_row->shipping_data_city;
		$row->shipping_data_country =  $order_row->shipping_data_country;

		foreach( $order_row->product_rows as $order_product)
		{
			$product_names_invoice[] = array(
							'product_name'               => $order_product->name,
							'product_price_text'         => $order_product->price_text,
							'tax_price_text'             => $order_product->tax_price_text,
							'shipping_method_price_text' => $order_product->shipping_method_price_text,
							'product_count'              => $order_product->count,
							'subtotal_text'              => $order_product->subtotal_text,
							'currency_code'              => $order_product->currency_code
							);	

		}
		$row->product_names_invoice = $product_names_invoice;
		
		return $row;

	}

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_orders_pagination() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $theme = WDFHelper::get_model('theme')->get_theme_row();

        // get orders count
        $query->clear();
        $query->select('COUNT(*)');
        $query->from('#__ecommercewd_orders');
        if (WDFHelper::is_user_logged_in() == true) {
            $j_user = JFactory::getUser();
            $query->where('j_user_id = ' . $j_user->id);
        } else {
            $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids', array());
            if (empty($order_rand_ids) == false) {
                $query->where('j_user_id = 0');
                $query->where('rand_id IN (' . implode(',', $order_rand_ids) . ')');
            } else {
                $query->where(0);
            }
        }
        $db->setQuery($query);
        $orders_count = $db->loadResult();

        if ($db->getErrorNum()) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('systempages', 'displayerror', '&tmpl=component', 'code=2');
            else
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        $limit_start = WDFInput::get('pagination_limit_start', 0, 'int');
        $limit = WDFInput::get('pagination_limit', $theme->orders_count_in_page, 'int');

        $pagination = new JPagination($orders_count, $limit_start, $limit);
        return $pagination;
    }

    private function get_order_rows($pagination) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        $query->clear();
        $query->select('T_ORDERS.id');
        $query->select('CONCAT(T_ORDERS.billing_data_first_name," ",T_ORDERS.billing_data_middle_name," ",T_ORDERS.billing_data_last_name) AS name');
        $query->select('GROUP_CONCAT(T_ORDER_PRODUCTS.id SEPARATOR ",") AS str_order_product_ids');
        $query->select('GROUP_CONCAT(DISTINCT T_ORDER_PRODUCTS.product_name SEPARATOR ", ") AS product_names');
        $query->select('T_ORDERS.checkout_date');
        $query->select('T_ORDERS.status_name');
        $query->select('SUM(T_ORDER_PRODUCTS.product_price * T_ORDER_PRODUCTS.product_count) AS price');
        $query->select('SUM(T_ORDER_PRODUCTS.tax_price * T_ORDER_PRODUCTS.product_count) AS tax_price');
        $query->select('SUM(T_ORDER_PRODUCTS.shipping_method_price * T_ORDER_PRODUCTS.product_count) AS shipping_price');
        $query->select('T_ORDERS.currency_code');
        $query->from('#__ecommercewd_orders AS T_ORDERS');
        $query->leftJoin('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS ON T_ORDER_PRODUCTS.order_id = T_ORDERS.id');

		if (JRequest::getVar('product_id') == '') {
			// my orders 
			if (WDFHelper::is_user_logged_in() == true) {
				$j_user = JFactory::getUser();
				$query->where('T_ORDERS.j_user_id = ' . $j_user->id);
			} else {
				$order_rand_ids = WDFInput::cookie_get_array('order_rand_ids', array());
				if (empty($order_rand_ids) == false) {
					$query->where('T_ORDERS.j_user_id = 0');
					$query->where('T_ORDERS.rand_id IN (' . implode(',', $order_rand_ids) . ')');
				} else {
					$query->where(0);
				}
			}
		}
		
		if (JRequest::getVar('product_id') != '') {
			// orders for one product
			$query->where('T_ORDER_PRODUCTS.product_id = "'.JRequest::getVar('product_id').'"');
		}
		
        $query->order('T_ORDERS.checkout_date DESC');
        $query->group('T_ORDERS.id');
        $db->setQuery($query, $pagination->limitstart, $pagination->limit);
        $order_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('systempages', 'displayerror', '&tmpl=component', 'code=2');
            else
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        // additional data
        foreach ($order_rows as $order_row) {
            // order_link
            $order_row->order_link = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=displayorder&order_id=' . $order_row->id);
           
			$order_row->print_orders_link = JURI::base().'index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=printorder&order_id=' . $order_row->id .'&tmpl=component';
			$order_row->pdf_invoice_link = JURI::base().'index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=pdfinvoice&order_id=' . $order_row->id .'&tmpl=component';

            // order product ids
            $order_row->order_product_ids = explode(',', $order_row->str_order_product_ids);

            // product names
            if (strlen($order_row->product_names) > self::MAX_PRODUCT_NAMES_LENGTH) {
                $order_row->product_names = WDFTextUtils::truncate($order_row->product_names, self::MAX_PRODUCT_NAMES_LENGTH);
            }

            // product images
            $product_images = array();
            foreach ($order_row->order_product_ids as $order_product_id) {
                $row_order_product = WDFDb::get_row_by_id('orderproducts', $order_product_id);
                $product_images[] = $row_order_product->product_image;
            }
            $order_row->product_images = $product_images;
			$order_row->subtotal = $order_row->price + $order_row->tax_price + $order_row->shipping_price ;
            // prices
            $order_row->price_text = number_format($order_row->price, $decimals);
            $order_row->tax_price_text = number_format($order_row->tax_price, $decimals);
            $order_row->shipping_price_text = number_format($order_row->shipping_price, $decimals);
            $order_row->total_price_text = number_format($order_row->subtotal, $decimals);

            // currency codes
            $order_row->price_text .= $order_row->currency_code;
            $order_row->tax_price_text .= $order_row->currency_code;
            $order_row->shipping_price_text .= $order_row->currency_code;
            $order_row->total_price_text .= $order_row->currency_code;
        }

        return $order_rows;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}