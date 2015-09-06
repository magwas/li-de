<?php
/**
 *------------------------------------------------------------------------------
 *  iC Library - Library by Jooml!C, for Joomla!
 *------------------------------------------------------------------------------
 * @package     iC Library
 * @subpackage  date
 * @copyright   Copyright (c)2014-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     1.3.1 2015-07-07
 * @since       1.3.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

/**
 * class iCDate
 */
class iCGlobalize
{
	/**
	 * Function to get Format Date (using option format, and translation)
	 *
	 * @access	public static
	 * @param	$date : date to be formatted (1993-04-30 14:33:00)
	 * 			$option : date format selected
	 * @return	formatted date
	 *
	 * @since   1.3.0
	 */
	static public function dateFormat($date, $format, $separator, $tz = null)
	{
		$eventTimeZone	= $tz ? $tz : null;

		$lang			= JFactory::getLanguage();
		$langTag		= $lang->getTag();
		$langName		= $lang->getName();

		if ( ! file_exists(JPATH_LIBRARIES . '/ic_library/globalize/culture/' . $langTag . '.php'))
		{
			$langTag = 'en-GB';
		}

		$globalize		= JPATH_LIBRARIES . '/ic_library/globalize/culture/' . $langTag . '.php';
		$iso			= JPATH_LIBRARIES . '/ic_library/globalize/culture/iso.php';

		if (is_numeric($format))
		{
			require $globalize;
		}
		else
		{
			require $iso;
		}

		// Load Globalization Date Format if selected
		if ($format == '1') {$format = $datevalue_1;}
		elseif ($format == '2') {$format = $datevalue_2;}
		elseif ($format == '3') {$format = $datevalue_3;}
		elseif ($format == '4') {$format = $datevalue_4;}
		elseif ($format == '5') {
			if (($langTag == 'en-GB') || ($langTag == 'en-US')) {
				$format = $datevalue_5;
			} else {
				$format = $datevalue_4;
			}
		}
		elseif ($format == '6') {$format = $datevalue_6;}
		elseif ($format == '7') {$format = $datevalue_7;}
		elseif ($format == '8') {$format = $datevalue_8;}
		elseif ($format == '9') {
			if ($langTag == 'en-GB') {
				$format = $datevalue_9;
			} else {
				$format = $datevalue_7;
			}
		}
		elseif ($format == '10') {
			if ($langTag == 'en-GB') {
				$format = $datevalue_10;
			} else {
				$format = $datevalue_8;
			}
		}
		elseif ($format == '11') {$format = $datevalue_11;}
		elseif ($format == '12') {$format = $datevalue_12;}

		// Explode components of the date
		$exformat = explode (' ', $format);

		$dateFormatted	= '';

		// Day with no 0 (test if Windows server)
//		$dayj = '%e';

//		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
//		{
//  		$dayj = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $dayj);
//		}

		// Date Formatting using strings of Joomla Core Translations (update 3.1.4)
		if ($tz === false)
		{
			$thisDate = date('Y-m-d', strtotime($date));
		}
		else
		{
			$thisDate = JHtml::date($date, 'Y-m-d', $eventTimeZone);
		}

		foreach ($exformat as $k => $val)
		{
			switch($val)
			{
				// Day
				case 'd':
					$val = date("d", strtotime("$thisDate"));
					break;

				case 'j':
					$val = date("j", strtotime("$thisDate"));
					break;

				case 'D':
					$val = JText::_(date("D", strtotime("$thisDate")));
					break;

				case 'l':
					$val = JText::_(date("l", strtotime("$thisDate")));
					break;

				case 'S':
					$val = '<sup>' . date("S", strtotime("$thisDate")) . '</sup>';
					break;

				case 'dS':
					$val = date("d", strtotime("$thisDate")) . '<sup>' . date("S", strtotime("$thisDate")) . '</sup>';
					break;

				case 'jS':
					$val = date("j", strtotime("$thisDate")) . '<sup>' . date("S", strtotime("$thisDate")) . '</sup>';
					break;

				// Month
				case 'm':
					$val = date("m", strtotime("$thisDate"));
					break;

				case 'F':
					$val = JText::_(date('F', strtotime($thisDate)));
					break;

				case 'M':
					$val = JText::_(date('F', strtotime($thisDate)) . '_SHORT');
					break;

				case 'n':
					$val = date("n", strtotime("$thisDate"));
					break;

				// year (v3)
				case 'Y':
//					$val = JHtml::date($thisDate, 'Y', $eventTimeZone);
					$val = date("Y", strtotime("$thisDate"));
					break;

				case 'y':
					$val = date("y", strtotime("$thisDate"));
					break;

				// separators of the components (v2)
				case '*':
					$val = $separator;
					break;
				case '_':
					$val = '&nbsp;';
//					$val = '&#160;';
					break;
//				case '/': $val='/'; break;
//				case '.': $val='.'; break;
//				case '-': $val='-'; break;
//				case ',': $val=','; break;
//				case 'the': $val='the'; break;
//				case 'gada': $val='gada'; break;
//				case 'de': $val='de'; break;
//				case 'г.': $val='г.'; break;
//				case 'den': $val='den'; break;
//				case 'ukp.': $val = '&#1088;.'; break;


				// day
				case 'N':
					$val = strftime("%u", strtotime("$thisDate"));
					break;
				case 'w':
					$val = strftime("%w", strtotime("$thisDate"));
					break;
				case 'z':
					$val = strftime("%j", strtotime("$thisDate"));
					break;

				// week
				case 'W':
					$val = date("W", strtotime("$thisDate"));
					break;

				// month
				case 'n':
					$val = $separator . date("n", strtotime("$thisDate")) . $separator;
					break;

				// time
//				case 'H':
//					$val = date("H", strtotime("$thisDate"));
//					break;
//				case 'i':
//					$val = date("i", strtotime("$thisDate"));
//					break;

				// Default
				default:
					$val;
					break;
			}

			$dateFormatted.= ($k !== 0) ? '' . $val : $val;
		}

		return $dateFormatted;
	}
}
