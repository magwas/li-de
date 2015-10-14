 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


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
    var users = [];
    jQuery("form[name=adminForm] input[type=checkbox][name^=cid]:checked").each(function () {
        var thisTr = jQuery(this).closest("tr");

        var user = {};
        user.id = jQuery(thisTr).attr("itemId");
        user.name = jQuery(thisTr).attr("itemName");
        users.push(user);
    });

    window.parent[_callback](users);
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
function onBtnUpdateClick(event, obj) {
    submitCheckedItems();
}