<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewOrders extends EcommercewdView {
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

        $this->lists = $model->get_lists();

        $task = WDFInput::get_task();
        switch ($task) {
            case 'view':
                $this->_layout = 'view';
                $this->row = $model->get_row();
                break;
            case 'edit':
                $this->_layout = 'edit';
                $this->row = $model->get_row();
                break;
            case 'paymentdata':
                $this->_layout = 'paymentdata';
                $this->row = $model->get_row();
                break;				
			case 'printorder':					
				if(WDFInput::get('boxchecked')){
					$id = WDFInput::get('boxchecked');
				}	
				else{
					$id = WDFInput::get('id');
				}				
				$this->row  = $model->get_row($id);
				$this->_layout= 'printorder';
				WDFInput::set('tmpl','component');
				break;
				
			case 'printorderbulk':
				$ids = WDFInput::get_checked_ids();		
				$id =  reset($ids);			
				$this->row  = $model->get_row($id);
              	$this->_layout= 'printorder';	
				WDFInput::set('tmpl','component');				
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
		$where_query = array( " published ='1' AND name='ecommercewd_pdfinvoice'" );
		$tools = WDFTool::get_tools( $where_query );
        switch (WDFInput::get_task()) {
            case 'view':
                JToolBarHelper::title(WDFText::get('VIEW_ORDER'), 'spidershop_orders.png');
				JToolBarHelper::custom('printorder', 'print', 'print', WDFText::get('PRINT_ORDER'),false);
				if(empty($tools) == false){
					JToolBarHelper::custom('pdfinvoice', 'download', 'download', WDFText::get('PDFINVOICE'),false);
				}
                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::cancel('cancel', WDFText::get('CLOSE'));
                break;
            case 'edit':
                JToolBarHelper::title(WDFText::get('EDIT_ORDER'), 'spidershop_orders.png');
				JToolBarHelper::custom('printorder', 'print', 'print', WDFText::get('PRINT_ORDER'),false);
				if(empty($tools) == false){
					JToolBarHelper::custom('pdfinvoice', 'download', 'download', WDFText::get('PDFINVOICE'),false);
				}
                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
			case 'paymentdata':
				JToolBarHelper::title(WDFText::get('ORDERS'), 'spidershop_orders.png');
				JToolBarHelper::cancel('cancel', WDFText::get('CLOSE'));
				break;
            default:
                JToolBarHelper::title(WDFText::get('ORDERS'), 'spidershop_orders.png');
				JToolBarHelper::custom('printorderbulk', 'print', 'print', WDFText::get('PRINT_ORDER'));
				if(empty($tools) == false){
					JToolBarHelper::custom('pdfinvoicebulk', 'download', 'download', WDFText::get('PDFINVOICE'));
				}
                JToolBarHelper::custom('view', 'preview', '', WDFText::get('VIEW'));
                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::deleteList(WDFText::get('MSG_DELETE_CONFIRM'));
                break;
        }
    }
	

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}