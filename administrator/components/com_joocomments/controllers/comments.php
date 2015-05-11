<?php
/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');

class JooCommentsControllerComments extends JControllerAdmin
{
	protected	$option 		= 'com_joocomments';
	protected $view_list='unpublished';
	
	public function __construct($config = array())
	{
		parent::__construct($config);	
		
	
	}
	
	function publish(){
		$cid	= JRequest::getVar('cid', array(), '', 'array');
		$data	= array('publish' => 1, 'unpublish' => 0, 'archive'=> 2, 'trash' => -2, 'report'=>-3);
		$task 	= $this->getTask();
		$value	= JArrayHelper::getValue($data, $task, 0, 'int');
		if(value==1){
		$this->view_list='unpublished';
		}
		if($value==0){
			$this->view_list='published';
		}
		
		parent::publish();
	}
	function delete(){
		$this->view_list=JRequest::getString('view','home','get');
		parent::delete();
	}
	
	public function &getModel($name = 'comment')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}