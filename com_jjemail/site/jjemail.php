<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 **/
// No direct access
defined('_JEXEC') or die('Restricted access');

// Import joomla controller library
jimport('joomla.application.component.controllerlegacy');

$input = JFactory::getApplication()->input;

// Get an instance of the controller prefixed by jjEmail
$controller = JControllerLegacy::getInstance('jjemail');

// Perform the Request task
$controller->execute($input->getCmd('task', ''));

// Redirect if set by the controller
$controller->redirect();
