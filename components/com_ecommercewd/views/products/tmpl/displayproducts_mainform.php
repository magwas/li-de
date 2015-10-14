<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_mainform.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_mainform.js');


$search_data = $this->search_data;
$filters_data = $this->filters_data;
$arrangement_data = $this->arrangement_data;
$sort_data = $this->sort_data;
$pagination = $this->pagination;
?>

<form name="wd_shop_main_form" action="<?php echo WDFUrl::get_site_url(); ?>index.php" method="POST">
    <input type="hidden" name="product_id" value="">
    <input type="hidden" name="product_count" value="">
    <input type="hidden" name="product_parameters_json" value="">

    <input type="hidden" name="search_name" value="<?php echo $search_data['name']; ?>">
    <input type="hidden" name="search_category_id" value="<?php echo $search_data['category_id']; ?>">

    <input type="hidden" name="filter_filters_opened" value="<?php echo $filters_data['filters_opened']; ?>">
    <input type="hidden" name="filter_manufacturer_ids"
           value="<?php echo implode(',', $filters_data['manufacturer_ids']); ?>">
    <input type="hidden" name="filter_price_from" value="<?php echo $filters_data['price_from']; ?>">
    <input type="hidden" name="filter_price_to" value="<?php echo $filters_data['price_to']; ?>">
    <input type="hidden" name="filter_date_added_range" value="<?php echo $filters_data['date_added_range']; ?>">
    <input type="hidden" name="filter_minimum_rating" value="<?php echo $filters_data['minimum_rating']; ?>">
    <input type="hidden" name="filter_tags" value="<?php echo implode(',', $filters_data['tags']); ?>">

    <input type="hidden" name="arrangement" value="<?php echo $arrangement_data['arrangement']; ?>">

    <input type="hidden" name="sort_by" value="<?php echo $sort_data['sort_by']; ?>">
    <input type="hidden" name="sort_order" value="<?php echo $sort_data['sort_order']; ?>">

    <input type="hidden" name="pagination_limit_start" value="<?php echo $pagination->limitstart; ?>">
    <input type="hidden" name="pagination_limit" value="<?php echo $pagination->limit; ?>">
</form>