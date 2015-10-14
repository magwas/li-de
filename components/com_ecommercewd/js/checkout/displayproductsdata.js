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
    var jq_mainForm = jQuery("form[name=wd_shop_main_form]");

    // fields that needs to be checked
    jq_mainForm.find("input[name^=product_count_]").each(function () {
        var jq_field = jQuery(this);
        var jq_productDataContainer = jq_field.closest(".wd_shop_product_data_container");
        var countIsUnlimited = jq_productDataContainer.attr("count_is_unlimited");
        var countAvailable = jq_productDataContainer.attr("count_available");

        jq_field.on("blur", function () {
            var value = jq_field.val();
            if ((value % 1 == 0) && (value > 0) && ((countIsUnlimited == "1") || (value <= parseInt(countAvailable)))) {
                jq_field.closest(".form-group").removeClass("has-error");
            } else {
                jq_field.closest(".form-group").addClass("has-error");
            }
        });
    });
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
function wdShop_checkout_getInvalidFields() {
    var jq_mainForm = jQuery("form[name=wd_shop_main_form]");

    var invalidFields = [];
    // check count fields
    jq_mainForm.find("input[name^=product_count_]").each(function () {
        var jq_field = jQuery(this);
        var jq_productDataContainer = jq_field.closest(".wd_shop_product_data_container");
        var countIsUnlimited = jq_productDataContainer.attr("count_is_unlimited");
        var countAvailable = jq_productDataContainer.attr("count_available");

        var value = jq_field.val();
        if ((value % 1 != 0) || (value <= 0) || ((countIsUnlimited == "0") && (value > parseInt(countAvailable)))) {
            invalidFields.push(jq_field);
        }
    });

    return invalidFields;
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onWDShop_pagerBtnClick(event, obj) {
    jQuery("form[name=wd_shop_main_form] .form-group").removeClass("has-error");

    var invalidFields = wdShop_checkout_getInvalidFields();
    if (invalidFields.length > 0) {
        for (var i = 0; i < invalidFields.length; i++) {
            var invalidField = invalidFields[i];
            jQuery(invalidField).closest(".form-group").addClass("has-error");
        }

        var jq_alert = jQuery(".wd_shop_checkout_alert_incorrect_data");
        if (jq_alert.is(":visible") == false) {
            jq_alert
                .removeClass("hidden")
                .slideUp(0)
                .slideDown(250);
        } else {
            jq_alert
                .fadeOut(100)
                .fadeIn(100);
        }
        return;
    }

    wdShop_mainForm_setAction(jQuery(obj).attr("href"));
    wdShop_mainForm_submit();
}