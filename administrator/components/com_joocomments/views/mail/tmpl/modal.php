<?php
/**
 * 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.modal');
$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root() . '/administrator/components/com_joocomments/assets/maillayout.css');;//ScriptDeclaration($js);
?>
<script type="text/javascript">

	Joomla.submitbutton = function(pressbutton) {
		var form = document.getElementById('mailtoForm');
		
		// do field validation
		if (form.mailto.value == "" || form.from.value == "") {
			alert('<?php echo JText::_('COM_MAILTO_EMAIL_ERR_NOINFO'); ?>');
			return false;
		}
		form.submit();
	}
</script>
<?php
$header= JRequest::getString('header','Send mail');
$data	= $this->get('data');
$toMail=JRequest::getString('toMail');
$title=JRequest::getString('title');
$name=JRequest::getString('name');
$user=JFactory::getUser();
?>
<h2>	
		<?php echo $header; ?>
	</h2>
	
<div id="mailto-window">
	<form action="<?php echo JRoute::_('index.php');?>" id="mailtoForm" method="post">
		<div class="formelm">
			<label for="mailto_field"><?php echo JText::_('COM_MAILTO_EMAIL_TO'); ?></label>
			<input type="text" id="mailto_field" name="mailto" class="inputbox" size="35" value="<?php echo $toMail?>"/>
		</div>
		<div class="formelm">
			<label for="sender_field">
			<?php echo JText::_('COM_MAILTO_SENDER'); ?></label>
			<input type="text" id="sender_field" name="sender" class="inputbox" value="<?php echo $user->name;?>" size="35" />
		</div>
		<div class="formelm">
			<label for="from_field">
			<?php echo JText::_('COM_MAILTO_YOUR_EMAIL'); ?></label>
			<input type="text" id="from_field" name="from" class="inputbox" value="<?php echo $user->email;?>" size="35" />
		</div>
		<div class="formelm">
			<label for="subject_field">
			<?php echo JText::_('COM_MAILTO_SUBJECT'); ?></label>
			<input type="text" id="subject_field" name="subject" class="inputbox" value="<?php echo $title ?>" size="65" />
		</div>
		<div class="formelm">
			<label for="text_field">
			<?php echo JText::_('Text'); ?></label>
			<textarea id="text_field" name="text_field" class="inputbox" rows="5" cols="37" >Hi <?php echo $name.',';?></textarea>
		</div>
		<div class="formelm">
		<p>
		
			<button class="button" onclick="return Joomla.submitbutton('send');">
				<?php echo JText::_('COM_MAILTO_SEND'); ?>
			</button>
			<button class="button" onclick="window.close();return false;" >
				<?php echo JText::_('COM_MAILTO_CANCEL'); ?>
			</button>
			
		</p>
		</div>
			<?php echo JHtml::_('form.token'); ?>
		<input type="hidden" name="option" value="com_joocomments" />
		<input type="hidden" name="task" value="send" />
		<input type="hidden" name="controller" value="mail" />
		<input type="hidden" name="layout" value="mailstatus" />
		<input type="hidden" name="tmpl" value="component" />
		<input type="hidden" name="link" value="" />

	</form>
</div>
