<?php
/**
* @version		$Id:condition.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableCondition class
*
* @package		Amproject
* @subpackage	Tables
*/
class TableCondition extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar table_type  **/
   public $table_type = null;

   /** @var int table_id  **/
   public $table_id = null;

   /** @var int type  **/
   public $type = null;

   /** @var int assigned_id  **/
   public $assigned_id = null;

   /** @var int volume  **/
   public $volume = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__ampm_condition', 'id', $db);
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
	public function check() {
		/** check for valid name */
    $msg = '';
		if (trim($this->table_type) == '') { 
			$msg .= JText::_('COM_AMPROJECT_TABLE_TYPE_REQUED').'<br />'; 
		}
		if ((trim($this->table_id) == '') | 
		    (trim($this->table_id) <= 0)) {
			$msg .= JText::_('COM_AMPROJECT_TABLE_ID_REQUED').'<br />'; 
		}
		if ((trim($this->type) == '') | 
		    (trim($this->type) <= 0)) {
			$msg .= JText::_('COM_AMPROJECT_CONDITION_TYPE_REQUED').'<br />'; 
		}
		if ((trim($this->assigned_id) == '') | 
		    (trim($this->assigned_id) <= 0)) {
			$msg .= JText::_('COM_AMPROJECT_ASSIGNED_ID_REQUED').'<br />'; 
		}

		if ($msg != '')	{
      $this->setError($msg);
      $result = false;
    } else {
      $result = true;
    }   
		return $result;
	}
  
  public function canDelete($cid) {
    return true;
  }
  
  public function load($id = null, $reset = true) {
    parent::load($id,$reset);
    if ($id == 0) {
      if (JRequest::getvar('table','') == '') 
        $this->table_type = '#__ampm_wfshema';
      else
        $this->table_type = '#__ampm_'.JRequest::getVar('table');
      $this->table_id = JRequest::getVar('tableid',0);
      $this->type = 60;  // resource_enabled
    }
  }
  
}
