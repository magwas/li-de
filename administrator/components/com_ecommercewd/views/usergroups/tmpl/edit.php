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

        <!-- users -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USERS') ?>:</label>
            </td>
            <td class="col_value">
                <textarea type="text"
                          name="user_names"
                          id="user_names"
                          class="names_list"
                          disabled="disabled"><?php echo $row->user_names; ?></textarea>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveUsersClick(event, this);"'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectUsersClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
                <input type="hidden"
                       name="user_ids"
                       id="user_ids"
                       value="<?php echo implode(',', $row->user_ids); ?>"/>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
    <input type="hidden" name="default" value="<?php echo $row->default; ?>"/>
</form>