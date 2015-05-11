<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Temakorok
* @subpackage 	Controllers
* @copyright	Copyright (C) 2014, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Variant Controller
 *
 * @package    
 * @subpackage Controllers
 */
class TemakorokController extends JControllerLegacy {
  protected $NAME='temakorok';
	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_temakorok";
  protected $temakorokHelper = null;
  protected $helper = null;
  protected $model = null;
  protected $view = null;
	/**
	 * Constructor
	 */
	public function __construct($config = array ()) {
		parent :: __construct($config);
    if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 
    
    // általánosan használt helper
    if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php')) {
      include JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php';
      $this->temakorokHelper = new TemakorokHelper();
    }
    
    // saját helper
    //if (file_exists(JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php')) {
    //  include JPATH_COMPONENT.DS.'helpers'.DS.'temakorok.php';
    //  $this->helper = new TemakorokHelper();
    //}

		$document =& JFactory::getDocument();
		$viewType	= $document->getType();
		$this->view = $this->getView($this->_viewname,$viewType);
		$this->model = $this->getModel($this->_mainmodel);
		$this->view->setModel($this->model,true);		
		JRequest :: setVar('view', $this->_viewname);
    
    // szükséges táblák létrehozása
    $db = JFactory::getDBO();
    $db->setQuery('CREATE TABLE IF NOT EXISTS `#__temakorok` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT "téma egyedi azonosító",
    `megnevezes` varchar(120) COLLATE utf8_hungarian_ci NOT NULL COMMENT "téma megnevezése",
    `leiras` text COLLATE utf8_hungarian_ci NOT NULL COMMENT "téma leírása",
    `lathatosag` int(2) NOT NULL DEFAULT 0 COMMENT "0-mindenki, 1-regisztraltak, 2-téma tagok",
    `szavazok` int(2) NOT NULL DEFAULT 1 COMMENT "1-regisztraltak, 2-téma tagok",
    `szavazasinditok` int(2) NOT NULL DEFAULT 1 COMMENT "1-regisztraltak, 2 -téma tagok, 3-téma adminok",
    `allapot` int(2) NOT NULL DEFAULT 0 COMMENT "0-aktiv, 1 - lezárt",
    `letrehozo` int(11) NOT NULL COMMENT "user_id",
    `letrehozva` datetime NOT NULL COMMENT "létrehozás időpontja",
    `lezaro` int(11) NOT NULL COMMENT "user_id",
    `lezarva` datetime NOT NULL COMMENT "lezárás időpontja",
     PRIMARY KEY (`id`)
     )
     ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__kepviselok (
      user_id integer NOT NULL,
      kepviselo_id integer NOT NULL,
      temakor_id integer NOT NULL COMMENT "ha 0 akkor álltalános képviselő",
      szavazas_id integer NOT NULL COMMENT "ha 0 akkor témakör vagy álltalános képviselő",
      lejarat date COMMENT "eddig érvényes a megbizás",
      KEY `user_id_i` (`user_id`),
      KEY `kepviselo_id_i` (`kepviselo_id`),
      KEY `temakor_id_i` (`temakor_id`),
      KEY `szavazas_id_i` (`szavazas_id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__kepviselojeloltek (
      user_id integer NOT NULL,
      temakor_id integer NOT NULL COMMENT "ha 0 akkor álltalános képviseletet vállal",
      szavazas_id integer NOT NULL COMMENT "ha 0 akkor témakör képviseletet vagy álltalános képviseletet vállal",
      leiras text NOT NULL,
      KEY `user_id_i` (`user_id`),
      KEY `temakor_id_i` (`temakor_id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__beallitasok (
      id integer NOT NULL auto_increment,
      temakor_felvivo integer NOT NULL COMMENT "1-regisztráltak, 2-adminok",
      PRIMARY KEY (`id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__szavazasok (
      id integer NOT NULL auto_increment,
      temakor_id integer NOT NULL ,
      megnevezes varchar(120) NOT NULL COMMENT "Szavazás megnevezése",
      leiras text NOT NULL COMMENT "Szavazás leírása",
      titkos integer NOT NULL COMMENT "0-nyilt, 1-titkos, 2-szigoruan titkos",
      szavazok integer NOT NULL COMMENT "1-regisztráltak, 2-téma tagok",
      alternativajavaslok integer NOT NULL COMMENT "10-szavazok, 11-indito és adminok",
      vita1_vege date NOT NULL COMMENT "alternativa javaslati vita határidő",
      vita2_vege date NOT NULL COMMENT "részletes vita hattáridő",
      szavazas_vege date NOT NULL COMMENT "szavazás vég határidő",
      vita1 integer NOT NULL COMMENT "0-nem ebben az állapotban van, 1-ebben az állapotban van",
      vita2 integer NOT NULL COMMENT "0-nem ebben az állapotban van, 1-ebben az állapotban van",
      szavazas integer NOT NULL COMMENT "0-nem ebben az állapotban van, 1-ebben az állapotban van",
      lezart integer NOT NULL COMMENT "0-nem, 1-igen",
      letrehozo integer NOT NULL COMMENT "user-id",
      letrehozva date NOT NULL COMMENT "létrehozás időpontja",
      PRIMARY KEY (`id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__alternativak (
      id integer NOT NULL auto_increment,
      temakor_id integer not NULL,
      szavazas_id integer NOT NULL ,
      megnevezes varchar(120) NOT NULL COMMENT "Alternativa megnevezése",
      leiras text NOT NULL COMMENT "Alternatíva leírása",
      letrehozo integer NOT NULL COMMENT "user-id",
      letrehozva date NOT NULL COMMENT "létrehozás időpontja",
      PRIMARY KEY (`id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__szavazok (
      id integer NOT NULL auto_increment,
      temakor_id integer not NULL COMMENT "témakör azonosító",
      szavazas_id integer NOT NULL COMMENT "szavazás azonosító",
      user_id integer NOT NULL COMMENT "szavazó user_id ha nyilvános",
      idopont datetime COMMENT "szavazás időpontja",
      PRIMARY KEY (`id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__szavazatok (
      id integer NOT NULL auto_increment,
      temakor_id integer not NULL COMMENT "témakör azonosító",
      szavazas_id integer NOT NULL COMMENT "szavazás azonosító",
      szavazo_id integer NOT NULL COMMENT "szavaó azonosító a concorde-shulze kiértékeléshez",
      user_id integer NOT NULL COMMENT "Ha nyilt szavazás a szavazó user_id -je",
      alternativa_id integer NOT NULL COMMENT "alternativa azonositó",
      pozicio integer NOT NULL COMMENT "ebbe a pozicióba sorolta az adott alternativát",
      PRIMARY KEY (`id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
    $db->setQuery('create table if not exists #__tagok (
      id integer NOT NULL auto_increment,
      temakor_id integer not NULL COMMENT "témakör azonosító",
      user_id integer NOT NULL COMMENT "Ha nyilt szavazás a szavazó user_id -je",
      admin integer COMMENT "0-nem, 1-igen",
      PRIMARY KEY (`id`)
    )
    ');
    if ($db->query()==false) $db->stderr();
	}
  /**
   * kik a témakör felvivők?
   * @return integer 1- regisztráltak, 2-adminok
   */         
  private function temakor_felvivo() {
    // kik a témakor felvivők?
    $result = 1;
    $db = JFactory::getDBO();
    $db->setQuery('select * from #__beallitasok where id = 1');
    $res = $db->loadObject();
    if ($res) $result = $res->temakor_felvivo;
    return $result;
  }
  /**
   * default display function
   */      
	public function display() {
		$this->view->display();
	}
	/**
	 * browse task
	 * @return void
	 * @request integer limit
	 * @request integer limitstart
	 * @request integer order
	 * @request integer filterStr
	 * @session object 'temakoroklist_status'   
	 */                     
  public function browse() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $total = 0;
    $pagination = null;
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // alapértelmezett browser status beolvasása sessionból
    $session = JFactory::getSession();
    $brStatusStr = $session->get($this->NAME.'list_status');
    if ($brStatusStr == '') {
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":""}';
    }
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    $session->set($this->NAME.'list_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitstart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    
   
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    $this->view->set('Items',$items);
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr);
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1');
    $itemLink =
       JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&order='.JRequest::getVar('order','1');
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    
    // van ált. képviselője?
    $kepviseloje = 0;
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$user->id.'" and k.temakor_id=0 and k.szavazas_id = 0 and
            k.lejarat >= "'.date('Y-m-d').'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $kepviseloje = $res->kepviselo_id;
    }
    
    // Ő maga képviselő jelölt?
    $kepviseloJelolt = false;
    $db->setQuery('select user_id 
    from #__kepviselojeloltek
    where  user_id = "'.$user->id.'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $kepviseloJelolt = true;
    }
    
    // kik a témakor felvivők?
    $temakor_felvivo = $this->temakor_felvivo();

    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($temakor_felvivo == 1) & ($user->id > 0))
       ) {
      $akciok['ujTemakor'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=add';
    }  
    if ($this->temakorokHelper->isAdmin($user)) {  
      $akciok['beallitasok'] = JURI::base().'index.php?option=com_beallitasok';
    }
    $akciok['tagok'] = JURI::base().'index.php?option=com_tagok';
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_(strtoupper($this->NAME).'LIST_SUGO').'&Itemid=435&tmpl=component';
    $this->view->set('Akciok',$akciok);
   
    // globális képviselő/képviselő jelölt gombok definiálása
    $kepviselo = array();
    $kepviselo['kepviselojeLink'] = '';
    $kepviselo['kepviseloJeloltLink'] = '';
    $kepviselo['kepviselotValasztLink'] = '';
    $kepviselo['ujJeloltLink'] = '';
    if ($user->id > 0) {
      if ($kepviseloje > 0) {
        $kepviseloUser = JFactory::getUser($kepviseloje);
        if ($kepviseloUser) {
          $userEx = HsUser::getInstance($kepviseloje);
          $kepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&task=show&id='.$kepviseloje;
          if (isset($userEx->image))
  				 $kepviselo['image'] = $userEx->get('image');
          else
  				 $kepviselo['image'] = '<img src="components/com_hs_users/asset/images/noimage.png" width="50" height="50" />';
          $kepviselo['nev'] = $kepviseloUser->name;
        }  
      } else if ($kepviseloJelolt) {
        $kepviselo['kepviseloJeloltLink'] = JURI::base().'index.php?option=com_kepviselo&task=edit&id='.$user->id;
      } else {
        $kepviselo['kepviselotValasztLink'] = JURI::base().'index.php?option=com_kepviselok&task=find&temekor=0&szavazas=0';
        $kepviselo['ujJeloltLink'] =  JURI::base().'index.php?option=com_kepviselojeloltek&task=add&temekor=0&szavazas=0&id='.$user->id;
      }
    }
    $this->view->set('Kepviselo',$kepviselo);
    
    //lapozósor definiálása
    jimport( 'joomla.html.pagination' );    
    $total = $this->model->getTotal($filterStr);
    $pagination = new JPagination($total, $limitStart, $limit);
    $pagination->setAdditionalUrlParam('order',$order);
    $pagination->setAdditionalUrlParam('filterStr',urlencode($filterStr));
    $this->view->set('Lapozosor', $pagination->getListFooter());
    $this->view->display();
  } // browse task
  /**
   * szürés start
   * @JRequests: limit, limitstart, filterStr, order
   * @return void      
   */      
  public function dofilter() {
     JRequest::setVar('limitstart','0');
     $this->browse();
  }
  /**
   * felvivő képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order
   * @return void
   */
  public function add() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // kik a témakor felvivők?
    $temakor_felvivo = $this->temakor_felvivo();

    if ($this->temakorokHelper->isAdmin($user) | 
        (($temakor_felvivo == 1) & ($user->id > 0))
       ) {
      $item = $this->model->getItem(0);
      $this->view->set('Item',$item);
      $this->view->set('Title', JText::_('UJTEMAKOR'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('UJTEMAKOR_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // add task
  /**
   * módosító képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order, temakor
   * @return void
   */
  public function edit() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__temakorok where id="'.JRequest::getVar('temakor').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_TEMAKOR_ID').':'.JRequest::getVar('temakor').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user) | 
        ($res->letrehozo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('temakor'));
      $this->view->set('Item',$item);
      $this->view->set('Title', JText::_('TEMAKORMODOSITAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('TEMAKORMODOSITAS_SUGO').'&Itemid=435&tmpl=component';
      $akciok['delete'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=deleteform'.
           '&temakor='.$item->id;
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // edit task
  /**
   * delete képernyő kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order, temakor
   * @return voin
   */
  public function deleteform() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__temakorok where id="'.JRequest::getVar('temakor').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_TEMAKOR_ID').':'.JRequest::getVar('temakor').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('temakor'));
      $this->view->set('Item',$item);
      $this->view->set('Title', JText::_('TEMAKORTORLES'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=delete'.
         '&temakor='.$item->id;
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('TEMAKORTORLES_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('delete');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // deleteform task
  
  /**
   * save a POST -ban lévő adatokból
   * @JRequest dataform   
   * @return void   
   */      
  public function save()	{
    // Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    // kik a témakor felvivők?
    $temakor_felvivo = $this->temakor_felvivo();

    if ($this->temakorokHelper->isAdmin($user) | 
        (($temakor_felvivo == 1) & ($user->id > 0) & JRequest::getVar('id') == 0) |
        (($user->id == JRequest::getVar('felvivo') & (JRequest::getVar('id') > 0)))
        ) {
      $item = $this->model->bind($_POST);
  		if ($this->model->store($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
        '&filterStr='.urlencode($filterStr).
        '&order='.$order;
        $this->setMessage(JText::_('TEMAKORTAROLVA'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
    		$this->view->setModel($this->model,true);
        $this->view->Msg = $this->model->getError();
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJTEMAKOR'));
        } else {
           $this->view->set('Title', JText::_('TEMAKORMODOSITAS'));
        }   
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJTEMAKOR_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('TEMAKORMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
        $this->view->set('Akciok',$akciok);
      
        // form megjelenités
        $this->view->setLayout('form');
        $this->view->display();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // save task        
  /**
   * delete task
   * @JRequest limit,limitstart,order, filterStr, temakor
   * @return void      
   */      
  public function delete()	{
    // Check for request forgeries
		JRequest :: checkToken() or jexit('Invalid Token');
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('temakor'));
      if ($item == fase) {
         echo '<div class="errorMsg">'.JText::_('WRONG_TEMAKOR_ID').':'.JRequest::getVar('temakor').'</div>';
         return;
      }
      if ($this->model->delete($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0';
        $this->setMessage(JText::_('TEMAKORTOROLVE'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0';
        $this->setMessage($this->model->getError());
        $this->setRedirect($link);
        $this->redirect();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // delete task
}// class
  
?>