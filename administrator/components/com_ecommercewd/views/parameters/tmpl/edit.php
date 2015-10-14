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
$parameter_types = $this->parameter_types;
JRequest::setVar( 'hidemainmenu', 1 );
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table">
        <!-- name -->
        <tr>
            <td class="col_key">
                <label for="name"><?php echo WDFText::get('NAME'); ?>&nbsp;<span class="star">*</span></label>
            </td>
            <td class="col_value" colspan="2">
                <input type="text"
                       name="name"
                       id="name"
                       class="required_field"
                       value="<?php echo $row->name; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>
        <!-- type -->
        <tr>
            <td class="col_key">
                <label for="param_type"> <?php echo WDFText::get('Type'); ?></label>
            </td>
            <td class="col_value" colspan="2">
                <?php echo JHTML::_('select.genericlist', $parameter_types, 'type_id', 'onchange="OnParameterTypesChange(event, this)"', 'id', 'name', $row->type_id); ?>
            </td>
        </tr>
        <!-- default values -->
        <tr class="parameter_container">
            <td class="col_key">
                <label for="param_default_values"> <?php echo WDFText::get('DEFAULT VALUES'); ?></label>
            </td>
            <td class="col_parameter_value parameter_values_container">
                <div class="template parameter_value_container single_parameter_value_container">
                        <input type="text" name="" class="parameter_value">
                    <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter_value', 'onclick="onBtnRemoveParameterValueClick(event, this);"'); ?>
                </div>
            </td>
            <td>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_ADD, '', 'btn_add_parameter_value', 'onclick="onBtnAddParameterValueClick(event, this);"'); ?>
            </td>
        </tr>

        <!-- required -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('REQUIRED'); ?></label>
            </td>
            <td class="col_value" colspan="2">
                <?php echo JHtml::_('select.booleanlist', 'required', '', $row->required, WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>
    </table>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
	<input type="hidden" name="default_values"/>
</form>

<script>
    var _defaultValues = JSON.parse("<?php echo addslashes($row->default_values); ?>");
    var _typeId = <?php echo $row->type_id; ?>;
</script>