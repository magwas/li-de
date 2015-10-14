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
WDFHelper::add_script('js/jquery-ui-1.10.3.js');
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$row_default_currency = $this->default_currency_row;
$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );

?>

<table class="adminlist table">
<tbody>
<!-- rating-->
<tr>
    <td class="col_key">
        <label ><?php echo WDFText::get('RATINGS'); ?>:</label>
    </td>
    <td class="col_value">
		<a href="index.php?option=com_<?php echo WDFHelper::get_com_name();?>&controller=ratings&search_product_id=<?php echo $row->id?>" target="_blank" class="jfbutton jfbutton_color_white jfbutton_size_small ">
			<span><?php echo WDFText::get('RATINGS'); ?></span>
		</a>
    </td>
</tr>
<!-- feedback-->
<tr>
    <td class="col_key">
        <label ><?php echo WDFText::get('FEEDBACK'); ?>:</label>
    </td>
    <td class="col_value">
		<a href="index.php?option=com_<?php echo WDFHelper::get_com_name();?>&controller=feedback&search_product_id=<?php echo $row->id?>" target="_blank" class="jfbutton jfbutton_color_white jfbutton_size_small ">
			<span><?php echo WDFText::get('FEEDBACK'); ?></span>
		</a>
    </td>
</tr>
</tbody>
</table>
