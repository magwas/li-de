<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewUsers extends EcommercewdView {
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
            case 'explore':
                $this->_layout = 'explore';
                $this->filter_items = $model->get_rows_filter_items();
                $this->sort_data = $model->get_rows_sort_data();
                $this->rows = $model->get_rows();
                break;
            case 'view':
                $this->_layout = 'view';
                $this->lists = $model->get_view_lists();
                $this->row = $model->get_row();
                break;
            case 'edit':
                $this->_layout = 'edit';
                $this->lists = $model->get_edit_lists();
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
            case 'view':
                JToolBarHelper::title(WDFText::get('VIEW_USER_DATA'), 'spidershop_users.png');

                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::cancel('cancel', WDFText::get('CLOSE'));
                break;
            case 'edit':
                JToolBarHelper::title(WDFText::get('EDIT_USER_DATA'), 'spidershop_users.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            default:
                JToolBarHelper::title(WDFText::get('USERS'), 'spidershop_users.png');

                JToolBarHelper::custom('view', 'preview', '', WDFText::get('VIEW'));
                JToolBarHelper::editList();
                break;
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}