<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewReports extends EcommercewdView {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
	public $row_default_currency;
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
	
    public function display($tpl = null) {
       
        $model = $this->getModel();
		$model_options = WDFHelper::get_model('options');
		$options = $model_options->get_options();	
		$initial_values = $options['initial_values'];
		$db = JFactory::getDbo();
       
		$decimals = $options['initial_values']['option_show_decimals'] == 1 ? 2 : 0;
		$this->decimals = $decimals;
		
		$this->report_data = $model->get_report_view_data();
		$this->row_default_currency = $this->report_data->currency;
		$this->create_toolbar();
        parent::display($tpl);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function create_toolbar() {
        JToolBarHelper::title(WDFText::get('REPORTS'), 'spidershop_reports.png');
		$where_query = array( " published ='1' AND name='ecommercewd_exportreports'" );
		$tools = WDFTool::get_tools( $where_query );
		
		if($this->row_default_currency != NULL && empty($tools) == false){
			JToolBarHelper::custom('export_report', 'print', 'print', WDFText::get('EXPORT_REPORT'),false);
		}
	

    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}