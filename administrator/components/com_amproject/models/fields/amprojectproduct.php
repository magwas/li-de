<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');

JFormHelper::loadFieldClass('list');


/**
 * Form Field class.
 */
class JFormFieldAmprojectproduct extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'Amprojectproduct';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db		= &JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('id AS value, title AS text');
		$query->from('#__ampm_product');
    $query->where('state=1');
		$query->order('title DESC');

		// Get the options.
		$db->setQuery($query->__toString());

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

    $i = count($options);
    
    $options0 = new stdclass();
    $options0->id=0; 
    $options0->text=JText::_('UNDEFINED'); 

		$options	= array_merge(
      array($options0),
			parent::getOptions(),
			$options
		);

		return $options;
	}
}