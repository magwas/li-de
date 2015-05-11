<?php
/* ez egy include file amit több képernyő tmpl -is
   behív.  Célja a kunena és jdownloader hívó gomb megjelenítése
   a temakor, szavazas, id JRequest paraméterek alapján és
   a $this->temakorGroupId alapján
   szükség esetén kreálja a kategoriákat
   
   string mysql_escape_string 
    
*/
$db = JFactory::getDBO();
$option = JRequest::getVar('option','');
$temakor = JRequest::getVar('temakor','');
$szavazas = JRequest::getVar('szavazas','');
$id = JRequest::getVar('id','');
if ($id == '') $id = JRequest::getVar('user_id');
$forumAlias = 'otletlada';
$filesAlias = '';
$createSql = '';  // kunena forum kategoria
$createSql2 = ''; // jdownloader kategoria
// Ha a hívó controller beállított TemakorGroupId -t akkor  (szükség esetén)
// korlátozott elérésü kunena és Jdownloader kategoriát kell
// létrehozni

if (($this->TemakorGroupId == '') | ($this->TemakorGroupId == 0)) {
  $temakorGroupId = 1;
  $params = '';
  $cat_access = 11;
  $cat_group_access = 0;
} else {
  $temakorGroupId = $this->TemakorGroupId;
  $params = '{\"access_post\":[\"6\",\"'.$temakorGroupId.'\"],\"access_replay\":[\"6\",\"'.$temakorGroupId.'\"]}';
  $db->setQuery('select id
  from #__jdownloads_groups
  where groups_name like "{'.$temakor.'}%"');
  $res = $db->loadObject();
  if ($res) {
    $cat_access = 99;
    $cat_group_access = $res->id;
  } else {
    $cat_access = 11;
    $cat_group_access = 0;
  }  
}
if (($option == 'com_kepviselok') | ($option == 'com_kepviselojeloltek')) {
   // képviselő
   $forumAlias = 'K'.$id;
   $filesAlias = 'K'.$id;
   $kuser = JFactory::getUser($id);
   $createSql = 'INSERT INTO #__kunena_categories 
	(`parent_id`, 
	`name`, 
	`alias`, 
	`icon_id`, 
	`locked`, 
	`accesstype`, 
	`access`, 
	`pub_access`, 
	`pub_recurse`, 
	`admin_access`, 
	`admin_recurse`, 
	`ordering`, 
	`published`, 
	`channels`, 
	`checked_out`, 
	`checked_out_time`, 
	`review`, 
	`allow_anonymous`, 
	`post_anonymous`, 
	`hits`, 
	`description`, 
	`headerdesc`, 
	`class_sfx`, 
	`allow_polls`, 
	`topic_ordering`, 
	`numTopics`, 
	`numPosts`, 
	`last_topic_id`, 
	`last_post_id`, 
	`last_post_time`, 
	`params`
	)
	VALUES
	(7, 
	"'.mysql_escape_string($kuser->name).'", 
	"K'.$id.'", 
	"", 
	0, 
	"joomla.group", 
	0, 
	'.$temakorGroupId.', 
	1, 
	0, 
	1, 
	1, 
	1, 
	"", 
	0, 
	0, 
	0, 
	0, 
	0, 
	0, 
	"", 
	"", 
	"", 
	0, 
	"lastpost", 
	0, 
	0, 
	0, 
	0, 
	0, 
	"'.$params.'"
	);
  ';
  $createSql2 = 'INSERT INTO #__jdownloads_cats 
	(`cat_dir`, 
	`parent_id`, 
	`cat_title`, 
	`cat_alias`, 
	`cat_description`, 
	`cat_pic`, 
	`cat_access`, 
	`cat_group_access`, 
	`metakey`, 
	`metadesc`, 
	`jaccess`, 
	`jlanguage`, 
	`ordering`, 
	`published`, 
	`checked_out`, 
	`checked_out_time`
	)
	VALUES
	("li-de/'.$filesAlias.'", 
	9, 
	"'.mysql_escape_string($kuser->name).'", 
	"'.$filesAlias.'", 
	"", 
	"folder.png", 
	'.$cat_access.', 
	'.$cat_group_access.', 
	"", 
	"", 
	0, 
	"", 
	0, 
	1, 
	0, 
	0
	);
  ';
} else if (($option == 'com_temakorok') | 
           ($option == 'com_szavazasok') |
           ($option == 'com_alternativak')) {
  if ($szavazas > 0) {
    $forumAlias = 'SZ'.$szavazas;
    $filesAlias = 'SZ'.$szavazas;
   $createSql = 'INSERT INTO #__kunena_categories 
	(`parent_id`, 
	`name`, 
	`alias`, 
	`icon_id`, 
	`locked`, 
	`accesstype`, 
	`access`, 
	`pub_access`, 
	`pub_recurse`, 
	`admin_access`, 
	`admin_recurse`, 
	`ordering`, 
	`published`, 
	`channels`, 
	`checked_out`, 
	`checked_out_time`, 
	`review`, 
	`allow_anonymous`, 
	`post_anonymous`, 
	`hits`, 
	`description`, 
	`headerdesc`, 
	`class_sfx`, 
	`allow_polls`, 
	`topic_ordering`, 
	`numTopics`, 
	`numPosts`, 
	`last_topic_id`, 
	`last_post_id`, 
	`last_post_time`, 
	`params`
	)
	VALUES
	(6, 
	"'.mysql_escape_string($this->Szavazas->megnevezes).'", 
	"SZ'.$szavazas.'", 
	"", 
	0, 
	"joomla.group", 
	0, 
	'.$temakorGroupId.', 

	1, 
	0, 
	1, 
	1, 
	1, 
	"", 
	0, 
	0, 
	0, 
	0, 
	0, 
	0, 
	"", 
	"", 
	"", 
	0, 
	"lastpost", 
	0, 
	0, 
	0, 
	0, 
	0, 
	"'.$params.'"
	);
  ';
  $createSql2 = 'INSERT INTO #__jdownloads_cats 
	(`cat_dir`, 
	`parent_id`, 
	`cat_title`, 
	`cat_alias`, 
	`cat_description`, 
	`cat_pic`, 
	`cat_access`, 
	`cat_group_access`, 
	`metakey`, 
	`metadesc`, 
	`jaccess`, 
	`jlanguage`, 
	`ordering`, 
	`published`, 
	`checked_out`, 
	`checked_out_time`
	)
	VALUES
	("li-de/'.$filesAlias.'", 
	8, 
	"'.mysql_escape_string($this->Szavazas->megnevezes).'", 
	"'.$filesAlias.'", 
	"", 
	"folder.png", 
	'.$cat_access.', 
	'.$cat_group_access.', 
	"", 
	"", 
	0, 
	"", 
	0, 
	1, 
	0, 
	0
	);
  ';
  } else if ($temakor > 0) {
    $forumAlias = 'T'.$temakor;
    $filesAlias = 'T'.$temakor;
   $createSql = 'INSERT INTO #__kunena_categories 
	(`parent_id`, 
	`name`, 
	`alias`, 
	`icon_id`, 
	`locked`, 
	`accesstype`, 
	`access`, 
	`pub_access`, 
	`pub_recurse`, 
	`admin_access`, 
	`admin_recurse`, 
	`ordering`, 
	`published`, 
	`channels`, 
	`checked_out`, 
	`checked_out_time`, 
	`review`, 
	`allow_anonymous`, 
	`post_anonymous`, 
	`hits`, 
	`description`, 
	`headerdesc`, 
	`class_sfx`, 
	`allow_polls`, 
	`topic_ordering`, 
	`numTopics`, 
	`numPosts`, 
	`last_topic_id`, 
	`last_post_id`, 
	`last_post_time`, 
	`params`
	)
	VALUES
	(4, 
	"'.mysql_escape_string($this->Temakor->megnevezes).'", 
	"T'.$temakor.'", 
	"", 
	0, 
	"joomla.group", 
	0, 
	'.$temakorGroupId.', 
	1, 
	0, 
	1, 
	1, 
	1, 
	"", 
	0, 
	0, 
	0, 
	0, 
	0, 
	0, 
	"", 
	"", 
	"", 
	0, 
	"lastpost", 
	0, 
	0, 
	0, 
	0, 
	0, 
	"'.$params.'"
	);
  ';
  $createSql2 = 'INSERT INTO #__jdownloads_cats 
	(`cat_dir`, 
	`parent_id`, 
	`cat_title`, 
	`cat_alias`, 
	`cat_description`, 
	`cat_pic`, 
	`cat_access`, 
	`cat_group_access`, 
	`metakey`, 
	`metadesc`, 
	`jaccess`, 
	`jlanguage`, 
	`ordering`, 
	`published`, 
	`checked_out`, 
	`checked_out_time`
	)
	VALUES
	("li-de/'.$filesAlias.'", 
	3, 
	"'.mysql_escape_string($this->Temakor->megnevezes).'", 
	"'.$filesAlias.'", 
	"", 
	"folder.png", 
	'.$cat_access.', 
	'.$cat_group_access.', 
	"", 
	"", 
	0, 
	"", 
	0, 
	1, 
	0, 
	0
	);
  ';
  
  }  
} 
echo '<center>
<b><i>A demokrácia lényege nem a szavazás, hanem a konszenzusra törekvő eszmecsere!</i></b><br />
';
if ($forumAlias != '') {
  $db->setQuery('select id from #__kunena_categories where alias="'.$forumAlias.'"');
  $res = $db->loadObject();
  if ($res == false) {
    if ($createSql != '') {
      //DBG echo '<p>createSql'.$result.' '.$createSql.'</p>';
      $db->setQuery($createSql);
      $db->query();
      $db->setQuery('select id from #__kunena_categories where alias="'.$forumAlias.'"');
      $res = $db->loadObject();
    }
  }
  if ($res) {
    $forumUrl = JURI::base().'index.php?option=com_kunena&view=category&catid='.$res->id;
    echo  '<a class="akcioGomb btnForum" href="'.$forumUrl.'" target="forum">'.JText::_('FORUM').'</a>
    ';
  }  
}
if ($filesAlias != '') {
  $db->setQuery('select cat_id from #__jdownloads_cats where cat_alias="'.$filesAlias.'"');
  $res = $db->loadObject();
  if ($res == false) {
    if ($createSql2 != '') {
      $db->setQuery($createSql2);
      $db->query();
      $db->setQuery('select cat_id from #__jdownloads_cats where cat_alias="'.$filesAlias.'"');
      $res = $db->loadObject();
      mkdir(JPATH_SITE.'/jdownloads/li-de/'.$filesAlias,0777);
    }
  }
  if ($res) {
    $filesUrl = JURI::base().'index.php?option=com_jdownloads&view=category&catid='.$res->cat_id;
    echo  '<a class="akcioGomb btnFiles" href="'.$filesUrl.'" target="files">'.JText::_('FILES').'</a>
    ';
  }  
}
echo '</center>
';
  
?>