<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


header("Content-type: text/css");

echo $this->loadTemplate('global');
echo $this->loadTemplate('headings');
echo $this->loadTemplate('input');
echo $this->loadTemplate('buttons');
echo $this->loadTemplate('divider');
echo $this->loadTemplate('navbar');
echo $this->loadTemplate('modal');
echo $this->loadTemplate('paneluserdata');
echo $this->loadTemplate('panelproduct');
echo $this->loadTemplate('well');
echo $this->loadTemplate('label');
echo $this->loadTemplate('alert');
echo $this->loadTemplate('breadcrumb');
echo $this->loadTemplate('pills');
echo $this->loadTemplate('tab');
echo $this->loadTemplate('pagination');
echo $this->loadTemplate('pager');
echo $this->loadTemplate('product');