<?php
/**
 * @package    JJ_Email
 * @copyright  (C) 2013 JoomJunk. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
**/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Import Joomla Model library
jimport('joomla.application.component.modellegacy');

/**
 * jjBlog Model
 *
 * @since  1.0
 */
class JjemailModeljjemail extends JModelLegacy
{
	/**
	 * Method to check the files.
	 *
	 * @return      boolean  true if checks are OK. false otherwise
	 *
	 * @since		1.0
	 **/
	private function canUpload(array $file)
	{
		jimport('joomla.filesystem.file');
		 		 
		// Check for filesize
		$fileSize = $file['size'];
		if($fileSize > 2000000)
		{
			// File Bigger than 2MB
			return false;
		}

		return true;
	}

	/**
	 * Method to fetch all Emails.
	 *
	 * @return      boolean  true if email sends sucessfully otherwise false
	 *
	 * @since		1.0
	 **/
	private function fetchEmails()
	{
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true)
			->select('*')
			->from('#__users')
			->where('enabled = 1');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		try
		{
			$rows = $db->loadObjectList();
		}
		catch (Exception $e)
		{
			// Catch any database errors.
			JLog::add(JText::sprintf('COM_JJEMAIL_ERROR', $e), JLog::CRITICAL);

			return false;
		}

		$emails = array();
		$i = 0;

		foreach ($rows as $row)
		{
			$emails[$i] = $row->email;
			$i++;
		}

		return $emails;
	}

	/**
     * Method to send an email.
     *
     * @return      boolean  true if email sends successfully otherwise false
	 *
     * @since		1.0
     */
	public function email()
	{
		$files = JFactory::getApplication()->input->files->get('attach');
		$post = JFactory::getApplication()->input->post;

		$mailer = JFactory::getMailer();
		$user = JFactory::getUser();
		$sender = array(
			$user->email,
			$user->name
		);

		// Fetch all Emails
		if (!$post->getBool('to', 'false') && ($recipient = $this->fetchEmails()))
		{
			$mailer->addRecipient($recipient);
		}
		else
		{
			// No users to send emails to
			return false;
		}

		if ($post->getString('subject', '') && $post->getString('message', ''))
		{
			$mailer->setSubject($post->getString('subject', ''))
					->setBody($post->getString('message', ''))
					->setSender($sender);

			if ($files)
			{
				foreach($files as $file)
				{
					if ($this->canUpload($file))
					{
						// Do some base checking on files to put in email and filter out name of file
						$mailer->addAttachment($file['tmp_name'], preg_replace("/[^A-Za-z0-9]/i", "-", $file['name']));
					}
				}
			}

			$send = $mailer->Send();

			if ($send == true)
			{
				return true;
			}
			else
			{
				// Retrieve error message
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}
