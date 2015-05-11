<?php
/**
* @version		$Id:controller.php  1 2014-04-04Z FT $
* @package		Szavazasok
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
class SzavazasokController extends JControllerLegacy {
  protected $NAME='szavazasok';
	protected $_viewname = 'item';
	protected $_mainmodel = 'item';
	protected $_itemname = 'Item';    
	protected $_context = "com_temakorok";
  protected $temakorokHelper = null;
  protected $temakor_id = 0;
  protected $temakor = null;
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
    $this->temakor_id = JRequest::getVar('temakor','0');
    $db = JFactory::getDBO();
    $db->setQuery('select * from #__temakorok where id="'.$this->temakor_id.'"');
    $this->temakor = $db->loadObject();
    
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
   * kik a szavazás felvivők?
   * @return integer 1- regisztráltak, 2-téma tagok, 3-adminok
   */         
  private function szavazas_felvivo() {
    $result = $this->temakor->szavazasinditok;
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
   * a megadott étmakörnek ez a user az inditója?
   */      
  private function temakorIndito($temakor_id,$user) {
    return (($user->id == $this->temakor->felvivo) & ($user->id > 0));
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
      $brStatusStr = '{"limit":20,"limitstart":0,"order":1,"filterStr":"|1"}';
    }
    $brStatus = JSON_decode($brStatus);
    
    $limitStart = JRequest::getVar('limitstart',$brStatus->limitstart);
    $limit = JRequest::getVar('limit',$brStatus->limit);
    $order = JRequest::getVar('order',$brStatus->order);
    $filterStr = urldecode(JRequest::getVar('filterStr',$brStatus->filterStr));
    if ($this->temakor_id=='') $this->temakor_id = $brStatus->temakor_id;
    
    // browser status save to session and JRequest
    $brStatus->limit = $limit;
    $brStatus->limitStart = $limitStart;
    $brStatus->order = $order;
    $brStatus->filterStr = $filterStr;
    $brStatus->temakor_id = $this->temakor_id;
    $session->set($this->NAME.'list_status', JSON_encode($brStatus));
    JRequest::setVar('limit',$limit);
    JRequest::setVar('limitstart',$limitstart);
    JRequest::setVar('order',$order);
    JRequest::setVar('filterStr',$filterStr);
    JRequest::setVar('temakor',$this->temakor_id);
    // adattábla tartalom elérése és átadása a view -nek
    $items = $this->model->getItems();
    
    //DBG echo $this->model->getDBO()->getQuery();
    
    if ($this->model->getError() != '')
      $this->view->Msg = $this->model->getError();
    $this->view->set('Items',$items);
    $this->view->set('Temakor',$this->temakor);
    $this->view->set('Title',JText::_('SZAVAZASOK'));
    
    // browser müködéshez linkek definiálása
    $reorderLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&temakor='.$this->temakor_id;
    $doFilterLink =
       JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    $itemLink =
       JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
       '&task=browse'.
       '&limit='.JRequest::getVar('limit','20').'&limitstart=0'.
       '&filterStr='.urlencode($filterStr).
       '&order='.JRequest::getVar('order','1').
       '&temakor='.$this->temakor_id;
    $backLink =
       JURI::base().'index.php?option=com_temakorok&view=temakoroklist'.
       '&task=browse';
    $temakorLink =
       JURI::base().'index.php?option=com_temakorok&view=temakorok'.
       '&task=show&remakor='.$this->temakor_id;
       
    $this->view->set('reorderLink',$reorderLink);
    $this->view->set('doFilterLink',$doFilterLink);
    $this->view->set('itemLink',$itemLink);
    $this->view->set('backLink',$backLink);
    $this->view->set('temakorLink',$temakorLink);
   
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
    
    // kik a szavazaás felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    // akciók definiálása
    $akciok = array();
    if ($this->temakorokHelper->isAdmin($user) | 
        (($szavazas_felvivo == 1) & ($user->id > 0)) |
        (($szavazas_felvivo == 2) & ($this->userTag($this->temakor_id,$user)))
       ) {
      if ($this->temakor->allapot == 0) { 
        $akciok['ujSzavazas'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=add'.
         '&temakor='.$this->temakor_id.
         '&limit='.JRequest::getVar('limit',20).
         '&limitstart='.JRequest::getVar('limitstart',0).
         '&order='.JRequest::getVar('order',1).
         '&filterStr='.JRequest::getVar('filterStr','');
      }   
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
        $kepviselo['kepviseloJeloltLink'] = JURI::base().'index.php?option=com_kepviselo&task=edit&id='.$user->id.'&temakor='.$this->temakor_id;
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

    // kik a témakor felvivők?
    $szavazas_felvivo = $this->szavazas_felvivo();

    if ($this->temakorokHelper->isAdmin($user) | 
        (($szavazas_felvivo == 1) & ($user->id > 0)) |
        ((szavazas_felvivo == 2) & ($this->userTag($this->temakor_id,$user)))
       ) {
      $item = $this->model->getItem(0);
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $item->szavazok = $this->temakor->szavazok;
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('UJSZAVAZAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
                          '&temakor='.$this->temakor_id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('UJSZAVAZAS_SUGO').'&Itemid=435&tmpl=component'; 
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
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == false) {
       echo '<div class="errorMsg">'.JText::_('WRONG_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user) | 
        ($res->felvivo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      
      //DBG foreach ($item as $fn => $fv) echo '<p>controller->item '.$fn.'='.$fv.'</p>';
      
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZASMODOSITAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
            '&temakor='.$this->temakor_id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZASMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // edit task
  /**
   * szavazás adatlap kirajzoéása
   * @JRequests: limit, limitstart, filterStr, order, temakor
   * @return void
   */
  public function __show() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRONG_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user) | 
        ($res->felvivo == $user->id)
       ) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZASMODOSITAS'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['szavazok'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=szavazok'.
              '&temakor='.$this->temakor.
              '&szavazas='.$JRequest::getVar('szavazas');
      $akciok['eredmeny'] = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=eredmeny'.
              '&temakor='.$this->temakor.
              '&szavazas='.$JRequest::getVar('szavazas');
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list';
      $akciok['cancel2'] = JURI::base().'index.php?option=com_temakorok&view=temakoroklist';
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZASADATLAP_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      $this->view->setLayout('form');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // showt task
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
    $db->setQuery('select felvivo from #__temakorok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == fase) {
       echo '<div class="errorMsg">'.JText::_('WRON_TEMAKOR_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    if ($this->temakorokHelper->isAdmin($user)) {
      $item = $this->model->getItem(JRequest::getVar('szavazas'));
      if ($this->model->getError() != '')
         $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZASTORLES'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=delete';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
         'temakor='.$tihis->temakor->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZASTORLES_SUGO').'&Itemid=435&tmpl=component'; 
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
    $szavazas_felvivo = $this->szavazas_felvivo();

    if ($this->temakorokHelper->isAdmin($user) | 
        (($szavazas_felvivo == 1) & ($user->id > 0) & JRequest::getVar('id') == 0) |
        (($user->id == JRequest::getVar('felvivo') & (JRequest::getVar('id') > 0)))
        ) {
      $item = $this->model->bind($_POST);
  		if ($this->model->store($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limit='.JRequest::getVar('limit','20').
        '&limitstart='.JRequest::getVar('limitstart').
        '&filterStr='.urlencode(JRequest::getVar('filterStr')).
        '&temakor='.urlencode(JRequest::getVar('temakor')).
        '&order='.JRequest::getVar('order');
        $this->setMessage(JText::_('SZAVAZASTAROLVA'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
    		$this->view->setModel($this->model,true);
        $this->view->Msg = $this->model->getError();
        $this->view->set('Item',$item);
        if ($item->id == 0) {
           $this->view->set('Title', JText::_('UJSZAVAZAS'));
        } else {
           $this->view->set('Title', JText::_('SZAVAZASMODOSITAS'));
        }   
        // akciok definiálása
        $akciok = array();
        $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=save';
        $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
           '&temakor='.$this->temakor_id;
        if ($item->id == 0)
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('UJSZAVAZAS_SUGO').'&Itemid=435&tmpl=component'; 
        else
          $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                            '&id='.JText::_('SZAVAZASMODOSITAS_SUGO').'&Itemid=435&tmpl=component'; 
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
      $item = $this->model->load(JRequest::getVar('szavazas'));
      if ($item == fase) {
         echo '<div class="errorMsg">'.JText::_('WRON_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
         return;
      }
      if ($this->model->delete($item)) {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor_id;
        $this->setMessage(JText::_('SZAVAZASTOROLVE'));
        $this->setRedirect($link);
        $this->redirect();
      } else {
        $link =
        JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
        '&limitstart=0&temakor='.$this->temakor_id;
        $this->setMessage($this->model->getError());
        $this->setRedirect($link);
        $this->redirect();
      }
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  } // delete task
  /**
   * szavazás leadása
   */     
  public function szavazoform() {
    jimport('hs.user.user');
    JHTML::_('behavior.modal'); 
    $user = JFactory::getUser();
    if ($user->id == 0) {
       echo '<div class="errorMsg">'.JText::_('NOT_LOGGED').'</div>';
       return;
    }
    $db = JFactory::getDBO();
    $db->setQuery('select letrehozo from #__szavazasok where id="'.JRequest::getVar('szavazas').'"');
    $res = $db->loadObject();
    if ($res == false) {
       echo '<div class="errorMsg">'.JText::_('WRONG_SZAVAZAS_ID').':'.JRequest::getVar('szavazas').'</div>';
       return;
    }
    // szavazott már?
    $db->setQuery('select * 
    from #__szavazok 
    where szavazas_id='.JRequest::getVar('szavazas').' and user_id='.$user->id);
    $res = $db->loadObejctList();    
    if (count($res) > 0) {
       echo '<div class="errorMsg">'.JText::_('MARSZAVAZTAL').'</div>';
       return;
    }
    $item = $this->model->getItem(JRequest::getVar('szavazas'));
    if ($item->szavazas == 1) {
      if ($this->model->getError() != '')
        $this->view->Msg = $this->model->getError();
      $this->view->set('Item',$item);
      $this->view->set('Temakor',$this->temakor);
      $this->view->set('Title', JText::_('SZAVAZOK'));
      
      // akciok definiálása
      $akciok = array();
      $akciok['ok'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'&task=szavazassave';
      $akciok['cancel'] = JURI::base().'index.php?option=com_'.$this->NAME.'&view='.$this->NAME.'list'.
         '&temakor='.$this->temakor->id.'&szavazas='.$item->id;
      $akciok['sugo'] = JURI::base().'index.php?option=com_content&view=article'.
                        '&id='.JText::_('SZAVAZOK_SUGO').'&Itemid=435&tmpl=component'; 
      $this->view->set('Akciok',$akciok);
      
      // form megjelenités
      
      $this->view->setLayout('szavazok');
      $this->view->display();
    } else {
      echo '<div class="errorMsg">Access denied</div>';
    }
  }
  /**
   * eredmény megtekintése
   */      
  public function eredmeny() {
    $db = JFactory::getDBO();
    $temakor_id = JRequest::getVar('temakor','0');
    $szavazas_id = JRequest::getVar('szavazas','0');
    $this->view->set('Temakor_id',$temakor_id);
    $this->view->set('Szavazas_id',$szavazas_id);
    $this->view->setLayout('values');
    $this->view->display();
  
  }
  /**
   * szavazás eredmény tárolása
   * Session: szavazas_secret              
   * JRequest: temakor, szavazas, nick, 'szavazas_secret', pos##,....
   *      ahol ## az alternativák id -je
   */
   public function szavazassave() {
     $db = JFactory::getDBO();
     $temakor_id = JRequest::getVar('temakor','0');
     $szavazas_id = JRequest::getVar('szavazas','0');
     $nick = JRequest::getvar('nick');
     $user = JFactory::getUser();
     $session = JFactory::getSession();
     if ($user->id == 0) {
       echo '<div class="errorMsg">Not loged in.</div>
       ';
       return;
     }
     if ($user->username != $nick) {
       echo '<div class="errorMsg">Wrong user</div>';
       return;
     }
     $szavazas_secret = $session->get('szavazas_secret','@@@');
     if (JRequest::getVar($szavazas_secret,'0') != 1) {
       echo '<h2 class="error">Wrong secret key</h2>';
       return;
     }
     // begin transaction, lock tables
     $db->setQuery('start transaction');
     if (!$db->query()) {
       echo '<h2 class="error">Error in save vote (0). Pleas try again</h2>';
       return;
     };
     $db->setQuery('lock tables #__szavazatok write,
                                #__szavazok write,
                                #__szavazasok read,
                                #__kepviselok read,
                                #__alternativak read');
     if (!$db->query()) {
       $db->setQuery('rollback');
       $db->query();
       echo '<h2 class="errorMsg">Error in save vote (1). Pleas try again</h2>';
       return;
     };
     
     // szavazas rekord beolvasása
     $db->setQuery('select * from #__szavazasok where id='.$szavazas_id);
     $szavazas = $db->loadObject();
     if ($szavazas->szavazas != 1) {
         $db->setQuery('unlock tables');
         $db->query();
         $db->setQuery('rollback');
         $db->query();
         echo '<h2 class="errorMsg">Wrong status '.$szavazas->megnevezes.'</h2>';
         return;
     }
     // user témakör képviselő vagy általános képviselő?
     $db->setQuery('select * from #__kepviselok 
     where kepviselo_id='.$user->id.' and
           (temakor_id='.$temakor_id.' or temakor_id = 0)
     ');
     $res = $db->loadObjectList();
     $kepviselo = (count($res) > 0);
     // szavazott már?
     $db->setQuery('select * from #__szavazok where szavazas_id='.$szavazas_id.' and user_id='.$user->id);
     $res = $db->loadObjectList();
     if (count($res)>0) {
         $db->setQuery('unlock tables');
         $db->query();
         $db->setQuery('rollback');
         $db->query();
         echo '<h2 class="errorMsg">Alredy voted</h2>';
         return;
     }
     if (JRequest::getVar($szavazas_secret,'0') == 1) {
        $db->setQuery('select * from #__alternativak where szavazas_id='.$szavazas_id);
        $alternativak = $db->loadObjectList();
        if (($szavazas->titkos == 0) |
            (($szavazas->titkos == 1) and ($kepviselo)))
            $user_id = $user->id;
        else
            $user_id = 0;     
        // szavazo_id képzése
        $db->setQuery('select max(szavazo_id) szavazo_id from #__szavazatok');
        $res = $db->loadObjectList();
        $szavazo_id = $res->szavazo_id + 1;
        // írás a szavazatok táblába
        foreach ($alternativak as $alternativa) {
          $pozicio = JRequest::getVar('pos'.$alternativa->id,0);
          $db->setQuery('insert into #__szavazatok 
            	(`temakor_id`,`szavazas_id`,`szavazo_id`,`user_id`,`alternativa_id`,`pozicio`	)
            	values
            	("'.$temakor_id.'", 
            	 "'.$szavazas_id.'", 
            	 "'.$szavazo_id.'", 
            	 "'.$user_id.'", 
            	 "'.$alternativa->id.'", 
            	 "'.$pozicio.'");
           ');
           if (!$db->query()) {
                 $db->setQuery('unlock tables');
                 $db->query();
                 $db->setQuery('rollback');
                 $db->query();
                 echo '<h2 class="errorMsg">Error in save vote (3). Pleas try again</h2>';
                 return;
           }
        }
        // szavazok táblába írás
        $db->setQuery('INSERT INTO #__szavazok 
          	(`temakor_id`,`szavazas_id`,`user_id`,`idopont`)
          	VALUES
          	('.$temakor_id.', 
          	'.$szavazas_id.', 
          	'.$user->id.', 
          	"'.date('Y-m-d H:i:s').'");
        ');
        if (!$db->query()) {
                 $db->setQuery('unlock tables');
                 $db->query();
                 $db->setQuery('rollback');
                 $db->query();
                 echo '<h2 class="errorMsg">Error in save vote (4). Pleas try again</h2>';
                 return;
        }
        // unlock, commit
        $db->setQuery('unlock tables');
        $db->query();
        $db->setQuery('commit');
        $db->query();
        $this->setMessage(JText::_('SZAVAZATTAROLVA'));
        $this->setRedirect(JURI::base().'index.php?option=com_alternativak&view=alternativaklist'.
          '&temakor='.$temakor_id.
          '&szavazas='.$szavazas_id);
        $this->redirect();
     } else {
       echo '<div class="errorMsg">Access denied wrong secret_key.</div>
       ';
       return;
     }
   }      
}// class
  
?>