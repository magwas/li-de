<?php
// no direct access
  defined('_JEXEC') or die('Restricted access');
  JHTML::_('behavior.modal'); 
  JToolBarHelper::title( JText::_('EVENTS'), 'generic.png' );
  JToolBarHelper::preferences('com_amproject', '550');  
?>
<h2><?php echo $this->Item->title.' '.JText::_('PRODUCT'); ?></h2>
<table border="0" width="100%" class="eventsTable">
  <thead>
    <tr>
    <th><?php echo JText::_('TIME'); ?></th>
    <th><?php echo JText::_('TITLE'); ?></th>
    <th><?php echo JText::_('TYPE'); ?></th>
    <th><?php echo JText::_('USER'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($this->Items as $item) {
        $link = JURI::base().'index.php?option=com_amproject&view=events'.
           '&task=edit&id='.$item->id.'&tmpl=component';
        echo '<tr>
                <td><a href="'.$link.'" class="modal" rel="{handler: '."'iframe'".', size: {x: 800, y: 600}}">
                      '.$item->time.'
                    </a>
                </td>
                <td>'.$item->title.'</td>
                <td>'.JText::_($item->type).'</td>
                <td>'.$item->user.'</td>
              </tr>
              ';  
      }
    ?>
  </tbody>
</table>
<center>
  <br />
  <a href="<?php echo JURI::base().'index.php?option=com_amproject&view=product'; ?>" class="btnBack">
    <?php echo JText::_('BACK_TO_PRODUCTS'); ?>
  </a>
</center>  	