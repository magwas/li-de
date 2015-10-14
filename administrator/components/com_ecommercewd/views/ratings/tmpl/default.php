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
$lists = $this->lists;
$list_ratings = $lists['ratings'];
$pagination = $this->pagination;
$rows = $this->rows;


EcommercewdSubToolbar::build();
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <?php
    echo $this->generate_filters($filter_items);
    ?>

    <table class="adminlist table table-striped">
        <thead>
        <tr>
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

            <th class="col_user_name">
                <?php echo JHtml::_('grid.sort', WDFText::get('USER'), 'user_name', $sort_order, $sort_by); ?>
            </th>

            <th class="col_user_ip_address">
                <?php echo JHtml::_('grid.sort', WDFText::get('USER_IP_ADDRESS'), 'user_ip_address', $sort_order, $sort_by); ?>
            </th>

            <th class="col_product_name">
                <?php echo JHtml::_('grid.sort', WDFText::get('PRODUCT'), 'product_name', $sort_order, $sort_by); ?>
            </th>

            <th class="col_rating">
                <?php echo JHtml::_('grid.sort', WDFText::get('RATING'), 'rating', $sort_order, $sort_by); ?>
            </th>
            <th class="col_date">
                <?php echo JHtml::_('grid.sort', WDFText::get('RATING_DATE'), 'date', $sort_order, $sort_by); ?>
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

                <td class="col_user_name">
                    <?php
                    if ($row->user_id != 0) {
                        echo WDFHTML::jfbutton_inline($row->user_name, WDFHTML::BUTTON_INLINE_TYPE_GOTO, '', '', 'href="' . $row->user_view_url . '" target="_blank"', WDFHTML::BUTTON_ICON_POS_RIGHT);
                    } else {
                        echo $row->user_name;
                    }
                    ?>
                </td>

                <td class="col_user_ip_address">
                    <?php echo $row->user_ip_address; ?>
                </td>

                <td class="col_product_name">
                    <?php echo $row->product_name; ?>
                </td>

                <td class="col_rating">
                    <?php
                    echo JHTML::_('select.genericlist', $list_ratings, 'rating_' . $row->id, 'onchange="onBtnUpdateRatingClick(event, this, ' . $row->id . ');"', 'value', 'text', $row->rating);
                    ?>
                </td>
				<td class="col_date">
                    <?php echo $row->date; ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="8">
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