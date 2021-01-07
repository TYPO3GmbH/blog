.. include:: ../../Includes.txt

=====================================
Feature: Make pagination configurable
=====================================

Description
===========

The behaviour of the pagination can not be confiured through typoscript constants.


Number of post that should be displayed per page (Default: 10):

.. code-block:: typoscript

   plugin.tx_blog.settings.lists.pagination.itemsPerPage

Show the pagination above the posts (Default: 0):

.. code-block:: typoscript

   plugin.tx_blog.settings.lists.pagination.insertAbove

Show the pagination below the posts (Default: 1):

.. code-block:: typoscript

   plugin.tx_blog.settings.lists.pagination.insertBelow

Maximum number of links in the pagination ((Default: 10))

.. code-block:: typoscript

   plugin.tx_blog.settings.lists.pagination.maximumNumberOfLinks


Change
======

https://github.com/TYPO3GmbH/blog/commit/461db542bc37e9b362941a222dd86e63a268388d
