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


$form_fields = $this->form_fields;
$user_data = $this->user_data;


WDFDocument::set_title(WDFText::get('EDIT_DATA'));
?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="wd_shop_panel_user_data panel panel-default">
                <div class="panel-body">
                    <h3 class="wd_shop_header">
                        <?php echo WDFText::get('EDIT_DATA'); ?>
                    </h3>

                    <!-- update data form -->
                    <form name="wd_shop_form_update_data"
                          class="form-horizontal"
                          role="form"
                          action="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=updateuserdata'; ?>"
                          method="POST">
                        <?php
                        foreach ($form_fields as $form_field_name => $form_field) {
                            $form_group_class = 'form-group';
                            $form_group_class .= $form_field['has_error'] == true ? ' has-error' : '';

                            $field_class = 'form-control';
                            $field_class .= $form_field['required'] == true ? ' wd_shop_required_field' : '';
                            switch ($form_field['type']) {
                                case 'select':
                                    ?>
                                    <div class="<?php echo $form_group_class; ?>">
                                        <label for="<?php echo $form_field['name']; ?>"
                                               class="col-md-4 control-label">
                                            <?php echo $form_field['label']; ?>:
                                            <?php if ($form_field['required'] == true) { ?>
                                                <span class="wd_star">*</span>
                                            <?php } ?>
                                        </label>

                                        <div class="col-md-8">
                                            <?php
                                            echo JHtml::_('select.genericlist', $form_field['options'], $form_field['name'], 'class="' . $field_class . '"', 'id', 'name', isset($user_data[$form_field['name']]) == true ? $user_data[$form_field['name']] : '');
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                default:
                                    ?>
                                        <div class="<?php echo $form_group_class; ?>">
                                            <label for="<?php echo $form_field['name']; ?>"
                                                   class="col-md-4 control-label">
                                                <?php echo $form_field['label']; ?>:
                                                <?php if ($form_field['required'] == true) { ?>
                                                    <span class="wd_star">*</span>
                                                <?php } ?>
                                            </label>

                                            <div class="col-md-8">
                                                <input type="<?php echo $form_field['type']; ?>"
                                                       name="<?php echo $form_field['name']; ?>"
                                                       id="<?php echo $form_field['name']; ?>"
                                                       class="<?php echo $field_class; ?>"
                                                       placeholder="<?php echo $form_field['placeholder']; ?>"
                                                       value="<?php echo isset($user_data[$form_field['name']]) == true ? $user_data[$form_field['name']] : ''; ?>">
                                            </div>
                                        </div>
                                    <?php
                                    break;
                            }
                        }
                        ?>
                    </form>

                    <!-- alert -->
                    <div class="wd_shop_alert_incorrect_data alert alert-danger hidden">
                        <p><?php echo WDFText::get('MSG_FILL_REQUIRED_FIELDS') ?></p>
                    </div>
                </div>

                <div class="panel-footer text-right">
                    <!-- back, update buttons -->
                    <div class="btn-group">
                        <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=useraccount&task=displayuseraccount'); ?>"
                           class="btn btn-default">
                            <?php echo WDFText::get('BTN_BACK'); ?>
                        </a>

                        <a class="btn btn-primary"
                           onclick="wdShop_onBtnUpdateUserDataClick(event, this); return false;">
                            <?php echo WDFText::get('BTN_UPDATE_DATA'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
