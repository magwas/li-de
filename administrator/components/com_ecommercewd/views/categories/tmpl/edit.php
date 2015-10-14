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

    <!-- parent category -->
    <tr>
        <td class="col_key">
            <label><?php echo WDFText::get('PARENT_CATEGORY'); ?>:</label>
        </td>
        <td class="col_value">
            <input type="text" id="parent_name" disabled="disabled" value="<?php echo $row->parent_name; ?>"/>
            <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveParentCategoryClick(event, this);"'); ?>
            <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnChangeParentCategoryClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
            <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
            <input type="hidden"
                   name="parent_id"
                   id="parent_id"
                   value="<?php echo $row->parent_id; ?>"/>
        </td>
    </tr>

    <!-- images -->
    <tr>
        <td class="col_key">
            <label><?php echo WDFText::get('IMAGES'); ?>:</label>
        </td>
        <td class="col_value">
            <?php echo WDFHTML::jf_thumb_box('thumb_box'); ?>
            <input type="hidden" name="images" id="images" value="<?php echo $row->images; ?>"/>
        </td>
    </tr>

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
    </tbody>
</table>

<table class="adminlist table">
    <tbody>
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

<!-- parameters -->
<fieldset>
    <legend><?php echo WDFText::get('PARAMETERS'); ?>:</legend>

    <table class="adminlist table">
        <tbody id="parameters_container">
        <tr class="template parameter_container" parameter_id="" parameter_name="">
			<td class="col-ordering"><i class="hasTooltip icon-drag" title="" data-original-title=""></i></td>
            <td class="col_parameter_key">
                <span class="parameter_name"></span>
                <span class="required_sign">*</span>
            </td>
            <td>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter', 'onclick="onBtnRemoveParameterClick(event, this);"'); ?>
            </td>
        </tr>
        </tbody>

        <tbody>
        <tr>
            <td colspan="3">
            <span>
                <?php echo '* - ' . WDFText::get('REQUIRED_PARAMETERS'); ?>
            </span>
            <span id="parameter_buttons_container">
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_ADD_PARAMETERS'), '', '', 'onclick="onBtnAddParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_INHERIT_PARENT_PARAMETERS'), '', '', 'onclick="onBtnInheritParentsParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
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

<!-- tags -->
<fieldset>
    <legend><?php echo WDFText::get('TAGS'); ?>:</legend>

    <table class="adminlist table">
        <tbody>
        <tr>
            <td class="col_value">
                <?php echo WDFHTML::jf_tag_box('tag_box', ''); ?>
            </td>
        </tr>

        <tr>
            <td class="col_value">
            <span id="tag_buttons_container">
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_ADD_TAGS'), '', '', 'onclick="onBtnAddTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_INHERIT_PARENT_TAGS'), '', '', 'onclick="onBtnInheritParentsTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
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

<table class="adminlist table">
    <tbody>
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


<input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>

<script>
    var _parentId = "<?php echo $row->parent_id; ?>";
    var _categoryId = "<?php echo $row->id; ?>";

    var _imageUrls = JSON.parse("<?php echo addslashes(stripslashes($row->images)); ?>");

    var _parameters = JSON.parse("<?php echo addslashes(stripslashes($row->parameters)); ?>");
    var _parentParameters = JSON.parse("<?php echo addslashes(stripslashes($row->parent_parameters)); ?>");

    var _tags = JSON.parse("<?php echo addslashes(stripslashes($row->tags)); ?>");
    var _parentTags = JSON.parse("<?php echo addslashes(stripslashes($row->parent_tags)); ?>");
	var _url_root = "<?php echo JURI::root() ; ?>";
</script>