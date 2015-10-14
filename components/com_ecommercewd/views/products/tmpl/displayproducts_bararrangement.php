<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_bararrangement.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_bararrangement.js');


$arrangement_data = $this->arrangement_data;

$btnThumbsClassActive = $arrangement_data['arrangement'] == 'thumbs' ? 'active' : '';
$btnThumbsChecked = $arrangement_data['arrangement'] == 'thumbs' ? 'checked="checked"' : '';

$btnListClassActive = $arrangement_data['arrangement'] == 'list' ? 'active' : '';
$btnListChecked = $arrangement_data['arrangement'] == 'list' ? 'checked="checked"' : '';
?>

<div class="row">
    <div class="col-sm-12">
        <form name="wd_shop_form_arrangement" action="" method="POST">
            <div class="btn-group btn-group-sm" data-toggle="buttons">
                <!-- btn thumbs -->
                <label class="btn btn-default <?php echo $btnThumbsClassActive; ?>">
                    <input type="radio" name="arrangement" value="thumbs" <?php echo $btnThumbsChecked; ?>
                           onchange="wdShop_formArrangement_onArrangementChange(event, this);">
                    &nbsp;<span class="glyphicon glyphicon-th"></span>&nbsp;
                </label>

                <!-- btn list -->
                <label class="btn btn-default <?php echo $btnListClassActive; ?>">
                    <input type="radio" name="arrangement" value="list" <?php echo $btnListChecked; ?>
                           onchange="wdShop_formArrangement_onArrangementChange(event, this);">
                    &nbsp;<span class="glyphicon glyphicon-align-justify"></span>&nbsp;
                </label>
            </div>
        </form>
    </div>
</div>