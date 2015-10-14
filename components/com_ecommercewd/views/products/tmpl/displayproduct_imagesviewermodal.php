<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '_imagesviewermodal.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '_imagesviewermodal.js');


$product_row = $this->product_row;

$images = WDFJson::decode($product_row->images);

if ($product_row->image != '') {
    $el_product_image = '<img class="wd_shop_product_main_image" src="' . WDFHelper::get_image_original_url($product_row->image) . '">';
} else {
    $el_product_image = '
        <div class="wd_shop_product_no_image">
            <span class="glyphicon glyphicon-picture"></span>
            <br>
            <span>' . WDFText::get('NO_IMAGE') . '</span>
        </div>
        ';
}
?>

<div class="wd_shop_product_images_viewer_modal modal wd-modal-wide fade in"
     role="dialog"
     tabindex="-1"
     aria-labelledby="ImagesViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- modal body -->
            <div class="wd-modal-body">
				<div>
					<!-- btn close -->
					<a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>

					<!-- main image -->
					<div class="wd_shop_product_main_image_container wd_center_wrapper">
						<div>
							<?php echo $el_product_image; ?>
						</div>
					</div>

				</div>

				<!-- modal footer -->
				<div class="wd-modal-footer">
					<!-- images slider -->
					<div class="wd_shop_product_images_slider">
						<a class="wd_items_slider_btn_prev btn btn-link pull-left">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>

						<a class="wd_items_slider_btn_next btn btn-link pull-right">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>

						<div class="wd_items_slider_mask">
							<ul class="wd_items_slider_items_list">
								<?php
								$active_class = 'active';
								for ($i = 0; $i < count($images); $i++) {
									$image = $images[$i];
									?>
									<li class="<?php echo $active_class; ?>">
										<a class="btn btn-link">
											<div class="wd_center_wrapper">
												<div>													
													<img src="<?php echo $image; ?>" data-src="<?php echo JURI::root().WDFHelper::get_image_original_url( $image );?>">											
												</div>
											</div>
										</a>
									</li>
									<?php
									$active_class = '';
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
