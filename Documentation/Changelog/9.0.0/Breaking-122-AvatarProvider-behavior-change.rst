.. include:: ../../Includes.txt

=======================================================
Breaking: #EXTBLOG-122 - AvatarProvider behavior change
=======================================================

See https://jira.typo3.com/browse/EXTBLOG-122

Description
===========

The AvatarProvider will no longer be injected into the author model.
To make it possible to select the avatar provider on author record level, the behavior has changed.
The GravatarProvider is still the default provider, but can be changed for each author.

An UpgradeWizard will set the GravatarProvider for all authors. if a custom AvatarProvider is in use,
skip the UpgradeWizard and add the class name to the new field for all records.

Impact
======

Existing custom AvatarProvider must be adjusted and registered in the author TCA field "avatar_provider".

.. index:: Backend, Frontend, Database
