<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdViewThemes extends EcommercewdView {
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
    public function display($tpl = null) {
        $this->create_toolbar();

        $model = $this->getModel();

        $task = WDFInput::get_task();
        switch ($task) {
            case 'add':
            case 'edit_basic':
            case 'edit':
                $this->_layout = 'edit';
                $this->row = $model->get_row();
                break;
            default:
                $this->filter_items = $model->get_rows_filter_items();
                $this->sort_data = $model->get_rows_sort_data();
                $this->pagination = $model->get_rows_pagination();
                $this->rows = $model->get_rows();
                break;
        }

        $this->init_bootstrap_files();

        parent::display($tpl);
    }

    public function wd_bs_container_start() {
        for ($i = 1; $i < 13; $i++) {
            echo '<div id="wd_shop_container_' . $i . '">';
        }
        echo '<div id="wd_shop_container">';
    }

    public function wd_bs_container_end() {
        for ($i = 1; $i < 14; $i++) {
            echo '</div>';
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function create_toolbar() {
        switch (WDFInput::get_task()) {
            case 'add':
                JToolBarHelper::title(WDFText::get('ADD_THEME'), 'spidershop_themes.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            case 'edit':
                JToolBarHelper::title(WDFText::get('EDIT_THEME'), 'spidershop_themes.png');

                JToolBarHelper::apply();
                JToolBarHelper::save();
                JToolBarHelper::save2new();
                JToolBarHelper::save2copy();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            case 'edit_basic':
                JToolBarHelper::title(WDFText::get('EDIT_THEME'), 'spidershop_themes.png');

                JToolBarHelper::save2copy();
                JToolBarHelper::divider();
                JToolBarHelper::cancel();
                break;
            default:
                JToolBarHelper::title(WDFText::get('THEMES'), 'spidershop_themes.png');

                JToolBarHelper::addNew();
                JToolBarHelper::editList();
                JToolBarHelper::divider();
                JToolBarHelper::deleteList(WDFText::get('MSG_DELETE_CONFIRM'), 'remove_keep_default_and_basic');
                JToolBarHelper::divider();
                JToolBarHelper::makeDefault('make_default');
                break;
        }
    }

    private function init_bootstrap_files() {
        // jQuery
        WDFHelper::add_script('js/jquery-1.10.2.min.js',true);

        //in dev mode add content ids in base_ css files
        if (DEV_MODE == true) {
            $clear_css_ids = $this->get_clear_css_ids();
            $wd_shop_container_css_ids = $this->get_wd_shop_container_css_ids();
            $bootstrap_css_ids = $this->get_bootstrap_css_ids();
            $this->add_clear_css_prefixes($clear_css_ids);
            $this->add_css_prefixes($wd_shop_container_css_ids);
            $this->add_bootstrap_css_prefixes($bootstrap_css_ids);
        }


        WDFHelper::add_css('css/clear.css', true, false, true);
        //bootstrap
        WDFHelper::add_css('bootstrap/css/bootstrap.css', true, false, true);
        WDFHelper::add_script('bootstrap/js/bootstrap.js', true, false, true, true);

        // for IE8 and below bootstrap responsive view
        WDFHelper::add_script("bootstrap/ie8/html5shiv.js", true, false, true, true);
        WDFHelper::add_script("bootstrap/ie8/respond.min.js", true, false, true, true);


        //wd main and wd shop
        WDFHelper::add_css('css/wd_main.css', true, false, true);
        WDFHelper::add_css('css/wd_shop.css', true, false, true );
    }

    private function get_clear_css_ids() {
        $wd_shop_container_ids = array();
        for ($i = 1; $i < 12; $i++) {
            $wd_shop_container_ids[] = 'wd_shop_container_' . $i;
        }
        $wd_shop_container_ids[] = 'wd_shop_container';

        return $wd_shop_container_ids;
    }

    private function get_bootstrap_css_ids() {
        $bootstrap_ids = array();
        for ($i = 1; $i < 13; $i++) {
            $bootstrap_ids[] = 'wd_shop_container_' . $i;
        }

        return $bootstrap_ids;
    }

    private function get_wd_shop_container_css_ids() {
        $wd_shop_container_ids = array();
        for ($i = 1; $i < 13; $i++) {
            $wd_shop_container_ids[] = 'wd_shop_container_' . $i;
        }
        $wd_shop_container_ids[] = 'wd_shop_container';

        return $wd_shop_container_ids;
    }

    private function add_clear_css_prefixes($clear_css_ids) {
        $css_dir_path = WDFPath::get_com_path() . DS . 'css';

        WDFLessHelper::add_selector_prefix($css_dir_path . DS . 'base_clear.css', $css_dir_path . DS . 'clear.css', $clear_css_ids);
    }

    private function add_bootstrap_css_prefixes($bootstrap_css_ids) {
        $bootstrap_css_dir = WDFPath::get_com_path() . DS . 'bootstrap' . DS . 'css';

        $bootstrap_file_path = $bootstrap_css_dir . DS . 'base_bootstrap.css';
        WDFLessHelper::add_selector_prefix($bootstrap_file_path, $bootstrap_css_dir . DS . 'bootstrap.css', $bootstrap_css_ids);
    }

    private function add_css_prefixes($wd_shop_container_css_ids, $dir_path = '') {
        if ($dir_path == '') {
            $dir_path = WDFPath::get_com_path() . DS . 'css';
        }

        $file_names = scandir($dir_path);
        foreach ($file_names as $file_name) {
            if (($file_name == '.') || ($file_name == '..')) {
                continue;
            }
            $file_path = $dir_path . DS . $file_name;
            if (is_dir($file_path) == true) {
                $this->add_css_prefixes($wd_shop_container_css_ids, $file_path);
            } else {
                if ((is_file($file_path) == true) && (pathinfo($file_path, PATHINFO_EXTENSION) == 'css') && ($file_name != 'base_clear.css') && (substr($file_name, 0, 5) == 'base_')) {
                    WDFLessHelper::add_selector_prefix($file_path, $dir_path . DS . substr($file_name, 5), $wd_shop_container_css_ids);
                }
            }
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}