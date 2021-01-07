.. include:: ../../Includes.txt

==============================================
Breaking: Limit tags to configured storage pid
==============================================

Description
===========

Listing of tags is now restricted to the configured storage pid.
If you want to use tags from additional storages please adjust your
configuration accordingly.

TypoScript Constants Example:

.. code-block:: typoscript

   plugin.tx_blog.settings.storagePid = 0,666


Change
======

https://github.com/TYPO3GmbH/blog/commit/8befd62185dd27b01ec78ed8fd5eda5c9eb87cb2
