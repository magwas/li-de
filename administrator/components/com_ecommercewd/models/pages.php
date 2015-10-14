<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelPages extends EcommercewdModel {
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
        // article title
        $row->article_title = $this->get_article_title($row->article_id);

        return $row;
    }

    public function get_articles_table_data() {
        jimport('joomla.html.pagination');

        $db = JFactory::getDbo();
        $query = $db->getQuery();

        // session data
        $search_title = WDFSession::get('search_title', '');
        $sort_by = WDFSession::get('sort_by', 'id');
        $sort_order = WDFSession::get('sort_order', 'asc');
        $limit = WDFSession::get_pagination_limit();
        $limitstart = WDFSession::get_pagination_start();

        //count
        $query->clear();
        $query->select('COUNT(*)');
        $query->from('#__content');
        $query->where('LOWER(title) LIKE "%' . $search_title . '%"');
        $db->setQuery($query);
        $rows_count = $db->loadResult();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $pagination = new JPagination($rows_count, $limitstart, $limit);

        //rows
        $query->clear();
        $query->select('T_CONTENT.id');
        $query->select('T_CONTENT.title');
        $query->select('T_CATEGORIES.title as category_title');
        $query->select('T_CONTENT.state as published');
        $query->from('#__content AS T_CONTENT');
        $query->leftJoin('#__categories AS T_CATEGORIES ON T_CATEGORIES.id = T_CONTENT.catid');
        $query->where('LOWER(T_CONTENT.title) LIKE "%' . $search_title . '%"');
        $query->order('T_CONTENT.' . $sort_by . ' ' . $sort_order);
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $data = array();
        $data['rows'] = $rows;
        $data['filter_items'] = $this->get_rows_filter_items();
        $data['sort_data'] = array('sort_by' => $sort_by, 'sort_order' => $sort_order);
        $data['pagination'] = $pagination;
        return $data;
    }

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
    protected function init_rows_filters() {
        $filter_items = array();

        // title
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'title';
        $filter_item->default_value = null;
        $filter_item->operator = 'like';
        $filter_item->input_type = 'text';
        $filter_item->input_label = WDFText::get('TITLE');
        $filter_item->input_name = 'search_title';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    private function get_article_title($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('title');
        $query->from('#__content');
        $query->where('id = ' . $id);
        $db->setQuery($query);
        $title = $db->loadResult();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $title;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}