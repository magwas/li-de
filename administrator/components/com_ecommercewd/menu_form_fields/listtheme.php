<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// J3
if (defined('DS') == false) {
    define('DS', DIRECTORY_SEPARATOR);
}

jimport('joomla.form.formfield');


class JFormFieldListTheme extends JFormField {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected $type = 'ListTheme';


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function getInput() {
        //include
        JTable::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_ecommercewd' . DS . 'tables');

        // init framework
        require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_ecommercewd' . DS . 'framework' . DS . 'WDFHelper.php';
        WDFHelper::init('ecommercewd');

        // J3 jQuery bug fix
        if (WDFHelper::is_j3() == false) {
            // jQuery
            WDFHelper::add_script('js/jquery-1.10.2.min.js', true, true);
        }

        // joomla system js
        JHTML::_('behavior.modal');
        JHTML::_('behavior.tooltip');

        // css and js
        WDFHelper::add_css('css/menu_form_fields/list_theme.css');
        WDFHelper::add_script('js/menu_form_fields/list_theme.js');

        ob_start();
        ?>
        <script>
            jQuery.noConflict();
        </script>
        <?php

        $list_themes = WDFDb::get_list('themes', 'id', 'name', array(), '', array(array('id' => 0, 'name' => WDFText::get('DEFAULT_THEME'))));
        echo JHtml::_('select.genericlist', $list_themes, $this->name, '', 'id', 'name', $this->value, $this->id);

        $content = ob_get_clean();

        return $content;
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