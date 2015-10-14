<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdModelReports extends EcommercewdModel {
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
	public function get_report_view_data(){

		$date_range = $this->get_date_range();	
		$row_report_data = $this->get_report_row($date_range->start_date, $date_range->end_date);
		
		$row_report_data->start_date = $date_range->start_date;
		$row_report_data->end_date = $date_range->end_date;
		$row_report_data->json_data = $this->get_reports_json_data();
		$row_report_data->currency = $this->get_currency($date_range->start_date, $date_range->end_date);
		
		return $row_report_data;
	}
	
	public function get_reports_data_array(){
	
		$date_range = $this->get_date_range();	
		$current_date = strtotime($date_range->start_date);
		$end_date = strtotime($date_range->end_date);
		$counter = 'day';
		$monthly = false;
		$date_format = "Y-m-d";
		
		if($date_range->number_of_months >12 || $date_range->tab_index == 'year'){
			$counter = 'month';
			$monthly = true;
			$date_format = "Y-m";
		}
		
		$row_end_date = $current_date;		
		if($monthly == true){
			$row_end_date = strtotime(date("Y-m-d",$current_date)." +1 month");
		}

		$reports_data_array = array();
		while($current_date <= $end_date){			
			$report_data = $this->get_report_row(date("Y-m-d",$current_date),date("Y-m-d",$row_end_date));
			$report_data->date = date($date_format,$current_date);
			$reports_data_array[] = $report_data;
			$current_date = strtotime(date("Y-m-d",$current_date). " +1 ".$counter);
			$row_end_date = strtotime(date("Y-m-d",$row_end_date). " +1 ".$counter);
		}
		
		return $reports_data_array;
	}

	public function get_date_range(){	
		$type = WDFInput::get('tab_index');
		switch($type){
			case "year":
				$start_date = date('Y-01-01');
				$end_date = date('Y-m-d');
			break;
			case "last_month":
				$start_date = date("Y-m-01",strtotime("-1 month"));
				$end_date = date("Y-m-t",strtotime("-1 month"));
			break;
			case "this_month":
				$start_date = date("Y-m-01");
				$end_date = date("Y-m-d");
			break;
			case "last_week":
				$start_date = date("Y-m-d",strtotime("-7 days"));
				$end_date = date("Y-m-d");
			break;
			case "custom":
				$start_date = WDFInput::get("start_date") ? WDFInput::get("start_date") : date('Y-m-d');
				$end_date = WDFInput::get("end_date") ? WDFInput::get("end_date") : date('Y-m-d');
			break;
			default:
				$start_date = date('Y-01-01');
				$end_date = date('Y-m-d');
			break;			
		}
		$number_of_days = strtotime($end_date) - strtotime($start_date);
		$number_of_days = ceil($number_of_days/(60*60*24));
		$number_of_months = ceil($number_of_days/30);
		
		$date_range = new Stdclass();
		$date_range->start_date = $start_date; 
		$date_range->end_date = $end_date; 
		$date_range->number_of_days = $number_of_days; 
		$date_range->number_of_months = $number_of_months; 
		$date_range->tab_index = $type == "" ? "year" : $type;
		
		return $date_range;

	}
	
	public function get_report_row($start_date, $end_date){
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);
		
		$query->clear();
		$query->select("SUM(T_ORDER_PRODUCTS.total_price) AS total_seals ");
		$query->select("SUM(T_ORDER_PRODUCTS.total_shipping_price) AS total_shipping_seals ");
		$query->select("COUNT(*) AS orders_count ");
		$query->select("SUM(T_ORDER_PRODUCTS.order_product_count) AS items_count ");	
		$query->from("#__ecommercewd_orders AS T_ORDERS");
		$query->leftJoin("( SELECT order_id, SUM(product_price*product_count) AS total_price,SUM(shipping_method_price*product_count) AS total_shipping_price, SUM(product_count) AS order_product_count FROM #__ecommercewd_orderproducts GROUP BY order_id) AS T_ORDER_PRODUCTS ON T_ORDER_PRODUCTS.order_id = T_ORDERS.id");	
		$query->where('DATE_FORMAT(T_ORDERS.checkout_date,"%Y-%m-%d") BETWEEN  "'.$start_date.'" AND "'.$end_date.'"');

		$db->setQuery($query);
		$row = $db->loadObject();
		$row->items_count = $row->items_count ? $row->items_count : 0;
		$type = WDFInput::get('tab_index');	
		$date_range = $this->get_date_range();
		
		$number_of_days = $date_range->number_of_days; 
		$number_of_months = $date_range->number_of_months; 
		switch($type){
			case "year":
				$row->average_sales = ($number_of_months != 0) ? $row->total_seals/$number_of_months : $row->total_seals;
				$row->average_type = "monthly";
			break;
			case "last_month":
			case "last_week":	
			case "this_month":			
				$row->average_sales = ($number_of_days != 0) ? $row->total_seals/$number_of_days :$row->total_seals ;
				$row->average_type = "daily";
			break;		
			case "custom":				
				if($number_of_months > 12){
					$row->average_sales = $row->total_seals/$number_of_months;
					$row->average_type = "monthly";
				}
				else{
					$row->average_sales = ($number_of_days != 0) ? $row->total_seals/$number_of_days : $row->total_seals;
					$row->average_type = "daily";
			
				}		
			break;
			default:													
				$row->average_sales = ($number_of_months != 0) ? $row->total_seals/$number_of_months : $row->total_seals;
				$row->average_type = "monthly";
			break;			
		}
		return $row;
	
	}	
	public function get_currency($start_date, $end_date){
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);
		
		$query->clear();
		$query->select("currency_id");
		$query->select("COUNT(*)");
		$query->from("#__ecommercewd_orders AS T_ORDERS");		
		$query->where('DATE_FORMAT(T_ORDERS.checkout_date,"%Y-%m-%d") BETWEEN  "'.$start_date.'" AND "'.$end_date.'"');
		$query->group("currency_id");
		$db->setQuery($query);
		$currencies = $db->loadObjectList();

		if(count($currencies) > 1){
			$currency_code = NUll;
		}
		else{		
			$currency_code = (count($currencies) == 1) ?  WDFDb::get_row('currencies', $db->quoteName('id') . ' = ' .$currencies[0]->currency_id ) : WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');			 
		}
		
		return $currency_code;
	
	}	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
	private function get_reports_json_data(){

		$reports_data_array = $this->get_reports_data_array();
		$date_range = $this->get_date_range();

		$row = $this->get_report_row($date_range->start_date, $date_range->end_date);

		$reports_chart_data = array();

		$reports_chart_data['total_seals'] = array();
		$reports_chart_data['total_shipping_seals'] = array();
		$reports_chart_data['orders_count'] = array();
		$reports_chart_data['items_count'] = array();
		foreach($reports_data_array as $key => $report_data){
			$reports_chart_data['total_seals'][] = array(strtotime( date( 'Ymd', strtotime( $report_data->date ) ) ) . '000',$report_data->total_seals ? (float)$report_data->total_seals : 0);
			$reports_chart_data['total_shipping_seals'][] = array(strtotime( date( 'Ymd', strtotime( $report_data->date ) ) ) . '000',$report_data->total_shipping_seals ? (float) $report_data->total_shipping_seals : 0);
			$reports_chart_data['orders_count'][] = array(strtotime( date( 'Ymd', strtotime( $report_data->date ) ) ) . '000',$report_data->orders_count ? (int)$report_data->orders_count : 0);
			$reports_chart_data['items_count'][] = array(strtotime( date( 'Ymd', strtotime( $report_data->date ) ) ) . '000',$report_data->items_count ? (int)$report_data->items_count : 0);
		}
		
		$reports_chart_data['start_date'] = strtotime( date( 'Ymd', strtotime( $date_range->start_date ) ) ) . '000';
		$reports_chart_data['end_date'] = strtotime( date( 'Ymd', strtotime( $date_range->end_date ) ) ) . '000';
		$reports_chart_data['average_sales'] = (float)$row->average_sales;
		
		if($row->average_type == "monthly"){		
			$reports_chart_data['barwidth'] = 60 * 60 * 24 * 7 * 4 * 1000;
		}
		else{			
			$reports_chart_data['barwidth'] = 60 * 60 * 24 * 1000;
		}

		
		$reports_chart_data_json = json_encode($reports_chart_data);
		//var_dump($reports_chart_data_json);
		return $reports_chart_data_json;
	}

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}