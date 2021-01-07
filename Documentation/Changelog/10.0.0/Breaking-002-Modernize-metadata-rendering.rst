.. include:: ../../Includes.txt

======================================
Breaking: Modernize metadata rendering
======================================

Description
===========

The metadata implementation for authors, categories, tags, publish date
and comments were really hard to customize. It was used in multiple
places and was also reliant on font awesome for icons.

To provide a better out of the box experience the templates were
completely refactored and rebuilt from the ground up. A generic set was
introduced that provides a lot of flexibility without the need to touch the
templates at all. This set is now replacing all current usages of the
metadata.

The old metadata plugin will now throw a deprecation message and is
planned to be removed with Version 11. Instead of using the old one, there
are now two new plugins for post header and post footer that can be
configured individually through TypoScript constants. While the post
header plugin will also render the post title, the post footer will only render
the metadata for now. Also, the list rendering of posts has now two
dedicated sections for rendering the metadata.

Each section like authors or categories can be configured per position.
If you do not want to have a section rendered at all, you can also simply
disable it. If comments are disabled for a post, the comment section will
not be rendered.

We are now shipping 3 different layouts you can choose from that will
change the look of how the metadata will be displayed.

**Simple:**
Is a compact version, showing icon and value in one line.

**Condensed:**
In addition to the icon and value, there is now also a prefix visible.

**Extended:**
Prefix and value are now in separate lines.

You will find settings for this in the constant editor.
Example Configuration for the postheader position:

.. code-block:: typoscript

   plugin.tx_blog.settings.meta.postheader {
      enable = 1
      modifier = simple
      elements {
         authors {
            enable = 0
         }
         categories {
            enable = 0
         }
         tags {
            enable = 1
         }
         published {
            enable = 1
            format = %d.%m.%Y
         }
         comments {
            enable = 1
         }
      }
   }

Templates added:

- Partials/Meta/Default.html
- Partials/Meta/Elements/Authors.html
- Partials/Meta/Elements/Categories.html
- Partials/Meta/Elements/Comments.html
- Partials/Meta/Elements/Published.html
- Partials/Meta/Elements/Tags.html
- Partials/Meta/ListFooter.html
- Partials/Meta/ListHeader.html
- Partials/Meta/PostFooter.html
- Partials/Meta/PostHeader.html
- Partials/Meta/Rendering/Group.html
- Partials/Meta/Rendering/Item.html
- Partials/Meta/Rendering/Section.html
- Templates/Post/Footer.html
- Templates/Post/Header.html

Templates changed:

- Partials/General/BlogIcons.html
- Partials/List/Post.html
- Templates/Post/Metadata.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/28ef430ad58fa3d0ac22cd7b0a1fe6cfc33f621e
