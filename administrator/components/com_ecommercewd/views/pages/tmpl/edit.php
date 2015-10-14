<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

// css
WDFHelper::add_css('css/layout_' . $this->_layout . '.css');
WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
// js
WDFHelper::add_script('js/view.js');
WDFHelper::add_script('js/layout_' . $this->_layout . '.js');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$row = $this->row;
JRequest::setVar( 'hidemainmenu', 1 );
?>

<form name="adminForm" id="adminForm" action="" method="post">
    <table class="adminlist table">
        <tbody>
        <!-- type -->
        <tr>
            <?php
            $is_artickle_0_checked = $row->is_article == 0 ? 'checked="checked"' : '';
            $is_artickle_1_checked = $row->is_article == 1 ? 'checked="checked"' : '';
            ?>
            <td class="col_key">
                <label for="title"><?php echo WDFText::get('PAGE_TYPE'); ?>:</label>
            </td>
            <td class="col_value">
                <label>
                    <input type="radio"
                           name="is_article"
                           value="0"
                        <?php echo $is_artickle_0_checked; ?>
                           onclick="onRadioCustomTextClick(event, this);"/>
                    <?php echo WDFText::get('CUSTOM_TEXT'); ?>
                </label>
                <br/>
                <label>
                    <input type="radio"
                           name="is_article"
                           value="1"
                        <?php echo $is_artickle_0_checked; ?>
                           onclick="onRadioJoomlaArticleClick(event, this);"/>
                    <?php echo WDFText::get('JOOMLA_ARTICLE'); ?>
                </label>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="adminlist table">
        <!-- custom text -->
        <tbody id="custom_text_container">
        <!--Title-->
        <tr>
            <td class="col_key">
                <label for="title"><?php echo WDFText::get('TITLE'); ?>:</label>
                <span class="star">*</span>
            </td>
            <td class="col_value">
                <input type="text"
                       name="title"
                       id="title"
                       class="required_field"
                       value="<?php echo $row->title; ?>"
                       onKeyPress="return disableEnterKey(event);"/>
            </td>
        </tr>

        <!-- text -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('TEXT'); ?>:</label>
            </td>
            <td class="col_value">
                <?php
                $editor = JFactory::getEditor();
                echo $editor->display('text', $row->text, '500px', '100px', 20, 20);
                ?>
            </td>
        </tr>
        </tbody>

        <!-- joomla article -->
        <tbody id="joomla_article_container">
        <tr>
            <td class="col_key">
                <label>
                    <?php echo WDFText::get('ARTICLE'); ?>:
                    <span class="star">*</span>
                </label>
            </td>
            <td class="col_value">
                <input type="text" name="article_title" value="<?php echo $row->article_title; ?>" disabled="disabled">
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveArticleClick(event, this);"'); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_SELECT'), '', '', 'onclick="onBtnSelectArticleClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
                <?php echo WDFHTML::jfbutton(WDFText::get('BTN_MANAGE'), '', '', 'href="index.php?option=com_content" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                <input type="hidden"
                       name="article_id"
                       id="article_id"
                       value="<?php echo $row->article_id; ?>"/>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="adminlist table">
        <!-- use for all products -->
        <tbody>
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('USE_FOR_ALL_PRODUCTS'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.booleanlist', 'use_for_all_products', '', $row->use_for_all_products, WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>

        <!-- published -->
        <tr>
            <td class="col_key">
                <label><?php echo WDFText::get('PUBLISHED'); ?>:</label>
            </td>
            <td class="col_value">
                <?php echo JHTML::_('select.booleanlist', 'published', '', $row->published, WDFText::get('YES'), WDFText::get('NO')); ?>
            </td>
        </tr>
        </tbody>
    </table>


    <input type="hidden" name="option" value=com_<?php echo WDFHelper::get_com_name(); ?>"/>
    <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>
