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
?>

<form name="adminForm" id="adminForm" action="" method="post">
<table class="adminlist table table-striped">
<thead>
<tr>
    <th colspan="2">
        <?php echo WDFText::get("PAYPAL_SUPPORTED_CURRENCIES"); ?>
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
<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Australian Dollar', 'AUD', '&#36;')">Australian Dollar</a>
    </td>
    <td class="col_value">
        AUD
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Brazilian Real', 'BRL', '&#82;&#36;')">Brazilian Real *</a>
    </td>
    <td class="col_value">
        BRL
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Canadian Dollar', 'CAD', '&#36;')">Canadian Dollar</a>
    </td>
    <td class="col_value">
        CAD
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Czech Koruna', 'CZK', '&#75;&#269;')">Czech Koruna</a>
    </td>
    <td class="col_value">
        CZK
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Danish Krone', 'DKK', '&#107;&#114;')">Danish Krone</a>
    </td>
    <td class="col_value">
        DKK
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Euro', 'EUR', '&#8364;')">Euro</a>
    </td>
    <td class="col_value">
        EUR
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Hong Kong Dollar', 'HKD', '&#36;')">Hong Kong Dollar</a>
    </td>
    <td class="col_value">
        HKD
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Hungarian Forint', 'HUF', '&#70;&#116;')">Hungarian Forint</a>
    </td>
    <td class="col_value">
        HUF
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Israeli New Sheqel', 'ILS', '&#8362;')">Israeli New Sheqel</a>
    </td>
    <td class="col_value">
        ILS
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Japanese Yen', 'JPY', '&#165;')">Japanese Yen</a>
    </td>
    <td class="col_value">
        JPY
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Malaysian Ringgit', 'MYR', '&#82;&#77;')">Malaysian Ringgit *</a>
    </td>
    <td class="col_value">
        MYR
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Mexican Peso', 'MXN', '&#36;')">Mexican Peso</a>
    </td>
    <td class="col_value">
        MXN
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Norwegian Krone', 'NOK', '&#107;&#114;')">Norwegian Krone</a>
    </td>
    <td class="col_value">
        NOK
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('New Zealand Dollar', 'NZD', '&#36;')">New Zealand Dollar</a>
    </td>
    <td class="col_value">
        NZD
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Philippine Peso', 'PHP', '&#8369;')">Philippine Peso</a>
    </td>
    <td class="col_value">
        PHP
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Polish Zloty', 'PLN', '&#122;&#322;')">Polish Zloty</a>
    </td>
    <td class="col_value">
        PLN
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Pound Sterling', 'GBP', '&#163;')">Pound Sterling</a>
    </td>
    <td class="col_value">
        GBP
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Russian Ruble', 'RUB', '&#1088;&#1091;&#1073;')">Russian Ruble</a>
    </td>
    <td class="col_value">
        RUB
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Singapore Dollar', 'SGD', '&#36;')">Singapore Dollar</a>
    </td>
    <td class="col_value">
        SGD
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Swedish Krona', 'SEK', '&#107;&#114;')">Swedish Krona</a>
    </td>
    <td class="col_value">
        SEK
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Swiss Franc', 'CHF', '&#67;&#72;&#70;')">Swiss Franc</a>
    </td>
    <td class="col_value">
        CHF
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Taiwan New Dollar', 'TWD', '&#78;&#84;&#36;')">Taiwan New Dollar</a>
    </td>
    <td class="col_value">
        TWD
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Thai Baht', 'THB', '&#3647;')">Thai Baht</a>
    </td>
    <td class="col_value">
        THB
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('Turkish Lira', 'TRY', '&#8356;')">Turkish Lira *</a>
    </td>
    <td class="col_value">
        TRY
    </td>
</tr>

<tr>
    <td class="col_key">
        <a onclick="insertCurrencyData('U.S. Dollar', 'USD', '&#36;')">U.S. Dollar</a>
    </td>
    <td class="col_value">
        USD
    </td>
</tr>
</tbody>

<tfoot>
<tr>
    <td colspan="2">
        <?php echo WDFText::get('PAYPAL_SUPPORTED_ACCOUNTS'); ?>
    </td>
</tr>
</tfoot>
</table>
</form>

<script>
    var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>