<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Kepviselojeloltek
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * KepviselojeloltekKepviselojeloltek Controller
 *
 * @package    Kepviselojeloltek
 * @subpackage Controllers
 */
class KepviselojeloltekControllerKepviselojeloltek extends KepviselojeloltekController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'kepviselojeloltek'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	

	
	
}// class
?>