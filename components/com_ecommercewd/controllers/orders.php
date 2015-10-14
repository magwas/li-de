<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerOrders extends EcommercewdController {
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
    public function displayorder() {
        $this->check_user_privileges();
	
        parent::display();
    }

    public function displayorders() {
        $this->check_user_privileges();
        parent::display();
    }

	public function printorder(){
        $this->check_user_privileges();
        parent::display();	
	}

	public function pdfinvoice(){
		$model = WDFHelper::get_model();
		$order_row = $model->get_print_order();
	
		$pdfinvoice_model = WDFHelper::get_model('pdfinvoice');
		$options = $pdfinvoice_model->get_invoice_options();
		
		EcommercewdOrder::get_pdf_invoice($order_row,$options);
	}
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function check_user_privileges() {
        $app = JFactory::getApplication();

        // if not registered users can't checkout and user is not logged in goto login page
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        if (($options->checkout_allow_guest_checkout == 0) && (WDFHelper::is_user_logged_in() == false)) {
            $app->enqueueMessage(WDFText::get('MSG_LOG_IN_FIRST'), 'message');
            if(WDFInput::get('type')){
                WDFHelper::redirect('usermanagement', 'displaylogin', '&tmpl=component');
            }
            else
            WDFHelper::redirect('usermanagement', 'displaylogin');
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}