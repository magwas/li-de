<?php
/**
 * @version		$Id: //depot/dev/Joomla/Joo_Comments/ver_1_0_0/com_joocomments/admin/views/settings/tmpl/default.php#7 $
 * @package		Joomla.Administrator
 * @subpackage	com_config
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$template = JFactory::getApplication()->getTemplate();

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<style type="text/css">
#config-tabs-com_joocomments_configuration .publishing-details h3{
font-weight: bold;
}
li.joolist{

    clear: left !important;
    display: block !important;
    height: 1.6em !important;
    margin: 1px 0 !important;
    padding: 1px !important;
}
li.joolist > label{
    display: block;
    float: left;
    height: 1.4em;
    margin-left: 30px !important;
    padding: 2px 0 0 2px;
    width: 15%;
}

.icon-48-config{
background:url("components/com_joocomments/assets/icon-48-config.png")
}
</style>
<script type="text/javascript">
	function notifyEmailDetails(){
		alert('<?php echo JText::_('COM_JOOCOMMENTS_PROVIDE_EMAIL_ID');?>');
	}
	Joomla.submitbutton = function(task)
	{
		if (document.formvalidator.isValid(document.id('component-form'))) {
			Joomla.submitform(task, document.getElementById('component-form'));
		}
	}
	 /* planned for ver1.0.4
	function requestArticleDetails(){
	 // create a Ajax Post request.
	 document.getElementById('co').innerHTML="Wait till article details is fetched ";
	 var element=document.getElementById('jform_comment_Enable_Disable').value;
	 var myHTMLRequest = new Request.HTML({url: 'index.php',onComplete: function(response){
			$('co').empty();
	        $('right').empty().adopt(response);
      }}).get('option=com_joocomments&task=settings.fetch&parentCategory='+element+'&view=articlesettings&layout=category');
	 

		}*/
</script>
<form action="<?php echo JRoute::_('index.php?option=com_joocomments&view=settings');?>" id="component-form" method="post" name="adminForm" autocomplete="off" class="form-validate">
	<?php
	echo JHtml::_('tabs.start','config-tabs-'.$this->component->option.'_configuration', array('useCookie'=>1));
		$fieldSets = $this->form->getFieldsets();
		foreach ($fieldSets as $name => $fieldSet) :
			$label = empty($fieldSet->label) ? 'COM_CONFIG_'.$name.'_FIELDSET_LABEL' : $fieldSet->label;
			echo JHtml::_('tabs.panel',JText::_($label), 'publishing-details');
			if (isset($fieldSet->description) && !empty($fieldSet->description)) :
				echo '<p class="tab-description">'.JText::_($fieldSet->description).'</p>';
			endif;
	?>
			<ul class="config-option-list">
			<?php
			$var=0;
			//planned for v1.0.4 $varLike=0;
			$varCap=0;
			//planned for v1.0.5 $varCom=0;
			$varFrontendComment=0;
			$varAdminEmail=0;
			$varAutoApprove=0;
			echo JHtml::_('sliders.start','config-tabs-', array('useCookie'=>1));
			foreach ($this->form->getFieldset($name) as $field):
		
			$ar=explode('_', $field->name);
			
			switch($ar[0]){
				case 'jform[gravatar':
					$this->assignRef('field',$field);
					$this->assignRef('particular',$var);
					$this->assign('sliderHeader','COM_JOOCOMMENTS_VIEW_CONFIGURATION_FRONTEND_OPTIONS_GRAVATAR_HEADER');
					echo $this->loadTemplate('gravatar');
					$var=+1;
					break;
				case 'jform[frontend-comment':
					$this->assignRef('field',$field);
					$this->assignRef('particular',$varFrontendComment);
					$this->assign('sliderHeader','COM_JOOCOMMENTS_VIEW_CONFIGURATION_FRONTEND_OPTIONS_COMMENT_HEADER');
					echo $this->loadTemplate('gravatar');
					$varFrontendComment=+1;
					break;
					/* planned for v1.0.4*/
					//case 'jform[like':
					//$this->assignRef('field',$field);
					//$this->assignRef('particular',$varLike);
					//$this->assign('sliderHeader','Like Settings');
					//echo $this->loadTemplate('gravatar');
					//$varLike=+1;
					//break;
					case 'jform[captcha':
					$this->assignRef('field',$field);
					$this->assignRef('particular',$varCap);
					$this->assign('sliderHeader','COM_JOOCOMMENTS_VIEW_CONFIGURATION_FRONTEND_OPTIONS_CAPTCHA_HEADER');
					echo $this->loadTemplate('gravatar');
					$varCap=+1;
					break;
					/* planned for version 1.0.5 
					 * 
					 */
					//case 'jform[comment':
					//$this->assignRef('field',$field);
					//$this->assignRef('particular',$varCom);
					//$this->assign('sliderHeader','Enable/Disable comments by Category');
					//echo $this->loadTemplate('comment');
					//$varCom=+1;
					//break;
		
					case 'jform[email':
					$this->assignRef('field',$field);
					$this->assignRef('particular',$varAdminEmail);
					$this->assign('sliderHeader','COM_JOOCOMMENTS_VIEW_CONFIGURATION_ADMINISTRATOR_SETTINGS_EMAIL_NOTIFICATION');
					echo $this->loadTemplate('administratoremail');
					$varAdminEmail=+1;
					break;
					case 'jform[autoapprove':
					$this->assignRef('field',$field);
					$this->assignRef('particular',$varAutoApprove);
					$this->assign('sliderHeader','COM_JOOCOMMENTS_VIEW_CONFIGURATION_ADMINISTRATOR_SETTINGS_AUTO_APPROVED_COMMENTS');
					echo $this->loadTemplate('administratoremail');
					$varAutoApprove=+1;
					break;
					
			}
			?>
			<?php
			endforeach;
			echo JHtml::_('sliders.end');
			?>
			</ul>


	<div class="clr"></div>
	<?php
		endforeach;
	echo JHtml::_('tabs.end');
	?>
	<div>
		<input type="hidden" name="id" value="<?php echo $this->component->id;?>" />
		<input type="hidden" name="component" value="<?php echo $this->component->option;?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
