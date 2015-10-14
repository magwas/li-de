<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFAdminControllerBase extends WDFDummyJController {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected $default_view = 'ecommercewd';


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function __construct($config = array()) {
        parent::__construct($config);
        WDFInput::set('view', WDFInput::get_controller());
		if(file_exists('components/com_'.WDFHelper::get_com_name().'/tmp/export.xlsx')){
			unlink('components/com_'.WDFHelper::get_com_name().'/tmp/export.xlsx');
		}	
		if(file_exists('components/com_'.WDFHelper::get_com_name().'/tmp/import.xlsx')){
			unlink('components/com_'.WDFHelper::get_com_name().'/tmp/import.xlsx');
		}
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function explore() {
        WDFInput::set('tmpl', 'component');
        parent::display();
    }

    public function view() {
        parent::display();
    }

    public function add() {
        parent::display();
    }

    public function add_refresh() {
        parent::display();
    }

    public function edit() {
        parent::display();
    }

    public function edit_refresh() {
        parent::display();
    }

    public function make_default() {
        $app = JFactory::getApplication();

        $checked_ids = WDFInput::get_checked_ids();
        if (count($checked_ids) != 1) {
            $app->enqueueMessage(WDFText::get('MSG_CHOOSE_ONE_ITEM'), 'error');
            WDFHelper::redirect();
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $checked_id = $checked_ids[0];
        $table_name = '#__ecommercewd_' . WDFInput::get_controller();
        $failed = false;

        // set default = 1 for checked item
        $query->clear();
        $query->update($table_name);
        $query->set($db->quoteName('default') . ' = 1');
        $query->where('id = ' . $checked_id);
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            $failed = true;
            echo $db->getErrorMsg();
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_UPDATE_DEFAULT_ITEM'), 'error');
        }

        // set default = 0 for others
        if ($failed == false) {
            $query->clear();
            $query->update($table_name);
            $query->set($db->quoteName('default') . ' = 0');
            $query->where('id != ' . $checked_id);
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                $failed = true;
                echo $db->getErrorMsg();
                $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_UPDATE_DEFAULT_ITEM'), 'error');
            }
        }

        WDFHelper::redirect();
    }

    public function publish() {
        WDFDb::set_checked_rows_data('', 'published', 1);
        WDFHelper::redirect();
    }

    public function unpublish() {
        WDFDb::set_checked_rows_data('', 'published', 0);
        WDFHelper::redirect();
    }

    public function remove() {
        WDFDb::remove_checked_rows();
        WDFHelper::redirect();
    }

    public function remove_keep_default() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();

        $ids = WDFInput::get_checked_ids();

        // prevent from removing default item
        $contain_default_items = false;
        $default_item_rows = WDFDb::get_rows('', $db->quoteName('default') . ' = 1');
        foreach ($default_item_rows as $default_item_row) {
            $index_of_default_item_id = array_search($default_item_row->id, $ids);
            if ($index_of_default_item_id !== false) {
                $contain_default_items = true;
                unset($ids[$index_of_default_item_id]);
                $ids = array_values($ids);
            }
        }

        if ($contain_default_items == true) {
            $app->enqueueMessage(WDFText::get('MSG_YOU_CANT_DELETE_DEFAULT_ITEM'), 'warning');
        }

        // remove items
        if ((empty($ids) == false) && (WDFDb::remove_rows('', $ids) == false)) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_REMOVE_ITEMS'), 'error');
        }

        WDFHelper::redirect();
    }

    public function remove_keep_default_and_basic() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();

        $ids = WDFInput::get_checked_ids();

        // prevent from removing default item
        $contain_default_items = false;
        $default_item_rows = WDFDb::get_rows('', $db->quoteName('default') . ' = 1');
        foreach ($default_item_rows as $default_item_row) {
            $index_of_default_item_id = array_search($default_item_row->id, $ids);
            if ($index_of_default_item_id !== false) {
                $contain_default_items = true;
                unset($ids[$index_of_default_item_id]);
                $ids = array_values($ids);
            }
        }

        if ($contain_default_items == true) {
            $app->enqueueMessage(WDFText::get('MSG_YOU_CANT_DELETE_DEFAULT_ITEM'), 'warning');
        }

        // prevent from removing basic item
        $contain_basic_items = false;
        $basic_item_rows = WDFDb::get_rows('', $db->quoteName('basic') . ' = 1');
        foreach ($basic_item_rows as $basic_item_row) {
            $index_of_basic_item_id = array_search($basic_item_row->id, $ids);
            if ($index_of_basic_item_id !== false) {
                $contain_basic_items = true;
                unset($ids[$index_of_basic_item_id]);
                $ids = array_values($ids);
            }
        }

        if ($contain_basic_items == true) {
            $app->enqueueMessage(WDFText::get('MSG_YOU_CANT_DELETE_BASIC_ITEM'), 'warning');
        }

        // remove items
        if ((empty($ids) == false) && (WDFDb::remove_rows('', $ids) == false)) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_REMOVE_ITEM'), 'error');
        }

        WDFHelper::redirect();
    }

    public function save_order() {	
		WDFDb::save_ordering();
    }

    public function apply() {		
        $row = $this->store_input_in_row();
        WDFHelper::redirect('', 'edit', $row->id, '', WDFText::get('MSG_CHANGES_SAVED'));
    }

    public function save() {
        $this->store_input_in_row();
        WDFHelper::redirect('', '', '', '', WDFText::get('MSG_ITEM_SAVED'));
    }

    public function save2new() {
        $this->store_input_in_row();
        WDFHelper::redirect('', 'add', '', '', WDFText::get('MSG_CHANGES_SAVED'));
    }

    public function cancel() {
        WDFHelper::redirect();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function store_input_in_row() {
        $table_name = WDFInput::get_controller();
        $row = WDFDb::get_table_instance($table_name);
		$id = WDFInput::get('id');
		
        if (property_exists($row, 'ordering') && $id == 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->clear();
            $query->select($db->quoteName('ordering'));
            $query->from('#__ecommercewd_' . $table_name);
            $query->order($db->quoteName('ordering') . ' DESC');
            $db->setQuery($query);
            $max_ordering = intval($db->loadResult());

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }

            WDFInput::set('ordering', $max_ordering + 1);
        }
        $row = WDFDb::store_input_in_row();
		
        return $row;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}