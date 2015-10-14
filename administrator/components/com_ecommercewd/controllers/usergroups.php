<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerUsergroups extends EcommercewdController {
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
    public function remove_keep_default() {
        $ids = WDFInput::get_checked_ids();
        $this->move_users_to_default_usergroup($ids);

        parent::remove_keep_default();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function store_input_in_row() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // store usergroup in table
        $usergroup_row = WDFDb::store_input_in_row('usergroups');

        // move users to default usergroup
        $this->move_users_to_default_usergroup($usergroup_row->id);

        // move new users to this usergroup
        $user_ids = WDFInput::get_array('user_ids', ',');
        if (empty($user_ids) == false) {
            $query->clear();
            $query->update('#__ecommercewd_users');
            $query->set('usergroup_id = ' . $usergroup_row->id);
            $query->where('id IN (' . implode(',', $user_ids) . ')');
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }
        }

        return $usergroup_row;
    }

    private function move_users_to_default_usergroup($usergroup_ids) {
        if (is_array($usergroup_ids) == false) {
            $usergroup_ids = array($usergroup_ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $default_usergroup_row = WDFDb::get_row('usergroups', $db->quoteName('default') . ' = 1');

        $query->clear();
        $query->update('#__ecommercewd_users');
        $query->set('usergroup_id = ' . $default_usergroup_row->id);
        $query->where('usergroup_id IN (' . implode(',', $usergroup_ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->stderr();
            die();
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}