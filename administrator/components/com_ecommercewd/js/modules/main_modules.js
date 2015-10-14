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

var _categoryBox;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function () {
	Joomla.submitbutton = onAdminFormSubmit;
	
	//categories
	_categoryBox = new ModuleBox(jQuery("#category_box"));
    for (var i = 0; i < _categories.length; i++) {
        _categoryBox.addItem(_categories[i]);
    }
	
	if( _categories.length == 0 )
		jQuery( "#category_box .jf_module_box_item_all" ).html("All");
		
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////

// categories
function addCategory(category) {
    _categoryBox.addItem(category);
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////

// categories
function showCategories(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=categories" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}

function fillInputCategoryIds() {
    var categories = _categoryBox.getItemDatas("#category_box");
    var categoryIds = [];
    for (var i = 0; i < categories.length; i++) {
        var category = categories[i];
        categoryIds.push(category.id);
    }
    adminFormSet( category_name, JSON.stringify(categoryIds));
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////


// categories
function onBtnAddCategoriesClick(event, obj) {
	jQuery("#category_box .jf_module_box_item_all").hide();
    showCategories("addCategory");		
}

function onBtnRemoveAllCategoriesClick(event, obj) {
    _categoryBox.removeAllItems();
}

function onAdminFormSubmit(pressbutton) {
    switch (pressbutton) {
        case "module.apply":
        case "module.save":
        case "module.save2new":
        case "module.save2copy":
			fillInputCategoryIds();
            break;
    }
    submitform(pressbutton);
}
