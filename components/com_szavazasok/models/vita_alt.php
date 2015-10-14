<?php
/**
  * azon szavazaspok amik vita1 statuszban vannak 
  */

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_szavazasok/tables');

class SzavazasokModelVita_alt extends JModelList {
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
	  $filterStr = ' and (sz.megnevezes like "%'.$filterStr.'%" or sz.cimkek like "%'.$filterStr.'%") ';
    }  
	$db		= $this->getDbo();
	$query	= $db->getQuery(true);			
	$catid = (int) $this->getState('authorlist.id', 1);		
	$query = '
/* szavazások amik jelenleg vita1 állapotban vannak */
/* ================================================ */
SELECT sz.megnevezes, sz.vita1, sz.vita2, sz.szavazas, sz.lezart, sz.szavazas_vege, sz.titkos, sz.vita1_vege,
  sz.id, sz.temakor_id
FROM #__szavazasok sz
left outer join #__temakorok as t 
   on t.id = sz.temakor_id	
left outer join #__tagok ta
   on ta.temakor_id = sz.temakor_id and ta.user_id = "'.$user->id.'"			 
WHERE (sz.vita1=1) '.$filterStr;
	// aktuális user láthatja ezt a szavazást?
	$query .= ' and ((t.lathatosag = 0) or
	                 (t.lathatosag = 1 and "'.$user->id.'" > 0) or
					 (ta.user_id is not null)
					)';
    $query .= ' order by '.JRequest::getVar('order','6');

	// echo '<pre>'.$query.'</pre><br />';
	
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
/* szavazások amik vita1 statuszban vannak */
SELECT sz.id
FROM #__szavazasok sz
left outer join #__temakorok as t 
   on t.id = sz.temakor_id	
left outer join #__tagok ta
   on ta.temakor_id = sz.temakor_id and ta.user_id = "'.$user->id.'"			 
WHERE (sz.vita1=1) '.$filterStr);
	// aktuális user láthatja ezt a szavazást?
	$query .= ' and ((t.lathatosag = 0) or
	                 (t.lathatosag = 1 and "'.$user->id.'" > 0) or
					 (ta.user_id is not null)
					)';
    $query .= ' order by '.JRequest::getVar('order','6');

     $res = $db->loadObjectList();
     $result = count($res);
     return $result;
  }
}