.. include:: ../../Includes.txt

============================================
Feature: #EXTBLOG-95 - Add Google Re-Captcha
============================================

See https://jira.typo3.com/browse/EXTBLOG-95

Description
===========

The google re-captcha was added to the comment form but have to be activated and configured.
The feature prevent comment spam by adding an additional captcha field to the comment form.
To use the feature it is required to activate and configure the captcha field.
The required keys can be received from google: https://www.google.com/recaptcha/admin#list

.. code-block:: typoscript

   plugin.tx_blog.settings.google_recaptcha = 1
   plugin.tx_blog.settings.google_recaptcha {
      website_key = 6LfN-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
      secret_key = 6LfN-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
   }


Impact
======

You can now reduce the amount of spam comments by activate this feature.

.. index:: TypoScript, Frontend
