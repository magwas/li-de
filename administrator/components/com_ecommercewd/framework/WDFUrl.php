<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFUrl {
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
     * Administrator url.
     *
     * @var    string
     */
    private static $admin_url;

    /**
     * Site url.
     *
     * @var    string
     */
    private static $site_url;

    /**
     * The component administrator url.
     *
     * @var    string
     */
    private static $com_admin_relative_url;

    /**
     * The component site url.
     *
     * @var    string
     */
    private static $com_site_relative_url;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Normaize url (Replace \ with /).
     *
     * @return    string    normalized path
     */
    public static function normalize_url($url) {
        $url = str_replace('\\', '/', $url);
        return $url;
    }


    /**
     * Get admin part url.
     *
     * @return    string    admin part url
     */
    public static function get_admin_url($relative = false) {
        if (isset(self::$admin_url) == false) {
            self::$admin_url = self::normalize_url(JURI::root($relative) . '/administrator');
        }
        return self::$admin_url;
    }

    /**
     * Get site part url.
     *
     * @return    string    site part url
     */
    public static function get_site_url($relative = false) {
        if (isset(self::$site_url) == false) {
            self::$site_url = self::normalize_url(JURI::root($relative));
        }
        return self::$site_url;
    }

    /**
     * Get component admin part url.
     *
     * @return    string    component admin part url
     */
    public static function get_com_admin_url($relative = false) {
        if (isset(self::$com_admin_relative_url) == false) {
            self::$com_admin_relative_url = self::normalize_url('components/com_' . WDFHelper::get_com_name());
        }
        return $relative == true ? self::$com_admin_relative_url : self::get_admin_url() .  '/' . self::$com_admin_relative_url;
    }

    /**
     * Get component site part url.
     *
     * @return    string    component site part url
     */
    public static function get_com_site_url($relative = false) {
        if (isset(self::$com_site_relative_url) == false) {
            self::$com_site_relative_url = self::normalize_url('components/com_' . WDFHelper::get_com_name());
        }
        return $relative == true ? self::$com_site_relative_url : self::get_site_url() . self::$com_site_relative_url;
    }

    /**
     * Get component admin part url if user is in admin part or site part if user is in site part.
     *
     * @return    string    component url
     */
    public static function get_com_url($relative = false) {
        return JFactory::getApplication()->isAdmin() ? self::get_com_admin_url() : self::get_com_site_url();
    }

    /**
     * Get current page url.
     *
     * @return    string    current page url
     */
    public static function get_self_url() {
        return JURI::getInstance()->toString();
    }

    /**
     * Get referer page url.
     *
     * @return    string    referer page url
     */
    public static function get_referer_url() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return base64_encode($_SERVER['HTTP_REFERER']);
        }
        return '';
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