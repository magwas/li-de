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

class JFormFieldCategories extends JFormField
{
	protected $categories = 'categories';

	public function getInput()
	{	
		ob_start();
		// add css and js		
		WDFHelper::add_script('js/view.js');
		
		WDFHelper::add_css('css/modules/main.css', true, true);
		$ids = $this->value ? $this->value : "[]";
		$categories = $this->getCategories($ids)  ;	
		
		
		?>
			<div class="wdshop_mod_panel">
				<?php echo WDFHTML::jf_module_box('category_box'); ?>
				<span id="buttons_container">
					<?php echo WDFHTML::jfbutton(WDFText::get_mod('BTN_ADD_CATEGORIES','ecommercewd_featured_products'), '', '', 'onclick="onBtnAddCategoriesClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
					<?php echo WDFHTML::jfbutton(WDFText::get_mod('BTN_REMOVE_ALL','ecommercewd_featured_products'), '', '', 'onclick="onBtnRemoveAllCategoriesClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
				</span>
				<script> 
						var _categories = JSON.parse("<?php echo $categories ? $categories : "[]" ; ?>");
						var category_name = "<?php echo $this->name;  ?>";
						var is_j3 = <?php echo (WDFHelper::is_j3()) ? 1 : 0 ;?>;
				</script>
				<input type="hidden" name="<?php echo $this->name;?>" value='<?php echo $categories;?>'  />
			</div>
		<?php
		
		WDFHelper::add_script('js/modules/main_featured_products.js');	
		$content=ob_get_contents();

        ob_end_clean();
        return $content;
	}
	
	private function getCategories($category_ids) 
	{
			
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);	
		$category_ids = WDFJson::decode($category_ids);
		
		if($category_ids)
		{
			$where_query = array();	
			$query->clear();
			$query->select('id');
			$query->select('name');
			$query->select('level');
			$query->select('parent_id');
			$query->from('#__ecommercewd_categories');

			foreach( $category_ids as $category_id )
				$where_query[] = "id = ".$category_id;			
			$where_query = implode(' OR ',$where_query);	
			$query->where( $where_query );

			$db->setQuery($query);
			$categories = $db->loadObjectList();

			if ($db->getErrorNum()) {
				echo $db->getErrorMsg();
				return false;
			}
			if(in_array (0, $category_ids))
			{
				$main_category =  new stdClass();
				$main_category->id = 0;
				$main_category->name = "Main";
				$main_category->level = 1;
				$main_category->parent_id = 0;				
				$categories[] = $main_category;
			}
			
			foreach($categories as $category)
				$category->tree = $this->find_parents($category->id);
		
			return  addslashes(WDFJson::encode($categories, 256)) ;
		}
		else
			return "[]";
    }
	
	private function find_parents($category_id , &$parents = array())
	{
		if($category_id != 0)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);			

			$query->clear();
			$query->select('T_PARENT_CATEGORIES.name');
			$query->select('T_PARENT_CATEGORIES.id');
			$query->from('#__ecommercewd_categories AS T_CATEGORIES');
			$query->leftJoin('#__ecommercewd_categories AS T_PARENT_CATEGORIES ON T_CATEGORIES.parent_id = T_PARENT_CATEGORIES.id');
			$query->where( 'T_CATEGORIES.id = ' . $category_id );
			
			$db->setQuery($query);
			$parent = $db->loadObject();
			
			if($parent->id != 0)
			{
				array_push($parents, $parent->name);
				$this->find_parents($parent->id, $parents);	
			}
		}
		return implode(' &#8594; ',array_reverse($parents));
		
	}


}
?>