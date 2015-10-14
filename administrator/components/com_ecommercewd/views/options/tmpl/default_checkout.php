<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$options = $this->options;
$initial_values = $options['initial_values'];
$lists = $this->lists;
$list_refirect_to_cart_field = $lists['refirect_to_cart'];
?>

<table class="adminlist table">
    <tbody>
    <!-- enable checkout -->
    <tr>
        <td class="col_key">
            <label for="checkout_enable_checkout">
                <?php echo WDFText::get('ENABLE_CHECKOUT'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'checkout_enable_checkout', '', $initial_values['checkout_enable_checkout'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- allow guest checkout -->
    <tr>
        <td class="col_key">
            <label for="checkout_allow_guest_checkout">
                <?php echo WDFText::get('ALLOW_GUEST_CHECKOUT'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'checkout_allow_guest_checkout', '', $initial_values['checkout_allow_guest_checkout'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- enable shipping -->
    <tr>
        <td class="col_key">
            <label for="checkout_enable_shipping">
                <?php echo WDFText::get('ENABLE_SHIPPING'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'checkout_enable_shipping', '', $initial_values['checkout_enable_shipping'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
	
    <!--  redirect to cart after adding an item -->
    <tr>
        <td class="col_key">
            <label for="checkout_redirect_to_cart_after_adding_an_item">
                <?php echo WDFText::get('REDIRECT_TO_CART'); ?>:
            </label>
        </td>
        <td class="col_value">
			<?php echo JHTML::_('select.radiolist', $list_refirect_to_cart_field, 'checkout_redirect_to_cart_after_adding_an_item', '', 'value', 'text', $initial_values['checkout_redirect_to_cart_after_adding_an_item']); ?>
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
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'checkout\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'checkout\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>