<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$pages = $this->pages;
$pager_data = $this->pager_data;


WDFDocument::set_title(WDFText::get('CHECKOUT'));
?>

<form name="wd_shop_main_form" action="" method="POST">
</form>

<div class="container">
    <div class="row">
        <h2 class="wd_shop_header">
            <?php echo WDFText::get('LICENSE_PAGES'); ?>
        </h2>

        <div class="col-sm-12">
            <!-- tabs -->
            <ul id="wd_shop_tab_license_pages" class="nav nav-tabs">
                <?php
                $class_active = 'active';
                for ($i = 0; $i < count($pages); $i++) {
                    $page = $pages[$i];
                    ?>
                    <li class="<?php echo $class_active; ?>">
                        <a data-toggle="tab" href="#wd_shop_license_page_<?php echo $i; ?>"
                           onclick="return false;"><?php echo $page->title; ?></a>
                    </li>
                    <?php
                    $class_active = '';
                }
                ?>
            </ul>

            <!-- tab contents -->
            <div class="tab-content">
                <?php
                for ($i = 0; $i < count($pages); $i++) {
                    $page = $pages[$i];
                    $class_active = $i == 0 ? 'active' : '';
                    ?>
                    <div id="wd_shop_license_page_<?php echo $i; ?>"
                         class="tab-pane fade in <?php echo $class_active; ?> text-justify">
                        <?php echo $page->text; ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="wd_divider"></div>

            <form name="wd_shop_form_license_pages" action="" method="POST">
                <div class="radio text-right">
                    <label>
                        <input type="checkbox" name="accept">
                        <?php echo WDFText::get('I_ACCEPT'); ?>
                    </label>
                </div>
            </form>

            <!-- alert -->
            <div class="wd_shop_checkout_alert_licensing alert alert-info wd_hidden">
                <p><?php echo WDFText::get('MSG_YOU_MUST_ACCEPT_LICENSE_AGREEMENT'); ?></p>
            </div>

            <!-- pager -->
            <div>
                <ul class="pager">
                    <?php
                    $btn_cancel_checkout_data = $pager_data['btn_cancel_checkout_data'];
                    ?>
                    <li class="previous">
                        <a href="<?php echo $btn_cancel_checkout_data['url']; ?>">
                            <span><?php echo WDFText::get('BTN_CANCEL_CHECKOUT'); ?></span>
                        </a>
                    </li>

                    <?php
                    if (isset($pager_data['btn_prev_page_data'])) {
                        $btn_prev_page_data = $pager_data['btn_prev_page_data'];
                        ?>
                        <li class="previous">
                            <a href="<?php echo $btn_prev_page_data['action']; ?>"
                               onclick="onWDShop_pagerBtnClick(event, this); return false;">
                                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                                <span><?php echo $btn_prev_page_data['text']; ?></span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (isset($pager_data['btn_next_page_data'])) {
                        $btn_next_page_data = $pager_data['btn_next_page_data'];
                        ?>
                        <li class="next">
                            <a href="<?php echo $btn_next_page_data['action']; ?>"
                               onclick="onWDShop_pagerBtnClick(event, this, <?php echo 'true'; ?>); return false;">
                                <span><?php echo $btn_next_page_data['text']; ?></span>&nbsp;
                                <span class="glyphicon glyphicon-arrow-right"></span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>