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
                        <?php echo WDFText::get('MSG_CHECKOUT_FAILED'); ?>
                    </h3>

                    <p>
                        <?php echo WDFInput::get('error_msg'); ?>
                    </p>
					<!-- pager -->
					<div>
						<ul class="pager">			
							<li class="previous">
								<a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart'); ?>">
									<span><?php echo WDFText::get('BTN_CANCEL_CHECKOUT'); ?></span>
								</a>
							</li>
							<li class="previous">
								<a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=checkout&task=displayconfirmorder&session_id=' . WDFInput::get('session_id')); ?>"
								   onclick="onWDShop_pagerBtnClick(event, this); return false;">
									<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;
									<span><?php echo WDFText::get('BTN_CONFIRM_ORDER'); ?></span>
								</a>
							</li>
						</ul>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>