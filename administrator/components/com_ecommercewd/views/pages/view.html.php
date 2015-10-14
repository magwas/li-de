<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewPages extends EcommercewdView {
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
                $this->pagination = $model->get_rows_pagination();
                $this->rows = $model->get_rows();
                break;
            case 'add':
            case 'edit':
                $this->_layout = 'edit';
                $this->row = $model->get_row();
                break;
            case 'explore_articles':
                $this->_layout = 'explore_articles';
                $table_data = $model->get_articles_table_data();
                $this->filter_items = $table_data['filter_items'];
                $this->sort_data = $table_data['sort_data'];
                $this->pagination = $table_data['pagination'];
                $this->rows = $table_data['rows'];
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
    // Private Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function create_toolbar() {
        switch (WDFInput::get_task()) {
            case 'add':
                JToolBarHelper::title(WDFText::get('ADD_PAGE'), 'spidershop_pages.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            case 'edit':
                JToolBarHelper::title(WDFText::get('EDIT_PAGES'), 'spidershop_pages.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            default:
                JToolBarHelper::title(WDFText::get('LICENSING'), 'spidershop_pages.png');

                JToolBarHelper::addNew();
                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::deleteList(WDFText::get('MSG_DELETE_CONFIRM'));
                JToolBarHelper::divider();
                JToolBarHelper::publishList();
                JToolBarHelper::unpublishList();
                break;
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}