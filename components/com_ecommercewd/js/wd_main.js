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
function wdShop_disableEnterKey(event) {
    var key;
    if (window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = event.which;              //firefox
    }
    return key == 13 ? false : true;
}

function wdShop_getBootstrapEnvironment() {
    var envs = ['xs', 'sm', 'md', 'lg'];

    jq_el = jQuery('<div>');
    jq_el.appendTo(jQuery('#wd_shop_container'));

    for (var i = envs.length - 1; i >= 0; i--) {
        var env = envs[i];

        jq_el.addClass('hidden-' + env);
        if (jq_el.is(':hidden')) {
            jq_el.remove();
            return env
        }
    }
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
function wdShop_mainForm_get(key) {
    return jQuery("form[name=wd_shop_main_form] input[name=" + key + "]").val();
}

function wdShop_mainForm_set(key, value) {
    jQuery("form[name=wd_shop_main_form] input[name=" + key + "]").val(value);
}

function wdShop_mainForm_setAction(action) {
    jQuery("form[name=wd_shop_main_form]").attr("action", action);
}

function wdShop_mainForm_submit() {
    jQuery("form[name=wd_shop_main_form]").submit();
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////