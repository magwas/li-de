<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class WDFPath {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * The component administrator path.
     *
     * @var    string
     */
    private static $com_admin_path;

    /**
     * The component site path.
     *
     * @var    string
     */
    private static $com_site_path;

    /**
     * Framework path.
     *
     * @var    string
     */
    private static $framework_path;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Normaize path (Replace / and \ with DS, removes multiple separators).
     *
     * @return    string    normalized path
     */
    public static function normalize_path($path) {
        $path = str_replace('/', DS, $path);
        $path = str_replace('\\', DS, $path);
        while (strpos($path, DS . DS) !== false) {
            $path = str_replace(DS . DS, DS, $path);
        }

        return $path;
    }

    /**
     * Get component admin part path.
     *
     * @return    string    component admin part path
     */
    public static function get_com_admin_path() {
        if (isset(self::$com_admin_path) == false) {
            self::$com_admin_path = self::normalize_path(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_' . WDFHelper::get_com_name());
        }
        return self::$com_admin_path;
    }

    /**
     * Get component site part path.
     *
     * @return    string    component site part path
     */
    public static function get_com_site_path() {
        if (isset(self::$com_site_path) == false) {
            self::$com_site_path = self::normalize_path(JPATH_SITE . DS . 'components' . DS . 'com_' . WDFHelper::get_com_name());
        }
        return self::$com_site_path;
    }

    /**
     * Get component admin path if user is in admin part and site path if user is in site part.
     *
     * @return    string    component path
     */
    public static function get_com_path() {
        return JFactory::getApplication()->isAdmin() ? self::get_com_admin_path() : self::get_com_site_path();
    }

    /**
     * Get framework folder path
     *
     * @return    string    path of framework folder
     */
    public static function get_framework_path() {
        if (isset(self::$framework_path) == false) {
            self::$framework_path = self::normalize_path(self::$com_admin_path . DS . 'framework');
        }
        return self::$framework_path;
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