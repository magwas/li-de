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
WDFHelper::add_css('css/sub_toolbar_icons.css');
WDFHelper::add_css('css/layout_edit.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_edit.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;
$initial_values = $options['initial_values'];
$default_values = $options['default_values'];


EcommercewdSubToolbar::build();
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <?php
    WDFHTMLTabs::startTabs('tab_group_options', WDFInput::get('tab_index'), 'onTabActivated');
	
	WDFHTMLTabs::startTab('products_data', WDFText::get('PRODUCTS_DATA'));
    echo $this->loadTemplate('products_data');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_registration', WDFText::get('REGISTRATION_OPTIONS'));
    echo $this->loadTemplate('registration');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_user_data', WDFText::get('USER_DATA_FIELDS'));
    echo $this->loadTemplate('user_data');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_checkout', WDFText::get('CHECKOUT'));
    echo $this->loadTemplate('checkout');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_feedback', WDFText::get('FEEDBACK'));
    echo $this->loadTemplate('feedback');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_search_and_sort', WDFText::get('SEARCH_AND_SORT'));
    echo $this->loadTemplate('search_and_sort');
    WDFHTMLTabs::endTab();

	
    WDFHTMLTabs::startTab('options_social_media_integration', WDFText::get('SOCIAL_MEDIA_INTEGRATION'));
    echo $this->loadTemplate('social_media_integration');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::startTab('options_other', WDFText::get('OTHER'));
    echo $this->loadTemplate('other');
    WDFHTMLTabs::endTab();

    WDFHTMLTabs::endTabs();

    echo JHtml::_('tabs.end');
    ?>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>"/>
</form>

<script>
    var _optionsInitialValues = JSON.parse("<?php echo addslashes(stripslashes(WDFJson::encode($initial_values, 256))); ?>");
    var _optionsDefaultValues = JSON.parse("<?php echo addslashes(stripslashes(WDFJson::encode($default_values, 256))); ?>");
</script>