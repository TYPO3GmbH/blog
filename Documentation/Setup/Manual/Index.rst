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

      .. code-block:: typoscript

         # Setup
         <INCLUDE_TYPOSCRIPT: source="FILE:EXT:blog/Configuration/TypoScript/Integration/setup.typoscript">

      .. code-block:: typoscript

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

   4. Configure the page ids in the typoscript constants

      These go either in the root template record or in the constants file of your sitepackage.

      .. code-block:: typoscript
         :linenos:

         plugin.tx_blog.settings.blogUid     = ID_of_Page_Blog
         plugin.tx_blog.settings.categoryUid = ID_of_Page_Categories
         plugin.tx_blog.settings.authorUid   = ID_of_Page_Authors
         plugin.tx_blog.settings.tagUid      = ID_of_Page_Tags
         plugin.tx_blog.settings.archiveUid  = ID_of_Page_Archive
         plugin.tx_blog.settings.storagePid  = ID_of_Page_Data

      .. tip::

         1. If you hover with your mouse over a page in the pagetree the tooltip will reveal the **"ID"** of that page
         2. You can use the constant editor in the template module and select **"TYPO3 BLOG"**
         3. You find all relevant page configuration in the Section **"Page ID settings"**

      .. image:: manual-4.png

   5. Configure the PageTS to point the blog to the storage folder "Data"

      .. code-block:: typoscript
         :linenos:

         TCEFORM.pages.tags.PAGE_TSCONFIG_ID       = ID_of_Page_Data
         TCEFORM.pages.authors.PAGE_TSCONFIG_ID    = ID_of_Page_Data
         TCEFORM.pages.categories.PAGE_TSCONFIG_ID = ID_of_Page_Data

      **Option A:**
      Add the configuration to the root page

      1. Select the page module
      2. Select and edit your root page
      3. Select the resources tab
      4. Add the "Page TSconfig" configuration

      .. image:: manual-5.png

      **Option B:**
      Add configuration to your Page TSconfig in your Sitepackage

   6. Frontend Routing

      The extension provides a frontend route enhancer configuration that
      you can include it in your site configuration.

      .. code-block:: yaml
         :linenos:

         imports:
            - { resource: "EXT:blog/Configuration/Routes/Default.yaml" }

      .. tip::

         You can find your site configuration in **./config/sites/<identifier>/config.yaml**

   7. Add Plugins to Blog Pages

      Example: Blog Listing

      1. Select the Page module
      2. Select the Blog page
      3. Click the Button to add content

      .. image:: manual-7-1.png

      4. Select the "Blog" tab
      5. Add plugin "Blog: List of posts"

      .. image:: manual-7-2.png

      +------------+------------------------+
      | Page       | Plugin                 |
      +============+========================+
      | Blog       | Blog: List of posts    |
      +------------+------------------------+
      | Authors    | Blog: List by author   |
      +------------+------------------------+
      | Categories | Blog: List by category |
      +------------+------------------------+
      | Tags       | Blog: List by tag      |
      +------------+------------------------+
      | Archive    | Blog: Archive          |
      +------------+------------------------+

   8. Congratulations

      Your blog is now ready, please read on in the capters about "how to add a blog post" and learn more about configuration options.

      .. image:: manual-8.png
