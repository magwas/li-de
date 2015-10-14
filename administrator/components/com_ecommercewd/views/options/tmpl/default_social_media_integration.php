<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


$options = $this->options;
$initial_values = $options['initial_values'];

$enable_fb_like_btn_checked = $initial_values['social_media_integration_enable_fb_like_btn'] == 1 ? 'checked="checked"' : '';
$enable_twitter_tweet_btn_checked = $initial_values['social_media_integration_enable_twitter_tweet_btn'] == 1 ? 'checked="checked"' : '';
$enable_g_plus_btn_checked = $initial_values['social_media_integration_enable_g_plus_btn'] == 1 ? 'checked="checked"' : '';

$list_fb_color_scheme = array();
$list_fb_color_scheme[] = (object)array('value' => 'light', 'text' => WDFText::get('LIGHT'));
$list_fb_color_scheme[] = (object)array('value' => 'dark', 'text' => WDFText::get('DARK'));
?>

<fieldset>
    <legend><?php echo WDFText::get('SHARE_BUTTONS'); ?></legend>

    <table class="adminlist table">
        <tbody>
        <!-- share buttons -->
        <tr>
            <td class="col_key">
                <label>
                    <?php echo WDFText::get('ENABLE_BUTTONS'); ?>:
                </label>
            </td>

            <td class="col_value">
                <label class="wd_clear">
                    <input type="checkbox" name="social_media_integration_enable_fb_like_btn"
                           value="1" <?php echo $enable_fb_like_btn_checked; ?>>
                    <img class="img_social_btn"
                         src="<?php echo WDFUrl::get_com_admin_url() . '/images/options/fb_like.png' ?>">
                </label>

                <label class="wd_clear">
                    <input type="checkbox" name="social_media_integration_enable_twitter_tweet_btn"
                           value="1" <?php echo $enable_twitter_tweet_btn_checked; ?>>
                    <img class="img_social_btn"
                         src="<?php echo WDFUrl::get_com_admin_url() . '/images/options/twitter_tweet.png' ?>">
                </label>

                <label class="wd_clear">
                    <input type="checkbox" name="social_media_integration_enable_g_plus_btn"
                           value="1" <?php echo $enable_g_plus_btn_checked; ?>>
                    <img class="img_social_btn"
                         src="<?php echo WDFUrl::get_com_admin_url() . '/images/options/g_plus.png' ?>">
                </label>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<fieldset>
    <legend><?php echo WDFText::get('FACEBOOK_COMMENTS'); ?></legend>

    <table class="adminlist table">
        <tbody>
        <!-- use fb comments -->
        <tr>
            <td class="col_key">
                <label for="social_media_integration_use_fb_comments">
                    <?php echo WDFText::get('USE_FACEBOOK_COMMENTS'); ?>:
                </label>
            </td>

            <td class="col_value">
                <?php echo JHTML::_('select.booleanlist', 'social_media_integration_use_fb_comments', '', $initial_values['social_media_integration_use_fb_comments'], WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>

        <!-- color scheme -->
        <tr>
            <td class="col_key">
                <label for="social_media_integration_fb_color_scheme">
                    <?php echo WDFText::get('COLOR_SCHEME'); ?>:
                </label>
            </td>

            <td class="col_value">
                <?php echo JHTML::_('select.radiolist', $list_fb_color_scheme, 'social_media_integration_fb_color_scheme', '', 'value', 'text', $initial_values['social_media_integration_fb_color_scheme']); ?>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>

<table class="adminlist table">
    <!-- ctrls -->
    <tbody>
    <tr>
        <td class="btns_container" colspan="2">
            <?php
            echo WDFHTML::jfbutton(WDFText::get('BTN_RESET'), '', '', 'onclick="onBtnResetClick(event, this, \'social_media_integration\');"');
            echo WDFHTML::jfbutton(WDFText::get('BTN_LOAD_DEFAULT_VALUES'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'social_media_integration\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>