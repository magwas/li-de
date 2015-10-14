<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerThemes extends EcommercewdController {
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
    public function __construct() {
        parent::__construct();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function edit_basic() {
        parent::display();
    }

    public function apply() {
        $row = $this->store_input_in_row();
        WDFHelper::redirect('', 'edit', $row->id, 'tab_index=' . WDFInput::get('tab_index'), WDFText::get('MSG_CHANGES_SAVED'));
    }

    public function save2copy() {
        WDFInput::set('id', '');
        WDFInput::set('basic', 0);
        WDFInput::set('default', 0);

        $this->prepare_checkboxes_for_save();

        $row = $this->store_input_in_row();
        WDFHelper::redirect('', 'edit', $row->id, 'tab_index=' . WDFInput::get('tab_index'), WDFText::get('MSG_CHANGES_SAVED'));
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function store_input_in_row() {
        $this->valididate_theme_name();
        $this->prepare_checkboxes_for_save();
        $row = parent::store_input_in_row();

        return $row;
    }

    public function valididate_theme_name() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();

        $id = WDFInput::get('id', 0, 'int');
        $name = WDFInput::get('name', '');
        if ($name == '') {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SAVE_CHANGES'), 'error');
            return false;
        }

        // check if rows with the same name exist
        $rows_theme = WDFDb::get_rows('themes', array('name = ' . $db->quote($name), 'id != ' . $id));

        $row_theme = empty($rows_theme) == false ? $rows_theme[0] : null;
        if ($row_theme != null) {
            $i = 2;
            do {
                $new_name = $name . '(' . $i . ')';
                $rows_theme = WDFDb::get_rows('themes', array('name = ' . $db->quote($new_name), 'id != ' . $id));
                $row_theme = empty($rows_theme) == false ? $rows_theme[0] : null;
                $i++;
            } while ($row_theme != null);
        } else {
            $new_name = $name;
        }

        WDFInput::set('name', $new_name);
    }

    private function prepare_checkboxes_for_save() {
        $checkboxes = array('products_thumbs_view_show_image', 'products_thumbs_view_show_label', 'products_thumbs_view_show_name', 'products_thumbs_view_show_rating', 'products_thumbs_view_show_price', 'products_thumbs_view_show_market_price', 'products_thumbs_view_show_description', 'products_thumbs_view_show_button_quick_view', 'products_thumbs_view_show_button_compare', 'products_thumbs_view_show_button_buy_now', 'products_thumbs_view_show_button_add_to_cart',

            'products_list_view_show_image', 'products_list_view_show_label', 'products_list_view_show_name', 'products_list_view_show_rating', 'products_list_view_show_price', 'products_list_view_show_market_price', 'products_list_view_show_description', 'products_list_view_show_button_quick_view', 'products_list_view_show_button_compare', 'products_list_view_show_button_buy_now', 'products_list_view_show_button_add_to_cart',

            'products_quick_view_show_image', 'products_quick_view_show_label', 'products_quick_view_show_name', 'products_quick_view_show_rating', 'products_quick_view_show_category', 'products_quick_view_show_manufacturer', 'products_quick_view_show_price', 'products_quick_view_show_market_price', 'products_quick_view_show_description', 'products_quick_view_show_button_compare', 'products_quick_view_show_button_buy_now', 'products_quick_view_show_button_add_to_cart',

            'product_view_show_image', 'product_view_show_label', 'product_view_show_name', 'product_view_show_rating', 'product_view_show_category', 'product_view_show_manufacturer', 'product_view_show_price', 'product_view_show_market_price', 'product_view_show_button_compare', 'product_view_show_button_write_review', 'product_view_show_button_buy_now', 'product_view_show_button_add_to_cart', 'product_view_show_description', 'product_view_show_social_buttons', 'product_view_show_parameters', 'product_view_show_shipping_info', 'product_view_show_reviews', 'product_view_show_related_products',);

        foreach ($checkboxes as $checkbox) {
            WDFInput::set($checkbox, WDFInput::get($checkbox, 0, 'int'));
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}