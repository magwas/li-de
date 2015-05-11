<?php
  defined('_JEXEC') or die('Restricted access');

  function AmprojectBuildRoute( &$query )
  {
    $segments = array();

    if (isset($query['view'])) {
		$segments[0] = $query['view'];
  		unset($query['view']);
  	};

    if (isset($query['id'])) {
 			$segments[1] = $query['id'];
  		unset($query['id']);
  	};

    return $segments;
  } // End AmprojectBuildRoute function
  
  function AmprojectParseRoute( $segments )
  {
    $vars = array();
    
    if (count($segments) > 0) {

  		$vars['view'] = $segments[0];
      switch ($vars['view']) {
        case 'all':
      		$catid = explode(':', $segments[1]);
      		$vars['catid']= (int) $catid[0];
			break;
        case 'category':
      		$vars['id']   = (int) $segments[1];
			break;
        case 'condition':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'events':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'product':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'project':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'resurce':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'task':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'taskshema':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'worker':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'workflow':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'resourcetype':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;
        case 'wfshema':
      		$id   = explode(':', $segments[1]);      		
      		$vars['id']= (int) $id[0];        
			break;

      };
      
    } else {
      $vars['view'] = $segments[0];
    } // End count(segments) statement

    return $vars;
  } // End AmprojectParseRoute

?>
