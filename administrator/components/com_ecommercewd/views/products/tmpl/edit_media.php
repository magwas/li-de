<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


$row_default_currency = $this->default_currency_row;
$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );

?>

<table class="adminlist table">

<tbody>
<!-- images -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('IMAGES'); ?>:</label>
    </td>
    <td class="col_value wd_shop_product_images">
        <?php echo WDFHTML::jf_thumb_box('thumb_box_images', true); ?>
        <input type="hidden" name="images" id="images" value='<?php echo $row->images; ?>'/>		
    </td>
</tr>

<!-- videos -->
<tr>
    <td class="col_key">
        <label><?php echo WDFText::get('VIDEOS'); ?>:</label>
    </td>
    <td class="col_value">
        <?php echo WDFHTML::jf_thumb_box('thumb_box_videos', true, 'videos'); ?>
        <input type="hidden" name="videos" id="videos" value='<?php echo $row->videos; ?>'/>		
    </td>
</tr>
</tbody>

</table>


