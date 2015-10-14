<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_script('js/framework/utils.js', true, true);

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$app = JFactory::getApplication();

$options = $this->options;

$form_fields = $this->form_fields;
$registration_data = $this->registration_data;


WDFDocument::set_title(WDFText::get('REGISTER'));
?>

<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="wd_shop_panel_user_data panel panel-default">
                <div class="panel-body">
                    <h3 class="wd_shop_header">
                        <?php echo WDFText::get('REGISTER'); ?>
                    </h3>

                    <!-- registeration form -->
                    <form name="wd_shop_form_register"
                          class="form-horizontal"
                          role="form"
                          action="<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=register'; ?>"
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
                                            echo JHtml::_('select.genericlist', $form_field['options'], $form_field['name'], 'class="' . $field_class . '"', 'id', 'name', isset($registration_data[$form_field['name']]) == true ? $registration_data[$form_field['name']] : '');
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
                                                       value="<?php echo isset($registration_data[$form_field['name']]) == true ? $registration_data[$form_field['name']] : ''; ?>">
                                            </div>
                                        </div>
                                    <?php
                                    break;
                            }
                        }
                        ?>

                        <?php
                        $use_captcha = $options->registration_captcha_use_captcha;
                        if ($use_captcha == true) {
                            $captcha_public_key = $options->registration_captcha_public_key;
                            $captcha_theme = $options->registration_captcha_theme;
                            ?>
                            <div class="wd_divider"></div>

                            <!-- recaptcha -->
                            <div class="form-group">
                                <label for="dynamic_recaptcha_1" class="col-md-4 control-label">
                                    <?php echo WDFText::get('CAPTCHA'); ?>:
                                    <span class="wd_star">*</span>
                                </label>

                                <div class="col-md-8">
                                    <div id="dynamic_recaptcha_1">
                                        <?php
                                        echo WDFRecaptchaHelper::generate_recaptcha($captcha_public_key, $captcha_theme);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <input type="hidden"
                               name="redirect_url"
                               value="<?php echo WDFInput::get('redirect_url', WDFUrl::get_referer_url()); ?>">
                    </form>

                    <!-- alert -->
                    <div class="wd_shop_alert_incorrect_data alert alert-danger hidden">
                        <p><?php echo WDFText::get('MSG_FILL_REQUIRED_FIELDS'); ?></p>
                    </div>
                </div>

                <div class="panel-footer text-right">
                    <!-- login/register buttons -->
                    <div class="btn-group">
                        <a href="<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=usermanagement&task=displaylogin'); ?>"
                           class="btn btn-default">
                            <?php echo WDFText::get('BTN_LOG_IN'); ?>
                        </a>

                        <a href="#"
                           class="btn btn-primary"
                           onclick="wdShop_onBtnRegisterClick(event, this); return false;">
                            <?php echo WDFText::get('BTN_REGISTER'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
