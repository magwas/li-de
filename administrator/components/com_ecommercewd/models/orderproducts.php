<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdModelOrderProducts extends EcommercewdModel {
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
    public function get_order_data() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $order_id = WDFInput::get('order_id');

        $query->clear();
        $query->select('GROUP_CONCAT(
            CONCAT(
                "<strong>", T_ORDER_PRODUCTS.product_name, "</strong>",
                " (",
                T_ORDER_PRODUCTS.product_price,
                " + ' . WDFText::get('TAX') . ': ", T_ORDER_PRODUCTS.tax_price,
                " + ' . WDFText::get('SHIPPING') . ': ", T_ORDER_PRODUCTS.shipping_method_price,
                ") x", T_ORDER_PRODUCTS.product_count,
                " = ",
                "<strong>", (T_ORDER_PRODUCTS.product_price + T_ORDER_PRODUCTS.tax_price + T_ORDER_PRODUCTS.shipping_method_price) * T_ORDER_PRODUCTS.product_count, "</strong>"
            )
        SEPARATOR "<hr>") AS product_names');
        $query->select('SUM((T_ORDER_PRODUCTS.product_price + T_ORDER_PRODUCTS.tax_price + T_ORDER_PRODUCTS.shipping_method_price) * T_ORDER_PRODUCTS.product_count) AS total_price');
        $query->select('CONCAT(SUM((T_ORDER_PRODUCTS.product_price + T_ORDER_PRODUCTS.tax_price + T_ORDER_PRODUCTS.shipping_method_price) * T_ORDER_PRODUCTS.product_count), " ", T_ORDER_PRODUCTS.currency_code) AS total_price_text');
        $query->select('T_ORDER_PRODUCTS.currency_code');
        $query->from('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS');
        $query->where('T_ORDER_PRODUCTS.order_id = ' . $order_id);

        $db->setQuery($query);
        $order_data = $db->loadObject();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }

        return $order_data;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    protected function add_rows_query_select(JDatabaseQuery $query) {
        parent::add_rows_query_select($query);

        $query->select('(product_price + tax_price + shipping_method_price) * product_count AS subtotal');
    }

    protected function add_rows_query_where(JDatabaseQuery $query) {
        $order_id = WDFInput::get('order_id');
        $query->where('order_id = ' . $order_id);
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}