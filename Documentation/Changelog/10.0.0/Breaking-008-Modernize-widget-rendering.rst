.. include:: ../../Includes.txt

====================================
Breaking: Modernize widget rendering
====================================

Description
===========

The widget rendering has been completely reworked and is
now more easy to customize without overwriting the templates.

Title rendering has been moved to the main layout, you can now
use the new section "Title" to set the widget title. If you have
overwritten the widget templates or added new ones that makes
use of the "Widgets" layout you need to add this new section.

Migration:

**Old**

.. code-block:: typoscript

   <h3 class="widget-title">[TITLE]</h3>

**New**

.. code-block:: typoscript

   <f:section name="Title">[TITLE]</f:section>

Templates changed:

- Layouts/Widget.html
- Templates/Post/Sidebar.html
- Templates/Widget/Archive.html
- Templates/Widget/Categories.html
- Templates/Widget/Comments.html
- Templates/Widget/Feed.html
- Templates/Widget/RecentPosts.html
- Templates/Widget/Tags.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/8db7276f899aa05a5e8d556e06ca32e3d97bbab6
