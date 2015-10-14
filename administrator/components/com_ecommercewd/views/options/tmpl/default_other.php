<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$lists = $this->lists;
$list_date_formats = $lists['date_formats'];

$options = $this->options;
$initial_values = $options['initial_values'];
?>

<table class="adminlist table">
    <tbody>
    <!-- date format -->
    <tr>
        <td class="col_key">
            <label for="option_date_format">
                <?php echo WDFText::get('DATE_FORMAT');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.genericlist', $list_date_formats, 'option_date_format', '', 'value', 'text', $initial_values['option_date_format']); ?>
        </td>
    </tr>

    <!-- include discount in price -->
    <tr>
        <td class="col_key">
            <label for="option_include_discount_in_price">
                <?php echo  WDFText::get('INCLUDE_DISCOUNT_IN_PRICE');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'option_include_discount_in_price', '', $initial_values['option_include_discount_in_price'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- include tax in price -->
    <tr>
        <td class="col_key">
            <label for="option_include_tax_in_price">
                <?php echo  WDFText::get('INCLUDE_TAX_IN_PRICE');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'option_include_tax_in_price', '', $initial_values['option_include_tax_in_price'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- show decimals -->
    <tr>
        <td class="col_key">
            <label for="option_show_decimals">
                <?php echo  WDFText::get('DISPLAY_PRICE_WITH_DECIMALS');
                ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'option_show_decimals', '', $initial_values['option_show_decimals'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
    </tbody>

    <!-- ctrls -->
    <tbody>
    <tr>
        <td class="btns_container" colspan="2">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'other\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'other\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>