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
    Joomla.submitbutton = onAdminFormSubmit;
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
function onBtnUpdateOrderStatusClick(event, obj) {
    var jq_mainForm = jQuery("form[name=adminForm]");

    jq_mainForm.find("input[name=task]").val("update_order_status");
    var orderStatusId = jq_mainForm.find("select[name=status_id] option:checked").val();
    jq_mainForm.find("input[name^=order_status]").val(orderStatusId);
    jq_mainForm.find("input[name=redirect_task]").val("view");
    jq_mainForm.submit();
}

function onAdminFormSubmit(pressbutton) { 
	var jq_mainForm = jQuery("form[name=adminForm]");
     if( pressbutton == "printorder"){
		jq_mainForm.attr('target','_blank');
    }	
	else{
		jq_mainForm.attr('target','_self');
	}
    submitform(pressbutton);
}