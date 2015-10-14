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

WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');

$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );

?>

<form name="adminForm" id="adminForm" action="" method="post">
<?php
	switch(WDFInput::get("type")){
		case 'stripe':
		case 'authorizenetaim':
		case 'authorizenetdpm':
			$_cc_fields = $row->json_cc_fields;
			WDFHTMLTabs::startTabs('payment_options', WDFInput::get('tab_index'), 'onTabActivated');

			WDFHTMLTabs::startTab('options_api', WDFText::get('API_OPTIONS'));
			echo $this->loadTemplate('apioptions');
			WDFHTMLTabs::endTab();

			WDFHTMLTabs::startTab('options_gneral', WDFText::get('CREDIT_CARD_FIELDS'));
			echo $this->loadTemplate('generaloptions');
			WDFHTMLTabs::endTab();
			
			WDFHTMLTabs::endTabs();
			echo JHtml::_('tabs.end');
		break;
		
		case 'without_online_payment':
		case 'paypalexpress':
		case 'authorizenetsim':
			$_cc_fields= '{}';
			echo $this->loadTemplate('apioptions');
		break;	
	}

?>
<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
<input type="hidden" name="short_name" value="<?php echo WDFInput::get("type"); ?>"/>
<input type="hidden" name="name" value="<?php echo $row->name; ?>"/>
<input type="hidden" name="options" value=""/>
<input type="hidden" name="type" value="<?php echo $row->short_name; ?>"/>
<input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>"/>
</form>
<script> 
	var _fields = '<?php echo $row->options; ?>';
	var _cc_fields = '<?php echo $_cc_fields; ?>';
	var payment_method = '<?php echo WDFInput::get("type"); ?>';
</script>




