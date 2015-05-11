<?php
/*
 * @package Joomla
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 *
 * @component jDownloads
 * @version 2.0  
 * @copyright (C) 2007 - 2011 - Arno Betz - www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * 
 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * jDownloads Restore Controller
 *
 */
class jdownloadsControllerrestore extends jdownloadsController
{
	/**
	 * Constructor
	 *
	 */
	    public function __construct($config = array())
    {
        parent::__construct($config);
       
	}

	/**
	 * logic to restore the backup file
	 *
	 */
	public function runrestore()
    {
        global $jlistConfig;
        
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Access check.
        if (!JFactory::getUser()->authorise('edit.config','com_jdownloads')){            
            JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
            $this->setRedirect(JRoute::_('index.php?option=com_jdownloads&view=tools', true));
            
        } else {       
        
            jimport('joomla.filesystem.file');
            $db = JFactory::getDBO();
            $target_prefix = JDownloadshelper::getCorrectDBPrefix();
            
            $app = JFactory::getApplication();
            
            $original_upload_dir = $jlistConfig['files.uploaddir'];
            
            $output = '';

            // get restore file
            $file = JArrayHelper::getValue($_FILES,'restore_file',array('tmp_name'=>''));
            
            // save it in upload root
            $upload_path = $jlistConfig['files.uploaddir'].'/'.$file['name'];
            if (!JFile::upload($file['tmp_name'], $upload_path)){
                $app->redirect(JRoute::_('index.php?option=com_jdownloads'),  JText::_('COM_JDOWNLOADS_RESTORE_MSG_STORE_ERROR'), 'error');
            }
            
            if($file['tmp_name']!= ''){
           /*
                $i = 0;
                // check file
                @$datei = fopen($upload_path,"r") or die ("Cannot open File!");
                $muster = "/\bjd.version\b/i";
                $backup_prefix = '';
                $searchprefix_1 = '`';
                $searchprefix_2 = '_jdownloads_config';
                $vers = false;
                
                while (!feof($datei)) {
                     $zeile = fgets($datei, 4096);
                     if (preg_match($muster, $zeile)) {
                        if ($pos = strpos($zeile, "jd.version'", 100)){
                            // restore only from version 1.9 or newer
                            $vers = floatval(substr($zeile, $pos+13, 3));
                            if ($vers < 1.9){
                                fclose($datei);   
                                echo "<script> alert('".JText::_('COM_JDOWNLOADS_RESTORE_OLD_FILE')."'); window.history.go(-1); </script>\n";
                                exit();
                            } 
                        }    
                     }
                     if (!$backup_prefix){
                         if ($pos1 = strpos($zeile, $searchprefix_1)){
                             if ($pos2 = strpos($zeile, $searchprefix_2)){
                                 $pos3 = $pos2 - $pos1;
                                 $backup_prefix = substr($zeile, $pos1 + 1, $pos3);
                             }    
                         }
                     }
                }
               
                fclose($datei);
                
                // check that the source and target database use the same db prefix - when not: exit
                if ($backup_prefix != $target_prefix){
                    $errmsg =  sprintf(JText::_('COM_JDOWNLOADS_RESTORE_MSG_WRONG_DB_PREFIX_ERROR'), $backup_prefix, $target_prefix);
                    // JText::printf('COM_JDOWNLOADS_RESTORE_MSG_WRONG_DB_PREFIX_ERROR', $backup_prefix, $target_prefix);
                    echo "<script> alert('".$errmsg."'); window.history.go(-1); </script>\n";
                    exit();
                } 

                if (!$vers){
                   // wrong file submitted
                   $app->redirect(JRoute::_('index.php?option=com_jdownloads'),  JText::_('COM_JDOWNLOADS_RESTORE_MSG_WRONG_FILE_ERROR'), 'error'); 
                }    
                
                // make the backup file compatible for 2.0 when it is from 1.9
                if ($vers == 1.9){
                    $search  = array();
                    $replace = array();
                    // jdownloads_cats
                    $search[]  = '_cats';
                    $replace[] = '_categories';
                    $search[]  = 'cat_id`,`cat_dir';
                    $replace[] = 'id`,`cat_dir';
                    $search[]  = 'cat_title';
                    $replace[] = 'title';
                    $search[]  = 'cat_alias';
                    $replace[] = 'alias';
                    $search[]  = 'cat_description';
                    $replace[] = 'description';                
                    $search[]  = 'cat_pic';
                    $replace[] = 'pic';
                   // $search[]  = '`pic`,`cat_access`,`cat_group_access`';
                   // $replace[] = '`pic`,`access`';                
                    $search[]  = '`metadesc`,`jaccess`,`jlanguage`';
                    $replace[] = '`metadesc`,`language`';                
                    
                    // jdownloads_files
                    $search[]  = '`release`,`language`';
                    $replace[] = '`release`,`file_language`';                 
                    
                    // jdownloads_license
                    $search[]  = '_license';
                    $replace[] = '_licenses';
                    
                    // general
                    $search[]  = '`jaccess`,`jlanguage`';
                    $replace[] = '`access`,`language`';

                    // load the file
                    $file_array = file ( $upload_path );

                    for ( $x = 0; $x < count ( $file_array ); $x++){
                         for ($i=0; $i < count($search); $i++){
                            if (strpos( $file_array[$x], $search[$i])) {
                                $file_array[$x] = str_replace($search[$i], $replace[$i], $file_array[$x]);     
                            } 
                         }
                    }
                    
                    // write the changed data in the file
                    if (!file_put_contents($upload_path, $file_array)) die ( 'Cannot write in backup file!' );
                }    
                
                */
                // write values in db tables
                require_once($upload_path);
                
                // set off monitoring
                $db->setQuery("UPDATE #__jdownloads_config SET setting_value = '0' WHERE setting_name = 'files.autodetect'");
                $db->execute();
                $jlistConfig['files.autodetect'] = 0;

                // we must restore the original stored upload root dir in config
                $db->setQuery("UPDATE #__jdownloads_config SET setting_value = '$original_upload_dir' WHERE setting_name = 'files.uploaddir'");
                $db->execute();
                $jlistConfig['files.uploaddir'] = $original_upload_dir;
                
                // check tables when backup file is from a older version - not possible n this version
                //require_once(JPATH_SITE."/administrator/components/com_jdownloads/check.restore.jdownloads.php");
                //$output = checkAfterRestore();
                
                //$output = JDownloadsHelper::checkAfterRestore();
                //$log_messages = checkFiles($task);
                
                $sum = '<font color="green"><b>'.sprintf(JText::_('COM_JDOWNLOADS_RESTORE_MSG'),(int)$i).'</b></font>';
                
                if ($log_messages){
                    $output = addslashes($sum.'<br />'.$output.'<br />'.JText::_('COM_JDOWNLOADS_AFTER_RESTORE_TITLE_3').'<br />'.$log_messages.'<br />'.JText::_('COM_JDOWNLOADS_CHECK_FINISH').'');
                } else {   
                    $output = addslashes($sum.'<br />'.$output.'<br />'.JText::_('COM_JDOWNLOADS_CHECK_FINISH').'');
                }    
                $db->setQuery("UPDATE #__jdownloads_config SET setting_value = '$output' WHERE setting_name = 'last.restore.log'");
                $db->execute();
                $jlistConfig['last.restore.log'] = stripslashes($output);
                
                // delete the backup file in temp folder
                JFile::delete($upload_path);
            }
            $this->setRedirect( 'index.php?option=com_jdownloads',  $sum.' '.JText::_('COM_JDOWNLOADS_RESTORE_MSG_2') );
        }    
    }    
	
}
?>