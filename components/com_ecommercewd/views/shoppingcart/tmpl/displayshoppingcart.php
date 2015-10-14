<?php
/**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;

$order_product_rows = $this->order_product_rows;
$total_price_text = $this->total_price_text;
WDFDocument::set_title(WDFText::get('SHOPPING_CART'));
?>

<div class="wd_shop_tooltip_container"></div>

<div class="container wd_shop_shopping_cart_container">
<h1 class="wd_shop_header">
    <?php echo WDFText::get('SHOPPING_CART'); ?>
</h1>

<?php
if (empty($order_product_rows) == false) {
    ?>
    <form name="wd_shop_main_form" action="" method="POST">
        <input type="hidden" name="order_product_id" value="">
    </form>

    <form name="wd_shop_form_products" action="" method="POST">
    <!-- products -->
    <div class="row">
    <?php
    for ($i = 0; $i < count($order_product_rows); $i++) {
        $order_product_row = $order_product_rows[$i];
        $id = $order_product_row->id;
        if ($order_product_row->product_image != '') {
            $el_order_product_image = '<img class="wd_shop_order_product_image" src="' . $order_product_row->product_image . '">';
        } else {
            $el_order_product_image = '
                    <div class="wd_shop_order_product_no_image">
                        <span class="glyphicon glyphicon-picture"></span>
                        <br>
                        <span>' . WDFText::get('NO_IMAGE') . '</span>
                    </div>
                    ';
        }
        ?>
        <div class="wd_shop_order_product_container col-sm-12"
             order_product_id="<?php echo $order_product_row->id; ?>">
        <div class="wd_shop_panel_product panel panel-default">
        <div class="panel-body">
            <div class="row">
                <!-- image -->
                <div class="col-sm-3">
                    <div class="row">
                        <div
                            class="wd_shop_order_product_image_container wd_center_wrapper col-sm-12">
                            <div>
                                <?php echo $el_order_product_image; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- details -->
                <div class="col-sm-6">
                    <div class="row">
                        <!-- name -->
                        <div class="col-sm-12">
                            <a href="<?php echo $order_product_row->product_url; ?>"
                               class="wd_shop_order_product_name wd_shop_product_name btn btn-link">
                                <?php echo $order_product_row->product_name; ?>
                            </a>
                        </div>

                        <div class="col-sm-12">
                            <!-- parameters -->
                            <dl class="wd_shop_order_product_list_parameters dl-horizontal">
                                <?php
                                for ($j = 0; $j < count($order_product_row->product_parameter_datas); $j++) {
                                    $product_parameter_data = $order_product_row->product_parameter_datas[$j];
                                    $name = $product_parameter_data->name;
                                    $name_ = str_replace(' ', '_', $product_parameter_data->name);
                                    $type_id = $product_parameter_data->type_id;
                                    $values_list = $product_parameter_data->values;
                                    $value = $product_parameter_data->value;

                                    ?>
                                    <dt>
                                    <p class="wd_shop_order_product_parameter_name">
                                        <?php echo $product_parameter_data->name; ?>
                                    </p>
                                    </dt>

                                    <dd class="wd_shop_order_product_parameter"
                                        type_id='<?php echo $type_id;?>'
                                        parameter_id='<?php echo $product_parameter_data->id;?>'>
                                        <?php
                                        switch ($type_id) {
                                            // Input field
                                            case 2:
                                                ?>
                                                <input type="text" name="parameter_value" id="<?php echo 'input_' . $id;?>"
                                                       class=" wd_shop_parameter_input form-control wd-input-xs"
                                                       value="<?php echo $product_parameter_data->value; ?>"
                                                       onchange="wdShop_onProductParameterChange(event, this)">
                                                <?php
                                                break;
                                            // Select
                                            case 3:
                                                $default_value = array();
                                                $default_value['value'] = 0;
                                                $default_value['price'] = '';
                                                $default_value['text'] = '- Select -';
                                                $default_value['type_id'] = 0;
                                                array_unshift($values_list, $default_value);
//
                                                ?>
                                                <select id="wd_shop_selectable_parameter_<?php echo $name_  . '_' . $id; ?>"
                                                        name="<?php echo $name_ . '_' . $id; ?> "
                                                        onchange="wdShop_onProductParameterChange(event, this)"
                                                        class=" wd_shop_parameter_select form-control wd-input-xs">
                                                    <?php
                                                    foreach ($values_list as $value_list) {
                                                        ?>
                                                        <option
                                                            data-paramater-price="<?php echo $value_list['price'];?>"
                                                            value="<?php echo $value_list['value'] ?>"
                                                            <?php echo ($value_list['value'] == $value) ? 'Selected="selected"' : '';?>">
                                                            <?php echo $value_list['text']; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                                break;
                                            // Radio
                                            case 4:
//                                                var_dump($values_list);
                                                foreach ($values_list as $value_list) {
                                                    ?>
                                                    <input type="radio"
                                                           id="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value'] . '_' . $id; ?>"
                                                           name="<?php echo $name_ . '_' . $id; ?>"
                                                           value="<?php echo $value_list['value'] ?>"
                                                           onchange="wdShop_onProductParameterChange(event, this)"
                                                           data-paramater-price="<?php echo $value_list['price'];?>"
                                                           class="   parameters_input wd_shop_parameter_radio"
                                                           <?php echo ($value_list['value'] == $value) ? 'checked="checked"' : '';?>">
                                                <label
                                                    for="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']   . '_' . $id; ?>"
                                                    id="wd_shop_checkbox_parameter_<?php echo $name_; ?>"
                                                    class="parameters_label">
                                                    <?php echo $value_list['text'] ?>
                                                </label>

                                            <?php
                                            }
                                                break;
                                            // Checkbox
                                            case 5:
                                                foreach ($values_list as $value_list) {
                                                    ?>
                                                    <input type="checkbox"
                                                           id="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value'] . '_' . $id; ?>"
                                                           name="<?php echo $name_ . '_' . $id; ?>"
                                                           value="<?php echo $value_list['value'] ?>"
                                                           data-paramater-price="<?php echo $value_list['price'];?>"
                                                           onchange="wdShop_onProductParameterChange(event, this)"
                                                           class=" parameters_input wd_shop_parameter_checkbox"
                                                           <?php
                                                            if (gettype($value) != 'string') {
                                                                echo in_array($value_list['value'], $value) ? 'checked="checked"' : '';
                                                            }
                                                ?>"
                                                    >
                                                    <label
                                                        for="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']  . '_' . $id; ?>"
                                                        id="label_<?php echo $name_; ?>"
                                                        class="parameters_label">
                                                        <?php echo $value_list['text'] ?>
                                                    </label>
                                                <?php
                                                }
                                                break;
                                        }?>
                                    </dd>
                                <?php
                                }
                                ?>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 text-right">
                    <!-- price -->
                    <p>
                                    <span>
                                        <span class="wd_shop_order_product_final_price wd_shop_product_price"
                                              orderProductId="<?php echo $order_product_row->id; ?>"><?php echo $order_product_row->product_final_price_text; ?></span>
                                        <span
                                            class="wd_shop_order_product_final_price_info glyphicon glyphicon-info-sign"
                                            title="<?php echo $order_product_row->product_final_price_info; ?>"></span>
                                    </span>
                    </p>

                    <!-- count -->
                    <p>
                        <label for="count">
                                        <span class="wd_shop_order_product_quantity_title">
                                            <?php echo WDFText::get("QUANTITY"); ?>:
                                        </span>

                            <input type="number"
                                   class="wd_shop_order_product_quantity form-control wd-input-xs"
                                   onfocus="wdShop_onProductCountFocus(event, this);"
                                   onkeydown="return wdShop_disableEnterKey(event);"
                                   onblur="wdShop_onProductCountBlur(event, this);"
                                   value="<?php echo $order_product_row->product_count; ?>" min="1">
                        </label>
                        <br>
                        <small class="wd_shop_order_product_available <?php echo $order_product_row->stock_class; ?>">
                            <?php echo $order_product_row->product_availability_msg; ?>
                        </small>
                    </p>

                    <!-- subtotal -->
                    <p>
                                    <span class="wd_shop_order_product_subtotal_title wd_shop_product_price">
                                        <?php echo WDFText::get('SUBTOTAL'); ?>:
                                    </span>
                                    <span class="wd_shop_order_product_subtotal wd_shop_product_price"
                                          productId="<?php echo $order_product_row->product_id; ?>">
                                        <?php echo $order_product_row->subtotal_text; ?>
                                    </span>
                    </p>
                </div>
            </div>

            <!-- loading and alerts -->
            <div class="row">
                <div class="wd_shop_loading_clip_container wd_hidden col-sm-12 text-right">
                    <span><?php echo WDFText::get('MSG_UPDATING'); ?></span>

                    <div class="wd_loading_clip_small"></div>
                </div>

                <div class="wd_shop_alert_failed_to_update_container wd_hidden col-sm-12">
                    <div class="alert alert-danger">
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <div class="wd_shop_order_product_ctrls">
                        <?php
                        if (($options->checkout_enable_checkout == 1) && ($order_product_row->product_available == true)) {
                            ?>
                            <a class="btn btn-link btn-sm"
                               onclick="wdShop_onBtnCheckoutProductClick(event, this); return false;">
                                <?php echo WDFText::get('BTN_CHECKOUT_THIS_ITEM'); ?>
                            </a>
                        <?php
                        }
                        ?>

                        <a class="btn btn-link btn-sm"
                           onclick="wdShop_onBtnRemoveProductClick(event, this); return false;">
                            <?php echo WDFText::get('BTN_REMOVE_THIS_ITEM'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    <?php
    }
    ?>
    </div>

    <div class="wd_divider"></div>

    <!-- total -->
    <div class="row">
        <div class="col-sm-12 text-right">
                <span class="wd_shop_total_title wd_shop_product_price">
                    <?php echo WDFText::get('TOTAL_PRICE'); ?>:
                </span>
                <span class="wd_shop_total wd_shop_product_price">
                    <?php echo $total_price_text; ?>
                </span>
        </div>
    </div>

    <div class="wd_divider"></div>

    <!-- ctrls -->
    <div class="row">
        <div class="col-sm-12 text-right">
            <a class="btn btn-default btn-sm"
               data-toggle="tooltip"
               onclick="wdShop_onBtnRemoveAllProductsClick(event, this); return false;">
                <?php echo WDFText::get('BTN_REMOVE_ALL'); ?>
            </a>

            <?php
            if ($options->checkout_enable_checkout == 1) {
                ?>
                <a class="btn btn-primary btn-sm"
                   onclick="wdShop_onBtnCheckoutAllProductsClick(event, this); return false;">
                    <?php echo WDFText::get('BTN_CHECKOUT_ALL'); ?>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
    </form>
<?php
} else {
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <?php echo WDFText::get('MSG_YOUR_CART_IS_EMPTY') ?>
            </div>
        </div>
    </div>
<?php
}
?>
</div>

<script>
    var WD_SHOP_TEXT_PLEASE_WAIT = "<?php echo WDFText::get('MSG_PLEASE_WAIT'); ?>";

    var wdShop_urlUpdateOrderProduct = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=ajax_update_order_product_data'; ?>";
    var wdShop_urlRemoveOrderProduct = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=ajax_remove_order_product'; ?>";
    var wdShop_urlRemoveAllOrderProducts = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=ajax_remove_all_order_products'; ?>";
    var wdShop_urlCheckoutOrderProduct = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=checkout_product'; ?>";
    var wdShop_urlCheckoutAllOrderProducts = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=checkout_all_products'; ?>";
    var wdShop_urlDisplayShoppingCart = "<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart'); ?>";

    <?php
    $product_parameters_array = array();
    $product_prices_array = array();
    $products_data = array();

    for ($i = 0; $i < count($order_product_rows); $i++) {
        $product_parameter_datas = $order_product_rows[$i]->product_parameter_datas;

        $parameters_array = array();
        for ($j = 0; $j < count($product_parameter_datas); $j++) {
            $parameters_data = $product_parameter_datas[$j];
            if($parameters_data->type_id != 1) {
                $param_price = 0;

                switch($parameters_data->type_id ) {
                    case 3:
                    case 4:
                        for($k = 0; $k < count($parameters_data->values); $k++) {
                        $values = $parameters_data->values[$k];
                            if($values['value'] == $parameters_data->value) {
                                $sign = substr($values['price'], 0, 1);
                                $price = substr($values['price'], 1, strlen($values['price']));
                                if($price){
                                    if($sign == '+') {
                                        $param_price = $param_price + $price;
                                    } else {
                                        $param_price = $param_price - $price;
                                    }
                                }
                            }
                        }
                        break;
                    case 5:
                        for($k = 0; $k < count($parameters_data->values); $k++) {
                        $values = $parameters_data->values[$k];
                            if(gettype($parameters_data->value) != 'string') {
                                if(in_array($values['value'], $parameters_data->value)) {
                                    $sign = substr($values['price'], 0, 1);
                                    $price = substr($values['price'], 1, strlen($values['price']));
                                    if($price){
                                        if($sign == '+') {
                                            $param_price = $param_price + $price;
                                        } else {
                                            $param_price = $param_price - $price;
                                        }
                                    }
                                }
                            }
                        }
                        break;

                }
                if($param_price > 0){
                    $param_price = '+' . $param_price;
                } else if( $param_price == 0){
                    $param_price = '+';
                } else {
                    $param_price = (string)$param_price;
                }

                $parameters_array[$parameters_data->name] = $param_price;
            }
                $product_parameters_array[$order_product_rows[$i]->id] =  $parameters_array;
        }
        $product_data = array();
        $product_data['quantity'] = $order_product_rows[$i]->product_count;
        $product_data['price'] = $order_product_rows[$i]->product_final_price;
        $product_data['final_price_info'] = $order_product_rows[$i]->product_final_price_info;
        $products_data[$order_product_rows[$i]->id] = $product_data;

    }

    $product_parameters_array_json =  json_encode($product_parameters_array);
    $products_data_json = json_encode($products_data);
    ?>

    var product_parameters_price = JSON.parse("<?php echo addslashes($product_parameters_array_json);?>");
    var products_data = JSON.parse("<?php echo addslashes($products_data_json);?>");
	var decimals = "<?php echo $options->option_show_decimals == 1 ? 2 : 0; ?>";
</script>
