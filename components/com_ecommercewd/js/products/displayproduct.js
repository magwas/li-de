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
var wdShop_lastValidCount = 1;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    // rater
    var jq_starRaters = jQuery(".wd_shop_product_star_rater");
    if (jq_starRaters.length > 0) {
        new WdBsStarRater(jq_starRaters);
    }

    // tabs
    jQuery('#spidershop_product_data_tab_container a').click(function (event) {
        jQuery(this).tab("show");
        event.preventDefault();
        return false;
    });

    // tooltips
    jQuery("[data-toggle=tooltip]").tooltip({container: ".wd_shop_tooltip_container"});

    // related products slider
    new WDItemsSlider(jQuery(".wd_shop_products_slider"), {loop: true, slideWidth: "slideSizePage"})
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
function wdShop_onProductCountBlur(event, obj) {
    var jq_fieldCount = jQuery(obj);
    var value = jq_fieldCount.val();
    if ((value % 1 == 0) && (value > 0)) {
        jq_fieldCount.closest(".form-group").removeClass("has-error");
    } else {
        jq_fieldCount.closest(".form-group").addClass("has-error");
    }
}

function wdShop_onBtnBuyNowClick(event, obj) {

	if( jQuery('#wd_shop_product_quantity').val()> wdShop_amount_in_stock && wdShop_product_unlimited == 0 ){
		jQuery(".form-group").addClass("has-error");
		return false;
	}

    var jq_form_order = jQuery("form[name=wd_shop_form_order]");

    var productId = jq_form_order.find("input[name=product_id]").val();
    var count = jq_form_order.find("input[name=product_count]").val();
    var parameters = {};
    jq_form_order.find(".wd_shop_product_selectable_parameter").each(function () {
		var parameterId = jQuery(this).attr("parameter_id");
		var parameterTypeId = jQuery(this).attr("type_id");
		var parameterValue;
		switch (parameterTypeId) {
			// Input
			case '2':
				var parameter_input = jQuery(this).find(".wd_shop_parameter_input");
				var input_parameter_val = jQuery(parameter_input).val();
				parameterValue = input_parameter_val;
				break;
			// Select
			case '3':
				var parameter_select = jQuery(this).find(".wd_shop_parameter_select");
				var select_parameter_val = jQuery(parameter_select).find(':selected').val();
				parameterValue = select_parameter_val;
				break;
			// Radio
			case '4':
				var parameter_radio_name = jQuery(this).find(".wd_shop_parameter_radio").attr('name');
				var radio_parameter_value = jQuery("input[name=" + parameter_radio_name + "]:checked").val();
				parameterValue = radio_parameter_value;
				break;
			// Checkbox
			case '5':
				var parameter_radio_name = jQuery(this).find(".wd_shop_parameter_checkbox").attr('name');
				var checkbox_parameter_values = Array();
				jQuery('input[name=' + parameter_radio_name +']:checked').each(function () {
					checkbox_parameter_values.push(jQuery(this).val());
				});
				parameterValue = checkbox_parameter_values;
				break;
		}
		 parameters[parameterId] = parameterValue;
    });

    wdShop_mainForm_set("product_id", productId);
    wdShop_mainForm_set("product_count", count);
    wdShop_mainForm_set("product_parameters_json", JSON.stringify(parameters));

    wdShop_mainForm_setAction(jQuery(obj).attr("href"));
    wdShop_mainForm_submit();
}

