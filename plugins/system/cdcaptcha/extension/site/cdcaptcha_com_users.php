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
 * Joomla! User Component
 */
class CdCaptcha_com_users
{
	public $name = 'Joomla! User Component';
	
	public $version = '2.5';
	
	public $enabled = 0;

	public $redirect = '';
	
	public $rememberFields = 0;
	
	public $isAjax = 0;

	
	/**
	 * Get Instance
	 * 
	 * @return instance
	 */
	public static function getInstance()
	{
		static $instance;
		if ($instance == null) $instance = new CdCaptcha_com_users();
		
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
		
		$view = JRequest::getCmd('view', '', 'get');
		
		// login form
		switch($view)
		{
			case 'login':
				$formObject->formElement = 'form[action*="' . JRoute::_('index.php?option=com_users&task=user.login', false) . '"]';
				$formObject->submitElement = 'button[type="submit"]';
				break;
				
			case 'registration':
				$formObject->formElement = 'form[action*="' . JRoute::_('index.php?option=com_users&task=registration.register', false) . '"]';
				$formObject->submitElement = 'button[type="submit"]'; 
				$formObject->rememberFields = array( 'jform' =>
					array(
						'name',
						'username',
						'email1',
						'email2'
						)
				);
				break;
			
			case 'reset':
				// confirmation, captcha not necessary
				if (JRequest::getCmd('layout', '', 'get') === 'confirm') return true;
				
				$formObject->formElement = 'form[action*="' . JRoute::_('index.php?option=com_users&task=reset.request', false) . '"]';
				$formObject->submitElement = 'button[type="submit"]';
				break;
				
			case 'remind':
				$formObject->formElement = 'form[action*="' . JRoute::_('index.php?option=com_users&task=remind.remind', false) . '"]';
				$formObject->submitElement = 'button[type="submit"]';
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
		// "get" is from user component, "post" from login module
		$get_task = JRequest::getCmd('task', '', 'get');
		
		switch($get_task)
		{
			case 'user.login':
				return true;
				break;
			case 'reset.request':
				$this->redirect = 'index.php?option=com_users&view=reset';
				return true;
				
				break;
				
			case 'remind.remind':
				$this->redirect = 'index.php?option=com_users&view=remind';
				return true;
				
				break;
				
				default: break;
		}
		
		$post_task = JRequest::getCmd('task', '', 'post');
		
		switch($post_task)
		{
			case 'registration.register':
				$this->redirect = 'index.php?option=com_users&view=registration';
				return true;
				break;
			default:
				break;
		}
		
		return false;
	}
	
}

?>