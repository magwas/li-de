<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
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

$ignore_required = WDFInput::get('ignore_required') == 'true' ? true : false;
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
                       id="checkall-toggle"
                       value=""
                       title="<?php echo WDFText::get('CHECK_ALL'); ?>"
                       onclick="Joomla.checkAll(this);"/>
            </th>

            <th class="col_id">
                <?php echo JHTML::_('grid.sort', WDFText::get('ID'), 'id', $sort_order, $sort_by); ?>
            </th>

            <th class="col_name">
                <?php echo JHtml::_('grid.sort', WDFText::get('NAME'), 'name', $sort_order, $sort_by); ?>
            </th>
            <th class="col_type">
                <?php echo JHtml::_('grid.sort', WDFText::get('TYPE'), 'type', $sort_order, $sort_by); ?>
            </th>
            <th class="col_required">
                <?php echo JHtml::_('grid.sort', WDFText::get('Required'), 'required', $sort_order, $sort_by); ?>
            </th>
        </tr>
        </thead>

        <tbody>
        <?php
        for ($i = 0; $i < count($rows); $i++) {
            $row = $rows[$i];
            ?>
            <tr class="row<?php echo $i % 2; ?>"
                itemId="<?php echo $row->id; ?>"
                itemName="<?php echo $row->name; ?>"
                itemTypeId="<?php echo $row->type_id; ?>"
                itemTypeName="<?php echo $row->type_name; ?>"
                itemDefaultValues='<?php echo $row->default_values; ?>'
                itemRequired="<?php echo $ignore_required == true ? 0 : $row->required; ?>">
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
                    <a href="#" onclick="onItemClick(event, this);"><?php echo $row->name; ?></a>
                </td>
				
                <td class="col_type">
                    <?php echo $row->type_name; ?>
                </td>				

                <td class="col_required">
                    <?php echo WDFHTML::icon_boolean_inactive($row->required); ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="6">
                <?php echo $this->generate_pager($pagination); ?>
            </td>
        </tr>
        </tfoot>
    </table>

    <table class="adminlist table table-striped">
        <tbody>
        <tr>
            <td class="btns_container">
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_INSERT'), '', '', 'onclick="onBtnInsertClick(event, this);"'); ?>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value="explore"/>
    <input type="hidden" name="boxchecked" value=""/>
    <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
    <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>

<script>
    var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>