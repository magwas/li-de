<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Workflow' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit) {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
?>

<script language="javascript" type="text/javascript">


Joomla.submitbutton = function(task)
{
	if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

</script>

	 	<form method="post" action="index.php" id="adminForm" name="adminForm">
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
							
				<?php echo $this->form->getLabel('title'); ?>
				
				<?php echo $this->form->getInput('title');  ?>
					
				<?php echo $this->form->getLabel('project_id'); ?>
				
				<?php echo $this->form->getInput('project_id');  ?>
					
				<?php echo $this->form->getLabel('start'); ?>
				
				<?php echo $this->form->getInput('start');  ?>
					
				<?php echo $this->form->getLabel('deadline'); ?>
				
				<?php echo $this->form->getInput('deadline');  ?>
					
				<?php echo $this->form->getLabel('mmanager_id'); ?>
				
				<?php echo $this->form->getInput('mmanager_id');  ?>
					
				<?php echo $this->form->getLabel('priority'); ?>
				
				<?php echo $this->form->getInput('priority');  ?>

				<div class="clr"></div>
					
					
				<?php echo $this->form->getLabel('process_desc'); ?>
				
					
				<div class="clr"></div>
					
				<?php echo $this->form->getInput('process_desc');  ?>

				<div class="clr"></div>
					
					
				<?php echo $this->form->getLabel('result_desc'); ?>
				
					
				<div class="clr"></div>
					
				<?php echo $this->form->getInput('result_desc');  ?>
					
				<?php echo $this->form->getLabel('wfshema_id'); ?>
				
				<?php echo $this->form->getInput('wfshema_id');  ?>
					
		
				<div class="clr"></div>
					
					
				<?php echo $this->form->getLabel('description'); ?>
				
					
				<div class="clr"></div>
					
				<?php echo $this->form->getInput('description');  ?>
					
							
				<?php echo $this->form->getLabel('state'); ?>
				
				<?php echo $this->form->getInput('state');  ?>
			
						
          </fieldset>                      
        </div>
        <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
			        

        </div>                   
		<input type="hidden" name="option" value="com_amproject" />
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="workflow" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>