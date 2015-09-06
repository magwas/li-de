<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.6 2015-05-14
 * @since       3.3.3
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport( 'joomla.filesystem.path' );
jimport('joomla.form.formfield');

class JFormFieldModal_evt_date extends JFormField
{
	protected $type = 'modal_evt_date';

	protected function getInput()
	{
		$id		= JRequest::getVar('id', '0');
		$class	= JRequest::getVar('class');

		if ($id != 0)
		{
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
			$query->select('r.date AS date, r.eventid AS eventid')
				->from('`#__icagenda_registration` AS r');
			$query->where('(' . $id . ' = r.id)');
			$db->setQuery($query);
			$result = $db->loadObject();

			$event_id	= $result->eventid;
			$saveddate	= $result->date;
		}
		else
		{
			$event_id	= '';
			$saveddate	= '';
		}

		// Test if date saved in in datetime data format
		$date_is_datetime_sql	= false;
		$array_ex_date			= array('-', ' ', ':');
		$d_ex					= str_replace($array_ex_date, '-', $saveddate);
		$d_ex					= explode('-', $d_ex);

		if (count($d_ex) > 4)
		{
			if (   strlen($d_ex[0]) == 4
				&& strlen($d_ex[1]) == 2
				&& strlen($d_ex[2]) == 2
				&& strlen($d_ex[3]) == 2
				&& strlen($d_ex[4]) == 2   )
			{
				$date_is_datetime_sql = true;
			}
		}

		// Test if registered date before 3.3.3 could be converted
		// Control if new date format (Y-m-d H:i:s)
		$input		= trim($saveddate);
		$is_valid	= date('Y-m-d H:i:s', strtotime($input)) == $input;

		if ($is_valid
			&& strtotime($saveddate))
		{
			$date_get		= explode (' ', $saveddate);
			$saved_date		= $date_get['0'];
			$saved_time		= date('H:i:s', strtotime($date_get['1']));
		}
		else
		{
			// Explode to test if stored in old format in database
			$ex_saveddate	= explode (' - ', $saveddate);
			$saved_date		= isset($ex_saveddate['0']) ? trim($ex_saveddate['0']) : '';
			$saved_time		= isset($ex_saveddate['1']) ? trim(date('H:i:s', strtotime($ex_saveddate['1']))) : '';
		}

		$data_eventid = $event_id;

		$eventid_url = JRequest::getVar('eventid', '');

		if ( ! $date_is_datetime_sql && $saveddate )
		{
			$saveddate_text = '"<b>' . $saveddate . '</b>"';
			echo '<div class="ic-alert ic-alert-note"><span class="iCicon-info"></span> <strong>' . JText::_('NOTICE') . '</strong><br />'
				. JText::sprintf('COM_ICAGENDA_REGISTRATION_ERROR_DATE_CONTROL', $saveddate_text) . '</div>';
		}

		$event_id = isset($event_id) ? $eventid_url : '';

		$this->AllDates($saved_date, $saved_time, $event_id, $saveddate, $data_eventid, $date_is_datetime_sql);
	}


