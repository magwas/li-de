<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerDiscounts extends EcommercewdController {
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
        $this->clear_product_discounts(WDFInput::get_checked_ids());
        $this->clear_usergroup_discounts(WDFInput::get_checked_ids());

        parent::remove();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function clear_product_discounts($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->update('#__ecommercewd_products');
        $query->set('discount_id = 0');
        $query->where('discount_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function clear_usergroup_discounts($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->update('#__ecommercewd_usergroups');
        $query->set('discount_id = 0');
        $query->where('discount_id IN (' . implode(',', $ids) . ')');
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