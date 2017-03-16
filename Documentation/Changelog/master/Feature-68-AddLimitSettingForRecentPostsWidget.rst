.. include:: ../../Includes.txt

===============================================================================================
Feature: #EXTBLOG-68 - Add ``limit`` setting in recent posts widget plug-in
===============================================================================================

See https://jira.typo3.com/browse/EXTBLOG-68

Description
===========

Introduction of a new setting ``widget.recentposts.limit`` for a maximum of displayed posts in the recent posts widget.
Default value is ``5``. There is no limit if the setting is not present or set to ``0``.

.. index:: TypoScript
