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

$order_row = $this->order_row;


WDFDocument::set_title(WDFText::get('ORDER'));
?>

<div class="container">
<h1 class="wd_shop_header">
    <?php echo WDFText::get('ORDER'); ?>
</h1>

<div class="row">
<div class="col-sm-12">
    <h4 class="wd_shop_order_id">
        <?php echo WDFText::get('ORDER_ID') . ': ' . $order_row->id; ?>
    </h4>

    <!-- checkout date -->
    <p class="wd_shop_order_checkout_date">
        <small><?php echo WDFText::get('CHECKOUT_DATE') . ': ' . date($options->option_date_format, strtotime($order_row->checkout_date)); ?></small>
    </p>

    <div class="wd_divider"></div>

    <!-- products -->
    <?php
    for ($i = 0; $i < count($order_row->product_rows); $i++) {
        $order_product_row = $order_row->product_rows[$i];

        ?>
        <div class="row">
            <!-- image -->
            <div class="col-sm-3">
                <div class="wd_shop_order_product_image_container wd_center_wrapper">
                    <div>
                        <?php
                        if ($order_product_row->image != '') {
                            ?>
                            <img class="wd_shop_order_product_image"
                                 src="<?php echo $order_product_row->image; ?>">
                        <?php
                        } else {
                            ?>
                            <div class="wd_shop_order_product_no_image">
                                <span class="glyphicon glyphicon-picture"></span>
                                <br>
                                <span><?php echo WDFText::get('NO_IMAGE'); ?></span>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- details -->
            <div class="col-sm-6">
                <h4 class="wd_shop_order_product_name wd_shop_product_name text-left">
                    <!-- product name -->
                    <?php echo $order_product_row->name; ?>

                    <!-- product id -->
                    <small>
                        (<?php echo WDFText::get('PRODUCT_ID') . ': ' . $order_product_row->id; ?>)
                    </small>
                </h4>

                <!-- shipping method name -->
                <?php
                if ($order_product_row->enable_shipping == 1) {
                    ?>
                    <p class="wd_shop_order_product_shipping_method_name">
                        <?php echo WDFText::get('SHIPPING') . ': ' . $order_product_row->shipping_method_name; ?>
                    </p>
                <?php
                }
                ?>

                <!-- parameters -->
                <p class="wd_shop_order_product_parameters">
                    <?php echo WDFText::get('PARAMETERS') . ': ' . $order_product_row->parameters; ?>
                </p>
            </div>

            <div class="col-sm-3 text-right">
                <!-- price -->
                <p>
                    <span class="wd_shop_order_product_price_title wd_shop_product_price">
                        <?php echo WDFText::get('PRICE'); ?>:
                    </span>
                    <br>
                    <span class="wd_shop_order_product_price wd_shop_product_price">
                        <?php echo $order_product_row->price_text; ?>
                    </span>
                </p>

                <!-- tax price -->
                <p>
                    <span class="wd_shop_order_product_tax_price_title">
                        <?php echo WDFText::get('TAX'); ?>:
                    </span>
                    <br>
                    <span class="wd_shop_order_product_tax_price">
                        <?php echo $order_product_row->tax_price_text; ?>
                    </span>
                </p>

                <!-- shipping price -->
				
					<p>
						<span class="wd_shop_order_product_shipping_price_title">
							<?php echo WDFText::get('SHIPPING'); ?>:
						</span>
						<br>
						<span class="wd_shop_order_product_shipping_price">
							<?php echo $order_product_row->shipping_method_price_text; ?>
						</span>
					</p>
				
                <!-- count -->
                <p>
                        <span class="wd_shop_order_product_count">
                            <?php echo WDFText::get('QUANTITY') . ': ' . $order_product_row->count; ?>
                        </span>
                </p>
            </div>
        </div>

        <div class="wd_divider"></div>
    <?php
    }
    ?>
</div>
</div>
<div class="row">

	<div class="">
		<div class="">
			<div class="col-sm-6">
				<!-- billing info -->
				<h4 class="wd_shop_header_sm">
					<?php echo WDFText::get('BILLING_INFO'); ?>
				</h4>

				<dl class="wd_shop_order_product_shipiing_info_data dl-horizontal">
					<dt>
						<?php echo WDFText::get('FIRST_NAME'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_first_name); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('MIDDLE_NAME'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_middle_name); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('LAST_NAME'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_last_name); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('COMPANY'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_company); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('EMAIL'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_email); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('COUNTRY'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_country); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('STATE'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_state); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('CITY'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_city); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('ADDRESS'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_address); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('MOBILE'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_mobile); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('PHONE'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_phone); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('FAX'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_fax); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('ZIP_CODE'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->billing_data_zip_code); ?>
					</dd>
				</dl>		
			</div>
			<div class="col-sm-6">
				<!-- shipping info -->
				<h4 class="wd_shop_header_sm">
					<?php echo WDFText::get('SHIPPING_INFO'); ?>
				</h4>

				<dl class="wd_shop_order_product_shipiing_info_data dl-horizontal">
					<dt>
						<?php echo WDFText::get('FIRST_NAME'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_first_name); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('MIDDLE_NAME'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_middle_name); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('LAST_NAME'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_last_name); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('COMPANY'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_company); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('COUNTRY'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_country); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('STATE'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_state); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('CITY'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_city); ?>
					</dd>

					<dt>
						<?php echo WDFText::get('ADDRESS'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_address); ?>
					</dd>
					<dt>
						<?php echo WDFText::get('ZIP_CODE'); ?>:
					</dt>
					<dd>
						<?php echo str_replace("'","",$order_row->shipping_data_zip_code); ?>
					</dd>
				</dl>
			</div>
		</div>
	</div>

</div>

<div class="wd_divider"></div>
<div class="row">
    <!-- status -->
    <div class="col-sm-4">
        <span class="wd_shop_order_status_title">
            <?php echo WDFText::get('STATUS'); ?>:
        </span>
        <span class="wd_shop_order_status">
            <?php echo $order_row->status_name; ?>
        </span>
    </div>

    <div class="col-sm-8 text-right">
        <!-- price -->
        <span class="wd_shop_order_price_title wd_shop_product_price">
            <?php echo WDFText::get('TOTAL_PRICE'); ?>:
        </span>
        <span class="wd_shop_order_price wd_shop_product_price">
            <?php echo $order_row->total_price_text; ?>
        </span>
    </div>
</div>

<div class="wd_divider"></div>

<div class="row">
    <div class="col-sm-12 text-right">
        <a class="btn btn-primary" href="<?php echo JURI::base().'index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=printorder&order_id=' . $order_row->id .'&tmpl=component';?>" target="_blank"><?php echo WDFText::get('BTN_PRINT_ORDER') ?></a>
		<?php
			$where_query = array( " published ='1' AND name='ecommercewd_pdfinvoice'" );
			$tools = WDFTool::get_tools( $where_query );
			if(empty($tools) == false){
		?>
		     <a class="btn btn-primary" href="<?php echo JURI::base().'index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=pdfinvoice&order_id=' . $order_row->id .'&tmpl=component';?>" ><?php echo WDFText::get('PDFINVOICE') ?></a>
		<?php
		}
		?>        
		<a class="btn btn-default"
           onclick="wdShop_onBtnBackClick(event, this); return false;"><?php echo WDFText::get('BTN_BACK') ?></a>
    </div>
</div>
</div>