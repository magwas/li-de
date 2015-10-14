<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerManufacturers extends EcommercewdController {
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
        $this->clear_product_manufacturers(WDFInput::get_checked_ids());

        parent::remove();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function clear_product_manufacturers($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->update('#__ecommercewd_products');
        $query->set('manufacturer_id = 0');
        $query->where('manufacturer_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    protected function store_input_in_row() {
        $this->validate_save_data();
        $row = WDFDb::store_input_in_row();
        return $row;
    }

    private function validate_save_data() {
        $db = JFactory::getDbo();

        $self_id = WDFInput::get('id');

        // alias
        $alias = trim(WDFInput::get('alias', ''));
        // If the alias field is empty, set it to the title.
        if (empty($alias) == true) {
            $alias = WDFInput::get('name', '');
        }

        // make the alias URL safe.
        $alias = JApplication::stringURLSafe($alias);
        if (trim(str_replace('-', '', $alias)) == '') {
            $this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
        }

        // get unique alias
        $row_manufacturer = WDFDb::get_row('manufacturers', array('id != ' . $self_id, $db->quoteName('alias') . ' = ' . $db->quote($alias)));
        if ($row_manufacturer->id != 0) {
            $i = 2;
            do {
                $new_alias = $alias . '-' . $i++;
                $row_manufacturer = WDFDb::get_row('manufacturers', array('id != ' . $self_id, $db->quoteName('alias') . ' = ' . $db->quote($new_alias)));
            } while ($row_manufacturer->id != 0);
            $alias = $new_alias;
        }

        WDFInput::set('alias', $alias);

        // site
        $site = WDFInput::get('site');
        if (($site != '') && (substr($site, 0, 7) != 'http://') && (substr($site, 0, 8) != 'https://')) {
            WDFInput::set('site', 'http://' . $site);
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}