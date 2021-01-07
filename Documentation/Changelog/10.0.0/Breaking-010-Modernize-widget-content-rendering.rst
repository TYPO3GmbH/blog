.. include:: ../../Includes.txt

============================================
Breaking: Modernize widget content rendering
============================================

Description
===========

The widget content rendering has been completely
reworked and is now more easy to customize without
overwriting the templates.

The archive template does not use the `Archive/Menu`
partial anymore. It now has a dedicated template to not
reflect template changes that are meant to be for a
different rendering location.

RSS links have been removed to declutter the default
view for the sidebar. Links to the RSS feeds still exist in
their dedicated single views.

Templates changed:

- Templates/Widget/Archive.html
- Templates/Widget/Categories.html
- Templates/Widget/Comments.html
- Templates/Widget/Feed.html
- Templates/Widget/RecentPosts.html
- Templates/Widget/Tags.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/eb8516523ee8e201612e90bbfad85ca18125b575
