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
var _thumb_box_images;
var _thumb_box_videos;
var _tagBox;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    _thumb_box_images = new ThumbBox(jQuery("#thumb_box_images"),'images');
    for (var i = 0; i < _imageUrls.length; i++) {
		var imageUrl = (_imageUrls[i].indexOf(_url_root) == -1 ) ? _url_root +  _imageUrls[i] : _imageUrls[i];		
        _thumb_box_images.addThumbAt(imageUrl, undefined, 'images');
    }
	
	_thumb_box_videos = new ThumbBox(jQuery("#thumb_box_videos"),'videos');
    for (var i = 0; i < _videoUrls.length; i++) {
		var videoUrl = (_videoUrls[i].indexOf(_url_root) == -1 ) ? _url_root +  _videoUrls[i] : _videoUrls[i];		
        _thumb_box_videos.addThumbAt(videoUrl, undefined, 'videos');
    }
	

    // parameters
    for (var i = 0; i < _parameters.length; i++) {
        addParameter(_parameters[i]);
    }

    // tags
    _tagBox = new TagBox(jQuery("#tag_box"));
    for (var i = 0; i < _tags.length; i++) {
        _tagBox.addTag(_tags[i]);
    }
	
 
	onShippingChange(jQuery("form[name=adminForm] input[name=enable_shipping]"));	
	orderParametersAndFiles();
	orderParameterValues();
	orderUploads();
 
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////

function changeCategory(id) {
    adminFormSet("category_id", id);
    refreshPage();
}

function selectFile(file) {
    var filesContainer = jQuery('#files_container');
    var template = jQuery(filesContainer).children(".template")[0];
    var newFileContainer = jQuery(template).clone();
    jQuery(newFileContainer).removeClass("template");
	newFileContainer.attr('data-file-id',file.id);
	newFileContainer.attr('data-file-name',file.name);
    var inputValue = jQuery(newFileContainer).find(".file_name")[0];
    jQuery(inputValue).val(file.name);
    jQuery(filesContainer).append(newFileContainer);
}

function removeAllFiles(){
	jQuery("#files_container").children(":not(.template)").remove();
}
function selectManufacturer(id, name) {
    adminFormSet("manufacturer_id", id);
    adminFormSet("manufacturer_name", name);
}

function selectDiscount(id, name, rate) {
    adminFormSet("discount_id", id);
    adminFormSet("discount_name", name);
    adminFormSet("discount_rate", rate);
    updateFinalPrice();
}

function selectTax(id, name, rate) {
    adminFormSet("tax_id", id);
    adminFormSet("tax_name", name);
    adminFormSet("tax_rate", rate);
    updateFinalPrice();
}

function selectLabel(id, name) {
    adminFormSet("label_id", id);
    adminFormSet("label_name", name);
}

function selectPages(pages) {
    var pageIds = [];
    var pageTitles = [];

    for (var i = 0; i < pages.length; i++) {
        var page = pages[i];
        pageIds.push(page.id);
        pageTitles.push(page.title);
    }

    adminFormSet("page_ids", pageIds.join(","));
    adminFormSet("page_titles", pageTitles.join("&#13;"));
}

function selectShippingMethods(shippingMethods) {
    var shippingMethodIds = [];
    var shippingMethodNames = [];

    for (var i = 0; i < shippingMethods.length; i++) {
        var shippingMethod = shippingMethods[i];
        shippingMethodIds.push(shippingMethod.id);
        shippingMethodNames.push(shippingMethod.name);
    }

    adminFormSet("shipping_method_ids", shippingMethodIds.join(","));
    adminFormSet("shipping_method_names", shippingMethodNames.join("&#13;"));
}

