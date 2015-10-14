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


$lists = $this->lists;
$list_countries = $lists['countries'];
$list_usergroups = $lists['usergroups'];
$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table">
        <tbody>
        <!-- first name -->
        <tr>
            <td class="col_key">
                <label for="first_name"><?php echo WDFText::get('FIRST_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="first_name"
                       id="first_name"
                       value="<?php echo $row->first_name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- middle name -->
        <tr>
            <td class="col_key">
                <label for="middle_name"><?php echo WDFText::get('MIDDLE_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="middle_name"
                       id="middle_name"
                       value="<?php echo $row->middle_name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- last name -->
        <tr>
            <td class="col_key">
                <label for="last_name"><?php echo WDFText::get('LAST_NAME'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="last_name"
                       id="last_name"
                       value="<?php echo $row->last_name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- company -->
        <tr>
            <td class="col_key">
                <label for="company"><?php echo WDFText::get('COMPANY'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="company"
                       id="company"
                       value="<?php echo $row->company; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- country -->
        <tr>
            <td class="col_key">
                <label for="country_id"><?php echo WDFText::get('COUNTRY'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHtml::_('select.genericlist', $list_countries, 'country_id', '', 'id', 'name', $row->country_id); ?>
            </td>
        </tr>

        <!-- state -->
        <tr>
            <td class="col_key">
                <label for="state"><?php echo WDFText::get('STATE'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="state"
                       id="state"
                       value="<?php echo $row->state; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- city -->
        <tr>
            <td class="col_key">
                <label for="city"><?php echo WDFText::get('CITY'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="city"
                       id="city"
                       value="<?php echo $row->city; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- address -->
        <tr>
            <td class="col_key">
                <label for="address"><?php echo WDFText::get('ADDRESS'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="address"
                       id="address"
                       value="<?php echo $row->address; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- mobile -->
        <tr>
            <td class="col_key">
                <label for="mobile"><?php echo WDFText::get('MOBILE'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="mobile"
                       id="mobile"
                       value="<?php echo $row->mobile; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- phone -->
        <tr>
            <td class="col_key">
                <label for="phone"><?php echo WDFText::get('PHONE'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="phone"
                       id="phone"
                       value="<?php echo $row->phone; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- fax -->
        <tr>
            <td class="col_key">
                <label for="fax"><?php echo WDFText::get('FAX'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="fax"
                       id="fax"
                       value="<?php echo $row->fax; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- zip code -->
        <tr>
            <td class="col_key">
                <label for="zip_code"><?php echo WDFText::get('ZIP_CODE'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="zip_code"
                       id="zip_code"
                       value="<?php echo $row->zip_code; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- usergroup -->
        <tr>
            <td class="col_key">
                <label for="usergroup_id"><?php echo WDFText::get('USERGROUP'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHtml::_('select.genericlist', $list_usergroups, 'usergroup_id', '', 'id', 'name', $row->usergroup_id); ?>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>
