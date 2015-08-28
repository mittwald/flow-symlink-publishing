Advanced Symlink publishing for Flow and Neos
=============================================

This package provides advanced symlink publishing options for Flow and Neos.
Most importantly, this package adds the option to publish resources using relative symlinks.
This is important when you run Flow or Neos with a chrooted PHP interpreter.

Installation
------------

Install using composer:

    composer require mittwald-flow/symlink-publishing

Next delete all absolute referenced symlinks, etc., from the _Resources folder:

    rm -rf Web/_Resources

Finally reissue the relative referenced symlinks, etc.:

    ./flow resources:publish

Configuration
-------------

You can configure relative symlink publishing in the Flow settings.
**It is enabled by default!**

	TYPO3:
	  Flow:
		resource:
		  targets:
			localWebDirectoryPersistentResourcesTarget:
			  target: 'Mw\SymlinkPublishing\Resource\Target\FileSystemSymlinkTarget'
			  targetOptions:
				relativeSymlinks: TRUE
			localWebDirectoryStaticResourcesTarget:
			  target: 'Mw\SymlinkPublishing\Resource\Target\FileSystemSymlinkTarget'
			  targetOptions:
				relativeSymlinks: TRUE

License
-------

This package is MIT-licensed. See the [license file](LICENSE) for more information.

Credits
-------

This package is based on a [change](https://review.typo3.org/30519) by Christian Müller.
