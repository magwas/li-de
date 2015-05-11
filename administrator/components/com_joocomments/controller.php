<?php

/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');

class JooCommentsController extends  JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false) 
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'home'));
 		require_once JPATH_COMPONENT.'/helpers/JooHelper.php';
		// call parent behavior
		$view=JRequest::getCmd('view', 'home');
 		JooHelper::addSubmenu($view);
		parent::display($cachable);
	}
}
