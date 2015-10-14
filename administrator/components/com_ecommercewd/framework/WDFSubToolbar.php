<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class WDFSubToolbar {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static $items;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * add subtoolbar item.
     *
     * @param    string $text text of item.
     * @param    string $url url.
     * @param    string $icon icon class.
     * @param    boolean $is_active is item active.
     */
    public static function add_item($text = '', $url = '', $icon = '', $is_active = false) {
        $active_class = $is_active == true ? 'active' : '';
        $icon_class = $icon != '' ? 'sub_toolbar_icon_' . $icon : '';
        ob_start();
        ?>
        <li>
            <a class="<?php echo $active_class; ?>" href="<?php echo $url; ?>" title="<?php echo $text; ?>">
                <span class="sub_toolbar_icon <?php echo $icon_class; ?>"></span>

                <span class="sub_toolbar_text"><?php echo $text; ?></span>
            </a>
        </li>
        <?php

        $item = ob_get_clean();

        if (self::$items == null) {
            self::$items = array();
        }
        self::$items[] = $item;
    }
	
	/**
     * add browse tools link
	 */
	public static function add_browse_tools_link(){
	    ob_start();
        ?>
        <li class="ecommerce-wd-tools">
			<div class="ecommerce-wd-tools-text">Extend the functionality of your <br> online store with various Tools.</div>
            <a  href=" http://web-dorado.com/products/joomla-ecommerce/ecommerce-wd-tools.html" target="_blank">
            </a>
        </li>
        <?php

        $item = ob_get_clean();

        if (self::$items == null) {
            self::$items = array();
        }
        self::$items[] = $item;
	}

    /**
     * add subtoolbar divider.
     */
    public static function add_divider() {
        ob_start();
        ?>
        <li>
            <span class="sub_toolbar_divider"></span>
        </li>
        <?php

        $divider = ob_get_clean();

        if (self::$items == null) {
            self::$items = array();
        }
        self::$items[] = $divider;
    }

    /**
     * clears subtoolbar's elements.
     */
    public static function clear() {
        self::$items = array();
    }

    /**
     * get subToolbar.
     *
     * @param    boolean $clear clear items after get.
     *
     * @return    string    toolbar html string.
     */
    public static function get_sub_toolbar($clear = true) {
        WDFHelper::add_css('css/framework/sub_toolbar.css', true, true);

        ob_start();
        ?>
        <ul class="jf_sub_toolbar">
            <?php
            echo implode('', self::$items);
            ?>
        </ul>
        <?php
        $sub_toolbar = ob_get_clean();

        if ($clear == true) {
            self::clear();
        }

        return $sub_toolbar;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}