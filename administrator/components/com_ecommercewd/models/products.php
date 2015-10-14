<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdModelProducts extends EcommercewdModel {
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
    public function get_row($id = 0) {
        $is_refresh = false;

        $task = WDFInput::get_task();
        switch ($task) {
            case 'add_refresh':
            case 'edit_refresh':
                $is_refresh = true;
                break;
        }
		
		$row_for_dimensions = parent::get_row($id);
        $row = $is_refresh == true ? WDFDb::get_row_from_input('') : parent::get_row($id);

        // additional data
        $model_categories = WDFHelper::get_model('categories');
		
		// dimensions
		$dimensions = explode('x', $row->dimensions);
	
		$row->dimensions_length = isset($dimensions[0]) == true ? $dimensions[0] : "";
		$row->dimensions_width = isset($dimensions[1])== true ? $dimensions[1] : "";
		$row->dimensions_height = isset($dimensions[2])== true ? $dimensions[2] : "";
		$row->_dimensions = $row_for_dimensions->dimensions;
		

        // images
        if ($row->images == null) {
            $row->images = WDFJson::encode(array());
        }
		
		 // videos
        if ($row->videos == null) {
            $row->videos = WDFJson::encode(array());
        }

        // category name
        $row_category = WDFDb::get_row_by_id('categories', $row->category_id);
        $row->category_name = $row_category->name != null ? $row_category->name : WDFText::get('ROOT_CATEGORY');

        // manufacturer name
        $row_manufacturer = WDFDb::get_row_by_id('manufacturers', $row->manufacturer_id);
        $row->manufacturer_id = $row_manufacturer->name != null ? $row_manufacturer->id : '';
        $row->manufacturer_name = $row_manufacturer->name != null ? $row_manufacturer->name : '';

        // tax data
        $row_tax = WDFDb::get_row_by_id('taxes', $row->tax_id);
        $row->tax_id = $row_tax->id;
        $row->tax_name = $row->tax_id != 0 ? $row_tax->name . ' (' . $row_tax->rate . '%)' : '';
        $row->tax_rate = $row_tax->rate;

        // discount data
        $row_discount = WDFDb::get_row_by_id('discounts', $row->discount_id);
        $row->discount_id = $row_discount->id;
        $row->discount_name = $row->discount_id != 0 ? $row_discount->name . ' (' . $row_discount->rate . '%)' : '';
        $row->discount_rate = $row_discount->rate;

        // label
        $row_label = WDFDb::get_row_by_id('labels', $row->label_id);
        $row->label_id = $row_label->id;
        $row->label_name = $row_label->name;

        // final price
        $row->final_price = ($row->price * (1 - $row->discount_rate / 100)) * (1 + $row->tax_rate / 100);
		
        // page ids and titles
        $page_titles = array();
        $row->page_ids = $is_refresh == true ? WDFInput::get_array('page_ids', ',') : $this->get_product_page_ids($row->id);
        if (empty($row->page_ids) == false) {
            foreach ($row->page_ids as $page_id) {
                $row_page = WDFDb::get_row_by_id('pages', $page_id);
                $page_titles[] = $row_page->title;
            }
        }
        $row->page_titles = implode('&#13;', $page_titles);

        // shipping method ids and names
        $shipping_method_names = array();
        $row->shipping_method_ids = $is_refresh == true ? WDFInput::get_array('shipping_method_ids', ',') : $this->get_product_shipping_method_ids($row->id);
        if (empty($row->shipping_method_ids) == false) {
            foreach ($row->shipping_method_ids as $shipping_method_id) {
                $row_shipping_method = WDFDb::get_row_by_id('shippingmethods', $shipping_method_id);
                $shipping_method_names[] = $row_shipping_method->name;
            }
        }
        $row->shipping_method_names = implode('&#13;', $shipping_method_names);

        // parameters and tags
        if ($is_refresh == true) {
            $row->parameters = $this->get_input_parameters($row->category_id);
            $row->tags = $this->get_input_tags($row->category_id);
        } else {
            $row->parameters = $this->get_product_parameters($row->id, $row->category_id, true);
            $row->tags = $this->get_product_tags($row->id, true);
        }
        $row->category_parameters = $model_categories->get_category_parameters($row->category_id, true);
        $row->category_tags = $model_categories->get_category_tags($row->category_id, true);
		
		$model_options = WDFHelper::get_model('options');
		$options = $model_options->get_options();
		$initial_values = $options['initial_values'];

		$row->enable_shipping = ( WDFInput::get_task() == 'add' ) ? 2 : $row->enable_shipping;
		$row->default_shipping = $initial_values['checkout_enable_shipping'] ;
		
        return $row;
    }

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

        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        $rows = parent::get_rows();

        // additional data
        foreach ($rows as $row) {
            // amount in stock
            if ($row->unlimited == 1) {
                $row->amount_in_stock = WDFText::get('UNLIMITED');
            }

            // price text
            $row->price_text = $row->price . ' ' . $row_default_currency->code;
		
        }

        return $rows;
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
        $query->select($this->current_table_name . '.*');
        $query->select('#__ecommercewd_products.price AS price');
        $query->select('IFNULL(T_CATEGORIES.name, "' . WDFText::get('ROOT_CATEGORY') . '") AS category_name');
        $query->select('T_MANUFACTURERS.name AS manufacturer_name');
        $query->select('T_LABELS.name AS label_name');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        parent::add_rows_query_from($query);

        $query->leftJoin('#__ecommercewd_categories AS T_CATEGORIES ON #__ecommercewd_products.category_id = T_CATEGORIES.id');
        $query->leftJoin('#__ecommercewd_manufacturers AS T_MANUFACTURERS ON #__ecommercewd_products.manufacturer_id = T_MANUFACTURERS.id');
        $query->leftJoin('#__ecommercewd_labels AS T_LABELS ON #__ecommercewd_products.label_id = T_LABELS.id');
    }

    protected function add_rows_query_order(JDatabaseQuery $query) {
        $sort_data = $this->get_rows_sort_data();
        $query->order(($sort_data['sort_by']) . ' ' . $sort_data['sort_order']);
    }

    private function get_product_parameters($product_id, $category_id, $json = false) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $parameters_map = array();

        $category_required_parameters = $this->get_category_required_parmeters($category_id);
        foreach ($category_required_parameters as $category_required_parameter) {
            $category_required_parameter->required = true;
            $category_required_parameter->values = array();
            $parameters_map[$category_required_parameter->id] = $category_required_parameter;
        }

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

        return $json == true ? addslashes(WDFJson::encode($parameters, 256)) : $parameters;
    }
	

    private function get_input_parameters($category_id) {
        $parameters = WDFJson::decode(WDFInput::get('parameters'));
		
		for ($i = 0; $i < count($parameters); $i++) {
            if (count($parameters[$i]->values) != 0) {
                for ($j = 0; $j < count($parameters[$i]->values); $j++) {
                    $param_values = WDFJson::decode($parameters[$i]->values[$j]);
                    $parameters[$i]->obj_values[] = $param_values;
                }
            } else {
                $parameters[$i]->obj_values[] = array();
            }
            $parameters[$i]->values = $parameters[$i]->obj_values;
            unset($parameters[$i]->obj_values);
        }

        $required_parameters = array();

        // insert category required parameters into new array
        $category_required_parameters = $this->get_category_required_parmeters($category_id);
        foreach ($category_required_parameters as $category_required_parameter) {
            $category_required_parameter->required = true;
            $category_required_parameter->values = array('');

            // get required parameter values from request (if their exists)
            for ($i = 0; $i < count($parameters); $i++) {
                $parameter_data = $parameters[$i];

                if ($parameter_data->id == $category_required_parameter->id) {
                    $category_required_parameter->values = $parameter_data->values;
                    unset($parameters[$i]);
                    $parameters = array_values($parameters);
                    break;
                }
            }

            $required_parameters[] = $category_required_parameter;
        }

        // update the rest of parameters(not required parameters) from request
        for ($i = 0; $i < count($parameters); $i++) {
            $parameter_data = $parameters[$i];

            $parameter_row = WDFDb::get_row_by_id('parameters', $parameter_data->id);
            $parameter_data->required = false;
            $parameter_data->name = $parameter_row->name;
        }

        // merge required and not required parameters
        $required_parameters = array_merge($required_parameters, $parameters);

        return addslashes(WDFJson::encode($required_parameters, 256));
    }

    private function get_input_tags() {
        if (empty($tag_ids) == true) {
            return WDFJson::encode(array());
        }

        $tag_ids = WDFJson::decode(WDFInput::get('tag_ids'));
        $tags = WDFDb::get_rows('tags', 'id IN (' . implode(',', $tag_ids) . ')');

        return WDFJson::encode($tags, 256);
    }

    private function get_category_required_parmeters($category_id) {
        if ($category_id == 0) {
            return array();
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('DISTINCT T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
		$query->select('T_PARAMETERS.type_id');
        $query->select('T_PARAMETER_TYPES.name AS type_name');
		$query->select('T_PARAMETERS.default_values');
        $query->from('#__ecommercewd_parameters AS T_PARAMETERS');
        $query->leftJoin('#__ecommercewd_categoryparameters AS T_CATEGORY_PARAMETERS ON T_CATEGORY_PARAMETERS.parameter_id = T_PARAMETERS.id');
        $query->leftJoin('#__ecommercewd_parametertypes AS T_PARAMETER_TYPES ON T_PARAMETERS.type_id = T_PARAMETER_TYPES.id');
		$query->where('T_CATEGORY_PARAMETERS.category_id = ' . $category_id);
        $query->where('T_PARAMETERS.required = 1');
        $query->order('T_CATEGORY_PARAMETERS.categoryparameters_id ASC');
        $db->setQuery($query);
        $category_required_parameter_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $category_required_parameter_rows;
    }

    private function get_product_tags($product_id, $json = false) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('T_TAGS.id');
        $query->select('T_TAGS.name');
        $query->from('#__ecommercewd_producttags AS T_PRODUCT_TAGS');
        $query->leftJoin('#__ecommercewd_tags AS T_TAGS ON T_PRODUCT_TAGS.tag_id = T_TAGS.id');
        $query->where('T_PRODUCT_TAGS.product_id = ' . $product_id);
        $query->order('T_TAGS.ordering ASC');
        $db->setQuery($query);
        $tags = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }

        return $json == true ? addslashes(WDFJson::encode($tags, 256)) : $tags;
    }

    private function get_product_page_ids($product_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('page_id');
        $query->from('#__ecommercewd_productpages');
        $query->where('product_id = ' . $product_id);
        $query->order($db->quote('ordering') . ' ASC');
        $db->setQuery($query);
        $page_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $page_ids;
    }

    private function get_product_shipping_method_ids($product_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('shipping_method_id');
        $query->from('#__ecommercewd_productshippingmethods');
        $query->where('product_id = ' . $product_id);
        $query->order($db->quote('ordering') . ' ASC');
        $db->setQuery($query);
        $shipping_method_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $shipping_method_ids;
    }



	

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}