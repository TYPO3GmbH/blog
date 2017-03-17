.. include:: ../../Includes.txt

===========================================
Feature: #EXTBLOG-35 - Set StoragePids
===========================================

See https://jira.typo3.com/browse/EXTBLOG-35

Description
===========

Added possibility to set the StoragePids for blog posts.


Impact
======

You can now set a StoragePid where the blog posts are saved. This can be done by TypoScript or Plugin-setting.

.. note::

        The "List of Posts" plugin will first check if there are any TypoScript or Plugin settings for the StoragePid.
        If there are no StoragePids set, it will scan the rootline of the page the plugin is on if there are any blogposts.

.. index:: TypoScript, Frontend