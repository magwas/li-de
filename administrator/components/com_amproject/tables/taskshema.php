<?php
/**
* @version		$Id:taskshema.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableTaskshema class
*
* @package		Amproject
* @subpackage	Tables
*/
class TableTaskshema extends JTable {
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar title  **/
   public $title = null;

   /** @var text description  **/
   public $description = null;

   /** @var int state  **/
   public $state = null;

   /** @var int ordering  **/
   public $ordering = null;

   /** @var amprojectwfshema wfshema_id  **/
   public $wfshema_id = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__ampm_taskshema', 'id', $db);
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

    // set JRequest wfshema_id
    $db->setQuery('SELECT wfshema_id FROM #__ampm_taskshema where id="'.$cid[0].'"');
    $res = $db->loadObject();
    if ($res) {
      JRequest::setVar('wfshema',$res->wfshema_id);
    }

    $db->setQuery('lock tables
    #__ampm_condition write,
    #__ampm_taskshema write');
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
    
    // delete from condition
    $query = 'DELETE FROM #__ampm_condition WHERE table_type="#__ampm_taskshema" and table_id '.$cond;
    $db->setQuery($query);
	  if (!$db->query()) {
			$this->setError($db->getErrorMsg());
      $result = false;    
    }	  
    
    // delete from taskshema
    $query = 'DELETE FROM #__ampm_taskshema WHERE id '.$cond;
    $db->setQuery($query);
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
       from #__ampm_taskshema
       where wfshema_id="'.JRequest::getVar('wfshema',0).'"');
       $res = $db->loadObject();
       if ($res) $this->wfshema_id = JRequest::getVar('wfshema',0);
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
      // set JRequest wfshema_id
      JRequest::setVar('wfshema',$this->wfshema_id);

      // chech and updateing ordering
      if (($this->ordering == '') | ($this->ordering <= 0)) $this->ordering = 1;
      $db = JFactory::getDBO();
      $db->setQuery('select id 
      from #__ampm_taskshema 
      where id<>"'.$this->id.'" and ordering="'.$this->ordering.'" and
            wfshema_id="'.$this->wfshema_id.'"');
      $res = $db->loadObject();
      if ($res) {
        $db->setQuery('update #__ampm_taskshema
        set ordering = ordering + 1
        where ordering >="'.$this->ordering.'" and
              wfshema_id="'.$this->wfshema_id.'"');
        $db->query();
      }
      return parent::store($updateNulls);
   }      

}
