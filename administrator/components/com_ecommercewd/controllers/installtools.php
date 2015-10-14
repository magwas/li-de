<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerInstalltools extends EcommercewdController {
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
	public function installtools(){
		// validate file type	
		if ($_FILES["zip_file"]['type'] != 'application/octet-stream' && $_FILES["zip_file"]['type'] != 'application/x-zip-compressed' && $_FILES["zip_file"]['type'] != 'application/zip' && $_FILES["zip_file"]['type'] != 'multipart/x-zip' && $_FILES["zip_file"]['type'] != 'application/zip-compressed'){
			$msg = WDFText::get("MSG_ERROR_INSTALLING_TOOL_INCORRECT_FILE_TYPE"); 
			WDFHelper::redirect(WDFInput::get_controller(),'','','',$msg,'error');				
		}
		$is_invalid = false;
		if($_FILES["zip_file"]["name"]) {
			$toolname = $_FILES["zip_file"]["name"];
			$source = $_FILES["zip_file"]["tmp_name"];

			$name =  basename ($toolname, '.zip');
			$name = preg_replace('#[0-9)( ]*#', '', $name);
			$path = 'components/com_'.WDFHelper::get_com_name().'/';  

			$targetdir = $path . $name; 
			$targetzip = $path . $toolname; 
		 
			if (is_dir($targetdir))  
				WDFTool::rmdir_recursive($targetdir);
 
			mkdir($targetdir,0777);		

			move_uploaded_file($source, $targetzip);		
			$zip = new ZipArchive();
			$x = $zip->open($targetzip);  // open the zip file to extract
			if ($x === true) {
				$zip->extractTo($targetdir); // place in the directory with same name  
				$zip->close();
	 
				unlink($targetzip);
			}

			// check xml manifest file
			if(!file_exists($targetdir.'/'.$name.'.xml')){
				$is_invalid = true;
				$msg = WDFText::get("MSG_ERROR_INSTALLING_TOOL_COULD_NOT_FIND_XML_FILE"); 
			}
			else{
				// Get XML file
				// check xml required tags
				$xml = simplexml_load_file($targetdir.'/'.$name.'.xml');
				$xml_fields = array_keys(get_object_vars($xml));
				if(!in_array('type',$xml_fields) && !in_array('createToolbarIcon',$xml_fields)){
					$is_invalid = true;
					$msg = WDFText::get("MSG_ERROR_INSTALLING_TOOL_COULD_NOT_FIND_XML_FILE");
				}
				else{			
					$types = array('PaymentSystem','ExportImport','ExportReports','PDFInvoice');
					if(!in_array($xml->type, $types)){
						$is_invalid = true;
						$msg = WDFText::get("MSG_ERROR_INSTALLING_TOOL_COULD_NOT_FIND_XML_FILE");
					}
				}
			}
			
			if($is_invalid == true){
				chmod($targetdir,0777);
				WDFTool::rmdir_recursive($targetdir);				
				WDFHelper::redirect(WDFInput::get_controller(),'','','',$msg,'error');
			}
			
			copy($targetdir.'/'.$name.'.xml', "components/com_".WDFHelper::get_com_name()."/".$name.'.xml');
			foreach ( $xml->admin->folder as $folder ){
				$this->rmove($targetdir."/admin/".$folder, "components/com_".WDFHelper::get_com_name()."/".$folder); 
			}
			foreach ( $xml->site->folder as $folder ){
				$this->rmove($targetdir."/site/".$folder, JPATH_SITE."/components/com_".WDFHelper::get_com_name()."/".$folder); 
			}
			
			chmod($targetdir,0777);
			WDFTool::rmdir_recursive($targetdir);
			
			$tools = WDFTool::get_tools( array() );
			if( !in_array( $name, $tools ) ){			
				$db = JFactory::getDBO();							
				$query = "INSERT INTO #__ecommercewd_tools (`id`,`name`,`description`,`tool_type`,`creation_date`,`author_url`,`published`,`create_toolbar_icon`)  
				VALUES ('','".$xml->name."','".$xml->description."','".$xml->type."','".$xml->creationDate."','".$xml->authorUrl."','1','".$xml->createToolbarIcon."')";
				$db->setQuery( $query);
				$db->Query();
				$type = $xml->type;
				switch($type){
					case 'PaymentSystem':
						$options  = '{';
						foreach ( $xml->options->option as $option ){
							$options .= '\"'.$option.'\":\"\",';
						}
						$short_name = $xml->info->shortname;
						switch($short_name){
							case 'paypalexpress':
							case 'authorizenetsim':							
								$options = substr($options,0,-1);
								$options .= '}';
							break;
							case 'stripe':
							case 'authorizenetaim':
							case 'authorizenetdpm':
								$options .= '\"options\":\"\"}';
							break;															
						}
						
						$query = $db->getQuery(true);	
						$query->clear();
						$query->select('MAX(id)');
						$query->from('#__ecommercewd_tools');
						$db->setQuery($query);
						$tool_id = $db->loadResult();
						
						$query = "INSERT INTO `#__ecommercewd_payments` (`id`,`tool_id`, `name`, `short_name`, `base_name`,`ordering`, `options`, `published`)
						VALUES ('','".$tool_id."', '".$xml->info->name."','".$xml->info->shortname."','".$xml->info->basename."', '', '".$options."', 1)";
						$db->setQuery( $query);
						$db->Query();
					break;					
				}
			}

		}
				
		$msg = WDFText::get("MSG_INSTALLING_TOOL_WAS_SUCCESSFUL"); 
 		WDFHelper::redirect(WDFInput::get_controller(),'','','',$msg);	
	}

	////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////	
	private function rmove($src, $dest){ 
		// If the destination directory does not exist create it
		if(!is_dir($dest)) { 
			if(!mkdir($dest)) {
				return false;
			}    
		}	 
		// Open the source directory to read in files
		$i = new DirectoryIterator($src);
		foreach($i as $f) {
			if($f->isFile()) 
				rename($f->getRealPath(), "$dest/" . $f->getFilename());
			else if(!$f->isDot() && $f->isDir()) 
				$this->rmove($f->getRealPath(), "$dest/$f");
		}

	}
	////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}