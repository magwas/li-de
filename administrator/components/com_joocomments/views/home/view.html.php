<?php
/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

class JooCommentsViewHome extends JView
{
	function display($tpl = null) 
	{
		$app=JFactory::getConfig();
		$extension = JTable::getInstance('extension');

		$eid=$extension->find(array('element'=>'com_joocomments',
								'type'=>'component',
		));
		if($eid){
			$extension->load($eid);
			$data = json_decode($extension->manifest_cache, true);
		}
		
		//check if php curl is installed.
		if (function_exists('curl_init') && function_exists ('curl_version')) {
			$curl = curl_init('http://www.bullraider.com/phocadownload/joocomments-verison.json');
			$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
			);
			curl_setopt_array( $curl, $options );
			$result=curl_exec($curl);
			$code = curl_getinfo ($curl, CURLINFO_HTTP_CODE);
			$message='';
			if($code!='200'){
			 Jlog::add('Error Code in reaching BullRaider.com for version details: '.$code, JLog::DEBUG,"com_joocomments");
			 $message='<p class="error">Error in fetching details for available version;see your joocomments.php file in log folder</p>';
			}else{
				$dataJson = json_decode($result, true);
				if(version_compare($dataJson['version'], $data['version'], '>') == 1)
				{
					$message='<p class="error">A new version ('.$dataJson['version'].') is available</p>';
				}else{
					$message='<p class="success">You have the latest version</p>';
				}
			}}else{
				Jlog::add('Perhaps the curl is not enabled or avialable in your host', JLog::DEBUG,"com_joocomments");
				$message='<p class="error">Error in fetching details for available version;see your joocomments.php file in log folder</p>';
			}
			$this->assignRef('message', $message);
			$this->assignRef('curVersion',$data['version']);
			$this->assignRef('availVersion', $dataJson['version']);

			$this->	addToolBar();
			parent::display($tpl);
	}
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_JOOCOMMENTS_VIEW_HEADER_WELCOME'), 'frontpage.png');
		
	}
	
}
