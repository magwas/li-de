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


$user_data = $this->user_data;


WDFDocument::set_title(WDFText::get('USER_DATA'));
?>

<div class="container">
    <div class="row">
        <!-- links -->
        <div class="col-sm-3">
            <ul class="nav nav-pills nav-stacked">
                <!-- shopping cart -->
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart'); ?>"><?php echo WDFText::get('BTN_SHOPPING_CART'); ?></a>
                </li>

                <!-- orders -->
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=orders&task=displayorders'); ?>"><?php echo WDFText::get('BTN_ORDERS'); ?></a>
                </li>
				
            </ul>
        </div>

        <!-- user data -->
        <div class="col-sm-9">
            <div class="wd_shop_panel_user_data panel panel-default">
                <div class="panel-body">
                    <h3 class="wd_shop_header">
                        <?php echo WDFText::get('USER_DATA'); ?>
                    </h3>

                    <dl class="dl-horizontal">
                        <?php
                        foreach ($user_data as $data) {
                            ?>
                            <dt><p><?php echo $data->key; ?>:</p></dt>
                            <dd><p><?php echo $data->value; ?></p></dd>
                        <?php
                        }
                        ?>
                    </dl>
                </div>

                <div class="panel-footer text-right">
                    <div class="btn-group">
                        <!-- edit btn -->
                        <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=displayupdateuserdata'); ?>"
                           class="btn btn-primary">
                            <?php echo WDFText::get('BTN_EDIT_DATA'); ?>
                        </a>

                        <!-- log out -->
                        <a href="<?php echo WDFUrl::get_site_url(); ?>index.php?option=com_<?php echo WDFHelper::get_com_name();?>&controller=usermanagement&task=logout"
                           class="btn btn-default">
                            <?php echo WDFText::get('BTN_LOGOUT'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>