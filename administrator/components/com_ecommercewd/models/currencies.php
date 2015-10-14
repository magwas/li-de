<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelCurrencies extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
	public function get_currencies_data(){	
		$published_payments = WDFDb::get_rows('payments',array('published = "1" '));
		$supported_currencies = $this->get_payment_supported_currencies();
		$currencies_data = array();
		foreach ($published_payments as $published_payment){
			if(isset($supported_currencies[$published_payment->base_name]) == true){
				$currency_data = new Stdclass;
				$currency_data->text = WDFText::get('BTN_'.strtoupper($published_payment->base_name).'_SUPPORTED_CURRENCIES');				
				$currency_data->currencies = $supported_currencies[$published_payment->base_name];
				$currency_data->payment_name = $published_payment->base_name;
				$currencies_data[$published_payment->base_name] = $currency_data;
			}
		}
				
		return $currencies_data;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function init_rows_filters() {
        $filter_items = array();

        // name
        $filter_item = new stdClass();
        $filter_item->type = 'string';
        $filter_item->name = 'name';
        $filter_item->default_value = null;
        $filter_item->operator = 'like';
        $filter_item->input_type = 'text';
        $filter_item->input_label = WDFText::get('NAME');
        $filter_item->input_name = 'search_name';
        $filter_items[$filter_item->name] = $filter_item;

        $this->rows_filter_items = $filter_items;

        parent::init_rows_filters();
    }
	
	protected function get_payment_supported_currencies(){
		$payments_supported_currencies = array();
		
		$authorizenet = array();
		$authorizenet["USD"] = array("United States Dollar","&#36;",0);
		$authorizenet["CAD"] = array("Canadian Dollar","&#36;",0);
		$authorizenet["GBP"] = array("British Pounds","&#163;",0);
		$authorizenet["EUR"] = array("Euro","&#8364;",0);
		$authorizenet["AUD"] = array("Australian Dollar","&#36;",0);
		$authorizenet["NZD"] = array("New Zealand Dollar","&#36;",0);
		
		$payments_supported_currencies['authorizenet'] = $authorizenet;
		
		$stripe = array();
		$stripe["AED"] = array("United Arab Emirates Dirham","AED",0);
		$stripe["AFN"] = array("Afghan Afghani","AFN",1);
		$stripe["ALL"] = array("Albanian Lek","ALL",0);
		$stripe["AMD"] = array("Armenian Dram","AMD",0);
		$stripe["ANG"] = array("Netherlands Antillean Gulden","ANG",0);
		$stripe["AOA"] = array("Angolan Kwanza","AOA",1);
		$stripe["ARS"] = array("Argentine Peso","ARS",1);
		$stripe["AUD"] = array("Australian Dollar","&#36;",0);
		$stripe["AWG"] = array("Aruban Florin","AWG",0);
		$stripe["AZN"] = array("Azerbaijani Manat","",0);
		$stripe["BAM"] = array("Bosnia & Herzegovina Convertible Mark","BAM",0);
		$stripe["BBD"] = array("Barbadian Dollar","BBD",0);
		$stripe["BDT"] = array("Bangladeshi Taka","BDT",0);
		$stripe["BGN"] = array("Bulgarian Lev","BGN",0);
		$stripe["BIF"] = array("Burundian Franc","BIF",0);
		$stripe["BMD"] = array("Bermudian Dollar","&#36;",0);
		$stripe["BND"] = array("Brunei Dollar","&#36;",0);
		$stripe["BOB"] = array("Bolivian Boliviano","BOB",1);
		$stripe["BRL"] = array("Brazilian Real","&#82;&#36;",1);
		$stripe["BSD"] = array("Bahamian Dollar","&#36;",0);
		$stripe["BWP"] = array("Botswana Pula","BWP",0);
		$stripe["BZD"] = array("Belize Dollar","&#36;",0);
		$stripe["CAD"] = array("Canadian Dollar","&#36;",0);
		$stripe["CDF"] = array("Congolese Franc","CDF",0);
		$stripe["CHF"] = array("Swiss Franc","&#67;&#72;&#70;",0);
		$stripe["CLP"] = array("Chilean Peso","CLP",1);
		$stripe["CNY"] = array("Chinese Renminbi Yuan","CNY",0);
		$stripe["COP"] = array("Colombian Peso","COP",1);
		$stripe["CRC"] = array("Costa Rican Colón","CRC",1);
		$stripe["CVE"] = array("Cape Verdean Escudo","CVE",1);
		$stripe["CZK"] = array("Czech Koruna","&#75;&#269;",1);
		$stripe["DJF"] = array("Djiboutian Franc","DJF",1);
		$stripe["DKK"] = array("Danish Krone","&#107;&#114;",0);
		$stripe["DOP"] = array("Dominican Peso","DOP",0);
		$stripe["DZD"] = array("Algerian Dinar","DZD",0);
		$stripe["EEK"] = array("Estonian Kroon","EEK",1);
		$stripe["EGP"] = array("Egyptian Pound","EGP",0);
		$stripe["ETB"] = array("Ethiopian Birr","ETB",0);
		$stripe["EUR"] = array("Euro","&#8364;",0);
		$stripe["FJD"] = array("Fijian Dollar","&#36;",0);
		$stripe["FKP"] = array("Falkland Islands Pound","FKP",1);
		$stripe["GBP"] = array("British Pound","GBP",0);
		$stripe["GEL"] = array("Georgian Lari","GEL",0);
		$stripe["GIP"] = array("Gibraltar Pound","GIP",0);
		$stripe["GMD"] = array("Gambian Dalasi","GMD",0);
		$stripe["GNF"] = array("Guinean Franc","GNF",1);
		$stripe["GTQ"] = array("Guatemalan Quetzal","GTQ",0);
		$stripe["GYD"] = array("Guyanese Dollar","&#36;",0);
		$stripe["HKD"] = array("Hong Kong Dollar","&#36;",0);
		$stripe["HNL"] = array("Honduran Lempira","HNL",1);
		$stripe["HRK"] = array("Croatian Kuna","HRK",0);
		$stripe["HTG"] = array("Haitian Gourde","HTG",0);
		$stripe["HUF"] = array("Hungarian Forint","&#70;&#116;",1);
		$stripe["IDR"] = array("Indonesian Rupiah","IDR",0);
		$stripe["ILS"] = array("Israeli New Sheqel","&#8362;",0);
		$stripe["INR"] = array("Indian Rupee","INR",1);
		$stripe["ISK"] = array("Icelandic Króna","ISK",0);
		$stripe["JMD"] = array("Jamaican Dollar","JMD",0);
		$stripe["JPY"] = array("Japanese Yen","JPY",0);
		$stripe["KES"] = array("Kenyan Shilling","KES",0);
		$stripe["KGS"] = array("Kyrgyzstani Som","KGS",0);
		$stripe["KHR"] = array("Cambodian Riel","KHR",0);
		$stripe["KMF"] = array("Comorian Franc","KMF",0);
		$stripe["KRW"] = array("South Korean Won","KRW",0);
		$stripe["KYD"] = array("Cayman Islands Dollar","KYD",0);
		$stripe["KZT"] = array("Kazakhstani Tenge","KZT",0);
		$stripe["LAK"] = array("Lao Kip","LAK",1);
		$stripe["LBP"] = array("Lebanese Pound","LBP",0);
		$stripe["LKR"] = array("Sri Lankan Rupee","LKR",0);
		$stripe["LRD"] = array("Liberian Dollar","&#36;",0);
		$stripe["LSL"] = array("Lesotho Loti","LSL",0);
		$stripe["LTL"] = array("Lithuanian Litas","LTL",0);
		$stripe["LVL"] = array("Latvian Lats","LVL",0);
		$stripe["MAD"] = array("Moroccan Dirham","MAD",0);
		$stripe["MDL"] = array("Moldovan Leu","MDL",0);
		$stripe["MGA"] = array("Malagasy Ariary","MGA",0);
		$stripe["MKD"] = array("Macedonian Denar","MKD",0);
		$stripe["MNT"] = array("Mongolian Tögrög","MNT",0);
		$stripe["MOP"] = array("Macanese Pataca","MOP",0);
		$stripe["MRO"] = array("Mauritanian Ouguiya","MRO",0);
		$stripe["MUR"] = array("Mauritian Rupee","MUR",1);
		$stripe["MVR"] = array("Maldivian Rufiyaa","MVR",0);
		$stripe["MWK"] = array("Malawian Kwacha","MWK",0);
		$stripe["MXN"] = array("Mexican Peso","MXN",1);
		$stripe["MYR"] = array("Malaysian Ringgit","MYR",0);
		$stripe["MZN"] = array("Mozambican Metical","MZN",0);
		$stripe["NAD"] = array("Namibian Dollar","&#36;",0);
		$stripe["NGN"] = array("Nigerian Naira","NGN",0);
		$stripe["NIO"] = array("Nicaraguan Córdoba","NIO",1);
		$stripe["NOK"] = array("Norwegian Krone","NOK",0);
		$stripe["NPR"] = array("Nepalese Rupee","NPR",0);
		$stripe["NZD"] = array("New Zealand Dollar","&#36;",0);
		$stripe["PAB"] = array("Panamanian Balboa","PAB",1);
		$stripe["PEN"] = array("Peruvian Nuevo Sol","PEN",1);
		$stripe["PGK"] = array("Papua New Guinean Kina","PGK",0);
		$stripe["PHP"] = array("Philippine Peso","PHP",0);
		$stripe["PKR"] = array("Pakistani Rupee","PKR",0);
		$stripe["PLN"] = array("Polish Złoty","PLN",0);
		$stripe["PYG"] = array("Paraguayan Guaraní","PYG",1);
		$stripe["QAR"] = array("Qatari Riyal","QAR",0);
		$stripe["RON"] = array("Romanian Leu","RON",0);
		$stripe["RSD"] = array("Serbian Dinar","RSD",0);
		$stripe["RUB"] = array("Russian Ruble","RUB",0);
		$stripe["RWF"] = array("Rwandan Franc","RWF",0);
		$stripe["SAR"] = array("Saudi Riyal","SAR",0);
		$stripe["SBD"] = array("Solomon Islands Dollar","&#36;",0);
		$stripe["SCR"] = array("Seychellois Rupee","&#36;",0);
		$stripe["SEK"] = array("Swedish Krona","SEK",0);
		$stripe["SGD"] = array("Singapore Dollar","&#36;",0);
		$stripe["SHP"] = array("Saint Helenian Pound","SHP",1);
		$stripe["SLL"] = array("Sierra Leonean Leone","SLL",0);
		$stripe["SOS"] = array("Somali Shilling","SOS",0);
		$stripe["SRD"] = array("Surinamese Dollar","&#36;",1);
		$stripe["STD"] = array("São Tomé and Príncipe Dobra","STD",0);
		$stripe["SVC"] = array("Salvadoran Colón","SVC",1);
		$stripe["SZL"] = array("Swazi Lilangeni","SZL",0);
		$stripe["THB"] = array("Thai Baht","THB",0);
		$stripe["TJS"] = array("Tajikistani Somoni","TJS",0);
		$stripe["TOP"] = array("Tongan Paʻanga","TOP",0);
		$stripe["TRY"] = array("Turkish Lira","TRY",0);
		$stripe["TTD"] = array("Trinidad and Tobago Dollar","&#36;",0);
		$stripe["TTD"] = array("New Taiwan Dollar","&#36;",0);
		$stripe["TZS"] = array("Tanzanian Shilling","TZS",0);
		$stripe["UAH"] = array("Ukrainian Hryvnia","UAH",0);
		$stripe["UGX"] = array("Ugandan Shilling","UGX",0);
		$stripe["USD"] = array("United States Dollar","&#36;",0);
		$stripe["UYU"] = array("Uruguayan Peso","UYU",1);
		$stripe["UZS"] = array("Uzbekistani Som","UZS",0);
		$stripe["VEF"] = array("Venezuelan Bolívar","VEF",1);
		$stripe["VND"] = array("Vietnamese Đồng","VND",0);
		$stripe["VUV"] = array("Vanuatu Vatu","VUV",0);
		$stripe["WST"] = array("Samoan Tala","WST",0);
		$stripe["XAF"] = array("Central African Cfa Franc","XAF",0);
		$stripe["XCD"] = array("East Caribbean Dollar","&#36;",0);
		$stripe["XOF"] = array("West African Cfa Franc","XOF",1);
		$stripe["XPF"] = array("Cfp Franc","XPF",1);
		$stripe["YER"] = array("Yemeni Rial","YER",0);
		$stripe["ZAR"] = array("South African Rand","ZAR",0);
		$stripe["ZMW"] = array("Zambian Kwacha","ZMW",0);
		
		$payments_supported_currencies['stripe'] = $stripe;
		
		$paypal = array();
		$paypal["AUD"] = array("Australian Dollar","&#36;",0);
		$paypal["BRL"] = array("Brazilian Real","&#82;&#36;",1);
		$paypal["CAD"] = array("Canadian Dollar","&#36;",0);
		$paypal["CZK"] = array("Czech Koruna","&#75;&#269;",0);
		$paypal["DKK"] = array("Danish Krone","&#107;&#114;",0);
		$paypal["EUR"] = array("Euro","&#8364;",0);
		$paypal["HKD"] = array("Hong Kong Dollar","&#36;",0);
		$paypal["HUF"] = array("Hungarian Forint","&#70;&#116;",0);
		$paypal["ILS"] = array("Israeli New Sheqel","&#8362;",0);
		$paypal["JPY"] = array("Japanese Yen","&#165;",0);
		$paypal["MYR"] = array("Malaysian Ringgit","&#82;&#77;",1);
		$paypal["MXN"] = array("Mexican Peso","&#36;",0);
		$paypal["NOK"] = array("Norwegian Krone","&#107;&#114;",0);
		$paypal["NZD"] = array("New Zealand Dollar","&#36;",0);
		$paypal["PHP"] = array("Philippine Peso","&#8369;",0);
		$paypal["PLN"] = array("Polish Zloty","&#122;&#322;",0);
		$paypal["GBP"] = array("Pound Sterling","&#163;",0);
		$paypal["RUB"] = array("Russian Ruble","&#1088;&#1091;&#1073;",0);
		$paypal["SGD"] = array("Singapore Dollar","&#36;",0);
		$paypal["SEK"] = array("Swedish Krona","&#107;&#114;",0);
		$paypal["CHF"] = array("Swiss Franc","&#67;&#72;&#70;",0);
		$paypal["TWD"] = array("Taiwan New Dollar","&#78;&#84;&#36;",0);
		$paypal["THB"] = array("Thai Baht","&#3647;",0);
		$paypal["TRY"] = array("Turkish Lira","&#8356;",1);
		$paypal["USD"] = array("United States Dollar","&#36;",0);

		
		$payments_supported_currencies['paypal'] = $paypal;
		
		return $payments_supported_currencies;
	
	}


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}