<?php
/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal','a.modal');
?>
<style type="text/css">
.icon-48-frontpage{
background:url("components/com_joocomments/assets/icon-48-frontpage.png")
}
p.error{
 color: red !important;
 font-weight: bold;
}
p.success{
color:green !important;
font-weight: bold;
}
</style>
				
				<div class="cpanel-left">
					<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
						<div style="float:right;margin:10px;">
						<?php echo JHTML::_('image', 'administrator/components/com_joocomments/assets/joocomments_logo.png', 'bullraider.com' );?>
						</div>
						<h3>Current Version:</h3><p><?php echo $this->curVersion;?></p><p><?php echo $this->message;?></p>
						<h3>Copyright:</h3><p>&copy; 2009 - 2011 Bullraider.com,Abhiram Mishra</p>
						<h3>License</h3><p><a target="_blank" href="http://www.gnu.org/licenses/gpl-2.0.html">GPLv2</a>
						<p><a target="_blank" href="http://www.bullraider.com/">www.bullraider.com</a></p>
						<h3>F.A.Q and Troubleshooting</h3>
							<p><a target="_blank" href="http://www.bullraider.com/joomla/extensions/joocomments/faq-joocomments/">Click here</a></p>
						<h3>Report problem</h3>
								<p><a target="_blank" href="http://www.bullraider.com/joomla/extensions/joocomments/submit-bugs/">Report Bug on bullraider.com</a> or Write a quick <a class="modal"  rel="{handler: 'iframe', size: {x: 620, y: 370}}" href="index.php?option=com_joocomments&view=mail&layout=modal&tmpl=component&header=Send bug details to author&name=Bullraider&toMail=bullraider@gmx.com&title=Bug Description" >E-Mail</a> to the author</p>
						<h3>Suggestions or Feature request</h3>
							<p><a target="_blank" href="http://www.bullraider.com/joomla/extensions/joocomments/feature-request">Click here</a></p>
						
					</div>
				</div>
				<div class="cpanel-right">
					<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px;text-align:center;">
					<p align="center">Please support JooComments</p>
					<form target="paypal" method="post" action="https://www.paypal.com/en/cgi-bin/webscr">
			<input type="hidden" value="_donations" name="cmd">
			<input type="hidden" value="aaraksheet@gmail.com" name="business">
			<input type="hidden" value="http://www.bullraider.com" name="return">
			<input type="hidden" value="0" name="undefined_quantity">
			<input type="hidden" value="Donate to Bullraider.com" name="item_name">
			Amount:&nbsp;<input type="text" style="text-align:right;" value="" maxlength="10" size="4" name="amount">
<select name="currency_code">
<option value="USD">USD</option>
<option value="EUR">EUR</option>
<option value="GBP">GBP</option>
<option value="CHF">CHF</option>
<option value="AUD">AUD</option>
<option value="HKD">HKD</option>
<option value="CAD">CAD</option>
<option value="JPY">JPY</option>
<option value="NZD">NZD</option>
<option value="SGD">SGD</option>
<option value="SEK">SEK</option>
<option value="DKK">DKK</option>
<option value="PLN">PLN</option>
<option value="HUF">HUF</option>
<option value="CZK">CZK</option>
<option value="ILS">ILS</option>
<option value="MXN">MXN</option>
</select>
			<input type="hidden" value="utf-8" name="charset">
			<input type="hidden" value="1" name="no_shipping">
			<input type="hidden" value="http://www.bullraider.com/images/stories/bullraider.gif" name="image_url">
			<input type="hidden" value="http://www.bullraider.com" name="cancel_return">
			<input type="hidden" value="0" name="no_note"><br><br>
			<input type="image" alt="PayPal secure payments." name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif">
			
		</form>
					</div>
					
				</div>
				
