<?php
JHTML::_('behavior.modal'); 

$form = JForm::getInstance('temakorok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_temakorok'.DS.'models'.DS.'forms'.DS.'temakorok.xml');

// beállítások kezelő form
$form2 = JForm::getInstance('beallitasok',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_beallitasok'.DS.'models'.DS.'forms'.DS.'beallitasok.xml');


$form->bind($this->Item);
$this->form = $form;

if ($this->Msg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
// echo $this->Szulok;
echo '<h2>'.$this->Title.'</h2>
<p style="text-align:right">
';
if ($this->Akciok['delete'] != '') {
  echo '<button type="button" class="btnDelete" onclick="deleteClick()">'.JText::_('DELETE').'</button>';
}  
echo '
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->Akciok['sugo'].'">
   '.JText::_('SUGO').'
   </a>
</p>
<form action="'.$this->Akciok['ok'].'" method="post">
  <input type="hidden" name="limit" value="'.JRequest::getVar('limit').'" />
  <input type="hidden" name="limitstart" value="'.JRequest::getVar('limitstart').'" />
  <input type="hidden" name="order" value="'.JRequest::getVar('order').'" />
  <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr').'" />
  <input type="hidden" name="itemId" value="'.JRequest::getVar('itemId').'" />
  <input type="hidden" name="id" value="'.$this->Item->id.'" />
  <input type="hidden" name="temakor" value="'.$this->Item->id.'" />
 '; 
?>
			<div style="float:left; width:100%">	
        <?php echo $this->form->getLabel('megnevezes'); ?>
				<?php echo $this->form->getInput('megnevezes');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('leiras'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('leiras');  ?>
				<div class="clr"></div>
			</div>
			<div style="float:left; width:100%" class="adminform">	
				<?php
				if ($this->Item->id > 0) {
					echo $this->form->getLabel('szulo');
					echo '<select name="szulo">
					'.$this->temakorTree.'
					</select>
					';
				} else {
				  echo '<input type="hidden" name="szulo" value="'.$this->item->szulo.'" />';
				}
				echo '<div class="clr"></div>';
				?>
				<?php echo $this->form->getLabel('lathatosag'); ?>
				<?php echo $this->form->getInput('lathatosag');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('szavazok'); ?>
				<?php echo $this->form->getInput('szavazok');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('szavazasinditok'); ?>
				<?php echo $this->form->getInput('szavazasinditok');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('allapot'); ?>
				<?php echo $this->form->getInput('allapot');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozo'); ?>
				<?php  $wuser = JFactory::getUser($this->form->getValue('letrehozo'));  echo $wuser->name;  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('letrehozva'); ?>
				<?php echo $this->form->getValue('letrehozva');  ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lezaro'); ?>
				<?php  if ($this->form->getValue('lezaro') > 0) {
                 $wuser = JFactory::getUser($this->form->getValue('lezaro'));  
                 if (wuser) echo $wuser->name; else echo '---';
               } else {
                 echo '---';
               }     
        ?>
				<div class="clr"></div>
				<?php echo $this->form->getLabel('lezarva'); ?>
				<?php echo $this->form->getValue('lezarva');  ?>
				<div class="clr"></div>

				<?php  
				// json string szétbontása mezőkre
				$jsonStr = $form->getValue('json');
				if (($jsonStr == '') | 
				    ($jsonStr == '{}')
				   ) {
				  $jsonStr = '{ "temakor_felvivok":1, 
 "tobbszintu_atruhazas":0, 
 "atruhazas_lefele_titkos":0, 
 "kepviselet_engedelyezett":1,
 "temakor_tagsag_csakadmin":0 
}';	
					
				}
				$jsonObj = JSON_decode($jsonStr);
				// echo 'jsonStr='.$jsonStr.'<br>';
				// foreach ($jsonObj as $fn => $fv) echo $fn.'='.$fv.'<br>';
				$form2->setValue('temakor_felvivok', '', $jsonObj->temakor_felvivok);
				$form2->setValue('tobbszintu_atruhazas', '', $jsonObj->tobbszintu_atruhazas);
				$form2->setValue('atruhazas_lefele_titkos', '', $jsonObj->atruhazas_lefele_titkos);
				$form2->setValue('kepviselet_engedelyezett', '', $jsonObj->kepviselet_engedelyezett);
				$form2->setValue('temakor_tagsag_csakadmin', '', $jsonObj->temakor_tagsag_csakadmin);
				echo '<br>
				'.$form2->getLabel('temakor_tagsag_csakadmin').'
				'.$form2->getInput('temakor_tagsag_csakadmin').'<br />
				
				'.$form2->getLabel('temakor_felvivok').'
				'.$form2->getInput('temakor_felvivok').'<br />
				
				'.$form2->getLabel('kepviselet_engedelyezett').'
				'.$form2->getInput('kepviselet_engedelyezett').'<br />
				
				'.$form2->getLabel('tobbszintu_atruhazas').'
				'.$form2->getInput('tobbszintu_atruhazas').'<br />
				
				'.$form2->getLabel('atruhazas_lefele_titkos').'
				'.$form2->getInput('atruhazas_lefele_titkos').'<br />
				';
				?>
				
				</div>
			<div class="clr"></div>
      <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt"></div>
		  <?php echo JHTML::_( 'form.token' ); ?>

<?php
echo '        
<center>
  <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->Akciok['cancel'].'";
  }
  function deleteClick() {
    location="'.$this->Akciok['delete'].'";
  }
</script>
';
?>