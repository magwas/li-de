<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/layout_' . $this->_layout . '.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$row_default_currency = $this->row_default_currency;

$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table">
        <tbody>
        <!-- name -->
        <tr>
            <td class="col_key">
                <label for="name"><?php echo WDFText::get('NAME'); ?>:</label>
                <span class="star">*</span>
            </td>
            <td class="col_value">
                <input type="text"
                       name="name"
                       id="name"
                       class="required_field"
                       value="<?php echo $row->name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- description -->
        <tr>
            <td class="col_key">
                <label for="description"><?php echo WDFText::get('DESCRIPTION'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="description"
                       id="description"
                       value="<?php echo $row->description; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- countries -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('COUNTRIES') ?>:</label>
            </td>
            <td class="col_value">
                <textarea type="text"
                          name="country_names"
                          id="country_names"
                          class="names_list"
                          disabled="disabled"><?php echo $row->country_names; ?></textarea>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveCountriesClick(event, this);"'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectCountriesClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=countries" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                <input type="hidden"
                       name="country_ids"
                       id="country_ids"
                       value="<?php echo implode(',', $row->country_ids); ?>"/>
            </td>
        </tr>

        <!-- free shipping -->
        <tr>
            <td class="col_key">
                <label for="free_shipping"><?php echo WDFText::get('FREE_SHIPPING'); ?>:</label>
            </td>
            <td class="col_value">
                <?php
                $free_shipping = $row->free_shipping;
                $free_shipping_0_checked = $free_shipping != 1 ? 'checked="checked"' : '';
                $free_shipping_1_checked = $free_shipping == 1 ? 'checked="checked"' : '';
                $free_shipping_after_certain_price_checked = $free_shipping == 2 ? 'checked="checked"' : '';
                $price_container_class_hidden = $free_shipping == 1 ? 'hidden' : '';
                $free_shipping_start_price_container_class_hidden = $free_shipping != 2 ? 'hidden' : '';
                ?>
                <input type="radio"
                       name="free_shipping"
                       id="free_shipping_0"
                       value="0"
                    <?php echo $free_shipping_0_checked; ?>
                       onchange="onFreeShippingChange(event, this);"/>
                <label for="free_shipping_0">
                    <?php echo WDFText::get('NO'); ?>
                </label>

                <input type="radio"
                       name="free_shipping"
                       id="free_shipping_1"
                       value="1"
                    <?php echo $free_shipping_1_checked; ?>
                       onchange="onFreeShippingChange(event, this);"/>
                <label for="free_shipping_1">
                    <?php echo WDFText::get('YES'); ?>
                </label>
            </td>
        </tr>

        <!-- price -->
        <tr class="price_container <?php echo $price_container_class_hidden; ?>">
            <td class="col_key">
                <label for="price"><?php echo WDFText::get('PRICE'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="price"
                       id="price"
                       value="<?php echo $row->price; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
                <?php echo $row_default_currency->code; ?>

                <br>

                (<label for="free_shipping_2">
                    <input type="checkbox"
                           name="free_shipping_after_certain_price"
                           id="free_shipping_after_certain_price"
                           value="1"
                        <?php echo $free_shipping_after_certain_price_checked; ?>
                           onchange="onFreeShippingAfterCertainPriceChange(event, this);"/>
                    <?php echo WDFText::get('FREE_SHIPPING_OVER_CERTAIN_PRICE'); ?>
                </label>

                <span
                    class="free_shipping_start_price_container <?php echo $free_shipping_start_price_container_class_hidden; ?>">
                    <input type="text"
                           name="free_shipping_start_price"
                           value="<?php echo $row->free_shipping_start_price; ?>"/>
                    <?php echo $row_default_currency->code; ?>
                </span>)
            </td>
        </tr>

        <!-- published -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PUBLISHED'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.booleanlist', 'published', '', $row->published, WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>
        <tbody>
    </table>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>
