<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

jimport('joomla.html.html.tabs');

// css
WDFHelper::add_css('css/layout_' . $this->_layout . '.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/jquery-ui-1.10.3.js');
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$row_default_currency = $this->default_currency_row;
$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );

?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php

	WDFHTMLTabs::startTabs('tab_group_products', WDFInput::get('tab_index'), 'onTabActivated');

    WDFHTMLTabs::startTab('general', WDFText::get('GENERAL'));
	echo $this->loadTemplate('general');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('data', WDFText::get('DATA'));
	echo $this->loadTemplate('data');	
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('links', WDFText::get('LINKS'));
	echo $this->loadTemplate('links');	
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('parameters', WDFText::get('PARAMETERS'));
	echo $this->loadTemplate('parameters');	
    WDFHTMLTabs::endTab();
	
	WDFHTMLTabs::startTab('shipping', WDFText::get('SHIPPING'));
	echo $this->loadTemplate('shipping');	
	WDFHTMLTabs::endTab();	
	
    WDFHTMLTabs::startTab('media', WDFText::get('MEDIA'));
	echo $this->loadTemplate('media');	
    WDFHTMLTabs::endTab();	
	
	if ( WDFInput::get_task() == "edit" or  WDFInput::get_task() == "edit_refresh" ) {
		WDFHTMLTabs::startTab('feedback', WDFText::get('FEEDBACK'));
		echo $this->loadTemplate('feedback');	
		WDFHTMLTabs::endTab();		
	}
    WDFHTMLTabs::endTabs();

	echo JHtml::_('tabs.end');
	?>
<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
<input type="hidden" name="date_added" value="<?php echo $row->date_added; ?>"/>
<input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>"/>
</form>

<script>
    var _categoryId = "<?php echo $row->category_id; ?>";

    var _manufacturerId = "<?php echo $row->manufacturer_id; ?>";
	
    var _imageUrls = JSON.parse("<?php echo addslashes(stripslashes($row->images)); ?>");
	
    var _videoUrls = JSON.parse("<?php echo addslashes(stripslashes($row->videos)); ?>");
		
    var _parameters = JSON.parse("<?php echo $row->parameters; ?>");
	
    var _categoryParameters = JSON.parse("<?php echo $row->category_parameters; ?>");

    var _tags = JSON.parse("<?php echo $row->tags; ?>");
    var _categoryTags = JSON.parse("<?php echo $row->category_tags; ?>");
	
	var _default_shipping = <?php echo $row->default_shipping ;?>;
	
	var _url_root = "<?php echo JURI::root() ; ?>";

	var _dimensions = "<?php echo $row->_dimensions;?> ";
	
	var _isJ3 = "<?php echo WDFHelper::is_j3() ? 1 : 0;?> ";
</script>
