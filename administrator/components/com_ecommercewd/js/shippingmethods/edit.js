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
    updateFreeShipping();
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function selectCountries(countries) {
    var countryIds = [];
    var countryNames = [];

    for (var i = 0; i < countries.length; i++) {
        var country = countries[i];
        countryIds.push(country.id);
        countryNames.push(country.name);
    }

    adminFormSet("country_ids", countryIds.join(","));
    adminFormSet("country_names", countryNames.join("&#13;"));
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function showCountries(callback) {
    var selectedIds = adminFormGet("country_ids");
    url = "index.php?option=com_ecommercewd" +
        "&controller=countries" +
        "&task=explore" +
        "&selected_ids=" + selectedIds +
        "&callback=" + callback;
    openPopUp(url);
}

function updateFreeShipping() {
    var value_free_shipping = jQuery("form[name=adminForm] input[name=free_shipping]:checked").val();
    value_free_shipping == "1" ? jQuery(".price_container").addClass("hidden") : jQuery(".price_container").removeClass("hidden");
}

function updateFreeShippingAfterCertainPrice() {
    var freeShippingAfterCertainPriceChecked = jQuery("form[name=adminForm] input[name=free_shipping_after_certain_price]:checked").val();
    freeShippingAfterCertainPriceChecked == "1" ? jQuery(".free_shipping_start_price_container").removeClass("hidden") : jQuery(".free_shipping_start_price_container").addClass("hidden");
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnRemoveCountriesClick(event, obj) {
    selectCountries([]);
}

function onBtnSelectCountriesClick(event, obj) {
    showCountries('selectCountries');
}

function onFreeShippingChange(event, obj) {
    updateFreeShipping();
}

function onFreeShippingAfterCertainPriceChange(event, obj) {
    updateFreeShippingAfterCertainPrice();
}