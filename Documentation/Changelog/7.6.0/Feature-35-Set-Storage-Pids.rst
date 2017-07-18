.. include:: ../../Includes.txt

=======================================
Feature: #EXTBLOG-35 - Set storage pids
=======================================

See https://jira.typo3.com/browse/EXTBLOG-35

Description
===========

Added possibility to set the storage pids for blog posts related plugins.

.. code-block::typoscript

   # This will set pids 1, 4 and 5 as storage pid for blog posts
   # this will used for all plugins in the whole tree
   plugin.tx_blog.settings.storagePid = 1,4,5


Impact
======

You can now set a storage pid where the blog posts are saved. This can be done by TypoScript or plugin setting.

.. note::

        All plugins which list blog posts will first check if there are any TypoScript or plugin setting for the storage pid.
        If there are no storage pids set, it will scan the rootline of the page the plugin is on if there are any blog posts.

.. index:: TypoScript, Frontend
