<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorlds View
 */
class JooCommentsViewSettings extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null) 
	{	
		
		$form		= $this->get('Form');
		//echo $form;
		$component	= $this->get('Component');
		$categoryItems=$this->get('item');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Bind the form to the data.
		if ($form && $component->params) {
			$form->bind($component->params);
		}

		$this->assignRef('form',		$form);
		$this->assignRef('component',	$component);

		$this->document->setTitle(JText::_('JGLOBAL_EDIT_PREFERENCES'));
		$this->	addToolBar();
		parent::display($tpl);
		//JRequest::setVar('hidemainmenu', true);
 
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_JOOCOMMENTS_VIEW_HEADER_CONFIGURATION'), 'config.png');
		JToolBarHelper::apply('settings.apply');
		JToolBarHelper::save('settings.save'); 
		JToolBarHelper::cancel('settings.cancel');
	}

}
