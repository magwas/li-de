<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelUsers extends EcommercewdModel {
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
        // email
        $j_user = JFactory::getUser($row->j_user_id);
        $row->email = $j_user->email;

        // country name
        $row_country = WDFDb::get_row_by_id('countries', $row->country_id);
        $row->country_name = $row_country->name;

        // usergroup_name
        $row_usergroup = WDFDb::get_row_by_id('usergroups', $row->usergroup_id);
        $row->usergroup_name = $row_usergroup->name;

        return $row;
    }

    public function get_rows() {
        $rows = parent::get_rows();

        // additional data
        foreach ($rows as $row) {
            // name
            $name_parts = array();
            if ($row->first_name != '') {
                $name_parts[] = $row->first_name;
            }
            if ($row->middle_name != '') {
                $name_parts[] = $row->middle_name;
            }
            if ($row->last_name != '') {
                $name_parts[] = $row->last_name;
            }
            $row->name = implode(' ', $name_parts);
        }

        return $rows;
    }

    public function get_rows_pagination() {
        jimport('joomla.html.pagination');

        $task = WDFInput::get_task();
        return $task == 'explore' ? new JPagination(0, 0, 0) : parent::get_rows_pagination();
    }

    public function get_view_lists() {
        $lists = array();
        $lists['usergroups'] = WDFDb::get_list('usergroups', 'id', 'name', array(), '', array(array('id' => '', 'name' => '-' . WDFText::get('SELECT_USERGROUP') . '-')));
        return $lists;
    }

    public function get_edit_lists() {
        $lists = array();
        $lists['countries'] = WDFDb::get_list('countries', 'id', 'name', array(' published = "1" '), 'name ASC', array(array('id' => '', 'name' => '-' . WDFText::get('SELECT_COUNTRY') . '-')));
        $lists['usergroups'] = WDFDb::get_list('usergroups', 'id', 'name', array(), '', array(array('id' => '', 'name' => '-' . WDFText::get('SELECT_USERGROUP') . '-')));
        return $lists;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_sort_data() {
        $this->rows_sort_data = array('sort_by' => 'first_name', 'sort_order' => 'asc');

        parent::init_rows_sort_data();
    }

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
        parent::add_rows_query_select($query);

        $query->select('CONCAT(#__ecommercewd_users.first_name, " ", #__ecommercewd_users.middle_name, " ", #__ecommercewd_users.last_name) AS name');
        $query->select('T_COUNTRIES.name AS country_name');
        $query->select('T_USERGROUPS.name AS usergroup_name');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        parent::add_rows_query_from($query);

        $query->leftJoin('#__ecommercewd_countries AS T_COUNTRIES ON #__ecommercewd_users.country_id = T_COUNTRIES.id');
        $query->leftJoin('#__ecommercewd_usergroups AS T_USERGROUPS ON #__ecommercewd_users.usergroup_id = T_USERGROUPS.id');
    }

    protected function add_rows_query_where_filters(JDatabaseQuery $query) {
        $db = JFactory::getDbo();

        $search_name = WDFSession::get('search_name');

        $query->where('LOWER(CONCAT(#__ecommercewd_users.first_name, #__ecommercewd_users.middle_name, #__ecommercewd_users.last_name)) LIKE ' . $db->quote('%' . WDFTextUtils::remove_spaces($search_name) . '%'));
    }

    protected function add_rows_query_order(JDatabaseQuery $query) {
        $sort_data = $this->get_rows_sort_data();

        $query->order(($sort_data['sort_by']) . ' ' . $sort_data['sort_order']);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}