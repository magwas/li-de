<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFChecoutHelper {
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
	
   	public static function check_can_checkout() {
        $app = JFactory::getApplication();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        // check if checkout is enabled
        if ($options->checkout_enable_checkout == 0) {
            WDFHelper::redirect('products', 'displayproducts');
        }

        // if not registered users can't checkout and user is not logged in goto login page
        if (($options->checkout_allow_guest_checkout == 0) && (WDFHelper::is_user_logged_in() == false)) {
            $app->enqueueMessage(WDFText::get('MSG_LOG_IN_FIRST'), 'message');
            WDFHelper::redirect('usermanagement', 'displaylogin');
        }
    }

    public static function check_checkout_data() {
        $model = WDFHelper::get_model('checkout');
        $checkout_data = $model->get_checkout_data();

        if (($checkout_data == null) || (empty($checkout_data['products_data']) == true)) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=1');
        }
    }	
    public static function send_checkout_finished_mail($row_order) {
        $app = JFactory::getApplication();

        $joomla_config = JFactory::getConfig();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        // get admin email
        $admin_email = $options->registration_administrator_email;

        // get user name
        $name_parts = array();
        if ($row_order->shipping_data_first_name != '') {
            $name_parts[] = $row_order->billing_data_first_name;
        }
        if ($row_order->shipping_data_middle_name != '') {
            $name_parts[] = $row_order->billing_data_middle_name;
        }
        if ($row_order->shipping_data_last_name != '') {
            $name_parts[] = $row_order->billing_data_last_name;
        }

        // get user email
        $mailto = $row_order->billing_data_email;
        if (JMailHelper::isEmailAddress($mailto) == false) {
            $j_user = JFactory::getUser($row_order->j_user_id);
            $mailto = $j_user->email;
            if (JMailHelper::isEmailAddress($mailto) == false) {
                $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SEND_CHECKOUT_FINISHED_MAIL'), 'error');
                return false;
            }
        }

        // get order details
        $product_details = array();
        foreach ($row_order->product_rows as $product) {
            $product_details[] = '<strong>' . $product->name . '</strong>' . ' (' . $product->price_text . ' + ' . WDFText::get('TAX') . ': ' . $product->tax_price_text . ' + ' . WDFText::get('SHIPPING') . ': ' . $product->shipping_method_price_text . ')' . ' x' . $product->count . ' = <strong>' . $product->subtotal_text . '</strong>';
        }

        $checkout_date = date($options->option_date_format, strtotime($row_order->checkout_date));

        // mail data
        $mail_data = array();
        $mail_data['name'] = implode(' ', $name_parts);
        $mail_data['mailfrom'] = JMailHelper::isEmailAddress($admin_email) == true ? $admin_email : $joomla_config->get('mailfrom');
        $mail_data['mailto'] = $mailto;
        $mail_data['sitename'] = $joomla_config->get('sitename');
        $mail_data['siteurl'] = JUri::root();
		$mail_data['order_details'] =  JURI::base().substr(JRoute::_("index.php?option=com_".WDFHelper::get_com_name()."&controller=orders&task=displayorder&order_id=".$row_order->id), strlen(JURI::base(true)) + 1);
		
		if(WDFHelper::is_user_logged_in() == true ){
			$body =	 WDFText::get('EMAIL_CHECKOUT_FINISHED_BODY_FOR_REGISTERED_USERS', $mail_data['name'], $checkout_date, $mail_data['sitename'], $mail_data['siteurl'], $row_order->id, $mail_data['order_details'], implode('<br>', $product_details), $row_order->total_price_text);
		} else{
			$body =	 WDFText::get('EMAIL_CHECKOUT_FINISHED_BODY_FOR_GUEST_CHECKOUT', $mail_data['name'], $checkout_date, $mail_data['sitename'], $mail_data['siteurl'], $row_order->id, implode('<br>', $product_details), $row_order->total_price_text);
		}
		
        $mail_data['subject'] = WDFText::get('EMAIL_CHECKOUT_FINISHED_DETAILS', $row_order->id, $mail_data['sitename']);
		
       	$body_shipping_data = '<br><br><strong>'.WDFText::get('SHIPPING_DATA').'</strong><br>'.
							  WDFText::get('FIRST_NAME').': '.$row_order->shipping_data_first_name.'<br>'.
							  WDFText::get('LAST_NAME').': '.$row_order->shipping_data_last_name.'<br>'.
							  WDFText::get('COMPANY').': '.$row_order->shipping_data_company.'<br>'.
							  WDFText::get('ADDRESS').': '.$row_order->shipping_data_address.'<br>'.
							  WDFText::get('CITY').': '.$row_order->shipping_data_city.'<br>'.
							  WDFText::get('STATE').': '.$row_order->shipping_data_state.'<br>'.
							  WDFText::get('ZIP_CODE').': '.$row_order->shipping_data_zip_code.'<br>'.
							  WDFText::get('COUNTRY').': '.$row_order->shipping_data_country;
							  
		$body_billing_data = '<br><br><strong>'.WDFText::get('BILLING_DATA').'</strong><br>'.
							  WDFText::get('FIRST_NAME').': '.$row_order->billing_data_first_name.'<br>'.
							  WDFText::get('LAST_NAME').': '.$row_order->billing_data_last_name.'<br>'.
							  WDFText::get('COMPANY').': '.$row_order->billing_data_company.'<br>'.
							  WDFText::get('ADDRESS').': '.$row_order->billing_data_address.'<br>'.
							  WDFText::get('CITY').': '.$row_order->billing_data_city.'<br>'.
							  WDFText::get('STATE').': '.$row_order->billing_data_state.'<br>'.
							  WDFText::get('ZIP_CODE').': '.$row_order->billing_data_zip_code.'<br>'.
							  WDFText::get('COUNTRY').': '.$row_order->billing_data_country.'<br>'.					  
							  WDFText::get('PHONE').': '.$row_order->billing_data_phone.'<br>'.					  
							  WDFText::get('FAX').': '.$row_order->billing_data_fax.'<br>'.					  
							  WDFText::get('EMAIL').': '.$row_order->billing_data_email;	
	   
		$mail_data['body'] = $body.$body_billing_data.$body_shipping_data;

        //send mail to user
		$where_query = array( " published ='1' AND name='ecommercewd_pdfinvoice'" );
		$tools = WDFTool::get_tools( $where_query );

		$attachment_customer = false;
		$attachment_admins = false;
		if(empty($tools) == false){
			$model_pdfinvoice = WDFHelper::get_model('pdfinvoice');
			$pdfoptions = $model_pdfinvoice->get_invoice_options();	
			$attachments = explode(',',$pdfoptions ['attach_to']);
			$model_order = WDFHelper::get_model('orders');
			WDFInput::set('order_id',$row_order->id);
			$invoice_order_row =  $model_order->get_print_order();
			if( in_array('customer_order_email',$attachments)){				
				$attachment_customer = EcommercewdOrder::get_pdf_invoice($invoice_order_row, $pdfoptions, true);	
			}
			if( in_array('admin_order_email',$attachments)){			
				$attachment_admins = EcommercewdOrder::get_pdf_invoice($invoice_order_row, $pdfoptions, true);
			}
				
		}	
		
		$is_mail_to_user_sent = WDFMail::send_mail($mail_data['mailfrom'], $mail_data['mailto'], $mail_data['subject'], $mail_data['body'], true, $attachment_customer);

		//send mail to admins
        $mail_data['body_admin'] = WDFText::get('EMAIL_CHECKOUT_FINISHED_TO_ADMIN_BODY', $mail_data['name'], $checkout_date, $mail_data['sitename'], $mail_data['siteurl'], $row_order->id, implode('<br>', $product_details), $row_order->total_price_text, $is_mail_to_user_sent == true ? WDFText::get('YES') : WDFText::get('NO'));

        $query->clear();
        $query->select('name');
        $query->select('email');
        $query->select('sendEmail');
        $query->from('#__users');
        $query->where('sendEmail = 1');
        $db->setQuery($query);
        $admin_rows = $db->loadObjectList();

        foreach ($admin_rows as $admin_row) {
			 WDFMail::send_mail($joomla_config->get('mailfrom'), $admin_row->email, $mail_data['subject'], $mail_data['body_admin'], true, $attachment_admins);
        }
		
		if ($is_mail_to_user_sent == true) {
            $app->enqueueMessage(WDFText::get('MSG_CHECKOUT_FINISHED_MAIL_SENT'), 'message');
        } else {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SEND_CHECKOUT_FINISHED_MAIL'), 'warning');
        }

	}	
   	public static function get_country_name($country_id) {
   		$row_country = WDFDb::get_row('countries', 'id = ' .$country_id);
		return $row_country->name;
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
