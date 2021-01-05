.. include:: ../../Includes.txt

============
Manual Setup
============

.. rst-class:: bignums

   1. Create the following page structure:

      .. image:: manual-1.png

      In the picture above, the existing site is represented by the pages with ids 1 through 5.

      * A standard page (id = 6) is the root page of the blog tree. It holds the Page TSconfig.
      * Data (a folder to hold categories, authors and tags, but also blog posts are possible)
      * Category (this page is used to show blog posts, related to single category, or a category overview)
      * Tag (this page is used to show blog posts, related to single tag, or a tag overview)
      * Archive (this page is the archive, it lists all blog posts by given date (month and year, or year only

   2. Configure the page ids in the constants. This constants go either in the constants of the root template (id=1) or, even better, in the constants.typoscript file in the sitepackage.

      .. code-block:: ts
         :linenos:

         plugin.tx_blog.settings.blogUid     = NEW_blogRoot
         plugin.tx_blog.settings.categoryUid = NEW_blogCategoryPage
         plugin.tx_blog.settings.authorUid   = NEW_blogAuthorPage
         plugin.tx_blog.settings.tagUid      = NEW_blogTagPage
         plugin.tx_blog.settings.archiveUid  = NEW_blogArchivePage
         plugin.tx_blog.settings.storagePid  = NEW_blogFolder

   3. In the template of the root page of the site (id=1), include the static template. Please go with either Integration or Expert template.

      Frontend view of blog post list.
      Backend view of blog post list.

   4. The root page of the blog tree, in this case the page with id = 6, will carry the Page TSconfig entries. These point all to the storage folder, in this case id = 7.

      .. code-block:: ts
         :linenos:

         TCEFORM.pages.tags.PAGE_TSCONFIG_ID       = 7
         TCEFORM.pages.authors.PAGE_TSCONFIG_ID    = 7
         TCEFORM.pages.categories.PAGE_TSCONFIG_ID = 7

   5. Frontend Routing

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
