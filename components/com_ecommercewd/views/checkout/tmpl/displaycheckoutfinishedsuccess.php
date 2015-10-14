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


WDFDocument::set_title(WDFText::get('CHECKOUT'));
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- panel -->
            <div class="wd_shop_panel_user_data panel panel-default">
                <div class="panel-body">
                    <h3 class="wd_shop_header">
                        <?php echo WDFText::get('MSG_CHECKOUT_FINISHED_SUCCESSFULLY'); ?>
                    </h3>

                    <p>
                        <?php echo WDFText::get('MSG_CHECKOUT_FINISHED_SUCCESSFULLY_SUB'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>