<?php
/**
 * @version		$Id: //depot/dev/Joomla/Joo_Comments/ver_1_0_0/com_joocomments/admin/models/articlesettings.php#2 $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_config
 */
class JooCommentsModelArticleSettings extends JModelForm
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState()
	{
		// Set the component (option) we are dealing with.
		$component = JRequest::getCmd('component');
		$this->setState('component.option','com_helloworld');

		// Set an alternative path for the configuration file.
		if ($path = JRequest::getString('path')) {
			$path = JPath::clean(JPATH_SITE . '/' . $path);
			JPath::check($path);
			$this->setState('component.path', $path);
		}
	}

	/**
	 * Method to get a form object.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');

		if ($path = $this->getState('component.path')) {
			// Add the search path for the admin component config.xml file.
			JForm::addFormPath($path);
		}
		else {
			// Add the search path for the admin component config.xml file.
			JForm::addFormPath(JPATH_ADMINISTRATOR.'/components/'.$this->getState('component.option'));
		}

		// Get the form.
		$form = $this->loadForm(
				'com_config.component',
				'config',
				array('control' => 'jform', 'load_data' => $loadData),
				false,
				'/config'
			);

		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Get the component information.
	 *
	 * @return	object
	 * @since	1.6
	 */
	function getComponent()
	{
		// Initialise variables.
		$option = $this->getState('component.option');

		// Load common and local language files.
		$lang = JFactory::getLanguage();
			$lang->load($option, JPATH_BASE, null, false, false)
		||	$lang->load($option, JPATH_BASE . "/components/$option", null, false, false)
		||	$lang->load($option, JPATH_BASE, $lang->getDefault(), false, false)
		||	$lang->load($option, JPATH_BASE . "/components/$option", $lang->getDefault(), false, false);

		$result = JComponentHelper::getComponent($option);

		return $result;
	}

	
	function retriveData($parentId,$recursive=false){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('con.id,con.title,con.attribs');
		// From the hello table
		$query->from('#__content as con');
		$query->where('con.catid='.$parentId);
		$query->order('con.id');
		$db->setQuery($query);

		return $db->loadAssocList();
	}
	
	function updateCmtStatus($articleId,$status){
		
	}
}