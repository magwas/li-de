 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/



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
function onBtnUpdateOrderStatusClick(event, obj, orderStatusId) {
    var jq_mainForm = jQuery("form[name=adminForm]");

    jq_mainForm.find("input[name^=cid], input[name=checkall-toggle]").prop("checked", false);
    jq_mainForm.find("input[name^=cid][value=" + orderStatusId + "]").prop("checked", true);

    jq_mainForm.find("input[name=order_status]").val("checked");

    jq_mainForm.find("input[name=task]").val("update_order_status");
    jq_mainForm.submit();
}

function onBtnPaymentsDataClick(event, obj) {
  	wdShop_paymentDataUrl = jQuery(obj).attr('data-payment-data-url');
    openPopUp(wdShop_paymentDataUrl);
}

function onAdminFormSubmit(pressbutton) { 
	var jq_mainForm = jQuery("form[name=adminForm]");
     if( pressbutton == "printorderbulk"){
		jq_mainForm.attr('target','_blank');
    }	
	else{
		jq_mainForm.attr('target','_self');
	}
    submitform(pressbutton);
}