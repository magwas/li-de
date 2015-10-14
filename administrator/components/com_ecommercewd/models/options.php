<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdModelOptions extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private $options;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_options_row() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('name');
        $query->select('value');
        $query->from('#__ecommercewd_options');
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        $options = new stdClass();
        foreach ($rows as $row) {
            $name = $row->name;
            $value = $row->value;
            $options->$name = $value;
        }

        return $options;
    }

    public function get_options() {
        if ($this->options == null) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->clear();
            $query->select('*');
            $query->from('#__ecommercewd_options');
            $db->setQuery($query);
            $initial_values = $db->loadAssocList('name', 'value');
            $default_values = $db->loadAssocList('name', 'default_value');

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }

            $this->options = array();
            $this->options['initial_values'] = $initial_values;
            $this->options['default_values'] = $default_values;
        }

        return $this->options;
    }

    public function get_lists() {
		// dimensions units
		$list_dimensions_units = array();
        $list_dimensions_units[] = array('value' => 'm', 'text' => 'm');
        $list_dimensions_units[] = array('value' => 'cm', 'text' => 'cm');
        $list_dimensions_units[] = array('value' => 'mm', 'text' => 'mm');
        $list_dimensions_units[] = array('value' => 'in', 'text' => 'in');
        $list_dimensions_units[] = array('value' => 'yd', 'text' => 'yd');
		
		// weight units
		$list_weight_units = array();
        $list_weight_units[] = array('value' => 'kg', 'text' => 'kg');
        $list_weight_units[] = array('value' => 'g', 'text' => 'g');
        $list_weight_units[] = array('value' => 'lbs', 'text' => 'lbs');
        $list_weight_units[] = array('value' => 'oz', 'text' => 'oz');
	
        // captcha themes
        $list_captcha_themes = array();
        $list_captcha_themes[] = array('value' => 'red', 'text' => 'Red');
        $list_captcha_themes[] = array('value' => 'white', 'text' => 'White');
        $list_captcha_themes[] = array('value' => 'blackglass', 'text' => 'Blackglass');
        $list_captcha_themes[] = array('value' => 'clean', 'text' => 'Clean');

        // date formats
        $list_date_formats = array();
        $list_date_formats[] = array('value' => 'd/m/Y', 'text' => '20/01/2014');
        $list_date_formats[] = array('value' => 'd/m/y', 'text' => '20/01/14');
        $list_date_formats[] = array('value' => 'm/d/Y', 'text' => '01/20/2014');
        $list_date_formats[] = array('value' => 'm/d/y', 'text' => '01/20/14');

        // user data fields
        $radio_list_user_data_field = array();
        $radio_list_user_data_field[] = (object)array('value' => '0', 'text' => WDFText::get('HIDE'));
        $radio_list_user_data_field[] = (object)array('value' => '1', 'text' => WDFText::get('SHOW'));
        $radio_list_user_data_field[] = (object)array('value' => '2', 'text' => WDFText::get('SHOW_AND_REQUIRE'));

        // redirect to cart after adding an item
		
		$radio_list_refirect_to_cart_field = array();
        $radio_list_refirect_to_cart_field[] = (object)array('value' => '0', 'text' => WDFText::get('ALLOW_ADDING_THE_SAME_ITEM_MULTIPLE_TIMES'));
        $radio_list_refirect_to_cart_field[] = (object)array('value' => '2', 'text' => WDFText::get('ALLOW_ADDING_EVERY_ITEM_ONCE'));
        $radio_list_refirect_to_cart_field[] = (object)array('value' => '1', 'text' => WDFText::get('REDIRECT_TO_CART'));


        $lists = array();
        $lists['dimensions_units'] = $list_dimensions_units;
        $lists['weight_units'] = $list_weight_units;
        $lists['captcha_themes'] = $list_captcha_themes;
        $lists['date_formats'] = $list_date_formats;
        $lists['user_data_field'] = $radio_list_user_data_field;
        $lists['refirect_to_cart'] = $radio_list_refirect_to_cart_field;

        return $lists;
    }

    public function get_user_data_fields() {
        $datas = array();
        $datas[] = (object)array('label' => WDFText::get('MIDDLE_NAME'), 'name' => 'user_data_middle_name',);
        $datas[] = (object)array('label' => WDFText::get('LAST_NAME'), 'name' => 'user_data_last_name',);
        $datas[] = (object)array('label' => WDFText::get('COMPANY'), 'name' => 'user_data_company',);
        $datas[] = (object)array('label' => WDFText::get('COUNTRY'), 'name' => 'user_data_country',);
        $datas[] = (object)array('label' => WDFText::get('STATE'), 'name' => 'user_data_state',);
        $datas[] = (object)array('label' => WDFText::get('CITY'), 'name' => 'user_data_city',);
        $datas[] = (object)array('label' => WDFText::get('ADDRESS'), 'name' => 'user_data_address',);
        $datas[] = (object)array('label' => WDFText::get('MOBILE'), 'name' => 'user_data_mobile',);
        $datas[] = (object)array('label' => WDFText::get('PHONE'), 'name' => 'user_data_phone',);
        $datas[] = (object)array('label' => WDFText::get('FAX'), 'name' => 'user_data_fax',);
        $datas[] = (object)array('label' => WDFText::get('ZIP_CODE'), 'name' => 'user_data_zip_code',);
        return $datas;
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