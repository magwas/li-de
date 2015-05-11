<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class JooCommentsViewArticleSettings extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		$id		= JRequest::getInt('parentCategory');
		$model	= $this->getModel('ArticleSettings');
		$articleItems=$model->retriveData($id);

		//var_dump($articleItems,'Item');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		//$pagination = $this->get('Pagination');
		$this->assignRef('items',$articleItems);
		//$this->addToolBar();
		parent::display($tpl);
		//JRequest::setVar('hidemainmenu', true);

	}
	protected function addToolBar() 
	{
		echo JHtml::image('/toolbar/icon-32-publish.png', $alt,$attrib,true,false);
		//JToolBarHelper::title(JText::_('Comment Management'));
		echo '<script>alert(\''.JToolBarHelper::custom('comments.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true).'\');</script>';
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'comments.delete','JTOOLBAR_DELETE');
		
	}

}