function wdShop_onBtnAddToCartClick(event, obj) {
	if( jQuery('#wd_shop_product_quantity').val()> wdShop_amount_in_stock && wdShop_product_unlimited == 0 ){
		jQuery(".form-group").addClass("has-error");
		return false;
	}

    var jq_btn = jQuery(obj);
	if(option_redirect_to_cart_after_adding_an_item == 2){
		if ((jq_btn.attr("disabled") != undefined) || (jq_btn.hasClass("disabled"))) {
			return false;
		}	
		jq_btn.addClass("disabled");
	}
	
    jq_btn.attr("data-original-title", WD_SHOP_TEXT_PLEASE_WAIT);
    var ishover = false;
    if (!jQuery.support.leadingWhitespace) {
        ishover = jq_btn.hasClass("hover");
    }
    else {
        ishover = jq_btn.is(":hover");
    }
    if (ishover) {
        jq_btn.tooltip("show");
    }

    var jq_form_order = jQuery("form[name=wd_shop_form_order]");

    var productId = jq_form_order.find("input[name=product_id]").val();
    var count = jq_form_order.find("input[name=product_count]").val();
    var parameters = {};
    jq_form_order.find(".wd_shop_product_selectable_parameter").each(function () {
        var parameterId = jQuery(this).attr("parameter_id");
        var parameterTypeId = jQuery(this).attr("type_id");
        var parameterValue;
        switch (parameterTypeId) {
            // Input
            case '1':
                var parameter_input = jQuery(this).find(".wd_shop_parameter_input");
                var input_parameter_val = jQuery(parameter_input).val();
                parameterValue = input_parameter_val;
                break;
            // Select
            case '3':
                var parameter_select = jQuery(this).find(".wd_shop_parameter_select");
                var select_parameter_val = jQuery(parameter_select).find(':selected').val();
                parameterValue = select_parameter_val;
                break;
            // Radio
            case '4':
                var parameter_radio_name = jQuery(this).find(".wd_shop_parameter_radio").attr('name');
                var radio_parameter_value = jQuery("input[name=" + parameter_radio_name + "]:checked").val()?jQuery("input[name=" + parameter_radio_name + "]:checked").val():'';
                parameterValue = radio_parameter_value;
                break;
            // Checkbox
            case '5':
                var parameter_radio_name = jQuery(this).find(".wd_shop_parameter_checkbox").attr('name');
                var checkbox_parameter_values = Array();
                jQuery('input[name=' + parameter_radio_name +']:checked').each(function () {
                    checkbox_parameter_values.push(jQuery(this).val());
                });
                parameterValue = checkbox_parameter_values;
                break;
        }

        parameters[parameterId] = parameterValue;
    });

    jQuery.ajax({
        type: "POST",
        url: wdShop_urlAddToShoppingCart,
        data: {
            "product_id": productId,
            "product_count": count,
            "product_parameters_json": JSON.stringify(parameters)
        },
        complete: function () {
        },
        success: function (result) {				
            console.log(result);
            var data = JSON.parse(result);			
            jq_btn.attr("data-original-title", data.msg);
            var ishover = false;
            if (!jQuery.support.leadingWhitespace) {
                ishover = jq_btn.hasClass("hover");
            }
            else {
                ishover = jq_btn.is(":hover");
            }
            if (ishover) {
                jq_btn.tooltip("show");
            }
            if ((data.product_added == true) && (wdShop_redirectToCart == true)) {
                wdShop_mainForm_setAction(wdShop_urlDisplayShoppingCart);
                wdShop_mainForm_submit();
            }
			if( jQuery(".minicart_module_container").length > 0 ){			
				wdShop_minicart_js_paths = [];
				wdShop_minicart_js_paths.push(wdShop_minicart_js_path);
				wdShop_load(wdShop_minicart,'minicart_module_container',wdShop_minicart_js_paths);
			}
        },
        failure: function (errorMsg) {
            alert(errorMsg);
        }
    });
}

function wdShop_onTagClick(event, obj) {
    var tagName = jQuery(obj).attr("data-name");
    var jq_form_tags = jQuery("form[name=wd_shop_form_tags]");
    jq_form_tags.find("input[name=filter_tags]").val(tagName);
    jq_form_tags.submit();
}


function onSelectableParameterChange(obj, event) {
    var type_id = jQuery(obj).attr('data-type');
    var name = jQuery(obj).attr('name');
    var price_text = jQuery('.wd_shop_product_price_text').text(); 

    var new_price;
    switch (type_id) {
        // Select
        case '3':
            var param_price_text = jQuery(obj).find(':selected').attr('data-price');
			param_price_text = param_price_text.replace(/,/g, "");	
            new_price = param_price_text;
            break;
        // Radio
        case '4':
            var param_price_text = jQuery(obj).attr('data-price');
			param_price_text = param_price_text.replace(/,/g, "");	
            new_price = param_price_text;
            break;
        // Checkbox
        case '5':
            var checked_prices = 0;
            jQuery('input[name=' + name +']:checked').each(function () {
                checked_param_price = this.checked ? $(this).attr('data-price') : "";
                var price_sign = checked_param_price.substr(0, 1);
                var param_price = checked_param_price.substr(1, checked_param_price.length);
				param_price = param_price.replace(/,/g, "");	
                if (param_price) {
                    if (price_sign == '+') {
                        checked_prices = (parseFloat(checked_prices) + parseFloat(param_price)).toFixed(2);
                    } else {
                        checked_prices = (parseFloat(checked_prices) - parseFloat(param_price)).toFixed(2);
                    }
                }
            });

            if(checked_prices > 0) {
                checked_prices = "+" + checked_prices;
            }

            new_price = checked_prices;
            break;
    }

    parameters_price[name] = new_price;

    var parameters_price_sum = 0;
    for (var key in parameters_price) {
        if (parameters_price[key]) {
            var price_sign = parameters_price[key].substr(0, 1);
            var param_price = parameters_price[key].substr(1, parameters_price[key].length);
            if (param_price) {
                if (price_sign == '+') {
                    parameters_price_sum = (parseFloat(parameters_price_sum) + parseFloat(param_price)).toFixed(decimals);
                } else {
                    parameters_price_sum = (parseFloat(parameters_price_sum) - parseFloat(param_price)).toFixed(decimals);
                }
            }
        }
    }
	
    var discount_price = (parseFloat(parameters_price_sum) + parseFloat(product_price))*(option_include_discount_in_price==1?(1-(discount_rate===null?0:discount_rate)/100):1);
   
	var tax = discount_price*(option_include_tax_in_price==1?((tax_rate===null?0:tax_rate)/100):0);
    var product_updated_price = (tax + discount_price);
   // product_updated_price = Math.floor(product_updated_price * 100) / 100;
	
	if(wdShop_currency_position == 1){
		jQuery('.wd_shop_product_price_text').html(product_updated_price.toFixed(decimals) + wdShop_currency_code);
	}
	else{
		jQuery('.wd_shop_product_price_text').html(wdShop_currency_code + product_updated_price.toFixed(decimals));
	}
	

}