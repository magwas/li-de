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
 * Joomla! Admin Login Component
 */
class CdCaptcha_com_login
{
	public $name = 'Joomla! Admin Login';
	
	public $version = '2.5';
	
	public $enabled = 0;
	
	public $redirect = '';
	
	public $rememberFields = 1;
	
	/**
	 * Get Instance
	 * 
	 * @return instance
	 */
	public static function getInstance()
	{
		static $instance;
		if ($instance == null) $instance = new CdCaptcha_com_login();
		
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
		
		// login form
		if (JAdministratorHelper::findOption() === 'com_login')
		{
			$formObject->formElement = 'form#form-login';
			$formObject->prependElement = 'div.button-holder';
			$formObject->additionalBoxStyle = 'margin: 20px auto 10px auto;';
			$formObject->scriptDeclaration = "
					var holder = $('div.button-holder', form);
					holder.css('opacity', '.5');
					$($('a', holder)).removeAttr('onclick').click(function(e){
						e.preventDefault();
						$(this).closest('form').submit();
					});
					form.closest('.wbg').append($('<div />').css('clear', 'both'));
			";
			$formObject->sliderStop = "
				if ( $(ui).slider('option', 'value') === 1 ) {
					$('div.button-holder', form).css('opacity', 1);
				} else {
					$('div.button-holder', form).css('opacity', '.5');
				}
			";
		}
		
		return $formObject;
	}
	
	/**
	 * Check captcha if required
	 * 
	 * @param	$request		array
	 * @return 	boolean			True if captcha is checked.
	 */
	public function checkCaptchaRules()
	{
		// login form, component com_user
		if (JRequest::getCmd('task', '', 'post') === 'login')
		{
			return true;
		}
		
		return false;
	}
	
}

?>