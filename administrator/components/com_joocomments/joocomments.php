<?php
/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JPATH_COMPONENT.DS.'controller.php' );
jimport('joomla.application.component.controller');

$jlang =& JFactory::getLanguage();
$jlang->load('com_joocomments', JPATH_SITE, 'en-GB', true);
$jlang->load('com_joocomments', JPATH_SITE, $jlang->getDefault(), true);
$jlang->load('com_joocomments', JPATH_SITE, null, true);
// Back-end translation
$jlang->load('com_joocomments', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_joocomments', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_joocomments', JPATH_ADMINISTRATOR, null, true);



JLog::addLogger(array(
        	'text_file' => 'joocomments.php'),JLog::ALL,
    		array('com_joocomments'));
if( $controller = JRequest::getWord('controller')) 
{
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if(file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
	// Create the controller
	$classname	= 'JooCommentsController'.$controller;
	$controller	= new $classname();
	$controller->execute(JRequest::getCmd('task'));
}else{
$controller	= JController::getInstance('JooComments');
$controller->execute(JRequest::getCmd('task'));
}
$controller->redirect();
?>
