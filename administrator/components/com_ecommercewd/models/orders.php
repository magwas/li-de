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
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_row($id = 0) {
        $row = parent::get_row($id);

        // additional data
        // product data
        $row->order_products = $this->get_order_products($row->id);
        $product_names = array();
		$product_names_invoice = array();
        $products_total_price = 0;
        $tax_toal_price = 0;
        $shipping_method_total_price = 0;
        $total_price = 0;
        foreach ($row->order_products as $order_product) {
            $product_names[] = '<strong>' . $order_product->product_name . '</strong>' . ' (' . $order_product->product_price_text . ' + ' . WDFText::get('TAX') . ': ' . $order_product->tax_price_text . ' + ' . WDFText::get('SHIPPING') . ': ' . $order_product->shipping_method_price_text . ')' . ' x' . $order_product->product_count . ' = <strong>' . $order_product->subtotal_text . '</strong><br>'.$order_product->product_parameters;
            $product_names_invoice[] = array(
										'product_name'               => $order_product->product_name,
										'product_price_text'         => $order_product->product_price_text,
										'tax_price_text'             => $order_product->tax_price_text,
										'shipping_method_price_text' => $order_product->shipping_method_price_text,
										'product_count'              => $order_product->product_count,
										'subtotal_text'              => $order_product->subtotal_text,
										'currency_code'              => $order_product->currency_code
										);		
										
			$products_total_price += $order_product->product_price * $order_product->product_count;
            $tax_toal_price += $order_product->tax_price * $order_product->product_count;
            $shipping_method_total_price += $order_product->shipping_method_price * $order_product->product_count;
            $total_price += $order_product->subtotal;
        }

        $row->product_names = implode('<hr>', $product_names);
		$row->product_names_invoice =   $product_names_invoice;
        $row->products_price = $products_total_price;
        $row->tax_price = $tax_toal_price;
        $row->shipping_price = $shipping_method_total_price;
        $row->total_price = $total_price;

        $row->total_price_text = number_format($row->total_price, 2) . ' ' . $row->currency_code;

        // payment status
        $row->payment_data_status = $row->payment_data_status != '' ? $row->payment_data_status : '-';

        // user data
        $j_user = JFactory::getUser($row->j_user_id);
        $row_user = WDFDb::get_row('users', 'j_user_id = ' . $j_user->id);
        $row->user_id = $row_user->id;
        if ($row_user->id != 0) {
            $row->user_name = $row_user->first_name . ($row_user->middle_name == '' ? '' : ' ' . $row_user->middle_name) . ($row_user->last_name == '' ? '' : ' ' . $row_user->last_name);
            $row->user_view_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=users' . '&task=view' . '&cid[]=' . $row_user->id;
        } else if ($j_user->id != 0) {
            $row->user_name = $j_user->name;
            $row->user_view_url = '';
        } else {
            $name_parts = array();
            if ($row->shipping_data_first_name != '') {
                $name_parts[] = $row->shipping_data_first_name;
            }
            if ($row->shipping_data_middle_name != '') {
                $name_parts[] = $row->shipping_data_middle_name;
            }
            if ($row->shipping_data_last_name != '') {
                $name_parts[] = $row->shipping_data_last_name;
            }
            $row->user_name = implode(' ', $name_parts);
            $row->user_view_url = '';
        }
	
		$row->view_payment_data = WDFHelperFunctions::object_to_array(WDFJson::decode($row->payment_data));
        return $row;
    }

    public function get_rows() {
        $rows = parent::get_rows();

        // additional data
        // products data and total
        foreach ($rows as $row) {
            $row->order_products = $this->get_order_products($row->id);
            $product_names = array();
            $products_price = 0;
            $tax_price = 0;
            $shipping_method_price = 0;
            $total_price = 0;
            foreach ($row->order_products as $order_product) {
                $product_names[] = $order_product->product_name . ' x' . $order_product->product_count;
                $products_price += $order_product->product_price * $order_product->product_count;
                $tax_price += $order_product->tax_price * $order_product->product_count;
                $shipping_method_price += $order_product->shipping_method_price * $order_product->product_count;
                $total_price += $order_product->subtotal;
            }

            $row->product_names = implode('<br>', $product_names);
            $row->products_price = $products_price;
            $row->tax_price = $tax_price;
            $row->shipping_price = $shipping_method_price;
            $row->total_price = $total_price;

            $row->total_price_text = number_format($row->total_price, 2) . ' ' . $row->currency_code;

            // payment status
            $row->payment_data_status = $row->payment_data_status == '' ? '-' : $row->payment_data_status;
			
			// view payment data url
			$row->view_payment_data_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=orders&task=paymentdata' . '&cid[]=' . $row->id .'&tmpl=component';
			
            // user data
            $j_user = JFactory::getUser($row->j_user_id);
            $row_user = WDFDb::get_row('users', 'j_user_id = ' . $j_user->id);
            $row->user_id = $row_user->id;
            if ($row_user->id != 0) {
                $row->user_name = $row_user->first_name . ($row_user->middle_name == '' ? '' : ' ' . $row_user->middle_name) . ($row_user->last_name == '' ? '' : ' ' . $row_user->last_name);
                $row->user_view_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=users' . '&task=view' . '&cid[]=' . $row_user->id;
            } else if ($j_user->id != 0) {
                $row->user_name = $j_user->name;
                $row->user_view_url = '';
            } else {
                $name_parts = array();
                if ($row->shipping_data_first_name != '') {
                    $name_parts[] = $row->shipping_data_first_name;
                }
                if ($row->shipping_data_middle_name != '') {
                    $name_parts[] = $row->shipping_data_middle_name;
                }
                if ($row->shipping_data_last_name != '') {
                    $name_parts[] = $row->shipping_data_last_name;
                }
                $row->user_name = implode(' ', $name_parts);
                $row->user_view_url = '';
            }
        }

        return $rows;
    }
	

    public function get_lists() {

        $lists = array();
        $lists['order_statuses'] = WDFDb::get_list('orderstatuses', 'id', 'name', array(" published = '1' "), 'ordering ASC');
		$lists['payment_methods'] = WDFDb::get_list('payments', 'short_name', 'name', array(" published = '1' "), 'ordering ASC');

        return $lists;
    }

    public function add_order_products_details_for_email($row_order) {
        $order_products = $this->get_order_products($row_order->id);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options_row();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        $product_names = array();
        $total_price = 0;
        foreach ($order_products as $order_product) {
            $product_names[] = '<strong>' . $order_product->product_name . '</strong>' . ' (' . $order_product->product_price_text . ' + ' . WDFText::get('TAX') . ': ' . $order_product->tax_price_text . ' + ' . WDFText::get('SHIPPING') . ': ' . $order_product->shipping_method_price_text . ')' . ' x' . $order_product->product_count . ' = <strong>' . $order_product->subtotal_text . '</strong>';
            $total_price += $order_product->subtotal;
        }

        // total price text and currency code
        $total_price_text = number_format($total_price, $decimals) . $row_order->currency_code;

        $row_order->products_details = implode('<br>', $product_names);
        $row_order->total_price = $total_price;
        $row_order->total_price_text = $total_price_text;

        return $row_order;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_filters() {
        $filter_items = array();

        // checkout date from
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'checkout_date_from';
        $filter_item->default_value = null;
        $filter_item->operator = '>=';
        $filter_item->input_type = 'date';
        $filter_item->input_label = WDFText::get('DATE_FROM');
        $filter_item->input_name = 'search_checkout_date_from';
        $filter_items[$filter_item->name] = $filter_item;

        // checkout date to
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'checkout_date_to';
        $filter_item->default_value = null;
        $filter_item->operator = '<=';
        $filter_item->input_type = 'date';
        $filter_item->input_label = WDFText::get('DATE_TO');
        $filter_item->input_name = 'search_checkout_date_to';
        $filter_items[$filter_item->name] = $filter_item;
		
		// payment data
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'payment_data';
        $filter_item->default_value = null;
        $filter_item->operator = 'LIKE';
        $filter_item->input_type = 'text';
        $filter_item->input_label = WDFText::get('PAYMENT_DATA');
        $filter_item->input_name = 'search_payment_data';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    protected function add_rows_query_select(JDatabaseQuery $query) {
        $query->select($this->current_table_name . '.*');
        $query->select('CONCAT(T_USERS.first_name, " ", T_USERS.last_name) AS user_name');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        $query->from($this->current_table_name);
        $query->leftJoin('#__ecommercewd_users AS T_USERS ON #__ecommercewd_orders.j_user_id = T_USERS.j_user_id');
        $query->leftJoin('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS ON T_ORDER_PRODUCTS.order_id = #__ecommercewd_orders.id');
    }

    private function get_order_products($order_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options_row();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        $query->clear();
        $query->select('product_name');
        $query->select('product_price');
        $query->select('tax_price');
        $query->select('shipping_method_price');
        $query->select('product_count');
        $query->select('currency_code');
		$query->select('product_parameters');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = ' . $order_id);
        $db->setQuery($query);
        $order_product_rows = $db->loadObjectList();

        // additional data
        foreach ($order_product_rows as $row) {
            // prices
            $row->product_price = doubleval($row->product_price);
            $row->tax_price = doubleval($row->tax_price);
            $row->shipping_method_price = doubleval($row->shipping_method_price);
            $row->product_count = intval($row->product_count);
            $row->subtotal = ($row->product_price + $row->tax_price + $row->shipping_method_price) * $row->product_count;

            //price texts
            $row->product_price_text = number_format($row->product_price, $decimals) . $row->currency_code;
            $row->tax_price_text = number_format($row->tax_price, $decimals) . $row->currency_code;
            $row->shipping_method_price_text = number_format($row->shipping_method_price, $decimals) . $row->currency_code;
            $row->subtotal_text = number_format($row->subtotal, $decimals) . $row->currency_code;
        }

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $order_product_rows;
    }
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}