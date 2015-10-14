<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFHelperFunctions {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
	/*
	/function for converting object to array
	/ @params object 
	*/
	public static function object_to_array($data) {
	
		if ((! is_array($data)) and (! is_object($data))){ 
			return $data; 
		}	

		$result = array();
		$data = (array) $data;
		foreach ($data as $key => $value) {
			if (is_object($value)) $value = (array) $value;
			if (is_array($value)) 
			$result[$key] = self::object_to_array($value);
			else
				$result[$key] = $value;
		}

		return $result;
	}
	
	/*
	/function for multidimensional array differences
	/ @params array, array 
	*/
	
	public static function multidimensional_array_diff($arr1, $arr2) {
		$result = array();
		foreach($arr1 as $k1 => $v1) {
			if (!array_key_exists($k1, $arr2)) {
			   $result = $v1; 
			   continue;
			}

			if (is_array($v1) && is_array($arr2[$k1])) {
				$result = self::multidimensional_array_diff($v1, $arr2[$k1]);
				continue;
			}

			if ((string)$arr1[$k1] === (string)$arr2[$k1]) {
				continue;
			}

			$result = $v1;
		}

		return $result;
	}
	
 
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
	

}
