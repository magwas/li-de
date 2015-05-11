<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
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

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   $pageTitle.': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit) {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}

  // tulajdonos rekordok
  $model = $this->getModel('condition');
  if (($table != '') & ($this->item->id >0)) {
    $owners = $model->getOwners('#__ampm_condition',$this->item->id);
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


?>
<div id="working" style="display:none;" class="working">
  <p><?php echo JText::_('WORKING...'); ?></p>
</div>
<script language="javascript" type="text/javascript">


Joomla.submitbutton = function(task) {
  document.getElementById('working').style.display='block';
	if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

</script>

	 	<form method="post" action="index.php" id="adminForm" name="adminForm">
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
							
				
					
				<?php 
          if ($table == '') {
            echo $this->form->getLabel('table_type'); 
				    echo $this->form->getInput('table_type'); 
            echo $this->form->getLabel('table_id'); 
            echo '<select id="jform_table_id" name="jform[table_id]" class="inputbox" aria-requed="true">'."\n";
            echo '<option value="0">'.JText::_('SELECT_PLEAS').'</option>'."\n";
            $tableName = $this->form->getValue('table_type');
            $value = $this->form->getValue('table_id');
            if ($tableName == '') $tableName='#__ampm_wfshema';
            $db->setQuery('select id,title from '.$tableName.' order by title');
            $options = $db->loadObjectList();
            foreach ($options as $option) {
              if ($value == $option->id)
                echo '<option value="'.$option->id.'" selected="selected">'.$option->title.'</option>'."\n";
              else
                echo '<option value="'.$option->id.'">'.$option->title.'</option>'."\n";
            }
            echo '</select>
            <div class="clr"></div>
            ';
          } else {
            echo $this->form->getLabel('table_type'); 
            echo '<input type="hidden" name="jform[table_type]" value="#__ampm_'.$table.'" />';
            echo '<input type="hidden" name="jform[table_id]" value="'.$tableid.'" />';
            echo '<span class="inputbox">'.JText::_($table).'</span>';
            echo '<div class="clr"></div>'.$this->form->getLabel('table_id'); 
            echo '<span class="inputbox">'.$tableTitle.'</span>';
          }
        ?>

				<?php echo $this->form->getLabel('type'); ?>
				<?php echo $this->form->getInput('type');  ?>
					
				<?php echo $this->form->getLabel('assigned_id'); ?>
				<?php 
          echo '<select id="jform_assigned_id" name="jform[assigned_id]" 
                   class="inputbox" aria-requed="true" onchange="Joomla.submitbutton('."'refresh'".')">'."\n";
          echo '<option value="0">'.JText::_('SELECT_PLEAS').'</option>'."\n";
          $type = $this->form->getValue('type');
          $tableName = '#__ampm_wfshema';
          if (($type >= 20) & ($type <= 23)) $tableName = '#__ampm_wfshema';
          if (($type >= 30) & ($type <= 33)) $tableName = '#__ampm_taskshema';
          if (($type >= 40) & ($type <= 43)) $tableName = '#__ampm_workflow';
          if (($type >= 50) & ($type <= 53)) $tableName = '#__ampm_task';
          if (($type >= 60) & ($type <= 60)) $tableName = '#__ampm_resource';
          $value = $this->form->getValue('assigned_id');
          $db->setQuery('select id,title from '.$tableName.' order by title');
          $options = $db->loadObjectList();
          foreach ($options as $option) {
            if ($value == $option->id)
              echo '<option value="'.$option->id.'" selected="selected">'.$option->title.'</option>'."\n";
            else
              echo '<option value="'.$option->id.'">'.$option->title.'</option>'."\n";
          }
          echo '</select>
          <div class="clr"></div>
          ';
        ?>
					
				<?php 
           if ($this->form->getValue('type')==60) {
				     echo '<div style="display:inline-block">';
             echo $this->form->getLabel('volume'); 
             echo '<input type="text" name="jform[volume]" value="'.$this->item->volume.'" />';
             $db->setQuery('select unit from #__ampm_resource where id="'.$this->form->getValue('assigned_id').'"');
             $res = $db->loadObject();
             if ($res) {
               echo ' '.$res->unit;
             } else {
               echo ' coli';
             }
             echo '</div>'; 
           }
        ?>
						
        </fieldset>                      
        </div>
        <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
        </div>                   
		<input type="hidden" name="option" value="com_amproject" />
    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
    <input type="hidden" name="jform[id]" value="<?php echo $this->item->id ?>" />
    <input type="hidden" name="table" value="<?php echo JRequest::getVar('table'); ?>">
    <input type="hidden" name="tableid" value="<?php echo JRequest::getVar('tableid'); ?>">
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="condition" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>