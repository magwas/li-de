<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

define('DEV_MODE', false);

// J3
if (defined('DS') == false) {
    define('DS', DIRECTORY_SEPARATOR);
}

//prepare framework
require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_ecommercewd' . DS . 'framework' . DS . 'WDFHelper.php';
WDFHelper::init();

//include
JTable::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_ecommercewd' . DS . 'tables');

//submenu
require_once WDFPath::get_com_admin_path() . DS . 'helpers' . DS . 'submenu.php';
if( (WDFInput::get("task") != "add" and WDFInput::get("task") != "edit" and  WDFInput::get("task") != "edit_refresh" and  WDFInput::get("task") != "add_refresh" and WDFInput::get("task") != "view") or WDFInput::get("task") == ""  )
	EcommercewdSubmenu::build();

//subtoolbar
require_once WDFPath::get_com_admin_path() . DS . 'helpers' . DS . 'sub_toolbar.php';

//helper classes
require_once WDFPath::get_com_admin_path() . DS . 'helpers' . DS . 'order.php';

//get current controller and execute current task
$controller = WDFHelper::get_controller();
$task = WDFInput::get_task();
$controller->execute($task);
$controller->redirect();