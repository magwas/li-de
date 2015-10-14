<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelShippingmethods extends EcommercewdModel {
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
    public function get_row($id = 0) {
        $row = parent::get_row($id);

        // additional data
        // country ids and names
        $country_names = array();
        $row->country_ids = $this->get_country_ids($row->id);
        if (empty($row->country_ids) == false) {
            foreach ($row->country_ids as $country_id) {
                $row_country = WDFDb::get_row_by_id('countries', $country_id);
                $country_names[] = $row_country->name;
            }
        }
        $row->country_names = implode('&#13;', $country_names);

        return $row;
    }

    public function get_rows() {
        $db = JFactory::getDbo();

        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        $rows = parent::get_rows();

        // additional data
        foreach ($rows as $row) {
            // price text
            if ($row->free_shipping == 1) {
                $row->price_text = WDFText::get('FREE_SHIPPING');
            } else {
                $row->price_text = number_format($row->price, 2) . ' ' . $row_default_currency->code;
            }
        }

        return $rows;
    }

    public function get_rows_pagination() {
        jimport('joomla.html.pagination');

        $task = WDFInput::get_task();
        return $task == 'explore' ? new JPagination(0, 0, 0) : parent::get_rows_pagination();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_filters() {
        $filter_items = array();

        // name
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'name';
        $filter_item->default_value = null;
        $filter_item->operator = 'like';
        $filter_item->input_type = 'text';
        $filter_item->input_label = WDFText::get('NAME');
        $filter_item->input_name = 'search_name';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    private function get_country_ids($shipping_method_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('country_id');
        $query->from('#__ecommercewd_shippingmethodcountries');
        $query->where('shipping_method_id = ' . $shipping_method_id);
        $db->setQuery($query);
        $country_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }

        return $country_ids;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}