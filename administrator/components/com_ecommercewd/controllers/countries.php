<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerCountries extends EcommercewdController {
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
        $this->clear_user_countries(WDFInput::get_checked_ids());
        $this->clear_order_user_countries(WDFInput::get_checked_ids());

        parent::remove();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function remove_shipping_method_countries($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_shippingmethodcountries');
        $query->where('country_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function clear_user_countries($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->update('#__ecommercewd_users');
        $query->set('country_id = 0');
        $query->where('country_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function clear_order_user_countries($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->update('#__ecommercewd_orders');
        $query->set('shipping_data_country_id = 0');
        $query->where('shipping_data_country_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}