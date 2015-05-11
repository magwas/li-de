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

/**
 * AmprojectTaskshema Controller
 *
 * @package    Amproject
 * @subpackage Controllers
 */
class AmprojectControllerTaskshema extends AmprojectController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'taskshema'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $wfshema = JRequest::getVar('wfshema','');
		$model = $this->getModel('taskshema');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname.'&wfshema='.$wfshema);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $wfshema = JRequest::getVar('wfshema','');
		$model = $this->getModel('taskshema');
		$model->move(1);
		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname.'&wfshema='.$wfshema);
	}

	public function saveorder() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $wfshema = JRequest::getVar('wfshema','');
		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		$order = JRequest :: getVar('order', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);
		JArrayHelper :: toInteger($order);
		$model = $this->getModel('taskshema');
		$model->saveorder($cid, $order);
		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname.'&wfshema='.$wfshema, $msg);
	}	
  /**
	 * user click the conditions button is browser
	 * @JREquest cid array  array of task'id enabled only one item!
	 * @return void
	 */            
  public function conditions() {
    //DBG foreach ($_POST as $fn => $fv) echo $fn.'='.$fv.'<br />';
    $cid = JRequest::getVar('cid');
    $wfshema = JRequest::getVar('wfshema','');
    $id = $cid[0];
    if (count($cid) > 1) {
       $this->setMessage(JText::_('COM_AMPROJECT_SELECT_ONLY_ONE'));
       $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view='.$this->_viewname.'&wfshema='.$wfshema);
       $this->redirect();    
    } else {
       $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view=condition&table=taskshema&tableid='.$cid[0].'&wfshema='.$wfshema);
       $this->redirect();    
    }
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
      $wfshema = JRequest::getVar('wfshema','');
      if ($model->store($data)) {
         $this->setMessage(JText::_('COM_AMPROJECT_TASKSHEMA_SAVED'));
         $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view='.$this->_viewname.'&wfshema='.$wfshema);
      } else {
         echo '<div class="alert alert-error"><h4>'.$model->getError().'</h4></div>';
         JRequest::setVar('edit', ($data->id > 0));
         $view = $this->getView($this->_viewname,'html');
         $view->setLayout('form');
         $view->set('item',$data);
         $view->set('Form', JForm::getInstance(
                               $this->_viewname,
                               'components/com_'.$this->_comname.'/models/forms/'.$this->_viewname.'.xml',
                               array('control' => 'jform')
                            )
         );  
         $view->display();
      }
   }
}// class
?>