<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::stylesheet('com_jjemail/com_jjemail.css', array(), true);
?>
<div id="jjEmail">
    <?php
	if (JFactory::getUser()->authorise('core.create', 'com_jjEmail'))
	{
	?>
    <h1><?php echo JText::_('COM_JJEMAIL_THANKS_FOR_USING'); ?></h1>
    <p><?php echo JText::_('COM_JJEMAIL_EMAIL_SENT'); ?></p>
    <?php
	}
	else
	{
	?>

    <h1><?php echo JText::_('COM_JJEMAIL_SORRY'); ?></h1>
    <p><?php echo JText::_('COM_JJEMAIL_BECOME_A_MEMBER'); ?></p>
	<?php
	}
	?>
</div>