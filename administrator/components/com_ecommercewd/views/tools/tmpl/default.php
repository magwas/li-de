<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/sub_toolbar_icons.css');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');

EcommercewdSubToolbar::build();

$rows = $this->rows;
$sort_data = $this->sort_data;
$sort_by = $sort_data['sort_by'];
$sort_order = $sort_data['sort_order'];
$pagination = $this->pagination;

?>

<form name="adminForm" id="adminForm" action="" method="POST" enctype="multipart/form-data">
	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th class="col_num">#</th>
				<th class="col_checked"><input type="checkbox" name="checkall-toggle" value="" title="<?php echo WDFText::get('CHECK_ALL'); ?>"  onclick="Joomla.checkAll(this);"/></th>
				<th class="col_id"><?php echo JHTML::_('grid.sort', WDFText::get('ID'), 'id', $sort_order, $sort_by); ?></th>
				<th class="col_name"><?php echo JHTML::_('grid.sort', WDFText::get('NAME'), 'name', $sort_order, $sort_by); ?></th>
				<th class="col_description"><?php echo JHTML::_('grid.sort', WDFText::get('DESCRIPTION'), 'description', $sort_order, $sort_by); ?></th>
				<th class="col_url"><?php echo JHTML::_('grid.sort', WDFText::get('AUTHOR_URL'), 'author_url', $sort_order, $sort_by); ?></th>
				<th class="col_published">
					<?php echo JHtml::_('grid.sort', WDFText::get('ENABLE'), 'published', $sort_order, $sort_by); ?>
				</th>
			</tr>
		</thead>

		<tbody>
			<?php
			for ($i = 0; $i < count($rows); $i++) {
				$row = $rows[$i];
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="col_num">
						<?php echo $pagination->getRowOffset($i); ?>
					</td>

					<td class="col_checked">
						<?php echo JHtml::_('grid.id', $i, $row->id); ?>
					</td>

					<td class="col_id">
						<?php echo $row->id; ?>
					</td>
					<td class="col_name">
						<?php echo ucwords(str_replace('_',' ',$row->name)); ?>
					</td>
					
					<td class="col_description">
						<?php echo $row->description; ?>
					</td>
					<td class="col_url">
						<a href="<?php echo $row->author_url; ?>" target="_blank"><?php echo $row->author_url_text; ?></a>
					</td>
					<td class="col_published">
						<?php echo JHTML::_('jgrid.published', $row->published, $i); ?>
					</td>						
				</tr>
			<?php
			}
			?>
		</tbody>

		<tfoot>
			<tr>
				<td colspan="11">
					<?php echo $this->generate_pager($pagination); ?>
				</td>
			</tr>
		</tfoot>		
	</table>

	<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
	<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value=""/>
	<input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
	<input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>