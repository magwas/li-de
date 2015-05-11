<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$pageTitle = JText::_('WFSHEMA') ;
$product = JRequest::getVar('product','');
if ($product != '') {
  $db = JFactory::getDBO();
  $db->setQuery('SELECT * FROM #__ampm_product WHERE id="'.$product.'" AND STATE=1');
  $res = $db->loadObject();
  if ($res) {
    $pageTitle = '<span class="tulajdonos">'.
            $res->title.'&nbsp;'.
            JText::_('PRODUCT').
            '</span><br />'.
            JText::_('WFSHEMA');
  }
} 

// Set toolbar items for the page
$edit		= JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(  $pageTitle.': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit) {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
  // tulajdonos rekordok
  $model = $this->getModel('wfshema');
  if (($product != '') & ($this->item->id > 0)) {
    $owners = $model->getOwners('#__ampm_wfshema',$this->item->id);
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
		
				<div class="clr"></div>
				<?php echo $this->form->getLabel('product_id'); ?>
				<?php 
          $product = JRequest::getVar('product',''); 
          if ($product == '')
             echo $this->form->getInput('product_id');
          else {
             echo '<input type="hidden" name="jform[product_id]" value="'.$product.'" />';
             $db->setQuery('SELECT title from #__ampm_product where id="'.$product.'"');
             $res = $db->loadObject();
             if ($res)
               echo '<span>'.$res->title.'</span>';
             else 
               echo '<span>'.$product.'</span>';
          }     
        ?>

				<div class="clr"></div>
				<?php echo $this->form->getLabel('ordering'); ?>
				<?php echo $this->form->getInput('ordering');  ?>
			
				<div class="clr"></div>
				<?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state');  ?>
        
				<div class="clr"></div>
				<?php echo $this->form->getLabel('description'); ?><br />
				<div class="clr"></div>
				<?php echo $this->form->getInput('description');  ?>
      </fieldset>                      
  </div>
  <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt"></div>                   
  <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
  <input type="hidden" name="option" value="com_amproject" />
  <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="wfshema" />
	<input type="hidden" name="product" value="<?php echo $product; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>