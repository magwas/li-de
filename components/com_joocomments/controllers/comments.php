<?php
/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JooCommentsControllerComments extends JooCommentsController {

	function __construct($default = array()) {
		parent::__construct ( $default );
		require_once JPATH_SITE.DS.'components'.DS.'com_joocomments'.DS.'captcha'.DS.'JooCaptcha.php';
		require_once JPATH_SITE.DS.'components'.DS.'com_joocomments'.DS.'helpers'.DS.'JooHelper.php';
		$this->registerTask('postComment','postComment');
		//$this->registerTask('checkCaptcha', 'invalid');
	}

	function showcaptcha(){
		$captcha = new JooCaptcha();
		$app= JFactory::getApplication();
		$params= $app->getParams();
		$backgroundColor=$params->get( 'captcha_background_color', 'FFFFFF' );
		$foregraoundColor=$params->get( 'captcha_foreground_color', 3 );
		
		$captcha->CaptchaSecurityImages(100,30,6,hex2RGB($backgroundColor),hex2RGB($foregraoundColor));
		die();
	}
	function checkCaptcha(){
		$captcha = new JooCaptcha();	
		$code=htmlentities(JRequest::getString('userCaptcha'));
		$text=$captcha->check($code);
		$document =& JFactory::getDocument();
		echo $text;
		$captcha->destroy();
		die();
	}
	function showComments(){
	//$model = & $this->getModel ('comments');
	//$article_id=JRequest::getInt('article_id',null,'post');
	//$comments=$model->retriveComments($article_id);
	//$view=$this->getView();
	//echo $view;
	parent::display();
	/*
		// Get the document object.
		$document =& JFactory::getDocument();
		// Set the MIME type for JSON output.
		$document->setMimeEncoding( 'application/json' );
		// Change the suggested filename.
		JResponse::setHeader( 'Content-Disposition', 'attachment; filename="'.$this->getName().'.json"' );
		// Output the JSON data.
		$commentsList['comments']=$comments;
		echo json_encode( $commentsList );*/
		die();

	}
	function postComment(){
		JRequest::checkToken() or die(JText::sprintf('COM_JOOCOOMENTS_COMMENTS_FORM_EXPIRED_TIME'));
		$document =& JFactory::getDocument();
		$user =& JFactory::getUser();
		$model = & $this->getModel ('comments');
		$post['name']=htmlentities(JRequest::getString( 'userName',null,'post',JREQUEST_ALLOWHTML), ENT_QUOTES, "UTF-8");
		$post['email']=htmlentities(JRequest::getString('userEmail',null,'post',JREQUEST_ALLOWHTML), ENT_QUOTES, "UTF-8");
		$post['website']=htmlentities(JRequest::getString('userWebsite',null,'post',JREQUEST_ALLOWHTML), ENT_QUOTES, "UTF-8");
		$post['article_id']=htmlentities(JRequest::getInt('article_id',null,'post'), ENT_QUOTES, "UTF-8");
		// removed unnecessary field$post['article_title']=htmlentities(JRequest::getString('article_title',null,'post',JREQUEST_ALLOWHTML),ENT_QUOTES, "UTF-8");
		$post['comment']=htmlentities(JRequest::getString('userComment',null,'post',JREQUEST_ALLOWHTML),ENT_NOQUOTES, "UTF-8");
		$post['publish_date']= date("Y-m-d H:i:s");
		$app= JFactory::getApplication();
		$params= $app->getParams();
		$isAutoApprove=$params->get( 'autoapprove_administrator', '1' );
		if($isAutoApprove==0 || ($isAutoApprove==2 && !$user->guest)){
		$post['published']='1';
		}else{
			$post['published']='0';
		}
		$isEmail=$params->get( 'email_administrator_notification', '0' );
		if($isEmail==1){
			include_once(dirname(__FILE__).DS.'..'.DS.'helpers'.DS.'markdown.php');
			$o = JFactory::getMailer();
			$o->setSender(array($app->getCfg('mailfrom'), $app->getCfg('fromname')));
            $recipientCSV=$params->get( 'email_administrator_value', '' );
			//$sre='abhiram_mishra@aol.in,bullraider@gmx.com';
			$recipientArray=explode(',', $recipientCSV);
			$o->addRecipient($recipientArray);
			$article_title=$model->retriveArticleDetails($post['article_id']);
			
			
			$mailBody='<b>Article title: </b>'.$article_title[0]['title'] .'<br/>'.
                                  '<b>Commentator:</b>'.$post['name'].'<br/>'.
                                  '<b>Commentator Email:</b>'.$post['email'].'<br/>'.
			          '<b>Comment :</b>'.Markdown($post['comment']);
					  
			$o->setBody($mailBody);
			if($isAutoApprove==0 || ($isAutoApprove==2 && !$user->guest)){
			$o->setSubject(JText::_('COM_JOOCOOMENTS_MAIL_SUBJECT_NEW_AUTO_APPROVED_COMMENT'));
			}else{
			$o->setSubject(JText::_('COM_JOOCOOMENTS_MAIL_SUBJECT_NEW_COMMENT_WAITING'));	
			}
			$o->IsHTML(true);
			// The ob_get_contents() function and the ob_end_clean() function is 
			// a work around to prevent the error messages generated from 
			
			$send=& $o->Send();
			$output = ob_get_contents();
			if(isset($output)){
			JLog::add($article_title,JLog::CRITICAL,'com_joocomments');
			}
			ob_end_clean();
		}
		
		$model->store($post);
		echo JText::sprintf('COM_JOOCOOMENTS_COMMENTS_FORM_SUCCESSFUL_SUBMIT');
		die();
	}
}?>
