<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


function ecommercewdBuildRoute(&$query) {
    $segments = array();

    unset($query['view']);
    // controller
    $controller = '';
    if (isset($query['controller']) == true) {
        $controller = $query['controller'];
        unset($query['controller']);
    }

    // task
    $task = '';
    if (isset($query['task']) == true) {
        $task = $query['task'];
        unset($query['task']);
    }

    switch ($controller) {
        case 'categories':
           // unset($query['Itemid']);
            $segments[] = 'categories';
            switch ($task) {
                case 'displaycategory':
                    if (isset($query['category_id']) == true) {
                        $category_id = (int)$query['category_id'];
                        $category_alias = wd_shop_get_category_alias($category_id);
                        $segments[] = $category_alias;
                        unset($query['category_id']);
                    }
                    break;
            }
            break;
        case 'checkout':
           // unset($query['Itemid']);
            $segments[] = 'checkout';
            if (isset($query['session_id']) == true) {
                $segments[] = $query['session_id'];
                unset($query['session_id']);
            }
            switch ($task) {
                case 'displayshippingdata':
                    $segments[] = 'shipping-data';
                    break;
                case 'displayproductsdata':
                    $segments[] = 'products-data';
                    break;
                case 'displaylicensepages':
                    $segments[] = 'license-pages';
                    break;
                case 'displayconfirmorder':
                    $segments[] = 'confirm-order';
                    break;
                case 'displaycheckoutfinishedsuccess':
                    $segments[] = 'success';
                    break;
                case 'displaycheckoutfinishedfailure':
                    $segments[] = 'failure';
                    break;
            }
            break;
        case 'manufacturers':
           // unset($query['Itemid']);
            $segments[] = 'manufacturers';
            switch ($task) {
                case 'displaymanufacturer':
                    if (isset($query['manufacturer_id']) == true) {
                        $manufacturer_id = (int)$query['manufacturer_id'];
                        $manufacturer_alias = wd_shop_get_manufacturer_alias($manufacturer_id);
                        $segments[] = $manufacturer_alias;
                        unset($query['manufacturer_id']);
                    }
                    break;
            }
            break;
        case 'orders':
            unset($query['Itemid']);
            $segments[] = 'orders';
            switch ($task) {
                case 'displayorder':
                    if (isset($query['order_id']) == true) {
                        $segments[] = $query['order_id'];
                        unset($query['order_id']);
                    }
                    break;
                case 'displayorders':
                    break;
            }
            break;
        case 'products':
            //unset($query['Itemid']);
            $segments[] = 'products';
            switch ($task) {
                case 'displayproduct':
                    $segments[] = 'display';

                    if (isset($query['product_id']) == true) {
                        $product_id = (int)$query['product_id'];
                        $product_alias = wd_shop_get_product_alias($product_id);
                        $segments[] = $product_alias;
                        unset($query['product_id']);
                    }
                    break;
                case 'displayproductreviews':
                    $segments[] = 'reviews';

                    if (isset($query['product_id']) == true) {
                        $product_id = (int)$query['product_id'];
                        $product_alias = wd_shop_get_product_alias($product_id);
                        $segments[] = $product_alias;
                        unset($query['product_id']);
                    }
                    break;
                case 'displaycompareproducts':
                    $segments[] = 'compare';

                    if (isset($query['product_id']) == true) {
                        $product_id = (int)$query['product_id'];
                        $product_alias = wd_shop_get_product_alias($product_id);
                        $segments[] = $product_alias;
                        unset($query['product_id']);
                    }
                    break;
                case 'displayproducts':
                    break;
            }
            break;
        case 'shoppingcart':
           // unset($query['Itemid']);
            $segments[] = 'shopping-cart';
            switch ($task) {
                case 'displayshoppingcart':
                    break;
            }
            break;
        case 'systempages':
            //unset($query['Itemid']);
            switch ($task) {
                case 'displayerror':
                    $segments[] = 'error';
                    break;
            }
            break;
        case 'useraccount':
            //unset($query['Itemid']);
            $segments[] = 'user-account';
            switch ($task) {
                case 'displayuseraccount':
                    break;
            }
            break;
        case 'usermanagement':
           // unset($query['Itemid']);
            switch ($task) {
                case 'displaylogin':
                    $segments[] = 'login';
                    break;
                case 'displayregister':
                    $segments[] = 'register';
                    break;
                case 'displayupdateuserdata':
                    $segments[] = 'edit-account';
                    break;
            }
            break;
    }

    return $segments;
}

