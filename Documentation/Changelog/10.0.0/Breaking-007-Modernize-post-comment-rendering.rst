.. include:: ../../Includes.txt

==========================================
Breaking: Modernize post comment rendering
==========================================

Description
===========

The post comment rendering has been completely reworks and
is now more easy to customize without overwriting the templates.
Bootstrap specific classes were completely removed and
we now deliver some basic css to achieve better results.

Schema.org attributes were adjusted to respect the latest
recommendations for user comments. And a new option was
added to make the display date format configurable through typoscript.

Configuration added:

- comments.date.format = %B %e, %Y

Templates changed or added:

- Partials/Comment/Comment.html
- Templates/Comment/Comments.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/a0b7d3188a7a07c8e10ecdb0bf34bbccd8b7f039
