<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelUseraccount extends EcommercewdModel {
    
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
    public function get_user_data() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $j_user = JFactory::getUser();

        $query->clear();
        $query->select('T_USERS.first_name');
        $query->select('T_USERS.middle_name');
        $query->select('T_USERS.last_name');
        $query->select('T_USERS.company');
        $query->select('T_J_USERS.email');
        $query->select('T_COUNTRIES.name AS country');
        $query->select('T_USERS.state');
        $query->select('T_USERS.city');
        $query->select('T_USERS.address');
        $query->select('T_USERS.mobile');
        $query->select('T_USERS.phone');
        $query->select('T_USERS.fax');
        $query->select('T_USERS.zip_code');
        $query->from('#__ecommercewd_users AS T_USERS');
        $query->leftJoin('#__users AS T_J_USERS ON T_USERS.j_user_id = T_J_USERS.id');
        $query->leftJoin('#__ecommercewd_countries AS T_COUNTRIES ON T_USERS.country_id = T_COUNTRIES.id');
        $query->where('T_USERS.j_user_id = ' . $j_user->id);
        $db->setQuery($query);
        $row_user = $db->loadObject();

       

        if ($row_user == null) {
            $row_user = WDFDb::get_table_instance('users');
            $row_user->email = $j_user->email;
            $row_user->country = 0;
        }
        // first name
        $data = new stdClass();
       
        $data->key = (($options->user_data_middle_name > 0) || ($options->user_data_last_name > 0)) ? WDFText::get('FIRST_NAME') : WDFText::get('NAME');
       
        $data->value = $row_user->first_name != '' ? $row_user->first_name : '-';
         
        $user_data['first_name'] = $data;

        // middle name
        if ($options->user_data_middle_name > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('MIDDLE_NAME');
            $data->value = $row_user->middle_name != '' ? $row_user->middle_name : '-';
            $user_data['middle_name'] = $data;
        }

        // last name
        if ($options->user_data_last_name > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('LAST_NAME');
            $data->value = $row_user->last_name != '' ? $row_user->last_name : '-';
            $user_data['last_name'] = $data;
        }

        // company
        if ($options->user_data_company > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('COMPANY');
            $data->value = $row_user->company != '' ? $row_user->company : '-';
            $user_data['company'] = $data;
        }

        // email
        $data = new stdClass();
        $data->key = WDFText::get('EMAIL');
        $data->value = $row_user->email != '' ? $row_user->email : '-';
        $user_data['email'] = $data;

        // country
        if ($options->user_data_country > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('COUNTRY');
            $data->value = $row_user->country != '' ? $row_user->country : '-';
            $user_data['country'] = $data;
        }

        // state
        if ($options->user_data_state > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('STATE');
            $data->value = $row_user->state != '' ? $row_user->state : '-';
            $user_data['state'] = $data;
        }

        // city
        if ($options->user_data_city > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('CITY');
            $data->value = $row_user->city != '' ? $row_user->city : '-';
            $user_data['city'] = $data;
        }

        // address
        if ($options->user_data_address > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('ADDRESS');
            $data->value = $row_user->address != '' ? $row_user->address : '-';
            $user_data['address'] = $data;
        }

        // mobile
        if ($options->user_data_mobile > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('MOBILE');
            $data->value = $row_user->mobile != '' ? $row_user->mobile : '-';
            $user_data['mobile'] = $data;
        }

        // phone
        if ($options->user_data_phone > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('PHONE');
            $data->value = $row_user->phone != '' ? $row_user->phone : '-';
            $user_data['phone'] = $data;
        }

        // fax
        if ($options->user_data_fax > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('FAX');
            $data->value = $row_user->fax != '' ? $row_user->fax : '-';
            $user_data['fax'] = $data;
        }

        // zip code
        if ($options->user_data_zip_code > 0) {
            $data = new stdClass();
            $data->key = WDFText::get('ZIP_CODE');
            $data->value = $row_user->zip_code != '' ? $row_user->zip_code : '-';
            $user_data['zip_code'] = $data;
        }

        return $user_data;
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