<?php
/**
 * szavazoknak küldendő körlevél form
 * bemenet:
 * $this->Szavazas
 *      .>Temakor 
 *      ->Akciok      [cancel,send]
 */ 
// no direct access
defined('_JEXEC') or die('Restricted access');
$editor =& JFactory::getEditor();
$s = '<p><a href="'.JURI::base().'index.php'.
'?option=com_alternativak&task=browse'.
'&szavazas='.$this->Szavazas->id.
'&temakor='.$this->Szavazas->temakor_id.'">'.$this->Szavazas->megnevezes.'</a></p>';

echo '<pre><code>'.$s.'</code></pre>';

echo '
<div class="emailform">
<form action="'.$this->Akciok['send'].'" method="post">
<h2>'.$this->Temakor->megnevezes.'</h2>
<h3>'.$this->Szavazas->megnevezes.'</h3>
<h4>'.JText::_('EMAILFORM').'</h4>
<p>'.JText::_('SUBJECT').':<br /><input type="text" name="subject" size="60"/></p>
<p>'.JText::_('MAILBODY').':<br />
  '.$editor->display('mailbody', $s, '550', '400', '60', '20', false).'
</p>
<center>
   <button type="submit" class="btnOK">'.JText::_('SEND').'</button>&nbsp;
   <button type="button" class="btnCancel" onclick="location='."'".$this->Akciok['cancel']."'".';">'.JText::_('CANCEL').'</button>
</center>
</form>
</div>
';
?>