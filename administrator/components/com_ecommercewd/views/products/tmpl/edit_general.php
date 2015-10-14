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
<!-- name-->
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

<!-- alias-->
<tr>
    <td class="col_key">
        <label for="alias"><?php echo WDFText::get('ALIAS'); ?>:</label>
    </td>
    <td class="col_value">
        <input type="text"
               name="alias"
               id="alias"
               value="<?php echo $row->alias; ?>"
               onKeyPress="return disableEnterKey(event);"/>
    </td>
</tr>

</tbody>

<tbody>
<!-- description -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('DESCRIPTION'); ?>:</label>
    </td>
    <td class="col_value">
        <?php
        $editor = JFactory::getEditor();
        echo $editor->display('description', $row->description, '500px', '100px', 20, 20);
        ?>
    </td>
</tr>

<!-- meta title-->
<tr>
	<td class="col_key">
		<label for="meta_title"><?php echo WDFText::get('META_TITLE'); ?>:</label>
	</td>
	<td class="col_value">
		<input type="text"
			   name="meta_title"
			   id="meta_title"
			   value="<?php echo $row->meta_title; ?>"
			   onKeyPress="return disableEnterKey(event);"/>
	</td>
</tr>

<!-- meta description-->
<tr>
	<td class="col_key">
		<label for="meta_description"><?php echo WDFText::get('META_DESCRIPTION'); ?>:</label>
	</td>
	<td class="col_value">
		<input type="text"
			   name="meta_description"
			   id="meta_description"
			   value="<?php echo $row->meta_description; ?>"
			   onKeyPress="return disableEnterKey(event);"/>
	</td>
</tr>

<!-- meta keyword-->
<tr>
	<td class="col_key">
		<label for="meta_keyword"><?php echo WDFText::get('META_KEYWORD'); ?>:</label>
	</td>
	<td class="col_value">
		<input type="text"
			   name="meta_keyword"
			   id="meta_keyword"
			   value="<?php echo $row->meta_keyword; ?>"
			   onKeyPress="return disableEnterKey(event);"/>
	</td>
</tr>
</tbody>
</table>

<!-- tags -->
<fieldset>
    <legend><?php echo WDFText::get('TAGS'); ?>:</legend>

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
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_INHERIT_CATEGORY_TAGS'), '', '', 'onclick="onBtnInheritCategoryTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
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
</fieldset>


