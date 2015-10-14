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

        <!-- thumb -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('THUMBNAIL'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo WDFHTML::jf_thumb_box('thumb_box'); ?>
                <input type="hidden"
                       name="thumb"
                       id="thumb"
                       value=""/>
            </td>
        </tr>

        <!-- position -->
        <tr class="col_key_tr">
            <td class="col_key">
                <label><?php echo WDFText::get('POSITION'); ?>:</label>
            </td>
            <td class="col_value">
                <?php
                $position_0_checked = $row->thumb_position == 0 ? 'checked="checked"' : '';
                $position_1_checked = $row->thumb_position == 1 ? 'checked="checked"' : '';
                $position_2_checked = $row->thumb_position == 2 ? 'checked="checked"' : '';
                $position_3_checked = $row->thumb_position == 3 ? 'checked="checked"' : '';
                ?>
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <label for="thumb_position_0"><?php echo WDFText::get('TOP_LEFT'); ?></label>
                        </td>

                        <td>
                            <input type="radio"
                                   name="thumb_position"
                                   id="thumb_position_0"
                                   value="0"
                                <?php echo $position_0_checked; ?>>
                        </td>

                        <td>
                            <input type="radio"
                                   name="thumb_position"
                                   id="thumb_position_1"
                                   value="1"
                                <?php echo $position_1_checked; ?>>
                        </td>

                        <td>
                            <label for="thumb_position_1"><?php echo WDFText::get('TOP_RIGHT'); ?></label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="thumb_position_2"><?php echo WDFText::get('BOTTOM_LEFT'); ?></label>
                        </td>

                        <td>
                            <input type="radio"
                                   name="thumb_position"
                                   id="thumb_position_2"
                                   value="2"
                                <?php echo $position_2_checked; ?>>
                        </td>

                        <td>
                            <input type="radio"
                                   name="thumb_position"
                                   id="thumb_position_3"
                                   value="3"
                                <?php echo $position_3_checked; ?>>
                        </td>

                        <td>
                            <label for="thumb_position_3"><?php echo WDFText::get('BOTTOM_RIGHT'); ?></label>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
        <tbody>
    </table>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>

<script>
    var _thumbUrls = JSON.parse("<?php echo addslashes(stripslashes($row->thumb)); ?>");
	var _url_root = "<?php echo JURI::root() ; ?>";
</script>