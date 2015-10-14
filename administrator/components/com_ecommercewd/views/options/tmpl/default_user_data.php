<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$lists = $this->lists;
$list_user_data_field = $lists['user_data_field'];

$options = $this->options;
$initial_values = $options['initial_values'];

$user_data_fields = $this->user_data_fields;
?>

<table class="adminlist table">
    <tbody>
    <?php
    foreach ($user_data_fields as $user_data_field) {
        ?>
        <tr>
            <td class="col_key">
                <label for="<?php echo $user_data_field->name; ?>">
                    <?php echo $user_data_field->label; ?>:
                </label>
            </td>

            <td class="col_value">
                <?php echo JHTML::_('select.radiolist', $list_user_data_field, $user_data_field->name, '', 'value', 'text', $initial_values[$user_data_field->name]); ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<!-- ctrls -->
<table class="adminlist table">
    <tbody>
    <tr>
        <td class="btns_container">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'user_data\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'user_data\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>