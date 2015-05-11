<?php 
/**
* @version		$Id:Model.php 1 2014-12-30Z FT $
* @package		Amproject
* @subpackage 	Models
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
/**
 * Model
 * @author Michael Liebler
 */
jimport( 'joomla.application.component.model' );
class AmprojectModel  extends JModelLegacy { 
	/**
	 * Items data array
	 *
	 * @var array
	 */
	protected $_data = null;
	/**
	 * Items total
	 *
	 * @var integer
	 */
	protected $_total = null;
	/**
	 * ID
	 *
	 * @var integer
	 */
	protected $_id = null;
	/**
	 * Default Filter
	 *
	 * @var mixed
	 */
	protected $_default_filter = null;
	/**
	 * Default Filter
	 *
	 * @var mixed
	 */
	protected $_default_table = null;
	/**
	 * JQuery
	 *
	 * @var object
	 */
	protected $_query;
	/**
	 * JQuery
	 *
	 * @var object
	 */
	protected $_state_field;
	/**
	 * @var		string	The URL option for the component.	
	 */
	protected $option = null;
	/**
	 * @var		string	context	the context to find session data.	
	 */		
	protected $_context = null;
	/**
 	* Constructor
 	*/
	public function __construct()	{
		parent::__construct();
		$app = &JFactory::getApplication('administrator');
			// Guess the option from the class name (Option)Model(View).
		if (empty($this->option)) {
			$r = null;
			if (!preg_match('/(.*)Model/i', get_class($this), $r)) {
				JError::raiseError(500, JText::_('No Model Name'));
			}
			$this->option = 'com_'.strtolower($r[1]);
		}		
		$this->_query = $this->_db->getQuery(true); 
		$table = $this->getTable();
		if ($table) {
			$this->_default_table = $table->getTableName(); 
			if (isset($table->published))  $this->_state_field = 'published';
		}
		if (empty($this->_context)) {
			$this->_context = $this->option.'.'.$this->getName();
		}
		$array = JRequest :: getVar('cid', array (
			0
		), '', 'array');
		$edit = JRequest :: getVar('edit', true);
		if ($edit)
			$this->setId((int) $array[0]);
		// Get the pagination request variables
		$limit		= $app ->getUserStateFromRequest( $this->_context .'.limit', 'limit', $app->getCfg('list_limit', 0), 'int' );
		$limitstart	= $app ->getUserStateFromRequest( $this->_context .'.limitstart', 'limitstart', 0, 'int' );
		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	/**
	* Method to get the item identifier
	*
	* @access public
	* @return $_id int Item Identifier
	*/
	public function getId()	{		
		return $this->_id;
	}
	/**
	* Method to set the item identifier
	*
	* @access public
	* @param int Item identifier
	*/
	public function setId($id)	{
		// Set item id and wipe data
		$this->_id = $id;		
		$this->_data = null;
	}
	/**
	   * Return a  List of vendor-Items 
	   * @access	public 
	   * @return $_data array
	   */
	public function getData() {
		// Lets load the content if it doesn't already exist
	   
		if (empty($this->_data)) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_data;
		
	}
	
	public function getDefaultFilter() 
	{
		return $this->_default_filter;
	}
	/**
	 * Method to get the row form.
	 *
	 * @return	mixed	JForm object on success, false on failure.
	 * @since	1.6
	 */
	public function getForm($name = null)	{
		if (!$name) {
			$name = $this->getName();
		}
		// Initialize variables.
		$app = &JFactory::getApplication();
		// Get the form.
		$form = $this->_getForm($name, 'form', array('control' => 'jform'));
		JFormHelper::addRulePath(JPATH_COMPONENT_ADMINISTRATOR.'/models/rules');
		// Check for an error.
		if (JError::isError($form)) {
			$this->setError($form->getMessage());
			return false;
		}
		// Check the session for previously entered form data.
		$data = $app->getUserState($this->_context.'.edit.'.$name.'.data', array());
		// Bind the form data if present.
		if (!empty($data)) {
			$form->bind($data);
		}
		return $form;
	}	

	/**
	 * Method to get a form object.
	 *
	 * @param	string		$xml		The form data. Can be XML string if file flag is set to false.
	 * @param	array		$options	Optional array of parameters.
	 * @param	boolean		$clear		Optional argument to force load a new form.
	 * @return	mixed		JForm object on success, False on error.
	 */
	private function &_getForm($xml, $name = 'form', $options = array(), $clear = false){
		// Handle the optional arguments.
		$options['control']	= JArrayHelper::getValue($options, 'control', false);
		// Create a signature hash.
		$hash = md5($xml.serialize($options));
		// Check if we can use a previously loaded form.
		if (isset($this->_forms[$hash]) && !$clear) {
			return $this->_forms[$hash];
		}

		// Get the form.

		jimport('joomla.form.form');

		JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR.'/models/forms');
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR.'/models/fields');

