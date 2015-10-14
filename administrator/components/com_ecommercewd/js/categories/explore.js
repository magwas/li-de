 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function submitCheckedItems() {
    jQuery("form[name=adminForm] input[type=checkbox][name^=cid]:checked").each(function () {
        var jq_thisTr = jQuery(this).closest("tr");
        var category = {};
        category.id = jq_thisTr.attr("itemId");
        category.name = jq_thisTr.attr("itemName");
        category.level = jq_thisTr.attr("itemLevel");	
        category.tree = jq_thisTr.attr("itemTree");

        window.parent[_callback](category);
    });

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
function onItemClick(event, obj) {
    jQuery("form[name=adminForm] input[type=checkbox][name=checkall-toggle]").prop("checked", false);
    jQuery("form[name=adminForm] input[type=checkbox][name^=cid]").prop("checked", false);
    jQuery(obj).closest("tr").find("input[type=checkbox][name^=cid]").prop("checked", true);
    submitCheckedItems();
}

function onBtnInsertClick(event, obj) {
    submitCheckedItems();
}