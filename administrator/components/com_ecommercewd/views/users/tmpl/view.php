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
$list_usergroups = $lists['usergroups'];
$row = $this->row;
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table">
        <tbody>
        <!-- first name -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('FIRST_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->first_name; ?>
            </td>
        </tr>

        <!-- middle name -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('MIDDLE_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->middle_name; ?>
            </td>
        </tr>

        <!-- last name -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('LAST_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->last_name; ?>
            </td>
        </tr>

        <!-- company -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('COMPANY'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->company; ?>
            </td>
        </tr>

        <!-- email -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('EMAIL'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->email; ?>
            </td>
        </tr>

        <!-- country -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('COUNTRY'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->country_name; ?>
            </td>
        </tr>

        <!-- state -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('STATE'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->state; ?>
            </td>
        </tr>

        <!-- city -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('CITY'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->city; ?>
            </td>
        </tr>

        <!-- address -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('ADDRESS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->address; ?>
            </td>
        </tr>

        <!-- mobile -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('MOBILE'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->mobile; ?>
            </td>
        </tr>

        <!-- phone -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PHONE'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->phone; ?>
            </td>
        </tr>

        <!-- fax -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('FAX'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->fax; ?>
            </td>
        </tr>

        <!-- zip code -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('ZIP_CODE'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->zip_code; ?>
            </td>
        </tr>

        <!-- usergroup_id -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USERGROUP'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo $row->usergroup_name; ?>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="<?php echo $row->id; ?>"/>
</form>