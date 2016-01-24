<?php
/**
 * @package    Joomla.Site
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

 /**
 * Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
 */
define('JOOMLA_MINIMUM_PHP', '5.3.10');

if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . JOOMLA_MINIMUM_PHP . ' or higher to run this version of Joomla!');
}

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('site');


// domain/SU/component/view/task/temakor/szavazas/limit/limitstart/order/urlencode(filterStr) stilusú rövid URL kezelés 
if (JRequest::getVar('option') == '') {
	$w = explode('/',$_SERVER['REQUEST_URI']);
	$i = 0;
	while ($i < count($w)) {
		if ($w[$i] == 'SU') {
			JRequest::setVar('option','com_'.$w[$i+1]);
			JRequest::setVar('view',$w[$i+2]);
			JRequest::setVar('task',$w[$i+3]);
			JRequest::setVar('temakor',$w[$i+4]);
			JRequest::setVar('szavazas',$w[$i+5]);
			JRequest::setVar('limit',$w[$i+6]);
			JRequest::setVar('limitstart',$w[$i+7]);
			JRequest::setVar('order',$w[$i+8]);
			JRequest::setVar('filterStr',urldecode($w[$i+9]));
		    $i = count($w); // kilép a ciklusból 	
		}
		$i = $i + 1;
	}
}


// Execute the application.
$app->execute();
