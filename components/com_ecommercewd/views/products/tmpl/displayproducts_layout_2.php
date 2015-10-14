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


$options = $this->options;

$arrangement_data = $this->arrangement_data;

$product_rows = $this->product_rows;

$show_filters = ($options->search_enable_search == 1) && (($options->filter_manufacturers == 1) || ($options->filter_price == 1) || ($options->filter_date_added == 1) || ($options->filter_minimum_rating == 1) || ($options->filter_tags == 1)) ? true : false;

$col_filters_class = $show_filters == true ? 'col-sm-3' : '';
$col_products_class = $show_filters == true ? 'col-sm-9' : 'col-sm-12';
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

    <div class="row">
        <!-- filters bars -->
        <?php
        if ($show_filters == true) {
            ?>
            <div class="<?php echo $col_filters_class; ?>">
                <div class="well">
                    <?php
                    echo $this->loadTemplate('barfilters');
                    ?>
                </div>
            </div>
        <?php
        }
        ?>

        <!-- search, arrangement, sort bars, products and pagination -->
        <div class="<?php echo $col_products_class; ?>">
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
