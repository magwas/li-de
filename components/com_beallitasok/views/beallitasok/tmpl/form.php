<?php
JHTML::_('behavior.modal'); 
if ($this->Masg != '') {
  echo '<div class="errorMsg">'.$this->Msg.'</div>
  ';
}
$jsonStr = $this->form->getValue('json');
$jsonObj = JSON_decode($jsonStr);

//DBG echo 'jsonStr='.$jsonStr.'<br>';
//DBG foreach ($jsonObj as $fn => $fv) echo $fn.'='.$fv.'<br>';

$this->form->setValue('temakor_felvivok', '', $jsonObj->temakor_felvivok);
$this->form->setValue('tobbszintu_atruhazas', '', $jsonObj->tobbszintu_atruhazas);
$this->form->setValue('atruhazas_lefele_titkos', '', $jsonObj->atruhazas_lefele_titkos);
$this->form->setValue('kepviselet_engedelyezett', '', $jsonObj->kepviselet_engedelyezett);
$this->form->setValue('temakor_tagsag_csakadmin', '', $jsonObj->temakor_tagsag_csakadmin);

echo '<h2>'.JText::_('BEALLITASOKURLAP').'</h2>
<p style="text-align:right">
   <a class="akcioGomb btnHelp modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}" href="'.$this->helpLink.'">
   '.JText::_('SUGO').'
   </a>
</p>
<form action="'.$this->okLink.'" method="post">
				'.$this->form->getLabel('id').'
				'.$this->form->getInput('id').'<br />
				
				'.$this->form->getLabel('temakor_tagsag_csakadmin').'<br />
				'.$this->form->getInput('temakor_tagsag_csakadmin').'<br />
				
				'.$this->form->getLabel('temakor_felvivok').'<br />
				'.$this->form->getInput('temakor_felvivok').'<br />
				
				'.$this->form->getLabel('kepviselet_engedelyezett').'<br />
				'.$this->form->getInput('kepviselet_engedelyezett').'<br />
				
				'.$this->form->getLabel('tobbszintu_atruhazas').'<br />
				'.$this->form->getInput('tobbszintu_atruhazas').'<br />
				
				'.$this->form->getLabel('atruhazas_lefele_titkos').'<br />
				'.$this->form->getInput('atruhazas_lefele_titkos').'<br />
				
<center>
  <button type="submit" class="btnOK">'.JText::_('RENDBEN').'</button>&nbsp;
  <button type="button" class="btnCancel" onclick="cancelClick()">'.JText::_('MEGSEM').'</a>
</center>
</form>

<!-- code>
Default:
{
 "temakor_felvivok":1, // 1-regisztráltak, 2- adminok
 "tobbszintu_atruhazas":0,  // 0-nem, 1-igen
 "atruhazas_lefele_titkos":0,  // 0-nem,  1-igen
 "kepviselet_engedelyezett":1, // 0-nem,  1-igen
 "temakor_tagsag_csakadmin":0  // 0-nem,  1-igen
}
</code -->
<script type="text/javascript">
  function cancelClick() {
    location="'.$this->cancelLink.'";
  }
</script>
';
?>