.. include:: ../../Includes.txt

=====================================================
Breaking: Drop social image wizard and prefer ext:seo
=====================================================

Description
===========

We are dropping the social image wizard and rely on the editor to create
custom images if necessary. The feature predated the core SEO-Initiative
that now handles social images through dedicated fields. We are strongly
recommending using core handling instead of the media fields.

The wizard itself had several drawbacks, it was hard to configure and
was not able to handle high-resolution images.


Change
======

https://github.com/TYPO3GmbH/blog/commit/2d2dc30ed5c04da73f714a195ac727ccce5214d3
