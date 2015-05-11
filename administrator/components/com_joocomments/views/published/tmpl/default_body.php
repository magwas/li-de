<?php
/*
 * v1.0.0
 * Friday Sep-02-2011
 * @component JooComments
 * @copyright Copyright (C) Abhiram Mishra www.bullraider.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$var=array('closeBtn'=>0);
JHtml::_('behavior.modal','a.modal',$var);
if(count($this->items)===0){?>
	<tr class="1" >
		<td colspan="5" align="center">
			<?php echo JText::sprintf('COM_JOOCOMMENTS_VIEW_PUBLISHED_NO_COMMENTS_FOUND'); ?>
		</td>
		
	</tr>
<?php }
 foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td style="width:5%">
			<?php echo $item->id; ?>
		</td>
		<td style="width:2%;">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td style="width:20%">
			<div style="float: left;width: 80%;">
			<strong><?php echo JText::sprintf('COM_JOOCOMMENTS_TABLE_BODY_COMMENTATOR_NAME').': ';?></strong><?php echo $item->name; ?><br/><br/>
			<strong><?php echo JText::sprintf('COM_JOOCOMMENTS_TABLE_BODY_COMMENTATOR_EMAIL').': ';?> </strong><?php echo $item->email; ?>

			</div>
			<div style="float: right;width:20%;text-decoration: underline;"> <a class="modal"  rel="{handler: 'iframe', size: {x: 620, y: 400}}" href="index.php?option=com_joocomments&view=mail&layout=modal&tmpl=component&name=<?php echo $item->name?>&toMail=<?php echo $item->email; ?>&title=<?php echo "RE: ".$item->title;?>&header=Send a quick mail to commentator" >E-Mail</a> 
			  </div>
		</td>
		<td style="width:68%">
			<strong><?php echo JText::sprintf('COM_JOOCOMMENTS_TABLE_BODY_COMMENTATOR_ARTICLE_TITLE').': ';?> </strong><?php echo $item->title; ?><br/><br/>
			<strong><?php echo JText::sprintf('COM_JOOCOMMENTS_TABLE_BODY_COMMENTATOR_COMMENT').': ';?> </strong><?php echo $item->comment; ?>
			
		</td>
		<td style="width:5%">
		<?php echo JHtml::_('jgrid.published', $item->published, $i, 'comments.'); ?>
		</td>
	</tr>
<?php endforeach; ?>
