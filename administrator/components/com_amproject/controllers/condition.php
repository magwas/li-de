<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Amproject
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.application.component.form');

/**
 * AmprojectCondition Controller
 *
 * @package    Amproject
 * @subpackage Controllers
 */
class AmprojectControllerCondition extends AmprojectController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'condition';
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	/**
	 * form refresh (change type or table_type)
	 *      
   */
   public function refresh() {
     JSession::checkToken() or die( 'Invalid Token' ); 
     $view = $this->getView($this->_viewname,'html');
     $view->Form = JForm::getInstance($this->_viewname,
        JPATH_ADMINISTRATOR.DS.'components'.DS.'com_'.$this->_comname.DS.'models'.DS.'forms'.DS.$this->_viewname.'.xml',
        array('control' => 'jform'));
     $jform = JRequest::getVar('jform');
     $data = JArrayHelper::toObject($jform);
     $view->set('item', $data);
     $view->setLayout('form');
     $view->display(); 
   }
  /**
   * save task (tulajdonos filter kezeléssel, hibakezeléssel)
   * @JRequest form fields values in jfom[]
   * @return void   
   */         
   public function save() {
      JSession::checkToken() or die( 'Invalid Token' );
      $model = $this->getModel($this->_viewname);
      $jform = JRequest::getVar('jform');
      $data = JArrayHelper::toObject($jform);
      $table = JRequest::getVar('table',$this->_viewname);
      $tableid = JRequest::getVar('tableid',0);
      if ($model->store($data)) {
         $this->setMessage(JText::_('COM_AMPROJECT_CONDITION_SAVED'));
         $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view='.$this->_viewname.
            '&table='.$table.'&tableid='.$tableid);
      } else {
         echo '<div class="alert alert-error"><h4>'.$model->getError().'</h4></div>';
         JRequest::setVar('edit', ($data->id > 0));
         $view = $this->getView($this->_viewname,'html');
         $view->setLayout('form');
         $view->set('item',$data);
         $view->set('Form', JForm::getInstance(
             $this->_viewname,
             'components/com_'.$this->comname.'/models/forms/'.$this->_viewname.'.xml',
             array('control' => 'jform')
             )
         );  
         $view->display();
      }
   }
	
	
}// class
?>