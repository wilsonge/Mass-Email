<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
**/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla Controller library
jimport('joomla.application.component.controllerlegacy');

/**
 * Class for the jjEmail view of the jj Email component
 *
 * @since  1.0
 */
class JjemailControllerjjemail extends JControllerLegacy
{
	/**
     * Constructor (registers additional tasks to methods)
	 *
     * @param   array  $config  An optional associative array of configuration settings.
     */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Register Extra tasks
		$this->registerTask("email", "email");
	}

	/**
	 * Email method, sends an email to the user.
	 *
	 * @return  void
	 */
	public function email()
	{
		$model = $this->getModel('jjemail');

		if ($model->email())
		{
			$msg = JText::_('COM_JJEMAIL_EMAIL_SENT_SUCCESSFULLY');
		}
		else
		{
			$msg = JText::_('COM_JJEMAIL_ERROR_SENDING_EMAIL');
		}

		// Redirect to the thanks view
		$link = 'index.php?option=com_jjemail&view=thanks';
		$this->setRedirect($link, $msg);
	}
}
