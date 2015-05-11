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
 * AmprojectProduct Controller
 *
 * @package    Amproject
 * @subpackage Controllers
 */
class AmprojectControllerProduct extends AmprojectController
{
	/**
	 * Constructor
	 */
	protected $_viewname = 'product'; 
	 
	public function __construct($config = array ()) 
	{
		parent :: __construct($config);
		JRequest :: setVar('view', $this->_viewname);

	}
	
  /**
	 * user click the wfshemas button is browser
	 * @JREquest cid array of product'id  enabled only one item!
	 * @return void
	 */            
	public function wfshemas() {
    $cid = JRequest::getVar('cid');
    $id = $cid[0];
    if (count($cid) > 1) {
       $this->setMessage(JText::_('COM_AMPROJECT_SELECT_ONLY_ONE'));
       $this->setRedirect(JURI::current().'?option=com_amproject&view=product');
       $this->redirect();    
    } else {
       $this->setRedirect(JURI::current().'?option=com_amproject&view=wfshema&product='.$cid[0]);
       $this->redirect();    
    }
  }

  public function orderup() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('product');
		$model->move(-1);

		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname);
	}

	public function orderdown() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$model = $this->getModel('product');
		$model->move(1);

		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname);
	}

	public function saveorder() 
	{
		// Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');

		$cid = JRequest :: getVar('cid', array (), 'post', 'array');
		$order = JRequest :: getVar('order', array (), 'post', 'array');
		JArrayHelper :: toInteger($cid);
		JArrayHelper :: toInteger($order);

		$model = $this->getModel('product');
		$model->saveorder($cid, $order);

		$msg = JText :: _('New ordering saved');
		$this->setRedirect('index.php?option=com_amproject&view='.$this->_viewname, $msg);
	}
  /**
   * felhasználó az "events" gombra kattintott
   * @JRequest: array cid[]   
   * @return void
   */         
  public function events() {
    $cid = JRequest::getVar('cid');
    if (count($cid) > 1) {
       $this->setMessage(JText::_('COM_AMPROJECT_SELECT_ONLY_ONE'));
       $this->setRedirect(JURI::current().'?option=com_amproject&view=product');
       $this->redirect();    
    } else {
      $id = $cid[0];
      $model = $this->getModel('product');
      $items = $model->getProductEvents($id);
      $item = $model->getItem($id);
      $view = $this->getView('product','html');
      $view->set('Item',$item);
      $view->set('Items',$items);
      $view->setLayout('events');
      $view->display();
    }
}	
}// class
?>