.. include:: ../../Includes.txt

================================================
Feature: Format new line to paragraph viewhelper
================================================

Description
===========

Most of the time the format nl2br viewhelper produces
unwanted and unnecessary line breaks where a paragraph
is actually the wanted result. The new viewhelper converts
linebreaks to actual paragraphs and cleans out empty
segments. In contrary to the form html viewhelper anything
else will be left untouched.


Change
======

https://github.com/TYPO3GmbH/blog/commit/7e4443ea3bc4059f91d7cd3d697e6962bee1e66d
