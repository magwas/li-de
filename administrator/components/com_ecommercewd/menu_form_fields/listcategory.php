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


class JFormFieldListCategory extends JFormField {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected $type = 'ListCategory';


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
        WDFHelper::add_css('css/menu_form_fields/list_category.css');
        WDFHelper::add_script('js/menu_form_fields/list_category.js');

        ob_start();

        $row_category = WDFDb::get_row_by_id('categories', $this->value);
        $category_name = $this->value == 0 ? WDFText::get('ROOT_CATEGORY') : $row_category->name;
        ?>
        <script>
            jQuery.noConflict();
        </script>
		<div class="wd_listcategory_wrapper">
			<input type="text" id="category_name" value="<?php echo $category_name; ?>" disabled="disabled" />
			<?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectCategoryClick(event, this, ' . $this->value . ');"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?>
			<input type="hidden" name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>"
				   value="<?php echo $this->value; ?>"/>
		</div>	   
        <?php

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