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

        <!-- logo -->
        <tr>
            <td class="col_key">
                <label for="site"><?php echo WDFText::get('LOGO'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo WDFHTML::jf_thumb_box('thumb_box'); ?>
                <input type="hidden" name="logo" id="logo" value="<?php echo $row->logo; ?>"/>
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

        <!-- website -->
        <tr>
            <td class="col_key">
                <label for="site"><?php echo WDFText::get('WEBSITE'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="site"
                       id="site"
                       value="<?php echo $row->site; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
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
    var _logoUrls = JSON.parse("<?php echo addslashes(stripslashes($row->logo)); ?>");
	var _url_root = "<?php echo JURI::root() ; ?>";
</script>

