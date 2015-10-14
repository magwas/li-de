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


$row = $this->row;
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table">
        <tbody>
        <!-- name -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USER_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->user_name; ?>
            </td>
        </tr>
		<tr>
            <td class="col_key">
                <label><?php echo WDFText::get('SENDER_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->sender_name; ?>
            </td>
        </tr>

        <!-- sender ip -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('SENDER_IP'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->user_ip_address; ?>
            </td>
        </tr>

        <!-- manufacturer -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('MANUFACTURER'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->manufacturer_name; ?>
            </td>
        </tr>

        <!-- product -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PRODUCT'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->product_name; ?>
            </td>
        </tr>

        <!-- review date -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('REVIEW_DATE'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->date; ?>
            </td>
        </tr>

        <!-- text -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('REVIEW'); ?>:</label>
            </td>
            <td class="col_value">
                <span class="review_text"><?php echo $row->text; ?></span>
            </td>
        </tr>

        <!-- published -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PUBLISHED'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->published == 1 ? WDFText::get('YES') : WDFText::get('NO'); ?>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="1"/>
    <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>"/>
</form>