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


$lists = $this->lists;
$list_payment_methods = $lists['payment_methods'];
$list_order_statuses = $lists['order_statuses'];

$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );

?>

<form name="adminForm" id="adminForm" action="" method="post">
<fieldset>
    <legend>
        <?php echo WDFText::get('MAIN_DATA'); ?>
    </legend>

    <table class="adminlist table">
        <tbody>
        <!-- product names -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PRODUCTS'); ?>:</label>
            </td>
            <td class="col_value">
                <div class="el_product_names">
                    <?php echo $row->product_names; ?>
                </div>
                <br>
                <?php echo WDFHTML::jfbutton(WDFText::get('EDIT_PRODUCTS'), '', '', ' onclick="onBtnEditProductsClick(event, this, ' . $row->id . ');"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?>
            </td>
        </tr>

        <!-- total price -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('TOTAL_PRICE'); ?>:</label>
                <small>
                    <?php echo WDFText::get('TOTAL_PRICE_EDIT_HINT'); ?>
                </small>
            </td>
            <td class="col_value">
                <p class="el_total_price"><?php echo $row->total_price_text; ?></p>
            </td>
        </tr>

        <!-- payment method -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PAYMENT_METHOD'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.genericlist', $list_payment_methods, 'payment_method', '', 'short_name', 'name', $row->payment_method); ?>
            </td>
        </tr>

        <!-- payment status -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PAYMENT_STATUS'); ?>:</label>
            </td>
            <td class="col_value">
                <span><?php echo $row->payment_data_status; ?></span>
            </td>
        </tr>

        <!-- status -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('STATUS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.genericlist', $list_order_statuses, 'status_id', '', 'id', 'name', $row->status_id); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>
<div>
	<fieldset>
		<legend>
			<?php echo WDFText::get('BILLING_DATA'); ?>
		</legend>

		<table class="adminlist table">
			<!-- shipping data -->
			<tbody>
			<!-- first name -->
			<tr>
				<td class="col_key">
					<label for="billing_data_first_name"><?php echo WDFText::get('FIRST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_first_name" value="<?php echo $row->billing_data_first_name; ?>">
				</td>
			</tr>

			<!-- middle name -->
			<tr>
				<td class="col_key">
					<label for="billing_data_middle_name"><?php echo WDFText::get('MIDDLE_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_middle_name" value="<?php echo $row->billing_data_middle_name; ?> ">
				</td>
			</tr>

			<!-- last name -->
			<tr>
				<td class="col_key">
					<label for="billing_data_last_name"><?php echo WDFText::get('LAST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_last_name" value="<?php echo $row->billing_data_last_name; ?> ">
				</td>
			</tr>

			<!-- company -->
			<tr>
				<td class="col_key">
					<label for="billing_data_company"><?php echo WDFText::get('COMPANY'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_company" value="<?php echo $row->billing_data_company; ?>">
				</td>
			</tr>

			<!-- email -->
			<tr>
				<td class="col_key">
					<label for="billing_data_email"><?php echo WDFText::get('EMAIL'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_email" value="<?php echo $row->billing_data_email; ?>">
				</td>
			</tr>

			<!-- country -->
			<tr>
				<td class="col_key">
					<label for="billing_data_country"><?php echo WDFText::get('COUNTRY'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_country" value="<?php echo $row->billing_data_country; ?>">
				</td>
			</tr>

			<!-- state -->
			<tr>
				<td class="col_key">
					<label for="billing_data_state"><?php echo WDFText::get('STATE'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_state" value="<?php echo $row->billing_data_state; ?>">
				</td>
			</tr>

			<!-- city -->
			<tr>
				<td class="col_key">
					<label for="billing_data_city"><?php echo WDFText::get('CITY'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_city" value="<?php echo $row->billing_data_city; ?>">
				</td>
			</tr>

			<!-- address -->
			<tr>
				<td class="col_key">
					<label for=""><?php echo WDFText::get('ADDRESS'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_address" value="<?php echo $row->billing_data_address; ?>">
				</td>
			</tr>

			<!-- mobile -->
			<tr>
				<td class="col_key">
					<label for="billing_data_mobile"><?php echo WDFText::get('MOBILE'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_mobile" value="<?php echo $row->billing_data_mobile; ?>">
				</td>
			</tr>

			<!-- phone -->
			<tr>
				<td class="col_key">
					<label for="billing_data_phone"><?php echo WDFText::get('PHONE'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_phone" value="<?php echo $row->billing_data_phone; ?>">
				</td>
			</tr>

			<!-- fax -->
			<tr>
				<td class="col_key">
					<label for="billing_data_fax"><?php echo WDFText::get('FAX'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_fax" value="<?php echo $row->billing_data_fax; ?>">
				</td>
			</tr>

			<!-- zip code -->
			<tr>
				<td class="col_key">
					<label for="billing_data_zip_code"><?php echo WDFText::get('ZIP_CODE'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="billing_data_zip_code" value="<?php echo $row->billing_data_zip_code; ?>">
				</td>
			</tr>
			</tbody>
		</table>
	</fieldset>	

	<fieldset>
		<legend>
			<?php echo WDFText::get('SHIPPING_DATA'); ?>
		</legend>

		<table class="adminlist table">
			<!-- shipping data -->
			<tbody>
			<!-- first name -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_first_name"><?php echo WDFText::get('FIRST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_first_name" value="<?php echo $row->shipping_data_first_name; ?>">
				</td>
			</tr>

			<!-- middle name -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_middle_name"><?php echo WDFText::get('MIDDLE_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_middle_name" value="<?php echo $row->shipping_data_middle_name; ?> ">
				</td>
			</tr>

			<!-- last name -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_last_name"><?php echo WDFText::get('LAST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_last_name" value="<?php echo $row->shipping_data_last_name; ?> ">
				</td>
			</tr>

			<!-- company -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_company"><?php echo WDFText::get('COMPANY'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_company" value="<?php echo $row->shipping_data_company; ?>">
				</td>
			</tr>

			<!-- country -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_country"><?php echo WDFText::get('COUNTRY'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_country" value="<?php echo $row->shipping_data_country; ?>">
				</td>
			</tr>

			<!-- state -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_state"><?php echo WDFText::get('STATE'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_state" value="<?php echo $row->shipping_data_state; ?>">
				</td>
			</tr>

			<!-- city -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_city"><?php echo WDFText::get('CITY'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_city" value="<?php echo $row->shipping_data_city; ?>">
				</td>
			</tr>

			<!-- address -->
			<tr>
				<td class="col_key">
					<label for=""><?php echo WDFText::get('ADDRESS'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_address" value="<?php echo $row->shipping_data_address; ?>">
				</td>
			</tr>

			<!-- zip code -->
			<tr>
				<td class="col_key">
					<label for="shipping_data_zip_code"><?php echo WDFText::get('ZIP_CODE'); ?>:</label>
				</td>
				<td class="col_value">
					<input name="shipping_data_zip_code" value="<?php echo $row->shipping_data_zip_code; ?>">
				</td>
			</tr>
			</tbody>
		</table>	
		
	</fieldset>
</div>

<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
<input type="hidden" name="read" id="read" value="1">
</form>