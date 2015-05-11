<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Alternativak
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
class AlternativakController extends JControllerLegacy {
  protected $NAME='alternativak';
	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_alternativak";
  protected $temakorokHelper = null;
  protected $temakor_id = 0;
  protected $szavazas_id = 0;
  protected $temakor = null;
  protected $szavazas = null;
  protected $helper = null;
  protected $model = null;
  protected $view = null;
	/**
	 * Constructor
	 */
	public function __construct($config = array ()) {
		parent::__construct($config);
    if(isset($config['viewname'])) $this->_viewname = $config['viewname'];
		if(isset($config['mainmodel'])) $this->_mainmodel = $config['mainmodel'];
		if(isset($config['itemname'])) $this->_itemname = $config['itemname']; 
    $this->temakor_id = JRequest::getVar('temakor','0');
    $this->szavazas_id = JRequest::getVar('szavazas','0');
    $db = JFactory::getDBO();
    $db->setQuery('select * from #__temakorok where id="'.$this->temakor_id.'"');
    $this->temakor = $db->loadObject();
    $db->setQuery('select * from #__szavazasok where id="'.$this->szavazas_id.'"');
    $this->szavazas = $db->loadObject();
    
    // általánosan használt helper
    if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php')) {
      include JPATH_ROOT.DS.'components'.DS.'com_temakorok'.DS.'helpers'.DS.'temakorok.php';
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
	}
  /**
   * kik az alternativa felvivők?
   * @return integer 1- regisztráltak, 2-téma tagok, 3-adminok
   */         
  private function alternativa_felvivo() {
    $result = $this->szavazas->alternativajavaslok;
    return $result;
  }
  /**
   * a megadott étmakörnek tagja a megadott user?
   *  TEST VERZIÓ   
   */      
  private function userTag($temakor_id,$user) {
    if ($user->id > 0) {
      $db = JFactory::getDBO();
      $db->setQuery('select * 
      from #__tagok 
      where temakor_id='.$temakor_id.' and user_id='.$user->id);
      $res = $db->loadObjectList();
    } else {
      $res = array();
    }
    return (count($res)>0);
  }
  /**
   * a megadott témakörnek ez a user az inditója?
   */      
  private function temakorIndito($temakor_id,$user) {
    return (($user->id == $this->temakor->felvivo) & ($user->id > 0));
  }
  /**
   * a megadott szavazásnak ez a user az inditója?
   */      
  private function szavazasIndito($szavazas_id,$user) {
    return (($user->id == $this->szavazas->letrehozo) & ($user->id > 0));
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
	 * @request integer temakor
	 * @request integer szavazas      
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
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"","temakor_id":0,"szavazas_id":0}';
    }
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    if ($this->szavazas_id=='') $this->szavazas_id = $brStatus->szavazas_id;
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    $brStatus->temakor_id = $this->temakor_id;
    $brStatus->szavazas_id = $this->szavazas_id;
    $session->set($this->NAME.'list_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitstart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);
    JRequest::setVar('szavazas',$this->szavazas_id);
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    
    //DBG echo $this->model->getDBO()->getQuery();
    
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
    $this->view->set('Temakor',$this->temakor);
    $this->view->set('Szavazas',$this->szavazas);
    $this->view->set('Title',JText::_('ALTERNATIVAK'));
    
    // browser müködéshez linkek definiálása
    if ($this->szavazas->vita1 == 1) {
      $itemLink =
        JURI::base().'index.php?option=com_alternativak&view=alternativak'.
        '&task=edit'.
        '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
        '&filterStr='.urlencode($filterStr).
        '&order='.JRequest::getVar('order','1').
        '&temakor='.$this->temakor_id.
        '&szavazas='.$this->szavazas_id;
    } else {
      $itemLink = '';
    }    
    $backLink =
       JURI::base().'index.php?option=com_szavazasok&view=szavazasoklist'.
       '&temakor='.$this->temakor_id.'&task=browse';
    $homeLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
       
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('homeLink',$homeLink);
   
    // van ált. képviselője?
    $altKepviseloje = 0;
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$user->id.'" and k.temakor_id=0 and k.szavazas_id = 0 and
            k.lejarat >= "'.date('Y-m-d').'"');
    $res = $db->loadObject();
    if ($db->getErrorNum() > 0) 
       $db->stderr();
    if ($res) {
      $altKepviseloje = $res->kepviselo_id;
    }
    
    // van témakör képviselője?
    $kepviseloje = 0;
    $db->setQuery('select k.kepviselo_id, u.name 
    from #__kepviselok k, #__users u
    where k.kepviselo_id = u.id and
            k.user_id = "'.$user->id.'" and k.temakor_id='.$this->temakor_id.' and k.szavazas_id = 0 and
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
    
    // kik az alternativa felvivők?
    $alternativa_felvivo = $this->alternativa_felvivo();

    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($szavazas_felvivo == 10) & ($this->szavazas->szavazok = 1) & ($user->id > 0)) |
        (($szavazas_felvivo == 10) & ($this->userTag($this->temakor_id,$user))) |
        ($this->szavazasIndito($this->szavazas_id,$user))
       ) {
      if ($this->szavazas->vita1 == 1) { 
        $akciok['ujAlternativa'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=add'.
         '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id.
         '&limit='.JRequest::getVar('limit',20).
         '&limitstart='.JRequest::getVar('limitstart',0).
         '&order='.JRequest::getVar('order',1).
         '&filterStr='.JRequest::getVar('filterStr','');
      }   
    }  

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->szavazas->letrehozo == $user->id)) {  
      $akciok['szavazasedit'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=edit'.
      '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->szavazas->letrehozo == $user->id)) {  
      $akciok['szavazastorles'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=deleteform'.
      '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;;
    }


    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakorIndito($this->temakor_id,$user))) {  
      $akciok['temakoredit'] = JURI::base().'index.php?option=com_temakorok&view=temakorok&task=edit'.
      '&temakor='.$this->temakor_id;
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakorIndito($this->temakor_id,$user))) {  
      $akciok['temakortorles'] = JURI::base().'index.php?option=com_temakorok&view=temakorok&task=deleteform'.
      '&temakor='.$this->temakor_id;
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakorIndito($this->temakor_id,$user))) {
      if ($this->szavazas->vita1 == 1) {    
        $akciok['alternativaedit'] = JURI::base().'index.php?option=com_alternativak&view=alternativak&task=edit'.
        '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
      }  
    }

    if (($this->temakorokHelper->isAdmin($user)) |
        ($this->temakorIndito($this->temakor_id,$user))) {  
      if ($this->szavazas->vita1 == 1) {    
        $akciok['alternativatorles'] = JURI::base().'index.php?option=com_alternativak&view=alternativak&task=deleteform'.
        '&temakor='.$this->temakor_id.'&szavazas='.$this->szavazas_id;
      }  
    }

    if (($this->szavazas->szavazas == 1) & ($user->id > 0)) {
      $db = JFactory::getDBO();
      $db->setQuery('select id from #__szavazatok
      where szavazas_id="'.$this->szavazas_id.'" and
      user_id="'.$user->id.'"');
      $res = $db->loadObjectList();
      if (count($res) == 0) {
        $akciok['szavazok'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=szavazoform&temakor='.$this->temakor_id.
             '&szavazas='.$this->szavazas_id;
      }       
    }
    if ($this->szavazas->lezart == 1) {
      $akciok['eredmeny'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=eredmeny&temakor='.$this->temakor_id.
              '&szavazas='.$this->szavazas_id;
    }          

    $akciok['tagok'] = JURI::base().'index.php?option=com_tagok&temakor='.$this->temakor_id;
    $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                      '&id='.JText::_(strtoupper($this->NAME).'LIST_SUGO').'&Itemid=435&tmpl=component';
    $this->view->set('Akciok',$akciok);
   
    // globális képviselő/képviselő jelölt gombok definiálása
    $altKepviselo = array();
    $altKepviselo['kepviselojeLink'] = '';
    $kepviselo = array();
    $kepviselo['kepviselojeLink'] = '';
    $kepviselo['kepviseloJeloltLink'] = '';
    $kepviselo['kepviselotValasztLink'] = '';
    $kepviselo['ujJeloltLink'] = '';
    
    if ($user->id > 0) {
      if ($altKepviseloje > 0) {
        $kepviseloUser = JFactory::getUser($altKepviseloje);
        if ($kepviseloUser) {
          $userEx = HsUser::getInstance($altKepviseloje);
          $altKepviselo['kepviselojeLink'] = JURI::base().'index.php?option=com_kepviselok&task=show&id='.$altKepviseloje;
          if (isset($userEx->image))
  				 $altKepviselo['image'] = $userEx->get('image');
          else
  				 $altKepviselo['image'] = '<img src="components/com_hs_users/asset/images/noimage.png" width="50" height="50" />';
          $altKepviselo['nev'] = $kepviseloUser->name;
        }  
      }
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
        $kepviselo['kepviselotValasztLink'] = JURI::base().'index.php?option=com_kepviselok&task=find&temekor='.$this->temakor_id.'&szavazas=0';
        $kepviselo['ujJeloltLink'] =  JURI::base().'index.php?option=com_kepviselojeloltek&task=add&temekor='.$this->temakor_id.'&szavazas=0&id='.$user->id;
      }
    }
    $this->view->set('Kepviselo',$kepviselo);
    $this->view->set('AltKepviselo',$altKepviselo);
    
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
     $s = JRequest::getVar('filterKeresendo','').'|'.JRequest::getVar('filterAktiv','0');
     JRequest::setVar('filterStr',$s);
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

    // kik az alternativa felvivők?
    $alternativa_felvivo = $this->alternativa_felvivo();

    if (($this->temakorokHelper->isAdmin($user) | 
         (($szavazas_felvivo == 10) & ($this->szavazas->szavazok = 1) & ($user->id > 0)) |
         (($szavazas_felvivo == 10) & ($this->userTag($this->temakor_id,$user))) |
         ($this->szavazasIndito($this->szavazas-id,$user))
        ) & 
       ($this->szavazas->vita1 == 1) 
       ){ 
      $item = $this->model->getItem(0);
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $item->szavazok = $this->temakor->szavazok;
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Szavazas',$this->szavazas);
      $this->view->set('Title', JText::_('UJALTERNATIVA'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                          '&temakor='.$this->temakor->id.
                          '&szavazas='.$this->szavazas->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('UJALTERNATIVA_SUGO').'&Itemid=435&tmpl=component'; 
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
    $db->setQuery('select letrehozo from #__alternativak where id="'.JRequest::getVar('alternativa').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_ALTERNATIVA_ID').':'.JRequest::getVar('alternativa').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user) | 
        ($res->letrehozo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('alternativa'));
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Szavazas',$this->szavazas);
      $this->view->set('Title', JText::_('ALTERNATIVAMODOSITAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                          '&temakor='.$this->temakor->id.
                          '&szavazas='.$this->szavazas->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('ALTERNATIVAMODOSITAS_SUGO').'&Itemid=435&tmpl=component';
      if ($this->szavazas->vita1==1) {
        $akciok['delete'] = JURI::base().'index.php?option=com_alternativak&view=alternativak'.
             '&temakor='.$this->temakor->id.
             '&szavazas='.$this->szavazas->id.
             '&alternativa='.$item->id.
             '&id='.$item->id;
      }                   
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
    $db->setQuery('select felvivo from #__alternativak where id="'.JRequest::getVar('alternativa').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_ALTERNATIVA_ID').':'.JRequest::getVar('alternativa').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('alternativa'));
      if ($this->model->getError() != '')
         $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Szavazas',$this->szavazas);
      $this->view->set('Title', JText::_('ALTERNATIVATORLES'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=delete';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                                       '&temakor='.$this->temakor->id.
                                       '&szavazas='.$this->szavazas->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('ALTERNATIVATORLES_SUGO').'&Itemid=435&tmpl=component'; 
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

    // kik az alternativa felvivők?
    $alternativa_felvivo = $this->alternativa_felvivo();

    if (($this->temakorokHelper->isAdmin($user) | 
         (($szavazas_felvivo == 10) & ($this->szavazas->szavazok = 1) & ($user->id > 0)) |
         (($szavazas_felvivo == 10) & ($this->userTag($this->temakor_id,$user))) |
         ($this->szavazasIndito($this->szavazas-id,$user))
        ) & 
       ($this->szavazas->vita1 == 1) 
       ){ 
      $item = $this->model->bind($_POST);
  		if ($this->model->store($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limit='.JRequest::getVar('limit','20').
        '&limitstart='.JRequest::getVar('limitstart').
        '&filterStr='.urlencode(JRequest::getVar('filterStr')).
        '&temakor='.urlencode(JRequest::getVar('temakor')).
        '&szavazas='.urlencode(JRequest::getVar('szavazas')).
        '&order='.JRequest::getVar('order');
        $this->setMessage(JText::_('ALTERNATIVATAROLVA'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
    		$this->view->setModel($this->model,true);
        $this->view->Msg = $this->model->getError();
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJALTERNATIVA'));
        } else {
           $this->view->set('Title', JText::_('ALTERNATIVAMODOSITAS'));
        }   
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
          '&temakor='.$this->temakor->id.
          '&szavazas='.$this->szavazas->id;
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJALTERNATIVA_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('ALTERNATIVAMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
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
      $item = $this->model->load(JRequest::getVar('alternativa'));
      if ($item == fase) {
         echo '<div class="errorMsg">'.JText::_('WRONG_ALTERNATIVA_ID').':'.JRequest::getVar('alternativa').'</div>';
         return;
      }
      if ($this->model->delete($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor->id.
        '&szavazas='.$this->szavazas->id;
        $this->setMessage(JText::_('ALTERNATIVATOROLVE'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor->id.
        '&szavazas='.$this->szavazas->id;
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