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
jQuery(document).ready(function() {
    jQuery('#wd_shop_checkall').click(function(event) {  
        if(this.checked) { 
           jQuery('[name="cid[]"]').each(function() { 
                this.checked = true;      
            });
        }else{
            jQuery('[name="cid[]"]').each(function() { 
                this.checked = false;                     
            });         
        }
		wd_ShopCheck_this();
    });
    
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
Joomla.submitbutton = function(task){
	if (jQuery("[name='cid[]']:checked").length ){
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
	else{
		alert(msg_edit);
	}
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////

function wd_ShopCheck_this(){
	var checked_ids = '';
	jQuery("[name='cid[]']:checked").each( function(){
		checked_ids += jQuery(this).val() + ',';	
	});
	checked_ids = checked_ids.substr(0,checked_ids.length-1);
	adminFormSet('boxcheckeds',checked_ids);
}