function ecommercewdParseRoute($segments) {
    for ($i = 0; $i < count($segments); $i++) {
        $segments[$i] = implode('-', explode(':', $segments[$i]));
    }

    $query = array();

    $query['option'] = 'com_ecommercewd';

    if (isset($segments[0]) == true) {
        switch ($segments[0]) {
            // categories
            case 'categories':
                $query['controller'] = 'categories';
                $query['task'] = 'displaycategory';

                if (isset($segments[1]) == true) {
                    $category_alias = $segments[1];
                    $category_id = wd_shop_get_category_id($category_alias);
                    $query['category_id'] = $category_id;
                }
                break;
            // checkout
            case 'checkout':
                $query['controller'] = 'checkout';
                if (isset($segments[1]) == true) {
                    $query['session_id'] = $segments[1];
                }
                if (isset($segments[2]) == true) {
                    switch ($segments[2]) {
                        case 'shipping-data':
                            $query['task'] = 'displayshippingdata';
                            break;
                        case 'products-data':
                            $query['task'] = 'displayproductsdata';
                            break;
                        case 'license-pages':
                            $query['task'] = 'displaylicensepages';
                            break;
                        case 'confirm-order':
                            $query['task'] = 'displayconfirmorder';
                            break;
                        case 'success':
                            $query['task'] = 'displaycheckoutfinishedsuccess';
                            break;
                        case 'failure':
                            $query['task'] = 'displaycheckoutfinishedfailure';
                            break;
                    }
                }
                break;
            // manufacturers
            case 'manufacturers':
                $query['controller'] = 'manufacturers';
                $query['task'] = 'displaymanufacturer';

                if (isset($segments[1]) == true) {
                    $manufacturer_alias = $segments[1];
                    $manufacturer_id = wd_shop_get_manufacturer_id($manufacturer_alias);
                    $query['manufacturer_id'] = $manufacturer_id;
                }
                break;
            // orders
            case 'orders':
                $query['controller'] = 'orders';
                if (isset($segments[1]) == true) {
                    $query['task'] = 'displayorder';
                    $query['order_id'] = (int)$segments[1];
                } else {
                    $query['task'] = 'displayorders';
                }
                break;
            // products
            case 'products':
                $query['controller'] = 'products';
                if (isset($segments[1]) == true) {
                    switch ($segments[1]) {
                        case 'display':
                            $query['task'] = 'displayproduct';

                            if (isset($segments[2]) == true) {
                                $product_alias = $segments[2];
                                $product_id = wd_shop_get_product_id($product_alias);
                                $query['product_id'] = $product_id;
                            }
                            break;
                        case 'reviews':
                            $query['task'] = 'displayproductreviews';

                            if (isset($segments[2]) == true) {
                                $product_alias = $segments[2];
                                $product_id = wd_shop_get_product_id($product_alias);
                                $query['product_id'] = $product_id;
                            }
                            break;
                        case 'compare':
                            $query['task'] = 'displaycompareproducts';

                            if (isset($segments[2]) == true) {
                                $product_alias = $segments[2];
                                $product_id = wd_shop_get_product_id($product_alias);
                                $query['product_id'] = $product_id;
                            }
                            break;
                    }
                } else {
                    $query['task'] = 'displayproducts';
                }
                break;
            // shoppingcart
            case 'shopping-cart':
                $query['controller'] = 'shoppingcart';
                $query['task'] = 'displayshoppingcart';
                break;
            // systempages
            case 'error':
                $query['controller'] = 'systempages';
                $query['task'] = 'displayerror';
                break;
            // useraccount
            case 'user-account':
                $query['controller'] = 'useraccount';
                $query['task'] = 'displayuseraccount';
                break;
            // usermanagement
            case 'login':
                $query['controller'] = 'usermanagement';
                $query['task'] = 'displaylogin';
                break;
            case 'register':
                $query['controller'] = 'usermanagement';
                $query['task'] = 'displayregister';
                break;
            case 'edit-account':
                $query['controller'] = 'usermanagement';
                $query['task'] = 'displayupdateuserdata';
                break;
        }
    }

    return $query;
}

// helpers
function wd_shop_get_category_alias($id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->clear();
    $query->select('alias');
    $query->from('#__ecommercewd_categories');
    $query->where('id = ' . $id);
    $db->setQuery($query);
    $row_category = $db->loadObject();

    if (($db->getErrorNum()) || ($row_category == null)) {
        return '';
    }

    return $row_category->alias;
}

function wd_shop_get_manufacturer_alias($id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->clear();
    $query->select('alias');
    $query->from('#__ecommercewd_manufacturers');
    $query->where('id = ' . $id);
    $db->setQuery($query);
    $row_manufacturer = $db->loadObject();

    if (($db->getErrorNum()) || ($row_manufacturer == null)) {
        return '';
    }

    return $row_manufacturer->alias;
}

function wd_shop_get_product_alias($id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->clear();
    $query->select('alias');
    $query->from('#__ecommercewd_products');
    $query->where('id = ' . $id);
    $db->setQuery($query);
    $row_product = $db->loadObject();

    if (($db->getErrorNum()) || ($row_product == null)) {
        return '';
    }

    return $row_product->alias;
}

function wd_shop_get_category_id($alias) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->clear();
    $query->select('id');
    $query->from('#__ecommercewd_categories');
    $query->where('alias = ' . $db->quote($alias));
    $db->setQuery($query);
    $row_category = $db->loadObject();

    if (($db->getErrorNum()) || ($row_category == null)) {
        return 0;
    }

    return (int)$row_category->id;
}

function wd_shop_get_manufacturer_id($alias) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->clear();
    $query->select('id');
    $query->from('#__ecommercewd_manufacturers');
    $query->where('alias = ' . $db->quote($alias));
    $db->setQuery($query);
    $row_manufacturer = $db->loadObject();

    if (($db->getErrorNum()) || ($row_manufacturer == null)) {
        return 0;
    }

    return (int)$row_manufacturer->id;
}

function wd_shop_get_product_id($alias) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->clear();
    $query->select('id');
    $query->from('#__ecommercewd_products');
    $query->where('alias = ' . $db->quote($alias));
    $db->setQuery($query);
    $row_product = $db->loadObject();

    if (($db->getErrorNum()) || ($row_product == null)) {
        return 0;
    }

    return (int)$row_product->id;
}
