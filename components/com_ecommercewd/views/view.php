<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdView extends WDFSiteViewBase {
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
	
        // in dev mode add content ids in base_ css files
        if (DEV_MODE == true) {
			$clear_css_ids = $this->get_clear_css_ids();
			$wd_shop_container_css_ids = $this->get_wd_shop_container_css_ids();
			$bootstrap_css_ids = $this->get_bootstrap_css_ids();
			$this->add_clear_css_prefixes($clear_css_ids);
			$this->add_css_prefixes($wd_shop_container_css_ids, WDFPath::get_com_admin_path() . DS . 'css');
			$this->add_css_prefixes($wd_shop_container_css_ids, WDFPath::get_com_site_path() . DS . 'css');
			$this->add_bootstrap_css_prefixes($bootstrap_css_ids);
        }

        // css and js
        WDFHelper::add_script('js/jquery-1.10.2.min.js', true);

        WDFHelper::add_css('css/clear.css', true);
        // bootstrap
        WDFHelper::add_css('bootstrap/css/bootstrap.css', true);
			
		WDFHelper::add_script('bootstrap/js/bootstrap.js', true, false, true);
		
        // for IE8 and below bootstrap responsive view
        WDFHelper::add_script("bootstrap/ie8/html5shiv.js", true, false, true);
        WDFHelper::add_script("bootstrap/ie8/respond.min.js", true, false, true);


        // wd main and shop
        WDFHelper::add_css('css/wd_main.css', true);
        WDFHelper::add_css('css/wd_shop.css', true);
        WDFHelper::add_script('js/wd_main.js');

        // theme
        $theme_id = WDFParams::get('theme_id', 0);
        WDFHelper::add_css(WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=theme&theme_id=' . $theme_id, false);

		
        //init component js variables
        ob_start();
        ?>
        <script>
            var COM_NAME = "<?php echo WDFHelper::get_com_name(); ?>";
            var CONTROLLER = "<?php echo WDFInput::get_controller(); ?>";
            var TASK = "<?php echo WDFInput::get_task(); ?>";
        </script>
        <?php
        $js_script = ob_get_contents();
        echo $js_script;

        //put content in containers
        for ($i = 1; $i < 13; $i++) {
            ?>
            <div id="wd_shop_container_<?php echo $i; ?>">
        <?php
        }
        ?>
        <div id="wd_shop_container">
            <?php

            parent::display($tpl);

            ?>
        </div>
        <?php
        for ($i = 1; $i < 13; $i++) {
            ?>
            </div>
        <?php
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_clear_css_ids() {
        $wd_shop_container_ids = array();
        for ($i = 1; $i < 12; $i++) {
            $wd_shop_container_ids[] = 'wd_shop_container_' . $i;
        }

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
        $css_dir_path = WDFPath::get_com_admin_path() . DS . 'css';

        WDFLessHelper::add_selector_prefix($css_dir_path . DS . 'base_clear.css', $css_dir_path . DS . 'clear.css', $clear_css_ids);
    }

    private function add_bootstrap_css_prefixes($bootstrap_css_ids) {
        $bootstrap_css_dir = WDFPath::get_com_admin_path() . DS . 'bootstrap' . DS . 'css';

        $bootstrap_file_path = $bootstrap_css_dir . DS . 'base_bootstrap.css';
        WDFLessHelper::add_selector_prefix($bootstrap_file_path, $bootstrap_css_dir . DS . 'bootstrap.css', $bootstrap_css_ids);
    }

    private function add_css_prefixes($wd_shop_container_css_ids, $dir_path) {
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