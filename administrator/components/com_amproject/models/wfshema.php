  <?php
 defined('_JEXEC') or die('Restricted access');
/**
* @version		$Id:wfshema.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Models
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
 defined('_JEXEC') or die('Restricted access');
/**
 * AmprojectModelWfshema 
 * @author Fogler Tibor
 */
 
 
class AmprojectModelWfshema  extends AmprojectModel { 

	
	
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

	protected function _buildQuery() {
 		return parent::_buildQuery();
	}
		
	/**
	* Method to build the Order Clause
	*
	* @access private
	* @return string orderby	
	*/
	
	protected function _buildContentOrderBy() 
	{
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
    
    $product = JRequest::getVar('product','');
    if ($product != '') {
			$this->_query->where('a.product_id = '. $this->_db->Quote($product));			
    }
		
	}
	
}
?>