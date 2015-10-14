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
	switch(payment_method){
		case 'stripe' :
			ShowField(jQuery('[name=mode]'));
			break;
		case "authorizenetaim":
		case "authorizenetsim":
		case "authorizenetdpm":
			ShowField(jQuery('[name=request]'));
			break;
	}

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
function checkForm() {
    var invalidField;
    jQuery(".required_field:not(.template .required_field)").each(function () {
        if (invalidField != null) {
            return false;
        }
        var value = jQuery(this).val();
        if (value.trim() == "") {
            invalidField = this;
            return false;
        }
    });

    if (invalidField != null) {
        alert("Please fill in all required fields!");
        jQuery(invalidField).focus();
        jQuery("html, body").animate({
            scrollTop: jQuery(invalidField).offset().top - 200
        }, "fast");
        return false;
    }

    fillInputOption();

    return true;
}

function fillInputOption(){
	var valueOption
	if(_fields){
		elements = {};
		var fields = JSON.parse(_fields);
		var cc_fields = JSON.parse(_cc_fields);
		for(var field in fields){
			if(field == 'options'){
				var options = {};
				for(i=0; i<cc_fields.length; i++){					
					options[cc_fields[i]] = jQuery("[name="+cc_fields[i]+"]:checked").val();
				}
				elements[field] = options;
			}
			else {
				var value;
				if(jQuery("[name="+field+"]").prop("tagName") == 'select')
					value = jQuery("[name="+field+"]:selected").val();
				else if(jQuery("[name="+field+"]").attr("type") == 'radio' || jQuery("[name="+field+"]").attr("type") == 'checkbox' )
					value = jQuery("[name="+field+"]:checked").val();
				else
					value = jQuery("[name="+field+"]").val();
				elements[field] = value;
			}			
		}	
		valueOption = JSON.stringify(elements);
	}
	else
		valueOption = '';
    adminFormSet("options", valueOption);
}

function ShowField(obj){
	
	if(jQuery(obj).val() == 0){		
		jQuery('.test').parent().parent().show();
		jQuery('.live').parent().parent().hide();		
	}
	else{
		jQuery('.test').parent().parent().hide();
		jQuery('.live').parent().parent().show();	
	}

}



////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTabActivated(currentTabIndex) {
    adminFormSet("tab_index", currentTabIndex);
}

function onBtnClickShowField(obj, event){
	ShowField(obj);
}

