<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$order_data = $this->order_data;
$rows = $this->rows;
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table table-striped">
        <thead>
        <tr>
            <th class="col_num">
                #
            </th>

            <th class="col_product_name">
                <?php echo WDFText::get('PRODUCT_NAME'); ?>
            </th>

            <th class="col_product_image">
                <?php echo WDFText::get('PRODUCT_IMAGE'); ?>
            </th>

            <th class="col_parameters">
                <?php echo WDFText::get('PARAMETERS'); ?>
            </th>

            <th class="col_price">
                <?php echo WDFText::get('PRICE'); ?>
                <br>
                <?php echo $order_data->currency_code; ?>
            </th>

            <th class="col_tax">
                <?php echo WDFText::get('TAX'); ?>
                <br>
                <?php echo $order_data->currency_code; ?>
            </th>

            <th class="col_shipping">
                <?php echo WDFText::get('SHIPPING'); ?>
                <br>
                <?php echo $order_data->currency_code; ?>
            </th>

            <th class="col_count">
                <?php echo WDFText::get('COUNT'); ?>
            </th>

            <th class="col_subtotal">
                <?php echo WDFText::get('SUBTOTAL'); ?>
                <br>
                <?php echo $order_data->currency_code; ?>
            </th>

            <th class="col_btns">
            </th>
        </tr>
        </thead>

        <tbody>
        <?php
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            ?>
            <tr class="row<?php echo $i % 2; ?>" item_id="<?php echo $row->id; ?>">
                <td class="col_num">
                    <?php echo $i + 1; ?>
                </td>

                <td class="col_product_name">
                    <input type="text"
                           name="product_name_<?php echo $row->id; ?>"
                           value="<?php echo $row->product_name; ?>">
                </td>

                <td class="col_product_image">
                    <?php
                    if ($row->product_image != '') {
                        ?>
                        <img class="order_product_image" src="<?php echo JURI::root().$row->product_image; ?>">
                    <?php
                    }
                    ?>
                </td>

                <td class="col_parameters">
                    <textarea
                        name="product_parameters_<?php echo $row->id; ?>"><?php echo $row->product_parameters; ?></textarea>
                </td>

                <td class="col_price">
                    <input type="text"
                           name="product_price_<?php echo $row->id; ?>"
                           value="<?php echo $row->product_price; ?>">
                </td>

                <td class="col_tax">
                    <?php echo $row->tax_name; ?>
                    <input type="text"
                           name="tax_price_<?php echo $row->id; ?>"
                           value="<?php echo $row->tax_price; ?>">
                </td>

                <td class="col_shipping">
                    <?php echo $row->shipping_method_name; ?>
                    <input type="text"
                           name="shipping_method_price_<?php echo $row->id; ?>"
                           value="<?php echo $row->shipping_method_price; ?>">
                </td>

                <td class="col_count">
                    <input type="text"
                           name="product_count_<?php echo $row->id; ?>"
                           value="<?php echo $row->product_count; ?>">
                </td>

                <td class="col_subtotal">
                    <span><?php echo $row->subtotal ?></span>
                </td>

                <td class="col_btns">
                    <?php echo WDFHTML::jfbutton(WDFText::get('BTN_DELETE'), '', '', 'onclick="onBtnDeleteProductClick(event, this);"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                    <?php echo WDFHTML::jfbutton(WDFText::get('BTN_UPDATE'), '', '', 'onclick="onBtnUpdateProductClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>

        <tbody>
        <tr>
            <td class="col_ctrls" colspan="10">
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_CLOSE'), '', 'btn_close', 'onclick="onBtnCloseClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_MEDIUM); ?>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="order_id" value="<?php echo WDFInput::get('order_id'); ?>">
    <input type="hidden" name="callback" value="<?php echo WDFInput::get('callback'); ?>">
    <input type="hidden" name="id" value="">
    <input type="hidden" name="product_name" value="">
    <input type="hidden" name="product_parameters" value="">
    <input type="hidden" name="product_price" value="">
    <input type="hidden" name="product_count" value="">
    <input type="hidden" name="tax_price" value="">
    <input type="hidden" name="shipping_method_price" value="">
</form>

<script>
    var MSG_DELETE_CONFIRM_SINGLE = "<?php echo WDFText::get('MSG_DELETE_CONFIRM_SINGLE'); ?>";

    var _orderDataJson = "<?php echo addslashes(stripslashes(WDFJson::encode($order_data, 256))); ?>";

    var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>