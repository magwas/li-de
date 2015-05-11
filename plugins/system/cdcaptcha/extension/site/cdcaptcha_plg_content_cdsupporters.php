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
 * Core Design Article Supporters plugin
 */
class CdCaptcha_plg_content_cdsupporters
{
	public $name = 'Core Design Supporters plugin';
	
	public $version = '2.5.x.1.0.0';
	
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
		if ($instance == null) $instance = new CdCaptcha_plg_content_cdsupporters();
		
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
		$formObject->formElement = '.submitSupporterForm form';
		$formObject->submitElement = 'button[type="submit"]';
		$formObject->additionalBoxStyle = 'width: auto;';
		
		return $formObject;
	}
	
	/**
	 * Check captcha if required
	 * 
	 * @return 	boolean			True if captcha is checked.
	 */
	public function checkCaptchaRules()
	{
		$post_task = JRequest::getCmd('cdsupporters_task', '', 'post');
		
		if ($post_task === 'addSupporter') return true;
		
		return false;
	}
	
	/**
	 * Set custom Ajax response
	 * 
	 * @return string
	 */
	public function ajaxResponse()
	{
		return '0|' . JText::_('PLG_SYSTEM_CDCAPTCHA_INVALID_CAPTCHA');
	}
	
}

?>