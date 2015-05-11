<?php
/**
 * alternativak böngésző képernyő = szavazazás adatlap
 * bemenet:
 * $this->Items
 *      ->temakor
 *      ->szavazas   
 *      ->Akciok      [name=>link,...]
 *      ->Kepviselo   [kepviselojeLink=>link, kepviselojeloltLink=>link,.....]
 *      ->altKepviselo
 *      ->reorderLink
 *      ->itemLink
 *      ->Lapozosor
 *      ->CommentId  comments megjelenitéshez cikk ID 
 *  Jrequest:  filterStr             
 */ 
//+ 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
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

// Szavazaás kiirása
//$szuser = JFactory::getUser($this->Szavazas->letrehozo);
// $szuser->load($this->Szavazas->letrehozo);
$db = JFactory::getDBO();
$db->setQuery('SELECT email,name from #__users WHERE id="'.$this->Szavazas->letrehozo.'"');
$szuser = $db->loadObject();
if ($szuser) 
   $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $szuser->email )));
else
   $grav_url = '';    
echo '<div class="szavazasfej">
<h3>'.$this->Szavazas->megnevezes.'
  <a href="javascript:szinfoClick()" class="akcioIkon btnInfo" title="Infó" id="btnszinfo" style="display:none">&nbsp;</a>';
  if ($this->Akciok['szavazasedit'] != '') {  
      echo '<a href="'.$this->Akciok['szavazasedit'].'" class="akcioIkon beallitasokGomb" title="'.JText::_('SZAVAZASBEALLITASOK').'">&nbsp;</a>';
  }
  if ($this->Akciok['copy'] != '') {  
      echo '<a href="'.$this->Akciok['copy'].'" class="akcioIkon copyGomb" title="'.JText::_('MASOLAS_VAGOLAPRA').'">&nbsp;</a>';
  }
  if ($this->Szavazas->vita1 == 1) echo JText::_('ALLAPOT_VITA1');
  if ($this->Szavazas->vita2 == 1) echo JText::_('ALLAPOT_VITA2');
  if ($this->Szavazas->szavazas == 1) echo JText::_('ALLAPOT_SZAVAZAS');
  if ($this->Szavazas->lezart == 1) echo JText::_('ALLAPOT_LEZART');
  if ($this->Szavazo) {
    if (($this->Szavazo->user_id > 0) & ($this->Szavazo->kepviselo_id == 0))
      echo '&nbsp;<img src="images/stories/ok.gif" title="'.JText::_('SZAVAZTAL').'" />';
  }
  if ($this->szavaztak > 0) {
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.JText::_('EDDIG_SZAVAZTAK').':'.$this->szavaztak.'&nbsp;';
  }
echo '  
</h3>
</div>
<div id="szavazasInfo" style="display:block;">
  <p style="text-align:right">
    <button type="button" onclick="szinfoClose()"><b>X</b></button>
  </p>
  <div style="float:left; width:60px">
  <img src="'.$grav_url.'" width="50" /><br />'.$szuser->name.'
  </div>
  '.$this->Szavazas->leiras.'
  <p>Létrehozva/módosítva:'.$this->Szavazas->letrehozva.
    ' Vita1 vége:'.$this->Szavazas->vita1_vege.
    ' Vita2 vége:'.$this->Szavazas->vita2_vege.
    ' Szavazás vége:'.$this->Szavazas->szavazas_vege.'</p>
</div>
';


echo '
<div class="kepviselo">
';
      if ($this->AltKepviselo['kepviselojeLink'] != '') {
        echo '<a class="btnKepviselo" href="'.$this->AltKepviselo['kepviselojeLink'].'">
             '.$this->AltKepviselo['image'].'
             <br />'.$this->AltKepviselo['nev'].'
             <br />'.JText::_('GLOBALISKEPVISELO').'
             </a>
             ';
      }       
      if ($this->Kepviselo['kepviselojeLink'] != '') {
        echo '<a class="btnKepviselo" href="'.$this->Kepviselo['kepviselojeLink'].'">
             '.$this->Kepviselo['image'].'
             <br />'.$this->Kepviselo['nev'].'
             <br />'.JText::_('TEMAKORKEPVISELO').'
             </a>
             ';
      };
echo '
</div>
<div class="clr"></div>
<div class="akciogombok">
';
if ($this->Akciok['ujAlternativa'] != '') {
      echo '<a href="'.$this->Akciok['ujAlternativa'].'" class="akcioGomb ujGomb">'.JText::_('UJALTERNATIVA').'</a>
      ';
}  
echo '<a href="'.$this->Akciok['deleteSzavazas'].'" class="akcioGomb btnAltDelete" styla="height:30px; margin-top:-4px">'.JText::_('SZAVAZASTORLES').'</a>
';

