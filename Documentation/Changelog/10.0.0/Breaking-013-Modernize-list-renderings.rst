.. include:: ../../Includes.txt

===================================
Breaking: Modernize list renderings
===================================

Description
===========

To provide more flexibility, all default post list templates
have been reworked. They all now share a common markup
with modifiers for the different plugins.

In previous versions the templates were already listening to
a variable class, but it was never set nor could could it be set
without overriding the templates. All controller that render lists
are now assigning a variable named type to these templates.

- ListPostsByAuthor -> postlist--byauthor
- ListPostsByCategory-> postlist--bycategory
- ListPostsByDate -> postlist--bydate
- ListPostsByTag -> postlist--bytag
- ListRecentPosts -> postlist--recent
- RelatedPosts --> postlist--related

Templates changed:

- Partials/List.html
- Partials/List/Post.html
- Templates/Post/ListPostsByAuthor.html
- Templates/Post/ListPostsByCategory.html
- Templates/Post/ListPostsByDate.html
- Templates/Post/ListPostsByTag.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/65affe6e3ec94446c1133863836ab3c20aecbc2d
