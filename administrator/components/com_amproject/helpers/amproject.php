<?php
/**
 * @version		$Id: #component#.php 125 2012-10-09 11:09:48Z michel $
 * @package		Joomla.Framework
 * @subpackage		HTML
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;



class AmprojectHelper
{
	
	/*
	 * Submenu for Joomla 1.6
	 */
	public static function addSubmenu($vName = 'condition')
	{
        
		JSubMenuHelper::addEntry(
			JText::_('Condition'),
			'index.php?option=com_amproject&view=condition',
			($vName == 'condition')
		);

		JSubMenuHelper::addEntry(
			JText::_('Events'),
			'index.php?option=com_amproject&view=events',
			($vName == 'events')
		);

		JSubMenuHelper::addEntry(
			JText::_('Product'),
			'index.php?option=com_amproject&view=product',
			($vName == 'product')
		);

		JSubMenuHelper::addEntry(
			JText::_('Project'),
			'index.php?option=com_amproject&view=project',
			($vName == 'project')
		);

		JSubMenuHelper::addEntry(
			JText::_('Resource'),
			'index.php?option=com_amproject&view=resource',
			($vName == 'resource')
		);

		JSubMenuHelper::addEntry(
			JText::_('Task'),
			'index.php?option=com_amproject&view=task',
			($vName == 'task')
		);

		JSubMenuHelper::addEntry(
			JText::_('Taskshema'),
			'index.php?option=com_amproject&view=taskshema',
			($vName == 'taskshema')
		);

		JSubMenuHelper::addEntry(
			JText::_('Worker'),
			'index.php?option=com_amproject&view=worker',
			($vName == 'worker')
		);

		JSubMenuHelper::addEntry(
			JText::_('Workflow'),
			'index.php?option=com_amproject&view=workflow',
			($vName == 'workflow')
		);

		JSubMenuHelper::addEntry(
			JText::_('Resourcetype'),
			'index.php?option=com_amproject&view=resourcetype',
			($vName == 'resourcetype')
		);

		JSubMenuHelper::addEntry(
			JText::_('Wfshema'),
			'index.php?option=com_amproject&view=wfshema',
			($vName == 'wfshema')
		);

	}
	
	/**
	 * 
	 * Get the Extensions for Categories
	 */
	public static function getExtensions() 
	{
						
		jimport('joomla.utilities.xmlelement');
		
		$xml = simplexml_load_file(JPATH_ADMINISTRATOR.'/components/com_amproject/elements/extensions.xml', 'JXMLElement');		        
		$elements = $xml->xpath('extensions');
		$extensions = $xml->extensions->xpath('descendant-or-self::extension');
		
		return $extensions;
	} 	
}

/**
 * Utility class for categories
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
abstract class JHtmlAmproject
{
	/**
	 * @var	array	Cached array of the category items.
	 */
	protected static $items = array();
	
	/**
	 * Returns the options for extensions list
	 * 
	 * @param string $ext - the extension
	 */
	public static function extensions($ext) 
	{
		$extensions = AmprojectHelper::getExtensions();
		$options = array();
		
		foreach ($extensions as $extension) {   
		
			$option = new stdClass();
			$option->text = JText::_(ucfirst($extension->name));
			$option->value = 'com_amproject.'.$extension->name;
			$options[] = $option;			
		}		
		return JHtml::_('select.options', $options, 'value', 'text', $ext, true);
	}
	
	/**
	 * Returns an array of categories for the given extension.
	 *
	 * @param	string	The extension option.
	 * @param	array	An array of configuration options. By default, only published and unpulbished categories are returned.
	 *
	 * @return	array
	 */
	public static function categories($extension, $cat_id,$name="categories",$title="Select Category", $config = array('attributes'=>'class="inputbox"','filter.published' => array(0,1)))
	{

			$config	= (array) $config;
			$db		= &JFactory::getDbo();

			$query = $db->getQuery(true);

			$query->select('a.id, a.title, a.level');
			$query->from('#__amproject_categories AS a');
			$query->where('a.parent_id > 0');

			// Filter on extension.
			if($extension)
			    $query->where('extension = '.$db->quote($extension));
			
			$attributes = "";
			
			if (isset($config['attributes'])) {
				$attributes = $config['attributes'];
			}
			
			// Filter on the published state
			if (isset($config['filter.published'])) {
				
				if (is_numeric($config['filter.published'])) {
					
					$query->where('a.published = '.(int) $config['filter.published']);
					
				} else if (is_array($config['filter.published'])) {
					
					JArrayHelper::toInteger($config['filter.published']);
					$query->where('a.published IN ('.implode(',', $config['filter.published']).')');
					
				}
			}

			$query->order('a.lft');

			$db->setQuery($query);
			$items = $db->loadObjectList();
			
			// Assemble the list options.
			self::$items = array();
			self::$items[] = JHtml::_('select.option', '', JText::_($title));
			foreach ($items as &$item) {
								
				$item->title = str_repeat('- ', $item->level - 1).$item->title;
				self::$items[] = JHtml::_('select.option', $item->id, $item->title);
			}

		return  JHtml::_('select.genericlist', self::$items, $name, $attributes, 'value', 'text', $cat_id, $name);
		//return self::$items;
	}
}