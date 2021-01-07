.. include:: ../../Includes.txt

===========================================
Breaking: Do not scale tags size by default
===========================================

Description
===========

The default size for `widgets.tags.maxSize` has
been reduced from 200 to 100 to unset the
default scaling. To reenable the tag scaling in
the widget please adjust the min-/maxSize to
your preferred settings.

In addition the fallback sizes have been also
adjusted to reflect these default typoscript
settings.


Change
======

https://github.com/TYPO3GmbH/blog/commit/f0507bd6af1db98f4dbbb50d400c8f36b7abf1c5
