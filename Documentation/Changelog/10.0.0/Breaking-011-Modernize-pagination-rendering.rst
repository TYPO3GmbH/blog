.. include:: ../../Includes.txt

========================================
Breaking: Modernize pagination rendering
========================================

Description
===========

The pagination rendering has been completely
reworked and is now more easy to customize without
overwriting the templates. Bootstrap specific markup
has been removed.

In addition to a new template, a11y has been
enhanced. We are now providing descriptive labels
for the pagination entries. A set of new language labels
have been introduced that you are now also able
to customize to your needs.

New labels:

- pagination.aria.label: Page navigation
- pagination.next: Next
- pagination.previous: Previous
- pagination.aria.current.page: Current page, page %s
- pagination.aria.goto.page: Go to page %s
- pagination.aria.goto.next: Go to next page
- pagination.aria.goto.previous: Go to previous page

Templates changed:

- Templates/ViewHelpers/Widget/Paginate/Index.html


Change
======

https://github.com/TYPO3GmbH/blog/commit/de0f9d209100ee04d235a73ccec584a1a3e9ddaa
