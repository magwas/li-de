<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$lists = $this->lists;
$list_captcha_themes = $lists['captcha_themes'];

$options = $this->options;
$initial_values = $options['initial_values'];
?>

<fieldset>
    <legend>
        <?php echo WDFText::get('REGISTRATION_EMAIL'); ?>
    </legend>

    <table class="adminlist table">
        <!-- administrator email -->
        <tbody>
        <tr>
            <td class="col_key">
                <label for="registration_administrator_email">
                    <?php echo WDFText::get('ADMINISTRATOR_EMAIL'); ?>:
                </label>
            </td>

            <td class="col_value">
                <input type="text"
                       name="registration_administrator_email"
                       id="registration_administrator_email"
                       value="<?php echo $initial_values['registration_administrator_email']; ?>">
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- captcha -->
<fieldset>
    <legend>
        <?php echo WDFText::get('RECAPTCHA'); ?>
    </legend>

    <table class="adminlist table">
        <tbody>
        <!-- use captcha -->
        <tr>
            <td class="col_key">
                <label for="registration_captcha_use_captcha">
                    <?php echo WDFText::get('USE_CAPTCHA'); ?>:
                </label>
            </td>

            <td class="col_value">
                <?php echo JHTML::_('select.booleanlist', 'registration_captcha_use_captcha', '', $initial_values['registration_captcha_use_captcha'], WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>

        <!-- public key -->
        <tr>
            <td class="col_key">
                <label for="registration_captcha_public_key">
                    <?php echo WDFText::get('PUBLIC_KEY'); ?>:
                </label>
            </td>

            <td class="col_value">
                <input type="text"
                       name="registration_captcha_public_key"
                       id="registration_captcha_public_key"
                       value="<?php echo $initial_values['registration_captcha_public_key']; ?>">
            </td>
        </tr>

        <!-- private key -->
        <tr>
            <td class="col_key">
                <label for="registration_captcha_private_key">
                    <?php echo WDFText::get('PRIVATE_KEY'); ?>:
                </label>
            </td>

            <td class="col_value">
                <input type="text"
                       name="registration_captcha_private_key"
                       id="registration_captcha_private_key"
                       value="<?php echo $initial_values['registration_captcha_private_key']; ?>">
            </td>
        </tr>

        <!-- theme -->
        <tr>
            <td class="col_key">
                <label>
                    <?php echo WDFText::get('THEME'); ?>:
                </label>
            </td>

            <td class="col_value">
                <?php echo JHTML::_('select.genericlist', $list_captcha_themes, 'registration_captcha_theme', '', 'value', 'text', $initial_values['registration_captcha_theme']); ?>
            </td>
        </tr>

        <!-- reccaptcha site -->
        <tr>
            <td colspan="2">
                <a href="https://www.google.com/recaptcha/admin#list"
                   target="_blank"><?php echo WDFText::get('GET_RECAPTCHA_KEY') ?></a>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<!-- ctrls -->
<table class="adminlist table">
    <tbody>
    <tr>
        <td class="btns_container">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'registration\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'registration\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>
