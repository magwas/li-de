<?php
/**
 * Core Design Captcha plugin for Joomla! 2.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		2.5.x.2.0.6
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

// no direct access
defined('_JEXEC') or die;

/**
 * Almond Classifieds 
 */
class CdCaptcha_com_aclsfgpl
{
	public $name = 'Almond Classifieds';
	
	public $version = '5.4';
	
	public $enabled = 0;
	
	public $redirect = '';
	
	public $rememberFields = 1;
	
	public $isAjax = 0;
	
	
	/**
	 * Get Instance
	 * 
	 * @return instance
	 */
	public static function getInstance()
	{
		static $instance;
		if ($instance == null) $instance = new CdCaptcha_com_aclsfgpl();
		
		return $instance;
	}
	
	/**
	 * Form object
	 * 
	 * @return		object		Form element.
	 */
	public function formObject()
	{
		$formObject = new stdClass();
		
		if (JRequest::getCmd('md', '', 'get') === 'add_form')
		{
			$formObject->formElement = 'form[action*="' . JRoute::_('index.php?option=com_aclsfgpl', false) . '"]';
			$formObject->submitElement = 'input[type="button"]';
		}
		
		return $formObject;
	}
	
	/**
	 * Check captcha if required
	 * 
	 * @return 	boolean			True if captcha is checked.
	 */
	public function checkCaptchaRules() {
		if (JRequest::getCmd('md', '', 'get') === 'submitad')
		{
			return true;
		}
		return false;
	}
}

?>