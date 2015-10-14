<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelUsergroups extends EcommercewdModel {
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
        // discount data
        $row_discount = WDFDb::get_row_by_id('discounts', $row->discount_id);
        $row->discount_id = $row_discount->id;
        $row->discount_name = $row->discount_id != 0 ? $row_discount->name . ' (' . $row_discount->rate . '%)' : '';
        $row->discount_rate = $row_discount->rate;

        // user ids and names
        $user_names = array();
        $row->user_ids = $this->get_user_ids($row->id);
        if (empty($row->user_ids) == false) {
            foreach ($row->user_ids as $user_id) {
                $row_user = WDFDb::get_row_by_id('users', $user_id);
                $name_parts = array();
                if ($row_user->first_name != '') {
                    $name_parts[] = $row_user->first_name;
                }
                if ($row_user->middle_name != '') {
                    $name_parts[] = $row_user->middle_name;
                }
                if ($row_user->last_name != '') {
                    $name_parts[] = $row_user->last_name;
                }
                $user_names[] = implode(' ', $name_parts);
            }
        }
        $row->user_names = implode('&#13;', $user_names);

        return $row;
    }

    public function get_lists() {
        $lists = array();
        $lists['discounts'] = WDFDb::get_list('discounts', 'id', 'CONCAT(name, "(", rate, "%)") AS name', array(), '', array(array('id' => '', 'name' => '-' . WDFText::get('SELECT_DISCOUNT') . '-')));
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

    protected function add_rows_query_select(JDatabaseQuery $query) {
        $query->select($this->current_table_name . '.*');
        $query->select('CONCAT(T_DISCOUNTS.name, " (", T_DISCOUNTS.rate, "%)") AS discount_data');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        parent::add_rows_query_from($query);

        $query->leftJoin('#__ecommercewd_discounts AS T_DISCOUNTS ON #__ecommercewd_usergroups.discount_id = T_DISCOUNTS.id');
    }

    private function get_user_ids($usergroup_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('id');
        $query->from('#__ecommercewd_users');
        $query->where('usergroup_id = ' . $usergroup_id);
        $db->setQuery($query);
        $ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }

        return $ids;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}