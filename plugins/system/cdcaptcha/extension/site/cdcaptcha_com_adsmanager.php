<?php
/**
 * Core Design Captcha plugin for Joomla! 1.5
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
 * Adsmanager
 */
class CdCaptcha_com_adsmanager
{
	public $name = 'Adsmanager';
	
	public $version = '2.6.5';
	
	var $enabled = 0;
	
	var $redirect = '';
	
	var $rememberFields = 1;
	
	var $isAjax = 0;
	
	
	/**
	 * Get Instance
	 * 
	 * @return instance
	 */
	public static function getInstance()
	{
		static $instance;
		if ($instance == null) $instance = new CdCaptcha_com_adsmanager();
		
		return $instance;
	}
	
	/**
	 * Form object
	 * 
	 * @return object		Form element.
	 */
	public function formObject()
	{
		$formObject = new stdClass();
		
		// write new
		switch(JRequest::getCmd('task', '', 'get'))
		{
			case 'write':
				if (JRequest::getInt('catid', 0, 'get'))
				{
					$formObject->formElement = 'fieldset#adsmanager_fieldset';
					$formObject->prependElement = 'tr:last';
					$formObject->scriptDeclaration = "
						container.wrap('<td>');
						container.closest('td').wrap('<tr>');
						container.closest('tr').prepend('<td>');
						
						var captcha_id = container.find('input:hidden');
						
						$('form[name=\"adminForm\"]').submit(function() {
							$(this).append(captcha_id);
						});
					";
				}
				break;
			
			case 'message':
				$formObject->formElement = 'fieldset#adsmanager_fieldset';
				$formObject->submitElement = 'input[type="button"]';
				$formObject->rememberFields =
				array(
					'name',
					'email',
					'title',
					'body'
				);
				break;
				
			default:
				break;
		}
		
		switch(JRequest::getCmd('view', '', 'get'))
		{
			case 'message':
				$formObject->formElement = 'fieldset#adsmanager_fieldset';
				$formObject->submitElement = 'input[type="button"]';
				$formObject->rememberFields =
				array(
					'name',
					'email',
					'title',
					'body'
				);
				break;
				
			default:
				break;
		}
		
		return $formObject;
	}
	
	/**
	 * Check captcha if required
	 * 
	 * @return 	boolean			True if captcha is checked.
	 */
	public function checkCaptchaRules()
	{
		$task = JRequest::getCmd('task', '', 'get');
		
		switch($task)
		{
			case 'save':
			case 'sendmessage':
				return true;
				break;
			default: break;
		}
		
		return false;
	}
	
}

?>