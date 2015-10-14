<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_noresults.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_noresults.js');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-info">
            <?php echo WDFText::get('MSG_NO_RESULTS') ?>
        </div>
    </div>
</div>