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

WDFDocument::set_title(WDFText::get('LOG_IN'));

?>

<div class="container">
    <div class="row">
        <div class="<?php if(!WDFInput::get("module_id")):?>col-sm-8 col-sm-offset-2<?php endif;?>">
            <div class="wd_shop_panel_user_data panel panel-default">
                <div class="panel-body">
                    <h3 class="wd_shop_header">
                        <?php echo WDFText::get('LOG_IN'); ?>
                    </h3>

                    <!-- log in form -->
                    <form name="wd_shop_form_login" class="form-horizontal" role="form" id="wd_shop_form_login"
                          action="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=login'; ?>"
                          method="POST">
                        <!-- username -->
                        <div class="form-group">
                            <label for="username" class="col-sm-4 control-label">
                                <?php echo WDFText::get("USERNAME"); ?>:
                            </label>

                            <div class="col-sm-8">
                                <input type="text"
                                       name="username"
                                       id="username" 
									   onkeydown="wd_shop_submit_form(event);"
                                       class="wd_shop_required_field form-control"
                                       placeholder="<?php echo WDFText::get('USERNAME'); ?>">
                            </div>
                        </div>

                        <!-- password -->
                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label">
                                <?php echo WDFText::get("PASSWORD"); ?>:
                            </label>

                            <div class="col-sm-8">
                                <input type="password"
                                       name="password"
                                       id="password" 
									   onkeydown="wd_shop_submit_form(event);"
                                       class="wd_shop_required_field form-control"
                                       placeholder="<?php echo WDFText::get('PASSWORD'); ?>">
                            </div>
                        </div>

                        <!-- remember -->
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <?php echo WDFText::get('REMEMBER_ME'); ?>
                                        <input type="checkbox" name="remember">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="redirect_url"
                               value="<?php echo WDFInput::get('redirect_url', WDFUrl::get_referer_url()); ?>">
				   </form>

                    <!-- alert -->
                    <div class="wd_shop_alert_incorrect_data alert alert-danger hidden">
                        <p><?php echo WDFText::get('MSG_FILL_USERNAME_PASSWORD'); ?></p>
                    </div>
                </div>

                <div class="panel-footer text-right">
                    <!-- login/register buttons -->
                    <div class="btn-group">
                        <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=displayregister'); ?>"
                           class="btn btn-default">
                            <?php echo WDFText::get('BTN_REGISTER'); ?>
                        </a>

                        <a href="#"
                           class="btn btn-primary"
                           onclick="wdShop_onBtnLoginClick(event, this); return false;">
                            <?php echo WDFText::get('BTN_LOG_IN'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- additional links -->
            <div>
                <p class="text-right">
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"
                       class="link"><?php echo WDFText::get('BTN_FORGOT_PASSWORD'); ?></a>
                </p>

                <p class="text-right">
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"
                       class="link"><?php echo WDFText::get('BTN_FORGOT_USERNAME'); ?></a>
                </p>
            </div>
        </div>
    </div>
</div>

