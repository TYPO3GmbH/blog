.. include:: ../../Includes.txt

===================================================
Breaking: Use TYPO3 Form Framework for comment form
===================================================

Description
===========

The required form markup can vary a lot depending on the
frontend implementation of the instance. To ease the
blog integration in all kinds of frontends we decided to
make use of the form framework of TYPO3.

By using the form framework the blog will automatically
respect the already configured forms of the typo3 instance.
This will remove the necessity to provide custom form
templates for the comment form of the blog extension.
This will also mean, thats its no longer possible to adjust
the comment form directly, since this is now generated
through the form framework API.

During the migration it was noticed that the google captcha
implementation is currently only compatible with v2, this
was added to the label for now to avoid configuration
confusions while generating API Keys at google.

Adjusted Templates:

- Templates/Comment/Form.html

New Templates:

- Partials/Comments/Form/Closed.html
- Partials/Comments/Form/Disqus.html
- Partials/Comments/Form/Local.html
- Partials/Form/GoogleCaptcha.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/407a2af699961f3c2726204f4a6c49e22e162a07
