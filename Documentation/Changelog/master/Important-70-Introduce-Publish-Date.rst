.. include:: ../../Includes.txt

===============================================
Important: #EXTBLOG-70 - Introduce publish date
===============================================

See https://jira.typo3.com/browse/EXTBLOG-70

Description
===========

This patch introduce a new field "publish_date" which replace the usage of crdate.

An UpgradeWizard copy the existing crdate value into the new field.

Impact
======

An existing installation must run the UpdateWizard, else the output is broken.

If use your own templates, ensure to use :html:`{post.publishDate}` instead of  :html:`{post.crdate}` in your templates.

.. index:: Backend, Frontend, Database
