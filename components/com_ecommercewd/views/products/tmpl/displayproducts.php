    <?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;
$theme = $this->theme;

WDFDocument::set_title(WDFText::get('PRODUCTS'));

?>


<div class="wd_shop_tooltip_container"></div>
<div class="wd_shop_modal_tooltip_container"></div>
<?php
echo $this->loadTemplate('mainform');
echo $this->loadTemplate('layout_' . $theme->products_filters_position);
echo $this->loadTemplate('quickview');
?>

<script>
    var WD_SHOP_TEXT_ALREADY_ADDED_TO_CART = "<?php echo WDFText::get('MSG_PRODUCT_ALREADY_ADDED_TO_CART'); ?>";
    var WD_SHOP_TEXT_PLEASE_WAIT = "<?php echo WDFText::get('MSG_PLEASE_WAIT'); ?>";

	var wdShop_minicart = "<?php echo WDFUrl::get_site_url().'index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayminicart&tmpl=component'; ?>";
	var wdShop_minicart_js_path = "<?php echo WDFUrl::get_site_url().'modules/mod_ecommercewd_minicart/js/main.js'; ?>";
    var wdShop_filtersAutoUpdate = <?php echo $theme->products_filters_position == 1 ? 'false' : 'true'; ?>;
    var wdShop_redirectToCart = <?php echo $options->checkout_redirect_to_cart_after_adding_an_item == 1 ? 'true' : 'false'; ?>;

    var wdShop_urlDisplayProducts = "<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproducts'); ?>";
    var wdShop_urlAddToShoppingCart = "<?php echo WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=add'; ?>";
    var wdShop_urlDisplayShoppingCart = "<?php echo JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=shoppingcart&task=displayshoppingcart'); ?>";
	var option_redirect_to_cart_after_adding_an_item = "<?php echo $options->checkout_redirect_to_cart_after_adding_an_item;?>";	

</script>
