<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelCategories extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    const MAX_DESCRIPTION_LENGTH = 150;


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

        $row = $is_refresh == true ? WDFDb::get_row_from_input('') : parent::get_row($id);

        // additional data
        // parent name
        $parent_row = WDFDb::get_row_by_id('categories', $row->parent_id);
        $row->parent_name = $parent_row->name != null ? $parent_row->name : WDFText::get('ROOT_CATEGORY');

        // images
        if ($row->images == null) {
            $row->images = WDFJson::encode(array());
        }
		
        // parameters and tags
        if ($is_refresh == true) {
            $row->parameters = $this->get_input_parameters();
            $row->tags = $this->get_input_tags();
        } else {
            $row->parameters = $this->get_category_parameters($row->id, true);
            $row->tags = $this->get_category_tags($row->id, true);
        }
        $row->parent_parameters = $this->get_category_parameters($row->parent_id, true);
        $row->parent_tags = $this->get_category_tags($row->parent_id, true);

        return $row;
    }

    public function get_rows() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $table_instance = WDFDb::get_table_instance();
        if (property_exists($table_instance, 'ordering') == true) {
            $table_instance->reorder();
        }

        $query->clear();
        $this->add_rows_query_select($query);
        $this->add_rows_query_from($query);
        $this->add_rows_query_where($query);
        $this->add_rows_query_order($query);
        $this->add_rows_query_group($query);
        $pagination = $this->get_rows_pagination();

        $db->setQuery($query);
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
            $row->view_url = 'index.php?option=com_' . $com_name . '&controller=' . $controller . '&task=view' . '&cid[]=' . $row->id;
            $row->edit_url = 'index.php?option=com_' . $com_name . '&controller=' . $controller . '&task=edit' . '&cid[]=' . $row->id;
        }

        // additional data
        foreach ($rows as $row) {
            // shorten description
            $row->description = WDFTextUtils::truncate($row->description, self::MAX_DESCRIPTION_LENGTH);
            // show products url
            $row->show_products_url = 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=products' . '&task=' . '&search_category_id=' . $row->id;
        }
		$parent_id = $this->get_root_parents( $rows );
        $sorted_rows = $this->parent_child_sort($rows, $parent_id);

        $sorted_rows = array_slice($sorted_rows, $pagination->limitstart, $pagination->limit);
				
		return $sorted_rows;

    }

    public function parent_child_sort($rows, $parent_id, &$sorted_rows = array()) {	
        foreach ($rows as $key => $row) {
            if ($row->parent_id == $parent_id) {
                array_push($sorted_rows, $row);
                unset($rows[$key]);
                $this->parent_child_sort($rows, $row->id, $sorted_rows);
            }
        }
        return $sorted_rows;
    }
	
	public function get_root_parents( $rows ){
		$ids = array();
		foreach ($rows as $key => $row)
			$ids[] = $row->parent_id;			
		return $ids ? min($ids) : 0;		
	}
	

    public function get_tree_data($category_id = 0) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        if ($category_id == 0) {
            $category = new stdClass();
            $category->id = 0;
            $category->name = WDFText::get('ROOT_CATEGORY');
        } else {
            $query->clear();
            $query->select('id');
            $query->select('name');
            $query->from('#__ecommercewd_categories');
            $query->where('id = ' . $category_id);
            $db->setQuery($query);
            $category = $db->loadObject();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }

        // add child categories
        $query->clear();
        $query->select('id');
        $query->from('#__ecommercewd_categories');
        $query->where('parent_id = ' . $category_id);
        $db->setQuery($query);
        $child_category_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $children = array();
        for ($i = 0; $i < count($child_category_ids); $i++) {
            $child_category_id = $child_category_ids[$i];
            $children[$i] = $this->get_tree_data($child_category_id);
        }
        $category->children = $children;

        return $category;
    }

    public function get_category_parameters($category_id, $json = false) {
        if ($category_id == '') {
            return $json == true ? addslashes(WDFJson::encode(array())) : array();
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // get parameter rows
        $query->clear();
        $query->select('T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
        $query->select('T_PARAMETERS.required');
		$query->select('T_PARAMETERS.default_values');
        $query->select('T_CATEGORY_PARAMETERS.parameter_value AS value');
		$query->select('T_PARAMETER_TYPES.name AS type_name');
        $query->from('#__ecommercewd_parameters AS T_PARAMETERS');
        $query->leftJoin('#__ecommercewd_categoryparameters AS T_CATEGORY_PARAMETERS ON T_CATEGORY_PARAMETERS.parameter_id = T_PARAMETERS.id');
        $query->leftJoin('#__ecommercewd_parametertypes AS T_PARAMETER_TYPES ON T_PARAMETERS.type_id = T_PARAMETER_TYPES.id');		
	    $query->where('T_CATEGORY_PARAMETERS.category_id = ' . $category_id);
        $query->order('T_CATEGORY_PARAMETERS.categoryparameters_id ASC');
        $db->setQuery($query);
        $parameter_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        // merge parameters with same id
        $parameters_map = array();
        foreach ($parameter_rows as $parameter_row) {
            $parameter_id = $parameter_row->id;
            if (isset($parameters_map[$parameter_id])) {
                $parameters_map[$parameter_id]->values[] = $parameter_row->value;
            } else {
                $parameter_row->values = array($parameter_row->value);
                $parameters_map[$parameter_id] = $parameter_row;
            }
        }

        $parameters = array();
        foreach ($parameters_map as $id => $parameter) {
            $parameters[] = $parameter;
        }

        return $json == true ? addslashes(WDFJson::encode($parameters, 256)) : $parameters;
    }

    public function get_category_tags($category_id, $json = false) {
        if ($category_id == '') {
            return $json == true ? addslashes(WDFJson::encode(array())) : array();
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // get tag rows
        $query->clear();
        $query->select('T_TAGS.id');
        $query->select('T_TAGS.name');
        $query->from('#__ecommercewd_categorytags AS T_CATEGORY_TAGS');
        $query->leftJoin('#__ecommercewd_tags AS T_TAGS ON T_CATEGORY_TAGS.tag_id = T_TAGS.id');
        $query->where('T_CATEGORY_TAGS.category_id = ' . $category_id);
        $query->order('T_TAGS.ordering ASC');
        $db->setQuery($query);
        $tags = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $json == true ? addslashes(WDFJson::encode($tags, 256)) : $tags;
    }

	public function get_popup_rows()
	{
		$rows = $this->get_rows();
		$main_category_array = array();
		$main_category = new stdClass();
		$main_category->id = 0;
		$main_category->name = "Main";
		$main_category->level = 1;
		$main_category_array[0] =  $main_category;
		
		$rows_ = array_merge($main_category_array,$rows);
		foreach($rows_ as $row)
			$row->tree = $this->find_parents($row->id);
		return 	$rows_;
	
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

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }

    protected function add_rows_query_select(JDatabaseQuery $query) {
        parent::add_rows_query_select($query);

        $query->select('COUNT(T_SUBCATEGORIES.id) AS subcategories_count');
        $query->select('COUNT(T_PRODUCTS.id) AS products_count');
    }

    protected function add_rows_query_from(JDatabaseQuery $query) {
        parent::add_rows_query_from($query);

        $query->leftJoin('#__ecommercewd_categories AS T_SUBCATEGORIES ON T_SUBCATEGORIES.parent_id = #__ecommercewd_categories.id');
        $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON T_PRODUCTS.category_id = #__ecommercewd_categories.id');
    }

    protected function add_rows_query_where_filters(JDatabaseQuery $query) {
        if (WDFSession::get('search_category_id') === null) {
            WDFSession::set('search_category_id', 0);
        }

        parent::add_rows_query_where_filters($query);
    }
	


    private function get_input_parameters() {
        $parameters = WDFJson::decode(WDFInput::get('parameters'));
        for ($i = 0; $i < count($parameters); $i++) {
            $parameter = $parameters[$i];

            $parameter_row = WDFDb::get_row_by_id('parameters', $parameter->id);
            $parameter->name = $parameter_row->name;
        }

        return addslashes(WDFJson::encode($parameters, 256));
    }

    private function get_input_tags() {
        $tag_ids = WDFJson::decode(WDFInput::get('tag_ids'));
        if (empty($tag_ids) == true) {
            return WDFJson::encode(array());
        }

        $tags = WDFDb::get_rows('tags', 'id IN (' . implode(',', $tag_ids) . ')');

        return WDFJson::encode($tags, 256);
    }
	
	private function find_parents($category_id , &$parents = array())
	{
		if($category_id != 0)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);			

			$query->clear();
			$query->select('T_PARENT_CATEGORIES.name');
			$query->select('T_PARENT_CATEGORIES.id');
			$query->from('#__ecommercewd_categories AS T_CATEGORIES');
			$query->leftJoin('#__ecommercewd_categories AS T_PARENT_CATEGORIES ON T_CATEGORIES.parent_id = T_PARENT_CATEGORIES.id');
			$query->where( 'T_CATEGORIES.id = ' . $category_id );
			
			$db->setQuery($query);
			$parent = $db->loadObject();
			
			if($parent->id != 0)
			{
				array_push($parents, $parent->name);
				$this->find_parents($parent->id, $parents);	
			}
		}
		return implode(' &#8594; ',array_reverse($parents));
		
	}


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}