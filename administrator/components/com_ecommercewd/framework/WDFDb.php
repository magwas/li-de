<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class WDFDb {
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
    /**
     * Gets a table instance.
     *
     * @param    string $table_name Name of the table.
     *
     * @return    JTable    table row.
     */
    public static function get_table_instance($table_name = '') {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        $table_name = ucfirst($table_name);
        $table_prefix = ucfirst(WDFHelper::get_com_name()) . 'Table';
        return JTable::getInstance($table_name, $table_prefix);
    }

    /**
     * Gets table row by conditions.
     *
     * @param    string $table_name Name of the table.
     * @param    string $where_queries array of WHERE parts of the query.
     *
     * @return    object    row.
     */
    public static function get_row($table_name = '', $where_queries = array()) {
        $rows = self::get_rows($table_name, $where_queries);
        return empty($rows) == false ? $rows[0] : self::get_table_instance($table_name);
    }

    /**
     * Gets table rows by conditions.
     *
     * @param    string $table_name Name of the table.
     * @param    string $where_queries array of WHERE parts of the query.
     *
     * @return    array    rows.
     */
    public static function get_rows($table_name = '', $where_queries = array()) {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }

        if (is_string($where_queries) == true) {
            $where_queries = array($where_queries);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__' . WDFHelper::get_com_name() . '_' . $table_name);
        foreach ($where_queries as $where_query) {
            $query->where($where_query);
        }
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }

        return $rows;
    }

    /**
     * Gets a table row by id.
     *
     * @param    string $table_name Name of the table.
     * @param    string $id Id of the row.
     *
     * @return    JTable    table row.
     */
    public static function get_row_by_id($table_name = '', $id = 0) {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        $row = self::get_table_instance($table_name);
			
        $row->load((int)$id);
        if ($row->id == 0) {
            $row = self::get_table_instance($table_name);
        }

        return $row;
    }

    /**
     * Gets table instance and fill it with the input data.
     *
     * @param    string $table_name Name of the table.
     *
     * @return    JTable    table row.
     */
    public static function get_row_from_input($table_name) {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        $row = self::get_table_instance($table_name);

        foreach ($row as $key => $value) {
            $value_input = WDFInput::get($key, null);
            if ($value_input != null) {
                $row->$key = $value_input;
            }
        }

        return $row;
    }

    /**
     * Removes a table rows with checked ids.
     *
     * @param    string $table_name Name of the table.
     */
    public static function remove_rows($table_name, $ids) {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        if (is_array($ids) == true) {
            $ids = implode(',', $ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__' . WDFHelper::get_com_name() . '_' . $table_name);
        $query->where('id IN (' . $ids . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }

        return true;
    }

    /**
     * Gets a table row with checked id.
     *
     * @param    string $table_name Name of the table.
     *
     * @return    JTable    table row with checked id.
     */
    public static function get_checked_row($table_name = '') {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        return self::get_row_by_id($table_name, WDFInput::get_checked_id());
    }

    /**
     * Removes a table row with checked id.
     *
     * @param    string $table_name Name of the table.
     */
    public static function remove_checked_rows($table_name = '') {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        self::remove_rows($table_name, WDFInput::get_checked_ids());
    }

    /**
     * Stores the input data in a table row.
     *
     * @param    string $table_name Name of the table.
     *
     * @return    mixed    object Stored row / boolean false if failed to store.
     */
    public static function store_input_in_row($table_name = '') {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }

        $id = WDFInput::get('id', 0, 'int');
        $row = self::get_row_by_id($table_name, $id);
        foreach ($row as $key => $value) {
			if($key == 'description'){
				 $new_value = JRequest::getVar( 'description', '','post', 'string', JREQUEST_ALLOWRAW );
			}
			else{
				$new_value = WDFInput::get($key, null);
			}
            if ($new_value !== null) {
                $row->$key = $new_value;
            }
        }
        if (!$row->store()) {
            return false;
        }
		
        return $row;
    }

    /**
     * Gets rows by ids and sets values.
     *
     * @param    string $table_name Name of the table.
     * @param    string $ids ids of rows to change.
     * @param    string $keys names of props.
     * @param    string $values values to set (appropriate to keys).
     */
    public static function set_rows_data($table_name, $ids, $keys, $values) {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        if (is_array($ids) == true) {
            $ids = implode(',', $ids);
        }

        $db = JFactory::getDbo();

        $table_name = WDFHelper::get_com_name() . '_' . $table_name;

        $query_set = '';
        if (is_array($keys)) {
            if (count($keys) > 0) {
                $query_set = 'SET';
                for ($i = 0; $i < count($keys); $i++) {
                    $query_set .= ' ' . $keys[$i] . ' = ' . $values[$i] . ($i == count($keys) - 1) ? '' : ',';
                }
            }
        } else {
            $query_set = 'SET ' . $keys . ' = ' . $values;
        }

        $query_where = $ids == '' ? '' : 'WHERE id IN ( ' . $ids . ' )';
        $query = 'UPDATE #__' . $table_name . ' ' . $query_set . ' ' . $query_where;
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            return false;
        }

        return true;
    }

    /**
     * Changing order of checked row.
     *
     * @param    string $table_name Name of the table.
     * @param    string $direction how to change order.
     *
     * @return    boolean    true if .
     */
    public static function order_checked_row($table_name = '', $direction) {
        $db = JFactory::getDbo();

        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        $id = WDFInput::get_checked_id();
        $row = self::get_table_instance($table_name);
        $row->load($id);
        if (!$row->move($direction)) {
            JError::raiseError(500, $db->getErrorMsg());
            return false;
        }
        return true;
    }

    /**
     * Save order of checked rows.
     *
     * @param    string $table_name Name of the table.
     */
    public static function save_ordering($table_name = '') {
        $db = JFactory::getDBO();				
		$cids = WDFJson::decode(WDFInput::get('cid'));       
        $row = WDFDb::get_table_instance($table_name);
        for ($i = 0; $i < count($cids); $i++) {
            $id = $cids[$i];       
            $row->load($id);         
			$row->ordering = $i+1;			
			if (!$row->store()) {				
				JError::raiseError(500, $db->getErrorMsg());
				return false;
			}           
        }

        return true;
    }

    /**
     * Gets row with checked id and sets values.
     *
     * @param    string $table_name Name of the table.
     * @param    string $keys names of props.
     * @param    string $values values to set (appropriate to keys).
     */
    public static function set_checked_row_data($table_name, $keys, $values) {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
        $cids = array(WDFInput::get_checked_id());
        return self::set_rows_data($table_name, $cids, $keys, $values);
    }

    /**
     * Gets rows with checked ids and sets values.
     *
     * @param    string $table_name Name of the table.
     * @param    string $keys names of props.
     * @param    string $values values to set (appropriate to keys).
     */
    public static function set_checked_rows_data($table_name, $keys, $values, $cids = '') {
        if ($table_name == '') {
            $table_name = WDFInput::get_controller();
        }
		if($cids == '')
			$cids = WDFInput::get_checked_ids();
        return self::set_rows_data($table_name, $cids, $keys, $values);
    }

    /**
     * Extract list(associative array) of key-values from table.
     *
     * @param    string $table_name Name of the table.
     * @param    string $key tables column that represents key in list.
     * @param    string $value tables column that represents value in list.
     * @param    mixed $where_conditions single where condition or array of conditions.
     * @param    array $key_value_first key_value to put at the start of the stack.
     * @param    array $key_value_last key_value to put at the end of the stack.
     *
     * @return    array    array of key-values.
     */
    public static function get_list($table_name, $key, $value, $where_conditions = array(), $order = '', $key_value_first = null, $key_value_last = null) {
        if (is_array($where_conditions) == false) {
            $where_conditions = empty($where_conditions) == true ? array() : array($where_conditions);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $table_name = WDFHelper::get_com_name() . '_' . $table_name;
        $query->clear();
        $query->select($key);
        $query->select($value);
        $query->from('#__' . $table_name);
        foreach ($where_conditions as $where_condition) {
            $query->where($where_condition);
        }
        if ($order != '') {
            $query->order($order);
        }
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        $value_parts = explode(' ', $value);
        $value = end($value_parts);

        $list = array();
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            $row_key = $row->$key;
            $row_value = $row->$value;
            $list[$row_key] = array($key => $row_key, $value => $row_value);
        }

        if ($key_value_first != null) {
            $list = array_merge($key_value_first, $list);
        }

        if ($key_value_last != null) {
            $list = array_merge($list, $key_value_last);
        }

        return $list;
    }


    /**
     * Quote array elements as sql names.
     *
     * @param    array $array array to be quoted.
     *
     * @return    array    quoted array.
     */
    public static function array_quote_name($array) {
        $db = JFactory::getDbo();

        $quoted_array = array();
        foreach ($array as $key => $value) {
            $quoted_array[$key] = $db->quoteName($value);
        }

        return $quoted_array;
    }


    /**
     * Quote array elements as sql values.
     *
     * @param    array $array array to be quoted.
     *
     * @return    array    quoted array.
     */
    public static function array_quote($array) {
        $db = JFactory::getDbo();

        $quoted_array = array();
        foreach ($array as $key => $value) {
            $quoted_array[$key] = $db->quote($value);
        }

        return $quoted_array;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}