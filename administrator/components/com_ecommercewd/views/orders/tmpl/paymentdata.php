<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/layout_edit.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_edit.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$lists = $this->lists;
$list_order_statuses = $lists['order_statuses'];

$row = $this->row;

$payment_data = $row->view_payment_data;

?>

<form name="adminForm" id="adminForm" action="" method="post">
<fieldset>
    <legend>
        <?php echo WDFText::get('PAYMENT_DATA'); ?>
    </legend>

    <table class="adminlist table">
        <tbody>
			<!-- payment method -->
			<tr>
				<td> <?php echo WDFText::get('PAYMENT_METHOD'); ?></td>
				<td><?php echo $row->payment_method;?> </td>
			<tr>		
			<!-- payment data -->
			<?php foreach($payment_data as $key=>$value) {?>
			<tr>
				<td class="col_key">
					<label><?php echo $key; ?>:</label>
				</td>
				<td class="col_value">
					<?php 
						if(is_array($value)){ ?>
							<table class="adminlist table">
								<?php
								foreach($value as $k => $v){ ?>
								<tr>
									<td class="col_key">
										<label><?php echo $k; ?>:</label>
									</td>
									<td class="col_value">
										<?php
										if(gettype($v) == "boolean"){
											echo $v ? 'true' : 'false'; 
										}
										else{
											echo $v;
										}	
										?>
									</td>
								<?php					
								}
								?>
								</tr>
							<table>
							<?php
						}
						else{
							if(gettype($value) == "boolean"){
								echo $value ? 'true' : 'false'; 
							}
							else{
								echo $value; 
							}
						}
					?>						
				</td>
			</tr>
			<?php 
			}
			?>
		</tbody>
	</table>
</fieldset>
	
<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="id" value="<?php echo $row->id;?>"/>

</form>