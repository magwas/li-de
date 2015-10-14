<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


echo WDFHTML::jf_tree_generator('tree_generator');
?>

<script>
    var _callback = "<?php echo WDFInput::get('callback'); ?>";
    var _treeData = JSON.parse("<?php echo addslashes(stripslashes(WDFJson::encode($this->tree_data, 256))); ?>");
    var _opened = "<?php echo WDFInput::get('opened'); ?>";
    var _disabledNodeId = <?php echo WDFInput::get('disabled_node_id', 0, 'int'); ?>;
    var _disabledNodeAndChildrenId = <?php echo WDFInput::get('disabled_node_and_children_id', 0, 'int'); ?>;
    var _selectedNodeId = <?php echo WDFInput::get('selected_node_id', 0, 'int'); ?>;
</script>