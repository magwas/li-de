<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelFeedback extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static $MAX_TEXT_LENGTH_DEFAULT_VIEW = 250;


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
        // product name
        $row_products = WDFDb::get_row_by_id('products', $row->product_id);
        $row->product_name = $row_products->name;

        // manufacturer name
        $row_manufacturer = WDFDb::get_row_by_id('manufacturers', $row_products->manufacturer_id);
        $row->manufacturer_name = $row_manufacturer->name;

        // user id
        $user_rows = WDFDb::get_rows('users', 'j_user_id = ' . $row->j_user_id);
        $row_user = empty($user_rows) == true ? WDFDb::get_table_instance('users') : $user_rows[0];
        $row->user_id = $row_user->id;
        $row->text = htmlspecialchars($row->text);

        return $row;
    }

    public function get_rows() {
        $rows = parent::get_rows();

        // additional data
        foreach ($rows as $row) {
            // user view url
            $row->user_view_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=users' . '&task=view' . '&cid[]=' . $row->user_id;

            // shorten text
            $row->text = WDFTextUtils::truncate($row->text, self::$MAX_TEXT_LENGTH_DEFAULT_VIEW);
			$row->text = htmlspecialchars($row->text);
        }

        return $rows;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_sort_data() {
        $this->rows_sort_data = array('sort_by' => 'date', 'sort_order' => 'desc');

        parent::init_rows_sort_data();
    }

    protected function init_rows_filters() {
        $filter_items = array();

        // user name
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'user_name';
        $filter_item->default_value = null;
        $filter_item->operator = 'like';
        $filter_item->input_type = 'text';
        $filter_item->input_label = WDFText::get('USER_NAME');
        $filter_item->input_name = 'search_user_name';
        $filter_items[$filter_item->name] = $filter_item;

        // text
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'text';
        $filter_item->default_value = null;
        $filter_item->operator = 'like';
        $filter_item->input_type = 'text';
        $filter_item->input_label = WDFText::get('TEXT');
        $filter_item->input_name = 'search_text';
        $filter_items[$filter_item->name] = $filter_item;

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

        // date from
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'date_from';
        $filter_item->default_value = null;
        $filter_item->operator = '>=';
        $filter_item->input_type = 'date';
        $filter_item->input_label = WDFText::get('DATE_FROM');
        $filter_item->input_name = 'search_date_from';
        $filter_items[$filter_item->name] = $filter_item;

        // date to
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'date_to';
        $filter_item->default_value = null;
        $filter_item->operator = '<=';
        $filter_item->input_type = 'date';
        $filter_item->input_label = WDFText::get('DATE_TO');
        $filter_item->input_name = 'search_date_to';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    protected function add_rows_query_select(JDatabaseQuery $query) {
        $query->select($this->current_table_name . '.*');
        $query->select('T_USERS.id AS user_id');
        $query->select('T_PRODUCTS.name AS product_name');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        $query->from($this->current_table_name);
        $query->leftJoin('#__ecommercewd_users AS T_USERS ON #__ecommercewd_feedback.j_user_id = T_USERS.j_user_id');
        $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON #__ecommercewd_feedback.product_id = T_PRODUCTS.id');
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}