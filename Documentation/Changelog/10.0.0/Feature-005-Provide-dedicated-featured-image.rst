.. include:: ../../Includes.txt

=========================================
Feature: Provide dedicated featured image
=========================================

Description
===========

The new featured image field will now be the preferred way
to set an article image. Since the media field could contain
any asset the new featured image field is dedicated to images.

You can configure the width and height through typoscript constants.

.. code-block:: typoscript

   plugin.tx_blog.settings.post.featuredImage.width = 1140
   plugin.tx_blog.settings.post.featuredImage.height= 400c
   plugin.tx_blog.settings.lists.featuredImage.width = 1140
   plugin.tx_blog.settings.lists.featuredImage.height= 400c


Change
======

https://github.com/TYPO3GmbH/blog/commit/b7c1e6ffe1daac09694135fcbbc164ec7b90475d
