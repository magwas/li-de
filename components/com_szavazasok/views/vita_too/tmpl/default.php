<?php
/**
 * szavazasok vita1 állapotban böngésző képernyő
 * bemenet:
 * $this->Items
 *      ->Akciok      [name=>link,...]
 *      ->reorderLink
 *      ->dofilterLink
 *      ->itemLink
 *      ->Lapozosor
 *  Jrequest:  filterStr             
 */ 
// no direct access
defined('_JEXEC') or die('Restricted access');

// segéd fubction a th order -függő szinezéséhez
function thClass($col) {
  if (JRequest::getVar('order')==$col)
    $result = 'thOrdering';
  else
    $result = 'th';
  return $result;  
}


echo '
<div class="componentheading'.$this->escape($this->params->get('pageclass_sfx')).'">
';
// filterStr = keresendő_str|activeFlag szétbontása
$w = explode('|',urldecode(JRequest::getVar('filterStr','')));
if ($w[1]==1) $filterAktiv = 'checked="checked"';
echo '

<h2>'.$this->Title.'</h2>
<div class="szuroKepernyo">
  <form action="'.$this->doFilterLink.'&task=dofilter" method="post">
    <div class="szurourlap">
      '.JText::_('SZURES').'
      <input type="text" name="filterKeresendo" size="40" value="'.$w[0].'" />
      <input type="hidden" name="filterAktiv" value="" '.$filterAktiv.'" />
      <input type="hidden" name="filterStr" value="'.JRequest::getVar('filterStr','').'" />
      <button type="submit" class="btnFilter">'.JText::_('SZURESSTART').'</button>
      <button type="button" class="btnClrFilter" onclick="location='."'".$this->doFilterLink.'&filterStr='."'".'">
        '.JText::_('SZURESSTOP').'
      </button>
    </div>
  </form>
</div>

<div class="tableKepviselok'.$this->escape($this->params->get('pageclass_sfx')).'">
	<table border="0" width="100%">
  <thead>
  <tr>
    <th rowspan="2" class="'.thClass(1).'">
      <a href="'.$this->reorderLink.'&order=1">
  		'.JText::_('SZAVAZASMEGNEVEZES').'
      </a>  
    </th>
    <th colspan="4">'.JText::_('SZAVAZASALLAPOT').'</th>
    <th rowspan="2" class="'.thClass(6).'">
      <a href="'.$this->reorderLink.'&order=6">
  		'.JText::_('SZAVAZAS_VEGE').' 
      </a>  
    </th>
    <th rowspan="2" class="'.thClass(7).'">
      <a href="'.$this->reorderLink.'&order=7">
  		'.JText::_('TITKOSSAG').' 
      </a>  
    </th>
    <th rowspan="2" class="'.thClass(8).'">
  		'.JText::_('VITA2_VEGE').' 
    </th>
    
  </tr>
  <tr>
    <th class="'.thClass(2).'">
      <a href="'.$this->reorderLink.'&order=2">
  		'.JText::_('SZAVAZASVITA1').' 
      </a>  
    </th>
    <th class="'.thClass(3).'">
      <a href="'.$this->reorderLink.'&order=3">
  		'.JText::_('SZAVAZASVITA2').' 
    </th>
    <th class="'.thClass(4).'">
      <a href="'.$this->reorderLink.'&order=4">
  		'.JText::_('SZAVAZAS').' 
      </a>  
    </th>
    <th class="'.thClass(5).'">
      <a href="'.$this->reorderLink.'&order=5">
  		'.JText::_('LEZART').' 
      </a>  
    </th>
    
  </tr>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  if (count($this->items) > 0) {
	  foreach ($this->Items as $item) { 
		  if (($item->user_id  == '') | ($item->kepviselo_id > 0))
			$szavaztal = '';
		  else
			$szavaztal = '<img src="images/stories/ok.gif" />';
		  if ($item->vita1 == 1) $item->vita1 = 'X'; else $item->vita1 = '';    
		  if ($item->vita2 == 1) $item->vita2 = 'X'; else $item->vita2 = '';    
		  if ($item->szavazas == 1) $item->szavazas = 'X'; else $item->szavazas = '';    
		  if ($item->lezart == 1) $item->lezart = 'X'; else $item->lezart = '';    
			echo '<tr class="'.$rowClass.'">';
		  $link = $this->itemLink.'&temakor='.$item->temakor_id.'&szavazas='. $item->id;
		  if ($item->titkos==0) $item->titkos = JText::_('NYILT');
		  if ($item->titkos==1) $item->titkos = JText::_('TITKOS');
		  if ($item->titkos==2) $item->titkos = JText::_('SZIGORUANTITKOS');
			echo '<td><a href="'.$link.'">'.$item->megnevezes.'</a></td>
			<td align="center">'.$item->vita1.'</td>
			<td align="center">'.$item->vita2.'</td>
			<td align="center">'.$item->szavazas.'</td>
			<td align="center">'.$item->lezart.'</td>
			<td align="center">'.$item->szavazas_vege.'</td>
			<td align="center">'.$item->titkos.'</td>
			<td align="center">'.$item->vita2_vege.'</td>
			</tr>
		   '; 
		   if ($rowClass == 'row0') $rowClass='row1'; else $rowClass='row0';
	  }
  } else {
     echo '<tr><td colspan="6">'.JText::_('SZAVAZASOK_NO_DATA').'</td></tr>	  
	 ';
  }  
echo '
</tbody>
</table>		
<div class="lapozosor">
  '.$this->LapozoSor.'
</div>
</div>
';
?>