<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdTableThemes extends JTable {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    public $id = 0;
    public $name = '';
    public $rounded_corners = 0;
    public $content_main_color = 0;

    // header
    public $header_content_color = 0;

    // subtext
    public $subtext_content_color = 0;

    // input
    public $input_content_color = 0;
    public $input_bg_color = 0;
    public $input_border_color = 0;
    public $input_focus_border_color = 0;
    public $input_has_error_content_color = 0;

    // button default
    public $button_default_content_color = 0;
    public $button_default_bg_color = 0;
    public $button_default_border_color = 0;
    // button primary
    public $button_primary_content_color = 0;
    public $button_primary_bg_color = 0;
    public $button_primary_border_color = 0;
    // button success
    public $button_success_content_color = 0;
    public $button_success_bg_color = 0;
    public $button_success_border_color = 0;
    // button info
    public $button_info_content_color = 0;
    public $button_info_bg_color = 0;
    public $button_info_border_color = 0;
    // button warning
    public $button_warning_content_color = 0;
    public $button_warning_bg_color = 0;
    public $button_warning_border_color = 0;
    // button danger
    public $button_danger_content_color = 0;
    public $button_danger_bg_color = 0;
    public $button_danger_border_color = 0;
    // button link
    public $button_link_content_color = 0;

    // divider
    public $divider_color = 0;

    // navbar
    public $navbar_bg_color = 0;
    public $navbar_border_color = 0;
    public $navbar_link_content_color = 0;
    public $navbar_link_hover_content_color = 0;
    public $navbar_link_open_content_color = 0;
    public $navbar_link_open_bg_color = 0;
    public $navbar_badge_content_color = 0;
    public $navbar_badge_bg_color = 0;
    public $navbar_dropdown_link_content_color = 0;
    public $navbar_dropdown_link_hover_content_color = 0;
    public $navbar_dropdown_link_hover_background_content_color = 0;
    public $navbar_dropdown_divider_color = 0;
    public $navbar_dropdown_background_color = 0;
    public $navbar_dropdown_border_color = 0;

    // modal
    public $modal_backdrop_color = 0;
    public $modal_bg_color = 0;
    public $modal_border_color = 0;
    public $modal_dividers_color = 0;

    // panel user data
    public $panel_user_data_bg_color = 0;
    public $panel_user_data_border_color = 0;
    public $panel_user_data_footer_bg_color = 0;

    // panel product
    public $panel_product_bg_color = 0;
    public $panel_product_border_color = 0;
    public $panel_product_footer_bg_color = 0;

    // well
    public $well_bg_color = 0;
    public $well_border_color = 0;

    // rating star
    public $rating_star_type = 0;
    public $rating_star_color = 0;
    public $rating_star_bg_color = 0;

    // label
    public $label_content_color = 0;
    public $label_bg_color = 0;

    // alert
    public $alert_info_content_color = 0;
    public $alert_info_bg_color = 0;
    public $alert_info_border_color = 0;

    public $alert_danger_content_color = 0;
    public $alert_danger_bg_color = 0;
    public $alert_danger_border_color = 0;

    // breadcrumbs
    public $breadcrumb_content_color = 0;
    public $breadcrumb_bg_color = 0;

    // pills
    public $pill_link_content_color = 0;
    public $pill_link_hover_content_color = 0;
    public $pill_link_hover_bg_color = 0;

    // tabs
    public $tab_link_content_color = 0;
    public $tab_link_hover_content_color = 0;
    public $tab_link_hover_bg_color = 0;
    public $tab_link_active_content_color = 0;
    public $tab_link_active_bg_color = 0;
    public $tab_border_color = 0;

    //pagination
    public $pagination_content_color = 0;
    public $pagination_bg_color = 0;
    public $pagination_hover_content_color = 0;
    public $pagination_hover_bg_color = 0;
    public $pagination_active_content_color = 0;
    public $pagination_active_bg_color = 0;
    public $pagination_border_color = 0;

    // pager
    public $pager_content_color = 0;
    public $pager_bg_color = 0;
    public $pager_border_color = 0;

    // product
    public $product_name_color = 0;
    public $product_category_color = 0;
    public $product_manufacturer_color = 0;
    public $product_model_color = 0;
    public $product_code_color = 0;
    public $product_price_color = 0;
    public $product_market_price_color = 0;

    // products filters position
    public $products_filters_position = 0;

    // products count
    public $products_count_in_page = 12;
    public $products_option_columns = 3;

    // products view arrangement thumbs
    public $products_thumbs_view_show_image = 1;
    public $products_thumbs_view_show_label = 1;
    public $products_thumbs_view_show_name = 1;
    public $products_thumbs_view_show_rating = 1;
    public $products_thumbs_view_show_price = 1;
    public $products_thumbs_view_show_market_price = 1;
    public $products_thumbs_view_show_description = 1;
    public $products_thumbs_view_show_button_quick_view = 1;
    public $products_thumbs_view_show_button_compare = 1;
    public $products_thumbs_view_show_button_buy_now = 1;
    public $products_thumbs_view_show_button_add_to_cart = 1;

    // products view arrangement list
    public $products_list_view_show_image = 1;
    public $products_list_view_show_label = 1;
    public $products_list_view_show_name = 1;
    public $products_list_view_show_rating = 1;
    public $products_list_view_show_price = 1;
    public $products_list_view_show_market_price = 1;
    public $products_list_view_show_description = 1;
    public $products_list_view_show_button_quick_view = 1;
    public $products_list_view_show_button_compare = 1;
    public $products_list_view_show_button_buy_now = 1;
    public $products_list_view_show_button_add_to_cart = 1;

    // products view quick view
    public $products_quick_view_show_image = 1;
    public $products_quick_view_show_label = 1;
    public $products_quick_view_show_name = 1;
    public $products_quick_view_show_rating = 1;
    public $products_quick_view_show_category = 1;
    public $products_quick_view_show_manufacturer = 1;
    public $products_quick_view_show_model = 1;
    public $products_quick_view_show_price = 1;
    public $products_quick_view_show_market_price = 1;
    public $products_quick_view_show_description = 1;
    public $products_quick_view_show_button_compare = 1;
    public $products_quick_view_show_button_buy_now = 1;
    public $products_quick_view_show_button_add_to_cart = 1;

    // product view
    public $product_view_show_image = 1;
    public $product_view_show_label = 1;
    public $product_view_show_name = 1;
    public $product_view_show_rating = 1;
    public $product_view_show_category = 1;
    public $product_view_show_manufacturer = 1;
    public $product_view_show_model = 1;
    public $product_view_show_price = 1;
    public $product_view_show_market_price = 1;
    public $product_view_show_button_compare = 1;
    public $product_view_show_button_write_review = 1;
    public $product_view_show_button_buy_now = 1;
    public $product_view_show_button_add_to_cart = 1;
    public $product_view_show_description = 1;
    public $product_view_show_social_buttons = 1;
    public $product_view_show_parameters = 1;
    public $product_view_show_shipping_info = 1;
    public $product_view_show_reviews = 1;
    public $product_view_show_related_products = 1;

    // orders
    public $orders_count_in_page = 12;

    public $basic = 0;
    public $default = 0;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    function __construct(&$db) {
        parent::__construct('#__ecommercewd_themes', 'id', $db);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
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