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
    // for table ordering
    Joomla.tableOrdering = tableOrdering;

    // for tooltips
    new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function disableEnterKey(event) {
    var key;
    if (window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = event.which;              //firefox
    }
    return key == 13 ? false : true;
}

function adminFormGet(name) {
    var jq_input = jQuery("form[name=adminForm] [name='" + name + "']");
    return getInputValue(jq_input);
}

function adminFormSet(name, value) {
    var jq_input = jQuery("form[name=adminForm] [name='" + name + "']");
    setInputValue(jq_input, value);
}

function adminFormSubmit() {
    var jq_adminForm = jQuery("form[name=adminForm]");
    jq_adminForm.submit();
}

function openFileManager(extensions, callback, tab_index, width, height) {
    url = "index.php?option=com_" + COM_NAME + "&controller=filemanager&extensions=" + extensions + "&callback=" + callback + "&fm_tab_index=" + tab_index + "&fm_tab_index_unchanged=" + tab_index;
    openPopUp(url, width, height);
}

function wdShop_load(url, id, js_paths){
	var xmlHttp;
	try{	
		xmlHttp=new XMLHttpRequest();// Firefox, Opera 8.0+, Safari
	}
	catch (e){
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
		}
		catch (e){
			try{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){
				alert("No AJAX!?");
				return false;
			}
		}
	}

	xmlHttp.onreadystatechange=function(){
		if(xmlHttp.readyState==4){
			document.getElementById(id).innerHTML=xmlHttp.responseText;
			if(js_paths){
				for(i=0; i<js_paths.length; i++){
					jQuery.getScript(js_paths[i]);
				}				
			}
		}
	}

	xmlHttp.open("GET",url,false);
	xmlHttp.send();

}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function tableOrdering(sort_by, sort_order, task) {	
    var form = document.adminForm;
    form.sort_by.value = sort_by;
    form.sort_order.value = sort_order;
    submitform(task);
}

function getInputValue(input) {
    var jq_input = jQuery(input);

    var tagName = jq_input.prop("tagName").toLowerCase();
    switch (tagName) {
        case "input":
            var type = jq_input.attr("type");
            switch (type) {
                case "radio":
                    var inputName = jq_input.attr("name");
                    var jq_checked_input = jQuery("radio[name='" + inputName + "']:checked");
                    return jq_checked_input.val();
                    break;
                case "checkbox":
                    return jq_input.prop('checked') == true ? true : false;
                    break;
                default:
                    return jq_input.val();
                    break;
            }
            break;
        case "select":
            jq_input.find("option:selected").val();
            break;
        case "textarea":
            jq_input.html();
            break;
    }
}

function setInputValue(inputs, value) {
    var jq_input = jQuery(inputs);

    var tagName = jq_input.prop("tagName").toLowerCase();
    switch (tagName) {
        case "input":
            var type = jq_input.attr("type");
            switch (type) {
                case "radio":
                    var inputName = jq_input.attr("name");
                    jQuery("input[name=" + inputName + "][value='" + value + "']").prop("checked", true);
                    break;
                case "checkbox":
                    jq_input.prop("checked", value ? true : false);
                    break;
                default:
                    jq_input.val(value);
                    break;
            }
            break;
        case "select":
            jq_input.find("option[value='" + value + "']").prop("selected", true);
            break;
        case "textarea":
            jq_input.html(value);
            break;
    }
}

function openPopUp(url, width, height, options) {
    if (options == undefined) {
        options = {};
    }

    options.handler = "iframe";
    options.size = {
        x: width == undefined ? 800 : width,
        y: height == undefined ? 500 : height
    };

    SqueezeBox.open(url, options);
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnSearchClick(event, obj) {
    jQuery("form[name=adminForm]").submit();
}

function onBtnResetClick(event, obj) {
    jQuery('.searchable').each(function () {
        var jq_input = jQuery(this);
        var tagName = jq_input.prop("tagName").toLowerCase();
        switch (tagName) {
            case "select":
                setInputValue(jq_input, -1);
                break;
            default:
                setInputValue(jq_input, "");
                break;
        }
    });
    jQuery("form[name=adminForm]").submit();
}
