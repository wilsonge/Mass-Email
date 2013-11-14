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
	if (JFactory::getUser()->authorise('core.create', 'com_jjemail'))
	{
	?>
		<h1><?php echo JText::_('COM_JJEMAIL_SEND_AN_EMAIL'); ?></h1>
		<form action="<?php echo JRoute::_('index.php?option=com_jjemail&task=jjemail.email'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
			<div class="field">
				<label for="jjEmail-to"><?php echo JText::_('COM_JJEMAIL_TO_FIELD_LABEL'); ?></label>
				<p class="jjemail-bold"><?php echo JText::_('COM_JJEMAIL_ALL_USERS'); ?></p>
			</div>

			<div class="field">
				<label for="jjEmail-from"><?php echo JText::_('COM_JJEMAIL_FROM_FIELD_LABEL'); ?></label>
				<input type="email" name="from" value="<?php echo JFactory::getUser()->email ?>" disabled="disabled" id="jjEmail-from"/>
			</div>

			<div class="field">
				<label for="jjEmail-subject"><?php echo JText::_('COM_JJEMAIL_SUBJECT_FIELD_LABEL'); ?></label>
				<input type="text" name="subject" id="jjEmail-subject"/>
			</div>

			<div class="field">
				<label for="jjEmail-message"><?php echo JText::_('COM_JJEMAIL_MESSAGE_FIELD_LABEL'); ?></label>
				<textarea name="message" id="jjEmail-message" cols="5" rows="5" ></textarea>
			</div>

			<div class="field">
				<label for="jjEmail-attach"><?php echo JText::_('COM_JJEMAIL_ATTACHMENTS_FIELD_LABEL'); ?></label>
				<input type="file" name="attach[]" id="jjEmail-attach"/>
				<p class="small"><?php echo JText::sprintf('COM_JJEMAIL_ALLOWED_TYPES_ARE', $this->fileSizeAllowed, $this->fileTypesAllowed); ?></p>
			</div>

			<div class="field">
				<input class="submit" type="submit" name="submit" id="jjEmail-submit" />
			</div>
			<input type="hidden" name="to" value="0" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
    <?php
	}
	else
	{
	?>
    <h1><?php echo JText::_('COM_JJEMAIL_SORRY'); ?></h1>
    <?php echo JText::_('COM_JJEMAIL_BECOME_A_MEMBER'); ?>
    <?php
	}
	?>
</div>