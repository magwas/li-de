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

// Import library dependencies
jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * Core Design Captcha plugin for Joomla! 2.5
 *
 * @author		Daniel Rataj <info@greatjoomla.com>
 * @package		Core Design
 * @subpackage	System
 */
class PlgSystemCdCaptcha extends JPlugin
{
	private		$livepath			=	'';
	private		$uitheme			= 	'ui-lightness';
	
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		// define language
		$this->loadLanguage();
		
		$this->livepath = JURI::root(true);
        
        // defaults
        $this->formObject = array();
        $this->instances = array();
        $this->remember_fields = (int)$this->params->get('remember_fields', 0);
        $this->customScriptDeclaration = '';
        $this->scriptDeclarationToQueue = '';
        
        $this->isError = false;
    }
    
	/**
	 * Joomla! onAfterRoute() function
	 * 
	 * @return boolean
	 */
	public function onAfterRoute()
	{
		if ($this->isDisabled()) return false;
		
		$document = JFactory::getDocument();
		
		// disable plugin for non-HTML interface (like RSS feed or PDF)
        if ($document->getType() !== 'html') return false;
		
		$application = JFactory::getApplication();
		
		$this->uitheme = $this->params->get('uitheme', 'ui-lightness');
		
		try {
			if ( ! class_exists( 'JScriptegrator' ) )
			{
			    throw new Exception( JText::_( 'PLG_SYSTEM_CDCAPTCHA_ENABLE_SCRIPTEGRATOR' ), 404 );
			}
			
			$JScriptegrator = JScriptegrator::getInstance('2.5.x.2.1.9');
			$JScriptegrator->importLibrary(
			array(
				'jQuery',
				'jQueryUI' => array(
					'uitheme' => $this->uitheme
				)
			));
			
			if ($message = $JScriptegrator->getError())
			{
			    throw new Exception($message, 500);
			}
		} catch (Exception $e) {
			$application->enqueueMessage( $e->getMessage(), 'error' );
			return false;
		}
		
		$appname = $application->getName();
		if ($appname === 'admin') $appname = 'administrator';
		
		$classdir = dirname(__FILE__) . DS . 'extension' . DS . $appname;
		
		$classfiles = JFolder::files($classdir, '^cdcaptcha_.*?\.php$');
		
		foreach($classfiles as $classfile) {
			
			$classfilepath = $classdir . DS . $classfile;
			
			// no file, return false
			if (!JFile::exists($classfilepath)) continue;
			
			// include file (required in fact)
			require_once($classfilepath);
			
			$classname = str_replace( 'cdcaptcha', 'CdCaptcha' , JFile::stripExt($classfile) );
			
			// prevent non-exists class
			if (!class_exists($classname)) continue;
			
			//$class = new $classname;
			
			$getInstance = call_user_func(array($classname, 'getInstance' ) );
			
			$extname = substr($classname, 10);
			
			if (!$this->extensionIsEnabled($extname)) continue;
			
			$enabled_for_extension = $this->params->get('enabled_for_' . $extname, null);
			
			if (!is_null($enabled_for_extension)) {
				$enabled_for_extension = (int)$enabled_for_extension; // set integer
				if ($enabled_for_extension === 0) continue;
			} else {
				// global $getInstance->enabled variable
				if (isset($getInstance->enabled) and $getInstance->enabled === 0) continue;
			}
			
			// add instance to global variable
			$this->instances[] = $getInstance;
		}
		
		// check captcha
		foreach($this->instances as $getInstance)
		{
			if (is_callable(array($getInstance, 'checkCaptchaRules')))
			{
				$checkCaptchaRules = $getInstance->checkCaptchaRules();
				
				if (is_bool($checkCaptchaRules) and $checkCaptchaRules === true)
				{
					$error_msg = JText::_('PLG_SYSTEM_CDCAPTCHA_INVALID_CAPTCHA');
					
					if (!$this->validCaptchaCount())
					{
						$error_msg = JText::_('PLG_SYSTEM_CDCAPTCHA_INVALID_CAPTCHA_COUNT');
					}
					$scope = substr(get_class($getInstance), 10);
					
					if ($this->compareRandom($scope) === false) {
						
						// Ajax Request
						if ($this->isAjax() or isset($getInstance->isAjax) and $getInstance->isAjax === 1)
						{
							
							if (is_callable(array($getInstance, 'ajaxResponse'))) {
								$error_msg = $getInstance->ajaxResponse();
							}
							
							$application->close($error_msg);
						}
						
						// custom redirect URL
						$redirect_url = '';
						if (isset($getInstance->redirect) and $getInstance->redirect)
						{
							$redirect_url = $getInstance->redirect;
						}
						
						// if no custom URL, use the previous one
						if (!$redirect_url)
						{
							if ($_SERVER['HTTP_REFERER'])
							{
								$redirect_url = $_SERVER['HTTP_REFERER'];
							}
							else
							{
								$redirect_url = 'index.php';
							}
						}
						
						// remember send fields (post request)
						if ($this->remember_fields and $getInstance->rememberFields)
						{
							$this->rememberFields('set');
						}
						
						// javascript queue
						if (is_callable(array($getInstance, 'scriptDeclarationToQueue')) and $getInstance->scriptDeclarationToQueue())
						{
							$script = "
							<script type=\"text/javascript\">
							<!--
							if (typeof(jQuery) === 'function') {
								jQuery(document).ready(function($){
									if ($.fn.$this->_name) {
										" . $getInstance->scriptDeclarationToQueue() . "
									}
								});
							}
							//-->
							</script>
							";
							if ($error_msg) $error_msg .= $script;
						}
						
						if (JURI::getInstance()->isInternal($redirect_url))
						{
							$redirect_url = JRoute::_($redirect_url, false);
						}
						
						$application->redirect($redirect_url, $error_msg, 'error');
					}
				}
			}
			
			// FORM OBJECT
			if (is_callable(array($getInstance, 'formObject')))
			{
				$extname = substr(get_class($getInstance), 10);
				
				$formObject = $getInstance->formObject();
				
				if (is_object($formObject) and count((array)$formObject))
				{
					// unset Remember fields if required
					if (isset($getInstance->rememberFields) and $getInstance->rememberFields === 0 and $this->remember_fields === 0)
					{
						if (isset($formObject->rememberFields) and count($formObject->rememberFields))
						{
							unset($formObject->rememberFields);
						}
					}
					
					$formObject->scope = $extname;
					$this->formObject []= $formObject;
				}
			}
		}
		
		if (is_array($this->formObject) and $this->formObject)
		{
			$uri = JFactory::getURI();
			$script_url = $uri->toString(array('path', 'query', 'fragment'));
			unset($uri);
			
			if (strpos($script_url, '?') !== false)
			{
				$script_url = $script_url . '&cdcaptcha=getScript';
			} else {
				$script_url = $script_url . '?cdcaptcha=getScript';
			}
			
			// add random to prevent file caching
			$script_url = $script_url . '&random=' . $this->generateRandom();
			
			$script_url = str_replace( '&', '&amp;', $script_url );
			
			$document->addScript($this->livepath . '/plugins/system/' . $this->_name . '/js/jquery.' . $this->_name . '.js');
			$document->addScript($script_url);
			$document->addStyleSheet($this->livepath . '/plugins/system/' . $this->_name . '/css/jquery.' . $this->_name . '.css');
			
			$autoFormSubmit = 'false';
			if ($this->params->get('autoFormSubmit', 0))
			{
				$autoFormSubmit = 'true';
			}
			
			$slideCaptchaUp = (int) $this->params->get('slideCaptchaUp', 0);
			
			$script = "
if (typeof(jQuery) == 'function') {
	jQuery(document).ready(function($){
		if ($.fn.$this->_name) {
		";
			$script .= "
			$.fn.$this->_name.globalDefaults = ({
				headerText : '" . JText::_('PLG_SYSTEM_CDCAPTCHA_HEADERTEXT', true) . "',
				infoText : '" . JText::_('PLG_SYSTEM_CDCAPTCHA_INFOTEXT', true) . "',
				lockedText : '" . JText::_('PLG_SYSTEM_CDCAPTCHA_LOCKEDTEXT', true) . "',
				unlockedText : '" . JText::_('PLG_SYSTEM_CDCAPTCHA_UNLOCKEDTEXT', true) . "',
				uitheme : '$this->uitheme',
				autoFormSubmit : $autoFormSubmit,
				slideCaptchaUp : $slideCaptchaUp
			});
			";
		
		foreach($this->formObject as $formObject)
		{
				// set defaults
				if (!isset($formObject->formElement)) $formObject->formElement = '';
				if (!isset($formObject->scriptDeclaration)) $formObject->scriptDeclaration = '';
				
				$random = $this->setRandom($formObject->scope);
				
				// custom ajax callback function
				if (isset($formObject->customScriptDeclaration) and $formObject->customScriptDeclaration)
				{
					$this->customScriptDeclaration .= "
					<script type=\"text/javascript\">
					<!--
					" . $formObject->customScriptDeclaration . "
					//-->
					</script>";
				}
				
				$script .= "
			$('$formObject->formElement').$this->_name({";
				
				if (isset($formObject->doNotUseCondition) and $formObject->doNotUseCondition)
				{
					$script .= "
				doNotUseCondition: function(form) {
					$formObject->doNotUseCondition
				},";
				}
				
				if (isset($formObject->prependElement) and $formObject->prependElement)
				{
					$script .= "
				prependElement : '$formObject->prependElement',";
				}
				
				if (isset($formObject->position) and $formObject->position)
				{
					$script .= "
				position : '$formObject->position',";
				}
				
				if (isset($formObject->submitElement) and $formObject->submitElement)
				{
					$script .= "
				submitElement : '$formObject->submitElement',";
				}
				
				if (isset($formObject->additionalBoxStyle) and $formObject->additionalBoxStyle)
				{
					$script .= "
				additionalBoxStyle : '$formObject->additionalBoxStyle',";
				}
				
				if (isset($formObject->scriptDeclaration) and $formObject->scriptDeclaration)
				{
					$script .= "
				scriptDeclaration: function(form, container) {
					$formObject->scriptDeclaration
				},";
				}
				
				if (isset($formObject->sliderStop) and $formObject->sliderStop)
				{
					$script .= "
				sliderStop: function(form, ui) {
					$formObject->sliderStop
				},";
				}
				
				// get remember fields if required
				if (isset($formObject->rememberFields) and count($formObject->rememberFields))
				{
					$isToRemember = 0;
					$rememberFieldsScript = '';
					$rememberFields = $this->rememberFields('get');
					
					foreach($formObject->rememberFields as $count_key=>$field)
					{
						if (!$rememberFields) continue;
						
						if (is_string($count_key) and is_array($field))
						{
							$rememberFieldsScript .= $count_key . ' : { ';
							
							foreach($field as $key=>$value)
							{
								if (!array_key_exists($value, $rememberFields[$count_key])) continue;
						
								// textarea elements requires sanitize the breaks
								$rememberFields[$count_key][$value] = $this->stringToJavaScript($rememberFields[$count_key][$value]);
								
								$rememberFieldsScript .= $value . ' : ' . '\'' . $rememberFields[$count_key][$value] . '\'';
								
								if (isset($formObject->rememberFields[$count_key][$key + 1]))
								{
									$rememberFieldsScript .= ', ';
								}
								
								$isToRemember++; // increase number
							}
							
							$rememberFieldsScript .= ' }';
							
						}
						else
						{
							if (!array_key_exists($field, $rememberFields)) continue;
						
							// textarea elements requires sanitize the breaks
							$rememberFields[$field] = $this->stringToJavaScript($rememberFields[$field]);
							
							$rememberFieldsScript .= $field . ' : ' . '\'' . $rememberFields[$field] . '\'';
							
							
							if (isset($formObject->rememberFields[$count_key + 1]))
							{
						$rememberFieldsScript .= ',
						';
							}
							
							$isToRemember++; // increase number
						}
						
					}
					
					if ($isToRemember)
					{
					$script .= "
				rememberFields: {
					$rememberFieldsScript
				},";
				}
					}
					
				$script .= "
				random : '$random',";

				$script .= "
				scope : '$formObject->scope'";
				
				$script .= "
			});";
			}
			
		$script .= "
		}
		});
	}
	";
			if (JRequest::getCmd('cdcaptcha', '', 'get') === 'getScript')
			{
				$this->rememberFields('clear'); // clear Remember fields
				
				$this->setJSHeader();
				$application->close(trim($script));
			}
			
		}
		
		return true;
	}
	
	private function multi_array_key_exists( $needle, $haystack )
	{
 
	    foreach ( $haystack as $key => $value ) :
	
	        if ( $needle == $key )
	            return true;
	       
	        if ( is_array( $value ) ) :
	             if ( multi_array_key_exists( $needle, $value ) == true )
	                return true;
	             else
	                 continue;
	        endif;
	       
	    endforeach;
	   
	    return false;
	}
	
	/**
	 * Joomla! onAfterRender() function
	 * 
	 * @return void
	 */
	private function onAfterRender()
	{
		$buffer = str_replace('</body>', $this->customScriptDeclaration . '</body>', JResponse::getBody());
		JResponse::setBody($buffer);
	}
	
	/**
	 * Modify string for JavaScript output
	 * 
	 * @param 	string	$text
	 * @return 	string
	 */
	private function stringToJavaScript($text)
	{
   		$text = str_replace(array("\r\n", "\r", "\n"), '\n', $text);
   		$text = addslashes($text);
   		$text = str_replace('\\\\', '\\', $text);
   		$text = str_replace(array('[', ']'), array('\\[', '\\]'), $text);
   		
   		return $text;
	} 
	
	/**
	 * Remember fields wrapper
	 * 
	 * @param 	string	$action			Action to perform (set, get, clear).
	 * @return 	mixed	boolean, array
	 */
	private function rememberFields($action = 'set')
	{
		
		$session = JFactory::getSession();
		$session_name = $this->_name . '_rememberfields';
		
		switch($action)
		{
			case 'set':
				if ($session->set($session_name, JRequest::get('post', 0)))
				{
					return true;
				}
				break;
				
			case 'get':
				return $session->get($session_name, array());
				break;
				
			case 'clear':
				
				$fields = $session->get($session_name, array());
		
				// clear session if there are some elements
				if (count($fields))
				{
					if ($session->clear($session_name))
					{
						return true;
					} else {
						return false;
					}
					
				}
				return true;
				
				break;
				
			default: break;
		}
		
		return false;
	}
	
	/**
	 * Check if extension is really enabled
	 * Just a simple wrapper.
	 * 
	 * @param string	$name
	 * @return boolean	True if extension is disabled.
	 */
	private function extensionIsEnabled($extension_name = '')
	{
		if (!$extension_name) return false;
		
		$extension_type = substr($extension_name, 0, 3);
		
		$setNewBody = false;
		
		switch($extension_type)
		{
			case 'com':
				jimport( 'joomla.application.component.helper' );
				
				// JComponentHelper::isEnabled() function calls error!
				if ($this->extensionInstalled($extension_name)) return true;
				break;
				
			case 'mod':
				jimport( 'joomla.application.module.helper' );
				
				// name has to be without "mod_" string at start
				if (JModuleHelper::isEnabled(substr($extension_name, 4))) return true;
				
				break;
				
			case 'plg':
				jimport( 'joomla.plugin.helper' );
				
				$extname = substr($extension_name, 4);
				
				// name has to be without "plg_" at start
				$plgname = substr($extname, strpos($extname, '_') + 1);
				
				$plgtype = substr($extname, 0, strlen($plgname) * -1 - 1);
				
				if (JPluginHelper::isEnabled($plgtype, $plgname))
				{
					return true;
				}
				
				break;
				
			default: break;
		}
		
		return false;
	}
	
	/**
	 * Check if extension has row in database
	 * 
	 * @param 	string 	$option
 	 * @return 	boolean
	 */
	private function extensionInstalled($option = '')
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('extension_id');
		$query->from('#__extensions');
		$query->where('`type` = '.$db->quote('component'));
		$query->where('`element` = '.$db->quote($option));
		$db->setQuery($query);
		
		if ($error = $db->getErrorMsg())
		{
			// Fatal error.
			JError::raiseWarning(500, JText::sprintf('JLIB_APPLICATION_ERROR_COMPONENT_NOT_LOADING', $option, $error));
			return false;
		}
		
		return (boolean) $db->loadResult();
	}
	
	/**
	 * Check if plugin is disabled
	 * 
	 * @return boolean
	 */
	private function isDisabled()
	{
		// site offline
		$config = JFactory::getConfig();
		if ((int)$config->getValue('config.offline', 0)) return true;
		
		$user = JFactory::getUser();
		
		// super admin
		if($user->authorise('core.admin')) return true;
		
		// disable for logged users
		if ($this->params->get('disable_for_logged', 1))
		{
			// check if user is logged
			if (!$user->guest) return true;
		}
		unset($user);
		
		if ($this->isPromoted()) return true;
		
		return false;
	}
	
	/**
	 * Set JS header
	 * 
	 * @return 	void
	 */
	private function setJSHeader()
	{
		if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) @ob_start('ob_gzhandler');
		
		ob_start();
		
		header("Content-type: application/x-javascript; charset=UTF-8");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		// HTTP/1.1 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false); 
		// HTTP/1.0 
		header("Pragma: no-cache"); 	
	}
	
	/**
	 * Set random
	 * 
	 * @param	$scope		String.
	 * @return	mixed	boolean, string		String if random, boolean (false) if action fails.
	 */
	private function setRandom($scope = '')
	{
		$session = JFactory::getSession();
		
		if ($session_random = $session->get($this->_name . '_' . $scope))
		{
			return $session_random;
		}
		
		$random = $this->generateRandom();
		
		$session->set($this->_name . '_' . $scope, $random);
		return $random;
	}
	
	/**
	 * Compare random
	 * 
	 * @param 	string		$scope		Scope.
	 * @return 	null|boolean
	 */
	private function compareRandom($scope = '')
	{
		$session = JFactory::getSession();
		
		$post_random = JRequest::getString($this->_name . '_' . $scope, '', 'post');
		$random = $session->get($this->_name . '_' . $scope, null);
		
		if (is_null($random)) return null;
		
		if ($post_random === $random)
		{
			// success
			
			// clean cdcaptcha_invalid_count value if exists
			$session->clear($this->_name . '_invalid_count');
			
			// promote
			$cdcaptcha_promote = (int)$session->get($this->_name . '_promote', null);
			$session->set($this->_name . '_promote', ++$cdcaptcha_promote);
			
			// clear captcha session
			$session->clear($this->_name . '_' . $scope);
			
			return true;
		}
		
		// wrong
		
		// set invalid captcha count
		$invalid_captcha_count = (int)$session->get($this->_name . '_invalid_count', null);
		$session->set($this->_name . '_invalid_count', ++$invalid_captcha_count);
		
		// clear captcha session
		$session->clear($this->_name . '_' . $scope);
		
		return false;
	}
	
	/**
	 * Check if captcha count is valid or not.
	 * Good routine for spam robots.
	 * 
	 * @return boolean
	 */
	private function validCaptchaCount()
	{
		$session = JFactory::getSession();
		
		$invalid_count_limit = (int)$this->params->get($this->_name . '_invalid_count', 10);
		
		if ($invalid_count_limit === 0) return true;
		
		if ((int) $session->get($this->_name . '_invalid_count', null) > $invalid_count_limit) return false;
		return true;
	}
	
	/**
	 * Checks whether user has been promoted after having given enough valid responses.
	 * 
	 * @return boolean
	 */
	private function isPromoted()
	{
		$session = JFactory::getSession();
		
		$promoted = (int)$this->params->get($this->_name . '_promote', 5);
		if (!$promoted) return false;
		
		if ((int) $session->get($this->_name . '_promote', null) >= $promoted) return true;
		return false;
	}
	
	/**
	 * Get Random string
	 * 
	 * @return string
	 */
	private function generateRandom()
	{
		// random length from 10 to 30
		$length = mt_rand(10, 30);
		
		$alphanum = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		
        $var_random = '';
        mt_srand(10000000 * (double)microtime());
        for ($i = 0; $i < (int)$length; $i++)
            $var_random .= $alphanum[mt_rand(0, 61)];
        unset($alphanum);
        
        return $var_random;
	}
	
	/**
	 * Check if there is a Ajax Request
	 * 
	 * @return boolean
	 */
	private function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
		($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}
}
?>