.. include:: ../../Includes.txt

================================================================
Feature: #EXTBLOG-60 - Deprecate CommentRepository::findLatest()
================================================================

See https://jira.typo3.com/browse/EXTBLOG-60

Description
===========

The method :php:`CommentRepository::findLatest()` has been marked as deprecated.


Impact
======

Calling the deprecated methods will trigger a deprecation log entry.


Migration
=========

Use the new method :php:`CommentRepository::findActiveComments()`


.. index:: PHP-API
