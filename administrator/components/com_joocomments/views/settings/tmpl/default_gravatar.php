<?php
defined('_JEXEC') or die('Restricted access');
			if($this->particular==0)
				echo JHtml::_('sliders.panel',JText::_($this->sliderHeader), 'publishing-details');
					
				echo '<li class="joolist">';
					if (!$this->field->hidden){ 
						echo $this->field->label;
					
					} 	
				 	echo $this->field->input; 
					echo '</li>';
				