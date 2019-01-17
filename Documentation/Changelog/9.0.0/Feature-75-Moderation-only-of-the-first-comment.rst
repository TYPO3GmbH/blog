.. include:: ../../Includes.txt

===========================================================
Feature: #EXTBLOG-75 - Moderation only of the first comment
===========================================================

See https://jira.typo3.com/browse/EXTBLOG-75

Description
===========

A new value for the moderation settings allows to auto approve comments
if a comment with the same email address has been approved before.

.. code-block:: typoscript

   plugin.tx_blog.settings.comments.moderation = 2

If the setting :typoscript:`plugin.tx_blog.settings.comments.moderation` is set to the value 2
a new comment with an author email address which has been used in an other approved comment will
automatically set to status approved too.

.. index:: TypoScript, Frontend
