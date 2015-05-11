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

// no direct access
defined('_JEXEC') or die;

/**
 * ZOO
 */
class Cleaners_com_zoo extends JObject
{
	public			$name		=	'ZOO';
	public			$version	=	'2.5.15';
	private static 	$extension 	= 	'com_zoo';
	
	/**
	 * Constructor
	 * 
	 * @param	mixed 	$properties		Either and associative array or another object to set the initial properties of the object.
	 * @return	void
	 */
	public function __construct($properties = null)
	{
		if ($properties !== null)
		{
			$this->setProperties($properties);
		}
	}
	
	/**
	 * Get instance
	 * 
	 * @return	instance
	 */
	public static function getInstance()
	{
		static $instance;
		if (!$instance)
		{
			$instance = new Cleaners_com_zoo();
		}
		return $instance;
	}
	
	/**
	 * Return paths to multiple instances of the same script
	 * 
	 * @return	boolean|array
	 */
	public function cleanScripts()
	{
		if (!class_exists('App'))
		{
			$zoo_filepath = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DS . 'administrator' . DS . 'components' . DS . self::$extension . DS . 'framework' . DS . 'config.php';
			if (!JFile::exists($zoo_filepath)) return false;
			require_once $zoo_filepath;
		}
		
		$zoo = App::getInstance('zoo');
		
		if($zoo->system->application->get('jquery'))
		{
			if ( $zoo->path->url('libraries:jquery/jquery.js') and $zoo->path->url('libraries:jquery/jquery-ui.custom.min.js') ) {
				return array(
					'jquery' => preg_quote($zoo->path->url('libraries:jquery/jquery.js')),
					'jqueryui' => preg_quote($zoo->path->url('libraries:jquery/jquery-ui.custom.min.js'))
				);
			}
		}
		return false;
	}
	
}
?>