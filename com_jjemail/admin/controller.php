<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Direct Access.');

jimport('joomla.application.component.controllerlegacy');

/**
 * JJ Email Admin Component Controller
 *
 * @since  1.0
 */
class JjEmailController extends JControllerLegacy
{
	/**
	 * @var		string	The default view.
	 * @since	1.0
	 */
	protected $default_view = 'jjEmail';

	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   boolean  $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JControllerLegacy  A JControllerLegacy object to support chaining.
	 *
	 * @since	1.0
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'jjEmail'));

		// Call parent behavior
		parent::display($cachable);
	}
}