if ($this->Akciok['szavazok'] != '') {
      echo '<a href="'.$this->Akciok['szavazok'].'" class="akcioGomb btnSzavazok" >'.JText::_('SZAVAZOK').'</a>
      ';
} 
//if ($this->Akciok['szavaztal'] != '') {
//      echo '<span class="szavaztal">'.JText::_('SZAVAZTAL').'</span>';
//}
if ($this->Akciok['szavazatTorles'] != '') {
      echo '<a href="'.$this->Akciok['szavazatTorles'].'" class="akcioGomb btnSzavazatDelete" >'.JText::_('SZAVAZATOMTORLESE').'</a>
      ';
}
 
 
if ($this->Akciok['eredmeny'] != '') {
      //echo '<a href="'.$this->Akciok['eredmeny'].'" class="akcioGomb btnEredmeny" onMouseDown="alter(123456);">'.JText::_('EREDMENY').'</a>
      echo '<a class="akcioGomb btnEredmeny" onClick="eredmenyClick();" style="cursor:pointer">'.JText::_('EREDMENY').'</a>
      ';
}  
if ($this->Akciok['emailszavazas'] != '') {
      echo '<a class="akcioGomb btnEmailSzavazas" style="cursor:pointer" href="'.$this->Akciok['emailszavazas'].'">'.JText::_('EMAILMEGHIVO').'</a>
      ';
}  

echo '<a href="'.$this->backLink.' "class="akcioGomb btnBack">'.JText::_('SZAVAZASOK').'</a>
      <a href="'.$this->homeLink.'" class="akcioGomb btnBack">'.JText::_('TEMAKOROK').'</a>
      <a href="'.$this->Akciok['sugo'].'" class="akcioGomb btnHelp modal" 
          rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">'.JText::_('SUGO').'</a>
';      
    
echo '
</div>
<div class="tableKepviselok'.$this->escape($this->params->get('pageclass_sfx')).'">
	<table border="0" width="100%">
  <thead>
  </thead>
  <tbody>
  ';
  $rowClass = 'row0';
  foreach ($this->Items as $item) { 
      if ($this->itemLink != '') {  
        $link = $this->itemLink.'&alternativa='. $item->id;
        //+ 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
        if ($this->isAdmin | 
            $this->temakor_admin |
            ($item->letrehozo == $this->user->id)
           ) {
       	  echo '<tr class="'.$rowClass.'">
          <td> * <a class="alternativaNev" href="'.$link.'">'.$item->megnevezes.'</a>
              <blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
          </td>
          </tr>
         ';
       } else {
       	  echo '<tr class="'.$rowClass.'">
          <td> * <span class="alternativaNev">'.$item->megnevezes.'</span>
              <blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
          </td>
          </tr>
         ';
       }   
       //- 2014.09.10 Az alternativa név csak akkor link ha jogosult módosítani
     } else {
     	  echo '<tr class="'.$rowClass.'">
        <td> * '.$item->megnevezes.'
            <blockquote class="alternativaInfo">'.$item->leiras.'</blockquote>
        </td>
        </tr>
       '; 
     }  
  } 
echo '
</tbody>
</table>		
<div class="lapozosor">
  '.$this->LapozoSor.'
</div>
<div id="divTurelem" style="display:none;">
<h1>Türelmet kérek...</h1>
</div>
<script type="text/javascript">
  function infoClick() {
    document.getElementById("temakorInfo").style.display="block";
  }
  function infoClose() {
    document.getElementById("temakorInfo").style.display="none";
  }
  function szinfoClick() {
    document.getElementById("szavazasInfo").style.display="block";
    document.getElementById("btnszinfo").style.display="none";
  }
  function szinfoClose() {
    document.getElementById("szavazasInfo").style.display="none";
    document.getElementById("btnszinfo").style.display="inline-block";
  }
  function eredmenyClick() {
    document.getElementById("divTurelem").style.display="block";
    setInterval("turelemAnimacio()",100);
    location = "'.$this->Akciok['eredmeny'].'";
  }
  function turelemAnimacio() {
    // esetleg itt lehet valami animáció
    d = document.getElementById("divTurelem");
  }
  
</script>
';

// kommentek megjelenitése
if ($this->CommentId > 0) {
  echo JComments::show($this->CommentId, 'com_content', $this->Szavazas->megnevezes);
}

// fórum, jdownload, jevent gombok
include 'components/com_jumi/files/forum.php'; 
?>