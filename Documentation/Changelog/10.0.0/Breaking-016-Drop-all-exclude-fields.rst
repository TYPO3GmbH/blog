.. include:: ../../Includes.txt

=================================
Breaking: Drop all exclude fields
=================================

Description
===========

All backend users now are NOT prevented from editing the field unless they are members
of a backend user group with this field added as an “Allowed Excludefield” (or “admin” user).


Change
======

https://github.com/TYPO3GmbH/blog/commit/d268ed030ea68ae263337673a93bf1fa8cc8db89
