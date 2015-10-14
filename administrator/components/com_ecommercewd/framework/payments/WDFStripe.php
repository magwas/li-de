<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFStripe {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Editable field types
     * 
     */
	 
	public static $field_types = array('mode'                 => array('type'=>'radio','options'=>array('TEST','LIVE'),'text'=>'CHECKOUT_MODE','attributes'=>'onclick="onBtnClickShowField(this,event);"'),
									   'test_secret_key'      => array('type'=>'text','text'=>'TEST_SECRET_KEY','attributes'=>'class="test"'),
									   'live_secret_key'      => array('type'=>'text','text'=>'LIVE_SECRET_KEY','attributes'=>'class="live"'),								   
									   'test_publishable_key' => array('type'=>'text','text'=>'TEST_PULISHABLE_KEY','attributes'=>'class="test"'),
									   'live_publishable_key' => array('type'=>'text','text'=>'LIVE_PULISHABLE_KEY','attributes'=>'class="live"'));
									   
    /**
     * CC fields
     * @var array with field names
    */
	public static $cc_fields  = array('NAME' =>0,'CARD_NUMBER'=>1, 'CVC'=>1, 'EXPIRATION_MONTH'=>1, 'EXPIRATION_YEAR'=>1,'ADDRESS_LINE_1' =>0,'ADDRESS_LINE_2' =>0,'CITY' =>0,'STATE' =>0,'ADDRESS_COUNTRY' =>0, 'ZIP_CODE' =>0,'COUNTRY' =>0 );
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////

    /**
     * production or sandbox(testing)
     * @var boolean
     */
    private static $is_production = false;

    /**
     * default API Credentials
     * @var array
     */
    private static $credentials = array('TEST_PULISHABLE_KEY' => '', 'LIVE_PULISHABLE_KEY' => '', 'TEST_SECRET_KEY' => '','LIVE_SECRET_KEY' => '');

    /**
     * error message(s)
     * @var array
     */
    private static $errors = array();

    /**
     * response object
     * @var  object
     */
    private static $response = '';
	
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
     * set stripe seller credentials
     *
     * @param array $credentials seller credentials (USER, PWD, SIGNATURE)
     */
    public static function set_credentials($credentials = array()) {
        self::$credentials = $credentials;
    }

    /**
     * set stripe checkout
     *
     * @param array $data seller data (stripetoken, amount, customer_id, currency)
    */
	public static function stripe_checkout($data = array()){
		require_once JPATH_ADMINISTRATOR. '/components/com_ecommercewd/libraries/stripe/Stripe.php';
		$token = $data['token'];		
		$amount = $data['amount'];
		$customer_id = $data['customer_id'];
		$currency = $data['currency'];

		$credentials = self::$credentials;

		$secret_key =  self::$is_production == false ? $credentials['TEST_SECRET_KEY'] : $credentials['LIVE_SECRET_KEY'];
		Stripe::setApiKey($secret_key);
		
		if( $customer_id ){	
			try{
				// retrive existing customer
				$customer = Stripe_Customer::retrieve($customer_id);		
				$customer->default_card = WDFInput::get('cards');			
				$customer->save();
				$charge = Stripe_Charge::create(array(
						'amount' => $amount*100, 
						'currency' => $currency,
						'customer' => $customer_id
					)
				);
				if ($charge->paid == false)
				self::$errors[] = $charge->failure_message;

				self::$response = $charge;
			}
			
			catch (Exception $e) {
			
				$body = $e->getJsonBody();
				$err = $body['error'];		
				self::$errors[] = $err['message'];
			}

		}
		else {	
			try{
				// create customer
				$customer = Stripe_Customer::create(array(
						'card' => $token,
						'description' => ''
					)
				);
				// create charge object
				$charge = Stripe_Charge::create(array(
						'amount' => $amount*100, // amount in cents
						'currency' => $currency,
						"customer" => $customer->id
					)
				);
				if ($charge->paid == false)
				self::$errors[] = $charge->failure_message;
				self::$response = $charge;
			}
			
			catch (Exception $e) {
			
				$body = $e->getJsonBody();
				$err = $body['error'];		
				self::$errors[] = $err['message'];
		
			}
		}

	}
	
	/**
     * add credit card 
     *
     * @param array $data seller data (stripetoken, amount, customer_id)
    */
	public static function stripe_add_credit_card_and_checkout($data = array()){
		require_once JPATH_ADMINISTRATOR. '/components/com_ecommercewd/libraries/stripe/Stripe.php';
		$token = $data['token'];		
		$amount = $data['amount'];
		$customer_id = $data['customer_id'];
		$currency = $data['currency'];
		
		$credentials = self::$credentials;

		$secret_key =  self::$is_production == false ? $credentials['TEST_SECRET_KEY'] : $credentials['LIVE_SECRET_KEY'];
		Stripe::setApiKey($secret_key);
		try {
			$customer = Stripe_Customer::retrieve($customer_id);
			$new_card = $customer->cards->create(array("card" => $token));
			$customer->default_card = $new_card->id;
			$customer->save();
			$charge = Stripe_Charge::create(array(
				'amount' => $amount*100, 
				'currency' => $currency,
				'customer' => $customer_id
				));
				
			if ($charge->paid == false)
				self::$errors[] = $charge->failure_message;

			self::$response = $charge;	
		}
		catch (Exception $e) {
			$body = $e->getJsonBody();
			$err = $body['error'];				
			self::$errors[] = $err['message'];
		}
			
	}
	
    /**
     * get response
     *
     * @return json encoded of request response
    */	

	public static function get_response(){	
		$response_obj = self::$response;

		$response_array = array();
		$response_array['charge_id'] = $response_obj->id;
		$response_array['refunded'] = $response_obj->refunded;
		$response_array['customer'] = $response_obj->card->customer;
		$response_array['cardlast4'] = $response_obj->card->last4;
		$response_array['cardbrand'] = $response_obj->card->brand;
		$response_array['cardfunding'] = $response_obj->card->funding;
		$response_array['cardexp_month'] = $response_obj->card->exp_month;
		$response_array['cardexp_year'] = $response_obj->card->exp_year;
		$response_array['cardcountry'] = $response_obj->card->country;
		$response_array['cardname'] = $response_obj->card->name;
		$response_array['invoice'] = $response_obj->invoice;
		$response_array['description'] = $response_obj->description;
		
		return WDFJson::encode($response_array);

	}
	
	/**
     * get credit cards
     * @param customer_id string
     * @return array of credit cards
    */
	
	public static function get_credit_cards($customer_id){
		if($customer_id){
			require_once JPATH_ADMINISTRATOR. '/components/com_ecommercewd/libraries/stripe/Stripe.php';
			$credentials = self::$credentials;
			$secret_key =  self::$is_production == false ? $credentials['TEST_SECRET_KEY'] : $credentials['LIVE_SECRET_KEY'];
			Stripe::setApiKey($secret_key);
			$customer = Stripe_Customer::retrieve($customer_id);
			$cards = $customer->cards;
			$data = $cards->data;
			$cards_data = array();
			for($i=0; $i<count($data);$i++){
				$cards_data[$data[$i]->id] = '**** **** **** ' . $data[$i]->last4. ' ('.$data[$i]->brand.')';
			}
			
			return $cards_data;
		}
		
		return false;
	
	}
	
	/**
     * delete credit cards
     * @param customer_id string
     * @return array of credit cards
    */
	
	public static function delete_credit_cards($customer_id, $card_id){
		if($customer_id){
			require_once JPATH_ADMINISTRATOR. '/components/com_ecommercewd/libraries/stripe/Stripe.php';
			$credentials = self::$credentials;
			$secret_key =  self::$is_production == false ? $credentials['TEST_SECRET_KEY'] : $credentials['LIVE_SECRET_KEY'];
			Stripe::setApiKey($secret_key);
			$customer = Stripe_Customer::retrieve($customer_id);
			$customer->cards->retrieve($card_id)->delete();			
		}
		
		return false;
	
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
