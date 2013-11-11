<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla view library
jimport('joomla.application.component.viewlegacy');

/**
 * HTML View class for the jjEmail Component
 *
 * @since  1.0
 */
class JjemailViewThanks extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @since   1.0
	 */
	public function display($tpl = null)
	{
		// Display the view
		parent::display($tpl);
	}
}
