<?php
defined('_JEXEC') or die('Restricted Access');
$message=JRequest::getString('message','','post');
echo $message;