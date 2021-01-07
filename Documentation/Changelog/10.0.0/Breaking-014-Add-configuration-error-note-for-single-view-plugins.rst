.. include:: ../../Includes.txt

==============================================================
Breaking: Add configuration error note for single view plugins
==============================================================

Description
===========

To prevent the usage of plugins that should only be
used on post views we are now adding additional
checks for those. If no post could be resolved - also
means if the plugin is used on pages that do not match
the `Constants::DOKTYPE_BLOG_POST` - the plugins will
now return a new message to make the miss usage visible.

```
A possible configuration error was detected.
No matching post could be obtained.
Make sure that this plugin is only used on a post.
```

The following plugins will now show this message if no
post could be obtained:

- Authors
- Footer
- Header
- Metadata
- RelatedPosts

Templates added:

- Layouts/Post.html

Templates changed:

- Templates/Comment/Comments.html
- Templates/Comment/Form.html
- Templates/Post/Authors.html
- Templates/Post/Footer.html
- Templates/Post/Header.html
- Templates/Post/Metadata.html
- Templates/Post/RelatedPosts.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/780f018b51e7db2a700f98d79c281dbad74005e9
