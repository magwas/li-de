<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerOptions extends EcommercewdController {
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
    public function apply() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $failed = false;
        $this->prepare_checkboxes_for_save();

        // get option names
        $query->clear();
        $query->select('name');
        $query->from('#__ecommercewd_options');
        $db->setQuery($query);
        $names = $db->loadColumn();

        if ($db->getErrorNum()) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SAVE_CHANGES'), 'error');
            $failed = true;
        }

        // update options
        if ($failed == false) {
            for ($i = 0; $i < count($names); $i++) {
                $name = $names[$i];
                $value = WDFInput::get($name, null);
                if ($value !== null) {
                    $query->clear();
                    $query->update('#__ecommercewd_options');
                    $query->set($db->quoteName('value') . ' = ' . $db->quote($value));
                    $query->where($db->quoteName('name') . ' = ' . $db->quote($name));
                    $db->setQuery($query);
                    $db->query();

                    if ($db->getErrorNum()) {
                        echo $db->getErrorMsg();
                        die();
                        $failed = true;
                        $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SAVE_CHANGES'), 'error');
                        break;
                    }
                }
            }
        }

        if ($failed == false) {
            $app->enqueueMessage(WDFText::get('MSG_CHANGES_SAVED'), 'message');
        }

        WDFHelper::redirect('', '', '', 'tab_index=' . WDFInput::get('tab_index'));
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function prepare_checkboxes_for_save() {
        $checkboxes = array('social_media_integration_enable_fb_like_btn', 'social_media_integration_enable_twitter_tweet_btn', 'social_media_integration_enable_g_plus_btn');

        foreach ($checkboxes as $checkbox) {
            WDFInput::set($checkbox, WDFInput::get($checkbox, 0, 'int'));
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}