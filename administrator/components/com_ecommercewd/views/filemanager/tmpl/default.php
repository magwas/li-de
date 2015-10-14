<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

$items_view = $this->file_manager_data['session_data']['items_view'];
$sort_by = $this->file_manager_data['session_data']['sort_by'];
$sort_order = $this->file_manager_data['session_data']['sort_order'];
$clipboard_task = $this->file_manager_data['session_data']['clipboard_task'];
$clipboard_files = $this->file_manager_data['session_data']['clipboard_files'];
$clipboard_src = $this->file_manager_data['session_data']['clipboard_src'];
$clipboard_dest = $this->file_manager_data['session_data']['clipboard_dest'];
$icons_dir_url = WDFUrl::get_com_admin_url(true) . '/images/filemanager/file_icons';
$sort_icon = $icons_dir_url . '/' . $sort_order;
//var_dump($items_view);
//var_dump($sort_by);
//var_dump($sort_order);
//var_dump($clipboard_task);
//var_dump($clipboard_files);
//var_dump($clipboard_src);
//var_dump($clipboard_dest);
//var_dump($icons_dir_url);
//var_dump($sort_icon);
WDFHelper::add_css('/css/filemanager/default.css" type="text/css" rel="stylesheet');
switch ($items_view) {
    case 'list':
        WDFHelper::add_css('/css/filemanager/default_view_list.css" type="text/css" rel="stylesheet');
        break;
    case 'thumbs':
        WDFHelper::add_css('/css/filemanager/default_view_thumbs.css" type="text/css" rel="stylesheet');
        break;
}
WDFHelper::add_script('/js/filemanager/jq_uploader/jquery.ui.widget.js', true, true, true);
WDFHelper::add_script('/js/filemanager/jq_uploader/jquery.iframe-transport.js', true, true, true);
WDFHelper::add_script('/js/filemanager/jq_uploader/jquery.fileupload.js', true, true, true);
WDFHelper::add_script('/js/filemanager/default.js');


?>

<form name="adminForm" id="adminForm" action="" method="post">

