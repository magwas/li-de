<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

class EcommercewdOrder{
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

	public static function get_pdf_invoice($row, $options, $create_file = false){
	
		$app = JFactory::getApplication();	
		// require domPDF library	
		require_once JPATH_ADMINISTRATOR. '/components/com_ecommercewd/libraries/pdfinvoice/dompdf_config.inc.php';

		$html = self::get_order_html($row,$options);
		$dompdf = new DOMPDF();

		$dompdf->load_html($html);
		$dompdf->render();
		
		// define papaer size
		if($options['paper_size'] == 'a4'){
			$dompdf->set_paper("A4", "portrait");
		}
		elseif($options['paper_size'] == 'letter'){
			$dompdf->set_paper('letter', 'landscape');
		}
		
		if($create_file == true){
			$output = $dompdf->output();
			file_put_contents(JPATH_SITE."/components/com_".WDFHelper::get_com_name()."/invoice.pdf", $output);			
			return JPATH_SITE."/components/com_".WDFHelper::get_com_name()."/invoice.pdf";
		}
		else{
			//define pdf invoice view
			if( $options['invoice_view'] == 0){
				$dompdf->stream('invoice.pdf',array('Attachment'=>0));			
			}
			else{
				$dompdf->stream("invoice.pdf");
			}
			exit;	
		}
	
	}
	