function addParameter(parameter) {
    //check if parameter exists
    var parameterRow = null;
    jQuery("#parameters_container").children(":not(.template)").each(function () {
        if (parameter["id"] == jQuery(this).attr("parameter_id")) {
            parameterRow = jQuery(this);
            return;
        }
    });
	
	var add_param_funct = false;
	
    //add new if doesn't
    if (parameterRow == null) {
        var parameterRow = jQuery(jQuery("#parameters_container").children(".template")[0]).clone();
        jQuery("#parameters_container").append(parameterRow);
        jQuery(parameterRow).removeClass("template");
        jQuery(parameterRow).attr("parameter_id", parameter["id"]);
        jQuery(parameterRow).attr("parameter_name", parameter["name"]);
		jQuery(parameterRow).attr("parameter_type_id", parameter["type_id"]);
        jQuery(parameterRow).find(".parameter_name").html(parameter["name"]);
		jQuery(parameterRow).find(".parameter_type").html(parameter['type_name']);
        if (parameter["required"] == true) {
            jQuery(parameterRow).find(".btn_remove_parameter").remove();
        } else {
            jQuery(parameterRow).removeClass("required_parameter_container");
            jQuery(parameterRow).find(".required_sign").remove();
            jQuery(parameterRow).find(".required_field").removeClass("required_field");
        }
		if (parameter['type_id'] == 1) {
            jQuery(parameterRow).find('.parameter_value_container').children(":not(.template)").each(function () {
                jQuery(this).find('.parameter_value').val('');
                jQuery(this).css('display', 'none');
            });
            jQuery(parameterRow).find('.btn_add_parameter_value').css('display', 'none')
            jQuery(parameterRow).find(".required_field").addClass('no_value');
            jQuery(parameterRow).find(".parameter_value_container").addClass('no_value');
        } else if(parameter['type_id'] == 2) {
            jQuery(parameterRow).find('.parameter_value_container').find('.price_sign').css('display', 'none');
            jQuery(parameterRow).find('.parameter_value_container').find('.parameter_price').css('display', 'none');
            jQuery(parameterRow).find('.btn_add_parameter_value').css('display', 'none');
        }


		 if (parameter['add_parameter']) {
			   var parameter_default_values = JSON.decode(parameter['default_values']);
			   if (parameter_default_values) {
				   for (var i = 0; i < parameter_default_values.length; i++) {
					   var default_value = {};
					   default_value['value'] = parameter_default_values[i];
					   default_value['price'] = '';
					   addParameterValue(parameterRow, default_value);
					   add_param_funct = true;
				   }
			   }
		   }
		
    }

    //get current values
    var currentValues = [];
    jQuery(parameterRow).find(".parameter_value_container:not(.template)").each(function () {
        var inputParameterValue = jQuery(this).find(".parameter_value")[0];
        currentValues.push(jQuery(inputParameterValue).val());
    });

    //add new value if doesn't exist
    var newValues = parameter["values"];
    if (!add_param_funct) {
        if (newValues == undefined) {
            addParameterValue(parameterRow);
        } else {
            for (var i = 0; i < newValues.length; i++) {
                var newValue = newValues[i];
                if (currentValues.indexOf(newValue) < 0) {
                    addParameterValue(parameterRow, newValue);
                }
//                var price_sign = newValues[i]['price'].charAt(0);
//                var price = newValues[i]['price'].substring(1,newValues[i]['price'].length);
//                jQuery(parameterRow).find(".price_sign").val(price_sign);
//                jQuery(parameterRow).find(".parameter_price").val(price);
            }
        }
    }
	
	orderParameterValues();
}

function removeAllParameters() {
    jQuery("#parameters_container").children(":not(.template):not(.required_parameter_container)").remove();
}

function addParameterValue(parameterContainer, parameter) {
    if (parameter == undefined) {
        parameter = "";
    }

    var isRequired = jQuery(parameterContainer).hasClass("required_parameter") == true ? true : false;

    var parameterValuesContainer = jQuery(parameterContainer).find(".parameter_values_container");
    var template = jQuery(parameterValuesContainer).children(".template")[0];
    var newValueContainer = jQuery(template).clone();
    jQuery(newValueContainer).removeClass("template");
    var inputValue = jQuery(newValueContainer).find(".parameter_value")[0];
    
	if (parameter['price']) {
        var sign = parameter['price'].charAt(0);
        var price = parameter['price'].substring(1, parameter['price'].length);
        var price_sign = jQuery(newValueContainer).find(".price_sign");
        var parameter_price = jQuery(newValueContainer).find(".parameter_price");
        jQuery(price_sign).val(sign);
        jQuery(parameter_price).val(price);
    }
    jQuery(inputValue).val(parameter['value']);
	
	
    if (isRequired == true) {
        jQuery(inputValue).addClass("required_field");
    }
    jQuery(parameterValuesContainer).append(newValueContainer);

    checkParameterSingleValue(parameterValuesContainer);
}

