<?php
/**
* @version		$Id:events.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableEvents class
*
* @package		Amproject
* @subpackage	Tables
*/
class TableEvents extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar tablename  **/
   public $tablename = null;

   /** @var int table_id  **/
   public $table_id = null;

   /** @var int volume  **/
   public $volume = null;

   /** @var varchar type  **/
   public $type = null;

   /** @var int user_id  **/
   public $user_id = null;

   /** @var time time  **/
   public $time = null;

   /** @var int newstate  **/
   public $newstate = null;

   public $oldrec = null;
   public $newrec = null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__ampm_events', 'id', $db);
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
	public function check()
	{



		/** check for valid name */
		/**
		if (trim($this->tablename) == '') {
			$this->setError(JText::_('Your Events must contain a tablename.')); 
			return false;
		}
		**/		

		return true;
	}
}
