<?php
namespace Mw\SymlinkResourceTarget\Resource\Target;

use Mw\SymlinkResourceTarget\Utility\Files;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Resource\Exception;
use TYPO3\Flow\Resource\Target\FileSystemTarget as FlowFileSystemTarget;

/**
 * A target which publishes resources to a specific directory in a file system.
 */
class FileSystemTarget extends FlowFileSystemTarget {

	/**
	 * Initializes this resource publishing target
	 *
	 * @return void
	 * @throws Exception
	 */
	public function initializeObject() {
		foreach ($this->options as $key => $value) {
			$isOptionSet = $this->setOption($key, $value);
			if (!$isOptionSet) {
				throw new Exception(sprintf('An unknown option "%s" was specified in the configuration of a resource FileSystemTarget. Please check your settings.',
					$key), 1436962549);
			}
		}

		if (!is_writable($this->path)) {
			@Files::createDirectoryRecursively($this->path);
		}
		if (!is_dir($this->path) && !is_link($this->path)) {
			throw new Exception('The directory "' . $this->path . '" which was configured as a publishing target does not exist and could not be created.',
				1436962550);
		}
		if (!is_writable($this->path)) {
			throw new Exception('The directory "' . $this->path . '" which was configured as a publishing target is not writable.',
				1436962551);
		}
	}

	/**
	 * Set an option value and return if it was set.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return boolean
	 */
	protected function setOption($key, $value) {
		switch ($key) {
			case 'baseUri':
				if (strpos($value, '://') === FALSE && $value[0] !== '/') {
					$this->baseUri = $this->detectResourcesBaseUri() . $value;
				} else {
					$this->baseUri = $value;
				}
				break;
			case 'path':
				$this->$key = $value;
				break;
			case 'subdivideHashPathSegment':
				$this->subdivideHashPathSegment = (boolean)$value;
				break;
			default:
				return FALSE;
		}

		return TRUE;
	}
}
