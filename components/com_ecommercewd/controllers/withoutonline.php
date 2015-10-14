<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerWithoutonline extends EcommercewdController {
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
        if ($model->is_final_checkout_data_valid(false) == false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=0');
        }
	
       $final_checkout_data = $model->get_final_checkout_data();
	  
        if ($final_checkout_data === false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=0');
        }

        $this->finish_checkout_without_online_payment($final_checkout_data);
			
        
    }
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
  
    private function finish_checkout_without_online_payment($final_checkout_data) {
        $model = WDFHelper::get_model('checkout');
        $final_checkout_data = $model->store_checkout_data(); 
        if ($final_checkout_data === false) {
            WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id');
        }

        $model_orders = WDFHelper::get_model('orders');

        $order_id = $final_checkout_data['order_id'];
        $row_order = WDFDb::get_row_by_id('orders', $order_id);
        $row_order = $model_orders->add_order_products_data($row_order, true);
		
        WDFChecoutHelper::send_checkout_finished_mail($row_order);

        WDFHelper::redirect('checkout', 'displaycheckoutfinishedsuccess', '', 'session_id=' . $final_checkout_data['session_id']);
    }
	

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}