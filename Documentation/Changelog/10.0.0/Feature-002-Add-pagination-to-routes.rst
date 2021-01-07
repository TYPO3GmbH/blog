.. include:: ../../Includes.txt

=================================
Feature: Add pagination to routes
=================================

Description
===========

The default routes are now respecting pagination params.
If you are using the default routes you dont need to change
anything else.

.. code-block:: typoscript

   imports:
      - { resource: "EXT:blog/Configuration/Routes/Default.yaml" }

If you have made a custom configuration, will need to add support yourself.


Change
======

https://github.com/TYPO3GmbH/blog/commit/461db542bc37e9b362941a222dd86e63a268388d
