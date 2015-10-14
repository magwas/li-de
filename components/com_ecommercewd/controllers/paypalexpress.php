<?php

 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerPaypalexpress extends EcommercewdController {
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
	
	public function finish_checkout() {	
        WDFChecoutHelper::check_can_checkout();
        WDFChecoutHelper::check_checkout_data();

		$model = WDFHelper::get_model('checkout');
        $model = WDFHelper::get_model('checkout');
        if ($model->is_final_checkout_data_valid(false) == false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=0');
        }
	
       $final_checkout_data = $model->get_final_checkout_data();
        if ($final_checkout_data === false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=0');
        }

        $this->finish_checkout_with_paypal($final_checkout_data);
			
        
    }
	
	/* 
	* paypal return and cancel handler functions 
	*
	*/
    public function handle_paypal_checkout_return() {
        WDFChecoutHelper::check_can_checkout();

        $app = JFactory::getApplication();

        $j_user = JFactory::getUser();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
	
        $model = WDFHelper::get_model('checkout');
        $checkout_data = $model->store_checkout_data();
		$checkout_api_options =  $model->checkout_api_options('paypalexpress');
        if ($checkout_data === false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=0');
        }

        $model_orders = WDFHelper::get_model('orders');
        $row_order = WDFDb::get_row_by_id('orders', $checkout_data['order_id']);

        $failed = false;

        // check token parameter
        if ((isset($_GET['token']) == false) || (empty($_GET['token']))) {
            $failed = true;
            $app->enqueueMessage(WDFText::get('MSG_INVALID_TOKEN'), 'error');
        }

        // check order, and if user can checkout this order
        if ($failed == false) {
            if (WDFHelper::is_user_logged_in() == true) {
                if ($row_order->j_user_id != $j_user->id) {
                    $failed = true;
                }
            } else {
                $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids');
                if ((empty($order_rand_ids) == true) || (in_array($row_order->rand_id, $order_rand_ids) == false)) {
                    $failed = true;
                }
            }
        }

        if ($failed == false) {
            // get payment checkout details
            $is_production = $checkout_api_options->mode == 1 ? true : false;
            WDFPaypal::set_production_mode($is_production);
            $credentials = array('USER' => $checkout_api_options->paypal_user, 'PWD' => $checkout_api_options->paypal_password, 'SIGNATURE' => $checkout_api_options->paypal_signature);
            WDFPaypal::set_credentials($credentials);

            $params = array('TOKEN' => $_GET['token']);
            $checkout_details = WDFPaypal::get_express_checkout_details($params);

            // store checkout details in orders table
            $payment_data = WDFJson::decode($row_order->payment_data);
            if ($payment_data == null) {
                $payment_data = array();
            }
            $payment_data[] = $checkout_details;
            $row_order->payment_data = WDFJson::encode($payment_data);
            if (!$row_order->store()) {
                //TODO: handle error storing paypal checkout details
            }
        }

        // get order product details and complete the checkout transaction
        if ($failed == false) {
            $row_order = $model_orders->add_order_products_data($row_order, true);
            if ($row_order === false) {
                $failed = true;
            } else {
                $params = array('TOKEN' => $_GET['token'], 'PAYMENTACTION' => 'Sale', 'PAYERID' => $_GET['PayerID'], // same amount as in the original request
                    'PAYMENTREQUEST_0_ITEMAMT' => $row_order->products_price, 'PAYMENTREQUEST_0_TAXAMT' => $row_order->tax_price, 'PAYMENTREQUEST_0_SHIPPINGAMT' => $row_order->shipping_price, 'PAYMENTREQUEST_0_AMT' => $row_order->total_price, // same currency as the original request
                    'PAYMENTREQUEST_0_CURRENCYCODE' => $row_order->currency_code, 'PAYMENTREQUEST_0_NOTIFYURL' => WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=paypalexpress&task=handle_paypal_checkout_notify&order_id=' . $row_order->id);

                $response = WDFPaypal::do_express_checkout_payment($params);
                if ((is_array($response) == false) || ($response['ACK'] != 'Success')) {
                    $failed = true;
                    $errors = WDFPaypal::get_errors();
                    $msg = empty($errors) == true ? WDFText::get('MSG_CHECKOUT_FAILED') : $errors[0];
                    $app->enqueueMessage($msg, 'error');
                } else {
                    // TODO: send transaction ids to user
                    // $transaction_id = $response['PAYMENTINFO_0_TRANSACTIONID'];
                }
            }
        }

        if ($failed == true) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $checkout_data['session_id']);
        } else {
			WDFChecoutHelper::send_checkout_finished_mail($row_order);
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedsuccess', '', 'session_id=' . $checkout_data['session_id']);           
        }
    }

    public function handle_paypal_checkout_cancel() {
        WDFChecoutHelper::check_can_checkout();

        $session_id = WDFSession::get('session_id');

        $msg = WDFText::get('MSG_CHECKOUT_CANCELED');
        WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $session_id . '&error_msg=' . $msg);
    }

    public function handle_paypal_checkout_notify() {
        $order_id = WDFInput::get('order_id', 0, 'int');
        if ($order_id == 0) {
            return false;
        }

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

		$checkout_api_options =  WDFHelper::get_model('checkout')->checkout_api_options('paypalexpress');
        $is_production = $checkout_api_options->mode == 1 ? true : false;
        WDFPaypal::set_production_mode($is_production);

        // validate ipn
        $ipn_data = WDFPaypal::validate_ipn();
        if (is_array($ipn_data) == false) {
            return false;
        }

        // store ipn in db
        $row_order = WDFDb::get_row_by_id('orders', $order_id);

        // insert new data in payment_data
        $payment_data = WDFJson::decode($row_order->payment_data);
        if ($payment_data == null) {
            $payment_data = array();
        }
        $payment_data[] = $ipn_data;
        $row_order->payment_data = WDFJson::encode($payment_data);

        // update payment data status
        $row_order->payment_data_status = $ipn_data['payment_status'];
        // mark as unread
        $row_order->read = 0;

        if ($row_order->store() == false) {
            $this->save_paypal_ipn_error_log($row_order->id, $ipn_data);
        }
    }


	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////	
	
	private function finish_checkout_with_paypal($final_checkout_data) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
        $checkout_api_options = WDFHelper::get_model('checkout')->checkout_api_options('paypalexpress');
		
        $is_production = $checkout_api_options->mode == 1 ? true : false;
        WDFPaypal::set_production_mode($is_production);

        // credentials
        $credentials = array('USER' => $checkout_api_options->paypal_user, 'PWD' => $checkout_api_options->paypal_password, 'SIGNATURE' => $checkout_api_options->paypal_signature);
        WDFPaypal::set_credentials($credentials);

        // callbacks
        $request_params = array('RETURNURL' => WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=paypalexpress&task=handle_paypal_checkout_return&session_id=' . $final_checkout_data['session_id'], 'CANCELURL' => WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=paypalexpress&task=handle_paypal_checkout_cancel&session_id=' . $final_checkout_data['session_id']);

        $products_price_total = 0;
        $product_taxes_price_total = 0;
        $product_shipping_price_total = 0;
        // products data
        $products_data = $final_checkout_data['products_data'];
        $items_params = array();
        $i = 0;
        foreach ($products_data as $product_data) {
            $items_params['L_PAYMENTREQUEST_0_NAME' . $i] = $product_data->name;
            $items_params['L_PAYMENTREQUEST_0_DESC' . $i] = $product_data->description;
            $items_params['L_PAYMENTREQUEST_0_AMT' . $i] = $product_data->price;
            $items_params['L_PAYMENTREQUEST_0_TAXAMT' . $i] = $product_data->tax_price;
            $items_params['L_PAYMENTREQUEST_0_QTY' . $i] = $product_data->count;
            $items_params['L_PAYMENTREQUEST_0_ITEMURL' . $i] = $product_data->url;

            $products_price_total += $product_data->count * $product_data->price;
            $product_taxes_price_total += $product_data->count * $product_data->tax_price;
            $product_shipping_price_total += $product_data->count * $product_data->shipping_method_price;

            $i++;
        }

        // order data
        $order_params = array('PAYMENTREQUEST_0_AMT' => $products_price_total + $product_taxes_price_total + $product_shipping_price_total, 'PAYMENTREQUEST_0_ITEMAMT' => $products_price_total, 'PAYMENTREQUEST_0_TAXAMT' => $product_taxes_price_total, 'PAYMENTREQUEST_0_SHIPPINGAMT' => $product_shipping_price_total, 'PAYMENTREQUEST_0_CURRENCYCODE' => $final_checkout_data['currency_code']);

        WDFPaypal::set_express_checkout($request_params, $order_params, $items_params);

        $errors = WDFPaypal::get_errors();
        if (empty($errors) == false) {
            $error_msg = $errors[0];
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $final_checkout_data['session_id'] . '&error_msg=' . $error_msg);
        }
    }
	
	private function save_paypal_ipn_error_log($order_id, $ipn_data) {
        // TODO: user friendly log
        $log_content = WDFJson::encode($ipn_data);
        file_put_contents($order_id . '_' . date("Y_m_d_H_i_s") . '.txt', $log_content);
    }
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}
