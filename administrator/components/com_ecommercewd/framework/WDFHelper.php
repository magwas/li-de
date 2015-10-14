<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') || die('Access Denied');


class WDFHelper {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Component name.
     *
     * @var    string
     */
    private static $com_name;

    /**
     * Current controller.
     *
     * @var    JController
     */
    private static $controller;

    /**
     * Map of generated models.
     *
     * @var    Array
     */
    private static $models_map;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Init variables and require all files in framework
     */
    public static function init($com_name = '') {
        self::$com_name = $com_name != '' ? $com_name : substr(JFactory::getApplication()->input->get('option'), 4);

        // require joomla mvc dummies (for version differneces)
        if (self::is_j3() == true) {
            self::framework_require('mvc' . DS . 'WDFDummyJ3MVC.php');
        } else {
            self::framework_require('mvc' . DS . 'WDFDummyJ2MVC.php');
        }
		
		if( !function_exists('_recaptcha_http_post') ){
			self::framework_require('helpers' . DS . 'recaptchalib.php');
		}
		
		if(!class_exists('lessc_formatter_compressed') ){
			self::framework_require('helpers' . DS . 'lessc.inc.php');
		}	
        self::require_dir(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_' . self::get_com_name() . DS . 'framework');

        //init basic input from params
        if (JFactory::getApplication()->isSite() == true) {
            if (WDFInput::get_controller() == null) {
                WDFInput::set('controller', WDFInput::get('view'));
            }
            if (WDFInput::get_task() == null) {
                WDFInput::set('task', WDFInput::get('layout'));
            }
        }

        // require base controller, model, and view classes
        self::com_require('controllers' . DS . 'controller.php');
        self::com_require('models' . DS . 'model.php');
        self::com_require('views' . DS . 'view.php');
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Get component name
     *
     * @return    string    name of the component
     */
    public static function get_com_name() {
        return self::$com_name;
    }

    /**
     * Require class starting from component directory
     *
     * @param    string $class_path path of the class to require
     */
    public static function com_require($class_path) {
        require_once WDFPath::get_com_path() . DS . $class_path;
    }

    /**
     * Add css
     *
     * @param    $path    string    path of css file starting from com path
     * @param    $relative    string    is path relative
     * @param    $from_admin_part    boolean    require from admin part folder
     */
    public static function add_css($path, $relative = true, $from_admin_part = false, $in_admin_from_site_part = false) {
        if( $in_admin_from_site_part == false ){
			$com_url = $from_admin_part == true ? WDFUrl::get_com_admin_url() : WDFUrl::get_com_url();
		}
		else{
			$com_url = WDFUrl::get_com_site_url();
		}	
        JFactory::getDocument()->addStyleSheet($relative == true ? $com_url . '/' . $path : $path);
    }

    /**
     * Add script
     *
     * @param    $path    string    path of js file starting from com path
     * @param    $relative    string    is path relative
     * @param    $from_admin_part    boolean    require from admin part folder
     * @param    $defer    boolean    defer
     */
    public static function add_script($path, $relative = true, $from_admin_part = false, $defer = false, $in_admin_from_site_part = false) {
        if( $in_admin_from_site_part == false ){
			$com_url = $from_admin_part == true ? WDFUrl::get_com_admin_url() : WDFUrl::get_com_url();
        }
		else{
			$com_url = WDFUrl::get_com_site_url();
		}
		JFactory::getDocument()->addScript($relative == true ? $com_url . '/' . $path : $path, 'text/javascript', $defer);
    }

    /**
     * Add script declaration
     *
     * @param    $path    string    path of js file starting from com path
     * @param    $relative    string    is path relative
     * @param    $from_admin_part    boolean    require from admin part folder
     */
    public static function add_script_declaration($path, $relative = true, $from_admin_part = false) {
        $com_url = $from_admin_part == true ? WDFUrl::get_com_admin_url() : WDFUrl::get_com_url();
        JFactory::getDocument()->addScriptDeclaration($relative == true ? $com_url . '/' . $path : $path);
    }

    /**
     * Is joomla 3
     *
     * @return    Boolean    true if j3
     */
    public static function is_j3() {
        return version_compare(JVERSION, '3.0.0', '>=') ? true : false;
    }

    /**
     * Is admin interface?
     *
     * @return    Boolean    true if admin
     */
    public static function is_admin() {
        $app = JFactory::getApplication();
        return $app->isAdmin() == true ? true : false;
    }

    /**
     * Check if user is logged in
     *
     * @return    Boolean    true if user is logged in
     */
    public static function is_user_logged_in() {
        $j_user = JFactory::getUser();
        return $j_user->guest == 1 ? false : true;
    }

    /**
     * Get appropriate controller
     *
     * @return    JController    new controller object based on controller input
     */
    public static function get_controller() {
		$all_controllers = self::get_controllers();
        if (self::$controller == null) {
            $input_controller = WDFInput::get_controller();
			if(in_array( $input_controller, $all_controllers ) == true){
				if ($input_controller) {
					$controller_path = WDFPath::get_com_path() . DS . 'controllers' . DS . $input_controller . '.php';
					if (file_exists($controller_path)) {
						require_once $controller_path;
					}
				}
				$controller_class = ucfirst(self::get_com_name()) . 'Controller' . ucfirst($input_controller);
				self::$controller = new $controller_class();
			}
        }
        return self::$controller;
    }

    /**
     * Get model by type (or appropriate if type is not set)
     *
     * @param    $type    string    type of model to get. if not set gets current controller's model
     *
     * @return    JModel    new model object
     */
    public static function get_model($type = '') {
        if (self::$models_map == null) {
            self::$models_map = array();
        }
		
        if ($type == '') {
            $input_controller = WDFInput::get_controller();
            $type = $input_controller;
        }
		
        if (isset(self::$models_map[$type]) == false) {
            require_once WDFPath::get_com_path() . DS . 'models' . DS . $type . '.php';
            $model_class = ucfirst(self::get_com_name()) . 'Model' . ucfirst($type);
            self::$models_map[$type] = new $model_class;
        }
        return self::$models_map[$type];
    }

    /**
     * Redirect to current component with params
     *
     * @param    $controller    string    controller request.
     * @param    $task    string    task request.
     * @param    $cid    string    checked ids request.
     * @param    $params    string    another params like param_name=param_value&...
     * @param    string $msg An optional message to display on redirect.
     * @param    string $msgType An optional message type. Defaults to message.
     * @param    boolean $moved True if the page is 301 Permanently Moved, otherwise 303 See Other is assumed.
     *
     * @return    JModel    new model object
     */
    public static function redirect($controller = '', $task = '', $cid = '', $params = '', $msg = '', $msgType = 'message', $moved = false) {
        if ($controller == '') {
            $controller = WDFInput::get_controller();
        }
        $url_parts = array();
        if ($controller != '') {
            $url_parts[] = 'controller=' . $controller;
        }
        if ($task != '') {
            $url_parts[] = 'task=' . $task;
        }
        if ($cid != '') {
            $url_parts[] = 'cid=' . $cid;
        }
        if ($params != '') {
            $url_parts[] = $params;
        }

        $app = JFactory::getApplication();
        if (self::is_admin() == true) {
            $app->redirect('index.php?option=com_' . self::get_com_name() . '&' . implode('&', $url_parts), $msg, $msgType, $moved);
        } else {
            $app->redirect(JRoute::_('index.php?option=com_' . self::get_com_name() . '&' . implode('&', $url_parts), false), $msg, $msgType, $moved);
        }
    }
	
	public static function get_image_original_url($image){
		return str_replace("/thumb","",$image);
	
	}
	
    /**
	* check if user is shop user
	*/	
	public static function is_shop_user($user_id){
		$db = JFactory::getDbo();
				
		$user = '';
		if( $user_id ){			
			$query = $db->getQuery(true);

			$query->clear();
			$query->select('j_user_id');
			$query->from('#__ecommercewd_users');
			$query->where('j_user_id = '.$user_id);
			
			$db->setQuery($query);
			$user = $db->loadResult();
		}
	
		if( $user ){
			return true;
		}
		
		return false;	
	}
	
    /**
	* make joomla user shop user
	*
	*/			
	public static function make_shop_user(){
		$db = JFactory::getDbo();
		$user_id = JFactory::getUser()->id;
		$name = JFactory::getUser()->name;
		
		if( $user_id ){			
			if( !self::is_shop_user($user_id) ){
				$query = $db->getQuery(true);

				$query->clear();
				$query->insert('#__ecommercewd_users');
				$columns = array('j_user_id', 'first_name');
				$query->columns($columns);
				
				$values = array($db->quote($user_id),$db->quote($name));
				$query->values(implode(',',$values));
							
				$db->setQuery($query);
				$db->query();
				
				if ($db->getErrorNum()) {
					echo $db->getErrorMsg();
					return false;
				}
					
			}	
		}
			
	}


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Require framework class
     *
     * @param    string $path name of the class to require
     */
    private static function framework_require($path) {
        require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_' . self::get_com_name() . DS . 'framework' . DS . $path;
    }

    /**
     * Require php files in specified folder
     *
     * @param    string $dir_path name of the dir of files
     * @param    boolean $include_subdirs include subdirectories
     */
    private static function require_dir($dir_path, $include_subdirs = true) {
        $files = scandir($dir_path);
        foreach ($files as $file) {
            if (($file == '.') || ($file == '..')) {
                continue;
            }
            $file = $dir_path . DS . $file;
            if (is_dir($file) == true) {
                self::require_dir($file);
            } else {
                if ((is_file($file) == true) && (pathinfo($file, PATHINFO_EXTENSION) == 'php') && (substr(pathinfo($file, PATHINFO_FILENAME), 0, 8) != 'WDFDummy') && (substr(pathinfo($file, PATHINFO_FILENAME), 0, 12) != 'recaptchalib') && (substr(pathinfo($file, PATHINFO_FILENAME), 0, 12) != 'lessc.inc')) {
                    require_once $file;
                }
            }
        }
    }
	
    /**
     * get all controllers
     *
     */	
	
	private static function get_controllers(){
		$admin_controllers_dir_path = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_' . self::get_com_name() . DS . 'controllers' ;
		$site_controllers_dir_path = JPATH_SITE . DS . 'components' . DS . 'com_' . self::get_com_name() . DS . 'controllers' ;
		$admin_controllers  = scandir($admin_controllers_dir_path);
		$site_controllers  = scandir($site_controllers_dir_path);
		$all_controllers = array_merge($admin_controllers,$site_controllers );
		foreach($all_controllers as $key => $value){
			if($value == "." || $value == ".." || $value == "index.html"){
				unset($all_controllers[$key]);				
			}
			else{			
				$all_controllers[$key] = substr($value,0,-4);
			}
		}
		$all_controllers = array_values($all_controllers);
		$all_controllers[] = '';
		
		return $all_controllers	;
	}

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}