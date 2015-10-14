<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFSession {
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
    /**
     * Gets a value from the applications session data (fallbacks to input if set).
     *
     * @param    string $key Name of the value to get.
     * @param    string $default The default value for the variable if not found. Optional.
     * @param    string $type Filter to apply to the value.
     * @param    string $use_input Filter to apply to the value.
     *
     * @return    mixed   The filtered input value.
     */
    public static function get($key, $default = null, $type = 'none', $use_input = true, $use_controller = true, $use_task = true) {
        $app = JFactory::getApplication();

        $key_parts = array();
        $key_parts[] = 'com_' . WDFHelper::get_com_name();
        $controller = WDFInput::get_controller();
        if (($use_controller == true) && ($controller != '')) {
            $key_parts[] = $controller;
        }
        $task = WDFInput::get_task();
        if (($use_task == true) && ($task != '')) {
            $key_parts[] = $task;
        }
        $key_parts[] = $key;
        $full_key = implode('.', $key_parts);
        if ($use_input == true) {
            return $app->getUserStateFromRequest($full_key, $key, $default, $type);
        } else {
            return $app->getUserState($full_key, $default);
        }
    }

    /**
     * Sets the value of a session variable.
     *
     * @param    string $key Name of the variable.
     * @param    string $value The value of the variable.
     *
     * @return    mixed    The previous state, if one existed.
     */
    public static function set($key, $value, $use_controller = true, $use_task = true) {
        $app = JFactory::getApplication();

        $key_parts = array();
        $key_parts[] = 'com_' . WDFHelper::get_com_name();
        $controller = WDFInput::get_controller();
        if (($use_controller == true) && ($controller != '')) {
            $key_parts[] = $controller;
        }
        $task = WDFInput::get_task();
        if (($use_task == true) && ($task != '')) {
            $key_parts[] = $task;
        }
        $key_parts[] = $key;
        $full_key = implode('.', $key_parts);
        return $app->setUserState($full_key, $value);
    }

    /**
     * Unset session variable.
     *
     * @param    string $key Name of the variable.
     */
    public static function clear($key, $use_controller = true, $use_task = true) {
        self::set($key, null, $use_controller, $use_task);
    }

    /**
     * Gets the limit of pagination.
     *
     * @return    int    Pagination limit.
     */
    public static function get_pagination_limit() {
        return JFactory::getApplication()->getUserStateFromRequest('global.list.limit', 'limit', WDFConfig::get('list_limit'), 'int');
    }

    /**
     * Gets the start of pagination.
     *
     * @return    int    Pagination start.
     */
    public static function get_pagination_start() {
        return self::get('limitstart', 0, 'int');
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