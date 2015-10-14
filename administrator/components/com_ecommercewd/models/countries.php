<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelCountries extends EcommercewdModel {
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
    public function get_rows_pagination() {
        jimport('joomla.html.pagination');

        $task = WDFInput::get_task();
        return $task == 'explore' ? new JPagination(0, 0, 0) : parent::get_rows_pagination();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
	protected function add_rows_query_where(JDatabaseQuery $query) {
		$task = WDFInput::get_task();
		if($task == 'explore')
			$query->where("published ='1' ");
        $this->add_rows_query_where_filters($query);
    }
    protected function init_rows_sort_data() {
        $this->rows_sort_data = array('sort_by' => 'published', 'sort_order' => 'desc');

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


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}