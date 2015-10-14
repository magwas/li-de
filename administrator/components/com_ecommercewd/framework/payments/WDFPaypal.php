<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFPaypal {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * API Version
     * @var string
     */
    public static $currencies_without_decimal_support = array('HUF', 'TWD', 'JPY');
	
    /**
     * Editable field types
     * 
     */
	 

	public static $field_types = array('mode'             => array('type'=>'radio','options'=>array('SANDBOX','PRODUCTION'),'text'=>'CHECKOUT_MODE','attributes'=>''),	
									   'paypal_user'      => array('type'=>'text','text'=>'USER','attributes'=>''),
									   'paypal_password'  => array('type'=>'text','text'=>'PASSWORD','attributes'=>''),
									   'paypal_signature' => array('type'=>'text','text'=>'SIGNATURE','attributes'=>''));

    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * API Version
     * @var string
     */
    private static $version = '74.0';

    /**
     * production or sandbox(testing)
     * @var boolean
     */
    private static $is_production = false;

    /**
     * default API Credentials
     * @var array
     */
    private static $credentials = array('USER' => '', 'PWD' => '', 'SIGNATURE' => '',);

    /**
     * error message(s)
     * @var array
     */
    private static $errors = array();


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * set checkout mode. production if true, sandbox if false
     *
     * @param array $credentials seller credentials (USER, PWD, SIGNATURE)
     */
    public static function set_production_mode($is_production) {
        self::$is_production = $is_production;
    }

    /**
     * set paypal seller credentials
     *
     * @param array $credentials seller credentials (USER, PWD, SIGNATURE)
     */
    public static function set_credentials($credentials = array()) {
        self::$credentials = $credentials;
    }

    /**
     * Make API request
     *
     * @param string $method string API method to request
     * @param array $params Additional request parameters
     * @return array / boolean Response array / boolean false on failure
     */
    public static function request($method, $params = array()) {
        // check if API method is not empty
        if (empty($method)) {
            self::$errors[] = 'API method is missing';
            return false;
        }

        // our request parameters
        $request_params = array('METHOD' => $method, 'VERSION' => self::$version) + self::$credentials;

        // building our NVP string
        $str_request = http_build_query($request_params + $params);


        // cURL settings
        $curl_options = array(CURLOPT_URL => self::$is_production == true ? 'https://api-3t.paypal.com/nvp' : 'https://api-3t.sandbox.paypal.com/nvp', CURLOPT_VERBOSE => 1, CURLOPT_SSL_VERIFYPEER => false, // TODO:
            //            CURLOPT_SSL_VERIFYPEER => true,
            //            CURLOPT_SSL_VERIFYHOST => 2,
            //            CURLOPT_CAINFO => dirname(__FILE__) . '/cacert.pem', //CA cert file
            CURLOPT_RETURNTRANSFER => 1, CURLOPT_POST => 1, CURLOPT_POSTFIELDS => $str_request);

        $curl_handle = curl_init();
        curl_setopt_array($curl_handle, $curl_options);

        // sending request - $response will hold the API response
        $response = curl_exec($curl_handle);

        // checking for cURL errors
        if (curl_errno($curl_handle)) {
            self::$errors[] = curl_error($curl_handle);
            curl_close($curl_handle);
            return false;
        }

        curl_close($curl_handle);


        // break the NVP string to an array
        $response_array = array();
        parse_str($response, $response_array);

        return $response_array;
    }

    /**
     * Make SetExpressCheckout request (redirects to paypal for user to log in and accept payment)
     *
     * @param string $request_params request params (RETURNURL, CANCELURL)
     * @param array $order_params order params (PAYMENTREQUEST_0_AMT, PAYMENTREQUEST_0_SHIPPINGAMT, PAYMENTREQUEST_0_CURRENCYCODE, PAYMENTREQUEST_0_ITEMAMT)
     * @param array $items_params item parms (L_PAYMENTREQUEST_0_NAME_0, L_PAYMENTREQUEST_0_DESC_0, L_PAYMENTREQUEST_0_AMT_0, L_PAYMENTREQUEST_0_QTY_0)
     *
     * @return boolean false on failure
     */
    public static function set_express_checkout($request_params = array(), $order_params = array(), $items_params = array()) {
        $response = self::request('SetExpressCheckout', $request_params + $order_params + $items_params);

        // if request is not successful
        if ((is_array($response) == false) || ($response['ACK'] != 'Success')) {
            $i = 0;
            while (isset($response['L_SHORTMESSAGE' . $i])) {
                self::$errors[] = $response['L_SHORTMESSAGE' . $i] . ': ' . $response['L_LONGMESSAGE' . $i];
                $i++;
            }
            return false;
        }

        $token = $response['TOKEN'];
        $location = self::$is_production == true ? 'http://www.paypal.com/webscr' : 'http://www.sandbox.paypal.com/webscr';
        header('Location: ' . $location . '?cmd=_express-checkout&token=' . urlencode($token));
    }

    /**
     * Make GetExpressCheckoutDetails request (get detail after payer accept payment)
     *
     * @param string $params params (TOKEN)
     *
     * @return array response details
     */
    public static function get_express_checkout_details($params) {
        $response = self::request('GetExpressCheckoutDetails', $params);
        return $response;
    }

    /**
     * Make DoExpressCheckoutPayment request (do checkout based on params from paypal)
     *
     * @param string $request_params request params (RETURNURL, CANCELURL)
     *
     * @return array response details / boolean false on failure
     */
    public static function do_express_checkout_payment($params) {
        $response = self::request('DoExpressCheckoutPayment', $params);
        return $response;
    }

    /**
     * checks is payment notification valid and returns it
     *
     * @return array ipn data / boolean false if notification is invalid
     */
    public static function validate_ipn() {
        $paypal_action = self::$is_production == true ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';

        $ipn_data = array();
        foreach ($_POST as $key => $value) {
            $ipn_data[$key] = $value;
        }

        $request_data = array('cmd' => '_notify-validate') + $ipn_data;
        $request = http_build_query($request_data);

        $curl_handle = curl_init();
        curl_setopt_array($curl_handle, array(CURLOPT_URL => $paypal_action, CURLOPT_HEADER => 0, CURLOPT_POST => 1, CURLOPT_POSTFIELDS => $request, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYHOST => 2));
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);

        if ($response != 'VERIFIED') {
            return false;
        }

        return $ipn_data;
    }

    /**
     * get errors
     *
     * @return array array of error msgs
     */
    public static function get_errors() {
        return self::$errors;
    }
	

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
	

}
