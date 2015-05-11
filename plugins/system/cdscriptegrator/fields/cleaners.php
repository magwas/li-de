<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 2.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		2.5.x.2.2.3
 * @copyright	Copyright (C) 2007 - 2012 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.form.formfield');
jimport('joomla.filesystem.folder');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldCleaners extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public	$type 		= 'Cleaners';
	
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		return '';
	}
	
	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getLabel()
	{
		$html = '';
		
		// cleaners dir
		$cleaners_dir = dirname(dirname(__FILE__)) . DS . 'cleaners';
		
		$cleaners = JFolder::files($cleaners_dir, "\.php$", false, true);
		
		$instances = array();
		
		foreach($cleaners as $cleaner)
		{
			require_once $cleaner;
			
			$extension = JFile::stripExt(basename($cleaner));
			$classname = 'cleaners_' . $extension;
			
			if (!is_callable($classname, 'getInstance')) continue;
			
			$instances[] = call_user_func(array($classname, 'getInstance'));
		}
		
		unset($cleaners);
		
		$html .= '<div style="clear: both;"></div>';
		$html .= '<p style="font-style:italic; font-size: 95%;">';
			$html .= JText::_('PLG_SYSTEM_CDSCRIPTEGRATOR_FORM_FIELD_CLEANERS_DESCRIPTION');
		$html .= '</p>';
		$html .= '<h4>';
			$html .= JText::_('PLG_SYSTEM_CDSCRIPTEGRATOR_FORM_FIELD_CLEANERS_SUPPORTED_EXTENSIONS');
		$html .= '</h4>';
		
		// sort array of objects by name
		jimport('joomla.utilities.arrayhelper');
		$instances = JArrayHelper::sortObjects($instances, 'name');
		
		$html .= '<table border="0" cellspacing="5" cellpadding="3">';
			$html .= '<tr>';
				$html .= '<th>';
					$html .= JText::_('PLG_SYSTEM_CDSCRIPTEGRATOR_FORM_FIELD_CLEANERS_EXTENSION');
				$html .= '</th>';
				$html .= '<th>';
					$html .= JText::_('PLG_SYSTEM_CDSCRIPTEGRATOR_FORM_FIELD_CLEANERS_VERSION');
				$html .= '</th>';
				$html .= '<th>';
					$html .= JText::_('PLG_SYSTEM_CDSCRIPTEGRATOR_FORM_FIELD_CLEANERS_NOTE');
				$html .= '</th>';
			$html .= '</tr>';
			foreach($instances as $instance)
			{
				$html .= '<tr>';
					$html .= '<td>';
						$html .= $instance->name;
					$html .= '</td>';
					$html .= '<td>';
						$html .= $instance->version;
					$html .= '</td>';
					if ( isset( $instance->note ) and $instance->note ) {
						$html .= '<td style="font-style: italic;">';
							$html .= $instance->note;
						$html .= '</td>';
					} else {
						$html .= '<td></td>';
					}
				$html .= '</tr>';
			}
		$html .= '</table>';
		
		unset($instances);
		
		return $html;
	}
}
?>