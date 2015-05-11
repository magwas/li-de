<?php
/**
* @version		$Id:product.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableProduct class
*
* @package		Amproject
* @subpackage	Tables
*/
class TableProduct extends JTable {

   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar title  **/
   public $title = null;

   /** @var text description  **/
   public $description = null;

   /** @var int state  **/
   public $state = null;

   /** @var varchar unit  **/
   public $unit = null;

   /** @var int orderint  **/
   public $ordering = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__ampm_product', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = '')
	{ 
		return parent::bind($array, $ignore);		
	}

 
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()	{
		$result = true;
    $msg = '';
    if (trim($this->title) == '') {
			$msg = JText::_('COM_AMPRODUCT_TITLE_REQUED').'<br />'; 
			$result = false;
		}
    if (trim($this->description) == '') {
			$msg .= JText::_('COM_AMPRODUCT_DESCRIPTION_REQUED').'<br />'; 
			$result = false;
		}
    if ($msg != '') {
	     $this->setError($msg); 
    }
		return $result;
	}

	/**
	 * canDelete records
	 *
	 * @access public
	 * @param array of integer $cid  array of records'id   
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function canDelete($cid)	{
		$result = true;
    $msg = '';
		/*
    $cond = (is_array($cid)) ? " IN ('" . implode("','", $cid) . "') " : " = '" . $cid . "' ";
    $db = & JFactory::getDBO();     
    $query = 'select count(id) cc FROM #__ampm_project WHERE product_id '.$cond;
    $db->setQuery( $query);
    $res = $db->loadObject();
	  if ($res->cc > 0) {
			$msg .= JText::_('COM_AMPRODUCT_PRODUCT_IS_USE').'<br />'; 
      $result = false;    
    }	    
    if ($msg != '') {
			$this->setError($msg);
    } 
    */  
		return $result;
	}

  	/**
	 * Delete records
	 *
	 * @access public
	 * @param array of integer $cid  array of records'id   
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function delete($cid = null)	{
		$result = true;
    $query = '';
		$cond = (is_array($cid)) ? " IN ('" . implode("','", $cid) . "') " : " = '" . $cid . "' ";
    $db = & JFactory::getDBO();     

    $db->setQuery('lock tables
    #__ampm_product write,
    #__ampm_wfshema write,
    #__ampm_taskshema write');
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
    
    // delete from product
    $query = 'DELETE FROM #__ampm_product WHERE id '.$cond;
    $db->setQuery($query);
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
    
    // mark delete wftaskshema
    $query = 'UPDATE #__ampm_taskshema, #__ampm_wfshema
    SET #__ampm_taskshema.state = -1
    WHERE #__ampm_taskshema.wfshema_id = #__ampm_wfshema.id and 
          #__ampm_wfshema.product_id '.$cond;
    $db->setQuery( $query);
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
     
    // delete from wftasksema
    $query = 'DELETE FROM #__ampm_taskshema WHERE state=-1';
    $db->setQuery( $query);
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
        
    // delete from wfshema
    $query = 'DELETE FROM #__ampm_wfshema WHERE product_id '.$cond;
    $db->setQuery( $query);
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  

    $db->setQuery('unlock tables');
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
          
		return $result;
	}

  /**
   * load one record or init new record
   * @param integer table'id   
   * @return JTable     
   */    
  public function load($id = null, $reset = true) {
    $row = parent::load($id,$reset);
    $db = JFactory::getDBO();
    if (($id == 0) | ($id == '') | ($id == null)) {
       // init record
       $db->setQuery('select max(ordering) maxOrdering
       from #__ampm_product');
       $res = $db->loadObject();
       $this->ordering = $res->maxOrdering + 1; 
       $this->state = 1; 
    }
    return $this;
  }
  
  /**
   * store a row
   * @return boolean   
   */
   public function store($updateNulls = false) {
      // chech and updateing ordering
      if (($this->ordering == '') | ($this->ordering <= 0)) $this->ordering = 1;
      $db = JFactory::getDBO();
      $db->setQuery('select id 
      from #__ampm_product 
      where id<>"'.$this->id.'" and ordering="'.$this->ordering.'"');
      $res = $db->loadObject();
      if ($res) {
        $db->setQuery('update #__ampm_product
        set ordering = ordering + 1
        where ordering >="'.$this->ordering.'"');
        $db->query();
      }
     return parent::store($updateNulls);
   }      
}
