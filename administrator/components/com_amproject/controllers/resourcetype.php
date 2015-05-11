<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Amproject
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * AmprojectResourcetype Controller
 *
 * @package    Amproject
 * @subpackage Controllers
 */
class AmprojectControllerResourcetype extends AmprojectController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'resourcetype'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('resourcetype');
		$model->move(-1);

		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('resourcetype');
		$model->move(1);

		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname);
	}

	public function saveorder() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		$order = JRequest :: getVar('order', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);
		JArrayHelper :: toInteger($order);

		$model = $this->getModel('resourcetype');
		$model->saveorder($cid, $order);

		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname, $msg);
	}	
}// class
?>