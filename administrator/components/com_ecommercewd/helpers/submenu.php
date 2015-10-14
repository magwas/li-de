<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdSubmenu {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public static function build() {
        self::addSubmenu('HOME', 'ecommercewd');	
		self::addSubmenu('PRODUCTS', 'products');
        self::addSubmenu('CATEGORIES', 'categories');
        self::addSubmenu('MANUFACTURERS', 'manufacturers');
        self::addSubmenu('ORDERS', 'orders');
        self::addSubmenu('REPORTS', 'reports');
		self::addSubmenu('USERS', 'users');
        self::addSubmenu('LOCALIZATION', 'countries');		
        self::addSubmenu('PAYMENTS', 'payments');
		self::addSubmenu('THEMES', 'themes');
		self::addSubmenu('OPTIONS', 'options');		
		self::addSubmenu('TOOLS_MANAGER', 'installtools');
        
        
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static function addSubmenu($title, $controller) {
        $input_controller = WDFInput::get_controller('ecommercewd');
        JSubMenuHelper::addEntry(WDFText::get($title), 'index.php?option=com_' . WDFHelper::get_com_name() . '&controller=' . $controller . '&reset_filters=1', $input_controller == $controller ? true : false);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}