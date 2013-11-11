<?php
/**
 * @copyright (C) 2013 JoomJunk. All rights reserved.
 * @package    JJ Email
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 /**
 * Script file of com_jjEmail component
 */
class com_jjemailInstallerScript
{
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) {
		$lang =  JFactory::getLanguage();
		$lang->load('com_jjemail', JPATH_ADMINISTRATOR);
		echo '<table width="100%">
				<tr>
					<td width="4%">
						<img src="../media/com_jjemail/images/cpanel_48.png" height="48px" width="48px">
					</td>
					<td width="76%">
						<h2>'.JText::_("COM_JJEMAIL") . ' 1.0.0 </h2>
					</td>
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td width="50%">' . JText::_("COM_JJEMAIL_DESC") . '</td>
					'.JText::_("COM_JJEMAIL_DESC_RIGHT") .'
				</tr>
			</table>';
	}
}
?>