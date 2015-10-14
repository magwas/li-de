<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewCheckout extends EcommercewdView {
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
    public function display($tpl = null) {
        $model = $this->getModel();
        $options_model = WDFHelper::get_model('options');

        $this->options = $options_model->get_options();
        $this->checkout_data = $model->get_checkout_data();

        $task = WDFInput::get_task();
        switch ($task) {
            case 'displayshippingdata':
                $this->_layout = 'displayshippingdata';
                $this->pager_data = $model->get_pager_data();
                $this->shipping_form_fields = $model->get_shipping_data_form_fields();
                $this->billing_form_fields = $model->get_billing_data_form_fields();
                break;
            case 'displayproductsdata':
                $this->_layout = 'displayproductsdata';
                $this->products_data = $model->get_products_page_products_data();
                $this->pager_data = $model->get_pager_data();
                break;
            case 'displaylicensepages':
                $this->_layout = 'displaylicensepages';
                $this->pager_data = $model->get_pager_data();
                $pages = $model->get_license_pages();
                if ($pages === false) {
                    WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $this->checkout_data['session_id']);
                }
                $this->pages = $pages;
                break;
			
            case 'displayconfirmorder':
                $this->_layout = 'displayconfirmorder';
                $this->pager_data = $model->get_pager_data();
                if ($model->is_final_checkout_data_valid(false) === false) {
                    WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $this->checkout_data['session_id']);
                }				
                $final_checkout_data = $model->get_final_checkout_data(1);
                if ($final_checkout_data === false) {
                    WDFHelper::redirect('checkout', 'displaycheckoutfinishedfailure', '', 'session_id=' . $this->checkout_data['session_id']);
                }				
                $this->final_checkout_data = $final_checkout_data;
                $this->payment_buttons_data = $model->get_payment_buttons_data($final_checkout_data['total_price']);
                break;								
            case 'displaycheckoutfinishedsuccess':
                $this->_layout = 'displaycheckoutfinishedsuccess';
                break;
            case 'displaycheckoutfinishedfailure':
                $this->_layout = 'displaycheckoutfinishedfailure';
                break;
            default:
                break;
        }

        parent::display($tpl);
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