	protected function AllDates($saved_date, $saved_time, $event_id, $saveddate, $data_eventid, $date_is_datetime_sql)
	{
		// Preparing connection to db
		$db	= JFactory::getDbo();

		// Preparing the query
		$query = $db->getQuery(true);

		// Selectable items
		$query->select('next AS next, dates AS dates,
						startdate AS startdate, enddate AS enddate, weekdays AS weekdays,
						id AS id, state AS state, access AS access, params AS params');
		$query->from('`#__icagenda_events` AS e');
//		$query->where(' e.id = '.$event_id);

		$list_of_dates_id = $event_id ? $event_id : $data_eventid;

		if ($list_of_dates_id)
		{
			$query->where('(' . $list_of_dates_id . ' = e.id)');
		}
		$db->setQuery($query);

		$allnext = $db->loadObjectList();

		foreach ($allnext as $i)
		{
			// Set Event Params
			$eventparam		= new JRegistry($i->params);

			$typeReg		= $eventparam->get('typeReg');

			// Declare AllDates array
			$AllDates		= array();

			// Get WeekDays setting
			$WeeksDays		= iCDatePeriod::weekdaysToArray($i->weekdays);

			// If Single Dates, added each one to All Dates for this event
			$singledates	= iCString::isSerialized($i->dates) ? unserialize($i->dates) : array();

			foreach($singledates as $sd)
			{
				$isValid = iCDate::isDate($sd);

				if ($isValid)
				{
					array_push($AllDates, $sd);
				}
			}

			// If Period Dates, added each one to All Dates for this event (filter week Days, and if date not null)
			$perioddates = iCDatePeriod::listDates($i->startdate, $i->enddate);

			$onlyStDate = isset($this->onlyStDate) ? $this->onlyStDate : '';

			if (isset($perioddates)
				&& is_array($perioddates))
			{
				foreach ($perioddates as $Dat)
				{
					if (in_array(date('w', strtotime($Dat)), $WeeksDays))
					{
						// May not work in php < 5.2.3 (should return false if date null since 5.2.4)
						$isValid = iCDate::isDate($Dat);

						if ($isValid)
						{
							$SingleDate = date('Y-m-d H:i', strtotime($Dat));
							array_push($AllDates, $SingleDate);
						}
					}
				}
			}
		}

		$today = time();

		// get Time Format
		$timeformat = JComponentHelper::getParams('com_icagenda')->get('timeformat', '1');

		$lang_time = ($timeformat == 1) ? 'H:i' : 'h:i A';

		if ( ! empty($AllDates))
		{
			sort($AllDates);
		}

		$eventid_url = JRequest::getVar('eventid', '');

		echo '<div>';
		echo '<select type="hidden" name="'.$this->name.'">';

		if ( ! $eventid_url || $eventid_url == $data_eventid)
		{
			$date_value = $saveddate;
		}
		else
		{
			$date_value = '';
		}

		$selected = ! strtotime($saveddate) ? ' selected="selected"' : '';

		$reg_datetime = date('Y-m-d H:i:s', strtotime($saved_date . ' ' . $saved_time));

		$is_valid = date('Y-m-d H:i:s', strtotime($reg_datetime)) == $saveddate;

		$if_old_value = !$is_valid ? $saveddate : '';

		echo '<option value="' . $if_old_value . '">- ' . JText::_( 'COM_ICAGENDA_REGISTRATION_NO_DATE_SELECTED' ) . ' -</option>';

		$date_exist = false;

		if ($list_of_dates_id)
		{
			foreach($AllDates as $date)
			{
				if ($date && $date != '0000-00-00 00:00' && $date != '0000-00-00 00:00:00')
				{
					$value_datetime = date('Y-m-d H:i:s', strtotime($date));

					echo '<option value="' . $value_datetime . '"';

					if ($reg_datetime == $value_datetime)
					{
						$date_exist = true;
						echo ' selected="selected"';
					}

					echo '>'.$this->formatDate($date).' - '.date($lang_time, strtotime($date)).'</option>';
				}
			}
		}
		echo '</select>';
		echo '</div>';

		if ( ! empty($AllDates)
			&& ! in_array(date('Y-m-d H:i', strtotime($saveddate)), $AllDates)
			&& $date_is_datetime_sql )
		{
			$date_no_longer_exists = '<strong>"'.$saveddate.'"</strong>';
			echo '<div class="alert alert-error"><strong>' . JText::_('COM_ICAGENDA_FORM_WARNING') . '</strong><br /><small>' . JText::sprintf('COM_ICAGENDA_REGISTRATION_DATE_NO_LONGER_EXISTS', $date_no_longer_exists) . '</small></div>';
		}
	}


	// Function to get Format Date (using option format, and translation)
	protected function formatDate ($date)
	{
		// Date Format Option (Global Component Option)
		$date_format_global	= JComponentHelper::getParams('com_icagenda')->get('date_format_global', 'Y - m - d');
		$format				= ($date_format_global != 0) ? $date_format_global : 'Y - m - d'; // Previous 3.5.6 setting

		// Separator Option
		$separator			= JComponentHelper::getParams('com_icagenda')->get('date_separator', ' ');

		if ( ! is_numeric($format))
		{
			// Update old Date Format options of versions before 2.1.7
			$format = str_replace(array('nosep', 'nosep', 'sepb', 'sepa'), '', $format);
			$format = str_replace('.', ' .', $format);
			$format = str_replace(',', ' ,', $format);
		}

		$dateFormatted = iCGlobalize::dateFormat($date, $format, $separator);

		return $dateFormatted;
	}
}
