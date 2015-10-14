<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerFilemanager extends EcommercewdController {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    public $uploads_dir;
    public $uploads_url;
    public $uploads_absolute_url;

    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function __construct() {
        // TODO:
        if ((isset($_GET['task'])) && ($_GET['task'] == 'handle_upload')) {
            WDFInput::set('task', $_GET['task']);
        }

        parent::__construct();
        WDFInput::set('view', 'filemanager');
        WDFInput::set('tmpl', 'component');

		$uploads_current_tab = WDFInput::get('fm_tab_index','images');	
        $this->uploads_dir = JPATH_SITE . DS .'media'. DS .'com_'. WDFHelper::get_com_name(). DS . 'uploads'.'/'.$uploads_current_tab;	
        if (file_exists($this->uploads_dir) == false) {
            mkdir($this->uploads_dir);
        }
        $this->uploads_url = JURI::root().'media/com_'. WDFHelper::get_com_name().'/uploads'.'/'.$uploads_current_tab;
        $this->uploads_absolute_url = 'media/com_'. WDFHelper::get_com_name().'/uploads'.'/'.$uploads_current_tab;

        WDFInput::set('dir', WDFPath::normalize_path(WDFInput::get('dir')));
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_uploads_dir() {		
        return $this->uploads_dir;
    }

    public function get_uploads_url() {
        return $this->uploads_url;
    }
	
	public function get_uploads_absolute_url() {
        return $this->uploads_absolute_url;
    }
	

    public function make_dir() {
        $input_dir = WDFInput::get('dir');
        $cur_dir_path = $input_dir == '' ? $this->uploads_dir : $this->uploads_dir . DS . $input_dir;

        $new_dir_path = $cur_dir_path . DS . WDFInput::get('new_dir_name');

        $msg = '';
        if (file_exists($new_dir_path) == true) {
            $msg = WDFText::get('FM_MSG_DIRECTORY_ALREADY_EXISTS');
        } else {
            mkdir($new_dir_path);
        }
        WDFHelper::redirect('filemanager', '', '', 'extensions=' . WDFInput::get('extensions') . '&callback=' . WDFInput::get('callback') . '&dir=' . WDFInput::get('dir'). '&fm_tab_index=' . WDFInput::get('fm_tab_index'). '&fm_tab_index_unchanged=' . WDFInput::get('fm_tab_index_unchanged'), $msg, 'Warning');
    }

    public function rename_item() {
        $input_dir = WDFInput::get('dir');
        $cur_dir_path = $input_dir == '' ? $this->uploads_dir : $this->uploads_dir . DS . $input_dir;
        $cur_dir_path = htmlspecialchars_decode($cur_dir_path, ENT_COMPAT | ENT_QUOTES);

        $file_names = WDFInput::get_array('file_names', '**#**');
        $file_name = $file_names[0];
        $file_name = htmlspecialchars_decode($file_name, ENT_COMPAT | ENT_QUOTES);

        $file_new_name = WDFInput::get('file_new_name');

        $file_path = $cur_dir_path . DS . $file_name;
        $thumb_file_path = $cur_dir_path . '/thumb/' . $file_name;    

        $msg = '';
        if (file_exists($file_path) == false) {
            $msg = WDFText::get('FM_MSG_FILE_DOESNT_EXIST');
        } else if (is_dir($file_path) == true) {
            if (rename($file_path, $cur_dir_path . DS . $file_new_name) == false) {
                $msg = WDFText::get('FM_MSG_CANT_RENAME_THE_FILE');
            }
        } else if ((strrpos($file_name, '.') !== false)) {
            $file_extension = substr($file_name, strrpos($file_name, '.') + 1);
            if (rename($file_path, $cur_dir_path . DS . $file_new_name . '.' . $file_extension) == false) {
                $msg = WDFText::get('FM_MSG_CANT_RENAME_THE_FILE');
            } else {
				if(WDFInput::get('tab_index') == 'images'){
					rename($thumb_file_path, $cur_dir_path . '/thumb/' . $file_new_name . '.' . $file_extension);
				}
            }
        } else {
            $msg = WDFText::get('FM_MSG_CANT_RENAME_THE_FILE');
        }

        WDFInput::set('file_names', '');

        WDFHelper::redirect('filemanager', 'show_file_manager', '', 'tmpl=component&extensions=' . WDFInput::get('extensions') . '&callback=' . WDFInput::get('callback') . '&dir=' . WDFInput::get('dir'). '&fm_tab_index=' . WDFInput::get('fm_tab_index'). '&fm_tab_index_unchanged=' . WDFInput::get('fm_tab_index_unchanged'), $msg, 'Warning');
    }

    public function remove_items() {
        $input_dir = WDFInput::get('dir');
        $cur_dir_path = $input_dir == '' ? $this->uploads_dir : $this->uploads_dir . DS . $input_dir;
        $cur_dir_path = htmlspecialchars_decode($cur_dir_path, ENT_COMPAT | ENT_QUOTES);

        $file_names = WDFInput::get_array('file_names', '**#**');

        $msg = '';
        foreach ($file_names as $file_name) {
            $file_name = htmlspecialchars_decode($file_name, ENT_COMPAT | ENT_QUOTES);
            $file_path = $cur_dir_path . DS . $file_name;
            $thumb_file_path = $cur_dir_path . '/thumb/' . $file_name;          

            if (file_exists($file_path) == false) {
                $msg = WDFText::get('FM_MSG_SOME_OF_THE_FILES_CANT_BE_REMOVED');
            } else {
                $this->remove_file_dir($file_path);
                if (file_exists($thumb_file_path)) {
                    $this->remove_file_dir($thumb_file_path);
                }
            }
        }

        WDFInput::set('file_names', '');

        WDFHelper::redirect('filemanager', 'show_file_manager', '', 'tmpl=component&extensions=' . WDFInput::get('extensions') . '&callback=' . WDFInput::get('callback') . '&dir=' . WDFInput::get('dir') . '&fm_tab_index=' . WDFInput::get('fm_tab_index'). '&fm_tab_index_unchanged=' . WDFInput::get('fm_tab_index_unchanged'), $msg, 'Warning');
    }

    public function paste_items() {
        $msg = '';

        $file_names = WDFInput::get_array('clipboard_files', '**#**');
        $src_dir = WDFSession::get('clipboard_src');
        $src_dir = $src_dir == '' ? $this->uploads_dir : $this->uploads_dir . DS . $src_dir;
        $src_dir = htmlspecialchars_decode($src_dir, ENT_COMPAT | ENT_QUOTES);
        $dest_dir = WDFSession::get('clipboard_dest');
        $dest_dir = $dest_dir == '' ? $this->uploads_dir : $this->uploads_dir . DS . $dest_dir;
        $dest_dir = htmlspecialchars_decode($dest_dir, ENT_COMPAT | ENT_QUOTES);

        switch (WDFInput::get('clipboard_task')) {
            case 'copy':
                foreach ($file_names as $file_name) {
                    $file_name = htmlspecialchars_decode($file_name, ENT_COMPAT | ENT_QUOTES);
                    $src = $src_dir . DS . $file_name;
                    if (file_exists($src) == false) {
                        $msg = WDFText::get('FM_MSG_FAILED_TO_COPY_SOME_OF_THE_FILES');
                        continue;
                    }

                    $dest = $dest_dir . DS . $file_name;
					if(WDFInput::get('fm_tab_index_unchanged') == 'images'){
						if (!is_dir($src_dir . '/' . $file_name)) {
							if (!is_dir($dest_dir . '/thumb')) {
								mkdir($dest_dir . '/thumb', 0777);
							}
							$thumb_src = $src_dir . '/thumb/' . $file_name;
							$thumb_dest = $dest_dir . '/thumb/' . $file_name;
						}
					}
                    $i = 0;
                    if (file_exists($dest) == true) {
                        $path_parts = pathinfo($dest);
                        while (file_exists($path_parts['dirname'] . DS . $path_parts['filename'] . '(' . ++$i . ')' . '.' . $path_parts['extension'])) {
                        }
                        $dest = $path_parts['dirname'] . DS . $path_parts['filename'] . '(' . $i . ')' . '.' . $path_parts['extension'];
                        if (!is_dir($src_dir . '/' . $file_name)) {
                            $thumb_dest = $path_parts['dirname'] . '/thumb/' . $path_parts['filename'] . '(' . $i . ')' . '.' . $path_parts['extension'];
                        }
                    }

                    if (!$this->copy_file_dir($src, $dest)) {
                        $msg = WDFText::get('FM_MSG_FAILED_TO_COPY_SOME_OF_THE_FILES');
                    }
					if(WDFInput::get('fm_tab_index_unchanged') == 'images'){
						if (!is_dir($src_dir . '/' . $file_name)) {
							$this->copy_file_dir($thumb_src, $thumb_dest);
						}
					}
                }
                break;
            case 'cut':
                if ($src_dir != $dest_dir) {
                    foreach ($file_names as $file_name) {
                        $file_name = htmlspecialchars_decode($file_name, ENT_COMPAT | ENT_QUOTES);
                        $src = $src_dir . DS . $file_name;
                        $dest = $dest_dir . DS . $file_name;
						if(WDFInput::get('fm_tab_index_unchanged') == 'images'){
							if (!is_dir($src_dir . '/' . $file_name)) {
								$thumb_src = $src_dir . '/thumb/' . $file_name;
								$thumb_dest = $dest_dir . '/thumb/' . $file_name;
								if (!is_dir($dest_dir . '/thumb')) {
									mkdir($dest_dir . '/thumb', 0777);
								}
							}
						}
                        if ((file_exists($src) == false) || (file_exists($dest) == true) || (!rename($src, $dest))) {
                            $msg = WDFText::get('FM_MSG_FAILED_TO_MOVE_SOME_OF_THE_FILES');
                        }
						if(WDFInput::get('fm_tab_index_unchanged') == 'images'){
							if (!is_dir($src_dir . '/' . $file_name)) {
								rename($thumb_src, $thumb_dest);
							}
						}
                    }
                }
                break;
        }
        WDFHelper::redirect('filemanager', 'show_file_manager', '', 'tmpl=component&extensions=' . WDFInput::get('extensions') . '&callback=' . WDFInput::get('callback') . '&dir=' . WDFInput::get('dir'). '&fm_tab_index=' . WDFInput::get('fm_tab_index'). '&fm_tab_index_unchanged=' . WDFInput::get('fm_tab_index_unchanged'), $msg, 'Warning');
    }
	
	

    public function handle_upload() {		
        new UploadHandler(array('upload_dir' => $_GET['dir'], 'accept_file_types' => '/\.(gif|jpe?g|JPG|png|bmp|mp4|flv|webm|ogg|mp3|wav|pdf|zip|rar)$/i', 'max_file_size' => min(WDFUtils::get_bytes(ini_get('upload_max_filesize')), WDFUtils::get_bytes(ini_get('memory_limit')), WDFUtils::get_bytes(ini_get('post_max_size')))), WDFInput::get('fm_tab_index'));
        die();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function remove_file_dir($del_file_dir) {
        if (is_dir($del_file_dir) == true) {
            $files_to_remove = scandir($del_file_dir);
            foreach ($files_to_remove as $file) {
                if ($file != '.' and $file != '..') {
                    $this->remove_file_dir($del_file_dir . '/' . $file);
                }
            }
            rmdir($del_file_dir);
        } else {
            unlink($del_file_dir);
        }
    }

    private function copy_file_dir($src, $dest) {
        if (is_dir($src) == true) {
            $dir = opendir($src);
            @mkdir($dest);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        $this->copy_file_dir($src . '/' . $file, $dest . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dest . '/' . $file);
                    }
                }
            }
            closedir($dir);
            return true;
        } else {
            return copy($src, $dest);
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}