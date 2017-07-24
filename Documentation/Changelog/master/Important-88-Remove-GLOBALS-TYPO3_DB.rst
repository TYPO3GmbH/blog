.. include:: ../../Includes.txt

====================================================
Important: #EXTBLOG-88 - Remove $GLOBALS['TYPO3_DB']
====================================================

See https://jira.typo3.com/browse/EXTBLOG-88

Description
===========

This patch removes all calls to $GLOBALS['TYPO3_DB'] and replace it with doctrine calls.

This patch introduce also two new columns in table :sql:``pages``:

* :sql:``crdate_month``
* :sql:``crdate_year``

both fields are used for the data aggregation of the archive sidebar widget.
for existing blog posts, an UpdateWizard is in place and should be executed in the install tool.

Impact
======

An existing installation must run the UpdateWizard, else the output of the archive sidebar widget is broken.

.. index:: Backend, Frontend, Database
