<?php
// 2010.10.11 szellemi termelés változat
// front end product felvitel, modositás
$editor =& JFactory::getEditor();
$images = JSON_decode($this->Item->images);
while (count($images) < 4) {
	$images[] = '';
}
if ($this->Msg != '')
	echo '<div class="errorMsg">'.$this->Msg.'</div>
    ';
?>
<h2><?php echo $this->Title; ?></h2>
<form name="adminForm" method="post" action="index.php" id="productForm" enctype="multipart/form-data">
  <input type="hidden" name="option" value="com_ecommercewd" />
  <input type="hidden" name="controller" value="products" />
  <input type="hidden" name="task" value="save" />
  <input type="hidden" name="jform[id]" value="<?php echo JRequest::getVar('product_id',$this->Item->id); ?>" />
  <input type="hidden" name="product_id" value="<?php echo JRequest::getVar('product_id',0); ?>" />
  <input type="hidden" name="jform[category_id]" value="<?php echo $this->Item->category_id; ?>" />
  <input type="hidden" name="category_id" value="<?php echo JRequest::getVar('category_id'); ?>" />
  <input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid'); ?>" />

  <p> </p>
  <div class="buttons">
    <button type="button" class="btn btn-primary" onclick="pressButton('<?php echo $this->saveTask; ?>')"><?php echo JText::_('OK'); ?></button>
	&nbsp;
    <button type="button" class="btn btn-primary" onclick="pressButton('<?php echo $this->cancelTask; ?>')"><?php echo JText::_('CANCEL'); ?></button>
	&nbsp;
  </div>
  <p> </p>

  <fieldset>
    <label><?php echo JText::_('COM_ECOMMERCEWD_NAME'); ?></label> 
	<input type="text" class="name" name="jform[name]" value="<?php echo $this->Item->name; ?>" />
	<div style="clear:both"></div>
	
    <label><?php echo JText::_('COM_ECOMMERCEWD_MODEL'); ?></label> 
	<input type="text" class="model" name="model_hidden" value="<?php echo $this->Item->model; ?>" disabled="disabled"/>
	<input type="hidden" class="model" name="jform[model]" value="<?php echo $this->Item->model; ?>" disabled="disabled"/>
	<div style="clear:both"></div>

    <label><?php echo JText::_('COM_ECOMMERCEWD_DESCRIPTION'); ?></label> 
    <?php echo $editor->display('jform[description]', $this->Item->description, '550', '400', '60', '20', false); ?>
	<div style="clear:both"></div>

    <label><?php echo JText::_('COM_ECOMMERCEWD_PRICE'); ?></label> 
	<input type="text" class="price" name="jform[price]" value="<?php echo $this->Item->price; ?>" />
	<div style="clear:both"></div>

    <label><?php echo JText::_('COM_ECOMMERCEWD_MARKET_PRICE'); ?></label> 
	<input type="text" class="market_price" name="jform[market_price]" value="<?php echo $this->Item->market_price; ?>" />
	<div style="clear:both"></div>

    <label><?php echo JText::_('COM_ECOMMERCEWD_AMOUNT_IN_STOCK'); ?></label> 
	<input type="text" class="amount_in" name="jform[amount_in_stock]" value="<?php echo $this->Item->amount_in_stock; ?>" />
	<div style="clear:both"></div>

    <label><?php echo JText::_('COM_ECOMMERCEWD_PUBLISHED'); ?></label> 
	<select name="jform[published]">
	  <option value="1"<?php if ($this->Item->published == 1) echo ' selected="selected"'; ?>>Igen</option> 
	  <option value="0"<?php if ($this->Item->published == 0) echo ' selected="selected"'; ?>>Nem</option> 
	</select>
	<div style="clear:both"></div>

	<h3><?php echo JText::_('IMAGES'); ?></h3>
	<div class="productImage">
	  <input type="file" type="text" name="img0" />
	  <?php if ($images[0] != '') { ?>
	  <img src="<?php echo $images[0]; ?>" /><br />
	  <input type="checkbox" name="imgdel0" value="1" /><?php echo JText::_('COM_ECOMMERCEWD_IMG_DELETE'); ?>
	  <?php 
	  }
	  ?>
	</div>
	<div class="productImage">
	  <input type="file" type="text" name="img1" />
	  <?php if ($images[1] != '') { ?>
	  <img src="<?php echo $images[1]; ?>" /><br />
	  <input type="checkbox" name="imgdel1" value="1" /><?php echo JText::_('COM_ECOMMERCEWD_IMG_DELETE'); ?>
	  <?php 
	  }
	  ?>
	</div>
	<div class="productImage">
	  <input type="file" type="text" name="img2" />
	  <?php if ($images[2] != '') { ?>
	  <img src="<?php echo $images[2]; ?>" /><br />
	  <input type="checkbox" name="imgdel2" value="1" /><?php echo JText::_('COM_ECOMMERCEWD_IMG_DELETE'); ?>
	  <?php 
	  }
	  ?>
	</div>
	<div class="productImage">
	  <input type="file" type="text" name="img3" />
	  <?php if ($images[3] != '') { ?>
	  <img src="<?php echo $images[3]; ?>" /><br />
	  <input type="checkbox" name="imgdel3" value="1" /><?php echo JText::_('COM_ECOMMERCEWD_IMG_DELETE'); ?>
	  <?php 
	  }
	  ?>
	</div>
	<div style="clear:both"></div>
	
  </fieldset>
  <p> </p>
  <div class="buttons">
    <button type="button" class="btn btn-primary" onclick="pressButton('<?php echo $this->saveTask; ?>')"><?php echo JText::_('OK'); ?></button>
	&nbsp;
    <button type="button" class="btn btn-primary" onclick="pressButton('<?php echo $this->cancelTask; ?>')"><?php echo JText::_('CANCEL'); ?></button>
	&nbsp;
  </div>
  <p> </p>
</form>

<script type="text/javascript">
  function pressButton(task) {
	if (task == 'cancel') {
		if (document.forms.adminForm.product_id.value > 0) {
			document.forms.adminForm.controller.value = 'products';
			task = 'displayproduct';
		} else {
			document.forms.adminForm.controller.value = 'categories';
			task = 'displaycategory';
		}
	}  
	document.forms.adminForm.task.value = task;
	document.forms.adminForm.submit();	
  }
</script>