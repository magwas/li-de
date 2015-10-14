<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFSiteViewBase extends WDFDummyJView {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected $active_menu_params;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function display($tpl = null) {
        $this->activate_current_menu();

        parent::display($tpl);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function activate_current_menu() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $app = JFactory::getApplication();
        $menu = $app->getMenu();

        // get menu with links to current layout
        $query->clear();
        $query->select('id');
        $query->from('#__menu');
        $query->where('link = ' . $db->quote('index.php?option=com_' . WDFHelper::get_com_name() . '&view=' . WDFInput::get_controller() . '&layout=' . $this->_layout));
        $query->where('published = 1');
        $query->order('id DESC');
        $db->setQuery($query);
        $menu_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        // get menus with same params and make active
        foreach ($menu_ids as $id) {
            if (empty($this->active_menu_params) == false) {
                $j_registry = $menu->getParams($id);
                foreach ($this->active_menu_params as $param_name) {
                    $param_value = WDFInput::get($param_name);
                    if ($j_registry->get($param_name) != $param_value) {
                        continue 2;
                    }
                }
            }
            $menu->setActive($id);
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}