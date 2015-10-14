<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerBulkactions extends EcommercewdController {
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

    public function save() {
		$db = JFactory::getDbo();
        $product_ids = WDFInput::get("boxcheckeds");
		$product_ids = explode(',', $product_ids);
		$editable_fields = WDFInput::get('edit_fields',array(), 'array');
		if(count($product_ids) == 1 && $product_ids[0] == ""){
			 WDFHelper::redirect('', '', '', '', WDFText::get('MSG_NO_ITEMS_TO_EDIT'),'error');
		}
		foreach($product_ids as $id){		
			$row = WDFDb::get_row_by_id('products' , $id );
			if( in_array('ch_category',$editable_fields ) == true ){
				$row->category_id = WDFInput::get("category_id");
			}
			if( in_array('ch_manufacturer',$editable_fields ) == true ){
				$row->manufacturer_id = WDFInput::get("manufacturer_id");
			}
			if( in_array('ch_discount',$editable_fields ) == true ){
				$row->discount_id = WDFInput::get("discount_id");
			}		
			if( in_array('ch_tax',$editable_fields ) == true ){
				$row->tax_id = WDFInput::get("tax_id");
			}	
			if( in_array('ch_amount_in_stock',$editable_fields ) == true ){			
				$row->amount_in_stock = WDFInput::get("amount_in_stock");
				$row->unlimited =  WDFInput::get("unlimited",0);			
			}		
			if( in_array('ch_label',$editable_fields ) == true ){
				$row->label_id = WDFInput::get("label_id");
			}
				
			if( in_array('ch_pages',$editable_fields ) == true ){
				$this->save_pages($id);
			}	
			if( in_array('ch_shipping_methods',$editable_fields ) == true ){
				$row->enable_shipping = WDFInput::get("enable_shipping");
				$this->save_shipping_methods($id);				
			}	
			if( in_array('ch_parameters',$editable_fields ) == true ){
				$this->save_parameters($id);
			}
			if( in_array('ch_tags',$editable_fields ) == true ){
				$this->save_tags($id);
			}			
			$row->store();					
			
		}
        WDFHelper::redirect('', '', '', '', WDFText::get('MSG_ITEM_SAVED'));
    }
	
	public function save_order() {	
		WDFDb::save_ordering('products');
    }
	
	public function add_category_parameters_tags(){
		$category_id = WDFInput::get('category_id');
		$category_model = WDFHelper::get_model('categories');
		$category_parameterers = $category_model->get_category_parameters($category_id,true);
		$category_tags = $category_model->get_category_tags($category_id,true);
		
		$category_tags_parameters = array();
		$category_tags_parameters['parameters'] = $category_parameterers;
		$category_tags_parameters['tags'] = $category_tags;
		
		echo WDFJson::encode($category_tags_parameters) ;
		die();
	
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////

	private function remove_parameters($row_id) {
 
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productparameters');
        $query->where('product_id = '.$row_id);
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }
	
	
	private function remove_tags($row_id) {
    
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_producttags');
        $query->where('product_id ='. $row_id );
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }
	
	
    private function remove_pages($row_id) {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productpages');
        $query->where('product_id = '. $row_id );
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function remove_shipping_methods($row_id) {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productshippingmethods');
        $query->where('product_id = '. $row_id );
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function save_parameters($row_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $parameters_obj = WDFJson::decode(WDFInput::get('parameters'));
		$parameters = array();
		
		foreach($parameters_obj as $parameter){
			$item = array(); 
			$item['id'] = $parameter->id;
			$item['type_id'] = $parameter->type_id;
			$item['values'] = $parameter->values;
			$parameters[] = $item;			
		}

		if(WDFInput::get('delete_parameters') != 1){		
			$model = WDFHelper::get_model("bulkactions");
			$product_parameters = $model->get_product_parameters($row_id);		
			$parameters = array_merge_recursive($parameters, $product_parameters);
			$parameters = array_map("unserialize", array_unique(array_map("serialize", $parameters)));
			$parameters = array_values($parameters);
		}
		
		$this->remove_parameters($row_id);
		
        if (empty($parameters) == false) {
            $ar_values = array();
            for ($i = 0; $i < count($parameters); $i++) {
                $parameter = $parameters[$i];
				
                $parameter_id = $parameter['id'];
                $parameter_values = $parameter['values'];
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
    }
	
	private function save_tags($row_id){
	    $db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$tag_ids = WDFJson::decode(WDFInput::get('tag_ids'));	
		
		if(WDFInput::get('delete_tags') != 1){		
			$model = WDFHelper::get_model("bulkactions");
			$product_tags = $model->get_product_tags($row_id);		
			$tag_ids = array_merge($tag_ids, $product_tags);
			$tag_ids = array_unique($tag_ids);
			$tag_ids = array_values($tag_ids);
		}
	
		$this->remove_tags($row_id);
		
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

        $page_ids = WDFInput::get_array('page_ids', ',');
		
		if(WDFInput::get('delete_pages') != 1){		
			$model = WDFHelper::get_model("bulkactions");
			$product_pages = $model->get_product_pages($row_id);		
			$page_ids = array_merge($page_ids, $product_pages);
			$page_ids = array_unique($page_ids);
			$page_ids = array_values($page_ids);
		}
		
		$this->remove_pages($row_id);
		
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

        $shipping_method_ids = WDFInput::get_array('shipping_method_ids', ',');
		
		if(WDFInput::get('delete_shipping_methods') != 1){		
			$model = WDFHelper::get_model("bulkactions");
			$product_shipping_methods = $model->get_product_shipping_methods($row_id);		
			$shipping_method_ids = array_merge($shipping_method_ids, $product_shipping_methods);
			$shipping_method_ids = array_unique($shipping_method_ids);
			$shipping_method_ids = array_values($shipping_method_ids);
		}
		
		$this->remove_shipping_methods($row_id);
		
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
	
	private function object_to_array($data) {
		if ((! is_array($data)) and (! is_object($data))) 
			return false; //$data;

		$result = array();

		$data = (array) $data;
		foreach ($data as $key => $value) {
			if (is_object($value)) $value = (array) $value;
			if (is_array($value)) 
			$result[$key] = $this->object_to_array($value);
			else
				$result[$key] = $value;
		}

		return $result;
	}

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}