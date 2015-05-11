<?php


jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelSzavaztam extends JModelList {
	public function __construct($config = array())
	{		
	
		parent::__construct($config);		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$app = JFactory::getApplication();
			$id = JRequest::getVar('id', 0, '', 'int');
			$this->setState('szavazasoklist.id', $id);			
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('szavazasoklist.id');
		return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()	{
    $w = explode('|',urldecode(JRequest::getVar('filterStr','')));
    $user = JFactory::getUser();
    $filterStr = $w[0];
    $filterAktiv = $w[1];
    if ($filterAktiv==1)
      $lezartLimit = 1;
    else
      $lezartLimit = 99;
    if ($filterStr != '') {
      $filterStr = ' and sz.megnevezes like "%'.$filterStr.'%"';
    }  
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);			
		$catid = (int) $this->getState('authorlist.id', 1);		
		$query = '
/* szavazások ahol szavaztam */
/* ========================================== */
SELECT sz.*
FROM #__szavazasok sz
INNER join #__temakorok te ON te.id = sz.temakor_id
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE szk.user_id="'.$user->id.'" '.$filterStr;
    if (JRequest::getVar('order')=='')
      $query .= ' order by 1 ASC, 6 DESC';
    else if (JRequest::getVar('order','1')=='1')
      $query .= ' order by '.JRequest::getVar('order','1').' ASC, 6 DESC';
    else   
      $query .= ' order by '.JRequest::getVar('order','1').' DESC, 6 DESC';
      
    //DBG echo '<hr>'.$query.'<hr>';  
      
    return $query;  
	}
  /**
   * get total record count
   * @return integer   
   */      
  public function getTotal($filterStr='') {
     $result = 0;
     $db = JFactory::getDBO();
     $db->setQuery('
    /* szavazások ahol szavaztam */
/* ==================================== */
/* ahol minden regisztrált szavazhat */
SELECT sz.id
FROM #__szavazasok sz
INNER join #__temakorok te ON te.id = sz.temakor_id
LEFT OUTER JOIN #__szavazok szk ON szk.szavazas_id = sz.id AND szk.user_id = '.$user->id.'
WHERE sz.user_id = "'.$user->id.'" '.$filterStr);
     
     //DBG echo '<hr>'.$db->getQuery().'<hr>';
     
     $res = $db->loadObejctList();
     $result = count($res);
     return $result;
  }
}