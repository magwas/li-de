 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var _treeGenerator;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    _treeGenerator = new TreeGenerator(jQuery("#tree_generator"), _treeData);
    jQuery(_treeGenerator).on(TreeGenerator.NODE_CLICKED, onTreeNodeClicked);

    if ((_opened == "true") || (_opened == "1")) {
        _treeGenerator.openAllNodes();
    }
    if (_disabledNodeId != 0) {
        _treeGenerator.disableNode(_treeGenerator.getNodeById(_disabledNodeId));
    }
    if (_disabledNodeAndChildrenId != 0) {
        _treeGenerator.disableNode(_treeGenerator.getNodeById(_disabledNodeAndChildrenId), true);
    }
    if (_selectedNodeId != 0) {
        _treeGenerator.selectNode(_treeGenerator.getNodeById(_selectedNodeId));
    }
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTreeNodeClicked(event, node) {
    window.parent[_callback](node.id, node.name);
}