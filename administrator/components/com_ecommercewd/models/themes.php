<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelThemes extends EcommercewdModel {
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
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $task = WDFInput::get_task();

        // get base theme
        switch ($task) {
            case 'add':
                $query->clear();
                $query->select('*');
                $query->from('#__ecommercewd_themes');
                $query->where($db->quoteName('basic') . ' = 1');
                $db->setQuery($query);
                $row = $db->loadObject();

                if ($db->getErrorNum()) {
                    echo $db->getErrorMsg();
                    die();
                }

                $row->id = '';
                $row->name = '';
                $row->basic = 0;
                $row->default = 0;
                break;
            case 'edit_basic':
                $row = WDFDb::get_checked_row();

                $row->id = '';
                $row->name = '';
                $row->basic = 0;
                $row->default = 0;
                break;
            case 'edit':
                $row = WDFDb::get_checked_row();
                break;
        }

        return $row;
    }

    public function get_rows() {
        $rows = parent::get_rows();

        // additional data
        foreach ($rows as $row) {
            // edit url
            if ($row->basic == 1) {
                $row->edit_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=' . WDFInput::get_controller() . '&task=edit_basic' . '&cid[]=' . $row->id;
            }

            // icon baseic
            $row->icon_basic = $row->basic == 1 ? '<img src="templates/hathor/images/admin/icon-16-protected.png">' : '';

            // icon default
            $row->icon_default = $row->default == 1 ? '<img src="templates/hathor/images/header/icon-48-default.png">' : '';
        }

        return $rows;
    }
    protected function add_rows_query_where(JDatabaseQuery $query) {
        $this->add_rows_query_where_filters($query);
		$query->where('basic = 0');
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


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}