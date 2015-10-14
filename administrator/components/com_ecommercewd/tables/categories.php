<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdTableCategories extends JTable {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    public $id = 0;
    public $level = 0;
    public $parent_id = 0;
    public $name = '';
    public $alias = '';
    public $description = '';
    public $images = '';
    public $meta_title = '';
    public $meta_description = '';
    public $meta_keyword = '';
    public $ordering = 0;
    public $published = 1;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    function __construct(&$db) {
        parent::__construct('#__ecommercewd_categories', 'id', $db);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function reorder($where = '') {
        // If there is no ordering field set an error and return false.
        if (!property_exists($this, 'ordering')) {
            $e = new JException(JText::sprintf('JLIB_DATABASE_ERROR_CLASS_DOES_NOT_SUPPORT_ORDERING', get_class($this)));
            $this->setError($e);
            return false;
        }

        // Initialise variables.
        $k = $this->_tbl_key;

        // Get the primary keys and ordering values for the selection.
        $query = $this->_db->getQuery(true);
        // SELECT PARENT ID
        $query->select($this->_tbl_key . ', parent_id, ordering');
        $query->from($this->_tbl);
        $query->where('ordering >= 0');
        $query->order('ordering');

        // Setup the extra where and ordering clause data.
        if ($where) {
            $query->where($where);
        }

        $this->_db->setQuery($query);
        $rows = $this->_db->loadObjectList();

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $e = new JException(JText::sprintf('JLIB_DATABASE_ERROR_REORDER_FAILED', get_class($this), $this->_db->getErrorMsg()));
            $this->setError($e);

            return false;
        }

        // SORT ROWS BY PARENT
        $rows = $this->parent_child_sort($rows);

        // Compact the ordering values.
        foreach ($rows as $i => $row) {
            // Make sure the ordering is a positive integer.
            if ($row->ordering >= 0) {
                // Only update rows that are necessary.
                if ($row->ordering != $i + 1) {
                    // Update the row ordering field.
                    $query = $this->_db->getQuery(true);
                    $query->update($this->_tbl);
                    $query->set('ordering = ' . ($i + 1));
                    $query->where($this->_tbl_key . ' = ' . $this->_db->quote($row->$k));
                    $this->_db->setQuery($query);

                    // Check for a database error.
                    if (!$this->_db->execute()) {
                        $e = new JException(
                            JText::sprintf('JLIB_DATABASE_ERROR_REORDER_UPDATE_ROW_FAILED', get_class($this), $i, $this->_db->getErrorMsg())
                        );
                        $this->setError($e);

                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function parent_child_sort($rows, $parent_id = 0, &$sorted_rows = array()) {
        foreach ($rows as $key => $row) {
            if ($row->parent_id == $parent_id) {
                array_push($sorted_rows, $row);
                unset($rows[$key]);
                $this->parent_child_sort($rows, $row->id, $sorted_rows);
            }
        }
        return $sorted_rows;
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