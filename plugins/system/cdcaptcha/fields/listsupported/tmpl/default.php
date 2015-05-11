<?php
/**
 * Core Design Captcha plugin for Joomla! 2.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla 
 * @subpackage	System
 * @category	Plugin
 * @version		2.5.x.2.0.6
 * @copyright	Copyright (C) 2007 - 2012 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
$extension_files = JFolder::files( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . DS . 'extension', '\.php$', true, true, array( 'cdcaptcha_pattern.php' ) );
if ( ! $extension_files ) return false;
sort( $extension_files );
?>
<div id="<?php echo $type; ?>">
<h4><?php echo JText::_( 'PLG_SYSTEM_CDCAPTCHA_FIELD_LISTSUPPORTED_HEADER' ); ?></h4>
	<ul>
		<?php foreach( $extension_files as $extension_file ): ?>
		<?php
	 	if (  ! JFile::exists( $extension_file ) ) continue;
	 	
	 	require_once $extension_file;
	 	
	 	$classname = JFile::stripExt( basename( $extension_file ) );
	 	
	 	$class = new $classname();
	 	
	 	if( ! isset( $class->name ) or ! $name = (string) $class->name) continue;
	 	if( ! isset( $class->version ) or ! $version = (string) $class->version) continue;
		?>
		<li><?php echo $name; ?> <?php echo $version; ?></li>
		<?php endforeach; ?>
	</ul>
</div>