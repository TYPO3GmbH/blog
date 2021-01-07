.. include:: ../../Includes.txt

=====================================================
Breaking: Respect PageTsConfig limitation for authors
=====================================================

Description
===========

From now on the PAGE_TSCONFIG_ID is respected for authors in the backend.

If you have not configured a storage pid for this records before please adjust your configuration.

TsConfig Example:

.. code-block:: typoscript

   TCEFORM.pages.authors.PAGE_TSCONFIG_ID = 59


Change
======

https://github.com/TYPO3GmbH/blog/commit/b2b058fd8570fb09636379dee97e0c82c896f5cb
