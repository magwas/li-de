<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

  // tulajdonos filter beolvasása
  $db = JFactory::getDBO();
  $table = JRequest::getVar('table','');
  $tableid = JRequest::getVar('tableid','');
  $tableTitle = '';    
  if ($table != '') {
     $db->setQuery('SELECT title from #__ampm_'.$table.' WHERE id="'.$tableid.'"');
     $res = $db->loadObject();
     if ($res) $tableTitle = $res->title;
     $pageTitle =  '<span class="tulajdonos">'.$tableTitle.'&nbsp;'.
           JText::_($table).'</span><br />'.JText::_('conditions');
  } else {
     $pageTitle = JText::_('conditions');
  }

  JToolBarHelper::title( $pageTitle, 'generic.png' );
  JToolBarHelper::addNew();
  JToolBarHelper::editList();
  JToolBarHelper::publishList();
  JToolBarHelper::unpublishList();  
  JToolBarHelper::deleteList();  
  JToolBarHelper::preferences('com_amproject', '550');
  $this->form = $this->getForm('condition');
  
  // tulajdonos rekordok
  $model = $this->getModel('condition');
  if (($table != '') & (count($this->items)>0)) {
    $owners = $model->getOwners('#__ampm_condition',$this->items[0]->id);
  } else {
    $owners = array();
  }    
  echo '<div class="tulajdonosok">
  ';
  for ($i=count($owners)-1; $i>=0; $i--) {
    echo '<a href="'.$owners[$i][1].'">'.$owners[$i][0].'</a>';
    if ($i > 0) echo '&nbsp;/&nbsp;';
  }
  echo '</div>
  ';
  
  // get tpye field options
  $options = array();
  $s = $this->form->getInput('type');
  $w = explode('<option value="',$s);
  for ($i=1;$i<count($w);$i++) {
    $w2 = explode('">',$w[$i]);
    $value = $w2[0];
    $label = str_replace('</option>','',$w2[1]);
    $label = str_replace("\n",'',$label);
    $label = str_replace('<\select>','',$label);
    $options[$value]=$label;
  }
  
?>

<form action="index.php?option=com_amproject&amp;view=condition" method="post" name="adminForm" id="adminForm">
	<table>
		<tr>
			<td align="left" width="100%">
				<div id="filter-bar" class="btn-toolbar">
					<div class="filter-search btn-group pull-left">
						<label class="element-invisible" for="filter_search"><?php echo JText::_( 'Filter' ); ?>:</label>
						<input type="text" name="search" id="search" value="<?php  echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
					</div>
					<div class="btn-group pull-left">
						<button class="btn" onclick="this.form.submit();"><?php if(version_compare(JVERSION,'3.0','lt')): echo JText::_( 'Go' ); else: ?><i class="icon-search"></i><?php endif; ?></button>
						<button type="button" class="btn" onclick="document.getElementById('search').value='';this.form.submit();"><?php if(version_compare(JVERSION,'3.0','lt')): echo JText::_( 'Reset' ); else: ?><i class="icon-remove"></i><?php endif; ?></button>
					</div>
				</div>					
			</td>
			<td nowrap="nowrap">
  				
			</td>
		</tr>		
	</table>
<div id="editcell">
	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="5">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="20">				
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>			

				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Table_type', 'a.table_type', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Table_id', 'a.table_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Type', 'a.type', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Assigned_id', 'a.assigned_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Volume', 'a.volume', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
        <th class="title">
					<?php echo JHTML::_('grid.sort', 'Id', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="12">
				<?php
          if ($table != '') {
            $this->pagination->setAdditionalUrlParam('table',$table);
            $this->pagination->setAdditionalUrlParam('tableid',$tableid);
          } 
          echo $this->pagination->getListFooter(); 
        ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
<?php
  $k = 0;
  if (count( $this->items ) > 0 ):
  
  for ($i=0, $n=count( $this->items ); $i < $n; $i++):
  
  $row = &$this->items[$i];
 	$onclick = "";
  if (JRequest::getVar('function', null)) {
    	$onclick= "onclick=\"window.parent.jSelectCondition_id('".$row->id."', '".$this->escape($row->table_type)."', '','id')\" ";
  }  	
    
 	$link = JRoute::_( 'index.php?option=com_amproject&view=condition&task=edit&cid[]='. $row->id.
      '&table='.$table.'&tableid='.$tableid);
 	$row->id = $row->id; 	
 	$checked = JHTML::_('grid.id', $i, $row->id); 	
  	$published = JHTML::_('grid.published', $row, $i ); 	
 	
  ?>
	<tr class="<?php echo "row$k"; ?>">
		
		<td align="center"><?php echo $this->pagination->getRowOffset($i); ?>.</td>
        <td><?php echo $checked  ?></td>	
        <td>		
							<a <?php echo $onclick; ?>href="<?php echo $link; ?>"><?php echo $row->table_type; ?></a>
    		</td>
        <td>		
							<?php echo $row->table_id; ?>
    		</td>
        <td>		
							<?php echo JText::_($options[$row->type]); ?>
    		</td>
        <td><?php echo $row->assigned_id ?></td>		
        <td><?php echo $row->volume ?></td>		
        <td><?php echo $row->id ?></td>		
	</tr>
<?php
  $k = 1 - $k;
  endfor;
  else:
  ?>
	<tr>
		<td colspan="12">
			<?php echo JText::_( 'There are no items present' ); ?>
		</td>
	</tr>
	<?php
  endif;
  ?>
</tbody>
</table>
</div>
<input type="hidden" name="option" value="com_amproject" />
<input type="hidden" name="task" value="condition" />
<input type="hidden" name="view" value="condition" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
<input type="hidden" name="table" value="<?php echo $table; ?>" />
<input type="hidden" name="tableid" value="<?php echo $tableid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>  	