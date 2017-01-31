Advanced Symlink publishing for Flow and Neos
=============================================

This package provides advanced symlink publishing options for Flow and Neos.
Most importantly, this package adds the option to publish resources using relative symlinks.
This is important when you run Flow or Neos with a chrooted PHP interpreter.

**Compatibility notices**:
* The `master` branch of this package and all `~2.0` versions are compatible with Flow >=3.0.2 and stop working with Flow 4.0.
* When you're using Flow 3.0.0 or 3.0.1 or Neos 2.0.3 or older, use one of the `~1.0` versions or the `v1.0` branch instead.
* Keep in mind that if you're using [Flow 3.3](http://flowframework.readthedocs.io/en/stable/TheDefinitiveGuide/PartV/ReleaseNotes/330.html#symlinks-can-now-be-relative) or newer you don't need this package anymore. The `FileSystemSymlinkTarget` can now be configured to create relative symlinks for published resources by default.

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


#### Changed FLOW_PATH_ROOT or FLOW_PATH_WEB

If you change the FLOW_PATH_WEB or FLOW_PATH_ROOT, please do not forget to change the **path** options at the **Flow** -> **resource** -> **targets**.

You can do this with following Settings.yaml configuration:

	TYPO3:
	  Flow:
		resource:
		  targets:
			localWebDirectoryPersistentResourcesTarget:
			  targetOptions:
				path: '[your_flow_path]/Web/_Resources/Persistent/'
			localWebDirectoryStaticResourcesTarget:
			  targetOptions:
				path: '[your_flow_path]/Web/_Resources/Static/Packages/'

License
-------

This package is MIT-licensed. See the [license file](LICENSE) for more information.

Credits
-------

This package is based on a [change](https://review.typo3.org/30519) by Christian Müller.