		$form = JForm::getInstance($name, $xml, $options, false);
		// Check for an error.
		if (JError::isError($form)) {
			$this->setError($form->getMessage());
			$false = false;
			return $form;
		}


		// Store the form for later.
		$this->_forms[$hash] = $form;

		return $form;
	}
	/**
	 * Method to get an Item
	 *
	 * @access	public 
	 * @return $item array
	 */
	
	public function getItem() 
	{			
		$item = & $this->getTable();				
		$item->load($this->_id);
		if (isset($item->params)) {					
			$params = json_decode($item->params);					
			$item->params = new JObject();
			$item->params ->setProperties(JArrayHelper::fromObject($params));
		}
		return $item;
	}



   /**
    * Method to delete an Item
 	*
	* @access	public
    * @param  array of table'id 
    * @return $affected int
    */
     public function  delete($cid) 
     {
        //+ FT 2014.12.31. tábla canDdelete és delete használata
    		$item = & $this->getTable();
        if ($item->canDelete($cid)) {
          // create event records
          $db = JFactory::getDBO();
          $user = JFactory::getUser();
          foreach ($cid as $id) {
            $db->setQuery('SELECT * FROM '.$item->getTableName().' WHERE ID="'.$id.'"');
            $oldRec = $db->loadObject();
            $eventType = 'delete';
            $db->setQuery('INSERT INTO #__ampm_events 
        	  (`tablename`, 
        	   `table_id`, 
             `type`, 
        	   `user_id`, 
        	   `time`, 
        	   `newstate`,
             `oldrec`,
             `newrec`
        	   )
        	   VALUES
        	  ("'.$item->getTableName().'", 
        	   "'.$id.'", 
           	 "'.$eventType.'", 
        	   "'.$user->id.'", 
        	   "'.date('Y-m-d H:i:s').'",
             "0",
             '.$db->quote(json_encode($oldRec)).',
             "")
             ');
            $db->query();
          }
          $result = $item->delete($cid);
        } else {
          $this->setError($item->getError());
          $result = false;
        }  
        return $resut;
     }

/**
	 * Method to store the Item
	 *
	 * @access	public
	 * @param recordObject $data  képernyő field array   
	 * @return	boolean	True on success
	 */
	public function store($data)
	{
		$row =& $this->getTable();
    if ($data->id > 0) {
      $oldRow = $row->load($data->id);
    } else if ($data['id'] > 0) {
      $oldRow = $row->load($data['id']);
    } else {
      $oldRow = new stdClass();
    }
		/**
		 * Example: get text from editor 
		 * $Text  = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		 */
		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($row->getError());
			return false;
		}

		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($row->getError());
			return false;
		}
		
		/**
		 * Clean text for xhtml transitional compliance
		 * $row->text		= str_replace( '<br>', '<br />', $Text );
		 */
	
		// Store the table to the database
		
    if (!$row->store()) {
			$this->setError($row->getError());
			return false;
		}
    
    // create event record
    $user = JFactory::getUser();
    if ($data->id > 0) {
      $eventType = 'update';
    } else if ($data['id'] > 0) {
      $eventType = 'update';
    } else {
      $eventType = 'add';
    }
    if (isset($row->state)) {
      $newState = $row->state;
    } else {
      $newState = 0;
    }
    if ((isset($row->volume)) & ($data->id > 0)) {
      if ($row->volume != $oldRow->volume) {
        $eventType = 'volumeChange';
      }
    }
    if ((isset($row->volume)) & ($data['id'] > 0)) {
      if ($row->volume != $oldRow->volume) {
        $eventType = 'volumeChange';
      }
    }
    
    $db = JFactory::getDBO();
    $db->setQuery('INSERT INTO #__ampm_events 
	  (`tablename`, 
	   `table_id`, 
     `type`, 
	   `user_id`, 
	   `time`, 
	   `newstate`,
     `oldrec`,
     `newrec`
	   )
	   VALUES
	  ("'.$row->getTableName().'", 
	   "'.$row->id.'", 
   	 "'.$eventType.'", 
	   "'.$user->id.'", 
	   "'.date('Y-m-d H:i:s').'",
     "'.$newState.'",
     '.$db->quote(json_encode($oldRow)).',
     '.$db->quote(json_encode($row)).')
     ');
    $db->query();
    
		$this->setId($row->{$row->getKeyName()});
		return $row->{$row->getKeyName()};
	}	
 
	/**
	 * Method to get a pagination object 
	 *
	 * @access public
	 * @return integer
	 */
	public function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	

	/**
	 * Method to get the total number of  items
	 *
	 * @access public
	 * @return integer
	 */
	public function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}	
	
