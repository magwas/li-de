<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

class com_ecommercewdInstallerScript{
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
	public function postflight($type, $parent){	
		if ($type == 'update'){
		
			$db = JFactory::getDBO();			
			$sqlfile = JPATH_ADMINISTRATOR.'/components/com_ecommercewd/sql/update.mysql.sql';	
			$buffer = file_get_contents($sqlfile);
			
			if ($buffer === false){
				JError::raiseWarning(1, JText::_('JLIB_INSTALLER_ERROR_SQL_READBUFFER'));
				return false;
			}
			
			jimport('joomla.installer.helper');
			$queries = JInstallerHelper::splitSql($buffer);
			if (count($queries) == 0) {
				// No queries to process
				return 0;
			}
					
			// Process each query in the $queries array (split out of sql file).
			foreach ($queries as $query){
				$query = trim($query);
				if ($query != '' && $query{0} != '#'){
					$db->setQuery($query);
					if (!$db->query()){
						JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
						return false;
					}
				}
			}

			$config = JFactory::getConfig();
			$db_name= $config->get( 'db' );				
			
			// category parameters
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_categoryparameters LIKE 'categoryparameters_id'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
		
			if($db->getNumRows()!=1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_categoryparameters ADD `categoryparameters_id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY"); 
				$db->query(); 
			}

			//countries
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_countries LIKE 'published'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
		
			if($db->getNumRows()!=1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_countries ADD  `published`  TINYINT UNSIGNED NOT NULL DEFAULT 1 ");
				$db->query(); 
				
				$query = "INSERT INTO `#__ecommercewd_countries` (`id`, `code` ,`name`, `published` ) VALUES							
						 ('', 'US', 'United States',1),('', 'CA', 'Canada',1),('', 'AF', 'Afghanistan',''),('', 'AL', 'Albania',''),('', 'DZ', 'Algeria',''),('', 'DS', 'American Samoa',''),('', 'AD', 'Andorra',''),('', 'AO', 'Angola',''),('', 'AI', 'Anguilla',''),('', 'AQ', 'Antarctica',''),('', 'AG', 'Antigua and/or Barbuda',''),('', 'AR', 'Argentina',''),('', 'AM', 'Armenia',1),('', 'AW', 'Aruba',''),('', 'AU', 'Australia',''),('', 'AT', 'Austria',''),('', 'AZ', 'Azerbaijan',''),('', 'BS', 'Bahamas',''),('', 'BH', 'Bahrain',''),('', 'BD', 'Bangladesh',''),('', 'BB', 'Barbados',''),('', 'BY', 'Belarus',''),('', 'BE', 'Belgium',1),('', 'BZ', 'Belize',''),('', 'BJ', 'Benin',''),('', 'BM', 'Bermuda',''),('', 'BT', 'Bhutan',''),('', 'BO', 'Bolivia',''),('', 'BA', 'Bosnia and Herzegovina',''),('', 'BW', 'Botswana',''),('', 'BV', 'Bouvet Island',''),('', 'BR', 'Brazil',''),('', 'IO', 'British lndian Ocean Territory',''),('', 'BN', 'Brunei Darussalam',''),('', 'BG', 'Bulgaria',''),('', 'BF', 'Burkina Faso',''),('', 'BI', 'Burundi',''),('', 'KH', 'Cambodia',''),('', 'CM', 'Cameroon',''),('', 'CV', 'Cape Verde',''),('', 'KY', 'Cayman Islands',''),('', 'CF', 'Central African Republic',''),('', 'TD', 'Chad',''),('', 'CL', 'Chile',''),('', 'CN', 'China',1),('', 'CX', 'Christmas Island',''),('', 'CC', 'Cocos (Keeling) Islands',''),('', 'CO', 'Colombia',''),('', 'KM', 'Comoros',''),('', 'CG', 'Congo',''),('', 'CK', 'Cook Islands',''),('', 'CR', 'Costa Rica',''),('', 'HR', 'Croatia (Hrvatska)',''),('', 'CU', 'Cuba',''),('', 'CY', 'Cyprus',''),('', 'CZ', 'Czech Republic',''),('', 'DK', 'Denmark',1),('', 'DJ', 'Djibouti',''),('', 'DM', 'Dominica',''),('', 'DO', 'Dominican Republic',''),('', 'TP', 'East Timor',''),('', 'EC', 'Ecuador',''),('', 'EG', 'Egypt',''),('', 'SV', 'El Salvador',''),('', 'GQ', 'Equatorial Guinea',''),('', 'ER', 'Eritrea',''),('', 'EE', 'Estonia',''),('', 'ET', 'Ethiopia',''),('', 'FK', 'Falkland Islands (Malvinas)',''),('', 'FO', 'Faroe Islands',''),('', 'FJ', 'Fiji',''),('', 'FI', 'Finland',''),('', 'FR', 'France',1),('', 'FX', 'France, Metropolitan',''),('', 'GF', 'French Guiana',''),('', 'PF', 'French Polynesia',''),('', 'TF', 'French Southern Territories',''),('', 'GA', 'Gabon',''),('', 'GM', 'Gambia',''),('', 'GE', 'Georgia',''),('', 'DE', 'Germany',1),('', 'GH', 'Ghana',''),('', 'GI', 'Gibraltar',''),('', 'GR', 'Greece',''),('', 'GL', 'Greenland',''),('', 'GD', 'Grenada',''),('', 'GP', 'Guadeloupe',''),('', 'GU', 'Guam',''),('', 'GT', 'Guatemala',''),('', 'GN', 'Guinea',''),('', 'GW', 'Guinea-Bissau',''),('', 'GY', 'Guyana',''),('', 'HT', 'Haiti',''),('', 'HM', 'Heard and Mc Donald Islands',''),('', 'HN', 'Honduras',''),('', 'HK', 'Hong Kong',''),('', 'HU', 'Hungary',''),('', 'IS', 'Iceland',''),('', 'IN', 'India',''),('', 'ID', 'Indonesia',''),('', 'IR', 'Iran (Islamic Republic of)',''),('', 'IQ', 'Iraq',''),('', 'IE', 'Ireland',''),('', 'IL', 'Israel',''),('', 'IT', 'Italy',1),('', 'CI', 'Ivory Coast',''),('', 'JM', 'Jamaica',''),('', 'JP', 'Japan',1),('', 'JO', 'Jordan',''),('', 'KZ', 'Kazakhstan',''),('', 'KE', 'Kenya',''),('', 'KI', 'Kiribati',''),('', 'KP', 'Korea, Democratic People''s Republic of',''),('', 'KR', 'Korea, Republic of',''),('', 'XK', 'Kosovo',''),('', 'KW', 'Kuwait',''),('', 'KG', 'Kyrgyzstan',''),('', 'LA', 'Lao People''s Democratic Republic',''),('', 'LV', 'Latvia',''),('', 'LB', 'Lebanon',''),('', 'LS', 'Lesotho',''),('', 'LR', 'Liberia',''),('', 'LY', 'Libyan Arab Jamahiriya',''),('', 'LI', 'Liechtenstein',''),('', 'LT', 'Lithuania',''),('', 'LU', 'Luxembourg',''),('', 'MO', 'Macau',''),('', 'MK', 'Macedonia',''),('', 'MG', 'Madagascar',''),('', 'MW', 'Malawi',''),('', 'MY', 'Malaysia',''),('', 'MV', 'Maldives',''),('', 'ML', 'Mali',''),('', 'MT', 'Malta',''),('', 'MH', 'Marshall Islands',''),('', 'MQ', 'Martinique',''),('', 'MR', 'Mauritania',''),('', 'MU', 'Mauritius',''),('', 'TY', 'Mayotte',''),('', 'MX', 'Mexico',''),('', 'FM', 'Micronesia, Federated States of',''),('', 'MD', 'Moldova, Republic of',''),('', 'MC', 'Monaco',''),('', 'MN', 'Mongolia',''),('', 'ME', 'Montenegro',''),('', 'MS', 'Montserrat',''),('', 'MA', 'Morocco',''),('', 'MZ', 'Mozambique',''),('', 'MM', 'Myanmar',''),('', 'NA', 'Namibia',''),('', 'NR', 'Nauru',''),('', 'NP', 'Nepal',''),('', 'NL', 'Netherlands',1),('', 'AN', 'Netherlands Antilles',''),('', 'NC', 'New Caledonia',''),('', 'NZ', 'New Zealand',''),('', 'NI', 'Nicaragua',''),('', 'NE', 'Niger',''),('', 'NG', 'Nigeria',''),('', 'NU', 'Niue',''),('', 'NF', 'Norfork Island',''),('', 'MP', 'Northern Mariana Islands',''),('', 'NO', 'Norway',''),('', 'OM', 'Oman',''),('', 'PK', 'Pakistan',''),('', 'PW', 'Palau',''),('', 'PA', 'Panama',''),('', 'PG', 'Papua New Guinea',''),('', 'PY', 'Paraguay',''),('', 'PE', 'Peru',''),('', 'PH', 'Philippines',''),('', 'PN', 'Pitcairn',''),('', 'PL', 'Poland',''),('', 'PT', 'Portugal',''),('', 'PR', 'Puerto Rico',''),('', 'QA', 'Qatar',''),('', 'RE', 'Reunion',''),('', 'RO', 'Romania',''),('', 'RU', 'Russian Federation',''),('', 'RW', 'Rwanda',''),('', 'KN', 'Saint Kitts and Nevis',''),('', 'LC', 'Saint Lucia',''),('', 'VC', 'Saint Vincent and the Grenadines',''),('', 'WS', 'Samoa',''),('', 'SM', 'San Marino',''),('', 'ST', 'Sao Tome and Principe',''),('', 'SA', 'Saudi Arabia',''),('', 'SN', 'Senegal',''),('', 'RS', 'Serbia',''),('', 'SC', 'Seychelles',''),('', 'SL', 'Sierra Leone',''),('', 'SG', 'Singapore',''),('', 'SK', 'Slovakia',''),('', 'SI', 'Slovenia',''),('', 'SB', 'Solomon Islands',''),('', 'SO', 'Somalia',''),('', 'ZA', 'South Africa',''),('', 'GS', 'South Georgia South Sandwich Islands',''),('', 'ES', 'Spain',1),('', 'LK', 'Sri Lanka',''),('', 'SH', 'St. Helena',''),('', 'PM', 'St. Pierre and Miquelon',''),('', 'SD', 'Sudan',''),('', 'SR', 'Suriname',''),('', 'SJ', 'Svalbarn and Jan Mayen Islands',''),('', 'SZ', 'Swaziland',1),('', 'SE', 'Sweden',1),('', 'CH', 'Switzerland',''),('', 'SY', 'Syrian Arab Republic',''),('', 'TW', 'Taiwan',''),('', 'TJ', 'Tajikistan',''),('', 'TZ', 'Tanzania, United Republic of',''),('', 'TH', 'Thailand',''),('', 'TG', 'Togo',''),('', 'TK', 'Tokelau',''),('', 'TO', 'Tonga',''),('', 'TT', 'Trinidad and Tobago',''),('', 'TN', 'Tunisia',''),('', 'TR', 'Turkey',''),('', 'TM', 'Turkmenistan',''),('', 'TC', 'Turks and Caicos Islands',''),('', 'TV', 'Tuvalu',''),('', 'UG', 'Uganda',''),('', 'UA', 'Ukraine',''),('', 'AE', 'United Arab Emirates',''),('', 'GB', 'United Kingdom',1),('', 'UM', 'United States minor outlying islands',''),('', 'UY', 'Uruguay',''),('', 'UZ', 'Uzbekistan',''),('', 'VU', 'Vanuatu',''),('', 'VA', 'Vatican City State',''),('', 'VE', 'Venezuela',''),('', 'VN', 'Vietnam',''),('', 'VG', 'Virigan Islands (British)',''),('', 'VI', 'Virgin Islands (U.S.)',''),('', 'WF', 'Wallis and Futuna Islands',''),('', 'EH', 'Western Sahara',''),('', 'YE', 'Yemen',''),('', 'YU', 'Yugoslavia',''),('', 'ZR', 'Zaire',''),('', 'ZM', 'Zambia',''), ('', 'ZW', 'Zimbabwe','')";
				$db->setQuery( $query );
				if ( !$db->query() ) {
					$msg =$db->getErrorMsg();
					echo $msg;
					return false;
				}
			}
			
			// orders			
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_orders LIKE 'billing_data_first_name'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			
			if($db->getNumRows() != 1) {
				// add fields
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_first_name` VARCHAR(256) NOT NULL");
				$db->query();
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_middle_name` VARCHAR(256) NOT NULL");
				$db->query();
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_last_name` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_company` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_email` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_country_id` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_country` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_state` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_city` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_address` VARCHAR(256) NOT NULL");
				$db->query();  				
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_mobile` VARCHAR(256) NOT NULL");
				$db->query();  					
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_phone` VARCHAR(256) NOT NULL");
				$db->query();  	
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_fax` VARCHAR(256) NOT NULL");
				$db->query();  	
				$db->setQuery("ALTER TABLE #__ecommercewd_orders ADD  `billing_data_zip_code` VARCHAR(256) NOT NULL");
				$db->query();  
				
				// drop fields
				$db->setQuery("ALTER TABLE #__ecommercewd_orders DROP `shipping_data_email` "); 
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders DROP `shipping_data_mobile` "); 
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders DROP `shipping_data_phone` "); 
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_orders DROP `shipping_data_fax` "); 
				$db->query(); 				
				
			}
			
			// order products
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_orderproducts LIKE 'product_parameters_price'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1){
				$db->setQuery("ALTER TABLE #__ecommercewd_orderproducts ADD `product_parameters_price` VARCHAR(256) NOT NULL"); 
				$db->query(); 			
			}
			
			// order statuses
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_orderstatuses LIKE 'published'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1){
				$db->setQuery("ALTER TABLE #__ecommercewd_orderstatuses ADD `published` TINYINT UNSIGNED NOT NULL DEFAULT 1"); 
				$db->query(); 			
			}
							
			$query = "SELECT * FROM #__ecommercewd_orderstatuses ";
			$db->setQuery($query);
			
			if(count($db->loadObjectList()) == 1){
				$query = "INSERT INTO `#__ecommercewd_orderstatuses` (`id`, `name`, `ordering`, `published`, `default`)  VALUES
						('', 'Confirmed by shopper', '', 1, 0),('', 'Confirmed', '', 1, 0),('', 'Cancelled', '', 1, 0),('', 'Refunded', '', 1, 0),('', 'Shipped', '', 1, 0)";
				$db->setQuery( $query );
				if ( !$db->query() ) {
					$msg =$db->getErrorMsg();
					echo $msg;
					return false;
				}						
			}
			
			//options
			$query = "SELECT name  FROM #__ecommercewd_options WHERE name='enable_sku' ";
			$db->setQuery($query);	
			
			if($db->loadResult() == NULL){
				$query = "INSERT INTO `#__ecommercewd_options` (`id`, `name`, `value`, `default_value`) VALUES 
				('', 'enable_sku', 1, 1),('', 'enable_upc', 1, 1),('', 'enable_ean', 1, 1),('', 'enable_jan', 1, 1),('', 'enable_isbn', 1, 1),('', 'enable_mpn', 1, 1),('', 'weight_unit', 'kg', 'kg'),('', 'dimensions_unit', 'cm', 'cm'),('', 'search_enable_user_bar', 1, 1)";
	
				$db->setQuery( $query );
				if ( !$db->query() ) {
					$msg =$db->getErrorMsg();
					echo $msg;
					return false;
				}
			}
			
			// parameters
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_parameters LIKE 'ordering'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_parameters ADD  `ordering` INT(16) UNSIGNED NOT NULL DEFAULT 0");
				$db->query(); 
			}
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_parameters LIKE 'type_id'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_parameters ADD  `type_id` INT(16) UNSIGNED NOT NULL DEFAULT 0");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_parameters ADD  `default_values` VARCHAR(256) NOT NULL");
				$db->query(); 
			}
			
			// product parameters
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_productparameters LIKE 'parameter_value_price'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_productparameters ADD  `parameter_value_price` VARCHAR(256) NOT NULL");
				$db->query(); 
			}	

			// products	
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_products LIKE 'model'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `model` VARCHAR(256) NOT NULL");
				$db->query();
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `sku` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `upc` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `ean` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `jan` VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `isbn` VARCHAR(256) NOT NULL");
				$db->query(); 	
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `mpn` VARCHAR(256) NOT NULL");
				$db->query(); 	
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `weight` VARCHAR(256) NOT NULL");
				$db->query(); 	
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `dimensions` VARCHAR(256) NOT NULL");
				$db->query(); 	
				$db->setQuery("ALTER TABLE #__ecommercewd_products ADD  `videos` VARCHAR(256) NOT NULL");
				$db->query(); 						
			}			
			
			//tools
			
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_tools LIKE 'create_toolbar_icon'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_tools ADD `create_toolbar_icon`  INT(16) UNSIGNED NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_tools ADD `tool_type`  VARCHAR(256) NOT NULL");
				$db->query(); 		
			
			}
			
			//themes
			
			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_themes LIKE 'product_model_color'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_themes ADD `product_model_color`  VARCHAR(256) NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_themes ADD `product_code_color`  VARCHAR(256) NOT NULL");
				$db->query(); 		
				$db->setQuery("ALTER TABLE #__ecommercewd_themes ADD `product_view_show_model`  TINYINT UNSIGNED NOT NULL");
				$db->query(); 
				$db->setQuery("ALTER TABLE #__ecommercewd_themes ADD `products_quick_view_show_model`  TINYINT UNSIGNED NOT NULL");
				$db->query(); 				
			}			

			// users		

			$db->setQuery("SHOW COLUMNS FROM #__ecommercewd_users LIKE 'stripe_customer_id'");
			if (!$db->query()){
				JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
				return false;
			}
			if($db->getNumRows() != 1) {
				$db->setQuery("ALTER TABLE #__ecommercewd_users ADD `stripe_customer_id` VARCHAR(256) NOT NULL");
				$db->query(); 			
			}			
			
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}	