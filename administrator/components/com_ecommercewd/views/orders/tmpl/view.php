<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/layout_edit.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_edit.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$lists = $this->lists;
$list_order_statuses = $lists['order_statuses'];

$row = $this->row;

?>

<form name="adminForm" id="adminForm" action="" method="post">
<fieldset>
    <legend>
        <?php echo WDFText::get('MAIN_DATA'); ?>
    </legend>

    <table class="adminlist table">
        <tbody>
        <!-- status -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('STATUS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php
                echo JHTML::_('select.genericlist', $list_order_statuses, 'status_id', '', 'id', 'name', $row->status_id);
                echo WDFHTML::jfbutton(WDFText::get('BTN_SAVE'), '', '', 'onclick="onBtnUpdateOrderStatusClick(event, this, ' . $row->id . ');"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL);
                ?>
            </td>
        </tr>

        <!-- user -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USER'); ?>:</label>
            </td>
            <td class="col_value">
                <?php
                if ($row->user_id != 0) {
                    echo WDFHTML::jfbutton_inline($row->user_name, WDFHTML::BUTTON_INLINE_TYPE_GOTO, '', '', 'href="' . $row->user_view_url . '" target="_blank"', WDFHTML::BUTTON_ICON_POS_RIGHT);
                } else {
                    echo $row->user_name;
                }
                ?>
            </td>
        </tr>

        <!-- user ip -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USER_IP_ADDRESS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->user_ip_address; ?>
            </td>
        </tr>

        <!-- product names -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PRODUCTS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->product_names; ?>
            </td>
        </tr>

        <!-- payment method -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PAYMENT_METHOD'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->payment_method; ?>
            </td>
        </tr>

        <!-- payment status -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PAYMENT_STATUS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->payment_data_status; ?>
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
					<label><?php echo WDFText::get('FIRST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_first_name; ?>
				</td>
			</tr>

			<!-- middle name -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('MIDDLE_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_middle_name; ?>
				</td>
			</tr>

			<!-- last name -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('LAST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_last_name; ?>
				</td>
			</tr>

			<!-- company -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('COMPANY'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_company; ?>
				</td>
			</tr>

			<!-- email -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('EMAIL'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_email; ?>
				</td>
			</tr>

			<!-- country -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('COUNTRY'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_country; ?>
				</td>
			</tr>

			<!-- state -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('STATE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_state; ?>
				</td>
			</tr>

			<!-- city -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('CITY'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_city; ?>
				</td>
			</tr>

			<!-- address -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('ADDRESS'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_address; ?>
				</td>
			</tr>

			<!-- zip code -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('ZIP_CODE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_zip_code; ?>
				</td>
			</tr>

			<!-- phone -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('PHONE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_phone; ?>
				</td>
			</tr>

			<!-- fax -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('FAX'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_fax; ?>
				</td>
			</tr>

			<!-- mobile -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('MOBILE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->billing_data_mobile; ?>
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
					<label><?php echo WDFText::get('FIRST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_first_name; ?>
				</td>
			</tr>

			<!-- middle name -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('MIDDLE_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_middle_name; ?>
				</td>
			</tr>

			<!-- last name -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('LAST_NAME'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_last_name; ?>
				</td>
			</tr>

			<!-- company -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('COMPANY'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_company; ?>
				</td>
			</tr>


			<!-- country -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('COUNTRY'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_country; ?>
				</td>
			</tr>

			<!-- state -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('STATE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_state; ?>
				</td>
			</tr>

			<!-- city -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('CITY'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_city; ?>
				</td>
			</tr>

			<!-- address -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('ADDRESS'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_address; ?>
				</td>
			</tr>
		
			<!-- zip code -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('ZIP_CODE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_data_zip_code; ?>
				</td>
			</tr>
			</tbody>
		</table>
		<table class="adminlist table">
			<tbody>
			<!-- shipping price -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('SHIPPING_PRICE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->shipping_price; ?>
				</td>
			</tr>

			<!-- checkout date -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('CHECKOUT_DATE'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->checkout_date; ?>
				</td>
			</tr>

			<!-- date modified -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('DATE_MODIFIED'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo $row->date_modified; ?>
				</td>
			</tr>
			</tbody>
		</table>	
	</fieldset>
</div>

<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="redirect_task" value=""/>
<input type="hidden" name="order_status_<?php echo $row->id; ?>" value=""/>
<input type="hidden" name="boxchecked" value="<?php echo $row->id; ?>"/>
<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>"/>
</form>