Advanced Symlink publishing for Flow and Neos
=============================================

This package provides advanced symlink publishing options for Flow and Neos.
Most importantly, this package adds the option to publish resources using relative symlinks.
This is important when you run Flow or Neos with a chrooted PHP interpreter.

**Compatibility notices**: The `master` branch of this package (and all `~2.0`
versions) are compatible with Flow 3.0.2 and newer (which is used by
Neos 2.0.4 and newer). When you're using Flow 3.0.0 or 3.0.1 or Neos 2.0.3 or
older, use one of the `~1.0` versions or the `v1.0` branch instead.

Installation
------------

Install using composer:

    composer require mittwald-flow/symlink-publishing=~2.0

Next delete all absolute referenced symlinks, etc., from the _Resources folder:

    rm -rf Web/_Resources

Finally reissue the relative referenced symlinks, etc.:

    ./flow resource:publish

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
