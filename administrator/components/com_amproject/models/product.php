  <?php
 defined('_JEXEC') or die('Restricted access');
/**
* @version		$Id:product.php  1 2014-12-30 07:54:22Z FT $
* @package		Amproject
* @subpackage 	Models
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
 defined('_JEXEC') or die('Restricted access');
/**
 * AmprojectModelProduct 
 * @author Fogler Tibor
 */
 
 
class AmprojectModelProduct  extends AmprojectModel { 
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
	protected function _buildContentWhere() {
		$app = &JFactory::getApplication('');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->getDefaultFilter(), 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', 'desc', 'word');
		$search = $app ->getUserStateFromRequest($context . 'search', 'search', '', 'string');
		if ($search) {
			$this->_query->where('LOWER(a.title) LIKE ' . $this->_db->Quote('%' . $search . '%'));			
		}
	}
  /**
   * productomhoz tartozó események (alrekordokhoz is!)
   * @param integer $id  product azonositó
   * @return array of record /id,title, type, time, user/
   */
   public function getProductEvents($id) {
     $result = array();
     $db = JFactory::getDBO();
     $db->setQuery('
     /* product események */
     SELECT e.id, 
            concat(p.title," ","'.JText::_('PRODUCT').'") title,
            e.type,
            e.time,
            u.name user
     FROM #__ampm_events e
     LEFT OUTER JOIN #__ampm_product p ON p.id = e.table_id
     LEFT OUTER JOIN #__users u ON u.id = e.user_id
     WHERE e.tablename = "#__ampm_product" AND p.id = "'.$id.'"       
     /* wfshema események */
     UNION ALL
     SELECT e.id, 
            concat(w.title," ","'.JText::_('WFSHEMA').'") title,
            e.type,
            e.time,
            u.name user
     FROM #__ampm_events e
     LEFT OUTER JOIN #__ampm_wfshema w ON w.id = e.table_id
     LEFT OUTER JOIN #__ampm_product p ON p.id = w.product_id
     LEFT OUTER JOIN #__users u ON u.id = e.user_id
     WHERE e.tablename = "#__ampm_wfshema" AND p.id = "'.$id.'"       
     /* wfshema-condition események */
     UNION ALL
     SELECT e.id, 
            concat(w.title," ","'.JText::_('CONDITION').'") title,
            e.type,
            e.time,
            u.name user
     FROM #__ampm_events e
     LEFT OUTER JOIN #__ampm_condition c ON c.id = e.table_id AND c.table_type="#__ampm_wfshema"
     LEFT OUTER JOIN #__ampm_wfshema w ON w.id = c.table_id 
     LEFT OUTER JOIN #__ampm_product p ON p.id = w.product_id
     LEFT OUTER JOIN #__users u ON u.id = e.user_id
     WHERE e.tablename = "#__ampm_condition" AND p.id = "'.$id.'"       
     /* taskshema események */
     UNION ALL
     SELECT e.id, 
            concat(w.title,"<br />",t.title," ","'.JText::_('TASKSHEMA').'") title,
            e.type,
            e.time,
            u.name user
     FROM #__ampm_events e
     LEFT OUTER JOIN #__ampm_taskshema t ON t.id = e.table_id
     LEFT OUTER JOIN #__ampm_wfshema w ON w.id = t.wfshema_id 
     LEFT OUTER JOIN #__ampm_product p ON p.id = w.product_id
     LEFT OUTER JOIN #__users u ON u.id = e.user_id
     WHERE e.tablename = "#__ampm_taskshema" AND p.id = "'.$id.'"       
     /* taskshema-condition eseméynek */
     UNION ALL
     SELECT e.id, 
            concat(w.title,"<br />",t.title," ","'.JText::_('TASKSHEMA').'") title,
            e.type,
            e.time,
            u.name user
     FROM #__ampm_events e
     LEFT OUTER JOIN #__ampm_condition c ON c.id = e.table_id AND c.table_type="#__ampm_taskshema" 
     LEFT OUTER JOIN #__ampm_taskshema t ON t.id = c.table_id
     LEFT OUTER JOIN #__ampm_wfshema w ON w.id = t.wfshema_id 
     LEFT OUTER JOIN #__ampm_product p ON p.id = w.product_id
     LEFT OUTER JOIN #__users u ON u.id = e.user_id
     WHERE e.tablename = "#__ampm_condition" AND p.id = "'.$id.'"       
     
     ORDER BY 4
     ');
     $result = $db->loadObjectList();
     return $result;
   }            
}
?>