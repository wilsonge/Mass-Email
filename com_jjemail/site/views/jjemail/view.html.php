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
class JjemailViewjjemail extends JViewLegacy
{
	/**
	 * The maximum file size allowed in MB
	 *
	 * @var    integer
	 * @since  1.0
	 */
	protected $fileSizeAllowed = null;

	/**
	 * The file types allowed separated by commas without spaces
	 *
	 * @var    integer
	 * @since  1.0
	 */
	protected $fileTypesAllowed = null;

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
		// Set the file size
		if (empty($this->fileSizeAllowed))
		{
			$this->fileSizeAllowed = $this->getFileSize();
		}

		// Set the file types
		if (empty($this->fileTypesAllowed))
		{
			$typesParam = $this->getFileTypes();
			$parts = explode(',', $typesParam);
			$typesAllowed = '';
			$number = count($parts);

			foreach($parts as $key => $part)
			{
				$typesAllowed .= $part;

				if ($key != ($number - 1))
				{
					$typesAllowed .= ', ';
				}
			}
			
			$this->fileTypesAllowed = $typesAllowed;
		}

		// Display the view
		parent::display($tpl);
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
}
