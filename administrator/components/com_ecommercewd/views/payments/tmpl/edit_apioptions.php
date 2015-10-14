<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');
$lists = $this->lists;
$row = $this->row;
$row_fields = $row->fields ;
$fields = $row->field_types ;


 if(WDFInput::get("type")!='without_online_payment'):?>
	<div id="wd_paymnet_options">
		<!-- Api fields -->
		<table class="adminlist table">
			<tbody>
				<?php foreach( $fields as $key => $field): 
					if($field['type'] == 'radio'):
						$checked = ($row_fields->$key === '') ? 0 : $row_fields->$key;
					?>
						<tr>
							<td class="col_key">
								<label for="<?php echo $key; ?>">
									<?php echo WDFText::get($field['text']); ?>:
								</label>
							</td>

							<td class="col_value">
								<?php echo JHTML::_('select.radiolist', $lists['radio'][$key], $key, $field['attributes'], 'value', 'text', $checked); ?>
							</td>
						</tr>
					<?php elseif($field['type'] == 'select'):?>
						<tr>
							<td class="col_key">
								<label for="<?php echo $key; ?>">
									<?php echo WDFText::get($field['text']); ?>:
								</label>
							</td>

							<td class="col_value">								
								<?php echo JHTML::_('select.genericlist', $field['options'], $key, $field['attributes'], 'value', 'text', $row_fields->$key); ?>
							</td>
						</tr>
					<?php else:?>					
						<tr>
							<td class="col_key">
								<label for="<?php echo $key; ?>"><?php echo WDFText::get($field['text']); ?>:</label>
							</td>
							<td class="col_value">
								<input type="text" name="<?php echo $key; ?>" value="<?php echo $row_fields->$key;?>" id="<?php echo $key; ?>" <?php echo $field['attributes'];?>/>
							</td>
						</tr>
					<?php endif;?>	
				<?php endforeach;?>
			</tbody>
		</table>
	</div>	
<?php endif;?>
	<table class="adminlist table">
		<tbody>
			<!-- published -->
			<tr>
				<td class="col_key">
					<label><?php echo WDFText::get('PUBLISHED'); ?>:</label>
				</td>
				<td class="col_value">
					<?php echo JHTML::_('select.booleanlist', 'published', '', $row->published, WDFText::get('YES'), WDFText::get('NO')); ?>
				</td>
			</tr>

		</tbody>
	</table>





