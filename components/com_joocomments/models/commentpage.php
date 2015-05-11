<?php
/*
 * v1.0.3
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport ( 'joomla.application.component.model' );

class JooCommentsModelCommentpage extends JModel {
function retriveComments($article_id){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('c.name ,c.email, c.comment,c.publish_date');
		$query->from('#__joocomments as c');
		$query->where('published=1 and article_id='.(int)$article_id);
		$app= JFactory::getApplication();
		$params= $app->getParams();
		$order=$params->get( 'frontend-comment_order', '0' );
		if($order=='0'){
			$query->order('publish_date desc,id desc');
		}else{
			$query->order('publish_date asc,id asc');
		}
		$db->setQuery($query);
		return $db->loadAssocList();
	}
}