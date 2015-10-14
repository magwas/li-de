<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerTools extends EcommercewdController {
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
	public function remove() {			
		$ids = WDFInput::get_checked_ids();
		if (empty($ids) == true) {
			return false;
		}	
		$this->remove_files( $ids );

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		// remove row from tools table
		WDFDb::remove_rows('tools', $ids);
		
		// remove row from payments table
		foreach($ids as $id){
			$query->clear();
			$query->delete();
			$query->from('#__ecommercewd_payments');
			$query->where('tool_id = "'. $id.'" ');
			$db->setQuery($query);
			$db->query();

			if ($db->getErrorNum()) {
				echo $db->getErrorMsg();
				die();
			}	
		}
		$msg = WDFText::get("MSG_UNINSTALLING_TOOL_WAS_SUCCESSFUL");
		WDFHelper::redirect(WDFInput::get_controller(),'','','',$msg);
	
	}

	public function publish() {
		WDFDb::set_checked_rows_data('tools', 'published', 1);
		$model = WDFHelper::get_model();	
		$selected_payment_types = $model->get_selected_payment_ids(WDFInput::get_checked_ids()); 
		WDFDb::set_checked_rows_data('payments', 'published', 1, $selected_payment_types);
		
		WDFHelper::redirect();
	}
	
	public function unpublish() {
		WDFDb::set_checked_rows_data('tools', 'published', 0);
		$model = WDFHelper::get_model();	
		$selected_payment_types = $model->get_selected_payment_ids(WDFInput::get_checked_ids()); 
		WDFDb::set_checked_rows_data('payments', 'published', 0, $selected_payment_types);
		WDFHelper::redirect();
	}
	
	////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
		
	private function check_types( $dir ){
		if( $dir == "controllers" or $dir == "models" )
			return true;
			
		return false;
	}
	
	private function remove_files( $ids ){
		$dirs = array( "admin", "site" );
		$where_query = array('id IN (' . implode(',', $ids) . ')');
		$tools = WDFTool::get_tools( $where_query );

		foreach( $tools as $tool ){
			$tool_name = explode( '_', $tool );
			$tool_name = $tool_name[1];
			
			// Get XML file
			$xml = simplexml_load_file("components/com_".WDFHelper::get_com_name()."/".$tool.'.xml');	
			foreach( $dirs as $dir ){
				$path = ( $dir == "admin" ) ? "components/com_".WDFHelper::get_com_name()."/" : JPATH_SITE."/components/com_".WDFHelper::get_com_name()."/";	
				foreach ( $xml->$dir->folder as $folder ){
					$sub_path = '';
					if( isset($folder['path']) == true ){
						$sub_path = $folder['path'].'/';
					}
					if( !$this->check_types( $folder ) ){
						chmod( $path.$folder."/".$sub_path.$tool_name, 0777 );
						WDFTool::rmdir_recursive( $path.$folder."/".$sub_path.$tool_name );
					}
					else
						unlink($path.$folder."/".$tool_name.".php");
					
				}
			}				
			unlink("components/com_".WDFHelper::get_com_name()."/".$tool.'.xml');	
		}
	
	}

	////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}