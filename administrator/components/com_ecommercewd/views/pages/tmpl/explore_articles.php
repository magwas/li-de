<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/layout_explore.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_explore.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$filter_items = $this->filter_items;
$sort_data = $this->sort_data;
$sort_by = $sort_data['sort_by'];
$sort_order = $sort_data['sort_order'];
$pagination = $this->pagination;
$rows = $this->rows;
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

            <th class="col_id">
                <?php echo JHTML::_('grid.sort', WDFText::get('ID'), 'id', $sort_order, $sort_by); ?>
            </th>

            <th class="col_title">
                <?php echo JHtml::_('grid.sort', WDFText::get('TITLE'), 'title', $sort_order, $sort_by); ?>
            </th>

            <th class="col_category_title">
                <?php echo WDFText::get('CATEGORY'); ?>
            </th>

            <th class="col_published">
                <?php echo JHtml::_('grid.sort', WDFText::get('PUBLISHED'), 'state', $sort_order, $sort_by); ?>
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
                itemTitle="<?php echo $row->title; ?>">
                <td class="col_num">
                    <?php echo $pagination->getRowOffset($i); ?>
                </td>

                <td class="col_id">
                    <?php echo $row->id; ?>
                </td>

                <td class="col_title">
                    <a href="#" onclick="onItemClick(event, this);"><?php echo $row->title; ?></a>
                </td>

                <td class="col_category_title">
                    <?php echo $row->category_title; ?>
                </td>

                <td class="col_published">
                    <?php echo WDFHTML::icon_boolean_inactive($row->published); ?>
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


    <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value="explore_articles"/>
    <input type="hidden" name="boxchecked" value=""/>
    <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
    <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>

<script>
    var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>