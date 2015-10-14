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
WDFHelper::add_css('css/sub_toolbar_icons.css');
WDFHelper::add_css('css/layout_edit.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');

// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_edit.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');

WDFHelper::add_script('js/' . WDFInput::get_controller() . '/src/jquery.flot.min.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/src/jquery.flot.pie.min.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/src/jquery.flot.resize.min.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/src/jquery.flot.stack.min.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/src/jquery.flot.time.min.js');

$report_data  = $this->report_data;
$decimals = $this->decimals;
$default_currency = $this->row_default_currency;
EcommercewdSubToolbar::build();
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <?php
	if(WDFHelper::is_j3() == true){
		WDFHTMLTabs::startTabs('reports', WDFInput::get('tab_index'), 'onTabActivated');

		WDFHTMLTabs::startTab('year', WDFText::get('YEAR'));
		WDFHTMLTabs::endTab();

		WDFHTMLTabs::startTab('last_month', WDFText::get('LAST_MONTH'));
		WDFHTMLTabs::endTab();

		WDFHTMLTabs::startTab('this_month', WDFText::get('THIS_MONTH'));
		WDFHTMLTabs::endTab();

		WDFHTMLTabs::startTab('last_week', WDFText::get('LAST_WEEK'));
		WDFHTMLTabs::endTab();

		WDFHTMLTabs::startTab('custom', WDFText::get('CUSTOM'));
		WDFHTMLTabs::endTab();

		WDFHTMLTabs::endTabs();

		echo JHtml::_('tabs.end');
	}
	else{
	?>
	<dl class="tabs" id="tab_group_reports">
		<dt class="year <?php if(WDFInput::get('tab_index','year') == 'year') echo 'open';?>"><a href="#year" data-toggle="tab" onclick="onTabActivated('year')"><?php echo WDFText::get('YEAR')?></a></dt>
		<dt class="last_month <?php if(WDFInput::get('tab_index','year') == 'last_month') echo 'open';?>"><a href="#last_month" data-toggle="tab" onclick="onTabActivated('last_month')"><?php echo WDFText::get('LAST_MONTH')?></a></dt>
		<dt class="this_month <?php if(WDFInput::get('tab_index','year') == 'this_month') echo 'open';?>"><a href="#this_month" data-toggle="tab" onclick="onTabActivated('this_month')"><?php echo WDFText::get('THIS_MONTH')?></a></dt>
		<dt class="last_week <?php if(WDFInput::get('tab_index','year') == 'last_week') echo 'open';?>"><a href="#last_week" data-toggle="tab" onclick="onTabActivated('last_week')"><?php echo WDFText::get('LAST_WEEK')?></a></dt>
		<dt class="custom <?php if(WDFInput::get('tab_index','year') == 'custom') echo 'open';?>"><a href="#custom" data-toggle="tab" onclick="onTabActivated('custom')"><?php echo WDFText::get('CUSTOM')?></a></dt>
	</dl>
	<?php
	}

	if(WDFInput::get('tab_index') == "custom"){?>
		<div class="date-range">
			<table class="adminlist table-striped search_table" width="50%">
				<tbody>
					<tr>
						<td><label for="start_date"><?php echo WDFText::get('DATE_FROM'); ?>:</label></td>
						<td><?php echo @JHTML::_('calendar', WDFInput::get("start_date"), 'start_date','start_date','%Y-%m-%d','size="10" class="inputbox"');?></td>
						<td><label for="start_date"><?php echo WDFText::get('DATE_TO'); ?>:</label></td>
						<td><?php echo @JHTML::_('calendar', WDFInput::get("end_date"), 'end_date','end_date','%Y-%m-%d','size="10" class="inputbox"');?></td>
						<td><?php echo WDFHTML::jfbutton(WDFText::get('BTN_SEARCH'), '', '', 'onclick="onTabActivated(\'custom\');"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?></td>
						<td><?php echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="document.getElementById(\'start_date\').value=\'\';document.getElementById(\'end_date\').value=\'\';onTabActivated(\'custom\');"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php 
	}
	
	
	if($default_currency !== NULL){
	?>
	<div class="report-wrapper current">
		<div class="reports">
			<?php if( $report_data->start_date || $report_data->end_date ){	?>

			<table class="adminlist table report" >
				<tbody>
					<!-- sales in this period -->
					<tr class="wd_reports_row">
						<td width="1%" class="type type-color-sales">
						</td>
						<td  width="2%">
							<input type="checkbox" checked="checked" id="total_seals" class="wd-chart" value="total_seals" onclick="wd_ShopGetCharts();" />
						</td>
						<td class="col_key">
							<label  for="total_seals">
								<?php echo WDFText::get('SALES_IN_THIS_PERIOD'); ?>:
							</label>
						</td>
						<td class="col_value">
							<?php echo number_format($report_data->total_seals, $decimals)." ".$default_currency->code; ?>
						</td>

					</tr>
					<!-- average monthly sales -->
					<tr class="wd_reports_row">
						<td width="1%" class="type type-color-average">
						</td>					
						<td  width="2%">
							<input type="checkbox" checked="checked" id="average_sales" class="wd-chart" value="average_sales" onclick="wd_ShopGetCharts();" />
						</td>					
						<td class="col_key">
							<label for="average_sales">
								<?php echo $report_data->average_type == "monthly" ? WDFText::get('AVERAGE_MONTHLY_SALES') : WDFText::get('AVERAGE_DAILY_SALES'); ?>:
							</label>
						</td>
						<td class="col_value">
							<?php echo number_format($report_data->average_sales, $decimals)." ".$default_currency->code; ?>
						</td>					
					</tr>
					<!-- orders placed -->
					<tr class="wd_reports_row">
						<td width="1%" class="type type-color-orders">
						</td>					
						<td  width="2%">
							<input type="checkbox" checked="checked" id="orders_count" class="wd-chart" value="orders_count" onclick="wd_ShopGetCharts();" />
						</td>					
						<td class="col_key">
							<label for="orders_count">
								<?php echo WDFText::get('ORDERS_PLACED'); ?>:
							</label>
						</td>
						<td class="col_value">
							<?php echo $report_data->orders_count; ?>
						</td>
					
					</tr>	
					<!-- items purchased -->
					<tr class="wd_reports_row">
						<td width="1%" class="type type-color-items">
						</td>					
						<td  width="2%">
							<input type="checkbox" checked="checked" class="wd-chart" id="items_count" value="items_count" onclick="wd_ShopGetCharts();" />
						</td>					
						<td class="col_key">
							<label for="items_count" >
								<?php echo WDFText::get('ITEMS_PURCHASED'); ?>:
							</label>
						</td>
						<td class="col_value">
							<?php echo $report_data->items_count; ?>
						</td>					
					</tr>
					<!-- charged for shipping -->
					<tr class="wd_reports_row">
						<td width="1%" class="type type-color-shipping">
						</td>						
						<td  width="2%">
							<input type="checkbox" checked="checked" class="wd-chart" id="total_shipping_seals" value="total_shipping_seals" onclick="wd_ShopGetCharts();" />
						</td>					
						<td class="col_key">
							<label for="total_shipping_seals">
								<?php echo WDFText::get('CHARGED_FOR_SHIPPING'); ?>:
							</label>
						</td>
						<td class="col_value">
							<?php echo number_format($report_data->total_shipping_seals, $decimals)." ".$default_currency->code; ?>
						</td>				
					</tr>				
				
				</tbody>
			</table>
		<?php 
			}
		?>
		</div>
		<div id="placeholder_wrapper">
			<div id="placeholder" class="chart-placeholder main"></div>
		</div>
	</div>

	<script type="text/javascript">
		var report_data = jQuery.parseJSON('<?php echo $report_data->json_data;?>') ;
		var default_currency_code = '<?php echo $default_currency->code;?>';
		var wdShop_urlCheckChart = '<?php echo JURI::base().'index.php?option=com_ecommercewd&controller=reports&task=select_chart';?>';
		var wdShop_totalSales = <?php echo (float)$report_data->total_seals ? $report_data->total_seals : 0; ?>;
		var wdShop_itemsCount = <?php echo (int)$report_data->items_count ? $report_data->items_count : 0; ?>;
		
		wd_Shop_drawReportChart();
	</script>
	
	<?php
	}
	else{
		echo  WDFText::get('NO_REPORTS');
	}
	?>
	<script>var wdShop_isJ3 = <?php echo WDFHelper::is_j3() ? 1 : 0; ?>;</script>
    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>"/>
</form>

