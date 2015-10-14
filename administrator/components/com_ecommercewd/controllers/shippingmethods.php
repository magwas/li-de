<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerShippingmethods extends EcommercewdController {
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
        $this->remove_shipping_method_countries(WDFInput::get_checked_ids());

        parent::remove();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function remove_shipping_method_countries($ids) {
        if (is_array($ids) == false) {
            $ids = array($ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_shippingmethodcountries');
        $query->where('shipping_method_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    protected function store_input_in_row() {
        // free shipping after certain price
        if ((WDFInput::get('free_shipping', 0, 'int') == 0) && (WDFInput::get('free_shipping_after_certain_price', 0, 'int') == 1)) {
            WDFInput::set('free_shipping', 2);
        }

        $row = parent::store_input_in_row();

        $this->save_shipping_method_countries($row->id);
        return $row;
    }

    private function save_shipping_method_countries($row_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $this->remove_shipping_method_countries($row_id);

        $country_ids = WDFInput::get_array('country_ids', ',');
        if (count($country_ids) > 0) {
            $ar_values = array();
            for ($i = 0; $i < count($country_ids); $i++) {
                $country_id = $country_ids[$i];
                $ar_values[] = $db->quote($row_id) . ', ' . $db->quote($country_id);
            }

            $query->clear();
            $query->insert('#__ecommercewd_shippingmethodcountries');
            $columns = array('shipping_method_id', 'country_id');
            $query->columns($columns);
            foreach ($ar_values as $values) {
                $query->values($values);
            }
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}