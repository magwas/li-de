<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril RezŽ, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril RezŽ (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version     3.5.7 2015-07-13
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

jimport('joomla.application.component.controlleradmin');

/**
 * Registrations list controller class.
 */
class iCagendaControllerRegistrations extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'event', $prefix = 'iCagendaModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
}
