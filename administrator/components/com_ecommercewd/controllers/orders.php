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
    public function remove() {
        $this->remove_order_products(WDFInput::get_checked_ids());

        parent::remove();
    }

    public function view() {
        $db = JFactory::getDbo();
        WDFDb::set_checked_row_data('', $db->quoteName('read'), 1);

        parent::view();
    }

    public function set_as_read() {
        $db = JFactory::getDbo();

        WDFDb::set_checked_rows_data('', $db->quoteName('read'), 1);
        WDFHelper::redirect();
    }

    public function set_as_unread() {
        $db = JFactory::getDbo();

        WDFDb::set_checked_rows_data('', $db->quoteName('read'), 0);
        WDFHelper::redirect();
    }

    public function edit() {
        $db = JFactory::getDbo();

        WDFDb::set_checked_row_data('', $db->quoteName('read'), 1);
        parent::display();
    }

    public function update_order_status() {
        $app = JFactory::getApplication();

        $checked_id = WDFInput::get_checked_id();
        $row_order = WDFDb::get_row_by_id('orders', $checked_id);

        // get status data
        $row_status = WDFDb::get_row_by_id('orderstatuses', WDFInput::get('order_status_' . $row_order->id));

        if (($row_order->id != null) && ($row_status->id != null)) {
            $old_status_id = $row_order->status_id;
            $old_status_name = $row_order->status_name;
            $new_status_id = $row_status->id;
            $new_status_name = $row_status->name;
            if ($old_status_id != $new_status_id) {
                $row_order->status_id = $row_status->id;
                $row_order->status_name = $row_status->name;
                $row_order->date_modified = date("Y-m-d H:i:s");
                if ($row_order->store() == true) {
                    $app->enqueueMessage(WDFText::get('MSG_STATUS_UPDATED'), 'message');
                    $this->send_status_changed_mail($row_order, $old_status_name, $new_status_name);
                } else {
                    $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_UPDATE_STATUS'), 'error');
                }
            } else {
                $app->enqueueMessage(WDFText::get('MSG_STATUS_HASNT_CHENGED'), 'warning');
            }
        } else {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_UPDATE_STATUS'), 'error');
        }

        $redirect_task = WDFInput::get('redirect_task', '');
        switch ($redirect_task) {
            case 'view':
                $cids = $row_order->id;
                break;
            default:
                $cids = '';
                break;
        }

        WDFHelper::redirect('', $redirect_task, $cids);
    }
	
	public function pdfinvoicebulk(){
		$model = WDFHelper::get_model('orders');		
		$ids = WDFInput::get_checked_ids();		
		$id =  reset($ids);	
		$pdfinvoice_model = WDFHelper::get_model('pdfinvoice');
		$options = $pdfinvoice_model->get_invoice_options();
		$row = $model->get_row($id);
	
		EcommercewdOrder::get_pdf_invoice($row,$options);
	}
	
	public function pdfinvoice(){
		$model = WDFHelper::get_model('orders');		
		$id = (WDFInput::get('boxchecked')) ? WDFInput::get('boxchecked') : WDFInput::get('id');
		$pdfinvoice_model = WDFHelper::get_model('pdfinvoice');
		$options = $pdfinvoice_model->get_invoice_options();
		$row = $model->get_row($id);
	
		EcommercewdOrder::get_pdf_invoice($row,$options);
	}	

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function remove_order_products($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    protected function store_input_in_row() {
        $app = JFactory::getApplication();

        // fill additional input data
        // status name
        $row_status = WDFDb::get_row_by_id('orderstatuses', WDFInput::get('status_id'));
        WDFInput::set('status_name', $row_status->name != null ? $row_status->name : '');

        // date modified
        WDFInput::set('date_modified', date("Y-m-d H:i:s"));


        $row = WDFDb::get_row_by_id('orders', WDFInput::get('id'));
        $row_new_order_status = WDFDb::get_row_by_id('orderstatuses',WDFInput::get('status_id'));

        $old_status_id = $row->status_id;
        $old_status_name = $row->status_name;
        $new_status_id = $row_new_order_status->id;
        $new_status_name = $row_new_order_status->name;

        $row = parent::store_input_in_row();

        if ($row != false) {
            if ($old_status_id != $new_status_id) {
                $this->send_status_changed_mail($row, $old_status_name, $new_status_name);
            }
        } else {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SAVE_CHANGES'), 'error');
            WDFHelper::redirect();
        }

        return $row;
    }

    private function send_status_changed_mail($row_order, $old_status_name, $new_status_name) {
        $app = JFactory::getApplication();

        $joomla_config = JFactory::getConfig();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options_row();

        // add order products and total data
        $model_orders = WDFHelper::get_model('orders');
        $row_order = $model_orders->add_order_products_details_for_email($row_order);

        // get admin email
        $admin_email = $options->registration_administrator_email;

        // get user email
        $mailto = $row_order->billing_data_email;
        if (JMailHelper::isEmailAddress($mailto) == false) {
            $j_user = JFactory::getUser($row_order->j_user_id);
            $mailto = $j_user->email;
            if (JMailHelper::isEmailAddress($mailto) == false) {
                $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SEND_ORDER_STATUS_UPDATE_MAIL'), 'error');
                return false;
            }
        }

        // get user name
        $name_parts = array();
        if ($row_order->billing_data_first_name != '') {
            $name_parts[] = $row_order->billing_data_first_name;
        }
        if ($row_order->billing_data_middle_name != '') {
            $name_parts[] = $row_order->billing_data_middle_name;
        }
        if ($row_order->billing_data_last_name != '') {
            $name_parts[] = $row_order->billing_data_last_name;
        }

        $checkout_date = date($options->option_date_format, strtotime($row_order->checkout_date));

        // mail data
        $mail_data = array();
        $mail_data['name'] = implode(' ', $name_parts);
        $mail_data['mailfrom'] = JMailHelper::isEmailAddress($admin_email) == true ? $admin_email : $joomla_config->get('mailfrom');
        $mail_data['mailto'] = $mailto;
        $mail_data['sitename'] = $joomla_config->get('sitename');
        $mail_data['siteurl'] = JUri::root();

        $mail_data['subject'] = WDFText::get('EMAIL_ORDER_STATUS_CHANGED_SUBJECT', $checkout_date, $mail_data['sitename']);
        $mail_data['body'] = WDFText::get('EMAIL_ORDER_STATUS_CHANGED_BODY', $mail_data['name'], $checkout_date, $mail_data['sitename'], $mail_data['siteurl'], $old_status_name, $new_status_name, $row_order->id, $row_order->products_details, $row_order->total_price_text);


        //send mail to user
        $is_mail_to_user_sent = WDFMail::send_mail($mail_data['mailfrom'], $mail_data['mailto'], $mail_data['subject'], $mail_data['body'], true);
        if ($is_mail_to_user_sent == false) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SEND_ORDER_STATUS_UPDATE_MAIL'), 'warning');
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}