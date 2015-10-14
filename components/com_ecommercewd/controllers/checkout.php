<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerCheckout extends EcommercewdController {
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
    public function checkout_product() {
        WDFChecoutHelper::check_can_checkout();

        $model = WDFHelper::get_model('checkout');
        $session_id = $model->init_checkout();
        WDFHelper::redirect('', 'displayshippingdata', '', 'session_id=' . $session_id);
    }

    public function checkout_all_products() {
        WDFChecoutHelper::check_can_checkout();

        $model = WDFHelper::get_model('checkout');
        $session_id = $model->init_checkout();
        WDFHelper::redirect('', 'displayshippingdata', '', 'session_id=' . $session_id);
    }

    public function quick_checkout() {
        WDFChecoutHelper::check_can_checkout();

        $model = WDFHelper::get_model('checkout');
        $session_id = $model->init_checkout();
        WDFHelper::redirect('', 'displayshippingdata', '', 'session_id=' . $session_id);
    }

    public function displayshippingdata() {
        WDFChecoutHelper::check_can_checkout();
        WDFChecoutHelper::check_checkout_data();
        parent::display();
    }

    public function displayproductsdata() {
        WDFChecoutHelper::check_can_checkout();
        WDFChecoutHelper::check_checkout_data();
        parent::display();
    }

    public function displaylicensepages() {
        WDFChecoutHelper::check_can_checkout();
        WDFChecoutHelper::check_checkout_data();
        parent::display();
    }

    public function displayconfirmorder() {
        WDFChecoutHelper::check_can_checkout();
        WDFChecoutHelper::check_checkout_data();
        parent::display();
    }
	
	   
	public function displaycheckoutfinishedsuccess() {
        WDFChecoutHelper::check_can_checkout();
        parent::display();
    }

    public function displaycheckoutfinishedfailure() {
        WDFChecoutHelper::check_can_checkout();
        parent::display();
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