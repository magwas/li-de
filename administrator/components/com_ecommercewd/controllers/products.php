<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerProducts extends EcommercewdController {
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
    public function remove() {
        $this->remove_feedback_and_ratings(WDFInput::get_checked_ids());
        $this->remove_parameters_and_tags(WDFInput::get_checked_ids());
        $this->remove_pages(WDFInput::get_checked_ids());
        $this->remove_shipping_methods(WDFInput::get_checked_ids());

        parent::remove();
    }

    public function view_feedback() {
        WDFHelper::redirect('feedback', '', '', 'search_product_id=' . WDFInput::get('id'));
    }

    public function view_ratings() {
        WDFHelper::redirect('ratings', '', '', 'search_product_id=' . WDFInput::get('id'));
    }
	
	public function apply() {		
        $row = $this->store_input_in_row();
        WDFHelper::redirect('', 'edit', $row->id, 'tab_index='.WDFInput::get('tab_index'), WDFText::get('MSG_CHANGES_SAVED'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function store_input_in_row() {
        $this->validate_save_data();	
        $row = parent::store_input_in_row();
        $this->save_parameters_and_tags($row->id);
        $this->save_pages($row->id);
        $this->save_shipping_methods($row->id);

        return $row;
    }
	

    private function remove_feedback_and_ratings($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_feedback');
        $query->where('product_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_ratings');
        $query->where('product_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function remove_parameters_and_tags($row_ids) {
        if (is_array($row_ids) == false) {
            $row_ids = array($row_ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productparameters');
        $query->where('product_id IN (' . implode(',', $row_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_producttags');
        $query->where('product_id IN (' . implode(',', $row_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function remove_pages($row_ids) {
        if (is_array($row_ids) == false) {
            $row_ids = array($row_ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productpages');
        $query->where('product_id IN (' . implode(',', $row_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function remove_shipping_methods($row_ids) {
        if (is_array($row_ids) == false) {
            $row_ids = array($row_ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productshippingmethods');
        $query->where('product_id IN (' . implode(',', $row_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function validate_save_data() {
        $db = JFactory::getDbo();

        $self_id = WDFInput::get('id');

        // alias
        $alias = trim(WDFInput::get('alias', ''));
        // If the alias field is empty, set it to the title.
        if (empty($alias) == true) {
            $alias = WDFInput::get('name', '');
        }

        // make the alias URL safe.
        $alias = JApplication::stringURLSafe($alias);
        if (trim(str_replace('-', '', $alias)) == '') {
            $this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
        }

        // get unique alias
        $row_product = WDFDb::get_row('products', array('id != ' . $self_id, $db->quoteName('alias') . ' = ' . $db->quote($alias)));
        if ($row_product->id != 0) {
            $i = 2;
            do {
                $new_alias = $alias . '-' . $i++;
                $row_product = WDFDb::get_row('products', array('id != ' . $self_id, $db->quoteName('alias') . ' = ' . $db->quote($new_alias)));
            } while ($row_product->id != 0);
            $alias = $new_alias;
        }

        WDFInput::set('alias', $alias);


        // checkbox
        $this->prepare_checkboxes_for_save();

        // date added
        $cur_date = JFactory::getDate();
		if( WDFInput::get('date_added') == ''){
			WDFInput::set('date_added', $cur_date->toSql());
		}	
    }
	

    private function save_parameters_and_tags($row_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $this->remove_parameters_and_tags($row_id);

        $parameters = WDFJson::decode(WDFInput::get('parameters'));
        if (empty($parameters) == false) {
            $ar_values = array();
            for ($i = 0; $i < count($parameters); $i++) {
                $parameter = $parameters[$i];
                $parameter_id = $parameter->id;
                $parameter_values = $parameter->values;
                $parameter_non_empty_values = array();
                for ($j = 0; $j < count($parameter_values); $j++) {
                    $parameter = WDFJson::decode($parameter_values[$j]);
                    $parameter_value = $parameter->value;
                    if (($parameter_value != '') && (in_array($parameter_value, $parameter_non_empty_values) == false)) {
                        $parameter_non_empty_values[] = $parameter;
                    }
                }
                if (empty($parameter_non_empty_values) == false) {
                    for ($j = 0; $j < count($parameter_non_empty_values); $j++) {
                        $parameter_value = $parameter_non_empty_values[$j]->value;
                        $parameter_value_price = $parameter_non_empty_values[$j]->price;
                        $ar_values[] = $db->quote($row_id) . ', ' . $db->quote($parameter_id) . ', ' . $db->quote($parameter_value) . ', ' . $db->quote($parameter_value_price);
                    }
                } else {
                    $ar_values[] = $db->quote($row_id) . ', ' . $db->quote($parameter_id) . ', "" , ""';
                }
            }

            $query->clear();
            $query->insert('#__ecommercewd_productparameters');
            $columns = array('product_id', 'parameter_id', 'parameter_value', 'parameter_value_price');
            $query->columns($columns);
            foreach ($ar_values as $values) {
                $query->values($values);
            }
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }


        $tag_ids = WDFJson::decode(WDFInput::get('tag_ids'));
        if (count($tag_ids) > 0) {
            $ar_values = array();
            for ($i = 0; $i < count($tag_ids); $i++) {
                $tag_id = $tag_ids[$i];
                array_push($ar_values, $db->quote($row_id) . ', ' . $db->quote($tag_id));
            }

            $query->clear();
            $query->insert('#__ecommercewd_producttags');
            $columns = array('product_id, tag_id');
            $query->columns($columns);
            foreach ($ar_values as $values) {
                $query->values($values);
            }
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }
    }

    private function save_pages($row_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $this->remove_pages($row_id);

        $page_ids = WDFInput::get_array('page_ids', ',');
        if (empty($page_ids) == false) {
            $ar_values = array();
            for ($i = 0; $i < count($page_ids); $i++) {
                $page_id = $page_ids[$i];
                array_push($ar_values, $db->quote($row_id) . ', ' . $db->quote($page_id));
            }

            $query->clear();
            $query->insert('#__ecommercewd_productpages');
            $columns = array('product_id', 'page_id');
            $query->columns($columns);
            foreach ($ar_values as $values) {
                $query->values($values);
            }
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }
    }

    private function save_shipping_methods($row_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $this->remove_shipping_methods($row_id);

        $shipping_method_ids = WDFInput::get_array('shipping_method_ids', ',');
        if (empty($shipping_method_ids) == false) {
            $ar_values = array();
            for ($i = 0; $i < count($shipping_method_ids); $i++) {
                $shipping_method_id = $shipping_method_ids[$i];
                array_push($ar_values, $db->quote($row_id) . ', ' . $db->quote($shipping_method_id));
            }

            $query->clear();
            $query->insert('#__ecommercewd_productshippingmethods');
            $columns = array('product_id', 'shipping_method_id');
            $query->columns($columns);
            foreach ($ar_values as $values) {
                $query->values($values);
            }
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }
    }

    private function prepare_checkboxes_for_save() {
        $checkboxes = array('unlimited');

        foreach ($checkboxes as $checkbox) {
            WDFInput::set($checkbox, WDFInput::get($checkbox, 0, 'int'));
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}