	public static function print_order($row){
		echo self::get_order_html($row);						
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
	private static function get_order_html($row, $pdf_options = ''){
		$model_options = WDFHelper::get_model('options');
		$options = $model_options->get_options();
		if(WDFHelper::is_admin() == true){
			$initial_values = $options['initial_values'];
			$decimals = $options['initial_values']['option_show_decimals'] == 1 ? 2 : 0;
		}
		else{
			$decimals = $options->option_show_decimals == 1 ? 2 : 0;
		}
		$shop_info  = '';
		
		if( $pdf_options != '' ){
			$shop_name = $pdf_options['shop_name'] ?  $pdf_options['shop_name'].'<br>' : '';
			$shop_address = $pdf_options['shop_address'] ?  $pdf_options['shop_address'].'<br>' : '';
			$shop_telephone = $pdf_options['shop_telephone'] ?  $pdf_options['shop_telephone'].'<br>' : '';
			$x = WDFJson::decode($pdf_options['invoice_logo']);
			$shop_logo = $pdf_options['invoice_logo'] != '[]' ?  '<img src="'.JPATH_SITE.'/'.$x[0].'" width="85">' : '';

			$site =  JURI::root().'<br>';
			$shop_info = '<table class="shop_info">
							<tr>
								<td>'.$shop_logo.'</td>
								<td>'.$shop_name.$shop_address.$shop_telephone.$site.'</td>
							</tr>
						</table>';
		}
		
		ob_start();
		echo '
			<style>
				table tr td{
					font-size:16px;
				}
				h1
				{
					text-align:right;
					text-transform: uppercase;
					color: #CCCCCC;
					font-size: 24px;
					font-weight: normal;
					padding-bottom: 5px;
					margin-top: 0px;
					margin-bottom: 15px;
					border-bottom: 1px solid #CDDDDD;
				}
				
				.shop_info{
					color: #5C5A5A;
					width: 58%;
				}
				.store 
				{
					width: 100%;
					margin-bottom: 20px;
					border:1px solid #fff;
				}
				
				.store  tr td{
					border:1px solid #fff;
				}

				.address , .product
				{
					width: 100%;
					margin-bottom: 20px;
					border-top: 1px solid #CDDDDD;
					border-right: 1px solid #CDDDDD;
					border-collapse: collapse;
				}

				 .address td , .product td
				 {
					border-left: 1px solid #CDDDDD;
					border-bottom: 1px solid #CDDDDD;
					padding: 5px;
					vertical-align: text-bottom;
					height:32px;
					width:50%;

				}
				.heading td 
				{
					background: #E7EFEF;
				}

				.address p 
				{
					margin:0;
				}
			</style>';
		echo '
			<div>
				<h1>'.JText::_('INVOICE').'</h1>
				<table class="store">
					<tr>
						<td>'.$shop_info.'</td>
						<td align="right">
							<table>
								<tr>
									<td><b>'.WDFText::get('PDF_DATE_ADDEED').'</b></td>
									<td>'.date("Y-m-d",strtotime($row->checkout_date)).'</td>									
								</tr>
								<tr>
									<td><b>'.WDFText::get('PDF_ORDER_ID').'</b></td>
									<td>'.$row->id.'</td>
								</tr>
								<tr>
									<td><b>'.WDFText::get('PDF_INVOICE_NUMBER').'</b></td>
									<td>'.date('Ymd').$row->id.'</td>
								</tr>								
								<tr>
									<td><b>'.WDFText::get('PDF_PAYMENT_METHOD').'</b></td>
									<td>'.ucwords(str_replace('_', ' ', $row->payment_method)).'</td>
								</tr>								
							</table>
						</td>
					</tr>
				</table>
				
				<table class="address">
					<tr class="heading">
						<td>'.WDFText::get('PDF_TO').'</td>
						<td>'.WDFText::get('PDF_SHIP_TO').'</td>
					</tr>	
					<tr>
						<td>
							<p>'.str_replace( "'", "", $row->billing_data_first_name ).' '.str_replace( "'", "", $row->billing_data_middle_name ).' '.str_replace( "'", "", $row->billing_data_last_name ).'</p>
							<p>'.str_replace( "'", "", $row->billing_data_email ).'</p>
							<p>'.str_replace( "'", "", $row->billing_data_address ).'</p>
							<p>'.str_replace( "'", "", $row->billing_data_city ).' '.str_replace( "'", "", $row->billing_data_state ).' '.str_replace( "'", "", $row->billing_data_zip_code ).'</p>
							<p>'.str_replace( "'", "", $row->billing_data_country ).'</p>						
							<p>'.str_replace( "'", "", $row->billing_data_phone ).'</p>
							<p>'.str_replace( "'", "", $row->billing_data_fax ).'</p>
						</td>					
						<td>
							<p>'.str_replace( "'", "", $row->shipping_data_first_name ).' '.str_replace( "'", "", $row->shipping_data_middle_name ).' '.str_replace( "'", "", $row->shipping_data_last_name ).'</p>
							<p>'.str_replace( "'", "", $row->shipping_data_address ).'</p>
							<p>'.str_replace( "'", "", $row->shipping_data_city ).' '.str_replace( "'", "", $row->shipping_data_state ).' '.str_replace( "'", "", $row->shipping_data_zip_code ).'</p>
							<p>'.str_replace( "'", "", $row->shipping_data_country ).'</p>
						</td>
					</tr>
				</table>

				<table class="product">
					<tr class="heading">
						<td>'.WDFText::get('PDF_PRODUCT').'</td>
						<td>'.WDFText::get('PDF_QUANTITY').'</td>
						<td>'.WDFText::get('PDF_UNIT_PRICE').'</td>
						<td>'.WDFText::get('PDF_TAX').'</td>	
						<td>'.WDFText::get('PDF_SHIPPING').'</td>	
						<td>'.WDFText::get('PDF_SUB_TOTAL').'</td>											
					</tr>';
				$sub_total = 0;	
				foreach ( $row->product_names_invoice as $product_info )
				{	
					echo '
						<tr>
							<td>'.$product_info['product_name'].'</td>
							<td>'.$product_info['product_count'].'</td>
							<td>'.$product_info['product_price_text'].'</td>
							<td>'.$product_info['tax_price_text'].'</td>							
							<td>'.$product_info['shipping_method_price_text'].'</td>							
							<td>'.$product_info['subtotal_text'].'</td>						
						</tr>					
					';
					$sub_total += str_replace(',','',preg_replace("/[^0-9,.]/", "",$product_info['subtotal_text']));
					$sub_total_text = number_format($sub_total, $decimals).$product_info['currency_code'];
				}
				for($j=0; $j<(10-count($row->product_names_invoice)); $j++)
					echo '
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>				
					';
				echo '
					<tr>
						<td colspan="5" align="right">'.WDFText::get('PDF_TOTAL').':</td>
						<td>'.$sub_total_text.'</td>
					</tr>
				</table>	
			
			</div>
		';
		
		$html = ob_get_contents();		
		ob_end_clean();
		
		return $html;

	}	
	////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////	


}