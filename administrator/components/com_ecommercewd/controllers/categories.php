<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerCategories extends EcommercewdController {
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
    public function show_tree() {
        WDFInput::set('tmpl', 'component');
        parent::display();
    }

    public function remove() {
        $checked_ids = WDFInput::get_checked_ids();
        for ($i = 0; $i < count($checked_ids); $i++) {
            $this->remove_category($checked_ids[$i]);
        }
        WDFHelper::redirect();
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

        return $row;
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

        // level
        $parent_id = WDFInput::get('parent_id', 0, 'int');
        $row_parent_category = WDFDb::get_row_by_id('categories', $parent_id);
        WDFInput::set('level', $row_parent_category->level + 1);

        // make the alias URL safe.
        $alias = JApplication::stringURLSafe($alias);
        if (trim(str_replace('-', '', $alias)) == '') {
            $this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
        }

        // get unique alias
        $row_category = WDFDb::get_row('categories', array('id != ' . $self_id, $db->quoteName('alias') . ' = ' . $db->quote($alias)));
        if ($row_category->id != 0) {
            $i = 2;
            do {
                $new_alias = $alias . '-' . $i++;
                $row_category = WDFDb::get_row('categories', array('id != ' . $self_id, $db->quoteName('alias') . ' = ' . $db->quote($new_alias)));
            } while ($row_category->id != 0);
            $alias = $new_alias;
        }

        WDFInput::set('alias', $alias);
    }

    private function remove_category($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $this->uncodegorize_category_products($id);
        $this->remove_category_parameters_and_tags($id);

        $query->clear();
        $query->select('id');
        $query->from('#__ecommercewd_categories');
        $query->where('parent_id = ' . $id);
        $db->setQuery($query);
        $child_category_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        for ($i = 0; $i < count($child_category_ids); $i++) {
            $child_category_id = $child_category_ids[$i];
            $this->remove_category($child_category_id);
        }

        WDFDb::remove_rows('', array($id));
    }

    private function uncodegorize_category_products($category_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->update('#__ecommercewd_products');
        $query->set('category_id = 0');
        $query->where('category_id = ' . $category_id);
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function remove_category_parameters_and_tags($category_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_categoryparameters');
        $query->where('category_id = ' . $category_id);
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_categorytags');
        $query->where('category_id = ' . $category_id);
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    private function save_parameters_and_tags($category_id) {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $this->remove_category_parameters_and_tags($category_id);

        $parameters = WDFJson::decode(WDFInput::get('parameters'));
        if (empty($parameters) == false) {
            $ar_values = array();
            for ($i = 0; $i < count($parameters); $i++) {
                $parameter = $parameters[$i];
                $parameter_id = $parameter->id;
                $parameter_values = $parameter->values;
                $parameter_valid_values = array();
                // get not empty unique values
                for ($j = 0; $j < count($parameter_values); $j++) {
                    $parameter_value = $parameter_values[$j];
                    if (($parameter_value != '') && (in_array($parameter_value, $parameter_valid_values) == false)) {
                        $parameter_valid_values[] = $parameter_value;
                    }
                }

                if (empty($parameter_valid_values) == false) {
                    for ($j = 0; $j < count($parameter_valid_values); $j++) {
                        $parameter_value = $parameter_valid_values[$j];
                        $ar_values[] = $db->quote($category_id) . ', ' . $db->quote($parameter_id) . ', ' . $db->quote($parameter_value);
                    }
                } else {
                    $ar_values[] = $db->quote($category_id) . ', ' . $db->quote($parameter_id) . ', ' . $db->quote('');
                }
            }

            $query->clear();
            $query->insert('#__ecommercewd_categoryparameters');
            $columns = array('category_id', 'parameter_id', 'parameter_value');
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
                $ar_values[] = $db->quote($category_id) . ', ' . $db->quote($tag_id);
            }

            $query->clear();
            $query->insert('#__ecommercewd_categorytags');
            $columns = array('category_id, tag_id');
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


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}