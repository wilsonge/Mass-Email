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
	 * The maximum file size allowed in MB
	 *
	 * @var    integer
	 * @since  1.0
	 */
	protected $fileSize = null;

	/**
	 * The file types allowed separated by commas without spaces
	 *
	 * @var    integer
	 * @since  1.0
	 */
	protected $fileTypes = null;

	/**
	 * Constructor
	 *
	 * @param   array  $config  An array of configuration options (name, state, dbo, table_path, ignore_request).
	 *
	 * @since   12.2
	 * @throws  Exception
	 */
	public function __construct($config = array())
	{
		parent::__construct($config = array());

		// Set the file size
		if (empty($this->fileSize))
		{
				if (array_key_exists('fileSize', $config))
				{
						$this->fileSize = $config['fileSize'];
				}
				else
				{
						$this->fileSize = $this->getFileSize();
				}
		}

		// Set the file types
		if (empty($this->fileTypes))
		{
				if (array_key_exists('fileTypes', $config))
				{
						$this->fileTypes = $config['fileTypes'];
				}
				else
				{
						$this->fileTypes = $this->getFileTypes();
				}
		}
	}

	/**
	 * Method to get the maximum allowed file size.
	 *
	 * @return      integer  the maximum file size in MB.
	 *
	 * @since		1.0
	 */
	private function getFileSize()
	{
		$app = JFactory::getApplication('site');
		$params = $app->getParams();

		return (int) $params->get('fileSize', 10);
	}

	/**
	 * Method to get the file types allowed for attachments.
	 *
	 * @return      string  the maximum file size in MB.
	 *
	 * @since		1.0
	 */
	private function getFileTypes()
	{
		$app = JFactory::getApplication('site');
		$params = $app->getParams();

		return $params->get('fileTypes', 'jpg,gif,jpeg,png,doc,docx,xls,xlsx,pdf');
	}

	/**
	 * Method to check the files.
	 *
	 * @param  array   $file  The file to be uploaded in JInputFile form
	 *
	 * @return      boolean  true if checks are OK. false otherwise
	 *
	 * @since		1.0
	 */
	private function canUpload(array $file)
	{
		jimport('joomla.filesystem.file');
		 		 
		// Check for filesize
		$fileSize = $file['size'];
		if ($fileSize > ($this->fileSize * 1000000))
		{
			// File Bigger than maximum allowed
			return false;
		}

		// Check file types
		$types = explode(',', $this->fileTypes);
		$extensionType = JFile::getExt($file['name']);
		$ok = false;

		foreach ($types as $type)
		{
			if ($extensionType == $type)
			{
				$ok = true;
			}
		}

		return $ok;
	}

	/**
	 * Method to fetch all Emails.
	 *
	 * @return      boolean  true if email sends sucessfully otherwise false
	 *
	 * @since		1.0
	 */
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
					// Make sure the file name isn't blank (means an empty attachment)
					if($file['name'] != '')
					{
						if ($this->canUpload($file))
						{
							// Check no errors then upload
							if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
								// Do some base checking on files to put in email, then create the name of the file again
								jimport('joomla.filesystem.file');
								$extensionType = JFile::getExt($file['name']);
								$name = preg_replace("/[^A-Za-z0-9]/i", "-", $file['name']);
								$mailer->addAttachment($file['tmp_name'], $name . '.' . $extensionType);
							}
						}
						else
						{
							JFactory::getApplication()->enqueueMessage(JText::_('COM_JJEMAIL_INVALID_ATTACHMENT'), 'error');
						}
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
