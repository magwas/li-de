<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

$row_default_currency = $this->default_currency_row;
$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );

?>

<!-- parameters -->
<fieldset>
    <legend><?php echo WDFText::get('PARAMETERS'); ?>:</legend>

    <table class="adminlist table parameters">
		<thead>
			<tr>
				<th class=""><?php echo WDFText::get('ORDERING'); ?></th>
				<th class="col_name"><?php echo WDFText::get('NAME'); ?></th>
				<th class="col_type"><?php echo WDFText::get('TYPE'); ?></th>
				<th class="col_values"><?php echo WDFText::get('VALUES'); ?><span class="price"><?php echo WDFText::get('PRICE'); ?></span></th>
				<th class=""></th>
			</tr>
        </thead>
        <tbody id="parameters_container">
        <tr class="template parameter_container required_parameter_container" parameter_id="" parameter_name="" parameter_type_id="">
			<td class="col-ordering"><i class="hasTooltip icon-drag" title="" data-original-title=""></i></td>
            <td class="col_parameter_key">
                <span class="parameter_name"></span>
                <span class="star required_sign">*</span>
            </td>
			<td class="col_parameter_type">
                <span class="parameter_type"></span>
            </td>
            <td class="col_parameter_value parameter_values_container">
                 <div class="template parameter_value_container single_parameter_value_container">
                    <i class="hasTooltip icon-drag" title="" data-original-title=""></i>
					<input type="text"
                           name=""
                           class="required_field parameter_value">
					 <select class="price_sign">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                    <input type="text" name="" class="parameter_price">	   
                    <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter_value', 'onclick="onBtnRemoveParameterValueClick(event, this);"'); ?>
                </div>
            </td>
            <td>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_ADD, '', 'btn_add_parameter_value', 'onclick="onBtnAddParameterValueClick(event, this);"'); ?>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter', 'onclick="onBtnRemoveParameterClick(event, this);"'); ?>
            </td>
        </tr>
        </tbody>

        <tbody>
        <tr>
            <td colspan="6">
            <span>
                <?php echo '* - ' . WDFText::get('REQUIRED_PARAMETERS'); ?>
            </span>
            <span id="parameter_buttons_container">
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_ADD_PARAMETERS'), '', '', 'onclick="onBtnAddParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_INHERIT_CATEGORY_PARAMETERS'), '', '', 'onclick="onBtnInheritCategoryParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_REMOVE_ALL'), '', '', 'onclick="onBtnRemoveAllParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=parameters" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
            </span>
            </td>
        </tr>

        <tr>
            <input type="hidden" name="parameters"/>
        </tr>
        </tbody>
    </table>
</fieldset>

