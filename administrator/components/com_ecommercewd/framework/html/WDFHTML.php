<?php

 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class WDFHTML {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    const BUTTON_SIZE_SMALL = 'jfbutton_size_small';
    const BUTTON_SIZE_MEDIUM = 'jfbutton_size_medium';
    const BUTTON_SIZE_BIG = 'jfbutton_size_big';

    const BUTTON_COLOR_BLUE = 'jfbutton_color_blue';
    const BUTTON_COLOR_GREEN = 'jfbutton_color_green';
    const BUTTON_COLOR_RED = 'jfbutton_color_red';
    const BUTTON_COLOR_WHITE = 'jfbutton_color_white';
    const BUTTON_COLOR_YELLOW = 'jfbutton_color_yellow';

    const BUTTON_ICON_POS_LEFT = 'jfbutton_icon_pos_left';
    const BUTTON_ICON_POS_RIGHT = 'jfbutton_icon_pos_right';


    const BUTTON_INLINE_TYPE_ADD = 'add';
    const BUTTON_INLINE_TYPE_REMOVE = 'remove';
    const BUTTON_INLINE_TYPE_MOVE_UP = 'move_up';
    const BUTTON_INLINE_TYPE_MOVE_DOWN = 'move_down';
    const BUTTON_INLINE_TYPE_GOTO = 'goto';


    const WD_BS_RATER_STAR_TYPE_STAR = "star";
    const WD_BS_RATER_STAR_TYPE_STAR_EMPTY = "star-empty";


    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    public static function jfbutton($text = '', $id = '', $class = '', $attributes = '', $color = self::BUTTON_COLOR_BLUE, $size = self::BUTTON_SIZE_MEDIUM, $icon = '', $icon_pos = self::BUTTON_ICON_POS_LEFT) {
        WDFHelper::add_css('css/framework/buttons.css', true, true);
        $attr_id = $id == '' ? '' : ' id="' . $id . '" ';
        $attr_class = ' class="jfbutton ' . $color . ' ' . $size . ' ' . $class . '"';
        $text = $text == '' ? '' : '<span>' . $text . '</span>';
        $img = $icon == '' ? '' : '<span><img src="' . $icon . '" /></span>';
        $separator = ($text != '') && ($img != '') ? '&nbsp;' : '';
        $content = $icon_pos == self::BUTTON_ICON_POS_LEFT ? $img . $separator . $text : $text . $separator . $img;
        $element = '<a ' . $attr_id . $attr_class . ' ' . $attributes . '>' . $content . '</a>';
        return WDFTextUtils::remove_new_line_chars($element);
    }

    public static function jfbutton_inline($text, $type, $id = '', $class = '', $attributes = '', $icon_pos = self::BUTTON_ICON_POS_LEFT) {
        WDFHelper::add_css('css/framework/buttons.css', true, true);
        $text = $text == '' ? '' : '<span>' . $text . '</span>';
        $icon = '<span class="jfbutton_inline_icon jfbutton_inline_icon_' . $type . '"></span>';
        $html = $icon_pos == self::BUTTON_ICON_POS_LEFT ? $icon . '&nbsp;' . $text : $text . '&nbsp;' . $icon;
        $button = '<a id="' . $id . '" class="jfbutton_inline ' . $type . ' ' . $class . '" ' . $attributes . '>' . $html . '</a>';
        return $button;
    }

    public static function jf_color_picker($id = '', $class = '', $initial_color = '#000000', $pickerShowHandler = '', $pickerHideHandler = '', $colorChangeHandler = '') {
        WDFHelper::add_css('css/framework/color_picker.css', true, true);
        WDFHelper::add_script('js/framework/color_picker.js', true, true, true);

        $class = explode(' ', $class);
        $class[] = 'wd_shop_color_picker';

        ob_start();
        ?>
        <div id="<?php echo $id; ?>" class="<?php echo implode(' ', $class) ?>"
             pickerShowHandler="<?php echo $pickerShowHandler; ?>"
             pickerHideHandler="<?php echo $pickerHideHandler; ?>"
             colorChangeHandler="<?php echo $colorChangeHandler; ?>">
            <span class="wd_shop_color_picker_color_box"></span>
            <input type="text"
                   name="<?php echo $id; ?>"
                   class="wd_shop_color_picker_input"
                   value="<?php echo $initial_color; ?>">
        </div>
        <?php
        $color_picker = WDFTextUtils::remove_html_spaces(ob_get_clean());
        return $color_picker;
    }

    public static function jf_thumb_box($id, $is_multi = false, $uploads_tab_index = 'images') {
        WDFHelper::add_css('css/framework/thumb_box.css', true, true);
        WDFHelper::add_script('js/framework/thumb_box.js', true, true);

        $class = $is_multi ? 'jf_thumb_box jf_thumb_box_multi' : 'jf_thumb_box';
		switch($uploads_tab_index){
			case 'images':
				$button_text = WDFText::get($is_multi == true ? 'BTN_ADD_IMAGES' : 'BTN_ADD_IMAGE');
				break;
			case 'videos':
				$button_text = WDFText::get('BTN_ADD_VIDEOS');
				break;
			case 'downloadable_files':
				$button_text = WDFText::get('BTN_ADD_FILES');
				break;							
		}
	
        ob_start(); ?>
        <div id="<?php echo $id; ?>" class="<?php echo $class ?>">
			<?php if($uploads_tab_index == 'images'){ ?>
				<div class="jf_thumb_box_items_container jf_thumb_box_items_container_iamges">
					<span class="jf_thumb_box_item template">				
						<img class="jf_thumb_box_item_image" src="" alt="<?php echo WDFText::get('CHANGE_THUMB'); ?>"/>
						<?php echo self::jfbutton_inline('', self::BUTTON_INLINE_TYPE_REMOVE, '', 'jf_thumb_box_item_btn_remove'); ?>
					</span>
				</div>
			<?php 
			}			
			elseif($uploads_tab_index == 'videos'){
			?>
				<div class="jf_thumb_box_items_container jf_thumb_box_items_container_ordering">
					<table class="jf_thumb_box_item template" width="50%">
						<tbody >
							<tr>
								<td width="1%">
									<i class="hasTooltip icon-drag" title="" data-original-title=""></i>
								</td>
								<td>
									<span class="jf_thumb_box_item_video" >	</span>								
								</td>
								<td width="1%">
									<?php echo self::jfbutton_inline('', self::BUTTON_INLINE_TYPE_REMOVE, '', 'jf_thumb_box_item_btn_remove'); ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>			
			<?php
			}
            echo self::jfbutton($button_text, '', 'jf_thumb_box_btn_add jf_thumb_box_btn_add_'.$uploads_tab_index, 'data-type="'.$uploads_tab_index.'"', self::BUTTON_COLOR_BLUE, self::BUTTON_SIZE_SMALL); ?>		
		</div>
		
        <script>
			var _jfThumbBoxCurrentObj;
			var _jfThumbBoxCurrentIndex;
			var _jfThumbBoxCurrentReplaceItem;
			var url_root = "<?php echo JURI::root() ; ?>";
			
			function jfThumbBoxOpenFileManager(thumbBoxObj, index, replaceThumb, fmTabIndex) {
				_jfThumbBoxCurrentObj = thumbBoxObj;
				_jfThumbBoxCurrentIndex = index == undefined ? _jfThumbBoxCurrentObj.getUploadUrls().length : index;

				_jfThumbBoxCurrentReplaceItem = replaceThumb == true ? true : false;
				openFileManager("gif,jpeg,JPG,png,bmp,mp4,flv,webm,ogg,mp3,wav,pdf,zip,rar", "jfThumbBoxAddUploadsHandler", fmTabIndex);
				
			}

			function jfThumbBoxAddUploadsHandler(uploads) {
			
				if (_jfThumbBoxCurrentObj == null) {
					return;
				}

				if (_jfThumbBoxCurrentReplaceItem == true) {
					_jfThumbBoxCurrentObj.removeThumbAt(_jfThumbBoxCurrentIndex);
				}
			
				uploads.reverse();
				for (var i = 0; i < uploads.length; i++) {	
					_jfThumbBoxCurrentObj.addThumbAt(url_root+uploads[i]['reliative_url'], _jfThumbBoxCurrentIndex, uploads[i]['fmTabIndexUnchanged']);
				}
			}
			
			
        </script>
        <?php
        $thumb_box = WDFTextUtils::remove_html_spaces(ob_get_clean());
        return $thumb_box;
    }

    public static function jf_tag_box($id, $width = '', $height = '') {
        WDFHelper::add_css('css/framework/tag_box.css', true, true);
        WDFHelper::add_script('js/framework/tag_box.js', true, true);

        $width = is_numeric($width) == true ? $width . 'px' : $width;
        $height = is_numeric($height) == true ? $height . 'px' : $height;
        $style = ($width == 0) && ($height == 0) ? '' : 'style="width: ' . $width . '; height: ' . $height . ';"';
        ob_start();
        ?>
        <div id="<?php echo $id; ?>" class="jf_tag_box" <?php echo $style ?>>
            <span class="jf_tag_box_item template">
                <span class="jf_tag_box_item_name"></span>
                <span class="jf_tag_box_item_divider">&nbsp;</span>
                <span class="jf_tag_box_item_btn">&nbsp;</span>
            </span>
        </div>
        <?php
        $tag_box = WDFTextUtils::remove_html_spaces(ob_get_clean());
        return $tag_box;
    }

    public static function jf_bs_rater($id, $class, $attributes, $initial_rating, $is_active, $rating_url, $msg, $tooltips_disabled = false, $stars_count = 5, $star_size = 20, $star_type = self::WD_BS_RATER_STAR_TYPE_STAR, $star_color = '#ffcc33', $star_bg_color = '#dadada', $module = "") {   
	   // css and js
        WDFHelper::add_css('css/framework/star_rater.css', true, false,true);
        WDFHelper::add_script('js/framework/star_rater.js', true, false,true,true);		
        $classes = explode(' ', $class);
        $classes[] = 'wd_bs_rater';
        if ($is_active == true) {
            $classes[] = 'active';
        }

        $star_bg_styles = array();
        $star_bg_styles[] = 'font-size: ' . $star_size . 'px';
        $star_bg_styles[] = 'background-color: ' . self::adjust_brightness($star_bg_color, -50);
        $star_bg_styles[] = 'text-shadow: 0px 1px 0px ' . $star_bg_color;
        $star_bg_styles[] = 'color: ' . $star_bg_color . '\9';

        $star_styles = array();
        $star_styles[] = 'font-size: ' . $star_size . 'px';
        $star_styles[] = 'color: ' . $star_color;
        $star_styles[] = 'text-shadow: 0px 1px 0px ' . self::adjust_brightness($star_color, -50);

        $star_hitter_styles = array();
        $star_hitter_styles[] = 'font-size: ' . $star_size . 'px';

        ob_start();
	
        ?>
        <div id="<?php echo $id; ?>"
             class="<?php echo implode(' ', $classes); ?>"
             rating="<?php echo $initial_rating ? $initial_rating : ''; ?>"
             ratingurl="<?php echo $rating_url; ?>"
             msg="<?php echo $msg; ?>"
             tooltipsdisabled="<?php echo $tooltips_disabled == true ? 'true' : 'false'; ?>"
            <?php echo $attributes; ?>>
            <ul class="wd_bs_rater_stars_list">
                <?php
                for ($i = 0; $i < $stars_count; $i++) {
                    ?>
                    <li>
                        <span class="wd_star_background glyphicon glyphicon-<?php echo $star_type; ?> "
                              style="<?php echo implode(';', $star_bg_styles); ?>; position: absolute; background-color: transparent\0/;"></span>
                        <span class="wd_star_color glyphicon glyphicon-<?php echo $star_type; ?> "
                              style="<?php echo implode(';', $star_styles); ?>; position: absolute"></span>
                        <span class="wd_star_hitter glyphicon glyphicon-<?php echo $star_type; ?> "
                              style="<?php echo implode(';', $star_hitter_styles); ?>; position: relative; visibility: hidden"></span>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <script>		
            var WD_TEXT_RATING = "<?php echo ( $module == "" ) ?  WDFText::get('SR_RATING') :  WDFText::get_mod('SR_RATING',$module); ?>:"
            var WD_TEXT_NOT_RATED = "<?php echo ( $module == "" ) ?  WDFText::get('SR_NOT_YET_RATED') : WDFText::get_mod('SR_NOT_YET_RATED',$module); ?>"
            var WD_TEXT_RATE = "<?php echo ( $module == "" ) ?  WDFText::get('SR_RATE') : WDFText::get_mod('SR_RATE',$module); ?>"
            var WD_TEXT_PLEASE_WAIT = "<?php echo( $module == "" ) ?  WDFText::get('SR_PLEASE_WAIT') : WDFText::get_mod('SR_PLEASE_WAIT',$module); ?>"
            var WD_TEXT_FAILED_TO_RATE = "<?php echo ( $module == "" ) ?  WDFText::get('SR_FAILED_TO_RATE') : WDFText::get_mod('SR_FAILED_TO_RATE',$module);  ?>"
        
		</script>
        <?php
        $star_rater = WDFTextUtils::remove_html_spaces(ob_get_clean());

        return $star_rater;
    }

    public static function jf_tree_generator($id, $width = '', $height = '') {
        WDFHelper::add_css('css/framework/tree_generator.css');
        WDFHelper::add_script('js/framework/tree_generator.js');
        $width = is_numeric($width) == true ? $width . 'px' : $width;
        $height = is_numeric($height) == true ? $height . 'px' : $height;
        $style = ($width == 0) && ($height == 0) ? '' : 'style="width: ' . $width . '; height: ' . $height . ';"';
        ob_start(); ?>
        <div id="<?php echo $id; ?>" class="jf_tree_generator" <?php echo $style ?>>
            <div class="jf_tree_generator_item template">
                <span class="jf_tree_generator_item_head">
                    <span class="jf_tree_generator_item_head_btn jf_tree_generator_item_head_btn_open">&nbsp;</span>
                    <span class="jf_tree_generator_item_head_btn jf_tree_generator_item_head_btn_close">&nbsp;</span>
                    <span class="jf_tree_generator_item_head_icon_empty">&nbsp;</span>
                    <span class="jf_tree_generator_item_head_divider">&nbsp;</span>
                    <span class="jf_tree_generator_item_head_name"></span>
                </span>

                <div class="jf_tree_generator_item_children_container">
                </div>
            </div>
        </div>
        <?php
        $tree_generator = WDFTextUtils::remove_html_spaces(ob_get_clean());
        return $tree_generator;
    }

    public static function icon_boolean_inactive($state) {
        if (WDFHelper::is_j3() == true) {
            $icon = '<i class="icon-' . ($state == 1 ? 'publish' : 'unpublish') . '"></i>';
        } else {
            $img = $state == 1 ? 'tick.png' : 'publish_x.png';
            $alt = $state == 1 ? WDFText::get('PUBLISHED') : WDFText::get('UNPUBLISHED');

            $icon = '<img src="templates/bluestork/images/admin/' . $img . '" title="' . $alt . '" />';
        }
        return $icon;
    }

	public static function jf_show_image($images, $title = ""){
		$images = WDFJson::decode($images);
		$image = "";
		if( $images != array()){		
			$image = '<img src="'.JURI::root().$images[0].'" title="'.$title.'" alt="'.$title.'" width="50px"/>';
		}
		else{
			$image='<div class="no_image">
						<span class="glyphicon glyphicon-picture" title="'.$title.'"></span>
						<br>
						<span>'. WDFText::get('NO_IMAGE').'</span>
					</div>';	
		}
		
		return $image;
	}
	
	public static function jf_module_box( $id ) {
	
        WDFHelper::add_css('css/framework/module_box.css', true, true);
        WDFHelper::add_script('js/framework/module_box.js', true, true);		
		JHTML::_('behavior.modal');
        ob_start();
        ?>
		 <script>
            jQuery.noConflict();
        </script>
        <div id="<?php echo $id; ?>" class="jf_module_box sortable" >
            <span class="jf_module_box_item template">				
                <span class="jf_module_box_item_name"></span>
                <span class="jf_module_box_item_btn">&nbsp;</span>
                <span class="jf_module_box_item_id"></span>
            </span>
			<span class="jf_module_box_item_all"></span>
        </div>
        <?php
        $module_box = WDFTextUtils::remove_html_spaces(ob_get_clean());
        return $module_box;
    }
	
	public static function id($rowNum, $recId, $checked, $checkedOut = false, $name = 'cid', $labelName = ''  )
	{
		if ($checkedOut)
			return '';

		else{
			$ch = $checked ? "checked='checked'" : "";
			if($labelName != ''){
			return '<label for="cb' . $rowNum . '"><input type="checkbox" id="cb' . $rowNum . '" name="' . $name . '[]" value="' . $recId
				. '" onclick="Joomla.isChecked(this.checked);" title="' . JText::sprintf($recId) . '" '.$ch.' /> '.$labelName.'</label>';
			}
			else{
				return '<input type="checkbox" id="cb' . $rowNum . '" name="' . $name . '[]" value="' . $recId
				. '" onclick="Joomla.isChecked(this.checked);" title="' . JText::sprintf($recId) . '" '.$ch.' />';				
			}
		}
	}
	public static function get_hidden_fields($array)
    {      
        $string = "";
        foreach ($array as $key => $value) {
            if ($value) {
                $string .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
            }
        }
        return $string;
    }
	
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static function adjust_brightness($hex, $steps) {
        // steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // format the hex color string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }

        // get decimal values
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // adjust number of steps and keep it inside 0 to 255
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

        return '#' . $r_hex . $g_hex . $b_hex;
    }
	



    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}