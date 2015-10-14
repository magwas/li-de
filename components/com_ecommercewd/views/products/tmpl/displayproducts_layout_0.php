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


$arrangement_data = $this->arrangement_data;

$product_rows = $this->product_rows;
?>

<div class="container">
    <!-- user bar -->
    <div class="row">
        <div class="col-sm-12">
            <?php
            echo $this->loadTemplate('bartop');
            ?>
        </div>
    </div>

    <!-- search, arrangement and sort bars -->
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <?php
                echo $this->loadTemplate('barsearch');
                ?>

                <div class="row">
                    <div class="col-sm-8 hidden-xs">
                        <?php
                        echo $this->loadTemplate('bararrangement');
                        ?>
                    </div>

                    <div class="col-sm-4 col-xs-12 pull-right">
                        <?php
                        echo $this->loadTemplate('barsort');
                        ?>
                    </div>
                </div>
            </div>

            <div class="wd_divider"></div>

            <?php
            if (empty($product_rows) == false) {
                echo $this->loadTemplate('arrangement' . $arrangement_data['arrangement']);
            } else {
                echo $this->loadTemplate('noresults');
            }
            ?>

            <div class="wd_divider"></div>

            <?php
            echo $this->loadTemplate('barpagination');
            ?>
        </div>
    </div>
</div>