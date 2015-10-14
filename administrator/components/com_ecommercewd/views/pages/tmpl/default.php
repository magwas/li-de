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
WDFHelper::add_css('css/layout_' . $this->_layout . '.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js

WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$filter_items = $this->filter_items;
$sort_data = $this->sort_data;
$sort_by = $sort_data['sort_by'];
$sort_order = $sort_data['sort_order'];
$pagination = $this->pagination;
$rows = $this->rows;

$class_name = 'icon-disable-drag';
if( $sort_by == 'ordering' && $sort_order == 'asc' ){
	WDFHelper::add_script('js/jquery-ui-1.10.3.js');
	WDFHelper::add_script('js/jquery-ordering.js');
	$class_name = 'icon-drag';
}

$enable_ordering = $sort_by == 'ordering' ? true : false;


EcommercewdSubToolbar::build();
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <?php
    echo $this->generate_filters($filter_items);
    ?>

    <table class="adminlist table table-striped">
        <thead>
        <tr>
			<th class="col_ordering">
				  <?php echo JHTML::_('grid.sort', '<i class="icon-menu-order"></i>', 'ordering', $sort_order, $sort_by); ?>
			</th>		
            <th class="col_num">
                #
            </th>

            <th class="col_checked">
                <input type="checkbox"
                       name="checkall-toggle"
                       value=""
                       title="<?php echo WDFText::get('CHECK_ALL'); ?>"
                       onclick="Joomla.checkAll(this);"/>
            </th>

            <th class="col_id">
                <?php echo JHTML::_('grid.sort', WDFText::get('ID'), 'id', $sort_order, $sort_by); ?>
            </th>

            <th class="col_title">
                <?php echo JHTML::_('grid.sort', WDFText::get('TITLE'), 'title', $sort_order, $sort_by); ?>
            </th>
            <th class="col_use_for_all_products">
                <?php echo JHTML::_('grid.sort', WDFText::get('USE_FOR_ALL_PRODUCTS'), 'use_for_all_products', $sort_order, $sort_by); ?>
            </th>

            <th class="col_published">
                <?php echo JHTML::_('grid.sort', WDFText::get('PUBLISHED'), 'published', $sort_order, $sort_by); ?>
            </th>
        </tr>
        </thead>

        <tbody>
        <?php
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            ?>
            <tr class="row<?php echo $i % 2; ?>">
				<td class="col_ordering">
					<?php echo $this->generate_order_cell_content($i, $row->ordering,$class_name); ?>
				</td>
                <td class="col_num">
                    <?php echo $pagination->getRowOffset($i); ?>
                </td>

                <td class="col_checked">
                    <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                </td>

                <td class="col_id">
                    <?php echo $row->id; ?>
                </td>

                <td class="col_title">
                    <a href="<?php echo $row->edit_url; ?>"><?php echo $row->title; ?></a>
                </td>
                <td class="col_use_for_all_products">
                    <?php echo JHTML::_('grid.boolean', $i, $row->use_for_all_products, 'use_for_all_products_on', 'use_for_all_products_off'); ?>
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
            <td colspan="7">
                <?php echo $this->generate_pager($pagination); ?>
            </td>
        </tr>
        </tfoot>
    </table>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
    <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>