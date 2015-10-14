<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');
$row = $this->row;
$class_name = $row->class_name;
$row_cc_fields = $row->cc_fields;
$cc_fields = $class_name ::$cc_fields ;

?>
<table class="adminlist table">
	<tbody>
		<?php foreach( $cc_fields as $key => $field): 
			$checked = isset($row_cc_fields->$key) ? $row_cc_fields->$key : '0';
			if($field == 1)	
				$list = WDFText::get('THIS_FIELD_IS_REQUIRED');
			else
				$list = JHTML::_('select.radiolist',array((object)array('value'=>0, 'text'=> WDFText::get('HIDE')),(object) array('value'=>1, 'text' => WDFText::get('SHOW')),(object) array('value'=>2, 'text' => WDFText::get('SHOW_AND_REQUIRE'))) , $key, '', 'value', 'text', $checked);

		?>
			<tr>
				<td class="col_key">
					<label for="<?php echo $key; ?>">
						<?php echo WDFText::get($key) ; ?>:
					</label>
				</td>

				<td class="col_value">
					<?php echo $list ?>
				</td>
			</tr>
		<?php endforeach;?>

	</tbody>
</table>


<?php

?>



