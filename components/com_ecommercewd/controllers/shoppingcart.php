<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerShoppingcart extends EcommercewdController {
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
    public function add() {
        WDFInput::set('tmpl', 'component');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

		$model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
		
        $j_user = JFactory::getUser();

        $model = WDFHelper::get_model('shoppingcart');

        $failed = false;
		$insert = true;
        $msg = '';
		$order_product_id = 0;

		
        //get product data
        $product_data = array();
        $product_data['id'] = WDFInput::get('product_id', 0, 'int');
        $product_data['count'] = max(1, WDFInput::get('product_count', 1, 'int'));
        $product_parameters = array();
        $input_product_parameters = WDFInput::get_parsed_json('product_parameters_json', array());

        if (empty($input_product_parameters) == false) {
            foreach ($input_product_parameters as $parameter_id => $parameter_value) {
                $product_parameters[intval($parameter_id)] = $parameter_value;
            }
        }
		
        $product_data['parameters'] = $product_parameters;

        $row_product = WDFDb::get_row_by_id('products', $product_data['id']);
		
        if ($row_product->id == 0) {
            $failed = true;
            $msg = WDFText::get('MSG_FAILED_TO_ADD_TO_CART');			
		}
		
        // add product name
        if ($failed == false) {
            $product_data['id'] = $row_product->id;
            $product_data['name'] = $row_product->name;
        }

        //check if user already has this product in cart
        if ($failed == false) {
			$row_product_id_count = new stdClass();
            $row_product_id_count->id = 0;
            $row_product_id_count->product_count = 0;
            $row_product_id_count->product_parameters = '';

            $query->clear();
            $query->select('id');
			$query->select('product_count');
			$query->select('product_parameters');
            $query->from('#__ecommercewd_orderproducts');
            $query->where('order_id = 0');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->where('j_user_id = ' . $j_user->id);
            } else {
                $user_order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');
                if (empty($user_order_product_rand_ids) == false) {
                    $query->where('j_user_id = 0');
                    $query->where('rand_id IN (' . implode(',', $user_order_product_rand_ids) . ')');
                } else {
                    $query->where('0');
                }
            }
            $query->where('product_id = ' . $product_data['id']);
            $db->setQuery($query);
			$rows = $db->loadObjectList();

		
            if ($db->getErrorNum()) {
                $failed = true;
                $msg = WDFText::get('MSG_FAILED_TO_ADD_TO_CART');
            } elseif ($rows) {
				if($options->checkout_redirect_to_cart_after_adding_an_item == 2){
					$failed = true;
					$msg = WDFText::get('MSG_PRODUCT_ALREADY_ADDED_TO_CART');
				}
				else{
					foreach($rows as $row){
						$insert = false;
						$id = $row->id;
						$product_count = $row->product_count;
						$product_parameters_json = $row->product_parameters;
						$product_parameters_array = json_decode($product_parameters_json);

						$new_keys = array();
						foreach ($product_data['parameters'] as $parameter_key => $product_parameter) {
							$new_keys[] = $parameter_key . '_' . $id;
						}
						
						if(empty($product_parameters_array) === false ){
							//$product_data_parameters_values = (empty($product_data['parameters']) === false) ? array_values($product_data['parameters']) : array();
							//$product_data_parameters = (empty($new_keys) === false && empty($product_data_parameters_values)) ? array_combine($new_keys, $product_data_parameters_values) : array();
							$product_data_parameters = $product_data['parameters'];
							foreach ($product_parameters_array as $param_key => $param_value) {						
								if ($product_data_parameters[$param_key] != $param_value) {
									$insert = true;
									break;
								} 
							}
						}
						
						if ($insert == false) {
							$product_data['count'] += $product_count;
							$order_product_id = $id;
							break;
						}
					}
				}
            }
        }
		
        if ($failed == false) {
            //insert product data into cart table
            if ($insert == true) {
                $rand_id = $model->get_order_product_rand_id();
                if ($rand_id === false) {
                    $failed = true;
                    $msg = WDFText::get('MSG_FAILED_TO_ADD_TO_CART');
                } else {

                    $query->clear();
                    $query->insert('#__ecommercewd_orderproducts');
                    $columns = array('rand_id', 'j_user_id', 'user_ip_address', 'product_id', 'product_name', 'product_parameters', 'product_count');
                    $query->columns($db->quoteName($columns));
                    $query_values = array();
                    $query_values[] = $rand_id;
                    $query_values[] = WDFHelper::is_user_logged_in() == true ? $j_user->id : 0;
                    $query_values[] = $db->quote(WDFUtils::get_client_ip_address());
                    $query_values[] = $product_data['id'];
                    $query_values[] = $product_data['name'];
                    $query_values[] = WDFJson::encode($product_data['parameters']);
                    $query_values[] = $product_data['count'];
                    $query_values = WDFDb::array_quote($query_values);
                    $query->values(implode(',', $query_values));
                    $db->setQuery($query);
                    $db->query();

                    $query->clear();
                    $query->select('MAX(id)');
                    $query->from('#__ecommercewd_orderproducts');
                    $db->setQuery($query);
                    $order_product_id = $db->loadResult();
                    $new_keys = array();
                    foreach ($product_data['parameters'] as $parameter_key => $product_parameter) {
                        $new_keys[] = $parameter_key . '_' . $order_product_id;
                    }
					$product_data_parameters_values = (empty($product_data['parameters']) === false) ? array_values($product_data['parameters']) : array();                  
					$product_data['parameters'] = (empty($new_keys) === false && empty($product_data_parameters_values) === false) ?  array_combine($new_keys, $product_data_parameters_values) : array();

                    $query->clear();
                    $query->update('#__ecommercewd_orderproducts');
                    $query->set("product_parameters='" . json_encode($product_data['parameters']) . "'");
                    $query->where('id = ' . $order_product_id);
                    $db->setQuery($query);
                    $db->query();
                    if ($db->getErrorNum()) {
                        $msg = WDFText::get('MSG_FAILED_TO_UPDATE_ITEM');
                    }
                    if ($db->getErrorNum()) {
                        $failed = true;
                        $msg = WDFText::get('MSG_FAILED_TO_ADD_TO_CART');
                    } elseif (WDFHelper::is_user_logged_in() == false) {
                        // if user is not logged in, add order product rand_id to cookies
                        $user_order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids', array());
                        $user_order_product_rand_ids[] = $rand_id;
                        WDFInput::cookie_set_array('order_product_rand_ids', $user_order_product_rand_ids);
                    }
                }
            } //update product data count
            else {
                $query->clear();
                $query->update('#__ecommercewd_orderproducts');
                $query->set('product_count = ' . $product_data['count']);
                $query->where('order_id = 0');
                if (WDFHelper::is_user_logged_in() == true) {
                    $query->where('j_user_id = ' . $j_user->id);
                } else {
                    $user_order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids', array());
                    if (empty($user_order_product_rand_ids) == false) {
                        $query->where('j_user_id = 0');
                        $query->where('rand_id IN (' . implode(',', $user_order_product_rand_ids) . ')');
                    } else {
                        $query->where('0');
                    }
                }
                $query->where('product_id = ' . $product_data['id']);
                $query->where('id = ' . $order_product_id);
                $db->setQuery($query);
                $db->query();
                if ($db->getErrorNum()) {
                    $failed = true;
                    $msg = WDFText::get('MSG_FAILED_TO_UPDATE_ITEM');
                }
            }
        }

        // get cart's products count
        $query->clear();
        $query->select('SUM(product_count)');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = 0');
        if (WDFHelper::is_user_logged_in() == true) {
            $query->where('j_user_id = ' . $j_user->id);
        } else {
            $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids', array());
            if (empty($order_product_rand_ids) == false) {
                $query->where('j_user_id = 0');
                $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
            } else {
                $query->where(0);
            }
        }
        $db->setQuery($query);
        $products_in_cart = $db->loadResult();

        if ($db->getErrorNum()) {
            $products_in_cart = -1;
        }
		
        $product_added = $failed == true ? false : true;
        if ($product_added == true) {
            $msg = WDFText::get('MSG_SUCCESSFULLY_ADDED_TO_CART');
        }

        $data = array();
        $data['product_added'] = $product_added;
        $data['msg'] = $msg;
        $data['products_in_cart'] = $products_in_cart;
        echo WDFJson::encode($data);
        die();
    }
    public function ajax_update_order_product_data() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_shopping_cart = WDFHelper::get_model('shoppingcart');

        $failed = false;
        $msg = '';

        $order_product_id = WDFInput::get('order_product_id', 0, 'int');
        $order_product_count = WDFInput::get('order_product_count', 1, 'int');
        $order_product_parameters = WDFJson::encode(WDFInput::get_parsed_json('order_product_parameters_json', array()));
		$order_product_parameters_price = WDFInput::get('order_product_parameters_price', 0, 'string');

	   // check data
        if ($order_product_count < 1) {
            $failed = true;
            $msg = WDFText::get('MSG_QUANTITY_AT_LEAST_MUST_BE_ONE');
        }

        //update order product data
        if ($failed == false) {
            $query->clear();
            $query->update('#__ecommercewd_orderproducts');
            $query->set('product_count = ' . $db->quote($order_product_count));      
            $query->set('product_parameters = ' . $db->quote($order_product_parameters));
			$query->set('product_parameters_price = ' . $db->quote($order_product_parameters_price));
            $query->where('id = ' . $order_product_id);
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                $failed = true;
                $msg = WDFText::get('MSG_FAILED_TO_UPDATE_ITEM');
            }
        }

        // get order product and order data after update
        $order_product_rows = $model_shopping_cart->get_order_product_rows();
        $total_text = $model_shopping_cart->get_order_products_total_price_text();
        foreach ($order_product_rows as $order_product_row) {
            if ($order_product_id == $order_product_row->id) {
                $order_product = $order_product_row;
                break;
            }
        }

        $data = array();
        $data['failed'] = $failed;
        $data['msg'] = $msg;
		$data['order_product_id'] = $order_product_id;
        $data['product_count'] = $order_product->product_count;
        $data['product_subtotal_text'] = $order_product->subtotal_text;
		$data['product_final_price_text'] = $order_product->product_final_price_text;
        $data['total_text'] = $total_text;

        echo WDFJson::encode($data);
        die();
    }

    public function ajax_remove_order_product() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        $model_shopping_cart = WDFHelper::get_model('shoppingcart');

        $failed = false;
        $msg = '';

        $order_product_id = WDFInput::get('order_product_id', 0, 'int');

        //remove order product
        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = 0');
        if (WDFHelper::is_user_logged_in()) {
            $query->where('j_user_id = ' . $j_user->id);
        } else {
            $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids', array());
            if (empty($order_product_rand_ids) == false) {
                $query->where('j_user_id = 0');
                $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
            } else {
                $query->where(0);
            }
        }
        $query->where('id = ' . $order_product_id);
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            $failed = true;
            $msg = WDFText::get('MSG_FAILED_TO_UPDATE_ITEM');
        }

        $order_products = $model_shopping_cart->get_order_product_rows();
        $order_products_left = count($order_products);

        $total_text = $model_shopping_cart->get_order_products_total_price_text();

        $data = array();
        $data['failed'] = $failed;
        $data['msg'] = $msg;
        $data['order_products_left'] = $order_products_left;
        $data['total_text'] = $total_text;

        echo WDFJson::encode($data);
        die();
    }

    public function ajax_remove_all_order_products() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        $model_shopping_cart = WDFHelper::get_model('shoppingcart');

        $failed = false;
        $msg = '';

        //remove order product
        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = 0');
        if (WDFHelper::is_user_logged_in() == true) {
            $query->where('j_user_id = ' . $j_user->id);
        } else {
            $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');
            if (empty($order_product_rand_ids) == false) {
                $query->where('j_user_id = 0');
                $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
            } else {
                $query->where('0');
            }
        }
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            $failed = true;
            $msg = WDFText::get('MSG_FAILED_TO_REMOVE_ITEM');
        }

        $total_text = $model_shopping_cart->get_order_products_total_price_text();

        $data = array();
        $data['failed'] = $failed;
        $data['msg'] = $msg;
        $data['total_text'] = $total_text;

        echo WDFJson::encode($data);
        die();
    }

    public function displayshoppingcart() {
		
        $this->add_guest_user_products();
		$this->check_cart();
        $this->remove_unavailable_products();
        parent::display();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function add_guest_user_products() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        // get user product ids
        $query->clear();
        $query->select('product_id');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('j_user_id = ' . $j_user->id);
        $query->where('order_id = 0');
        $db->setQuery($query);
        $user_product_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            $app->enqueueMessage('Failed to add your products to the cart');
            return false;
        }

        // get order product ids with new rows
        $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');

        $query->clear();
        $query->select('id');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = 0');
        $query->where('j_user_id = 0');
        if (empty($order_product_rand_ids) == false) {
            $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
        } else {
            $query->where(0);
        }
        if (empty($user_product_ids) == false) {
            $query->where('product_id NOT IN (' . implode(',', $user_product_ids) . ')');
        }
        $db->setQuery($query);
        $new_order_product_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            $app->enqueueMessage('Failed to add your products to the cart');
            return false;
        }

        // add new products to users shopping cart
        $query->clear();
        $query->update('#__ecommercewd_orderproducts');
        $query->set('j_user_id = ' . $j_user->id);
        if (empty($new_order_product_ids) == false) {
            $query->where('id IN (' . implode(',', $new_order_product_ids) . ')');
        } else {
            $query->where(0);
        }
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_ADD_GUEST_PRODUCTS'));
            return false;
        }

        if (empty($new_order_product_ids) == false) {
            $app->enqueueMessage(WDFText::get('MSG_GUEST_PRODUCTS_ADDED'), 'message');
        }

        // get merged products rand ids
        if (empty($new_order_product_ids) == false) {
            $query->clear();
            $query->select('rand_id');
            $query->from('#__ecommercewd_orderproducts');
            $query->where('id IN (' . implode(',', $new_order_product_ids) . ')');
            $db->setQuery($query);
            $merged_order_product_rand_ids = $db->loadColumn();

            if ($db->getErrorNum()) {
                // TODO:
            }
        } else {
            $merged_order_product_rand_ids = array();
        }

        // remove merged order products ids from cookies
        $oreder_product_rand_ids_left = array_diff($order_product_rand_ids, $merged_order_product_rand_ids);
        $oreder_product_rand_ids_left = array_values($oreder_product_rand_ids_left);
        WDFInput::cookie_set_array('order_product_rand_ids', $oreder_product_rand_ids_left);

        return true;
    }

    private function remove_unavailable_products() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        $guest_order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');

        // get user unavailable order products
        $query->clear();
        $query->select('T_ORDER_PRODUCTS.id');
        $query->select('T_ORDER_PRODUCTS.rand_id');
        $query->select('T_ORDER_PRODUCTS.product_name');
        $query->from('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS');
        $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON T_ORDER_PRODUCTS.product_id = T_PRODUCTS.id');
        $query->where('T_ORDER_PRODUCTS.order_id = 0');
        $query->where('(T_PRODUCTS.id IS NULL OR T_PRODUCTS.published = 0)');
        if (WDFHelper::is_user_logged_in() == true) {
            $query->where('T_ORDER_PRODUCTS.j_user_id = ' . $j_user->id);
        } else {
            if (empty($guest_order_product_ids) == false) {
                $query->where('T_ORDER_PRODUCTS.j_user_id = 0');
                $query->where('T_ORDER_PRODUCTS.rand_id IN (' . implode(',', $guest_order_product_rand_ids) . ')');
            } else {
                $query->where('0');
            }
        }
        $db->setQuery($query);
        $unavailable_products_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        $unavailable_ids = array();
        $unavailable_rand_ids = array();
        $unavailable_products_names = array();
        foreach ($unavailable_products_rows as $row_unavailable_product) {
            $unavailable_ids[] = $row_unavailable_product->id;
            $unavailable_rand_ids[] = $row_unavailable_product->rand_id;
            $unavailable_products_names[] = $row_unavailable_product->product_name;
        }

        //remove unavailable order product
        if (empty($unavailable_ids) == false) {
            $query->clear();
            $query->delete();
            $query->from('#__ecommercewd_orderproducts');
            $query->where('id IN (' . implode(',', $unavailable_ids) . ')');
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
            }

            if (WDFHelper::is_user_logged_in() == false) {
                $guest_order_product_rand_ids = array_diff($guest_order_product_rand_ids, $unavailable_rand_ids);
                $guest_order_product_rand_ids = array_values($guest_order_product_rand_ids);
                WDFInput::cookie_set_array('order_product_rand_ids', $guest_order_product_rand_ids);
            }

            $app->enqueueMessage(WDFText::get('MSG_PRODUCTS_NO_LONGER_AVAILABLE') . ': ' . implode(', ', $unavailable_products_names), 'info');
        }
    }
	
	private function check_cart(){
	
	    $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();
		$selected_order_products = array();
		
		if($j_user->id != 0){
			// get user product ids
			$query->clear();
			$query->select('id');
			$query->select('product_id');
			$query->select('product_count');
			$query->select('product_name');
			$query->select('product_parameters');
			$query->from('#__ecommercewd_orderproducts');
			$query->where('j_user_id = ' . $j_user->id);
			$query->where('order_id = 0');
			$db->setQuery($query);
			$user_order_products = $db->loadObjectList();

			if ($db->getErrorNum()) {          
				return false;
			}
			
			
			for( $i=0; $i<count($user_order_products); $i++ ){
				$user_order_product = $user_order_products[$i];
				for($j=$i+1; $j<count($user_order_products); $j++ ){
					$_user_order_product = $user_order_products[$j];
					if( $user_order_product->product_id == $_user_order_product->product_id ){					
						$parameters = WDFHelperFunctions::object_to_array(WDFJson::decode($user_order_product->product_parameters));					
						$_parameters = WDFHelperFunctions::object_to_array(WDFJson::decode($_user_order_product->product_parameters));
						if( count($parameters) != count($_parameters)){
							continue;
						}
						else{						
							//$parameters = array_combine(array_map(function($k){ $k = explode('_',$k) ;return $k[0]; }, array_keys($parameters)) , $parameters);				
							//$_parameters = array_combine(array_map(function($k){ $k = explode('_',$k) ;return $k[0]; }, array_keys($_parameters)) , $_parameters);					
							$array_map_parameters =	!empty($parameters) ? array_map(function($k){ $k= explode('_',$k) ; return $k[0]; }, array_keys($parameters)) : array();
							if( !empty($array_map_parameters) && !empty( $parameters ) )
								$parameters = array_combine($array_map_parameters , $parameters);				
							if( !empty($array_map_parameters) && !empty( $_parameters ) )
								$_parameters = array_combine(array_map(function($k){ $k= explode('_',$k) ;return $k[0]; }, array_keys($_parameters)) , $_parameters);
					
							$parameters_keys = (!empty($parameters)) ? array_keys($parameters) : array();
							$_parameters_keys = (!empty($_parameters)) ? array_keys($_parameters) : array();
									
							if(WDFHelperFunctions::multidimensional_array_diff($parameters,$_parameters) == array() && array_diff($parameters_keys,$_parameters_keys) == array()){							
								$selected_order_products[$user_order_product->product_id] = array( 'product_count' => ($_user_order_product->product_count + $user_order_product->product_count), 'parameters' => $parameters, '_row_parameters' =>$_user_order_product->product_parameters, 'row_parameters' =>$user_order_product->product_parameters,'product_name'=>$user_order_product->product_name);
							}
						}
					}			
				}		
			}
		}
		
		
		if(empty($selected_order_products) === false){
			foreach($selected_order_products as $product_id => $order_product_data){
				$query->clear();
				$query->delete();
				$query->from('#__ecommercewd_orderproducts');
				$query->where('product_id = ' . $product_id);
				$query->where('order_id = 0');
				$query->where("(product_parameters = '" . $order_product_data['_row_parameters'] ."' OR product_parameters = '". $order_product_data['row_parameters'] ."')");
				$db->setQuery($query);
				$db->Query();
				
			   if (!$db->getErrorNum()) {
				
					// insert new order product row
					$query->clear();
					$query->insert('#__ecommercewd_orderproducts');
					$columns = array( 'j_user_id', 'user_ip_address', 'product_id', 'product_name', 'product_count');
					$query->columns($db->quoteName($columns));
					$query_values = array();
					$query_values[] = WDFHelper::is_user_logged_in() == true ? $j_user->id : 0;
					$query_values[] = $db->quote(WDFUtils::get_client_ip_address());
					$query_values[] = $product_id;
					$query_values[] = $order_product_data['product_name'];
					$query_values[] = $order_product_data['product_count'];
					$query_values = WDFDb::array_quote($query_values);
					$query->values(implode(',', $query_values));
					$db->setQuery($query);
					$db->query();
					
					$query->clear();
					$query->select('MAX(id)');
					$query->from('#__ecommercewd_orderproducts');
					$db->setQuery($query);
					$order_product_id = $db->loadResult();
					
					// insert parameters
					$new_parameters = $order_product_data['parameters'];
					$new_keys = array();
					$new_values = array();
					if(empty($new_parameters) == false){
						foreach ($new_parameters as $parameter_key => $product_parameter) {
							$new_keys[] = $parameter_key . '_' . $order_product_id;
							$new_values[] = $product_parameter;
						}
						$new_parameters = (empty($new_keys) === false && empty($new_values) === false) ? array_combine($new_keys, $new_values) : array();
					}

					$query->clear();
					$query->update('#__ecommercewd_orderproducts');
					$query->set("product_parameters='" . WDFJson::encode($new_parameters) . "'");
					$query->where('id = ' . $order_product_id);
					$db->setQuery($query);
					$db->query();				
								
				}
				
			}
		}

	}


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}