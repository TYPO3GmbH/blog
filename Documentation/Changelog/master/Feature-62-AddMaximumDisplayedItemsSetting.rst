.. include:: ../../Includes.txt

===============================================================================================
Feature: #EXTBLOG-62 - Introduce ``maximumDisplayedItems`` setting in recent posts list plug-in
===============================================================================================

See https://jira.typo3.com/browse/EXTBLOG-62

Description
===========

The lists plug-in will now use the setting ``lists.posts.maximumDisplayedItems`` for recent posts to limit the number of recent items to be displayed.

Default value is ``0``, which means there is no limit (there is no impact on previous behaviour).


Impact
======

The partial file used for the list has changed (``EXT:blog/Resources/Private/Partials/List.html``).

If you did override this partial file in your own extension, you may need to apply the same modification in your own file(s).

.. index:: TypoScript
