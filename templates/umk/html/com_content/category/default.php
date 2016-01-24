<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');
?>
<div class="kapcsolodoCikkek">
<?php
// li-de témakör/szavazás elérése, megjelenitése
$temakor_id = '';
$szavazas_id = '';
$db = JFactory::getDBO();
$session = JFactory::getSession();
$db->setQuery('select * from #__categories where id='.$db->quote(JRequest::getVar('id')));
$res = $db->loadObject();
if ($res) {
	if (substr($res->alias,0,2)=='sz') {
	   // lehet hogy szavazáshoz rendelt kategoria
	   $szavazas_id = substr($res->alias,2,10);
	   $db->setQuery('select * from #__categories where id = '.$res->parent_id);
	   $res = $db->loadObject();
	   if ($res) {
		   if ($res->parent_id == 82) {
			   $temakor_id = substr($res->alias,1,10);
		   } else {
			   $szavazas_id = '';
		   }
	   } else {
		   $szavazas_id = '';
	   }
	}
	if ((substr($res->alias,0,1)=='t') and ($res->parent_id == 82)) {
	   $temakor_id = substr($res->alias,1,10);
    }
}
if ($temakor_id != '')	{
	JRequest::setVar('temakor',$temakor_id);
	$akciok = array();
	$akciok['ujSzavazas'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=add&temakor='.$temakor_id.'&limit=20&limitstart=0&order=6';
	$session->set('akciok', $akciok);
	$db->setQuery('select * from #__temakorok where id='.$temakor_id);
	$temakor = $db->loadObject();
	if ($szavazas_id != '') {
	  $db->setQuery('select * from #__szavazasok where id='.$szavazas_id);
	  $szavazas = $db->loadObject();
	}
	?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<div class="temakorDoboz">
			<div class="dobozFejlec">
			    <a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo $temakor_id; ?>">
				  <img class="temakorKep" src="<?php echo kepLeirasbol($temakor->leiras); ?>" />
				  Témakör: <h2><?php echo $temakor->megnevezes; ?></h2>
				</a>
			</div>
			<div class="temakorLeiras"><?php echo utf8Substr($temakor->leiras,0,10000); ?></div>
		</div>
		<?php if ($szavazas_id != '') : ?>
		<div class="szavazasDoboz">
			<div class="dobozFejlec">
				<a href="<?php echo JURI::base(); ?>index.php?option=com_alternativak&view=alternativaklist&task=browse&temakor=<?php echo $temakor_id; ?>&szavazas=<?php echo $szavazas_id; ?>">
				  <img class="szavazasKep" src="<?php echo kepLeirasbol($szavazas->leiras); ?>" />
			      <h3><?php echo $szavazas->megnevezes; ?></h3>
				</a>
			</div>
			<div class="szavazasLeiras"><?php echo utf8Substr($szavazas->leiras,0,10000); ?></div>
		</div>
		<?php endif; ?>
	</div><!-- componetheading -->
	<div class="clr"></div>	
	<?php
}

?>
<b>Kapcsolódó cikkek</b>
<div class="category-list<?php echo $this->pageclass_sfx;?>">
<?php
$this->subtemplatename = 'articles';
echo JLayoutHelper::render('joomla.content.category_default', $this);
?>

</div>
</div>