.. include:: ../../Includes.txt

===================================
Breaking: Drop obsolete MetaService
===================================

Description
===========

The meta service is obsolete since TYPO3 v9 and is replaced
through the usage of the MetaTag-API from core. To migrate to
the new API you just need to remove all usages of the MetaService.


Change
======

https://github.com/TYPO3GmbH/blog/commit/7cd241b7b766dbddf473ef6f502fcc03c5da9fce
