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
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    for (var i = 0; i < _selectedIds.length; i++) {
        var selectedId = _selectedIds[i];
        jQuery("form[name=adminForm] input[type=checkbox][name^=cid][value=" + selectedId + "]").prop("checked", true);
    }
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function submitCheckedItems() {
    var pages = [];
    jQuery("form[name=adminForm] input[type=checkbox][name^=cid]:checked").each(function () {
        var jq_thisTr = jQuery(this).closest("tr");
        var page = {};
        page.id = jq_thisTr.attr("itemId");
        page.title = jq_thisTr.attr("itemTitle");
        pages.push(page);
    });
    window.parent[_callback](pages);
    window.parent.SqueezeBox.close();
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnSelectClick(event, obj) {
    submitCheckedItems();
}