<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdModelBulkactions extends EcommercewdModel {
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

	  public function get_lists()
	  {
		$model_options = WDFHelper::get_model('options');
		$options = $model_options->get_options();
		$initial_values = $options['initial_values'];
		$lists = array();
		// shipping data fields
		$radio_list_shipping_data_field = array();
		$radio_list_shipping_data_field[] = (object)array('value' => '0', 'text' => WDFText::get('NO'));
		$radio_list_shipping_data_field[] = (object)array('value' => '1', 'text' => WDFText::get('YES'));			
		//$radio_list_shipping_data_field[] = (object)array('value' => $initial_values['checkout_enable_shipping'], 'text' => WDFText::get('USE_DEFAULT'));
		$radio_list_shipping_data_field[] = (object)array('value' => '2', 'text' => WDFText::get('USE_GLOBAL'));
		
		$lists["list_shipping_data_field"] = $radio_list_shipping_data_field;
			
			
			return $lists;
	  
	  }

    public function get_rows() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
		
		$row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');
		
        $query->clear();
        $this->add_rows_query_select($query);
        $this->add_rows_query_from($query);
        $this->add_rows_query_where($query);
        $this->add_rows_query_order($query);
        $pagination = $this->get_rows_pagination();

        $db->setQuery($query, $pagination->limitstart, $pagination->limit);

        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }

        // additional data
        foreach ($rows as $row) {
            // view and edit urls
            $com_name = WDFHelper::get_com_name();
            $controller = WDFInput::get_controller();           
            $row->edit_url = 'index.php?option=com_' . $com_name . '&controller=' . $controller . '&task=edit' . '&boxcheckeds=' . $row->id;
            // amount in stock
            if ($row->unlimited == 1) {
                $row->amount_in_stock = WDFText::get('UNLIMITED');
            }
            // price text
            $row->price_text = $row->price . ' ' . $row_default_currency->code;		
		}

        return $rows;
		
    }
	
	public function get_checked_products(){
		$checked_ids = WDFInput::get("boxcheckeds");
		$product_ids = explode(',', $checked_ids);
		
		$checked_products = array();
		foreach($product_ids as $product_id){
			$row = WDFDb::get_row('products', array('id = '.$product_id));
			$checked_products[$row->id] = $row->name;
		}
	
		return $checked_products;
	}
	

	public function get_product_tags($product_id) {
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
		$query->select('tag_id');
		$query->from('#__ecommercewd_producttags');
		$query->where('product_id = ' . $product_id);

        $db->setQuery($query);

        $tags = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }
		
		return  $tags;
	}
	
	public function get_product_pages($product_id) {
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
		$query->select('page_id');
		$query->from('#__ecommercewd_productpages');
		$query->where('product_id = ' . $product_id);

        $db->setQuery($query);

        $pages = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }
		
		return  $pages;
	}
	
	public function get_product_shipping_methods($product_id) {
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
		$query->select('shipping_method_id');
		$query->from('#__ecommercewd_productshippingmethods');
		$query->where('product_id = ' . $product_id);

        $db->setQuery($query);

        $shipping_methods = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }
		
		return  $shipping_methods;
	}	
	
	public function get_product_parameters($product_id) {
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $parameters_map = array();

        $query->clear();
        $query->select('T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
		$query->select('T_PARAMETERS.type_id');
        $query->select('T_PARAMETER_TYPES.name AS type_name');
        $query->select('T_PRODUCT_PARAMETERS.parameter_value AS value');
		$query->select('T_PRODUCT_PARAMETERS.parameter_value_price AS price');
        $query->select('T_PRODUCT_PARAMETERS.productparameters_id AS productparameters_id');
        $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
        $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
		$query->leftJoin('#__ecommercewd_parametertypes AS T_PARAMETER_TYPES ON T_PARAMETERS.type_id = T_PARAMETER_TYPES.id');
        $query->where('product_id = ' . $product_id);
        $query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
        $db->setQuery($query);
        $parameter_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        foreach ($parameter_rows as $parameter_row) {
            $parameter_id = $parameter_row->id;
            if (isset($parameters_map[$parameter_id])) {
                $param_value = array();
                $param_value['value'] = $parameter_row->value;
                $param_value['price'] = $parameter_row->price;
                $parameters_map[$parameter_id]->values[] = $param_value;
            } else {
                $param_value = array();
                $param_value['value'] = $parameter_row->value;
                $param_value['price'] = $parameter_row->price;
                $parameter_row->values[] = $param_value;
                $parameters_map[$parameter_id] = $parameter_row;
            }
        }

        $parameters = array();
        foreach ($parameters_map as $parameter) {
            if (empty($parameter->values) == true) {
                $parameter->values[] = '';
            }
            $parameters[] = $parameter;
        }

        return $parameters;
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

        // category id
        $filter_item = new stdClass();
        $filter_item->type = 'uint';
        $filter_item->name = 'category_id';
        $filter_item->values_list = WDFDb::get_list('categories', 'id', 'name', array(), '', array(array('id' => -1, 'name' => '-' . WDFText::get('ANY_CATEGORY') . '-')));
        $filter_item->values_list_prop_value = 'id';
        $filter_item->values_list_prop_text = 'name';
        $filter_item->default_value = -1;
        $filter_item->operator = '=';
        $filter_item->input_type = 'select';
        $filter_item->input_label = WDFText::get('CATEGORY');
        $filter_item->input_name = 'search_category_id';
        $filter_items[$filter_item->name] = $filter_item;

        // manufacturer id
        $filter_item = new stdClass();
        $filter_item->type = 'uint';
        $filter_item->name = 'manufacturer_id';
        $filter_item->values_list = WDFDb::get_list('manufacturers', 'id', 'name', array(), '', array(array('id' => -1, 'name' => '-' . WDFText::get('ANY_MANUFACTURER') . '-')));
        $filter_item->values_list_prop_value = 'id';
        $filter_item->values_list_prop_text = 'name';
        $filter_item->default_value = -1;
        $filter_item->operator = '=';
        $filter_item->input_type = 'select';
        $filter_item->input_label = WDFText::get('MANUFACTURER');
        $filter_item->input_name = 'search_manufacturer_id';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    protected function add_rows_query_select(JDatabaseQuery $query) {
        $query->select('#__ecommercewd_products.*');
        $query->select('#__ecommercewd_products.price AS price');
        $query->select('IFNULL(T_CATEGORIES.name, "' . WDFText::get('ROOT_CATEGORY') . '") AS category_name');
        $query->select('T_MANUFACTURERS.name AS manufacturer_name');
        $query->select('T_LABELS.name AS label_name');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
		$query->from('#__ecommercewd_products');
        $query->leftJoin('#__ecommercewd_categories AS T_CATEGORIES ON #__ecommercewd_products.category_id = T_CATEGORIES.id');
        $query->leftJoin('#__ecommercewd_manufacturers AS T_MANUFACTURERS ON #__ecommercewd_products.manufacturer_id = T_MANUFACTURERS.id');
        $query->leftJoin('#__ecommercewd_labels AS T_LABELS ON #__ecommercewd_products.label_id = T_LABELS.id');
    }

    protected function add_rows_query_order(JDatabaseQuery $query) {
        $sort_data = $this->get_rows_sort_data();

        $query->order(($sort_data['sort_by']) . ' ' . $sort_data['sort_order']);
    }
    protected function add_rows_query_where_filters(JDatabaseQuery $query) {
        if ($this->rows_filter_conditions === null) {
            $db = JFactory::getDbo();

            $filter_conditions = array();
            foreach ($this->rows_filter_items as $filter_item) {				
                if ($filter_item->value !== null) {
                    $operator = strtolower($filter_item->operator);
                    switch ($operator) {
                        case 'like':
                            $filter_condition = 'LOWER(#__ecommercewd_products.' . $filter_item->name . ') LIKE ' . $db->quote('%' . $filter_item->value . '%');
                            break;
                        default:
                            $filter_name = $filter_item->name;
                            $filter_value = $filter_item->value;

                            if ($filter_item->input_type == 'date') {
                                if ($operator == '>=') {
                                    if (substr($filter_name, -5) == '_from') {
                                        $filter_name = substr($filter_name, 0, -5);
                                    }
                                    $filter_value .= ' 00:00:00';
                                } else if ($operator == '<=') {
                                    if (substr($filter_name, -3) == '_to') {
                                        $filter_name = substr($filter_name, 0, -3);
                                    }
                                    $filter_value .= ' 23:59:59';
                                }
                            }

                            $filter_condition = '#__ecommercewd_products.' . $filter_name . ' ' . $operator . ' ' . $db->quote($filter_value);
                            break;
                    }
                    $filter_conditions[] = $filter_condition;
					
                }
            }
			
            $this->rows_filter_conditions = $filter_conditions;
        }

        foreach ($this->rows_filter_conditions as $filter_condition) {
            $query->where($filter_condition);
        }
		
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}