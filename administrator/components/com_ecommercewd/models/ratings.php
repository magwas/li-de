<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelRatings extends EcommercewdModel {
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
    public function get_rows() {
        $rows = parent::get_rows();
		
        // additional data
        foreach ($rows as $row) {
            // user view url
            $row->user_view_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=users' . '&task=view' . '&cid[]=' . $row->user_id;
        }

        return $rows;
    }

    public function get_lists() {
        $list_ratings = array(array('value' => 1, 'text' => 1), array('value' => 2, 'text' => 2), array('value' => 3, 'text' => 3), array('value' => 4, 'text' => 4), array('value' => 5, 'text' => 5));

        $lists = array();
        $lists['ratings'] = $list_ratings;

        return $lists;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_filters() {
        $filter_items = array();

        // product id
        $filter_item = new stdClass();
        $filter_item->type = 'uint';
        $filter_item->name = 'product_id';
        $filter_item->values_list = WDFDb::get_list('products', 'id', 'name', array(), '', array(array('id' => -1, 'name' => '-' . WDFText::get('ANY_PRODUCT') . '-')));
        $filter_item->values_list_prop_value = 'id';
        $filter_item->values_list_prop_text = 'name';
        $filter_item->default_value = -1;
        $filter_item->operator = '=';
        $filter_item->input_type = 'select';
        $filter_item->input_label = WDFText::get('PRODUCT');
        $filter_item->input_name = 'search_product_id';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    protected function add_rows_query_select(JDatabaseQuery $query) {
        $query->select($this->current_table_name . '.*');
        $query->select('T_USERS.id AS user_id');
        $query->select('CONCAT (T_USERS.first_name, " ", T_USERS.last_name) AS user_name');
        $query->select('T_PRODUCTS.name AS product_name');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        parent::add_rows_query_from($query);

        $query->leftJoin('#__ecommercewd_users AS T_USERS ON #__ecommercewd_ratings.j_user_id = T_USERS.j_user_id');
        $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON #__ecommercewd_ratings.product_id = T_PRODUCTS.id');
    }

    protected function add_rows_query_order(JDatabaseQuery $query) {
        $sort_data = $this->get_rows_sort_data();

        $query->order(($sort_data['sort_by']) . ' ' . $sort_data['sort_order']);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}