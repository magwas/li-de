<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

  JToolBarHelper::title( JText::_( 'Resource' ), 'generic.png' );
  JToolBarHelper::addNew();
  JToolBarHelper::editList();
  JToolBarHelper::publishList();
  JToolBarHelper::unpublishList();  
  JToolBarHelper::deleteList();  
  JToolBarHelper::preferences('com_amproject', '550');  
?>

<form action="index.php?option=com_amproject&amp;view=resource" method="post" name="adminForm" id="adminForm">
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
					<?php echo JHTML::_('grid.sort', 'Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>								<th class="title">
					<?php echo JHTML::_('grid.sort', 'Unit', 'a.unit', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>								<th class="title">
					<?php echo JHTML::_('grid.sort', 'Ordering', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>								<th class="title">
					<?php echo JHTML::_('grid.sort', 'State', 'a.state', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>								<th class="title">
					<?php echo JHTML::_('grid.sort', 'Id', 'a.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="12">
				<?php echo $this->pagination->getListFooter(); ?>
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
    	$onclick= "onclick=\"window.parent.jSelectResource_id('".$row->id."', '".$this->escape($row->title)."', '','id')\" ";
    }  	
    
 	$link = JRoute::_( 'index.php?option=com_amproject&view=resource&task=edit&cid[]='. $row->id );
 	$row->id = $row->id; 	
 	$checked = JHTML::_('grid.id', $i, $row->id); 	
  	$published = JHTML::_('grid.published', $row, $i ); 	
 	
  ?>
	<tr class="<?php echo "row$k"; ?>">
		
		<td align="center"><?php echo $this->pagination->getRowOffset($i); ?>.</td>
        
        <td><?php echo $checked  ?></td>	

        <td>
							
							<a <?php echo $onclick; ?>href="<?php echo $link; ?>"><?php echo $row->title; ?></a>
 									
		</td>
        <td><?php echo $row->unit ?></td>
        <td>
        	<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', ($this->lists['order'] == 'a.ordering' and $this->lists['order_Dir'] == 'asc'));?></span>
			<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', ($this->lists['order'] == 'a.ordering' and $this->lists['order_Dir'] == 'asc') );?></span>
        </td>

        <td><?php echo $row->state ?></td>
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
<input type="hidden" name="task" value="resource" />
<input type="hidden" name="view" value="resource" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>  	