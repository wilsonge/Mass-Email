<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die();

// Import Joomla view library
jimport('joomla.application.component.viewlegacy');

/**
 * HTML View class for the jjEmail Component Backend
 *
 * @since  1.0
 */
class JjemailViewjjemail extends JViewLegacy
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
		// Set the toolbar and number of found items
		$this->addToolBar();

		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Sets the toolbar
	 *
	 * @return  void
	 *
	 * @since  1.0
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JJEMAIL_HEADER'));

		if (JFactory::getUser()->authorise('core.admin', 'com_jjemail'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_jjemail');
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 *
	 * @since  1.0
	 */
	protected function setDocument()
	{
			$document = JFactory::getDocument();
			$document->setTitle(JText::_('COM_JJEMAIL_ADMINISTRATION'));
	}
}