function removeParameterValue(parameterValueContainer) {
    var parameterValuesContainer = jQuery(parameterValueContainer).closest(".parameter_values_container");
    jQuery(parameterValueContainer).remove();
    checkParameterSingleValue(parameterValuesContainer);
}

function removeParameter(parameterContainer) {
    jQuery(parameterContainer).remove();
}

function addTag(tag) {
    _tagBox.addTag(tag);
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function refreshPage() {
    fillInputImages();
	fillInputVideos();
	orderInputUploads();
    fillInputTagIds();
    fillInputParameters();
	fillInputDimensions();
    adminFormSet("task", TASK == "add" ? "add_refresh" : "edit_refresh");
    adminFormSubmit();
}


function orderParametersAndFiles(){
	jQuery( "#parameters_container" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',	
		handle: ".col-ordering"
	});	
	
	jQuery( "#files_container" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',	
		handle: ".col-ordering"
	});	

}


function orderParameterValues(){
	jQuery( ".parameter_values_container" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',	
		handle: ".icon-drag"
	});	
}

function orderUploads() {			
	jQuery( ".jf_thumb_box_items_container_iamges" ).sortable({	
	   start: function(event, ui) {
            ui.item.bind("click.prevent",
                function(event) { var event = event || window.event; event.preventDefault(); });
        },
        stop: function(event, ui) {
            setTimeout(function(){ui.item.unbind("click.prevent");}, 300);
        },
		axis: 'x',
		opacity: 0.8,
		cursor: 'move'
	});				
	jQuery( ".jf_thumb_box_items_container_iamges" ).disableSelection();

	jQuery( ".jf_thumb_box_items_container_ordering" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',
		handle: ".icon-drag"		
	});				
	
}	

function showCategoriesTree(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=categories" +
        "&task=show_tree" +
        "&callback=" + callback +
        "&selected_node_id=" + _categoryId +
        "&opened=true";
    openPopUp(url);
}

