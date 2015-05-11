<?php
/**
* @version		$Id:project.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Tables
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableProject class
*
* @package		Amproject
* @subpackage	Tables
*/
class TableProject extends JTable
{
	
   /** @var int id- Primary Key  **/
   public $id = null;

   /** @var varchar title  **/
   public $title = null;

   /** @var text description  **/
   public $description = null;

   /** @var int ordering  **/
   public $ordering = null;

   /** @var int volume  **/
   public $volume = null;

   /** @var varchar unit  **/
   public $unit = null;

   /** @var date start  **/
   public $start = null;

   /** @var date deadline  **/
   public $deadline = null;

   /** @var int priority  **/
   public $priority = null;

   /** @var int manager_id  **/
   public $manager_id = null;

   /** @var int sate  **/
   public $state = null;

   /** @var amprojectproduct product_id  **/
   public $product_id = null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__ampm_project', 'id', $db);
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
		if ($this->id === 0) {
			//get next ordering

			
			$this->ordering = $this->getNextOrder( );

		}


		/** check for valid name */
		/**
		if (trim($this->title) == '') {
			$this->setError(JText::_('Your Project must contain a title.')); 
			return false;
		}
		**/		

		return true;
	}
}
