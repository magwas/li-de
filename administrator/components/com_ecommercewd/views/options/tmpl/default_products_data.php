<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$lists = $this->lists;
$list_dimensions_units = $lists['dimensions_units'];
$list_weight_units = $lists['weight_units'];

$options = $this->options;

$initial_values = $options['initial_values'];
?>

<table class="adminlist table">
    <tbody>
    <!-- weight unit -->
    <tr>
        <td class="col_key">
            <label for="weight_unit">
                <?php echo WDFText::get('WEIGHT_UNIT');
                ?>:
            </label>
        </td>
        <td class="col_value">   
	        <?php echo JHTML::_('select.genericlist', $list_weight_units, 'weight_unit', '', 'value', 'text', $initial_values['weight_unit']); ?>
	 </td>
    </tr>

    <!-- dimensions unit -->
    <tr>
        <td class="col_key">
            <label for="dimensions_unit">
                <?php echo WDFText::get('DIMENSIONS_UNIT');
                ?>:
            </label>
        </td>
        <td class="col_value">
	        <?php echo JHTML::_('select.genericlist', $list_dimensions_units, 'dimensions_unit', '', 'value', 'text', $initial_values['dimensions_unit']); ?>
	  </td>
    </tr>	
	
    <!-- enable sku -->
    <tr>
        <td class="col_key">
            <label for="enable_sku">
                <?php echo WDFText::get('ENABLE_SKU');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'enable_sku', '', $initial_values['enable_sku'], WDFText::get('YES'), WDFText::get('NO')); ?>    
	  </td>
    </tr>

    <!-- enable upc -->
    <tr>
        <td class="col_key">
            <label for="enable_upc">
                <?php echo  WDFText::get('ENABLE_UPC');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'enable_upc', '', $initial_values['enable_upc'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
	
    <!-- enable ean -->
    <tr>
        <td class="col_key">
            <label for="enable_ean">
                <?php echo  WDFText::get('ENABLE_EAN');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'enable_ean', '', $initial_values['enable_ean'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
	
    <!-- enable jan -->
    <tr>
        <td class="col_key">
            <label for="enable_jan">
                <?php echo  WDFText::get('ENABLE_JAN');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'enable_jan', '', $initial_values['enable_jan'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>	
	
    <!-- enable isbn -->
    <tr>
        <td class="col_key">
            <label for="enable_isbn">
                <?php echo  WDFText::get('ENABLE_ISBN');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'enable_isbn', '', $initial_values['enable_isbn'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
	
    <!-- enable mpn -->
    <tr>
        <td class="col_key">
            <label for="enable_mpn">
                <?php echo  WDFText::get('ENABLE_MPN');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'enable_mpn', '', $initial_values['enable_mpn'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>	
   
    </tbody>
</table>
<!-- ctrls -->
<table class="adminlist table">
    <tbody>
    <tr>
        <td class="btns_container">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'products_data\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'products_data\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>