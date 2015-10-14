<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


defined('_JEXEC') || die('Access Denied');
// css
WDFHelper::add_css('css/sub_toolbar_icons.css');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');

EcommercewdSubToolbar::build();

?>

<form name="adminForm" id="adminForm" action="" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend><?php echo WDFText::get('UPLOAD_TOOL');?></legend>
		<label for="upload"><?php echo WDFText::get('UPLOAD_TOOL');?> </label>
		<input type="file" name="zip_file" id="upload">
		<a href="#" onclick="Joomla.submitbutton('installtools')" class="install_button"><?php echo WDFText::get('UPLOAD_INSTALL');?>  </a>
	</fieldset>
	<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
	<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
	<input type="hidden" name="task" value=""/>
</form>
<script>var no_file = '<?php echo WDFText::get('FM_NO_FILES_CHOOSEN'); ?>'</script>
