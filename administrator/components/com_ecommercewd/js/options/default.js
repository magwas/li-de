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
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function resetValues(options, toDefault) {
    if (toDefault == undefined) {
        toDefault = false;
    }

    var values = toDefault == true ? _optionsDefaultValues : _optionsInitialValues;

    var inputNames = [];
    switch (options) {
	   case "products_data":
            inputNames = [
                "weight_unit",
                "dimensions_unit",
                "enable_sku",
                "enable_upc",
                "enable_ean",
                "enable_jan",
                "enable_isbn",
                "enable_mpn"
            ];
            break;
        case "registration":
            inputNames = [
                "registration_administrator_email",
                "registration_captcha_use_captcha",
                "registration_captcha_public_key",
                "registration_captcha_private_key",
                "registration_captcha_theme"
            ];
            break;
        case "user_data":
            inputNames = [
                "user_data_middle_name",
                "user_data_last_name",
                "user_data_company",
                "user_data_country",
                "user_data_state",
                "user_data_city",
                "user_data_address",
                "user_data_mobile",
                "user_data_phone",
                "user_data_fax",
                "user_data_zip_code"
            ];
            break;
        case "checkout":
            inputNames = [
                "checkout_enable_checkout",
                "checkout_allow_guest_checkout",
                "checkout_redirect_to_cart_after_adding_an_item",
                "checkout_enable_shipping"
            ];
            break;
        case "feedback":
            inputNames = [
                "feedback_enable_guest_feedback",
                "feedback_enable_product_rating",
                "feedback_enable_product_reviews",
                "feedback_publish_review_when_added"
            ];
            break;
        case "search_and_sort":
            inputNames = [
                "search_enable_user_bar",
                "search_enable_search",
                "search_by_category",
                "search_include_subcategories",
                "filter_manufacturers",
                "filter_price",
                "filter_date_added",
                "filter_minimum_rating",
                "filter_tags",
                "sort_by_name",
                "sort_by_manufacturer",
                "sort_by_price",
                "sort_by_count_of_reviews",
                "sort_by_rating"
            ];
            break;
        case "social_media_integration":
            inputNames = [
                "social_media_integration_enable_fb_like_btn",
                "social_media_integration_enable_twitter_tweet_btn",
                "social_media_integration_enable_g_plus_btn",
                "social_media_integration_use_fb_comments",
                "social_media_integration_fb_color_scheme"
            ];
            break;
        case "other":
            inputNames = [
                "option_date_format",
                "option_include_discount_in_price",
                "option_include_tax_in_price",
                "option_show_decimals"
            ];
            break;
    }

    for (var i = 0; i < inputNames.length; i++) {
        var inputName = inputNames[i];
        adminFormSet(inputName, values[inputName]);
    }
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTabActivated(currentTabIndex) {
    adminFormSet("tab_index", currentTabIndex);
}

function onBtnResetClick(event, obj, options) {
    resetValues(options);
}

function onBtnLoadDefaultValuesClick(event, obj, options) {
    resetValues(options, true);
}