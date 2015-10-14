<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdSubToolbar {
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
        $url_base = 'index.php?option=com_'.WDFHelper::get_com_name().'&reset_filters=1&controller=';

        $controller = WDFInput::get_controller();
        switch ($controller) {
            case '':
            case 'ecommercewd':
                WDFSubToolbar::add_item(WDFText::get('CATEGORIES'), $url_base . 'categories', 'categories', $controller == 'categories' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('MANUFACTURERS'), $url_base . 'manufacturers', 'manufacturers', $controller == 'manufacturers' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('PRODUCTS'), $url_base . 'products', 'products', $controller == 'products' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('BULK_ACTIONS'), $url_base . 'bulkactions', 'bulkactions', $controller == 'bulkactions' ? true : false);
				WDFSubToolbar::add_browse_tools_link();
				echo WDFSubToolbar::get_sub_toolbar();

                WDFSubToolbar::add_item(WDFText::get('TAXES'), $url_base . 'taxes', 'taxes', $controller == 'taxes' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('DISCOUNTS'), $url_base . 'discounts', 'discounts', $controller == 'discounts' ? true : false);
                WDFSubToolbar::add_divider();
                WDFSubToolbar::add_item(WDFText::get('FEEDBACK'), $url_base . 'feedback', 'feedback', $controller == 'feedback' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('RATINGS'), $url_base . 'ratings', 'ratings', $controller == 'ratings' ? true : false);
                WDFSubToolbar::add_divider();
                WDFSubToolbar::add_item(WDFText::get('TAGS'), $url_base . 'tags', 'tags', $controller == 'tags' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('PARAMETERS'), $url_base . 'parameters', 'parameters', $controller == 'parameters' ? true : false);
                WDFSubToolbar::add_divider();
                WDFSubToolbar::add_item(WDFText::get('LICENSING'), $url_base . 'pages', 'pages', $controller == 'pages' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('LABELS'), $url_base . 'labels', 'labels', $controller == 'labels' ? true : false);
                echo WDFSubToolbar::get_sub_toolbar();

                WDFSubToolbar::add_item(WDFText::get('PAYMENTS'), $url_base . 'payments', 'payments', $controller == 'payments' ? true : false);
                WDFSubToolbar::add_divider();
				WDFSubToolbar::add_item(WDFText::get('ORDERS'), $url_base . 'orders', 'orders', $controller == 'orders' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('ORDER_STATUSES'), $url_base . 'orderstatuses', 'orderstatuses', $controller == 'orderstatuses' ? true : false);
                WDFSubToolbar::add_divider();
				WDFSubToolbar::add_item(WDFText::get('REPORTS'), $url_base . 'reports', 'reports', $controller == 'reports' ? true : false);
			    echo WDFSubToolbar::get_sub_toolbar();

                WDFSubToolbar::add_item(WDFText::get('COUNTRIES'), $url_base . 'countries', 'countries', $controller == 'countries' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('CURRENCIES'), $url_base . 'currencies', 'currencies', $controller == 'currencies' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('SHIPPING_METHODS'), $url_base . 'shippingmethods', 'shippingmethods', $controller == 'shippingmethods' ? true : false);
                echo WDFSubToolbar::get_sub_toolbar();

                WDFSubToolbar::add_item(WDFText::get('USERS'), $url_base . 'users', 'users', $controller == 'users' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('USERGROUPS'), $url_base . 'usergroups', 'usergroups', $controller == 'usergroups' ? true : false);
                echo WDFSubToolbar::get_sub_toolbar();
				
				WDFSubToolbar::add_item(WDFText::get('INSTALL'), $url_base . 'installtools', 'install', $controller == 'installtools' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('MANAGE_TOOLS'), $url_base . 'tools', 'tools', $controller == 'tools' ? true : false);
                echo WDFSubToolbar::get_sub_toolbar();

                WDFSubToolbar::add_item(WDFText::get('THEMES'), $url_base . 'themes', 'themes', $controller == 'themes' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('OPTIONS'), $url_base . 'options', 'options', $controller == 'options' ? true : false);
				echo WDFSubToolbar::get_sub_toolbar();
				
				self::toolbar_tools($url_base,$controller);
				
                break;
            case 'products':
            case 'bulkactions':
            case 'feedback':
            case 'ratings':
                WDFSubToolbar::add_item(WDFText::get('PRODUCTS'), $url_base . 'products', 'products', $controller == 'products' ? true : false);
	            WDFSubToolbar::add_item(WDFText::get('BULK_ACTIONS'), $url_base . 'bulkactions', 'bulkactions', $controller == 'bulkactions' ? true : false);			
				WDFSubToolbar::add_item(WDFText::get('FEEDBACK'), $url_base . 'feedback', 'feedback', $controller == 'feedback' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('RATINGS'), $url_base . 'ratings', 'ratings', $controller == 'ratings' ? true : false);
				WDFSubToolbar::add_browse_tools_link();
				echo WDFSubToolbar::get_sub_toolbar();
                break;
            case 'orders':
            case 'orderstatuses':
			case 'reports':
                WDFSubToolbar::add_item(WDFText::get('ORDERS'), $url_base . 'orders', 'orders', $controller == 'orders' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('ORDER_STATUSES'), $url_base . 'orderstatuses', 'orderstatuses', $controller == 'orderstatuses' ? true : false);
              	WDFSubToolbar::add_item(WDFText::get('REPORTS'), $url_base . 'reports', 'reports', $controller == 'reports' ? true : false);
				WDFSubToolbar::add_browse_tools_link();
				echo WDFSubToolbar::get_sub_toolbar();
                break;
            case 'countries':
            case 'currencies':
            case 'shippingmethods':
                WDFSubToolbar::add_item(WDFText::get('COUNTRIES'), $url_base . 'countries', 'countries', $controller == 'countries' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('CURRENCIES'), $url_base . 'currencies', 'currencies', $controller == 'currencies' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('SHIPPING_METHODS'), $url_base . 'shippingmethods', 'shippingmethods', $controller == 'shippingmethods' ? true : false);
				WDFSubToolbar::add_browse_tools_link();
				echo WDFSubToolbar::get_sub_toolbar();
                break;
            case 'users':
            case 'usergroups':
                WDFSubToolbar::add_item(WDFText::get('USERS'), $url_base . 'users', 'users', $controller == 'users' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('USERGROUPS'), $url_base . 'usergroups', 'usergroups', $controller == 'usergroups' ? true : false);
                WDFSubToolbar::add_browse_tools_link();
				echo WDFSubToolbar::get_sub_toolbar();
                break;
				
            case 'installtools':
			case 'tools':
				WDFSubToolbar::add_browse_tools_link();
				WDFSubToolbar::add_item(WDFText::get('INSTALL'), $url_base . 'installtools', 'install', $controller == 'installtools' ? true : false);
                WDFSubToolbar::add_item(WDFText::get('MANAGE_TOOLS'), $url_base . 'tools', 'tools', $controller == 'tools' ? true : false);
                echo WDFSubToolbar::get_sub_toolbar();
                break;
       
				
        }
    }
	
	public static function toolbar_tools($url_base, $controller)
	{
		$where_query = array( " published ='1' AND create_toolbar_icon=1" );
		$tools = WDFTool::get_tools( $where_query );
		if($tools)	
		{
			foreach( $tools as $tool )
			{
				$toolname = substr( $tool, 12 );
				$controller_name  = strtolower(str_replace('_','',$toolname));
				$text = strtoupper($toolname);
				WDFSubToolbar::add_item(WDFText::get($text), $url_base . $controller_name, $controller_name, $controller == $controller_name ? true : false);
					
			}
			echo WDFSubToolbar::get_sub_toolbar();		
		}
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