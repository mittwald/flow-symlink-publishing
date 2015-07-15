<?php
namespace Mw\SymlinkPublishing\Utility;

use TYPO3\Flow\Exception;
use TYPO3\Flow\Utility\Files as FlowFiles;

/**
 * File and directory functions
 */
class Files extends FlowFiles {

	static public function createRelativeSymlink($target, $link) {
		if (file_exists($link)) {
			self::unlink($link);
		}
		$relativeTargetPath = Files::getRelativePath($link, $target);
		if (DIRECTORY_SEPARATOR !== '/') {
			$relativeTargetPath = str_replace('/', '\\', $relativeTargetPath);
			$flag = (is_dir($target) ? '/d' : '');
			$output = array();
			$return = 0;
			exec(sprintf('mklink %s %s %s', $flag, escapeshellarg($link), escapeshellarg($relativeTargetPath)), $output,
				$return);
			if ($return !== 0) {
				throw new Exception(sprintf('Error while attempting to create a relative symlink at "%s" pointing to "%s". Make sure you have sufficient privileges and your operating system supports symlinks.',
					$link, $relativeTargetPath), 1436962557);
			}
			return file_exists($link);
		} else {
			return \symlink($relativeTargetPath, $link);
		}
	}

	/**
	 * Finds the relative path between two given absolute paths.
	 * Credits go to stackoverflow member "Gordon".
	 *
	 * @see http://stackoverflow.com/questions/2637945/
	 *
	 * @param string $from An absolute path to base on
	 * @param string $to An absolute path to find the relative representation onto $from
	 * @return string
	 */
	static public function getRelativePath($from, $to) {
		$from = self::getUnixStylePath($from);
		$to = self::getUnixStylePath($to);
		if (is_dir($from)) {
			$from = self::getNormalizedPath($from);
		}
		if (is_dir($to)) {
			$to = self::getNormalizedPath($to);
		}

		$from = explode('/', $from);
		$to = explode('/', $to);
		$relativePath = $to;

		foreach ($from as $depth => $directory) {
			// find first non-matching dir
			if ($directory === $to[$depth]) {
				// ignore this directory
				array_shift($relativePath);
			} else {
				// get number of remaining dirs to $from
				$remaining = count($from) - $depth;
				if ($remaining > 1) {
					// add traversals up to first matching dir
					$padLength = (count($relativePath) + $remaining - 1) * -1;
					$relativePath = array_pad($relativePath, $padLength, '..');
					break;
				} else {
					$relativePath[0] = './' . $relativePath[0];
				}
			}
		}
		return implode('/', $relativePath);
	}
}
