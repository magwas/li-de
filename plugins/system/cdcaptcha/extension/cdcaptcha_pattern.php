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
 * EXTENSION_NAME
 * 
 * @version		VERSION
 */
class CdCaptcha_EXTENSION_NAME {
	
	/**
	 * Enable extension
	 * You can specify the override in plugin configuration, "enable_for_EXTENSION_NAME" param name.
	 * 
	 * @var		int		0 , 1		0 by default.
	 */
	public $enabled = 0;
	
	/**
	 * URL to redirect if captcha failed, use HTTP_REFERER by default.
	 * 
	 * @var string
	 */
	public $redirect = '';
	
	/**
	 * Remember post fields from form
	 * 
	 * @var int		0, 1		1 by default.
	 */
	public $rememberFields = 1;
	
	/**
	 * Set if request is ajaxed or not.
	 * Not all extensions send the correct Ajax server header - HTTP_X_REQUESTED_WITH.
	 * 
	 * @var int		0, 1		0 by default.
	 */
	public $isAjax = 0;
	
	
	/**
	 * Get Instance
	 * 
	 * @return instance
	 */
	function getInstance() {
		static $instance;
		if ($instance == null) $instance = new CdCaptcha_EXTENSION_NAME();
		
		return $instance;
	}
	
	/**
	 * Form object
	 * 
	 * @return		object		Form element for jQuery script.
	 */
	function formObject() {
		
		$formObject = new stdClass();
		
		/**
		 * Form element
		 * Default: empty
		 * 
		 * @var string
		 */
		$formObject->formElement = '';
		
		/**
		 * Disable Captcha based on JavaScript condition
		 * Must return "true" to disable Captcha script.
		 * 
		 * @var string
		 */
		$formObject->doNotUseCondition = "
			if (something) return true;
		";
		
		/**
		 * Submit element in form
		 * input[type="submit"] by default
		 * 
		 * @var string
		 */
		$formObject->submitElement = 'input[type="submit"]';
		
		/**
		 * Place to inject captcha
		 * default is $formObject->submitElement
		 * 
		 * @var string
		 */
		$formObject->prependElement = $formObject->submitElement;
		
		/**
		 * Captcha position.
		 * Values:		before, after
		 * Default:		before
		 * 
		 * @var string
		 */
		$formObject->position = 'before';
		
		
		/**
		 * CSS style for captcha box.
		 * 
		 * Example:
		 * $formObject->additionalBoxStyle = 'width: auto; margin: 5px;';
		 * 
		 * @var string
		 */
		$formObject->additionalBoxStyle = '';
		
		/**
		 * Custom jQuery based function to run after page load.
		 * There are "form" and "container" local variable available.
		 * 
		 * @var string
		 */
		$formObject->scriptDeclaration = "
			console.log('Hello world');
		";
		/**
		 * Run JavaScript function after slider is being switched.
		 * There are "form" and "ui" local variable available.
		 * 
		 * @var string
		 */
		$formObject->sliderStart = "
			console.log('Hello world');
		";
		/**
		 * Run JavaScript function after slider has been switched.
		 * There are "form" and "ui" local variable available.
		 * 
		 * @var string
		 */
		$formObject->sliderStop = "
			console.log('Hello world');
		";
		
		/**
		 * Insert custom JS function at end of document before </body> tag.
		 * 
		 * Result: <script type="text/javascript"> MY_FUNCTION </script>
		 * 
		 * @var string
		 */
		$formObject->customScriptDeclaration = "
			console.log('Hello world');
		";
		
		/**
		 * Set array of form fields (names) to remember if captcha failed.
		 * Please do not insert password field!
		 * 
		 * @var array
		 */
		$formObject->rememberFields = array();
		
		
		// Please use some request variable to enable captcha if possible.
		// just example
		if ($get_task !== 'view_submit_form') {
			// set null object because the task doesn't exist
			$formObject = null; 
		}
		
		// Do not forget to return the created object.
		return $formObject;
	}
	
	/**
	 * Check if captcha is required to check.
	 * 
	 * @return 	boolean			True if captcha has to be checked.
	 */
	function checkCaptchaRules() {
		// EXAMPLE
		
		if (JRequest::getCmd('task', '', 'post') === 'login') {
			// you can set custom redirect URL or leave default (HTTP_REFERER)
			$this->redirect = 'index.php';
			
			return true;
		}
		return false;
	}
	
	/**
	 * Add custom JavaScript function after Captcha is validated (and failed)
	 * and page is loaded with error message in queue.
	 * 
	 * @return		string
	 */
	function scriptDeclarationToQueue() {
		return "
			console.log('Hello world');
		";
	}
	
	/**
	 * Set custom Ajax response message
	 * If user request is called by Ajax, show custom message or use default.
	 * Default: JText::_('PLG_SYSTEM_CDCAPTCHA_INVALID_CAPTCHA');
	 * 
	 * @return string
	 */
	function ajaxResponse() {
		return 'My custom error message showed as result of Ajax Request.';
	}
	
}

?>