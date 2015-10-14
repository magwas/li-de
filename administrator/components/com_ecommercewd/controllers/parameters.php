<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerParameters extends EcommercewdController {
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
    public function set_required_on() {
        $app = JFactory::getApplication();

        if (WDFDb::set_checked_rows_data('', 'required', 1) == false) {
            $app->enqueueMessage(WDFText::get('FAILED_TO_SAVE_CHANGES'), 'error');
        }

        WDFHelper::redirect();
    }

    public function set_required_off() {
        $app = JFactory::getApplication();

        if (WDFDb::set_checked_rows_data('', 'required', 0) == false) {
            $app->enqueueMessage(WDFText::get('FAILED_TO_SAVE_CHANGES'), 'error');
        }

        WDFHelper::redirect();
    }

    public function remove() {
        $this->remove_category_parameters(WDFInput::get_checked_ids());
        $this->remove_product_parameters(WDFInput::get_checked_ids());

        parent::remove();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
	protected function store_input_in_row(){
		$parameter_name = str_replace(array('.',':'),'',WDFInput::get('name'));	
		WDFInput::set('name',$parameter_name);
		$row = parent::store_input_in_row();	
		return $row;
	}
	
    private function remove_category_parameters($checked_ids) {
        if (empty($checked_ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_categoryparameters');
        $query->where('parameter_id IN (' . implode(',', $checked_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return true;
    }

    private function remove_product_parameters($checked_ids) {
        if (empty($checked_ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productparameters');
        $query->where('parameter_id IN (' . implode(',', $checked_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return true;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}