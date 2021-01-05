.. include:: ../../Includes.txt

.. _SetupManual:

============
Manual Setup
============

The manual setup helps you to build an **integrated** instance of the TYPO3 Blog
Extension. If you want a standalone Blog and do not have an existing
site, please go with the :ref:`Setup Wizard <SetupWizard>` instructions.

Prerequisites:

1. Ensure the TYPO3 Blog Extension is :ref:`installed and activated <Installation>`
2. Ensure your logged in as **Administrator**

.. rst-class:: bignums

   1. Open your existing template record (optional)

      .. image:: manual-1.png

   2. Add the static template to your existing template

      **Option A:** Add the static template to your existing template record

      .. image:: manual-2.png

      **Option B:** Add nessesary includes to your sitepackage

      .. code-block:: ts

         # Setup
         <INCLUDE_TYPOSCRIPT: source="FILE:EXT:blog/Configuration/TypoScript/Integration/setup.typoscript">

      .. code-block:: ts

         # Constants
         <INCLUDE_TYPOSCRIPT: source="FILE:EXT:blog/Configuration/TypoScript/Integration/constants.typoscript">

   3. Create Blog Pages

      1. Right click the page you want the Blog to list below
      2. Select "More options"
      3. Select "Create multiple pages"

      .. image:: manual-3-1.png

      .. image:: manual-3-2.png

      Create the following Pages, make sure they have the correct **Type**

      +-------------+-------------+
      | Name        | Type        |
      +=============+=============+
      | Blog        | Blog Page   |
      +-------------+-------------+
      | Authors     | Blog Page   |
      +-------------+-------------+
      | Categories  | Blog Page   |
      +-------------+-------------+
      | Tags        | Blog Page   |
      +-------------+-------------+
      | Archive     | Blog Page   |
      +-------------+-------------+
      | Data        | Folder      |
      +-------------+-------------+

      Edit the newly generated Data folder to contain the "Blog"

      4. Edit the page "Data" and select the "Behaviour" tab
      5. Select "Blog" at "Contains Plugin"
      6. Save the Page

      .. image:: manual-3-3.png

      Sort the pages like the following screenshot

      .. image:: manual-3-4.png

   4. Configure the page ids in the constants. This constants go either in the constants of the root template (id=1) or, even better, in the constants.typoscript file in the sitepackage.

      .. code-block:: ts
         :linenos:

         plugin.tx_blog.settings.blogUid     = NEW_blogRoot
         plugin.tx_blog.settings.categoryUid = NEW_blogCategoryPage
         plugin.tx_blog.settings.authorUid   = NEW_blogAuthorPage
         plugin.tx_blog.settings.tagUid      = NEW_blogTagPage
         plugin.tx_blog.settings.archiveUid  = NEW_blogArchivePage
         plugin.tx_blog.settings.storagePid  = NEW_blogFolder

   5. In the template of the root page of the site (id=1), include the static template. Please go with either Integration or Expert template.

      Frontend view of blog post list.
      Backend view of blog post list.

   6. The root page of the blog tree, in this case the page with id = 6, will carry the Page TSconfig entries. These point all to the storage folder, in this case id = 7.

      .. code-block:: ts
         :linenos:

         TCEFORM.pages.tags.PAGE_TSCONFIG_ID       = 7
         TCEFORM.pages.authors.PAGE_TSCONFIG_ID    = 7
         TCEFORM.pages.categories.PAGE_TSCONFIG_ID = 7

   7. Frontend Routing

      The extension provides a frontend route enhancer configuration that you can include it in your site configuration.

      .. code-block:: yaml
         :linenos:

         imports:
         - { resource: "EXT:blog/Configuration/Routes/Default.yaml" }

      Feel free to modify or enhance this configuration, feedback is welcome.

This rounds up the manual installation method.

.. note::

   If you have multiple folder or root pages for your blog posts your have to
   add all root pages to :typoscript:`plugin.tx_blog.settings.storagePid` as a
   comma separated list. The first value must be the value of NEW_blogFolder
