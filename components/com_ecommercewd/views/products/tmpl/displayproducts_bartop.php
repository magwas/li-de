<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_bartop.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_bartop.js');


$row_user = $this->row_user;
$options = $this->options;


if ($options->search_enable_user_bar == 1){
?>

<nav class="navbar navbar-default" role="navigation">
    <!-- toggle button -->
    <div class="navbar-header">
        <a class="navbar-toggle"
           data-toggle="collapse"
           data-target=".wd_shop_topbar_user_data">
            <span class="sr-only">Toggle user data</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
    </div>

    <!-- navbar content -->
    <div class="wd_shop_topbar_user_data collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
            <!-- shopping cart -->
            <li>
                <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart'); ?>">
                    &nbsp;<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
                    <?php
                    $products_in_cart_class = $row_user->products_in_cart > 0 ? '' : 'wd_hidden';
                    ?>
                    <span class="wd_shop_products_in_cart badge <?php echo $products_in_cart_class; ?>">
                        <?php echo $row_user->products_in_cart; ?>
                    </span>
                </a>
            </li>

            <li class="dropdown">
                <!-- log in/user button -->
                <a href="#"
                   class="bs_dropdown-toggle"
                   data-toggle="bs_dropdown">
                    <?php echo WDFHelper::is_user_logged_in() == true ? $row_user->name : WDFText::get('BTN_LOG_IN'); ?>
                    <span class="glyphicon glyphicon-user"></span>
                    <b class="caret"></b>
                </a>

                <ul class="bs_dropdown-menu" role="menu">
                    <?php
                    if (WDFHelper::is_user_logged_in() == true) {
                        ?>
                        <!-- orders -->
                        <li>
                            <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=displayorders'); ?>">
                                <?php echo WDFText::get('BTN_ORDERS'); ?>
                            </a>
                        </li>

                        <!-- user account -->
                        <li>
                            <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=useraccount&task=displayuseraccount'); ?>">
                                <?php echo WDFText::get('BTN_ACCOUNT'); ?>
                            </a>
                        </li>

                        <li class="divider">
                        </li>

                        <!-- logout -->
                        <li>
                            <a href="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=logout'; ?>">
                                <?php echo WDFText::get('BTN_LOGOUT'); ?>
                            </a>
                        </li>
                    <?php
                    } else {
                        ?>
                        <li>
                            <div class="container">
                                <!-- log in form -->
                                <form name="wd_shop_form_login" class="form-inline" role="form"
                                      action="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=login'; ?>"
                                      method="POST">
                                    <!-- username -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-addon wd-input-xs">
                                                    &nbsp;<span class="glyphicon glyphicon-user"></span>&nbsp;
                                                </span>

                                                <input type="text"
                                                       name="username"
                                                       id="username"
                                                       class="wd_shop_required_field form-control wd-input-xs"
                                                       placeholder="<?php echo WDFText::get('USERNAME'); ?>"
													   onkeydown="wd_shop_submit_form(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- password -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-addon wd-input-xs">
                                                    &nbsp;<span class="glyphicon glyphicon-lock"></span>&nbsp;
                                                </span>

                                                <input type="password"
                                                       name="password"
                                                       id="password"
                                                       class="wd_shop_required_field form-control wd-input-xs"
                                                       placeholder="<?php echo WDFText::get('PASSWORD'); ?>"
													   onkeydown="wd_shop_submit_form(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- remember and login button -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <?php echo WDFText::get('REMEMBER_ME'); ?>
                                                    <input type="checkbox" name="remember">
                                                </label>
                                            </div>

                                            <a href="#"
                                               class="btn btn-primary btn-sm pull-right"
                                               onclick="wdShop_onBtnLoginClick(event, this); return false;">
                                                <?php echo WDFText::get('BTN_LOG_IN'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </form>

                                <!-- alert -->
                                <div class="wd_shop_alert_form_login_incorrect_data alert alert-danger hidden">
                                    <p><?php echo WDFText::get('MSG_FILL_USERNAME_PASSWORD'); ?></p>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<?php
}
?>