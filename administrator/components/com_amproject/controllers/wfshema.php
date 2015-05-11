<?php
/**
* @version		$Id: default_controller.php 96 2011-08-11 06:59:32Z michel $
* @package		Amproject
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
* 
* amProjekt rendszer müveleti sorrend tervek
* tulajdonos rekord: product (JRequest-ben érkezhet az id-je 'product' néven))
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * AmprojectWfshema Controller
 *
 * @package    Amproject
 * @subpackage Controllers
 */
class AmprojectControllerWfshema extends AmprojectController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'wfshema'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $product = JRequest::getVar('product','');
		$model = $this->getModel($this->_viewname);
		$model->move(-1);
		$this->setRedirect('index.php?option=com_'.$this->_comname.'&view='.$this->_viewname.'&product='.$product);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $product = JRequest::getVar('product','');
		$model = $this->getModel($this->_viewname);
		$model->move(1);
		$this->setRedirect('index.php?option=com_'.$this->_comname.'&view='.$this->_viewname.'&product='.$product);
	}

	public function saveorder() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		$order = JRequest :: getVar('order', array (), 'post', 'array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		$model = $this->getModel($this->_viewname);
		$model->saveorder($cid, $order);
    $product = JRequest::getVar('product','');
		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=com_'.$this->_comname.'&view='.$this->_viewname.'&product='.$product, $msg);
	}	
  
  /**
	 * user click the conditions button is browser
	 * @JREquest cid array  array of product'id enabled only one item!
	 * @return void
	 */            
  public function conditions() {
    //DBG foreach ($_POST as $fn => $fv) echo $fn.'='.$fv.'<br />';
    $cid = JRequest::getVar('cid');
    $product = JRequest::getVar('product','');
    $id = $cid[0];
    if (count($cid) > 1) {
       $this->setMessage(JText::_('COM_AMPROJECT_SELECT_ONLY_ONE'));
       $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view='.$this->_viewname.'&product='.$product);
       $this->redirect();    
    } else {
       $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view=condition&table=wfshema&tableid='.$cid[0].'&product='.$product);
       $this->redirect();    
    }
  }
  
  
  /**
	 * user click the taskshemas button is browser
	 * @JREquest cid array of product'id  enabled only one item!
	 * @return void
	 */            
	public function taskshema() {
    $cid = JRequest::getVar('cid');
    $product = JRequest::getVar('product','');
    $id = $cid[0];
    if (count($cid) > 1) {
       $this->setMessage(JText::_('COM_AMPROJECT_SELECT_ONLY_ONE'));
       $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view='.$this->_viewname.'&product='.$product);
       $this->redirect();    
    } else {
       $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view=taskshema&wfshema='.$cid[0]);
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
      $product = JRequest::getVar('product','');
      if ($model->store($data)) {
         $this->setMessage(JText::_('COM_AMPROJECT_WFSHEMA_SAVED'));
         $this->setRedirect(JURI::current().'?option=com_'.$this->_comname.'&view='.$this->_viewname.'&product='.$product);
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