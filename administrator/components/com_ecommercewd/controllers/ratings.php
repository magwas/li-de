<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerRatings extends EcommercewdController {
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
    public function update_rating() {
        $app = JFactory::getApplication();

        $row_rating = WDFDb::get_row_by_id('ratings', WDFInput::get_checked_id());
        $is_updated = false;
        if ($row_rating->id != null) {
            $row_rating->rating = WDFInput::get('rating_' . $row_rating->id);
            if ($row_rating->store() == true) {
                $is_updated = true;
            }
        }

        $msg = $is_updated == true ? WDFText::get('MSG_RATING_UPDATED') : WDFText::get('MSG_FAILED_TO_UPDATE_RATING');
        $msg_type = $is_updated == true ? 'message' : 'error';
        $app->enqueueMessage($msg, $msg_type);

        WDFHelper::redirect();
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