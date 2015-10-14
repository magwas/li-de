<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelSystempages extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    const ERROR_MSG_1 = 'MSG_WRONG_REQUEST';
    const ERROR_MSG_2 = 'MSG_ERROR_LOADING_PAGE';


    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_error() {
        $error = new stdClass();
        $error->code = WDFInput::get('code', 0, 'int');

        switch ($error->code) {
            case 1:
                $error->header = WDFText::get('ERROR') . ' ' . $error->code;
                $error->msg = WDFText::get(self::ERROR_MSG_1);
                break;
            case 2:
                $error->header = WDFText::get('ERROR') . ' ' . $error->code;
                $error->msg = WDFText::get(self::ERROR_MSG_1);
                break;
            default:
                $error->header = WDFText::get('ERROR');
                $error->msg = '';
        }

        return $error;
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