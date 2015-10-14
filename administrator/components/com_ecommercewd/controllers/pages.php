<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerPages extends EcommercewdController {
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
    public function explore_articles() {
        WDFInput::set('tmpl', 'component');
        parent::display();
    }

    public function remove() {
        $this->remove_product_pages(WDFInput::get_checked_ids());

        parent::remove();
    }

    public function use_for_all_products_on() {
        WDFDb::set_checked_rows_data('pages', 'use_for_all_products', 1);
        WDFHelper::redirect('pages');
    }

    public function use_for_all_products_off() {
        WDFDb::set_checked_rows_data('pages', 'use_for_all_products', 0);
        WDFHelper::redirect('pages');
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function remove_product_pages($ids) {
        if (empty($ids) == true) {
            return false;
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->delete();
        $query->from('#__ecommercewd_productpages');
        $query->where('page_id IN (' . implode(',', $ids) . ')');
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            die();
        }
    }

    protected function store_input_in_row() {
        $is_article = WDFInput::get('is_article', 0, 'int');
        if ($is_article == 1) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $article_id = WDFInput::get('article_id', 0, 'int');

            $query->clear();
            $query->select('title');
            $query->from('#__content');
            $query->where('id = ' . $article_id);
            $db->setQuery($query);
            $article_title = $db->loadResult();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                die();
            }

            WDFInput::set('title', $article_title);
        }

        $row = parent::store_input_in_row();
        return $row;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}