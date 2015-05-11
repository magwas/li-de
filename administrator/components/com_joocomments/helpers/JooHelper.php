<?php
/**
 * @version		$Id: //depot/dev/Joomla/Joo_Comments/ver_1_0_0/com_joocomments/admin/helpers/JooHelper.php#2 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

/**


 */
class JooHelper
{
	/**
	 * Configure the Linkbar,.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($view)
	{
		// building the submenu
		JSubMenuHelper::addEntry('JooComments '.JText::_( 'COM_JOOCOMMENTS_VIEW_NAMES_JOOCOMMENTS_HOME' ), 'index.php?option=com_joocomments&view=home',$view=='home');
		JSubMenuHelper::addEntry( JText::_( 'COM_JOOCOMMENTS_VIEW_NAMES_APPROVED_COMMENTS' ), 'index.php?option=com_joocomments&view=published',$view=='published');
		JSubMenuHelper::addEntry( JText::_( 'COM_JOOCOMMENTS_VIEW_NAMES_UNAPPROVED_COMMENTS' ), 'index.php?option=com_joocomments&view=unpublished',$view=='unpublished');
		JSubMenuHelper::addEntry( JText::_( 'COM_JOOCOMMENTS_VIEW_NAMES_CONFIGURATION' ), 'index.php?option=com_joocomments&view=settings',$view=='settings');
	}
}