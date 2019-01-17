.. include:: ../../Includes.txt

========================================================
Feature: #EXTBLOG-96 - Notification of new blog comments
========================================================

See https://jira.typo3.com/browse/EXTBLOG-96

Description
===========

A notification system was introduced to send notifications on new comments.
The notification system is extensible and will be used for more notifications in the future.
The first implementation handles the email notifications for new comments on posts.

.. code-block:: typoscript

   plugin.tx_blog.settings.notifications {
      email {
         senderName = TYPO3 Blog
         senderMail =
      }
      T3G\AgencyPack\Blog\Notification\CommentAddedNotification {
         admin = 1
         admin.email = admin@example.com

         author = 1
      }
   }

The TypoScript above configure / activate the email notification on new comments
of a blog post for admin and author.

.. index:: TypoScript, Frontend