<div id="wrapper">
<div id="file_manager">


    <div class="ctrls_bar ctrls_bar_header">
        <div class="ctrls_left">
            <a class="ctrl_bar_btn btn_up" onclick="onBtnUpClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_UP'); ?>">
            </a>
            <a class="ctrl_bar_btn btn_make_dir" onclick="onBtnMakeDirClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_MAKE_DIRECTORY'); ?>">
            </a>
            <a class="ctrl_bar_btn btn_rename_item" onclick="onBtnRenameItemClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_RENAME'); ?>">
            </a>
            <span class="ctrl_bar_divider">
            </span>
            <a class="ctrl_bar_btn btn_copy" onclick="onBtnCopyClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_COPY'); ?>">
            </a>
            <a class="ctrl_bar_btn btn_cut" onclick="onBtnCutClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_CUT'); ?>">
            </a>
            <a class="ctrl_bar_btn btn_paste" onclick="onBtnPasteClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_PASTE'); ?>">
            </a>
            <a class="ctrl_bar_btn btn_remove_items" onclick="onBtnRemoveItemsClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_REMOVE'); ?>">
            </a>
            <span class="ctrl_bar_divider">
            </span>
            <a class="ctrl_bar_btn btn_primary btn_upload_files"
               onclick="onBtnShowUploaderClick(event, this);"><?php echo WDFText::get('FM_BTN_UPLOAD_FILES'); ?>
            </a>
        </div>
        <div class="ctrls_right">
            <a class="ctrl_bar_btn btn_view_thumbs" onclick="onBtnViewThumbsClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_VIEW_THUMBS'); ?>"></a>
            <a class="ctrl_bar_btn btn_view_list" onclick="onBtnViewListClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_VIEW_LIST'); ?>"></a>
        </div>
    </div>

    <div id="path">
        <?php
        foreach ($this->file_manager_data['path_components'] as $path_component) {
            ?>
            <a class="path_component path_dir"
               onclick="onPathComponentClick(event, this, '<?php echo addslashes($path_component['path']); ?>');">
                <?php echo $path_component['name']; ?></a>
            <a class="path_component path_separator"><?php echo DS; ?></a>
        <?php
        }
        ?>
    </div>

    <div id="explorer">
        <div id="explorer_header_wrapper">
            <div id="explorer_header_container">
                <div id="explorer_header">
                        <span class="item_number">
                            #
                        </span>
                        <span class="item_icon">
                        </span>
                        <span class="item_name">
                            <span class="clickable" onclick="onNameHeaderClick(event, this);">
                                <?php
                                echo WDFText::get('FM_NAME');
                                if ($sort_by == 'name') {
                                    ?>
                                    <span class="sort_order_<?php echo $sort_order; ?>"></span>
                                <?php
                                }
                                ?>
                            </span>
                        </span>
                        <span class="item_size">
                            <span class="clickable" onclick="onSizeHeaderClick(event, this);">
                                <?php
                                echo WDFText::get('FM_SIZE');
                                if ($sort_by == 'size') {
                                    ?>
                                    <span class="sort_order_<?php echo $sort_order; ?>"></span>
                                <?php
                                }
                                ?>
                            </span>
                        </span>
                        <span class="item_date_modified">
                            <span class="clickable" onclick="onDateModifiedHeaderClick(event, this);">
                                <?php
                                echo WDFText::get('FM_DATE_MODIFIED');
                                if ($sort_by == 'date_modified') {
                                    ?>
                                    <span class="sort_order_<?php echo $sort_order; ?>"></span>
                                <?php
                                }
                                ?>
                            </span>
                        </span>
                        <span class="scrollbar_filler">
                        </span>
                </div>
            </div>
        </div>

        <div id="explorer_body_wrapper">
            <div id="explorer_body_container">
				<?php
					if(WDFHelper::is_j3() == true){
						WDFHTMLTabs::startTabs('files', WDFInput::get('fm_tab_index'), 'onTabFilemanagerActivated');
		
						WDFHTMLTabs::startTab('images', WDFText::get('IMAGES'));	
							
						WDFHTMLTabs::endTab();

						WDFHTMLTabs::startTab('videos', WDFText::get('VIDEOS'));					
						WDFHTMLTabs::endTab();
						
						WDFHTMLTabs::endTabs();
						echo JHtml::_('tabs.end');
					}
					else{
				?>
					<dl class="tabs" id="tab_group_files">
						<dt class="year <?php if(WDFInput::get('fm_tab_index','images') == 'images') echo 'open';?>"><a href="#year" data-toggle="tab" onclick="onTabFilemanagerActivated('images')"><?php echo WDFText::get('IMAGES')?></a></dt>
						<dt class="last_month <?php if(WDFInput::get('fm_tab_index','images') == 'videos') echo 'open';?>"><a href="#last_month" data-toggle="tab" onclick="onTabFilemanagerActivated('videos')"><?php echo WDFText::get('VIDEOS')?></a></dt>						
					</dl>
				<?php
				}
				?>
                <div id="explorer_body" class="current">
                 <?php				
                    $files = $this->file_manager_data['files'];
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $files[$i];
                        ?>
                        <div class="explorer_item" draggable="true"
                             name="<?php echo $file['name']; ?>"
                             onmouseover="onFileMOver(event, this);"
                             onmouseout="onFileMOut(event, this);"
                             onclick="onFileClick(event, this);"
                             ondblclick="onFileDblClick(event, this);"
                             ondragstart="onFileDragStart(event, this);"
                            <?php
                            if ($file['is_dir'] == true) {
                                ?>
                                ondragover="onFileDragOver(event, this);"
                                ondrop="onFileDrop(event, this);"
                            <?php
                            }
                            ?>
                             isDir="<?php echo $file['is_dir'] == true ? 'true' : 'false'; ?>">
                            <span class="item_number">
                                <?php echo $i + 1; ?>
                            </span>
                            <span class="item_thumb">
                                <img src="<?php echo $file['thumb']; ?>"/>
                            </span>
                            <span class="item_icon">
                                <img src="<?php echo $file['icon']; ?>"/>
                            </span>
                            <span class="item_name">
                                <?php echo $file['name']; ?>
                            </span>
                            <span class="item_size">
                                <?php echo $file['size']; ?>
                            </span>
                            <span class="item_date_modified">
                                <?php echo $file['date_modified']; ?></span>
                            </span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ctrls_bar ctrls_bar_footer">
	    <div class="ctrls_left">
            <a class="ctrl_bar_btn btn_primary btn_text btn_select_all" onclick="onBtnSelectAllClick();"><?php echo  WDFText::get('FM_BTN_SELECT_ALL'); ?></a>
        </div>
        <div class="ctrls_right">
            <a class="ctrl_bar_btn btn_text btn_primary btn_open"
               onclick="onBtnOpenClick(event, this);">
                <?php echo WDFText::get('FM_BTN_INSERT'); ?>
            </a>
            <span class="ctrl_bar_empty_divider"></span>
            <a class="ctrl_bar_btn btn_text btn_cancel"
               onclick="onBtnCancelClick(event, this);">
                <?php echo WDFText::get('FM_BTN_CANCEL'); ?>
            </a>
        </div>
    </div>
</div>

