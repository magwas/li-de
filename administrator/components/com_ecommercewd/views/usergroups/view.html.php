<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewUsergroups extends EcommercewdView {
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
    public function display($tpl = null) {
        $this->create_toolbar();

        $model = $this->getModel();

        $task = WDFInput::get_task();
        switch ($task) {
            case 'add':
            case 'edit':
                $this->_layout = 'edit';
                $this->lists = $model->get_lists();
                $this->row = $model->get_row();
                break;
            default:
                $this->filter_items = $model->get_rows_filter_items();
                $this->sort_data = $model->get_rows_sort_data();
                $this->pagination = $model->get_rows_pagination();
                $this->rows = $model->get_rows();
                break;
        }

        parent::display($tpl);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function create_toolbar() {
        switch (WDFInput::get_task()) {
            case 'add':
                JToolBarHelper::title(WDFText::get('ADD_USER_GROUP'), 'spidershop_usergroups.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            case 'edit':
                JToolBarHelper::title(WDFText::get('EDIT_USER_GROUP'), 'spidershop_usergroups.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            default:
                JToolBarHelper::title(WDFText::get('USERGROUPS'), 'spidershop_usergroups.png');

                JToolBarHelper::addNew();
                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::deleteList(WDFText::get('MSG_DELETE_CONFIRM'), 'remove_keep_default');
                JToolBarHelper::divider();
                JToolBarHelper::makeDefault('make_default');
                break;
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}