<?php

// No direct access

// system li-de plugin

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemLi_de extends JPlugin
{
	
    /**
     * Constructor.
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

	public function onAfterInitialise() {
		if (JRequest::getVar('option') == '') {
		  //$fp = fopen('debug.txt','w+');
		  //fwrite($fp, $_SERVER['REQUEST_URI']);
		  //fclose($fp);
		  
			$w = explode('/',$_SERVER['REQUEST_URI']);
			$i = 0;
			while ($i < count($w)) {
				if ($w[$i] == 'SU') {
					JRequest::setVar('option','com_'.$w[$i+1]);
					JRequest::setVar('view',$w[$i+2]);
					JRequest::setVar('task',$w[$i+3]);
					JRequest::setVar('temakor',$w[$i+4]);
					JRequest::setVar('szavazas',$w[$i+5]);
					JRequest::setVar('limit',$w[$i+6]);
					JRequest::setVar('limitstart',$w[$i+7]);
					JRequest::setVar('order',$w[$i+8]);
					JRequest::setVar('filterStr',urldecode($w[$i+9]));
					JRequest::setVar('Itemid',888);
					$i = count($w); // kil�p a ciklusb�l 	
				}
				$i = $i + 1;
			}
		}
		if (JRequest::getVar('limit')=='') JRequest::setVar('limit',20);
	}
   
}

// glob�lisan haszn�lhat� saj�t rutinok

/**
  * t�voli szolg�ltat�s h�v�s
  * @param string url
  * @param string 'GET' vagy 'POST'
  * @param array data  param�terek ["n�v" => "�rt�k",....]
  * @param string extra header sor (elhagyhat�)
  * @return string
*/
function remoteCall($url,$method,$data,$extraHeader='') {
	$result = '';
	if ($extraHeader != '') {
		$extraHeader .= "\r\n";
	}	
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n".$extraHeader,
			'method'=> $method,
			'content' => http_build_query($data)
	    )
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	return $result;
}


/**
  * get avatar
  * @return string  html img tag
  * @param integer user.id
*/  
function getAvatar($userId,$size=100) {
	$noImage = JURI::base().'images/stories/noavatar.jpg';
	if ($userId <= 0) {
		$result = $noImage;
	} else {
		$user = JFactory::getUser($userId);
		if ($user->id <= 0) {
			$result = $noImage;
		} else {
			$result = 'http://www.gravatar.com/avatar/'.md5($user->email).'?s='.$size.'&d=blank';
		}
	}
	return '<img src="'.$result.'" />';
}

/**
  * utf8 substr html entity -ket nem v�g f�lbe
*/  
function utf8Substr($str,$start,$length) {
	$s = trim(strip_tags($str));
    $s = html_entity_decode($s, ENT_COMPAT, 'UTF-8');
	$s = str_replace('&nbsp;',' ',$s);
	$origLength = mb_strlen($s);
    if (($origLength > $length) | ($start != 0)) {
		$s = mb_substr($s,$start,$length);
		$i = mb_strlen($s);
		while (($i > 1) & 
			   (mb_substr($s,$i,1) != ' ') & 
			   (mb_substr($s,$i,1) != ',') & 
			   (mb_substr($s,$i,1) != '-') & 
			   (mb_substr($s,$i,1) != '.')) {
		   $i--;
		}		   
		$s = mb_substr($s,0,$i);	   
	}
	if (mb_strlen($s) < $origLength) $s .= '...';
	return $s;
}

/**
  * K�p kiemel�se le�r�s sz�vegb�l
  * @param string leir�s sz�veg
  * @return string  image url
*/  
function kepLeirasbol($leiras) {
	  $noImage = JURI::base().'images/stories/noimage.png';
	  // img tag kiemel�se
	  $matches = Array();
	  preg_match('/<img[^>]+>/i', $leiras, $matches);
	  if (count($matches) > 0) {
		  $img = $matches[0];
		  // src attributum kiemel�se
		  preg_match('/src="[^"]+"/i', $img, $matches);
		  if (count($matches) > 0) {
			$src = $matches[0];
		  } else {
			$src = $noImage;  
		  }	
	  } else {
		  $src = $noImage;	
	  }
	  $src = str_replace('src=','',$src);
	  $src = str_replace('robitc/','192.168.0.12/',$src);
	  return str_replace('"','',$src);
}

