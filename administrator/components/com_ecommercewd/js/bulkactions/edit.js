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

	_tagBox = new TagBox(jQuery("#tag_box"));
	jQuery(".bulk-table tr:not(#shipping_methods) td.col_key").attr("colspan","2");
	jQuery('#add_category_parameters').hide();
	jQuery('#add_category_tags').hide();
	onShippingChange(jQuery("form[name=adminForm] input[name=enable_shipping]"));
	onUnlimitedChange(jQuery("form[name=adminForm] input[name=unlimited]"));

});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function changeCategory(id , name) {
    adminFormSet("category_id", id);
    adminFormSet("category_name", name);
	SqueezeBox.close();
	jQuery.ajax({
       type: "POST",
       url:"index.php?option=com_ecommercewd" +
        "&controller=bulkactions" +
        "&task=add_category_parameters_tags&category_id=" + id,
       complete: function () {
       },
       success: function (result) {				
			data = JSON.parse(result);
			console.log(data.tags);
			jQuery('#add_category_parameters').show();
			jQuery('#add_category_tags').show();
			jQuery('#add_category_parameters').attr('data-category-parameters',data.parameters);					
			jQuery('#add_category_tags').attr('data-category-tags',data.tags);					
       },
       failure: function (errorMsg) {
           alert(errorMsg);
       }
   });
	
}

function selectManufacturer(id, name) {
    adminFormSet("manufacturer_id", id);
    adminFormSet("manufacturer_name", name);
}

function selectDiscount(id, name, rate) {
    adminFormSet("discount_id", id);
    adminFormSet("discount_name", name);
    adminFormSet("discount_rate", rate);
}

function selectTax(id, name, rate) {
    adminFormSet("tax_id", id);
    adminFormSet("tax_name", name);
    adminFormSet("tax_rate", rate);
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

    adminFormSet("shipping_method_names", shippingMethodNames.join("&#13;"));
    adminFormSet("shipping_method_ids", shippingMethodIds.join());
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
        }

        if (parameter['type_id'] == 2) {
            jQuery(parameterRow).find('.btn_add_parameter_value').css('display', 'none')
        }
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
    fillInputTagIds();
    fillInputParameters();
    adminFormSet("task", TASK == "add" ? "add_refresh" : "edit_refresh");
    adminFormSubmit();
}

function orderParameters(){
	jQuery( "#parameters_container" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',	
		handle: ".col-ordering",		
	});		
}


function orderParameterValues(){
	jQuery( ".parameter_values_container" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',	
		handle: ".icon-drag",		
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

function checkParameterSingleValue(parameterValuesContainer) {
    var valueContainers = jQuery(parameterValuesContainer).children(":not(.template)");
    if (valueContainers.length > 1) {
        jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)").removeClass("single_parameter_value_container");
    } else {
        jQuery(jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)")[0]).addClass("single_parameter_value_container");
    }
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

function desableFields(){
	jQuery('.col_value').each(function(){
		jQuery(this).find('a').removeAttr("onclick");
		jQuery(this).find('a').removeAttr("href");
		jQuery(this).find('a').css("cursor","not-allowed !important");
		jQuery(this).css("cursor","not-allowed !important") ;	

	});
}

function enableFields (){
	jQuery('.col_value').each(function(){
		jQuery(this).find('a').addAttr("onclick");
		jQuery(this).find('a').removeAttr("href");
		jQuery(this).find('a').css("cursor","not-allowed !important");
		jQuery(this).css("cursor","not-allowed !important") ;	

	});

}

function checkForm(){
    fillInputParameters();
    fillInputTagIds();
	return true;
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onCheckboxEditFieldsClick(event, obj) {
	if(jQuery(obj).prop( "checked" ) == true){
		jQuery(obj).parent().parent().find(".col_value").show();
		if(jQuery(obj).prop("value") == "ch_shipping_methods"){
			jQuery("#shipping_methods").removeAttr("style");
		}
		jQuery(obj).parent().removeAttr('colspan');
		
	}
	else{
		jQuery(obj).parent().parent().find(".col_value").hide();
		if(jQuery(obj).prop("value") == "ch_shipping_methods"){
			jQuery("#shipping_methods").hide();
		}
		jQuery(obj).parent().attr('colspan',"2");	
	}
}

function onBtnRemoveCategoryClick(event, obj) {
    changeCategory(0 , "");
    //refreshPage();
}

function onBtnSelectCategoryClick(event, obj) {
    showCategoriesTree("changeCategory");
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
	_categoryParameters = jQuery(obj).attr('data-category-parameters');	
	_categoryParameters=_categoryParameters.replace(/\\'/g,'\'');
	_categoryParameters=_categoryParameters.replace(/\\"/g,'"');
	_categoryParameters=_categoryParameters.replace(/\\0/g,'\0');
	_categoryParameters=_categoryParameters.replace(/\\\\/g,'\\');

	_categoryParameters = JSON.parse(_categoryParameters);
	
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
	_categoryTags = jQuery(obj).attr('data-category-tags');	
	_categoryTags=_categoryTags.replace(/\\'/g,'\'');
	_categoryTags=_categoryTags.replace(/\\"/g,'"');
	_categoryTags=_categoryTags.replace(/\\0/g,'\0');
	_categoryTags=_categoryTags.replace(/\\\\/g,'\\');

	_categoryTags = JSON.parse(_categoryTags);
    for (var i = 0; i < _categoryTags.length; i++) {
        _tagBox.addTag(_categoryTags[i]);
    }
}

function onBtnRemoveAllTagsClick(event, obj) {
    _tagBox.removeAllTags();
}

function onBtnRemoveProduct(event,obj) {
	var jq_checkboxes = jQuery('[name=boxcheckeds]').val().split(",");
	
	var index = jq_checkboxes.indexOf(jQuery(obj).attr('data-productid'));
	jq_checkboxes.splice(index,1);
	adminFormSet('boxcheckeds',jq_checkboxes);
	jQuery(obj).parent().remove();
	

}


function onUnlimitedChange(obj) {
	var display_property;
    var jq_inputUnlimited = jQuery("form[name=adminForm] input[name=unlimited]");
    var display_property = jq_inputUnlimited.prop("checked") == true ? false : true;

    var jq_inputAmountInStock = jQuery("form[name=adminForm] input[name=amount_in_stock]");
    display_property == true ? jq_inputAmountInStock.removeClass("hidden") : jq_inputAmountInStock.addClass("hidden");
}

function onShippingChange(obj) {
	var display_property;
    var jq_inputEnableShipping = jQuery("form[name=adminForm] input[name=enable_shipping]:checked").val();
	if( jq_inputEnableShipping == 1 || (jq_inputEnableShipping == 2 && _default_shipping == 1) )
		display_property = false;
	else if( jq_inputEnableShipping == 0 || (jq_inputEnableShipping == 2 && _default_shipping == 0) )	
		display_property = true;

    var jq_trShippingMethods = jQuery("form[name=adminForm] #shipping_methods");
    var jq_trShippingMethodNames = jQuery("form[name=adminForm] [name=shipping_method_names]");
    display_property == false ? jq_trShippingMethods.removeClass("hidden") : jq_trShippingMethods.addClass("hidden");
   // display_property == false ? jq_trShippingMethodNames.addClass("required_field") : jq_trShippingMethodNames.removeClass("required_field");
}
