<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewProducts extends EcommercewdView {
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
            case 'add_refresh':
            case 'edit':
            case 'edit_refresh':
                $db = JFactory::getDbo();
                $this->_layout = 'edit';
                $this->default_currency_row = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');
                $this->row = $model->get_row();
				$this->lists = $model->get_lists();
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
            case 'add_refresh':
                JToolBarHelper::title(WDFText::get('ADD_PRODUCT'), 'spidershop_products.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            case 'edit':
            case 'edit_refresh':
                JToolBarHelper::title(WDFText::get('EDIT_PRODUCT'), 'spidershop_products.png');

                /*JToolBarHelper::custom('view_feedback', 'spidershop_feedback', 'spidershop_feedback', 'Feedback', false);
                JToolBarHelper::custom('view_ratings', 'spidershop_ratings', 'spidershop_ratings', 'Ratings', false);
                JToolBarHelper::divider();*/
                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            default:
                JToolBarHelper::title(WDFText::get('PRODUCTS'), 'spidershop_products.png');

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
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}