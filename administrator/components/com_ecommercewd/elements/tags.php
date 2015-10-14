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

class JFormFieldTags extends JFormField
{
	protected $tags = 'tags';

	public function getInput()
	{
		ob_start();
		// add css and js		
		WDFHelper::add_script('js/view.js');
		WDFHelper::add_css('css/modules/main.css', true, true);
		$tags = $this->getTags($this->value);

		?>
			<div class="wdshop_mod_panel">
				<?php echo WDFHTML::jf_module_box('tag_box'); ?>
				<span id="buttons_container">
					<?php echo WDFHTML::jfbutton(WDFText::get_mod('BTN_ADD_TAGS','ecommercewd_featured_products'), '', '', 'onclick="onBtnAddTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
					<?php echo WDFHTML::jfbutton(WDFText::get_mod('BTN_REMOVE_ALL','ecommercewd_featured_products'), '', '', 'onclick="onBtnRemoveAllTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
				</span>
				<script> 
						var _tags = JSON.parse("<?php echo $tags ? $tags : "[]" ; ?>");
						var tag_name = "<?php echo $this->name;  ?>";
				
				</script>
				<input type="hidden" name="<?php echo $this->name;?>" value='<?php echo $tags;?>'  />
			</div>
		<?php
		$content=ob_get_contents();

        ob_end_clean();
        return $content;
	}
	
	private function getTags($tag_ids) 
	{
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);	
		$tag_ids = WDFJson::decode($tag_ids);
		if($tag_ids)
		{
			$where_query = array();	
			$query->clear();
			$query->select('id');
			$query->select('name');
			$query->from('#__ecommercewd_tags');

			foreach( $tag_ids as $tag_id )
				$where_query[] = "id = ".$tag_id;			
			$where_query = implode(' OR ',$where_query);	
			$query->where( $where_query );
		
			$db->setQuery($query);
			$tags = $db->loadObjectList();

			if ($db->getErrorNum()) {
				echo $db->getErrorMsg();
				return false;
			}

			return  addslashes(WDFJson::encode($tags, 256)) ;
		}
		else
			return false;
    }

}
?>