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
<table class="adminlist table">
<tbody>

<!-- category -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('CATEGORY'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" id="category_name" disabled="disabled" value="<?php echo $row->category_name; ?>"/>
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveCategoryClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectCategoryClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="category_id"
               id="category_id"
               value="<?php echo $row->category_id; ?>"/>
    </td>
</tr>

<!-- manufacturer -->
<tr>
    <td class="col_key">
        <label for="manufacturer_id"><?php echo WDFText::get('MANUFACTURER'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="manufacturer_name" value="<?php echo $row->manufacturer_name; ?>"
               disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveManufacturerClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectManufacturerClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=manufacturers" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="manufacturer_id" id="manufacturer_id"
               value="<?php echo $row->manufacturer_id; ?>">
    </td>
</tr>

<!-- label -->
<tr>
    <td class="col_key">
        <label for="label_id"><?php echo WDFText::get('LABEL') ?>:</label>
    </td>
    <td class="col_value">
        <input type="text" name="label_name" value="<?php echo $row->label_name; ?>" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveLabelClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectLabelClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=labels" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="label_id" id="label_id" value="<?php echo $row->label_id; ?>">
    </td>
</tr>

<!-- pages -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('LICENSE_PAGES') ?>:</label>
    </td>
    <td class="col_value">
        <textarea type="text"
                  name="page_titles"
                  id="page_titles"
                  class="names_list"
                  disabled="disabled"><?php echo $row->page_titles; ?></textarea>
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemovePagesClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectPagesClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=pages" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="page_ids"
               id="page_ids"
               value="<?php echo implode(',', $row->page_ids); ?>"/>
    </td>
</tr>
</tbody>
</table>













