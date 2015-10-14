<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

jimport('joomla.html.html.tabs');

// css
WDFHelper::add_css('css/layout_' . $this->_layout . '.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/framework/color_utils.js');
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );
?>

<form name="adminForm" id="adminForm" action="" method="POST">
    <table class="adminlist table">
        <!-- name -->
        <tr>
            <td class="col_key">
                <label for="name">
                    <?php echo WDFText::get('NAME'); ?>&nbsp;<span class="star">*</span>
                </label>
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

        <!-- rounded corners -->
        <tr>
            <td class="col_key">
                <label>
                    <?php echo WDFText::get('ROUNDED_CORNERS'); ?>:
                </label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.booleanlist', 'rounded_corners', ' onchange="onRoundCornersChange(event, this);"', $row->rounded_corners, WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>

        <!-- main text color -->
        <tr>
            <td class="col_key">
                <label>
                    <?php echo WDFText::get('MAIN_TEXT_COLOR'); ?>:
                </label>
            </td>

            <td class="col_value">
                <ul class="list_color_pickers">
                    <li>
                        <span><?php echo WDFText::get('CONTENT'); ?>:</span>
                        <br>
                        <span><?php echo WDFHTML::jf_color_picker('content_main_color', '', $row->content_main_color, '', '', 'onColorChange'); ?></span>
                    </li>
                </ul>
            </td>
        </tr>
    </table>

    <?php
    WDFHTMLTabs::startTabs('tab_group_theme', WDFInput::get('tab_index'), 'onTabActivated');

    WDFHTMLTabs::startTab('options_elements', WDFText::get('ELEMENTS_OPTIONS'));
    echo $this->loadTemplate('elements');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_components', WDFText::get('COMPONENTS_OPTIONS'));
    echo $this->loadTemplate('components');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_products', WDFText::get('PRODUCT_OPTIONS'));
    echo $this->loadTemplate('products');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::endTabs();
    ?>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
    <input type="hidden" name="basic" value="<?php echo $row->basic; ?>"/>
    <input type="hidden" name="default" value="<?php echo $row->default; ?>"/>
    <input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>"/>
</form>
