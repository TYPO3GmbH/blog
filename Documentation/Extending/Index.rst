.. include:: ../Includes.txt

.. _Extending:

=========
Extending
=========

Creating Categories and Tags
----------------------------

Categories are the default TYPO3 categories you probably already know.

Create a new category:

* Go to the list module
* Click on the page where you want to create the new category
* Click on the "new record" button on the top and choose category
* Enter a title for the category and choose a possible parent
* Click "Save"

Tags are blog specific records. Creating a new tag works in the same way as creating categories does:

* Go to list module
* Click on the page where you want to create the new tag
* Enter a title for the tag
* Click "Save"

Enable sharing
--------------
No implementation is provided by the blog extension itself. Of course you can still use an extension like the Shariff implementation for TYPO3 in your custom templates.


AvatarProvider
--------------
The default AvatarProvider is the GravatarProvider, this means the avatar of an author is received from gravatar.com. The extension provides also an ImageProvider for local stored images.

But you can also implement your own AvatarProvider:

1. Create a class which implements the AvatarProviderInterface.
2. Add your provider to the TCA field “avatar_provider” to make it selectable in the author record

**Note:** Since v10 the proxying of gravatar loading is used which means that TYPO3 downloads the gravatar, stores it on the filesystem and delivers the image locally from typo3temp. This is privacy related and useful if users didn't give their consent for fetching gravatars client side.