function showManufacturer(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=manufacturers" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}

function showDiscounts(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=discounts" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}

function showTaxes(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=taxes" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}

function showLabels(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=labels" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}

function showPages(callback) {
    var selectedIds = adminFormGet("page_ids");
    url = "index.php?option=com_ecommercewd" +
        "&controller=pages" +
        "&task=explore" +
        "&selected_ids=" + selectedIds +
        "&callback=" + callback;
    openPopUp(url);
}

function showShippingMethods(callback) {
    var selectedIds = adminFormGet("shipping_method_ids");
    url = "index.php?option=com_ecommercewd" +
        "&controller=shippingmethods" +
        "&task=explore" +
        "&selected_ids=" + selectedIds +
        "&callback=" + callback;
    openPopUp(url);
}

function showParameters(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=parameters" +
        "&task=explore" +
        "&callback=" + callback +
        "&ignore_required=true";
    openPopUp(url);
}

function showTags(callback) {
    url = "index.php?option=com_ecommercewd" +
        "&controller=tags" +
        "&task=explore" +
        "&callback=" + callback;
    openPopUp(url);
}


function updatePrice() {
    var finalPrice = parseFloat(jQuery("form[name=adminForm] input[name=final_price]").val());
    finalPrice = !isNaN(finalPrice) ? finalPrice : 0;
    var discountRate = parseFloat(jQuery("form[name=adminForm] input[name=discount_rate]").val());
    discountRate = !isNaN(discountRate) ? discountRate : 0;
    var taxRate = parseFloat(jQuery("form[name=adminForm] input[name=tax_rate]").val());
    taxRate = !isNaN(taxRate) ? taxRate : 0;

    var price = !isNaN(finalPrice) ? (finalPrice / (1 + taxRate / 100)) / (1 - discountRate / 100) : 0;
    jQuery("form[name=adminForm] input[name=price]").val(price.toFixed(2));
}

function updateFinalPrice() {
    var price = parseFloat(jQuery("form[name=adminForm] input[name=price]").val());
    price = !isNaN(price) ? price : 0;
    var discountRate = parseFloat(jQuery("form[name=adminForm] input[name=discount_rate]").val());
    discountRate = !isNaN(discountRate) ? discountRate : 0;
    var taxRate = parseFloat(jQuery("form[name=adminForm] input[name=tax_rate]").val());
    taxRate = !isNaN(taxRate) ? taxRate : 0;

    var finalPrice = !isNaN(price) ? (price * (1 - discountRate / 100)) * (1 + taxRate / 100) : 0;
    jQuery("form[name=adminForm] input[name=final_price]").val(finalPrice.toFixed(2));
}

function checkParameterSingleValue(parameterValuesContainer) {
    var valueContainers = jQuery(parameterValuesContainer).children(":not(.template)");
    if (valueContainers.length > 1) {
        jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)").removeClass("single_parameter_value_container");
    } else {
        jQuery(jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)")[0]).addClass("single_parameter_value_container");
    }
}


function checkForm() {
    var invalidField;
	jQuery(".required_field:not(.template .required_field):not(.no_value)").each(function () {
        if (invalidField != null) {
            return false;
        }
        var value = jQuery(this).val();
        if (value.trim() == "") {
            invalidField = this;
            return false;
        }
    });

    if (invalidField != null && _isJ3 == 1) {
        alert("Please fill in all required fields!");
		if(jQuery(invalidField).attr('data-tab-index')){	
			onTabActivated(jQuery(invalidField).attr('data-tab-index'));
			jQuery('#tab_group_productsTabs').find('.active').removeClass('active');			
			jQuery('#tab_group_productsTabs').find('[href="#'+jQuery(invalidField).attr('data-tab-index')+'"]').closest('li').addClass('active');
			jQuery('#tab_group_productsContent').find('.active').removeClass('active');
			jQuery('#tab_group_productsContent').find('#'+jQuery(invalidField).attr('data-tab-index')).addClass('active');	
		}
		else{
			jQuery(invalidField).focus();
			jQuery("html, body").animate({
				scrollTop: jQuery(invalidField).offset().top - 200
			}, "fast");
		}
        return false;
    }

    fillInputImages();
	fillInputVideos();
	orderInputUploads();
    fillInputParameters();
    fillInputTagIds();
	fillInputDimensions();
    return true;
}

function fillInputImages() {
    var imageUrls = _thumb_box_images.getUploadUrls();
	for(i=0; i<imageUrls.length; i++ )
		imageUrls[i] = imageUrls[i].substr(_url_root.length);
    var valueImageUrls = JSON.stringify(imageUrls);
    adminFormSet("images", valueImageUrls);
}

function fillInputVideos() {
    var videoUrls = _thumb_box_videos.getUploadUrls();
	for(i=0; i<videoUrls.length; i++ )
		videoUrls[i] = videoUrls[i].substr(_url_root.length);
    var valueVideoUrls = JSON.stringify(videoUrls);
    adminFormSet("videos", valueVideoUrls);
}


function fillInputParameters() {
    var parameters = [];
    jQuery("#parameters_container").children(":not(.template)").each(function () {
        var parameter = {};
        parameter.id = jQuery(this).attr("parameter_id");
		parameter.type_id = jQuery(this).attr("parameter_type_id");
        parameter.values = [];
        jQuery(this).find(".parameter_value_container:not(.template):not(.no_value)").each(function () {
            var parameter_price = jQuery(this).find(".parameter_price").val();
			var parameter_price = parameter_price.replace(/[^0-9.]/g,'');
            if (parameter_price) {
                if (parameter_price.indexOf('.') + 1) {
                    if ((parameter_price.length - (parameter_price.indexOf('.') + 1)) == 1) {
                        parameter_price = parameter_price + 0;
                    } else {
                        parameter_price = parameter_price.substr(0, parameter_price.indexOf('.') + 3);
                    }
                } else {
                    parameter_price = parameter_price + '.00';
                }
            } else {
                parameter_price = '';
            }
            var inputParameter = {};
            inputParameter.value = jQuery(this).find(".parameter_value").val();
            inputParameter.price = jQuery(this).find(".price_sign").val() + parameter_price;
            parameter.values.push(JSON.stringify(inputParameter));
        });
        parameters.push(parameter);
    });
    adminFormSet("parameters", JSON.stringify(parameters));
}

function fillInputTagIds() {
    var tags = _tagBox.getTagDatas();
    var tagIds = [];
    for (var i = 0; i < tags.length; i++) {
        var tag = tags[i];
        tagIds.push(tag.id);
    }
    adminFormSet("tag_ids", JSON.stringify(tagIds));
}

function fillInputDimensions(){
	if(jQuery("#dimensions_length").length && jQuery("#dimensions_width").length && jQuery("#dimensions_height").length){
		var dimensions = '';
		var dimensions_flag = false;
		if(jQuery("#dimensions_length").val() != '' ){
			dimensions += jQuery("#dimensions_length").val() ;	
			dimensions_flag = true;	
		}
		if(jQuery("#dimensions_width").val() != ''){		
			var x = (dimensions_flag == true) ? 'x' : '';						
			dimensions += x + jQuery("#dimensions_width").val(); 
			dimensions_flag = true;
		}
		if(jQuery("#dimensions_height").val() != ''){
			var x = (dimensions_flag == true) ? 'x' : '';	
			dimensions += x + jQuery("#dimensions_height").val() 
		}		
		adminFormSet("dimensions", dimensions);		
	}
}


function orderInputUploads(){
	_jq_images = [];
	_jq_images_children = jQuery( "#thumb_box_images .jf_thumb_box_items_container").children().not(".template");	
	_jq_images_children.each(function(index, val){	
		_image_url = jQuery(this).find(".jf_thumb_box_item_image").attr("src").substr(_url_root.length);	
		_jq_images.push(_image_url);				
	});
	var _jq_json_images = JSON.stringify(_jq_images);
	adminFormSet("images", _jq_json_images);
	
	_jq_videos = [];
	_jq_videos_children = jQuery( "#thumb_box_videos .jf_thumb_box_items_container").children().not(".template");	
	_jq_videos_children.each(function(index, val){	
		_video_url = jQuery(this).find(".jf_thumb_box_item_video").html().substr(_url_root.length);	
		_jq_videos.push(_video_url);				
	});
	var _jq_json_videos = JSON.stringify(_jq_videos);
	adminFormSet("videos", _jq_json_videos);
		
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnRemoveCategoryClick(event, obj) {
    changeCategory(0);
    refreshPage();
}

function onBtnSelectCategoryClick(event, obj) {
    showCategoriesTree("changeCategory");
}

function onBtnRemoveFileClick(event, obj) {
   jQuery(obj).closest('.file_container').remove();
}

function onBtnSelectFilesClick(event, obj) {
    showFiles("selectFile");
}

function onBtnRemoveAllFilesClick(event, obj) {
    removeAllFiles();
}

function onBtnRemoveManufacturerClick(event, obj) {
    selectManufacturer(0, "");
}

function onBtnSelectManufacturerClick(event, obj) {
    showManufacturer("selectManufacturer");
}

function onBtnRemoveDiscountClick(event, obj) {
    selectDiscount(0, "", 0);
}

function onBtnSelectDiscountClick(event, obj) {
    showDiscounts('selectDiscount');
}

function onBtnRemoveTaxClick(event, obj) {
    selectTax(0, "", 0);
}

function onBtnSelectTaxClick(event, obj) {
    showTaxes('selectTax');
}

function onBtnRemoveLabelClick(event, obj) {
    selectLabel(0, "");
}

function onBtnSelectLabelClick(event, obj) {
    showLabels('selectLabel');
}

function onBtnRemovePagesClick(event, obj) {
    selectPages([]);
}

function onBtnSelectPagesClick(event, obj) {
    showPages('selectPages');
}

function onBtnRemoveShippingMethodsClick(event, obj) {
    selectShippingMethods([]);
}

function onBtnSelectShippingMethodsClick(event, obj) {
    showShippingMethods('selectShippingMethods');
}

function onBtnAddParametersClick(event, obj) {
    showParameters("addParameter");
}

function onBtnRemoveAllParametersClick(event, obj) {
    removeAllParameters();
}

function onBtnAddParameterValueClick(event, obj) {
    var parameterContainer = jQuery(obj).closest(".parameter_container");
    addParameterValue(parameterContainer);
}

function onBtnInheritCategoryParametersClick(event, obj) {
    for (var i = 0; i < _categoryParameters.length; i++) {
        addParameter(_categoryParameters[i]);
    }
}

function onBtnRemoveParameterValueClick(event, obj) {
    var parameterValueContainer = jQuery(obj).closest(".parameter_value_container");
    removeParameterValue(parameterValueContainer);
}

function onBtnRemoveParameterClick(event, obj) {
    var parameterContainer = jQuery(obj).closest(".parameter_container");
    removeParameter(parameterContainer);
}


function onBtnAddTagsClick(event, obj) {
    showTags("addTag");
}

function onBtnInheritCategoryTagsClick(event, obj) {
    for (var i = 0; i < _categoryTags.length; i++) {
        _tagBox.addTag(_categoryTags[i]);
    }
}

function onBtnRemoveAllTagsClick(event, obj) {
    _tagBox.removeAllTags();
}

function onPriceChange(event, obj) {
    updateFinalPrice();
}

function onFinalPriceChange(event, obj) {
    updatePrice();
}

function onUnlimitedChange(event, obj) {
    var jq_inputUnlimited = jQuery("form[name=adminForm] input[name=unlimited]");
    var display_property = jq_inputUnlimited.prop("checked") == true ? false : true;

    var jq_inputAmountInStock = jQuery("form[name=adminForm] input[name=amount_in_stock]");
    display_property == true ? jq_inputAmountInStock.removeClass("hidden") : jq_inputAmountInStock.addClass("hidden");
}

function onShippingChange(obj) {
	var display_property ;
    var jq_inputEnableShipping = jQuery("form[name=adminForm] input[name=enable_shipping]:checked").val();
	if( jq_inputEnableShipping == 1 || (jq_inputEnableShipping == 2 && _default_shipping == 1) )
		display_property = false;
	else if( jq_inputEnableShipping == 0 || (jq_inputEnableShipping == 2 && _default_shipping == 0) )	
		display_property = true;

    var jq_trShippingMethods = jQuery("form[name=adminForm] #shipping_methods");
    var jq_trShippingMethodNames = jQuery("form[name=adminForm] [name=shipping_method_names]");
    display_property == false ? jq_trShippingMethods.removeClass("hidden") : jq_trShippingMethods.addClass("hidden");
    display_property == false ? jq_trShippingMethodNames.addClass("required_field") : jq_trShippingMethodNames.removeClass("required_field");
}


function onTabActivated(currentTabIndex) {
    adminFormSet("tab_index", currentTabIndex);
	var href = location.href;
	if( location.href.indexOf('&tab_index') != -1 ) {
		 href = location.href.substr(0,location.href.indexOf('&tab_index'));		
	}
	//location.href = href + '&tab_index=' + currentTabIndex;
	href = href + '&tab_index=' + currentTabIndex;
	setLocation(href);
}

function setLocation(curLoc){
    try {
        history.pushState(null, null, curLoc);
        return false;
    } catch(e) {}
        location.hash = '#' + curLoc;
}