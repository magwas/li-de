<?php
 
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die( 'Restricted access' );
if(!defined('DS')) 
{
	define('DS',DIRECTORY_SEPARATOR);
}

//Prepare WD framework
require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_ecommercewd' . DS . 'framework' . DS . 'WDFHelper.php';
WDFHelper::init('ecommercewd');

class JFormFieldProducts extends JFormField
{
	protected $products = 'products';

	public function getInput()
	{
		ob_start();
		// add css and js		
		WDFHelper::add_script('js/view.js');
		WDFHelper::add_script('js/jquery-ui-1.10.3.js');
		WDFHelper::add_css('css/modules/main.css', true, true);
		$products = $this->getProducts($this->value);
		
		?>
			<div class="wdshop_mod_panel">
				<?php echo WDFHTML::jf_module_box('product_box'); ?>
				<span id="buttons_container">
					<?php echo WDFHTML::jfbutton(WDFText::get_mod('BTN_ADD_PRODUCTS','ecommercewd_featured_products'), '', '', 'onclick="onBtnAddProductsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
					<?php echo WDFHTML::jfbutton(WDFText::get_mod('BTN_REMOVE_ALL','ecommercewd_featured_products'), '', '', 'onclick="onBtnRemoveAllProductsClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
				</span>
				<script> 
						var _products = JSON.parse("<?php echo $products ? $products : "[]" ; ?>");
						var product_name = "<?php echo $this->name;  ?>";
						
				</script>
				<input type="hidden" name="<?php echo $this->name;?>" value='<?php echo $products;?>'  />				
			</div>
		<?php
		$content=ob_get_contents();

        ob_end_clean();
        return $content;
	}
	
	private function getProducts($product_ids) 
	{
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);	
		$product_ids = WDFJson::decode($product_ids);
		$products = array();
		if($product_ids)
		{
			foreach( $product_ids as $product_id )
			{
				$where_query = array();	
				$query->clear();
				$query->select('id');
				$query->select('name');
				$query->from('#__ecommercewd_products');
				$query->where( "id = ".$product_id );

				$db->setQuery($query);
				$product = $db->loadObject();

				if ($db->getErrorNum()) {
					echo $db->getErrorMsg();
					return false;
				}
				$products[] = $product;
			}

			return  addslashes(WDFJson::encode($products, 256)) ;
		}
		else
			return false;
    }

}
?>