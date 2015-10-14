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
var PAGE_TYPE_CUSTOM_TEXT = "pageTypeCustomText";
var PAGE_TYPE_JOOMLA_ARTICLE = "pageTypeJoomlaArticle";


////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var _pageType;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    var isArticle = jQuery("form[name=adminForm] input[name=is_article]:checked").val() == 1 ? true : false;
    var pageType = isArticle == true ? PAGE_TYPE_CUSTOM_TEXT : PAGE_TYPE_JOOMLA_ARTICLE;
    switchPageType(pageType);
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function switchPageType(pageType) {
    _pageType = pageType
    switch (pageType) {
        case PAGE_TYPE_CUSTOM_TEXT:
            jQuery("form[name=adminForm] input[name=is_article][value='0']").prop("checked", true);
            jQuery("#custom_text_container").removeClass("hidden_settings");
            jQuery("#joomla_article_container").addClass("hidden_settings");
            break;
        case PAGE_TYPE_JOOMLA_ARTICLE:
            jQuery("form[name=adminForm] input[name=is_article][value='1']").prop("checked", true);
            jQuery("#custom_text_container").addClass("hidden_settings");
            jQuery("#joomla_article_container").removeClass("hidden_settings");
            break;
    }
}

function selectArticle(articleId, articleName) {
    adminFormSet("article_id", articleId);
    adminFormSet("article_title", articleName);
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function showArticles(callback) {
    url = "index.php?option=com_ecommercewd&controller=pages&task=explore_articles&callback=" + callback;
    openPopUp(url);
}

function checkForm() {
    var invalidField;
    switch (_pageType) {
        case PAGE_TYPE_CUSTOM_TEXT:
            var valueTitle = adminFormGet("title");
            if (valueTitle.trim() == "") {
                invalidField = jQuery("form[name=adminForm] input[name=title]");
            }
            break;
        case PAGE_TYPE_JOOMLA_ARTICLE:
            var valueArticleId = adminFormGet("article_id");
            if ((valueArticleId.trim() == "") || (valueArticleId == 0)) {
                invalidField = jQuery("form[name=adminForm] input[name=article_id]");
            }
            break;
    }

    if (invalidField == null) {
        jQuery(".required_field").not("#joomla_article_container .required_field, #custom_text_container .required_field").each(function () {
            if (invalidField != null) {
                return false;
            }

            var value = jQuery(this).val();
            if (value.trim() == "") {
                invalidField = this;
                return false;
            }
        });
    }

    if (invalidField != null) {
        alert("Please fill in all required fields!");
        jQuery(invalidField).focus();
        jQuery("html, body").animate({
            scrollTop: jQuery(invalidField).offset().top - 200
        }, "fast");
        return false;
    }

    return true;
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onRadioCustomTextClick(event, obj) {
    switchPageType(PAGE_TYPE_CUSTOM_TEXT);
}

function onRadioJoomlaArticleClick(event, obj) {
    switchPageType(PAGE_TYPE_JOOMLA_ARTICLE);
}

function onBtnRemoveArticleClick(event, obj) {
    selectArticle(0, "");
}

function onBtnSelectArticleClick(event, obj) {
    showArticles("selectArticle");
}
