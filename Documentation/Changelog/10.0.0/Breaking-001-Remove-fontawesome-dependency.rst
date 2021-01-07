.. include:: ../../Includes.txt

=======================================
Breaking: Remove fontawesome dependency
=======================================

Description
===========

All Icons are now delivered by default as svgs and are
rendered inline, this makes them easy to style and adjust.
New templates have been introduced that only delivers the markup
for the icons. This can be overwritten if you want to exchange the
icons used. Default avatar size was also slightly increased to better
match renderings.

Templates added:

- Partials/General/BlogIcons.html
- Partials/General/SocialIcons.html

Templates changed:

- Partials/Archive/Menu.html
- Partials/Post/Author.html
- Partials/Post/Meta.html
- Templates/Post/ListPostsByAuthor.html
- Templates/Post/ListPostsByCategory.html
- Templates/Post/ListPostsByDate.html
- Templates/Post/ListPostsByTag.html

Change
======

https://github.com/TYPO3GmbH/blog/commit/4bf2ae83639399c46a35e75b2476353cb43ee96c