<div id="uploader">
    <div id="uploader_bg">
    </div>

    <div class="ctrls_bar ctrls_bar_header">
        <div class="ctrls_right">
            <a class="ctrl_bar_btn btn_back" onclick="onBtnBackClick(event, this);"
               title="<?php echo WDFText::get('FM_BTN_BACK'); ?>"></a>
        </div>
    </div>

    <label for="jQueryUploader">
        <div id="uploader_hitter">
            <div id="drag_message">
                <span><?php echo WDFText::get('FM_MSG_DRAG_HERE'); ?></span>
            </div>
            <div id="btnBrowseContainer">
                <input id="jQueryUploader" type="file" name="files[]"
                       data-url="<?php echo WDFUrl::get_admin_url() . '/index.php?option=com_'.WDFHelper::get_com_name().'&controller=filemanager&task=handle_upload&dir=' . WDFHelper::get_controller()->get_uploads_dir() . DS . WDFInput::get('dir') . DS; ?>"
                       multiple>
            </div>
        </div>
    </label>

    <div id="uploaded_files">
        <ul>
        </ul>
    </div>

    <div id="uploader_progress">
        <div id="uploader_progress_bar" class="uploader_text">
            <div></div>
        </div>
        <span id="uploader_progress_text">
            <?php echo WDFText::get('FM_NO_FILES_TO_UPLOAD'); ?>
        </span>
    </div>
</div>
</div>


<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>">
<input type="hidden" name="controller" value="filemanager">
<input type="hidden" name="task" value="">
<input type="hidden" name="extensions" value="<?php echo WDFInput::get('extensions', '*'); ?>">
<input type="hidden" name="callback" value="<?php echo WDFInput::get('callback'); ?>">
<input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>">
<input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>">
<input type="hidden" name="items_view" value="<?php echo $items_view; ?>">
<input type="hidden" name="dir" value="<?php echo WDFInput::get('dir'); ?>"/>
<input type="hidden" name="file_names" value=""/>
<input type="hidden" name="file_new_name" value=""/>
<input type="hidden" name="new_dir_name" value=""/>
<input type="hidden" name="clipboard_task" value="<?php echo $clipboard_task; ?>"/>
<input type="hidden" name="clipboard_files" value="<?php echo $clipboard_files; ?>"/>
<input type="hidden" name="clipboard_src" value="<?php echo $clipboard_src; ?>"/>
<input type="hidden" name="clipboard_dest" value="<?php echo $clipboard_dest; ?>"/>
<input type="hidden" name="fm_tab_index" value="<?php echo WDFInput::get('fm_tab_index'); ?>"/>
<input type="hidden" name="fm_tab_index_unchanged" value="<?php echo WDFInput::get('fm_tab_index_unchanged'); ?>"/>
</form>

<script>
    var DS = "<?php echo addslashes(DS); ?>";

    var FM_MSG_UPLOAD_FAILED = "<?php echo WDFText::get('FM_MSG_UPLOAD_FAILED'); ?>";
    var FM_MSG_UPLOADED = "<?php echo WDFText::get('FM_MSG_UPLOADED'); ?>";

    var errorLoadingFile = "<?php echo WDFText::get('FM_MSG_FILE_LOADING_FAILED'); ?>";

    var warningRemoveItems = "<?php echo WDFText::get('FM_MSG_REMOVE_CONFIRM'); ?>";
    var warningCancelUploads = "<?php echo WDFText::get('FM_MSG_CANCEL_UPLOAD_CONFIRM'); ?>";

    var messageEnterDirName = "<?php echo WDFText::get('FM_MSG_ENTER_DIRECTORY_NAME'); ?>";
    var messageEnterNewName = "<?php echo WDFText::get('FM_MSG_ENTER_NEW_NAME'); ?>";
    var messageFilesUploadComplete = "<?php echo WDFText::get('FM_MSG_UPLOADING_FINISHED'); ?>";

	var fmTabIndexUnchanged = "<?php echo WDFInput::get('fm_tab_index_unchanged');?>";
	var fmTabIndex = "<?php echo WDFInput::get('fm_tab_index');?>";

    var root = "<?php echo addslashes(WDFHelper::get_controller()->get_uploads_dir()); ?>";
    var dir = "<?php echo addslashes(WDFInput::get('dir')); ?>";

	var dirUrl = (fmTabIndexUnchanged == 'images') ? "<?php echo WDFUrl::normalize_url(WDFHelper::get_controller()->get_uploads_absolute_url() . "/" . WDFInput::get('dir').'/thumb'); ?>" : "<?php echo WDFUrl::normalize_url(WDFHelper::get_controller()->get_uploads_absolute_url() . "/" . WDFInput::get('dir')); ?>";

	var callback = "<?php echo WDFInput::get('callback'); ?>";
    var sortBy = "<?php echo $sort_by; ?>";
    var sortOrder = "<?php echo $sort_order; ?>";
	
	var wdShop_isJ3 = <?php echo WDFHelper::is_j3() ? 1 : 0; ?>;
</script>