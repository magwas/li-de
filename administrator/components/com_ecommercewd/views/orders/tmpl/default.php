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
$list_order_statuses = $lists['order_statuses'];

$pagination = $this->pagination;
$rows = $this->rows;



EcommercewdSubToolbar::build();
?>

<form name="adminForm" id="adminForm" method="post" action="" >
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
            <th class="col_order_link">
               <?php echo WDFText::get('VIEW_ORDER'); ?>
            </th>
            <th class="col_order_link">
               <?php echo WDFText::get('PAYMENT_DATA'); ?>
            </th>			
            <th class="col_user_name">
                <?php echo WDFText::get('USER_NAME'); ?>
            </th>

            <th class="col_user_ip_address">
                <?php echo JHTML::_('grid.sort', WDFText::get('USER_IP_ADDRESS'), 'user_ip_address', $sort_order, $sort_by); ?>
            </th>

            <th class="col_product_names">
                <?php echo WDFText::get('PRODUCTS'); ?>
            </th>

            <th class="col_total_price">
                <?php echo WDFText::get('TOTAL_PRICE'); ?>
            </th>

            <th class="col_checkout_date">
                <?php echo JHTML::_('grid.sort', WDFText::get('CHECKOUT_DATE'), 'checkout_date', $sort_order, $sort_by); ?>
            </th>

            <th class="col_date_modified">
                <?php echo JHTML::_('grid.sort', WDFText::get('DATE_MODIFIED'), 'date_modified', $sort_order, $sort_by); ?>
            </th>

            <th class="col_order_status">
                <?php echo JHTML::_('grid.sort', WDFText::get('ORDER_STATUS'), 'status_id', $sort_order, $sort_by); ?>
            </th>

            <th class="col_payment_status">
                <?php echo WDFText::get('PAYMENT_STATUS'); ?>
            </th>

            <th class="col_read">
                <?php echo JHTML::_('grid.sort', WDFText::get('READ'), 'read', $sort_order, $sort_by); ?>
            </th>
        </tr>
        </thead>

        <tbody>
        <?php
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            ?>
            <tr class="row<?php echo $row->read; ?>">
                <td class="col_num">
                    <?php echo $pagination->getRowOffset($i); ?>
                </td>

                <td class="col_checked">
                    <?php echo JHtml::_('grid.id', $i, $row->id); ?>
                </td>

                <td class="col_id">
                   <?php echo $row->id; ?>
                </td>
				
				<td class="col_order_link">
					 <a href="<?php echo $row->view_url; ?>"><?php echo WDFText::get('VIEW_ORDER'); ?></a>
				</td>
				<td class="col_order_link">
					 <a href="javascript:void(0)" onclick="onBtnPaymentsDataClick(event,this);" data-payment-data-url = "<?php echo $row->view_payment_data_url; ?>" ><?php echo WDFText::get('VIEW_PAYMENT_DATA'); ?></a>
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

                <td class="col_product_names">
                    <?php echo $row->product_names; ?>
                </td>

                <td class="col_total_price">
                    <?php echo $row->total_price_text; ?>
                </td>

                <td class="col_checkout_date">
                    <?php echo $row->checkout_date; ?>
                </td>

                <td class="col_date_modified">
                    <?php echo $row->date_modified; ?>
                </td>

                <td class="col_order_status">
                    <?php
                    echo JHTML::_('select.genericlist', $list_order_statuses, 'order_status_' . $row->id, '', 'id', 'name', $row->status_id);
                    echo WDFHTML::jfbutton(WDFText::get('BTN_SAVE'), '', '', 'onclick="onBtnUpdateOrderStatusClick(event, this, ' . $row->id . ');"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL);
                    ?>
                </td>

                <td class="col_payment_status">
                    <?php echo $row->payment_data_status; ?>
                </td>

                <td class="col_read">
                    <?php echo JHTML::_('grid.boolean', $i, $row->read, 'set_as_read', 'set_as_unread'); ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="14">
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
