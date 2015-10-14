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


$error = $this->error;


WDFDocument::set_title(WDFText::get('ERROR'));
?>

<div class="container">
    <div class="alert alert-danger">
        <h2 class="wd_shop_header text-center">
            <?php echo $error->header; ?>
        </h2>

        <p class="text-center">
            <?php echo $error->msg; ?>
        </p>
    </div>
</div>