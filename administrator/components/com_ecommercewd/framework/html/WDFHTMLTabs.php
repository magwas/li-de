<?php

 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFHTMLTabs {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static $tabs_name;
    private static $start_tab;
    private static $on_active;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public static function startTabs($name, $start_tab = '', $on_active = '') {
        self::$tabs_name = $name;
        self::$start_tab = $start_tab;
        self::$on_active = $on_active;

        if (WDFHelper::is_j3() == true) {
            echo JHtml::_('bootstrap.startTabSet', self::$tabs_name, array('active' => $start_tab));
        } else {
            echo JHtml::_('tabs.start', $name, array('startOffset' => $start_tab, 'onActive' => 'onTabActivated_'. self::$tabs_name ));
        }
    }

    public static function startTab($tab_name, $tab_label) {
        if (WDFHelper::is_j3() == true) {
            echo JHtml::_('bootstrap.addTab', self::$tabs_name, $tab_name, $tab_label);			
        } else {
            echo JHtml::_('tabs.panel', $tab_label, $tab_name);
        }
    }

    public static function endTab() {
        if (WDFHelper::is_j3() == true) {
            echo JHtml::_('bootstrap.endTab');
        } else {
        }
    }

    public static function endTabs() {
        if (WDFHelper::is_j3() == true) {
            echo JHtml::_('bootstrap.endTabSet');
            ?>
            <script>
                jQuery(document).ready(function () {
                    // activate first tab if there is no active tab
                    var hasActiveTab = false
                    jQuery("#<?php echo self::$tabs_name; ?>Tabs li").each(function (event) {
                        if (jQuery(this).hasClass("active")) {
                            hasActiveTab = true;
                        }
                    });
                    if (hasActiveTab == false) {
                        var jq_firstTab = jQuery(jQuery("#<?php echo self::$tabs_name; ?>Tabs li a[data-toggle=tab]")[0]);
                        jq_firstTab.tab("show");
                    }

                    // on tab activate
                    jQuery("#<?php echo self::$tabs_name; ?>Tabs li a[data-toggle=tab]").on("click", function (event) {
                        var href = jQuery(this).attr("href");
                        var currentTabIndex = href.substr(1);
                        <?php echo self::$on_active; ?>(currentTabIndex);
                    });
                });
            </script>
        <?php
        } else {
            //echo JHtml::_('tabs.end');
            ?>
            <script>
                function onTabActivated_<?php echo self::$tabs_name; ?>(title, description) {
                    var currentTabIndex = jQuery("#<?php echo self::$tabs_name; ?> dt.tabs").index(jQuery(title));
                    <?php echo self::$on_active; ?>(currentTabIndex);
                    // default functionality
                    description.setStyle("display", "block");
                    title.addClass("open").removeClass("closed");

                }
            </script>
        <?php
        }
        self::$tabs_name = null;
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