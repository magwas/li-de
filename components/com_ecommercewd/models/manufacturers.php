<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelManufacturers extends EcommercewdModel {
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
    public function get_row() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        if(WDFInput::get('type'))
        {
            $id = WDFInput::get('id');
        }
        else
        $id = WDFInput::get('manufacturer_id', WDFParams::get('manufacturer_id', 0, 'int'));
        $row = WDFDb::get_row('manufacturers', array($db->quoteName('id') . ' = ' . $id, $db->quoteName('published') . ' = 1'));
	
        if ($row->id == 0) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=1');
        }

        // additional data
        // info
        if(WDFInput::get('type'))
        {
            $row->show_info = WDFInput::get('show_info');
        }
        else
        $row->show_info = WDFParams::get('show_info', 1);

        // logo
        if ($row->logo != null) {
            $logos = WDFJson::decode($row->logo);
            $row->logo = empty($logos) == false ? $logos[0] : '';
        } else {
            $row->logo = '';
        }

        // products and count
        if(WDFInput::get('type'))
        {
            $row->show_products = WDFInput::get('show_products');
        }
        else
        $row->show_products = WDFParams::get('show_products', 1);
        if(WDFInput::get('type'))
        {
            $row->products_count = WDFInput::get('products_number');
        }
        else
        $row->products_count = WDFParams::get('products_count', 12);
        $row->products = array();
        if ($row->show_products == 1) {
            $products = $this->get_manufacturer_products($row->id, $row->products_count);
            if ($products === false) {
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
            }
            $row->products = $products;
        }
        if (empty($row->products) == true) {
            $row->show_products = 0;
        }

        // url view products
        $row->url_view_products = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproducts&filter_manufacturer_ids=' . $row->id .'&filter_filters_opened=1');

        return $row;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_manufacturer_products($manufacturer_id, $count) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id');
        $query->select('name');
        $query->select('images');
        $query->from('#__ecommercewd_products');
        $query->where('manufacturer_id = ' . $manufacturer_id);
        $query->where('published = 1');
        $query->order('ordering ASC');
        $db->setQuery($query, 0, $count);
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }

        // additional data
        foreach ($rows as $row) {
            // url
            $row->url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproduct&product_id=' . $row->id);

            // image
            $row->images = WDFJson::decode($row->images);
            $row->image = empty($row->images) == false ? $row->images[0] : '';
        }

        return $rows;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}