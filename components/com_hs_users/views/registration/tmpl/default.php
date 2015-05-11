<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.noframes');
?>
<div class="registration<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>
	
	<?php $hideForm = $this->params->get('hide_default_form', 'show');?>
	
	<?php if($hideForm!=='hide'):?>
	<div class="hs_users_divider hs_left">
		<div class="hs_inner">
			
			<h3><?php echo JText::_('COM_HS_USERS_VIEW_REG_DEFAULT_TITLE_LABEL'); ?></h3>
			<div class="hs_desc">
				<?php echo JText::_('COM_HS_USERS_VIEW_REG_DEFAULT_TITLE_DESC'); ?>
			</div>		
			
			
						
			<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal">
		<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<fieldset>
				<?php 
				  
				 /* Disabled fieldset label
				
				if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
				?>
					<legend><?php echo JText::_($fieldset->label);?></legend>
				<?php endif;
				
				*/
				?>
				<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
					<?php if ($field->hidden):// If the field is hidden, just display the input.?>
						<?php echo $field->input;?>
					<?php else:?>
						<div class="control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer'): ?>
								<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
					<?php endif;?>
				<?php endforeach;?>
				</fieldset>
			<?php endif;?>
		<?php endforeach;?>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER');?></button>
					<a class="btn" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="registration.register" />
					<?php echo JHtml::_('form.token');?>
				</div>
			</form>		
		
		</div>
	</div>
	<?php endif;?>
	
	
	<div class="hs_users_divider hs_right">
		<div class="hs_inner">
			<h3><?php echo JText::_('COM_HS_USERS_VIEW_REG_SOCIALS_TITLE_LABEL'); ?></h3>
			<div class="hs_desc">
				<?php echo JText::_('COM_HS_USERS_VIEW_REG_SOCIALS_TITLE_DESC'); ?>
			</div>			
			<?php 		
			
				jimport('hs.user.html');
				echo HsUserHTML::getSocialList();
			?>	
		</div>
	</div>
	
	<div class="clear"></div>
</div>
