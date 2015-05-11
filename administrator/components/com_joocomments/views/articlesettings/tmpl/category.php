<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<script type="text/javascript">
function sumbitIndividualStatus(id){
	var element=document.getElementById('jform_comment_Enable_Disable').value;
	 var myHTMLRequest = new Request.HTML({url: 'index.php',onComplete: function(response){
			$('co').empty();
	        $('right').empty().adopt(response);
   }}).get('option=com_joocomments&task=settings.update&articleId='+id+'&parentCategory='+element+'&view=articlesettings&layout=category');
	 
	
	alert('jhi');
}

</script>
<style type="text/css">
div.joo_tablewrapper {
	background-color: #F4F4F4;
	border: 1px solid #CCCCCC;
	border-radius: 10px 10px 10px 10px;
	margin-top: 8px;
	margin-right: 8px;
}

div.joo_toolbar-list {
	padding: 0;
	text-align: right;
}

div.joo_toolbar-list ul {
	margin: 0;
	padding: 0;
	float:right;
}

div.joo_toolbar-list li {
	color: #666666;
	float: left;
	list-style: none outside none;
	padding: 1px 1px 3px 4px;
	text-align: center;
}

div.joo_toolbar-list a {
	border: 1px solid #F4F4F4;
	cursor: pointer;
	display: block;
	float: left;
	height: 32px;
	white-space: nowrap;
	width: 32px;
	background-image:
		url(" http://localhost/fixed/administrator/templates/bluestork/images/toolbar/icon-32-new.png");
}
input.joo_checkall{
margin:12px !important;

}
</style>

<div class="joo_tablewrapper">
<div class="joo_toolbar-list">
<input class="joo_checkall" type="checkbox" name="checkall-toggle" value=""
			title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
			onclick="Joomla.checkAll(this)" />
<ul>
	<li><a href=""></a></li>
</ul>
</div>

<div class="clr"></div>
<div style="height: 250px;overflow:auto;">
<table class="adminlist">
	<thead>

		<th>Id</th>
		<th><strong>Article Title</strong></th>
		<th width="5%"><b>Comments status</b></th>
	</thead>

	<tbody>
		<?php
		if (count($this->items)>0){
			foreach($this->items as  $item):
	  $registry = new JRegistry;
	  $registry->loadString($item['attribs']);
	  $attribs = $registry->toArray();
	  echo '<tr>';
	  echo '<td class="center">';
	  echo JHtml::_('grid.id', $item['id'], $item['id']);
	  echo '</td>';
	  echo '<td>'.$item['title'].'<br/>'.'</td>';
	  $path='ss';
	  if(isset($attribs['comments_enabled'])){
	  	$path=$attribs['comments_enabled']=='1'?'admin/tick.png':'admin/publish_x.png';
	  }else{
	  	$path='admin/tick.png';
	  }
	  $attrib='onclick=sumbitIndividualStatus(\''.$item['id'].'\');';
	  echo '<td class="center">'.JHtml::image($path,'',$attrib,true,false).'</td>';
	  echo '</tr>';
	  endforeach;
		}else{
			echo '<tr><td>No Articles found</td></tr>';
		}
		echo '</tbody>';
		echo '</table></div></div>';
		echo '<input type="hidden" name="boxchecked" value="0" />';