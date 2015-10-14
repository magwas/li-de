<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/layout_explore.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_explore.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');

$currencies_data = $this->currencies_data;
$paymnet_name = WDFInput::get('payment');

?>

<form name="adminForm" id="adminForm" action="" method="post">
<table class="adminlist table table-striped">
<thead>
<tr>
    <th colspan="2">
        <?php echo WDFText::get(strtoupper($paymnet_name)."_SUPPORTED_CURRENCIES"); ?>
    </th>
</tr>

<tr>
    <th class="col_key">
        <?php echo WDFText::get("CURRENCY"); ?>
    </th>
    <th class="col_value">
        <?php echo WDFText::get("CURRENCY_CODE"); ?>
    </th>
</tr>
</thead>

<tbody>
	<?php 
		$_currency_data = $currencies_data[$paymnet_name];
		$currencies = $_currency_data->currencies;
		foreach( $currencies as $currency_code => $currency_data){	
		$star = "";
		if($currency_data[2] == 1)
			$star = " *";
	?>
		<tr>
			<td class="col_key">
				<a onclick="insertCurrencyData('<?php echo $currency_data[0]; ?>', '<?php echo $currency_code; ?>', '<?php echo $currency_data[1]; ?>')">
				<?php echo $currency_data[0].$star; ?>
				</a>
			</td>
			<td class="col_value">
				<?php echo $currency_code; ?>
			</td>
		</tr>
	<?php 
		}
	?>
</tbody>

<tfoot>
<tr>
    <td colspan="2">
        <?php echo WDFText::get(strtoupper($paymnet_name).'_SUPPORTED_ACCOUNTS'); ?>
    </td>
</tr>
</tfoot>
</table>
</form>

<script>
    var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>