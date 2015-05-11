<?php
// planned for version 1.0.5
defined('_JEXEC') or die('Restricted access');
			if($this->particular==0)
				echo JHtml::_('sliders.panel',JText::_($this->sliderHeader), 'publishing-details');
					
				echo '<div style="float:left"><li>';
					if (!$this->field->hidden){ 
						echo $this->field->label;
					
					} 	
				 	echo $this->field->input; 
					echo '</li><span id="co"></span></div><div id="right" style="float:right;height:300px;overflow:auto;"></div>';
				