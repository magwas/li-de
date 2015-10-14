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

var _tagBox;



////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function () {
	Joomla.submitbutton = onAdminFormSubmit;
    // tags
    _tagBox = new ModuleBox(jQuery("#tag_box"));
    for (var i = 0; i < _tags.length; i++) {
        _tagBox.addItem(_tags[i]);
    }

	
	if( _tags.length == 0 )		
		jQuery( "#tag_box .jf_module_box_item_all" ).html("All");
		
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////

// tags
function addTag(tag) {
    _tagBox.addItem(tag);
}
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////


// tags
function showTags(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=tags" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}

function fillInputTagIds() {
    var tags = _tagBox.getItemDatas();
    var tagIds = [];
    for (var i = 0; i < tags.length; i++) {
        var tag = tags[i];
        tagIds.push(tag.id);
    }
    adminFormSet( tag_name, JSON.stringify(tagIds));
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////

// tags
function onBtnAddTagsClick(event, obj) {
	jQuery("#tag_box .jf_module_box_item_all").hide();
    showTags("addTag");
}

function onBtnRemoveAllTagsClick(event, obj) {
    _tagBox.removeAllItems();
}


function onAdminFormSubmit(pressbutton) {
    switch (pressbutton) {
        case "item.apply":
        case "item.save":
        case "item.save2new":
        case "item.save2copy":
			fillInputTagIds();
            break;
    }
    Joomla.submitform(pressbutton,document.getElementById("item-form"));
}
