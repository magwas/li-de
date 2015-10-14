<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFAdminViewBase extends WDFDummyJView {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function generate_filters($filter_items) {
        if (empty($filter_items) == true) {
            return '';
        }

        ob_start();
        ?>
        <fieldset>
            <legend><?php echo WDFText::get('FILTERS'); ?></legend>
            <table class="adminlist table table-striped search_table">
                <tbody>
				<tr>
				  <?php
                    foreach ($filter_items as $filter_item) {
                        if ($filter_item->input_type == 'hidden') {
                            continue;
                        }
                        ?>
						<td>
							<label
							for="<?php echo $filter_item->input_name; ?>"><?php echo $filter_item->input_label; ?>
							:</label>
						</td>
						<?php
						}
						?>
						<td></td>
				</tr>				
                <tr>
                    <?php
                    foreach ($filter_items as $filter_item) {
                        if ($filter_item->input_type == 'hidden') {
                            continue;
                        }
                        ?>
                        <td>
                            <?php
                            switch ($filter_item->input_type) {
                                case 'select':
                                    echo JHTML::_('select.genericlist', $filter_item->values_list, $filter_item->input_name, 'class="searchable"', $filter_item->values_list_prop_value, $filter_item->values_list_prop_text, $filter_item->value);
                                    break;
                                case 'date':
                                    echo JHTML::_('calendar', $filter_item->value, $filter_item->input_name, $filter_item->input_name, '%Y-%m-%d', array('class' => 'searchable'));
                                    break;
                                default:
                                    ?>
                                        <input type="<?php echo $filter_item->input_type; ?>"
                                               name="<?php echo $filter_item->input_name; ?>"
                                               id="<?php echo $filter_item->input_name; ?>"
                                               class="searchable"
                                               value="<?php echo $filter_item->value; ?>"/>
                                    <?php
                                    break;
                            }
                            ?>
                        </td>
                    <?php
                    }
                    ?>

                    <td>
                        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SEARCH'), '', '', 'onclick="onBtnSearchClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                        <?php echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
        <?php
        $filters = ob_get_clean();
        return $filters;
    }

    public function generate_order_cell_content($i, $ordering, $class_name) {		
		$data_original_title = $class_name == 'icon-disable-drag' ?  WDFText::get('PLEASE_SORT_BY_ORDER_TO_ENABLE_REORDERING') : '';
        ob_start();
        ?>
        <i class="hasTooltip <?php echo $class_name; ?>" title="<?php echo $data_original_title;?>" data-original-title="<?php echo $data_original_title;?>"></i>
        <input type="hidden"
               name="order[]"
               value="<?php echo $ordering; ?>" />
         
        <?php
        $content = ob_get_clean();
        return $content;
    }

    public function generate_pager(JPagination $pagination) {
        ob_start();
        echo $pagination->getListFooter();
        if (WDFHelper::is_j3() == true) {
            echo $pagination->getLimitBox();
        }
        $content = ob_get_clean();
        return $content;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}