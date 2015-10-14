<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerUsermanagement extends EcommercewdController {
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
    public function register() {
        if (WDFHelper::is_user_logged_in() == true) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('useraccount', '&tmpl=component', 'displayuseraccount');
            else
                WDFHelper::redirect('useraccount', 'displayuseraccount');
        }
		
        // get validated registration data (and captcha) from request
        $registration_data = $this->get_user_data_from_post(true);

        $app = JFactory::getApplication();

        $user_params = JComponentHelper::getParams('com_users');
        $useractivation = $user_params->get('useractivation');

        $j_user = new JUser;

        // add needed activation data to registration data, insert into JUser object
        if (($useractivation == 1) || ($useractivation == 2)) {
            $registration_data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
            $registration_data['block'] = 1;
        }

        // insert user data into table
        $is_registered = false;
        if (($j_user->bind($registration_data) == false) || ($j_user->save() == false)) {
            $app->enqueueMessage(WDFText::get('ERROR_FAILED_TO_REGISTER_USER') . ' :: ' . $j_user->getError(), 'error');
        } else {
            $is_registered = true;
            $registration_data['j_user_id'] = $j_user->id;
            $app->enqueueMessage(WDFText::get('MSG_SUCCESSFULLY_REGISTERED'), 'message');

            $this->send_registration_mails($j_user);

            $row_user = WDFDb::get_table_instance('users');
            if (($row_user->bind($registration_data) == false) || ($row_user->store() == false)) {
                $app->enqueueMessage(WDFText::get('MSG_REGISTRATION_FAILED') . ' :: ' . $row_user->getError());
            }
        }

        // goto login page with check your mail message if successful or back to registration page
        $task = $is_registered == true ? 'displaylogin' : 'displayregister';
        WDFHelper::redirect('usermanagement', $task, '' );
    }

    public function activate() {
        if (WDFHelper::is_user_logged_in() == true) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('useraccount', 'displayuseraccount', '&tmpl=component');
            else
                WDFHelper::redirect('useraccount', 'displayuseraccount');
        }

        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        //get activation code and unblock user
        $activation_code = WDFInput::get('activation');
        $query->clear();
        $query->select('id');
        $query->from('#__users');
        $query->where('activation = ' . $db->quote($activation_code));
        $query->where('lastvisitDate = ' . $db->quote($db->getNullDate()));
        $db->setQuery($query);
        $j_user_id = $db->loadResult();
        if ($j_user_id == null) {
            $app->enqueueMessage(WDFText::get('MSG_YOU_ARE_NOT_REGISTERED'), 'warning');
        } else {
            $j_user = JFactory::getUser($j_user_id);
            $j_user->set('activation', '');
            $j_user->set('block', '0');
            if (!$j_user->save()) {
                $app->enqueueMessage(WDFText::get('MSG_ACTIVATION_FAILED'), 'error');
            } else {
                $app->enqueueMessage(WDFText::get('MSG_ACTIVATION_COMPLETED'), 'message');
            }
        }

        //goto login page with activation completed message
        WDFHelper::redirect('usermanagement', 'displaylogin');
    }

    public function login() {
        if (WDFHelper::is_user_logged_in() == true) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('useraccount', 'displayuseraccount', '&tmpl=component');
            else
                WDFHelper::redirect('useraccount', 'displayuseraccount');
        }

        $app = JFactory::getApplication();

        $username = WDFInput::get('username');
        $password = WDFInput::get('password');
        $remember = WDFInput::get('remember', false, 'bool') == true ? true : false;
        $redirect_url = WDFInput::get('redirect_url', WDFUrl::get_referer_url());	


        $options = array();
        $options['remember'] = $remember;

        $credentials = array();
        $credentials['username'] = $username;
        $credentials['password'] = $password;
		$task = WDFInput::get_task();
		
        if ($app->login($credentials, $options) === true) {
            $app->setUserState('users.login.form.data', array());
			$this->add_guest_user_products();
			$this->check_cart();
			$this->remove_unavailable_products();
            if ($redirect_url != '' ) {
				if(WDFInput::get('option') == 'com_'.WDFHelper::get_com_name() && WDFHelper::is_admin() == false){
					$app->redirect(base64_decode($redirect_url));									 
				} else {
					WDFHelper::redirect('useraccount', 'displayuseraccount');
				}
		
			}
		}
		else {
			WDFHelper::redirect('usermanagement', 'displaylogin', '', 'redirect_url=' . $redirect_url);
		}
		
	}	

    public function updateuserdata() {
        if (WDFHelper::is_user_logged_in() == false) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('usermanagement', 'displaylogin', '&tmpl=component', '', WDFText::get('MSG_LOG_IN_FIRST'), 'message');
            else
                WDFHelper::redirect('usermanagement', 'displaylogin', '', '', WDFText::get('MSG_LOG_IN_FIRST'), 'message');
        }

        // get validated user data from request
        $user_data = $this->get_user_data_from_post(false);

        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $options = WDFHelper::get_model('options')->get_options();

        // update joomla user data
        $j_user = JFactory::getUser();
        $name = $user_data['first_name'];
        $name .= $user_data['middle_name'] != '' ? ' ' . $user_data['middle_name'] : '';
        $name .= $user_data['last_name'] != '' ? ' ' . $user_data['last_name'] : '';
        $j_user->name = $name;
        $j_user->email = $user_data['email'];
        if ($j_user->save() == false) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_UPDATE_USER_DATA') . ' :: ' . $j_user->getError(), 'error');
        } else {
            // update user data, insert new row if user row doesn't exist
            $row_user = WDFDb::get_row('users', $db->quoteName('j_user_id') . ' = ' . $j_user->id);
            $row_user = WDFDb::get_row_by_id('users', $row_user->id);

            $row_user->j_user_id = $j_user->id;

            $row_user->first_name = $user_data['first_name'];
            if ($options->user_data_middle_name > 0) {
                $row_user->middle_name = $user_data['middle_name'];
            }
            if ($options->user_data_last_name > 0) {
                $row_user->last_name = $user_data['last_name'];
            }
            if ($options->user_data_company > 0) {
                $row_user->company = $user_data['company'];
            }
            if ($options->user_data_country > 0) {
                $row_user->country_id = $user_data['country_id'];
            }
            if ($options->user_data_state > 0) {
                $row_user->state = $user_data['state'];
            }
            if ($options->user_data_city > 0) {
                $row_user->city = $user_data['city'];
            }
            if ($options->user_data_address > 0) {
                $row_user->address = $user_data['address'];
            }
            if ($options->user_data_mobile > 0) {
                $row_user->mobile = $user_data['mobile'];
            }
            if ($options->user_data_phone > 0) {
                $row_user->phone = $user_data['phone'];
            }
            if ($options->user_data_fax > 0) {
                $row_user->fax = $user_data['fax'];
            }
            if ($options->user_data_zip_code > 0) {
                $row_user->zip_code = $user_data['zip_code'];
            }

            if ($row_user->store()) {
                $app->enqueueMessage(WDFText::get('MSG_USER_DATA_UPDATED'), 'message');
            } else {
                $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_UPDATE_USER_DATA') . ' :: ' . $row_user->getError(), 'error');
            }
        }

        // goto update data page(with message)
        WDFHelper::redirect('usermanagement', 'displayupdateuserdata');
    }

    public function logout() {
		$app = JFactory::getApplication();
        if (WDFHelper::is_user_logged_in() == false) {  
            WDFHelper::redirect('usermanagement', 'displaylogin', '', 'redirect_url=' . WDFInput::get('redirect_url', WDFUrl::get_referer_url()), WDFText::get('MSG_LOG_IN_FIRST'), 'message');
        }

        JFactory::getApplication()->logout();

        $redirect_url = WDFInput::get('redirect_url', WDFUrl::get_referer_url());
		if(WDFInput::get('option') == 'com_'.WDFHelper::get_com_name() && WDFHelper::is_admin() == false && $redirect_url != '' ){
			$app->redirect(base64_decode($redirect_url));									 
		} else {
			WDFHelper::redirect('usermanagement', 'displaylogin', '', 'redirect_url=' . $redirect_url);
		}
    }

    public function displayregister() {
        if (WDFHelper::is_user_logged_in() == true) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('useraccount', '&tmpl=component', 'displayuseraccount');
            else
                WDFHelper::redirect('useraccount', 'displayuseraccount');
        }

        parent::display();
    }

    public function displayactivationsuccess() {
        parent::display();
    }

    public function displayactivationfailed() {
        parent::display();
    }

    public function displaylogin() {
        if (WDFHelper::is_user_logged_in() == true) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('useraccount', '&tmpl=component', 'displayuseraccount');
            else
                WDFHelper::redirect('useraccount', 'displayuseraccount');
        }

        parent::display();
    }

    public function displayupdateuserdata() {
        if (WDFHelper::is_user_logged_in() == false) {
            if(WDFInput::get('type'))
                WDFHelper::redirect('usermanagement', 'displaylogin', '&tmpl=component', '', WDFText::get('MSG_LOG_IN_FIRST'), 'message');
            else
                WDFHelper::redirect('usermanagement', 'displaylogin', '', '', WDFText::get('MSG_LOG_IN_FIRST'), 'message');
        }

        parent::display();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_user_data_from_post($is_registration) {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $params = JComponentHelper::getParams('com_users');
        $options = WDFHelper::get_model('options')->get_options();

        // key_values to return if there are invalid fields
        $return_key_values = array();
        $invalid_fields = array();
        $data = array();

        if ($is_registration == true) {
            // check captcha
            $use_captcha = $options->registration_captcha_use_captcha;
            if ($use_captcha == true) {
                $captcha_private_key = $options->registration_captcha_private_key;
                $captcha_response = WDFInput::get('recaptcha_response_field');
                $is_captcha_correct = WDFRecaptchaHelper::check_captcha($captcha_private_key, $captcha_response);
                if ($is_captcha_correct == false) {
                    $app->enqueueMessage(WDFText::get('MSG_INVALID_CAPTCHA'), 'error');
                }
            }

            // check username
            $username = WDFInput::get('username');
            if ((trim(WDFInput::get('username')) == '') || (preg_match('#[<>"\'%;()&]#i', $username) !== 0) || (strlen(utf8_decode($username)) < 2)) {
                $invalid_fields[] = 'username';
                $app->enqueueMessage(WDFText::get('MSG_INVALID_USERNAME'), 'error');
            } else {
                // check for existing username
                $query->clear();
                $query->select('id');
                $query->from('#__users');
                $query->where('username = ' . $db->quote($username));
                $db->setQuery($query);
                $j_user_id = (int)$db->loadResult();
                if ($j_user_id != 0) {
                    $invalid_fields[] = 'username';
                    $app->enqueueMessage(WDFText::get('MSG_USERNAME_IN_USE'), 'error');
                } else {
                    $data['username'] = $username;
                    $return_key_values[] = 'username=' . $username;
                }
            }

            // check password
            $password = WDFInput::get('password');
            if (trim($password) == '') {
                $invalid_fields[] = 'password';
                $invalid_fields[] = 'confirm_password';
                $app->enqueueMessage(WDFText::get('MSG_INVALID_PASSWORD'), 'error');
            } else {
                $data['password'] = $password;
            }

            // add joomla user to 'Registered' users group after registration
            $data['groups'] = array();
            $system = $params->get('new_usertype', 2);
            $data['groups'][] = $system;

            // add user to wd shop default users group after registration
            $query->clear();
            $query->select('id');
            $query->from('#__ecommercewd_usergroups');
            $query->where($db->quoteName('default') . ' = 1');
            $db->setQuery($query);
            $data['usergroup_id'] = $db->loadResult();

            if ($db->getErrorNum()) {
                $app->enqueueMessage(WDFText::get('MSG_REGISTRATION_FAILED'));
                WDFHelper::redirect('usermanagement', 'displayregister');
            }
        }

        $data['name'] = '';

        // check first name
        $first_name = WDFInput::get('first_name');
      
        if (trim($first_name) == '') {
            $invalid_fields[] = 'first_name';
        } else {
            $data['first_name'] = $first_name;
            $return_key_values[] = 'first_name=' . $first_name;
            $data['name'] = $data['first_name'];
        }

        // check middle name
        $middle_name = WDFInput::get('middle_name');
        if (($options->user_data_middle_name == 2) && (trim($middle_name) == '')) {
            $invalid_fields[] = 'middle_name';
        } else {
            $data['middle_name'] = $middle_name;
            $return_key_values[] = 'middle_name=' . $middle_name;
            $data['name'] .= $data['middle_name'] == '' ? '' : ' ' . $data['middle_name'];
        }

        // check last name
        $last_name = WDFInput::get('last_name');
        if (($options->user_data_last_name == 2) && (trim($last_name) == '')) {
            $invalid_fields[] = 'last_name';
        } else {
            $data['last_name'] = $last_name;
            $return_key_values[] = 'last_name=' . $last_name;
            $data['name'] .= $data['last_name'] == '' ? '' : ' ' . $data['last_name'];
        }
		
		// check email
		$email = WDFInput::get('email');
		if ((trim($email) == '') || (JMailHelper::isEmailAddress($email) == false)) {
			$invalid_fields[] = 'email';
			$return_key_values[] = 'email=' . $email;
			$app->enqueueMessage(WDFText::get('MSG_INVALID_EMAIL'), 'error');
		} elseif($is_registration == true) {
			// check for existing email
			$query->clear();
			$query->select($db->quoteName('id'));
			$query->from($db->quoteName('#__users'));
			$query->where($db->quoteName('email') . ' = ' . $db->quote($email));
			$db->setQuery($query);
			$j_user_id = (int)$db->loadResult();
			if ($j_user_id != 0) {
				$invalid_fields[] = 'email';
				$return_key_values[] = 'email=' . $email;
				$app->enqueueMessage(WDFText::get('MSG_EMAIL_IN_USE'), 'error');
			} else {
				$data['email'] = $email;
				$return_key_values[] = 'email=' . $email;
			}
		}
		else{
			$data['email'] = $email;
			$return_key_values[] = 'email=' . $email;
		}		

        // check company
        $company = WDFInput::get('company');
        if (($options->user_data_company == 2) && (trim($company) == '')) {
            $invalid_fields[] = 'company';
        } else {
            $data['company'] = $company;
            $return_key_values[] = 'company=' . $company;
        }

        // check country
        $row_country = WDFDb::get_row_by_id('countries', WDFInput::get('country_id', 0, 'int'));
        $country_id = $row_country != null ? $row_country->id : 0;
        if (($options->user_data_country == 2) && ($country_id == 0)) {
            $invalid_fields[] = 'country_id';
        } else {
            $data['country_id'] = $country_id;
            $return_key_values[] = 'country_id=' . $country_id;
        }

        // check state
        $state = WDFInput::get('state');
        if (($options->user_data_state == 2) && (trim($state) == '')) {
            $invalid_fields[] = 'state';
        } else {
            $data['state'] = $state;
            $return_key_values[] = 'state=' . $state;
        }

        // check city
        $city = WDFInput::get('city');
        if (($options->user_data_city == 2) && (trim($city) == '')) {
            $invalid_fields[] = 'city';
        } else {
            $data['city'] = $city;
            $return_key_values[] = 'city=' . $city;
        }

        // check address
        $address = WDFInput::get('address');
        if (($options->user_data_address == 2) && (trim($address) == '')) {
            $invalid_fields[] = 'address';
        } else {
            $data['address'] = $address;
            $return_key_values[] = 'address=' . $address;
        }

        // check mobile
        $mobile = WDFInput::get('mobile');
        if (($options->user_data_mobile == 2) && (trim($mobile) == '')) {
            $invalid_fields[] = 'mobile';
        } else {
            $data['mobile'] = $mobile;
            $return_key_values[] = 'mobile=' . $mobile;
        }

        // check phone
        $phone = WDFInput::get('phone');
        if (($options->user_data_phone == 2) && (trim($phone) == '')) {
            $invalid_fields[] = 'phone';
        } else {
            $data['phone'] = $phone;
            $return_key_values[] = 'phone=' . $phone;
        }

        // check fax
        $fax = WDFInput::get('fax');
        if (($options->user_data_fax == 2) && (trim($fax) == '')) {
            $invalid_fields[] = 'fax';
        } else {
            $data['fax'] = $fax;
            $return_key_values[] = 'fax=' . $fax;
        }

        // check zip_code
        $zip_code = WDFInput::get('zip_code');
        if (($options->user_data_zip_code == 2) && (trim($zip_code) == '')) {
            $invalid_fields[] = 'zip_code';
        } else {
            $data['zip_code'] = $zip_code;
            $return_key_values[] = 'zip_code=' . $zip_code;
        }

        if (count($invalid_fields) > 0) {
            $msg = WDFText::get('MSG_FILL_REQUIRED_FIELDS');
            $task = $is_registration == true ? 'displayregister' : 'displayupdateuserdata';
            WDFHelper::redirect('usermanagement', $task, '', implode('&', $return_key_values) . '&invalid_fields=' . implode(',', $invalid_fields), $msg, 'error');
        } elseif (($is_registration == true) && ($use_captcha == true) && ($is_captcha_correct == false)) {
            WDFHelper::redirect('usermanagement', 'displayregister', '', implode('&', $return_key_values));
        }

        return $data;
    }

    private function send_registration_mails($user) {
        $app = JFactory::getApplication();

        $joomla_config = JFactory::getConfig();
        $j_user_params = JComponentHelper::getParams('com_users');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        // get admin email
        $admin_email = $options->registration_administrator_email;

        //activation params
        $useractivation = $j_user_params->get('useractivation');
        $sendpassword = $j_user_params->get('sendpassword', 1);

        $mail_data = $user->getProperties();
        $mail_data['mailfrom'] = JMailHelper::isEmailAddress($admin_email) == true ? $admin_email : $joomla_config->get('mailfrom');
        $mail_data['sitename'] = $joomla_config->get('sitename');
        $mail_data['siteurl'] = JUri::root();

        $mail_data['subject'] = WDFText::get('EMAIL_ACCOUNT_DETAILS', $mail_data['name'], $mail_data['sitename']);
        if ($useractivation == 2) {
            if ($sendpassword) {
                $mail_data['body'] = WDFText::get('EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY', $mail_data['name'], $mail_data['sitename'], $mail_data['siteurl'] . 'index.php?option=com_users&task=registration.activate&token=' . $mail_data['activation'], $mail_data['siteurl'], $mail_data['username'], $mail_data['password_clear']);
            } else {
                $mail_data['body'] = WDFText::get('EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW', $mail_data['name'], $mail_data['sitename'], $mail_data['siteurl'] . 'index.php?option=com_users&task=registration.activate&token=' . $mail_data['activation'], $mail_data['siteurl'], $mail_data['username']);
            }
        } elseif ($useractivation == 1) {
            if ($sendpassword) {
                $mail_data['body'] = WDFText::get('EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $mail_data['name'], $mail_data['sitename'], $mail_data['siteurl'] . 'index.php?option=com_users&task=registration.activate&token=' . $mail_data['activation'], $mail_data['siteurl'], $mail_data['username'], $mail_data['password_clear']);
            } else {
                $mail_data['body'] = WDFText::get('EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW', $mail_data['name'], $mail_data['sitename'], $mail_data['siteurl'] . 'index.php?option=com_users&task=registration.activate&token=' . $mail_data['activation'], $mail_data['siteurl'], $mail_data['username']);
            }
        } else {
            $mail_data['body'] = WDFText::get('EMAIL_REGISTERED_BODY', $mail_data['name'], $mail_data['sitename'], $mail_data['siteurl']);
        }


        //send mail to user
        $is_mail_to_user_sent = WDFMail::send_mail($mail_data['mailfrom'], $mail_data['email'], $mail_data['subject'], $mail_data['body']);
        if ($is_mail_to_user_sent == true) {
            $app->enqueueMessage(WDFText::get('MSG_REGISTRATION_MAIL_SENT'), 'message');
        } else {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SEND_REGISTRATION_MAIL'), 'warning');
        }

        //send mail to admins
        if (($j_user_params->get('useractivation') < 2) && ($j_user_params->get('mail_to_admin') == 1)) {
            $mail_data['body_admin'] = WDFText::get('EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY', $mail_data['name'], $mail_data['username'], $mail_data['siteurl'], $is_mail_to_user_sent == true ? WDFText::get('YES') : WDFText::get('NO'));

            $query->clear();
            $query->select('name');
            $query->select('email');
            $query->select('sendEmail');
            $query->from('#__users');
            $query->where('sendEmail = 1');
            $db->setQuery($query);
            $admin_rows = $db->loadObjectList();

            foreach ($admin_rows as $admin_row) {
                WDFMail::send_mail($mail_data['mailfrom'], $admin_row->email, $mail_data['subject'], $mail_data['body_admin']);
            }
        }
    }
	
	private function add_guest_user_products() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        // get order product ids with new rows
        $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');

        $query->clear();
        $query->select('id');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('order_id = 0');
        $query->where('j_user_id = 0');
        if (empty($order_product_rand_ids) == false) {
            $query->where('rand_id IN (' . implode(',', $order_product_rand_ids) . ')');
        } else {
            $query->where(0);
        }
        $db->setQuery($query);
        $new_order_product_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            $app->enqueueMessage('Failed to add your products to the cart');
            return false;
        }

        // add new products to users shopping cart
        $query->clear();
        $query->update('#__ecommercewd_orderproducts');
        $query->set('j_user_id = ' . $j_user->id);
        if (empty($new_order_product_ids) == false) {
            $query->where('id IN (' . implode(',', $new_order_product_ids) . ')');
        } else {
            $query->where(0);
        }
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_ADD_GUEST_PRODUCTS'));
            return false;
        }

        if (empty($new_order_product_ids) == false) {
            $app->enqueueMessage(WDFText::get('MSG_GUEST_PRODUCTS_ADDED'), 'message');
        }

        // get merged products rand ids
        if (empty($new_order_product_ids) == false) {
            $query->clear();
            $query->select('rand_id');
            $query->from('#__ecommercewd_orderproducts');
            $query->where('id IN (' . implode(',', $new_order_product_ids) . ')');
            $db->setQuery($query);
            $merged_order_product_rand_ids = $db->loadColumn();

            if ($db->getErrorNum()) {
                // TODO:
            }
        } else {
            $merged_order_product_rand_ids = array();
        }

        // remove merged order products ids from cookies
        $oreder_product_rand_ids_left = array_diff($order_product_rand_ids, $merged_order_product_rand_ids);
        $oreder_product_rand_ids_left = array_values($oreder_product_rand_ids_left);
        WDFInput::cookie_set_array('order_product_rand_ids', $oreder_product_rand_ids_left);

        return true;
    }
	
	private function check_cart(){
	
	    $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        // get user product ids
        $query->clear();
        $query->select('id');
        $query->select('product_id');
        $query->select('product_count');
        $query->select('product_name');
        $query->select('product_parameters');
        $query->from('#__ecommercewd_orderproducts');
        $query->where('j_user_id = ' . $j_user->id);
        $query->where('order_id = 0');
        $db->setQuery($query);
        $user_order_products = $db->loadObjectList();

        if ($db->getErrorNum()) {          
            return false;
        }
		
		$selected_order_products = array();
		for( $i=0; $i<count($user_order_products); $i++ ){
			$user_order_product = $user_order_products[$i];
			for($j=$i+1; $j<count($user_order_products); $j++ ){
				$_user_order_product = $user_order_products[$j];
				if( $user_order_product->product_id == $_user_order_product->product_id ){					
					$parameters = WDFHelperFunctions::object_to_array(WDFJson::decode($user_order_product->product_parameters));					
					$_parameters = WDFHelperFunctions::object_to_array(WDFJson::decode($_user_order_product->product_parameters));
					if( count($parameters) != count($_parameters)){
						continue;
					}
					else{						
						$parameters = array_combine(array_map(function($k){ $k= explode('_',$k) ;return $k[0]; }, array_keys($parameters)) , $parameters);				
						$_parameters = array_combine(array_map(function($k){ $k= explode('_',$k) ;return $k[0]; }, array_keys($_parameters)) , $_parameters);					
						if(WDFHelperFunctions::multidimensional_array_diff($parameters,$_parameters) == array() && array_diff(array_keys($parameters),array_keys($_parameters)) == array()){							
							$selected_order_products[$user_order_product->product_id] = array( 'product_count' => ($_user_order_product->product_count + $user_order_product->product_count), 'parameters' => $parameters, '_row_parameters' =>$_user_order_product->product_parameters, 'row_parameters' =>$user_order_product->product_parameters,'product_name'=>$user_order_product->product_name);
						}
					}
				}			
			}		
		}
		
		foreach($selected_order_products as $product_id => $order_product_data){
			$query->clear();
			$query->delete();
			$query->from('#__ecommercewd_orderproducts');
			$query->where('product_id = ' . $product_id);
			$query->where('order_id = 0');
			$query->where("(product_parameters = '" . $order_product_data['_row_parameters'] ."' OR product_parameters = '". $order_product_data['row_parameters'] ."')");
			$db->setQuery($query);
			$db->Query();
			
		   if (!$db->getErrorNum()) {
			
				// insert new order product row
				$query->clear();
				$query->insert('#__ecommercewd_orderproducts');
				$columns = array( 'j_user_id', 'user_ip_address', 'product_id', 'product_name', 'product_count');
				$query->columns($db->quoteName($columns));
				$query_values = array();
				$query_values[] = WDFHelper::is_user_logged_in() == true ? $j_user->id : 0;
				$query_values[] = $db->quote(WDFUtils::get_client_ip_address());
				$query_values[] = $product_id;
				$query_values[] =  $order_product_data['product_name'];
				$query_values[] = $order_product_data['product_count'];
				$query_values = WDFDb::array_quote($query_values);
				$query->values(implode(',', $query_values));
				$db->setQuery($query);
				$db->query();
				
				$query->clear();
				$query->select('MAX(id)');
				$query->from('#__ecommercewd_orderproducts');
				$db->setQuery($query);
				$order_product_id = $db->loadResult();
				
				// insert parameters
				$new_parameters = $order_product_data['parameters'];
				$new_keys = array();
				$new_values = array();
				foreach ($new_parameters as $parameter_key => $product_parameter) {
					$new_keys[] = $parameter_key . '_' . $order_product_id;
					$new_values[] = $product_parameter;
				}
				$new_parameters = array_combine($new_keys, $new_values);
				

				$query->clear();
				$query->update('#__ecommercewd_orderproducts');
				$query->set("product_parameters='" . WDFJson::encode($new_parameters) . "'");
				$query->where('id = ' . $order_product_id);
				$db->setQuery($query);
				$db->query();				
							
			}
			
		}

	}
	
	
    private function remove_unavailable_products() {
        $app = JFactory::getApplication();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();

        $guest_order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');

        // get user unavailable order products
        $query->clear();
        $query->select('T_ORDER_PRODUCTS.id');
        $query->select('T_ORDER_PRODUCTS.rand_id');
        $query->select('T_ORDER_PRODUCTS.product_name');
        $query->from('#__ecommercewd_orderproducts AS T_ORDER_PRODUCTS');
        $query->leftJoin('#__ecommercewd_products AS T_PRODUCTS ON T_ORDER_PRODUCTS.product_id = T_PRODUCTS.id');
        $query->where('T_ORDER_PRODUCTS.order_id = 0');
        $query->where('(T_PRODUCTS.id IS NULL OR T_PRODUCTS.published = 0)');
        if (WDFHelper::is_user_logged_in() == true) {
            $query->where('T_ORDER_PRODUCTS.j_user_id = ' . $j_user->id);
        } else {
            if (empty($guest_order_product_ids) == false) {
                $query->where('T_ORDER_PRODUCTS.j_user_id = 0');
                $query->where('T_ORDER_PRODUCTS.rand_id IN (' . implode(',', $guest_order_product_rand_ids) . ')');
            } else {
                $query->where('0');
            }
        }
        $db->setQuery($query);
        $unavailable_products_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        $unavailable_ids = array();
        $unavailable_rand_ids = array();
        $unavailable_products_names = array();
        foreach ($unavailable_products_rows as $row_unavailable_product) {
            $unavailable_ids[] = $row_unavailable_product->id;
            $unavailable_rand_ids[] = $row_unavailable_product->rand_id;
            $unavailable_products_names[] = $row_unavailable_product->product_name;
        }

        //remove unavailable order product
        if (empty($unavailable_ids) == false) {
            $query->clear();
            $query->delete();
            $query->from('#__ecommercewd_orderproducts');
            $query->where('id IN (' . implode(',', $unavailable_ids) . ')');
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
            }

            if (WDFHelper::is_user_logged_in() == false) {
                $guest_order_product_rand_ids = array_diff($guest_order_product_rand_ids, $unavailable_rand_ids);
                $guest_order_product_rand_ids = array_values($guest_order_product_rand_ids);
                WDFInput::cookie_set_array('order_product_rand_ids', $guest_order_product_rand_ids);
            }

            $app->enqueueMessage(WDFText::get('MSG_PRODUCTS_NO_LONGER_AVAILABLE') . ': ' . implode(', ', $unavailable_products_names), 'info');
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}