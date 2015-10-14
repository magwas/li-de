<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFAdminModelBase extends WDFDummyJModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected $current_table_name;

    protected $rows_sort_data;
    protected $rows_default_sort_by;
    protected $rows_default_sort_order;
    protected $rows_filter_items;
    protected $rows_filter_conditions;
    protected $rows_pagination;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function __construct() {
        parent::__construct();

        $this->current_table_name = '#__' . WDFHelper::get_com_name() . '_' . WDFInput::get_controller();

        $this->init_rows_sort_data();
        $this->init_rows_filters();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_row($id = 0) {
        $task = WDFInput::get_task();
        if (($id == 0) && ($task != 'add')) {
            $id = WDFInput::get_checked_id();
        }

        $row = WDFDb::get_row_by_id('', $id);
        return $row;
    }

    public function get_rows() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $table_instance = WDFDb::get_table_instance();
        if (property_exists($table_instance, 'ordering') == true) {
            $table_instance->reorder();
        }

        $query->clear();
        $this->add_rows_query_select($query);
        $this->add_rows_query_from($query);
        $this->add_rows_query_where($query);
        $this->add_rows_query_order($query);
        $this->add_rows_query_group($query);
        $pagination = $this->get_rows_pagination();

        $db->setQuery($query, $pagination->limitstart, $pagination->limit);

        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }

        // additional data
        foreach ($rows as $row) {
            // view and edit urls
            $com_name = WDFHelper::get_com_name();
            $controller = WDFInput::get_controller();
            $row->view_url = 'index.php?option=com_' . $com_name . '&controller=' . $controller . '&task=view' . '&cid[]=' . $row->id;
            $row->edit_url = 'index.php?option=com_' . $com_name . '&controller=' . $controller . '&task=edit' . '&cid[]=' . $row->id;
        }

        return $rows;
    }

    public function get_rows_filter_items() {
        return $this->rows_filter_items;
    }

    public function get_rows_sort_data() {
        return $this->rows_sort_data;
    }

    public function get_rows_pagination() {
        if ($this->rows_pagination == null) {
            jimport('joomla.html.pagination');

            $rows_count = $this->get_rows_count();

            $limit = WDFSession::get_pagination_limit();
            $limitstart = WDFSession::get_pagination_start();
            $this->rows_pagination = new JPagination($rows_count, $limitstart, $limit);
        }
        return $this->rows_pagination;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_sort_data() {
        if ($this->rows_sort_data === null) {
			switch(WDFInput::get_controller()){				
				case "categories":
				case "orderstatuses":
				case "pages":
				case "payments":
				case "products":
				case "shippingmethods":
				case "tags":
					$sort_by = 'ordering';
				break;
				default:	
					$sort_by = 'id';
				break;	
			}	
            $this->rows_sort_data = array('sort_by' => $sort_by, 'sort_order' => 'asc');
        }

        $this->rows_sort_data['sort_by'] = WDFSession::get('sort_by', $this->rows_sort_data['sort_by']);
        $this->rows_sort_data['sort_order'] = WDFSession::get('sort_order', $this->rows_sort_data['sort_order']);
    }

    protected function init_rows_filters() {
        if ($this->rows_filter_items === null) {
            $this->rows_filter_items = array();
        }

        // reset filter values if needed
        if (WDFInput::get('reset_filters', 0, 'int') == 1) {
            foreach ($this->rows_filter_items as $filter_item) {
                WDFSession::set('search_' . $filter_item->name, $filter_item->default_value);
            }
        }

        // init values
        foreach ($this->rows_filter_items as $filter_item) {
            switch ($filter_item->type) {
                case 'uint':
                    $value = WDFSession::get('search_' . $filter_item->name, $filter_item->default_value, 'int');
                    $filter_item->value = $value >= 0 ? $value : null;
                    break;
                case 'string':
                    $value = WDFSession::get('search_' . $filter_item->name, $filter_item->default_value, 'string');
                    $filter_item->value = $value != '' ? $value : null;
                    break;
                default:
                    $filter_item->value = WDFSession::get('search_' . $filter_item->name, $filter_item->default_value, $filter_item->type);

            }
        }
    }

    protected function get_rows_count() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $this->add_rows_query_from($query);
        $this->add_rows_query_where($query);
        $db->setQuery($query);
        $rows_count = $db->loadResult();

        if ($db->getErrorNum()) {
            $db->getErrorMsg();
        }

        return $rows_count;
    }

    protected function add_rows_query_select(JDatabaseQuery $query) {
        $query->select($this->current_table_name . '.*');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        $query->from($this->current_table_name);
    }

    protected function add_rows_query_where(JDatabaseQuery $query) {
        $this->add_rows_query_where_filters($query);
    }

    protected function add_rows_query_where_filters(JDatabaseQuery $query) {
        if ($this->rows_filter_conditions === null) {
            $db = JFactory::getDbo();

            $filter_conditions = array();
            foreach ($this->rows_filter_items as $filter_item) {				
                if ($filter_item->value !== null) {
                    $operator = strtolower($filter_item->operator);
                    switch ($operator) {
                        case 'like':
                            $filter_condition = 'LOWER(' . $this->current_table_name . '.' . $filter_item->name . ') LIKE ' . $db->quote('%' . $filter_item->value . '%');
                            break;
                        default:
                            $filter_name = $filter_item->name;
                            $filter_value = $filter_item->value;

                            if ($filter_item->input_type == 'date') {
                                if ($operator == '>=') {
                                    if (substr($filter_name, -5) == '_from') {
                                        $filter_name = substr($filter_name, 0, -5);
                                    }
                                    $filter_value .= ' 00:00:00';
                                } else if ($operator == '<=') {
                                    if (substr($filter_name, -3) == '_to') {
                                        $filter_name = substr($filter_name, 0, -3);
                                    }
                                    $filter_value .= ' 23:59:59';
                                }
                            }

                            $filter_condition = $this->current_table_name . '.' . $filter_name . ' ' . $operator . ' ' . $db->quote($filter_value);
                            break;
                    }
                    $filter_conditions[] = $filter_condition;
					
                }
            }
			
            $this->rows_filter_conditions = $filter_conditions;
        }

        foreach ($this->rows_filter_conditions as $filter_condition) {
            $query->where($filter_condition);
        }
		
    }

    protected function add_rows_query_group(JDatabaseQuery $query) {
        $query->group($this->current_table_name . '.id');
    }

    protected function add_rows_query_order(JDatabaseQuery $query) {
        $db = JFactory::getDbo();

        $sort_data = $this->get_rows_sort_data();
        $query->order($db->quoteName($this->current_table_name . '.' . $sort_data['sort_by']) . ' ' . $sort_data['sort_order']);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}