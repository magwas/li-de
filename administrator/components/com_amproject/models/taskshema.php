  <?php
 defined('_JEXEC') or die('Restricted access');
/**
* @version		$Id:taskshema.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Models
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
 defined('_JEXEC') or die('Restricted access');
/**
 * AmprojectModelTaskshema 
 * @author Fogler Tibor
 */
 
 
class AmprojectModelTaskshema  extends AmprojectModel { 

	
	
	protected $_default_filter = 'a.title';   

/**
 * Constructor
 */
	
	public function __construct()
	{
		parent::__construct();

	}

	/**
	* Method to build the query
	*
	* @access private
	* @return string query	
	*/

	protected function _buildQuery()
	{
		return parent::_buildQuery();
	}
	
	/**
	 * Method to store the Item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	public function store($data)	{
    $newId = parent::store($data);
    $db = JFactory::getDBO();
    if (($data->id==0) | ($data->id=='')) {
       // default feltétel kreálása
       
       // order szerint elöző taskshema kiolvasása
       $db->setQuery('SELECT id,ordering
       from #__ampm_taskshema
       where wfshema_id="'.$data->wfshema_id.'" and ordering < "'.$data->ordering.'"
       order by ordering DESC');
       $res = $db->loadObjectList();
       if ($res) {
         // condition rekord kiirása
         $db->setQuery('insert into #__ampm_condition 
        	(`table_type`, 
        	`table_id`, 
        	`type`, 
        	`assigned_id`, 
        	`volume`
        	)
        	values
        	("#__ampm_taskshema", 
        	"'.$newId.'", 
        	33, 
        	"'.$res[0]->id.'", 
        	0);
        ');
        $db->query();
      }
    }
    return $newId;    
	}	

	/**
	* Method to build the Order Clause
	*
	* @access private
	* @return string orderby	
	*/
	protected function _buildContentOrderBy()	{
		$app = &JFactory::getApplication('');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->getDefaultFilter(), 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$this->_query->order($filter_order . ' ' . $filter_order_Dir );
	}
	
	/**
	* Method to build the Where Clause 
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentWhere() 
	{
		
		$app = &JFactory::getApplication('');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->getDefaultFilter(), 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
		$search = $app ->getUserStateFromRequest($context . 'search', 'search', '', 'string');
					
		if ($search) {
			$this->_query->where('LOWER(a.title) LIKE ' . $this->_db->Quote('%' . $search . '%'));			
		}

    $wfshema = JRequest::getVar('wfshema','');
    if ($wfshema != '') {
			$this->_query->where('a.wfshema_id = '. $this->_db->Quote($wfshema));			
    }
		
	}
	
}
?>