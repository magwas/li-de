<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelUsermanagement extends EcommercewdModel {
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
    public function get_registration_data() {
        $registration_data = array();

        $registration_data['username'] = WDFInput::get('username', '');
        $registration_data['email'] = WDFInput::get('email', '');
        $registration_data['first_name'] = WDFInput::get('first_name', '');
        $registration_data['middle_name'] = WDFInput::get('middle_name', '');
        $registration_data['last_name'] = WDFInput::get('last_name', '');
        $registration_data['company'] = WDFInput::get('company', '');
        $registration_data['country_id'] = WDFInput::get('country_id', 0, 'int');
        $registration_data['state'] = WDFInput::get('state', '');
        $registration_data['city'] = WDFInput::get('city', '');
        $registration_data['address'] = WDFInput::get('address', '');
        $registration_data['mobile'] = WDFInput::get('mobile', '');
        $registration_data['phone'] = WDFInput::get('phone', '');
        $registration_data['fax'] = WDFInput::get('fax', '');
        $registration_data['zip_code'] = WDFInput::get('zip_code', '');

        return $registration_data;
    }

    public function get_user_data() {
        // if user entered wrong data, return user entered data, else return data from db
        $has_errors = WDFInput::get('invalid_fields', '') == '' ? false : true;
		$j_user = JFactory::getUser();
        $user_data = array();
        if ($has_errors == true) {
            $user_data['first_name'] = WDFInput::get('first_name', '');
            $user_data['middle_name'] = WDFInput::get('middle_name', '');
            $user_data['last_name'] = WDFInput::get('last_name', '');
            $user_data['email'] = WDFInput::get('email', '');
            $user_data['company'] = WDFInput::get('company', '');
            $user_data['country_id'] = WDFInput::get('country_id', 0, 'int');
            $user_data['state'] = WDFInput::get('state', '');
            $user_data['city'] = WDFInput::get('city', '');
            $user_data['address'] = WDFInput::get('address', '');
            $user_data['mobile'] = WDFInput::get('mobile', '');
            $user_data['phone'] = WDFInput::get('phone', '');
            $user_data['fax'] = WDFInput::get('fax', '');
            $user_data['zip_code'] = WDFInput::get('zip_code', '');
        } else {            
            $user_row = WDFDb::get_row('users', 'j_user_id = ' . $j_user->id);

            if ($user_row != null) {
                $user_data['first_name'] = WDFInput::get('first_name', $user_row->first_name);
                $user_data['middle_name'] = WDFInput::get('middle_name', $user_row->middle_name);
                $user_data['last_name'] = WDFInput::get('last_name', $user_row->last_name);
				$user_data['email'] = WDFInput::get('email', $j_user->email);
                $user_data['company'] = WDFInput::get('company', $user_row->company);
                $user_data['country_id'] = WDFInput::get('country_id', $user_row->country_id, 'int');
                $user_data['state'] = WDFInput::get('state', $user_row->state);
                $user_data['city'] = WDFInput::get('city', $user_row->city);
                $user_data['address'] = WDFInput::get('address', $user_row->address);
                $user_data['mobile'] = WDFInput::get('mobile', $user_row->mobile);
                $user_data['phone'] = WDFInput::get('phone', $user_row->phone);
                $user_data['fax'] = WDFInput::get('fax', $user_row->fax);
                $user_data['zip_code'] = WDFInput::get('zip_code', $user_row->zip_code);
            } else {
                $user_data['first_name'] = '';
                $user_data['middle_name'] = '';
                $user_data['last_name'] = '';
                $user_data['email'] = '';
                $user_data['company'] = '';
                $user_data['country_id'] = 0;
                $user_data['state'] = '';
                $user_data['city'] = '';
                $user_data['address'] = '';
                $user_data['mobile'] = '';
                $user_data['phone'] = '';
                $user_data['fax'] = '';
                $user_data['zip_code'] = '';
            }
        }

        return $user_data;
    }

    public function get_user_data_form_fields($is_registration = false) {
        $options = WDFHelper::get_model('options')->get_options();

        $invalid_fields = WDFInput::get_array('invalid_fields', ',');

        $form_fields = array();

        if ($is_registration == true) {
            // username
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'username';
            $form_field['label'] = WDFText::get('USERNAME');
            $form_field['placeholder'] = WDFText::get('USERNAME');
            $form_field['required'] = true;
            $form_field['has_error'] = in_array('username', $invalid_fields);
            $form_fields['username'] = $form_field;

            // password
            $form_field = array();
            $form_field['type'] = 'password';
            $form_field['name'] = 'password';
            $form_field['label'] = WDFText::get('PASSWORD');
            $form_field['placeholder'] = WDFText::get('PASSWORD');
            $form_field['required'] = true;
            $form_field['has_error'] = in_array('password', $invalid_fields);
            $form_fields['password'] = $form_field;

            // confirm password
            $form_field = array();
            $form_field['type'] = 'password';
            $form_field['name'] = 'confirm_password';
            $form_field['label'] = WDFText::get('CONFIRM_PASSWORD');
            $form_field['placeholder'] = WDFText::get('CONFIRM_PASSWORD');
            $form_field['required'] = true;
            $form_field['has_error'] = in_array('confirm_password', $invalid_fields);
            $form_fields['confirm_password'] = $form_field;

        }

        // first name
        $form_field = array();
        $form_field['type'] = 'text';
        $form_field['name'] = 'first_name';
        if (($options->user_data_middle_name == 0) && ($options->user_data_last_name == 0)) {
            $form_field['label'] = WDFText::get('NAME');
            $form_field['placeholder'] = WDFText::get('NAME');
        } else {
            $form_field['label'] = WDFText::get('FIRST_NAME');
            $form_field['placeholder'] = WDFText::get('FIRST_NAME');
        }
        $form_field['required'] = true;
        $form_field['has_error'] = in_array('first_name', $invalid_fields);
        $form_fields['first_name'] = $form_field;

        // middle name
        if ($options->user_data_middle_name != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'middle_name';
            $form_field['label'] = WDFText::get('MIDDLE_NAME');
            $form_field['placeholder'] = WDFText::get('MIDDLE_NAME');
            $form_field['required'] = $options->user_data_middle_name == 2 ? true : false;
            $form_field['has_error'] = in_array('middle_name', $invalid_fields);
            $form_fields['middle_name'] = $form_field;
        }

        // last name
        if ($options->user_data_last_name != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'last_name';
            $form_field['label'] = WDFText::get('LAST_NAME');
            $form_field['placeholder'] = WDFText::get('LAST_NAME');
            $form_field['required'] = $options->user_data_last_name == 2 ? true : false;
            $form_field['has_error'] = in_array('last_name', $invalid_fields);
            $form_fields['last_name'] = $form_field;
        }
		
		// email
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'email';
            $form_field['label'] = WDFText::get('EMAIL');
            $form_field['placeholder'] = WDFText::get('EMAIL');
            $form_field['required'] = true;
            $form_field['has_error'] = in_array('email', $invalid_fields);
            $form_fields['email'] = $form_field;

        // company
        if ($options->user_data_company != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'company';
            $form_field['label'] = WDFText::get('COMPANY');
            $form_field['placeholder'] = WDFText::get('COMPANY');
            $form_field['required'] = $options->user_data_company == 2 ? true : false;
            $form_field['has_error'] = in_array('company', $invalid_fields);
            $form_fields['company'] = $form_field;
        }

        // country id
        if ($options->user_data_country != 0) {
            $form_field = array();
            $form_field['type'] = 'select';
            $form_field['name'] = 'country_id';
            $form_field['label'] = WDFText::get('COUNTRY');
            $form_field['required'] = $options->user_data_country == 2 ? true : false;
            $form_field['has_error'] = in_array('country_id', $invalid_fields);
            $form_field['options'] = WDFDb::get_list('countries', 'id', 'name', array(' published = "1" '), 'name ASC', array(array('id' => '', 'name' => WDFText::get('SELECT_COUNTRY'))));
            $form_fields['country_id'] = $form_field;
        }

        // state
        if ($options->user_data_state != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'state';
            $form_field['label'] = WDFText::get('STATE');
            $form_field['placeholder'] = WDFText::get('STATE');
            $form_field['required'] = $options->user_data_state == 2 ? true : false;
            $form_field['has_error'] = in_array('state', $invalid_fields);
            $form_fields['state'] = $form_field;
        }

        // city
        if ($options->user_data_city != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'city';
            $form_field['label'] = WDFText::get('CITY');
            $form_field['placeholder'] = WDFText::get('CITY');
            $form_field['required'] = $options->user_data_city == 2 ? true : false;
            $form_field['has_error'] = in_array('city', $invalid_fields);
            $form_fields['city'] = $form_field;
        }

        // address
        if ($options->user_data_address != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'address';
            $form_field['label'] = WDFText::get('ADDRESS');
            $form_field['placeholder'] = WDFText::get('ADDRESS');
            $form_field['required'] = $options->user_data_address == 2 ? true : false;
            $form_field['has_error'] = in_array('address', $invalid_fields);
            $form_fields['address'] = $form_field;
        }

        // mobile
        if ($options->user_data_mobile != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'mobile';
            $form_field['label'] = WDFText::get('MOBILE');
            $form_field['placeholder'] = WDFText::get('MOBILE');
            $form_field['required'] = $options->user_data_mobile == 2 ? true : false;
            $form_field['has_error'] = in_array('mobile', $invalid_fields);
            $form_fields['mobile'] = $form_field;
        }

        // phone
        if ($options->user_data_phone != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'phone';
            $form_field['label'] = WDFText::get('PHONE');
            $form_field['placeholder'] = WDFText::get('PHONE');
            $form_field['required'] = $options->user_data_phone == 2 ? true : false;
            $form_field['has_error'] = in_array('phone', $invalid_fields);
            $form_fields['phone'] = $form_field;
        }

        // fax
        if ($options->user_data_fax != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'fax';
            $form_field['label'] = WDFText::get('FAX');
            $form_field['placeholder'] = WDFText::get('FAX');
            $form_field['required'] = $options->user_data_fax == 2 ? true : false;
            $form_field['has_error'] = in_array('fax', $invalid_fields);
            $form_fields['fax'] = $form_field;
        }

        // zip code
        if ($options->user_data_zip_code != 0) {
            $form_field = array();
            $form_field['type'] = 'text';
            $form_field['name'] = 'zip_code';
            $form_field['label'] = WDFText::get('ZIP_CODE');
            $form_field['placeholder'] = WDFText::get('ZIP_CODE');
            $form_field['required'] = $options->user_data_zip_code == 2 ? true : false;
            $form_field['has_error'] = in_array('zip_code', $invalid_fields);
            $form_fields['zip_code'] = $form_field;
        }

        return $form_fields;
    }

    public function get_current_user_row() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        if (WDFHelper::is_user_logged_in() == true) {
            $j_user = JFactory::getUser();
            $row_user = WDFDb::get_row('users', 'j_user_id = ' . $j_user->id);

            if ($row_user->id != 0) {
                // name
                $name_parts = array();
                if (($row_user->first_name != null) && ($row_user->first_name != '')) {
                    $name_parts[] = $row_user->first_name;
                }
                if (($row_user->middle_name != null) && ($row_user->middle_name != '')) {
                    $name_parts[] = $row_user->middle_name;
                }
                if (($row_user->last_name != null) && ($row_user->last_name != '')) {
                    $name_parts[] = $row_user->last_name;
                }
                $row_user->name = implode(' ', $name_parts);
            } else {
                // for not wd shop registered users
                $row_user = WDFDb::get_table_instance('users');
                $row_user->name = $j_user->name;
                $row_user->j_user_id = $j_user->id;
                $row_user->email = $j_user->email;
            }
        } else {
            $row_user = WDFDb::get_table_instance('users');
            $row_user->name = '';
            $row_user->email = '';
            $row_user->j_user_id = 0;
        }

        // additional data
        // products in cart
        $query->clear();
        $query->select('SUM(product_count)');
        $query->from('#__ecommercewd_orderproducts');
        if (WDFHelper::is_user_logged_in() == true) {
            $query->where('j_user_id = ' . $row_user->j_user_id);
        } else {
            $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids', array());
            if (empty($order_product_rand_ids) == false) {
                $query->where('j_user_id = 0');
                $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
            } else {
                $query->where(0);
            }
        }
        $query->where('order_id = 0');
        $db->setQuery($query);
		
        $row_user->products_in_cart = $db->loadResult();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $row_user;
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