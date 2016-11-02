
README.rst
==========

:author: mb
:date:   2015-10-26

This folder ``_make`` is provided as a service for convenience.
It helps to render this documentation on your own machine
"at home".

It is a good idea to check whether the *conf.py* file in this
*\_make* folder is still up to date. The latest version should
be maintained here:
https://github.com/marble/typo3-docs-typo3-org-resources/blob/master/userroot/scripts/bin/conf-2015-10.py



Steps:
------

1. Prepare your machine!

   Follow the installation steps of
   http://mbless.de/blog/2015/01/26/sphinx-doc-installation-steps.html


2. On the commandline::

      cd  path/to/_make
      make
      make html


3. Open ``_make/build/html/Index.html`` in the browser.


4. Check ``_make/_not_versioned/`` for logfiles.


Enjoy!