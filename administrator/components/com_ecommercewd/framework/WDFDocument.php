<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class WDFDocument {
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
     * Set title page title
     *
     * @param    string $title title to set.
     */
    public static function set_title($title) {
        $document = JFactory::getDocument();
        $document->setTitle($title);
    }

    /**
     * Set page meta data
     *
     * @param    string $name meta name.
     * @param    string $content meta content.
     */
    public static function set_meta_data($name, $content) {
        $document = JFactory::getDocument();
        $document->setMetaData($name, $content);
    }

    /**
     * Set page description
     *
     * @param    string $description description.
     */
    public static function set_description($description) {
        $document = JFactory::getDocument();
        $document->setDescription($description);
    }

    /**
     * Set meta property
     *
     * @param    string $name meta name.
     * @param    string $content meta content.
     */
    public static function set_meta_property($name, $content) {
        $document = JFactory::getDocument();
        $document->addCustomTag('<meta property="' . $name . '" content="' . $content . '" />');
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