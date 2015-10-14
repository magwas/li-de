<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$options = $this->options;
$initial_values = $options['initial_values'];
?>

<table class="adminlist table">
    <tbody>
    <!-- enable guest feedback -->
    <tr>
        <td class="col_key">
            <label for="feedback_enable_guest_feedback">
                <?php echo WDFText::get('ALLOW_GUEST_FEEDBACK'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'feedback_enable_guest_feedback', '', $initial_values['feedback_enable_guest_feedback'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- enable product rating -->
    <tr>
        <td class="col_key">
            <label for="feedback_enable_product_rating">
                <?php echo WDFText::get('ENABLE_PRODUCT_RATING'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'feedback_enable_product_rating', '', $initial_values['feedback_enable_product_rating'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- enable product reviews -->
    <tr>
        <td class="col_key">
            <label for="feedback_enable_product_reviews">
                <?php echo WDFText::get('ENABLE_PRODUCT_REVIEWS'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'feedback_enable_product_reviews', '', $initial_values['feedback_enable_product_reviews'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>


    <!-- publish review when added -->
    <tr>
        <td class="col_key">
            <label for="feedback_publish_review_when_added">
                <?php echo WDFText::get('PUBLISH_REVIEW_WHEN_ADDED'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'feedback_publish_review_when_added', '', $initial_values['feedback_publish_review_when_added'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
    </tbody>

    <!-- ctrls -->
    <tbody>
    <tr>
        <td class="btns_container" colspan="2">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'feedback\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'feedback\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>