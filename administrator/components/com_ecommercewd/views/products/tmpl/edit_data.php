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
$model_options = WDFHelper::get_model('options');
$options = $model_options->get_options();
$initial_values = $options['initial_values'];
JRequest::setVar( 'hidemainmenu', 1 );

?>

<table class="adminlist table">
<tbody>
<!-- model-->
<tr>
    <td class="col_key">
        <label for="model"><?php echo WDFText::get('MODEL'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text"
               name="model"
               id="model"
               value="<?php echo $row->model; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<!-- price -->
<tr>
    <td class="col_key ">
        <label for="price"><?php echo WDFText::get('PRICE'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text"
               name="price"
               id="price"
               onkeyup="onPriceChange(event, this);"
               value="<?php echo $row->price; ?>">
        <?php echo $row_default_currency->code; ?>
    </td>
</tr>

<!-- discount -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('DISCOUNT'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="discount_name" value="<?php echo $row->discount_name; ?>" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveDiscountClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectDiscountClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=discounts" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="discount_id" id="discount_id" value="<?php echo $row->discount_id; ?>">
        <input type="hidden" name="discount_rate" id="discount_rate" value="<?php echo $row->discount_rate; ?>">
    </td>
</tr>

<!-- tax -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('TAX'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="tax_name" value="<?php echo $row->tax_name; ?>" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveTaxClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectTaxClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=taxes" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="tax_id" id="tax_id" value="<?php echo $row->tax_id; ?>">
        <input type="hidden" name="tax_rate" id="tax_rate" value="<?php echo $row->tax_rate; ?>">
    </td>
</tr>

<!-- final price -->
<tr>
    <td class="col_key">
        <label for="final_price"><?php echo WDFText::get('FINAL_PRICE'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text"
               name="final_price"
               id="final_price"
               onkeyup="onFinalPriceChange(event, this);"
               value="<?php echo($row->final_price); ?>">
        <?php echo $row_default_currency->code; ?>
    </td>
</tr>

<!-- market price -->
<tr>
    <td class="col_key">
        <label for="market_price"><?php echo WDFText::get('MARKET_PRICE'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text"
               name="market_price"
               id="market_price"
               value="<?php echo $row->market_price; ?>">
        <?php echo $row_default_currency->code; ?>
    </td>
</tr>
<!-- amount in stock -->
<tr>
    <td class="col_key">
        <label for="amount_in_stock"><?php echo WDFText::get('AMOUNT_IN_STOCK'); ?>:</label>
    </td>
    <td class="col_value">
        <div>
            <label>
                <input type="checkbox"
                       name="unlimited"
                       value="1"
                    <?php echo $row->unlimited == 1 ? 'checked="checked"' : ''; ?>
                       onchange="onUnlimitedChange(event, this);">
                <?php echo WDFText::get('UNLIMITED'); ?>
            </label>
        </div>
        <div>
            <input type="text"
                   name="amount_in_stock"
                   id="amount_in_stock"
                   class="<?php echo $row->unlimited == 1 ? "hidden" : ""; ?>"
                   value="<?php echo $row->amount_in_stock; ?>">
        </div>
    </td>
</tr>

<?php if( $initial_values['enable_sku'] == 1 ){?>
<!-- sku-->
<tr>
    <td class="col_key">
        <label for="sku" ><?php echo WDFText::get('SKU'); ?>:</label>
		<div><small><?php echo WDFText::get('STOCK_KEEPING_UNIT'); ?></small></div>
    </td>
    <td class="col_value">
        <input type="text"
               name="sku"
               id="sku"
               value="<?php echo $row->sku; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<?php }

if( $initial_values['enable_upc'] == 1 ){
?>
<!-- upc-->
<tr>
    <td class="col_key">
        <label for="upc" ><?php echo WDFText::get('UPC'); ?>:</label>
		<div><small><?php echo WDFText::get('UNIVERSAL_PRODUCT_CODE'); ?></small></div>
    </td>
    <td class="col_value">
        <input type="text"
               name="upc"
               id="upc"
               value="<?php echo $row->upc; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<?php }
if( $initial_values['enable_ean'] == 1 ){
?>
<!-- ean-->
<tr>
    <td class="col_key">
        <label for="ean" ><?php echo WDFText::get('EAN'); ?>:</label>
		<div><small><?php echo WDFText::get('EUROPEAN_ARTICLE_NUMBER'); ?></small></div>
    </td>
    <td class="col_value">
        <input type="text"
               name="ean"
               id="ean"
               value="<?php echo $row->ean; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<?php }
if( $initial_values['enable_jan'] == 1 ){
?>
<!-- jan-->
<tr>
    <td class="col_key">
        <label for="jan" ><?php echo WDFText::get('JAN'); ?>:</label>
		<div><small><?php echo WDFText::get('JAPANESS_ARTICLE_NUMBER'); ?></small></div>
    </td>
    <td class="col_value">
        <input type="text"
               name="jan"
               id="jan"
               value="<?php echo $row->jan; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<?php }
if( $initial_values['enable_isbn'] == 1 ){
?>
<!-- isbn-->
<tr>
    <td class="col_key">
        <label for="isbn" ><?php echo WDFText::get('ISBN'); ?>:</label>
		<div><small><?php echo WDFText::get('INTERNATIONAL_STANDART_BOOK_NUMBER'); ?></small></div>
    </td>
    <td class="col_value">
        <input type="text"
               name="isbn"
               id="isbn"
               value="<?php echo $row->isbn; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<?php }
if( $initial_values['enable_mpn'] == 1 ){
?>
<!-- mpn-->
<tr>
    <td class="col_key">
        <label for="mpn" ><?php echo WDFText::get('MPN'); ?>:</label>
		<div><small><?php echo WDFText::get('MANUFACTURER_PART_NUMBER'); ?></small></div>
    </td>
    <td class="col_value">
        <input type="text"
               name="mpn"
               id="mpn"
               value="<?php echo $row->mpn; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>
<?php }
?>

<!-- published -->
<tr>
	<td class="col_key">
		<label><?php echo WDFText::get('PUBLISHED'); ?>:</label>
	</td>
	<td class="col_value">
		<?php echo JHTML::_('select.booleanlist', 'published', '', $row->published, WDFText::get('YES'), WDFText::get('NO')); ?>
	</td>
</tr>
</tbody>
</table>


