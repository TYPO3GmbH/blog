.. include:: ../Includes.txt

.. _Extending:

=========
Extending
=========


AvatarProvider
--------------
The default AvatarProvider is the GravatarProvider, this means the avatar of an author is received from gravatar.com. The extension provides also an ImageProvider for local stored images.

But you can also implement your own AvatarProvider:

1. Create a class which implements the AvatarProviderInterface.
2. Add your provider to the TCA field “avatar_provider” to make it selectable in the author record

**Note:** Since v10 the proxying of gravatar loading is used which means that TYPO3 downloads the gravatar, stores it on the filesystem and delivers the image locally from typo3temp. This is privacy related and useful if users didn't give their consent for fetching gravatars client side.
