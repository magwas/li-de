 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

Joomla.submitbutton = function(task)
{	
	if ( document.getElementById('upload').value == ''  ) 
		alert(no_file);
	else
		Joomla.submitform(task, document.getElementById('adminForm'));
}





