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
                <label for="user_name"><?php echo WDFText::get('USER_NAME'); ?>:</label>
                <span class="star">*</span>
            </td>
            <td class="col_value">
                <input type="text"
                       name="user_name"
                       id="user_name"
                       class="required_field"
                       value="<?php echo $row->user_name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>
		<tr>
            <td class="col_key">
                <label for="user_name"><?php echo WDFText::get('SENDER_NAME'); ?>:</label>
                <span class="star">*</span>
            </td>
            <td class="col_value">
                <input type="text"
                       name="sender_name"
                       id="sender_name"
                       class="required_field"
                       value="<?php echo $row->sender_name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- text -->
        <tr>
            <td class="col_key">
                <label for="text"><?php echo WDFText::get('REVIEW'); ?>:</label>
            </td>
            <td class="col_value">
                <textarea name="text" id="text" class="review_text"><?php echo $row->text; ?></textarea>
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
    <input type="hidden" name="user_ip_address" value="<?php echo $row->user_ip_address; ?>"/>
</form>