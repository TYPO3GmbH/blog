.. include:: ../../Includes.txt

=========================================
Breaking: Modernize post author rendering
=========================================

Description
===========

The author rendering has been completely reworks and is now
more easy to customize without overwriting the templates. Bootstrap
and FontAwesome specific classes were completely removed and
we now deliver some basic css to achieve better results.

Rendering is now more resilient and only renders elements
if necessary. Each element can be identified through specific
classes on the markup. Flexbox is used for alignment and can be
used to reorder the rendering without touching the templates.

Icons for social links now are now delivered by default as svgs
and are rendered inline, this makes them easy to style and adjust.
A new template has been introduced that only delivers the markup
for the icons. This can be overwritten if you want to exchange the
icons used. Default avatar size was also slightly increased to better
match renderings.

Configuration changed:

- avatar.provider.size: 64 -> 72

Templates changed or added:

- Partials/General/SocialIcons.html
- Partials/Post/Author.html
- Templates/Post/Authors.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/a17891e087e97be8346bf65484c30480a0edc7c2
