<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFAuthorizenet {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
	const LIVE_URL = 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';
	
    /**
     * Editable field types 
     */	 
	public static $field_types = array(//'mode'                         => array('type'=>'radio','options'=>array('TEST','LIVE'),'text'=>'CHECKOUT_MODE','attributes'=>''),
									   'request'                           => array('type'=>'radio','options'=>array('SANDBOX','PRODUCTION'),'text'=>'CHECKOUT_REQUEST','attributes'=>'onclick="onBtnClickShowField(this,event);"'),									   	
									   'authorizenet_test_login_id'        => array('type'=>'text','text'=>'TEST_API_LOGIN_ID','attributes'=>'class="test"'),
									   'authorizenet_test_transaction_key' => array('type'=>'text','text'=>'TEST_TRANSACTION_KEY','attributes'=>'class="test"'),
									   'authorizenet_live_login_id'        => array('type'=>'text','text'=>'LIVE_API_LOGIN_ID','attributes'=>'class="live"'),
									   'authorizenet_live_transaction_key' => array('type'=>'text','text'=>'LIVE_TRANSACTION_KEY','attributes'=>'class="live"')									   
									   );
									   //'authorizenet_md5'             => array('type'=>'text','text'=>'MD5_HASH','attributes'=>'')
    /**
     * CC fields
     * @var array with field names
    */
	public static $cc_fields  = array('CARD_NUMBER' =>1 , 'EXPIRATION_MM_YY'=> 1, 'CVC' =>0 );								  
									  
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////

    /**
     * production or testing
     * @var boolean
     */
    private static $is_production = false;

    /**
     * default API Credentials
     * @var array
     */
    //private static $credentials = array('AUTHORIZENET_API_LOGIN_ID' => '', 'AUTHORIZENET_TRANSACTION_KEY' => '', 'AUTHORIZENET_MD5_SETTING' => '');
    private static $credentials = array('AUTHORIZENET_TEST_API_LOGIN_ID' => '', 'AUTHORIZENET_TEST_TRANSACTION_KEY' => '','AUTHORIZENET_LIVE_API_LOGIN_ID' => '', 'AUTHORIZENET_LIVE_TRANSACTION_KEY' => '');

	/**
     * test request
     * @var boolean
     */
    private static $request = false;	
	
    /**
     * error message(s)
     * @var array
     */
    private static $errors = array();

    /**
     * response object
     * @var object
     */
    private static $response = '';
		
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////

    /**
     * set transaktion server mode. live if true, test if false
     *
     * @param var boolean
     */
    public static function set_request_mode($request) {
        self::$request = $request;
    }	

    /**
     * set authorizenet seller credentials
     *
     * @param array $credentials seller credentials (AUTHORIZENET_API_LOGIN_ID, AUTHORIZENET_TRANSACTION_KEY, AUTHORIZENET_MD5_SETTING)
     */
    public static function set_credentials($credentials = array()) {
        self::$credentials = $credentials;
    }
		
    /**
     * Make AIM Checkout 	 
     *
	 * @params $details array 
    */
    public static function aim_checkout($details = array()) {
		require_once JPATH_ADMINISTRATOR. '/components/com_ecommercewd/libraries/authorizenetaim/AuthorizeNet.php';
		$credentials = self::$credentials;
		$api_login_id = (self::$request == 0) ? $credentials['AUTHORIZENET_TEST_API_LOGIN_ID'] :  $credentials['AUTHORIZENET_LIVE_API_LOGIN_ID'];
		$transaction_key = (self::$request == 0) ? $credentials['AUTHORIZENET_TEST_TRANSACTION_KEY'] :  $credentials['AUTHORIZENET_LIVE_TRANSACTION_KEY'];
	
		$mode =  self::$request == 0 ? true : false;
		$transaction = new AuthorizeNetAIM ($api_login_id, $transaction_key );
		$transaction->setSandbox($mode);
		$transaction->setFields($details);

		$response = $transaction->authorizeAndCapture();
		
		if (!$response->approved){
			self::$errors[] = $response->response_reason_text;
		}	

		self::$response = $response;		
    }
	 /**
     * Make SIM/DPM Checkout 	 
     *
	 * @params $details array 
     */
	 	 
	 public static function dpm_sim_checkout($details = array()) {	
		$response = $_POST;		
		if(count($response)){
			$response_code = $_POST['x_response_code'];	
			if ($response_code != 1 )
				self::$errors[] = $response['x_response_reason_text'];			
			self::$response = $response;
		}
		else 
			self::$response = array();  
	}
		
    /**
     * get response
     *
     * @return json encoded of request response
    */	

	public static function get_response(){
		return WDFJson::encode(self::$response);
	}
	
    /**
     * get errors
     *
     * @return array  of error msgs
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
