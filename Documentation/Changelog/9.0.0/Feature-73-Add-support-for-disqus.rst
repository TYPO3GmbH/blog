.. include:: ../../Includes.txt

=================================================
Feature: #EXTBLOG-73 - Add support for disqus.com
=================================================

See https://jira.typo3.com/browse/EXTBLOG-73

Description
===========

Support for disqus.com was added which allows threaded and interactive comments.
To use disqus.com you have to enable it and set your disqus shortname (forum identifier)

.. code-block:: typoscript

   plugin.tx_blog.settings.comments {
      disqus = 1
      disqus.shortname = foo-bar
   }

The TypoScript above configures / activates the disqus support and replaces the classic comment form and comment listing.
The comment counts in the list are also replaced by disqus.
Attention: If you have overridden the templates, check the template changes of this patch.

.. index:: TypoScript, Frontend
