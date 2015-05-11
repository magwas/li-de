<?php

defined('_JEXEC') or die('Restricted access');

class JooCommentsControllerMail extends JController{
	function send()
	{
		$extension = 'com_mailto';
		$lang =& JFactory::getLanguage();
		$base_dir = JPATH_SITE;
		$language_tag = 'en-GB';
		$lang->load($extension, $base_dir, $language_tag, true);

		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$app	= JFactory::getApplication();
		$session = JFactory::getSession();
		$db	= JFactory::getDbo();


		jimport('joomla.mail.helper');

		$SiteName	= $app->getCfg('sitename');
		$MailFrom	= $app->getCfg('mailfrom');
		$FromName	= $app->getCfg('fromname');
		require_once JPATH_COMPONENT.'/helpers/mailto.php';

		// An array of email headers we do not want to allow as input
		$headers = array (	'Content-Type:',
							'MIME-Version:',
							'Content-Transfer-Encoding:',
							'bcc:',
							'cc:');

		// An array of the input fields to scan for injected headers
		$fields = array(
			'mailto',
			'sender',
			'from',
			'subject',
		);

		/*
		 * Here is the meat and potatoes of the header injection test.  We
		 * iterate over the array of form input and check for header strings.
		 * If we find one, send an unauthorized header and die.
		 */
		foreach ($fields as $field)
		{
			foreach ($headers as $header)
			{
				if (strpos($_POST[$field], $header) !== false)
				{
					JError::raiseError(403, '');
				}
			}
		}

		/*
		 * Free up memory
		 */
		unset ($headers, $fields);

		$email				= JRequest::getString('mailto', '', 'post');
		$sender				= JRequest::getString('sender', '', 'post');
		$from				= JRequest::getString('from', '', 'post');
		$subject_default	= JText::sprintf('COM_MAILTO_SENT_BY', $sender);
		$subject			= JRequest::getString('subject', $subject_default, 'post');

		// Check for a valid to address
		$error	= false;
		if (! $email  || ! JMailHelper::isEmailAddress($email))
		{
			$error	= JText::sprintf('COM_MAILTO_EMAIL_INVALID', $email);
			JError::raiseWarning(0, $error);
		}

		// Check for a valid from address
		if (! $from || ! JMailHelper::isEmailAddress($from))
		{
			$error	= JText::sprintf('COM_MAILTO_EMAIL_INVALID', $from);
			JError::raiseWarning(0, $error);
		}
		// Build the message to send
				$msg	=JRequest::getString('text_field', '', 'post');
		$body	= sprintf($msg, $SiteName, $sender, $from);

		// Clean the email data
		$subject = JMailHelper::cleanSubject($subject);
		$body	 = JMailHelper::cleanBody($body);
		$sender	 = JMailHelper::cleanAddress($sender);

		// Send the email
		if (JUtility::sendMail($from, $sender, $email, $subject, $body) !== true)
		{       JLog::add('Some problem in sending ',JLog::CRITICAL,'com_joocomments');
			JError::raiseNotice(500, JText:: _ ('COM_MAILTO_EMAIL_NOT_SENT'));
		}else{
			JRequest::setVar('message','Mail successfully send','post');
		}

		JRequest::setVar('view','mail');
		$this->display();
	}
}