<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_amproject/tables');

class AmprojectModelResurcelist extends JModelList
{
	public function __construct($config = array())
	{		
	
		parent::__construct($config);		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('resurcelist.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('resurcelist.id');

		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()
	{
		
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query->select('a.*');
		$query->from('#__ampm_resurce as a');
					
		return $query;
	}	
}