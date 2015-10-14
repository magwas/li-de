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


class JFormFieldCheckboxManufacturer extends JFormField {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected $type = 'CheckboxManufacturer';


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
        WDFHelper::add_css('css/menu_form_fields/checkbox_manufacturer.css');
        WDFHelper::add_script('js/menu_form_fields/checkbox_manufacturer.js');

        ob_start();
        ?>
        <script>
            jQuery.noConflict();
        </script>
        <?php

        $manufacturers = WDFDb::get_list('manufacturers', 'id', 'name', 'published = 1');
		$selected_manufacturers = explode(',',$this->value);
		foreach($manufacturers as $manufacturer){
			if(in_array($manufacturer['id'],$selected_manufacturers))
				$checked = 'checked="checked"';
			else
				$checked = '';
			echo '<label for="'.$manufacturer['id'].'" class="wd_manufacturer_label"><input type="checkbox" name="manufacturers[]" value="'.$manufacturer['id'].'" onchange="wd_shop_fillInputmanufacturers()" '.$checked.' id="'.$manufacturer['id'].'"/> '.$manufacturer['name'].'</label>';		
		}
		?>
		<input type="hidden" name="<?php echo $this->name;?>" value="<?php echo $this->value;?>" id="wd_shop_selected_manufacturers" />
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