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

$list_value_sign_positions = array();
$list_value_sign_positions[] = (object)array('value' => '0', 'text' => WDFText::get('LEFT'));
$list_value_sign_positions[] = (object)array('value' => '1', 'text' => WDFText::get('RIGHT'));

$currencies_data = $this->currencies_data;
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

        <!-- code -->
        <tr>
            <td class="col_key">
                <label for="code"><?php echo WDFText::get('CODE'); ?>:</label>
                <span class="star">*</span>
            </td>
            <td class="col_value">
                <input type="text"
                       name="code"
                       id="code"
                       class="required_field"
                       value="<?php echo $row->code; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- sign -->
        <tr>
            <td class="col_key">
                <label for="sign"><?php echo WDFText::get('SIGN'); ?>:</label>
            </td>
            <td class="col_value">
                <input type="text"
                       name="sign"
                       id="sign"
                       value="<?php echo $row->sign; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- sign position -->
        <tr>
            <td class="col_key">
                <label for="sign_position"><?php echo WDFText::get('SIGN_POSITION'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.radiolist', $list_value_sign_positions, 'sign_position', '', 'value', 'text', $row->sign_position); ?>
            </td>
        </tr>
        </tbody>

        <tbody>
		<?php foreach($currencies_data as $currency_data ):?>
			<tr>
				<td class="btn_select_container" colspan="2">
					<?php echo WDFHTML::jfbutton($currency_data->text, '', '', 'onclick="onBtnSelectCurrencyClick(event, this,\''.$currency_data->payment_name.'\' );"'); ?>
				</td>
			</tr>
		<?php endforeach;?>
        </tbody>
    </table>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>


