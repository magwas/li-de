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

class JFormFieldType extends JFormField
{
	protected $type = 'type';

	public function getInput()
	{
		ob_start();
		if(!WDFHelper::is_j3())
			WDFHelper::add_script('js/jquery-1.10.2.min.js');	
		$types = array(
				1 => "-Select-",
				2 => "Tags",
				3 => "Categories" ,
				4 => "Products" 
		);
		?>
		<span id="WDelementForParent"></span>
		<script> var _type = <?php echo $this->value ? $this->value : 1;?>; </script>

		<?php
			
		echo JHTML::_('select.genericlist', $types, $this->name, 'class="searchable" onchange="SelectType();"', '', '', $this->value);

		$content=ob_get_contents();

        ob_end_clean();
        return $content;
	}

}
?>