/**
  * Method to (un)publish an items
	*
	* @access public
	* @param array of table'id  
	* @return boolean True on success
	*/
	public function publish($cid = array (), $publish = 1)	{
		$user = & JFactory :: getUser();
		if ((count($cid) > 0) & ($cid[0]!='')) {
			JArrayHelper :: toInteger($cid);
			$cids = implode(',', $cid);
			$query = 'UPDATE '.$this->_default_table.' SET state = ' . (int) $publish . ' WHERE id IN ( ' . $cids . ' )';
			$this->_db->setQuery($query);
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

    // create event records
    $db = JFactory::getDBO();
    $user = JFactory::getUser();
    foreach ($cid as $id) {
          $eventType = 'update';
          $db->setQuery('INSERT INTO #__ampm_events 
      	  (`tablename`, 
      	   `table_id`, 
           `type`, 
      	   `user_id`, 
      	   `time`, 
      	   `newstate`
      	   )
      	   VALUES
      	  ("'.$this->_default_table.'", 
      	   "'.$id.'", 
         	 "'.$eventType.'", 
      	   "'.$user->id.'", 
      	   "'.date('Y-m-d H:i:s').'",
           "'.$publish.'" 
         	)');
          $db->query();
    }

		return true;
	}

	/**
	* Method to move a item
	*
	* @access public
	* @param array of table'id  
	* @return boolean True on success
	*/
	public function saveorder($cid, $order)	{
		$row = & $this->getTable();
		$groupings = array ();
		// update ordering values
		for ($i = 0; $i < count($cid); $i++) {
			$row->load((int) $cid[$i]);

			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * Method to move an item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	public function move($direction) {
		$row =& $this->getTable();
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		$table = $this->getTable();
		$where = "";
		if ($row->catid) {
			$where = ' catid = '.(int) $row->catid.' AND published >= 0 ';
		} 
		if (!$row->move( $direction, $where )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	/**
	* Method to checkin/unlock the item
	*
	* @access public
	* @return boolean True on success
	
	*/
	public function checkin() {
		if ($this->_id) {
			$item = & $this->getTable();
			if (!$item->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}
	/**
	* Method to checkout/lock the item
	*
	* @access public
	* @param int $uid User ID of the user checking the article out
	* @return boolean True on success
	*/
	public function checkout($uid = null) {
		if ($this->_id) {
			// Make sure we have a user id to checkout the vendor with
			if (is_null($uid)) {
				$user = & JFactory :: getUser();
				$uid = $user->get('id');
			}
			// Lets get to it and checkout the thing...
			$item = & $this->getTable();
			if (!$item->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}	
	
	/**
	 * Method to set the Default Filter Column
	 * 
	 * @access public
	 * @param mixed Default Filter
	 */
	public function setDefaultFilter($filter)	{
		$this->_default_filter = $filter;
	}
	
	/**
	* Method to build the query
	*
	* @access private
	* @return string query	
	*/
	protected function _buildQuery()	{
		static $instance;
		if(!empty($instance)) {
			return $instance;
		}
		$this->_query->select('a.*');
		$this->_query->from($this->_default_table.' AS a');
		$this->_buildContentWhere();		
		$this->_buildContentOrderBy();
		$instance = $this->_query->__toString();
		return $instance;
	}
	
	/**
	* Method to build the Joins
	*
	* @access private	
	*/
	protected function _buildJoins()	{
		
	}

	/**
	* Method to build the Order Clause
	*
	* @access private
	* @return string orderby	
	*/
	protected function _buildContentOrderBy()	{
		$app = &JFactory::getApplication('administrator');
		$context			= $option.'.'.strtolower($this->getName()).'.list.';
		$filter_order = $app ->getUserStateFromRequest($context . 'filter_order', 'filter_order', $this->_default_filter, 'cmd');
		$filter_order_Dir = $app ->getUserStateFromRequest($context . 'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$this->_query->order($filter_order . ' ' . $filter_order_Dir );
	}
	
/**
	* Method to build the Where Clause 
	*
	* @access private
	* @return string orderby	
	*/
	protected function _buildContentWhere()	{
		$app = &JFactory::getApplication('administrator');
		$context			= $this->option.'.'.strtolower($this->getName()).'.list.';
		$search = $app->getUserStateFromRequest($context . 'search', 'search', '', 'string');
		if ($search) {
			$where[] = 'LOWER('.$this->getDefaultFilter().') LIKE ' . $this->_db->Quote('%' . $search . '%');
			$this->_query->where('LOWER('.$this->getDefaultFilter().') LIKE ' . $this->_db->Quote('%' . $search . '%'));
		}
		if ($this->_state_field) {
			$filter_state = $app->getUserStateFromRequest($context . 'filter_state', 'filter_state', '', 'word');			
			switch($filter_state) {
				case 'P':
					$this->_query->where('a.published = 1');
					break;
				case 'U':
					$this->_query->where('a.published = 0');
					break;
				case 'T':
					$this->_query->where('a.published = -2');
					break;
			}
		}
	}		
	
	protected function _multiDbCondIfArray($search)	{
		$ret = (is_array($search)) ? " IN ('" . implode("','", $search) . "') " : " = '" . $search . "' ";
		return $ret;
	}

	/**
	 * Method to validate the form data.
	 *
	 * @param	object		$form		The form to validate against.
	 * @param	array		$data		The data to validate.
	 * @return	mixed		Array of filtered data if valid, false otherwise.
	 * @since	1.1
	 */
	public function validate($form, $data)	{
		// Filter and validate the form data.
		$data	= $form->filter($data);
		$return	= $form->validate($data);
		// Check for an error.
		if (JError::isError($return)) {
			$this->setError($return->getMessage());
			return false;
		}
		// Check the validation results.
		if ($return === false) {
			// Get the validation messages from the form.
			foreach ($form->getErrors() as $message) {
				$this->setError($message);
			}
			return false;
		}
		return $data;
	}	
  /**
    * rekord tulajdonosok beolvasása
    * @param string $tableName
    * @param integer $tableid        
    * @return array  [0] - title, [1] - link (browserhez amin ez szerepel)
    */         
  public function getOwners($tableName,$tableid) {
    $result = array();
    $db = JFactory::getDBO();
    if ($tableName == '#__ampm_wfshema') {
       $db->setQuery('SELECT p.id,p.title 
                      FROM #__ampm_wfshema wfs, #__ampm_product p
                      WHERE p.id = wfs.product_id AND wfs.id="'.$tableid.'"' );
       $res = $db->loadObject();
       if ($res) {
         $result[] = array();
         $result[count($result)-1][0] = $res->title;
         $result[count($result)-1][1] = JURI::base().'index.php?option=com_amproject'.
            '&view=product&search='.URLencode($res->title);
       }  
    }
    if ($tableName == '#__ampm_workflow') {
       $db->setQuery('SELECT p.id,p.title 
                      FROM #__ampm_workflow wf, #__ampm_project p
                      WHERE p.id = wf.project_id AND wf.id="'.$tableid.'"' );
       $res = $db->loadObject();
       if ($res) {
         $result[] = array();
         $result[count($result)-1][0] = $res->title;
         $result[count($result)-1][1] = JURI::base().'index.php?option=com_amproject'.
             '&view=project&search='.URLencode($res->title);
       }  
    }
    if ($tableName == '#__ampm_taskshema') {
       $db->setQuery('SELECT w.id,w.title,w.product_id 
                      FROM #__ampm_taskshema t, #__ampm_wfshema w
                      WHERE w.id = t.wfshema_id AND t.id="'.$tableid.'"' );
       $res = $db->loadObject();
       if ($res) {
         $r1 = array();
         $r1[] = array();
         $r1[count($r1)-1][0] = $res->title;
         $r1[count($r1)-1][1] = JURI::base().'index.php?option=com_amproject'.
            '&view=wfshema&search='.URLencode($res->title).
            '&product='.$res->product_id;
         $r2 = $this->getOwners('#__ampm_wfshema',$res->id);
         $result = array_merge($r1,$r2);
       }  
    }
    if ($tableName == '#__ampm_task') {
       $db->setQuery('SELECT w.id,w.title,w.project_id 
                      FROM #__ampm_task t, #__ampm_workflow w
                      WHERE w.id = t.workflow_id AND t.id="'.$tableid.'"' );
       $res = $db->loadObject();
       if ($res) {
         $r1 = array();
         $r1[] = array();
         $r1[count($r1)-1][0] = $res->title;
         $r1[count($r1)-1][1] = JURI::base().'index.php?option=com_amproject'.
            '&view=workflow&search='.URLencode($res->title).
            '&project='.$res->project_id;
         $r2 = $this->getOwners('#__ampm_workflow',$res->id);
         $result = array_merge($r1,$r2);
       }  
    }
    if ($tableName == '#__ampm_condition') {
       $db->setQuery('SELECT c.table_id, c.table_type 
                      FROM #__ampm_condition c
                      WHERE c.id="'.$tableid.'"' );
       $res = $db->loadObject();
       if ($res) {
         $table_type = $res->table_type;
         $table_id = $res->table_id;
         $db->setQuery('SELECT * 
         FROM '.$table_type.'
         WHERE id="'.$table_id.'"');
         $res = $db->loadObject();
       }
       if ($res) {  
         $r1 = array();
         $r1[] = array();
         $r1[count($r1)-1][0] = $res->title;
         $r1[count($r1)-1][1] = JURI::base().'index.php?option=com_amproject'.
            '&view='.substr($table_type,8,20).'&search='.URLencode($res->title);
         if ($table_type == '#__ampm_taskshema') 
            $r1[count($r1)-1][1] .= '&wfshema='.$res->wfshema_id;
         if ($table_type == '#__ampm_task') 
            $r1[count($r1)-1][1] .= '&workflow='.$res->workflow_id;
         if ($table_type == '#__ampm_wfshema') 
            $r1[count($r1)-1][1] .= '&product='.$res->product_id;
         if ($table_type == '#__ampm_workflow') 
            $r1[count($r1)-1][1] .= '&project='.$res->project_id;
         $r2 = $this->getOwners($table_type,$table_id);
         $result = array_merge($r1,$r2);
        }
      }  
      return $result;
  }
}    