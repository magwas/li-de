<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

$wd_file_manager_parent_dir;
$wd_file_manager_sort_order;


class EcommercewdModelFilemanager extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_file_manager_data() {
        $session_data = array();
        $session_data['sort_by'] = WDFSession::get('sort_by', 'name');
        $session_data['sort_order'] = WDFSession::get('sort_order', 'asc');
        $session_data['items_view'] = WDFSession::get('items_view', 'thumbs');
        $session_data['clipboard_task'] = WDFSession::get('clipboard_task', '');
        $session_data['clipboard_files'] = WDFSession::get('clipboard_files', '');
        $session_data['clipboard_src'] = WDFSession::get('clipboard_src', '');
        $session_data['clipboard_dest'] = WDFSession::get('clipboard_dest', '');

        $data = array();
        $data['session_data'] = $session_data;
        $data['path_components'] = $this->get_path_components();
        $data['dir'] = WDFInput::get('dir');
        $data['files'] = $this->get_files($session_data['sort_by'], $session_data['sort_order']);
        $data['extensions'] = WDFInput::get('extensions');
        $data['callback'] = WDFInput::get('callback');

        return $data;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_path_components() {
        $dir_names = explode(DS, WDFInput::get('dir'));
        $path = '';

        $components = array();
        $component = array();
        $component['name'] = WDFText::get('FM_UPLOADS_ROOT_DIR');
        $component['path'] = $path;
        $components[] = $component;
        for ($i = 0; $i < count($dir_names); $i++) {
            $dir_name = $dir_names[$i];
            if ($dir_name == '') {
                continue;
            }
            $path .= (($path == '') ? $dir_name : DS . $dir_name);
            $component = array();
            $component['name'] = $dir_name;
            $component['path'] = $path;
            $components[] = $component;
        }
        return $components;
    }

    function get_files($sort_by, $sort_order) {
        $icons_dir_url = WDFUrl::get_com_admin_url(true) . '/images/filemanager/file_icons';
        $valid_types = explode(',', strtolower(WDFInput::get('extensions', '*')));

        $parent_dir = WDFHelper::get_controller()->get_uploads_dir() . DS . WDFInput::get('dir');
        $parent_dir_url = WDFHelper::get_controller()->get_uploads_url() . '/' . WDFUrl::normalize_url(WDFInput::get('dir'));
	
        $file_names = $this->get_sorted_file_names($parent_dir, $sort_by, $sort_order);

        $dirs = array();
        $files = array();
        foreach ($file_names as $file_name) {
            if (($file_name == '.') || ($file_name == '..') || ($file_name == 'thumb') ) {
                continue;
            }
            if (is_dir($parent_dir . DS . $file_name) == true) {
                $file = array();
                $file['is_dir'] = true;
                $file['name'] = $file_name;
                $file['filename'] = $file_name;
                $file['type'] = '';
                $file['thumb'] = $icons_dir_url . '/dir.png';
                $file['icon'] = $icons_dir_url . '/dir.png';
                $file['size'] = '';
                $file['date_modified'] = '';
                $dirs[] = $file;
            } else {
                $file = array();
                $file['is_dir'] = false;
                $file['name'] = $file_name;
                $file['filename'] = substr($file_name, 0, strrpos($file_name, '.'));
                $file['type'] = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
//                $file['type'] = pathinfo($file_name, PATHINFO_EXTENSION);
                $icon = $icons_dir_url . '/' . $file['type'] . '.png';
                if (file_exists($icon) == false) {
                    $icon = $icons_dir_url . '/' . '_blank.png';
                }
                $file['thumb'] = $this->is_img($file['type']) ? $parent_dir_url . '/' . $file_name : $icon;
                $file['icon'] = $icon;
                if (($valid_types[0] != '*') && (in_array($file['type'], $valid_types) == FALSE)) {
                    continue;
                }
                $file_size_kb = (int)(filesize($parent_dir . DS . $file_name) / 1024);
                $file_size_mb = (int)($file_size_kb / 1024);
                $file['size'] = $file_size_kb < 1024 ? (string)$file_size_kb . 'KB' : (string)$file_size_mb . 'MB';
                $file['date_modified'] = date('d F Y, H:i', filemtime($parent_dir . DS . $file_name));

                $files[] = $file;
            }
        }

        $result = $sort_order == 'asc' ? array_merge($dirs, $files) : array_merge($files, $dirs);
		
        return $result;
    }


    private function get_sorted_file_names($parent_dir, $sort_by, $sort_order) {
        global $wd_file_manager_parent_dir;
        global $wd_file_manager_sort_order;

        $wd_file_manager_parent_dir = $parent_dir;
        $wd_file_manager_sort_order = $sort_order;

        function sort_by_size($a, $b) {
            global $wd_file_manager_parent_dir;
            global $wd_file_manager_sort_order;

            $size_of_a = filesize($wd_file_manager_parent_dir . DS . $a);
            $size_of_b = filesize($wd_file_manager_parent_dir . DS . $b);
            return $wd_file_manager_sort_order == 'asc' ? $size_of_a > $size_of_b : $size_of_a < $size_of_b;
        }

        function sort_by_date_modified($a, $b) {
            global $wd_file_manager_parent_dir;
            global $wd_file_manager_sort_order;

            $m_time_a = filemtime($wd_file_manager_parent_dir . DS . $a);
            $m_time_b = filemtime($wd_file_manager_parent_dir . DS . $b);
            return $wd_file_manager_sort_order == 'asc' ? $m_time_a > $m_time_b : $m_time_a < $m_time_b;
        }

        $file_names = scandir($parent_dir);
        switch ($sort_by) {
            case 'name':
                natcasesort($file_names);
                if ($sort_order == 'desc') {
                    $file_names = array_reverse($file_names);
                }
                break;
            case 'size':
                usort($file_names, 'sort_by_size');
                break;
            case 'date_modified':
                usort($file_names, 'sort_by_date_modified');
                break;
        }

        return $file_names;
    }

    private function is_img($file_type) {
        switch ($file_type) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'JPG':
            case 'bmp':
            case 'gif':
                return true;
                break;
        }

        return false;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}