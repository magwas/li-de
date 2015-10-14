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
WDFHelper::add_script('js/jquery-ui-1.10.3.js');
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$row_default_currency = $this->default_currency_row;
$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$checked_products = $this->checked_products;
JRequest::setVar( 'hidemainmenu', 1 );

?>
<form name="adminForm" id="adminForm" action="" method="post">

<div class="wd_shop_selected_products ">
	<?php foreach($checked_products as $checked_product_id => $checked_product_name){
	?>
		<span class="wd_shop_product_item">
			<span class="jf_tag_box_item_name"><?php echo $checked_product_name;?> </span>
			<span class="jf_tag_box_item_divider">&nbsp;</span>
			<a id="" class="jfbutton_inline remove" data-productid="<?php echo $checked_product_id;?>" onclick="onBtnRemoveProduct(event,this);"><span class="jfbutton_inline_icon jfbutton_inline_icon_remove"></span>&nbsp;</a>
			&nbsp;&nbsp;
		</span>
	<?php 
	}
	?>	
</div>
<table class="adminlist table bulk-table" style="width: 1236px !important;">
<tbody>

<!-- category -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_category" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_category" onclick="onCheckboxEditFieldsClick(event, this);onCategoryChange(this)" />&nbsp;&nbsp;
        <label for="ch_category"><?php echo WDFText::get('CATEGORY'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" id="category_name" name = "category_name" disabled="disabled" value="<?php echo WDFInput::get('category_name')?>" />
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveCategoryClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectCategoryClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="category_id"
               id="category_id"
               value="0"/>
    </td>
</tr>

<!-- manufacturer -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_manufacturer" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_manufacturer" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_manufacturer"><?php echo WDFText::get('MANUFACTURER'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="manufacturer_name" value=""
               disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveManufacturerClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectManufacturerClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=manufacturers" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="manufacturer_id" id="manufacturer_id"
               value="">
    </td>
</tr>

<!-- discount -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_discount" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_discount" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_discount"><?php echo WDFText::get('DISCOUNT'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="discount_name" value="" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveDiscountClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectDiscountClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=discounts" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="discount_id" id="discount_id" value="">
        <input type="hidden" name="discount_rate" id="discount_rate" value="">
    </td>
</tr>

<!-- tax -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_tax" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_tax" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_tax"><?php echo WDFText::get('TAX'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="tax_name" value="" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveTaxClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectTaxClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=taxes" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="tax_id" id="tax_id" value="">
        <input type="hidden" name="tax_rate" id="tax_rate" value="">
    </td>
</tr>



<!-- amount in stock -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_amount_in_stock" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_amount_in_stock" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_amount_in_stock"><?php echo WDFText::get('AMOUNT_IN_STOCK'); ?>:</label>
    </td>
    <td class="col_value">
        <div>
            <label>
                <input type="checkbox"
                       name="unlimited"
                       value="1"   
					   checked="checked"
                       onchange="onUnlimitedChange(this);">
                <?php echo WDFText::get('UNLIMITED'); ?>
            </label>
        </div>
        <div>
            <input type="text"
                   name="amount_in_stock"
                   id="amount_in_stock"                 
                   value="">
        </div>
    </td>
</tr>


<!-- label -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_label" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_label" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_label"><?php echo WDFText::get('LABEL') ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="label_name" value="" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveLabelClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectLabelClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=labels" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="label_id" id="label_id" value="">
    </td>
</tr>

<!-- pages -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_pages" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_pages" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_pages"><?php echo WDFText::get('LICENSE_PAGES') ?>:</label>
    </td>
    <td class="col_value">
		<div class="delete_existing_data" >
			<label for="delete_pages"><?php echo WDFText::get('ADD_WITH_DELETING_EXISTING_LICENSE_PAGES') ?></label>
			<input type="checkbox" name="delete_pages"  value="1" id="delete_pages" />
		</div>	
        <textarea type="text"
                  name="page_titles"
                  id="page_titles"
                  class="names_list"
                  disabled="disabled"></textarea>
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemovePagesClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectPagesClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=pages" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="page_ids"
               id="page_ids"
               value=""/>
    </td>
</tr>

<!-- shipping methods -->
<tr>
    <td class="col_key">
		<input type="checkbox" id="ch_shipping" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_shipping_methods" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
        <label for="ch_shipping"><?php echo WDFText::get('ENABLE_SHIPPING') ?>:</label>
    </td>
	<td class="col_value">
		<div class="delete_existing_data">
			<label for="delete_shipping_methods"><?php echo WDFText::get('ADD_WITH_DELETING_EXISTING_SHIPPING_METHODS') ?></label>
			<input type="checkbox" name="delete_shipping_methods"  value="1" id="delete_shipping_methods" />
		</div>
		<?php echo JHTML::_('select.radiolist',$list_shipping_data_field, 'enable_shipping', 'onchange="onShippingChange(this);"', 'value', 'text',''); ?>
	</td>
</tr>

<tr id="shipping_methods">
    <td class="col_key">
        <label><?php echo WDFText::get('SHIPPING_METHODS') ?>:</label>
		<span class="star">*</span>
    </td>
    <td class="col_sh_value">
        <textarea type="text"
                  name="shipping_method_names"
                  id="shipping_method_names"
                  class="names_list" 
                  disabled="disabled"></textarea>
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveShippingMethodsClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectShippingMethodsClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=shippingmethods" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="shipping_method_ids"
               id="shipping_method_ids"
               value=""/>
    </td>
</tr>
</tbody>
</table>

<!-- parameters -->

<table class="adminlist table bulk-table" style="width: 1236px !important;">
	<tr>
		<td class="col_key">		
			<input type="checkbox" id="ch_parameters" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_parameters" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
			<label for="ch_parameters"><?php echo WDFText::get('PARAMETERS') ?>:</label>						
		</td>
		<td class="col_value">
			<div class="delete_existing_data" >
				<label for="delete_parameters"><?php echo WDFText::get('ADD_WITH_DELETING_EXISTING_PARATMETERS') ?></label>
				<input type="checkbox" name="delete_parameters"  value="1" id="delete_parameters" />
			</div>			
			<table class="adminlist table">
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
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_INHERIT_CATEGORY_PARAMETERS'), 'add_category_parameters', '', 'onclick="onBtnInheritCategoryParametersClick(event, this);" data-category-parameters="[]"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_REMOVE_ALL'), '', '', 'onclick="onBtnRemoveAllParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=parameters" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
					</span>
					</td>
				</tr>
				</tbody>
			</table>
			<input type="hidden" name="parameters"/>			
		</td>
	</tr>
</table>

<!-- tags -->

<table class="adminlist table bulk-table" style="width: 1236px !important;">
	<tr>
		<td class="col_key">
			<input type="checkbox" id="ch_tags" name="edit_fields[]" title="<?php echo WDFText::get('CHECK_TO_EDIT');?>" value="ch_tags" onclick="onCheckboxEditFieldsClick(event, this);" />&nbsp;&nbsp;	
			<label for="ch_tags"><?php echo WDFText::get('TAGS') ?>:</label>		
		</td>
		<td class="col_value">
			<div class="delete_existing_data" >		
				<label for="delete_tags"><?php echo WDFText::get('ADD_WITH_DELETING_EXISTING_TAGS') ?></label>
				<input type="checkbox" name="delete_tags"  value="1" id="delete_tags" />
			</div>		
			<table class="adminlist table">
				<tbody>
				<tr>
					<td class="col_value">
						<?php echo WDFHTML::jf_tag_box('tag_box'); ?>
					</td>
				</tr>

				<tr>
					<td class="col_value">
					<span id="tag_buttons_container">
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_ADD_TAGS'), '', '', 'onclick="onBtnAddTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_INHERIT_CATEGORY_TAGS'), 'add_category_tags', '', 'onclick="onBtnInheritCategoryTagsClick(event, this);" data-category-tags="[]"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_REMOVE_ALL'), '', '', 'onclick="onBtnRemoveAllTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
						<?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=tags" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
					</span>
					</td>
				</tr>

				<tr>
					<input type="hidden" name="tag_ids"/>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>		
</table>

<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxcheckeds" value="<?php echo WDFInput::get("boxcheckeds");?>"/>
<input type="hidden" name="id" value=""/>

</form>

<script>
    var _categoryId = "0";
    var _manufacturerId = "";	
    var _imageUrls = JSON.parse("[]");	
    var _parameters = JSON.parse("[]");	
    var _categoryParameters = JSON.parse("[]");
    var _tags = JSON.parse("[]");	
    var _categoryTags = JSON.parse("[]");	
	var _default_shipping = "";	
	var _url_root = "<?php echo JURI::root() ; ?>";
	
	
</script>
