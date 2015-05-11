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
 
class com_joocommentsInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' .'It is installing'. '</p>';
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' .'It is uninstalling'. '</p>';
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		// $parent is the class calling this method
		echo '<p><strong>' .'Make sure you update the JooComments content plugin and Install JooComments system plugin' . '</strong></p>';
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
	
	$jversion = new JVersion();
	if( version_compare( $jversion->getShortVersion(), '1.6', 'lt' ) ) {
		Jerror::raiseWarning(null, 'Cannot install com_joocomment in a Joomla release prior to 1.6');
		return false;
	}
		$tableName='#__joocomments';
		// if update then only do the following check
		if($type=='update'){
			$db = JFactory::getDBO();
			$results=$db->getTableColumns($tableName);
			if(!array_key_exists('publish_date', $results)){
			// worried, cause the installing guy perhaps installed 1.0.0 and then 1.0.1 which is why 
			// published_date is not there. Let create that here.
			$query='ALTER TABLE #__joocomments ADD COLUMN publish_date datetime NOT NULL DEFAULT '.'\'0000-00-00 00:00:00\'';
			$db->setQuery($query);
			$db->query();
			echo 'log: publish_date added.';
			}
			if(array_key_exists('article_title',$results)){
			// so article_title column was installed may be because the installer guy installed 1.0.0 and then 1.0.1
			// whatever lets remove this column , we don't need this column.
			$query='ALTER TABLE #__joocomments DROP COLUMN article_title';
			$db->setQuery($query);
			$db->query();
			echo 'log: article_title, unnecesary column removed.';
			}
		}
		echo '<p>' . JText::_('It is prelight'. $type) . '</p>';
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		if ($type == 'install' || $type=='update') {
           $db = &JFactory::getDBO();
           $query  = $db->getQuery(true);
           $query->update('#__extensions');
           $defaults = '{"frontend-comment_order":"0","frontend-comment_feature_link":"1","frontend-comment_category_link":"1","frontend-comment_count_in_link":"1","gravatar_enabled":"1","gravatar_icon":"mm","captcha_enabled":"0","captcha_foreground_color":"FF2864","captcha_background_color":"FFFFFF","captcha_noise_type":"0","email_administrator_notification":"0","email_administrator_value":"0","autoapprove_administrator":"1"}'; // JSON format for the parameters
           $query->set("params = '" . $defaults . "'");      
           $query->where("name = 'joocomments'");
           $db->setQuery($query);
           $db->query();
		    echo '<p>' . JText::_('Configuration saved successfully' . $type ) . '</p>';
       } 
	}
}
