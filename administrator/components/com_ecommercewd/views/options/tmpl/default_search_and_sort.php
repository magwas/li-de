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
    <!-- enable user bar -->
    <tr>
        <td class="col_key">
            <label for="search_enable_search">
                <?php echo WDFText::get('ENABLE_USER_BAR'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'search_enable_user_bar', '', $initial_values['search_enable_user_bar'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>	
    <!-- enable search -->
    <tr>
        <td class="col_key">
            <label for="search_enable_search">
                <?php echo WDFText::get('ENABLE_SEARCH'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'search_enable_search', '', $initial_values['search_enable_search'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- search by category -->
    <tr>
        <td class="col_key">
            <label for="search_by_category">
                <?php echo WDFText::get('SEARCH_BY_CATEGORY'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'search_by_category', '', $initial_values['search_by_category'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- include subcategories -->
    <tr>
        <td class="col_key">
            <label for="search_include_subcategories">
                <?php echo WDFText::get('INCLUDE_SUBCATEGORIES'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'search_include_subcategories', '', $initial_values['search_include_subcategories'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- filter manufacturers -->
    <tr>
        <td class="col_key">
            <label for="filter_manufacturers">
                <?php echo WDFText::get('FILTER_MANUFACTURERS'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'filter_manufacturers', '', $initial_values['filter_manufacturers'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- filter price -->
    <tr>
        <td class="col_key">
            <label for="filter_price">
                <?php echo WDFText::get('FILTER_PRICE'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'filter_price', '', $initial_values['filter_price'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- filter date added -->
    <tr>
        <td class="col_key">
            <label for="filter_date_added">
                <?php echo WDFText::get('FILTER_DATE_ADDED'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'filter_date_added', '', $initial_values['filter_date_added'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- filter minimum rating -->
    <tr>
        <td class="col_key">
            <label for="filter_minimum_rating">
                <?php echo WDFText::get('FILTER_MINIMUM_RATING'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'filter_minimum_rating', '', $initial_values['filter_minimum_rating'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- filter tags -->
    <tr>
        <td class="col_key">
            <label for="filter_tags">
                <?php echo WDFText::get('FILTER_TAGS'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'filter_tags', '', $initial_values['filter_tags'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- sort by name -->
    <tr>
        <td class="col_key">
            <label for="sort_by_name">
                <?php echo WDFText::get('SORT_BY_NAME'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'sort_by_name', '', $initial_values['sort_by_name'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- sort by manufacturer -->
    <tr>
        <td class="col_key">
            <label for="sort_by_manufacturer">
                <?php echo WDFText::get('SORT_BY_MANUFACTURER'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'sort_by_manufacturer', '', $initial_values['sort_by_manufacturer'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- sort by price -->
    <tr>
        <td class="col_key">
            <label for="sort_by_price">
                <?php echo WDFText::get('SORT_BY_PRICE'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'sort_by_price', '', $initial_values['sort_by_price'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- sort by count of reviews -->
    <tr>
        <td class="col_key">
            <label for="sort_by_count_of_reviews">
                <?php echo WDFText::get('SORT_BY_NUMBER_OF_REVIEWS'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'sort_by_count_of_reviews', '', $initial_values['sort_by_count_of_reviews'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>

    <!-- sort by rating -->
    <tr>
        <td class="col_key">
            <label for="sort_by_rating">
                <?php echo WDFText::get('SORT_BY_RATING'); ?>:
            </label>
        </td>
        <td class="col_value">
            <?php echo JHTML::_('select.booleanlist', 'sort_by_rating', '', $initial_values['sort_by_rating'], WDFText::get('YES'), WDFText::get('NO')); ?>
        </td>
    </tr>
    </tbody>

    <!-- ctrls -->
    <tbody>
    <tr>
        <td class="btns_container" colspan="2">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'search_and_sort\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'search_and_sort\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>