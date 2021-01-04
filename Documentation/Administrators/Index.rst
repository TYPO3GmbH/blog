Blogging for Administrators
===========================


Setup
-----

Setup without Wizard
^^^^^^^^^^^^^^^^^^^^

To create a new blog setup, follow these steps:

1) Create the following page structure:

- Rootpage (contains the TypoScript and PageTS-Config)
- > Data (a folder to hold categories, authors and tags, but also blog posts are possible)
- > Category (this page is used to show blog posts, related to single category, or a category overview)
- > Tag (this page is used to show blog posts, related to single tag, or a tag overview)
- > Archive (this page is the archive, it lists all blog posts by given date (month and year, or year only)

2) Add at least the TypoScript template which is provided by the extension

3) Configure the page ids in the constants:

.. code-block:: ts

   plugin.tx_blog.settings.blogUid = NEW_blogRoot
   plugin.tx_blog.settings.categoryUid = NEW_blogCategoryPage
   plugin.tx_blog.settings.authorUid = NEW_blogAuthorPage
   plugin.tx_blog.settings.tagUid = NEW_blogTagPage
   plugin.tx_blog.settings.archiveUid = NEW_blogArchivePage
   plugin.tx_blog.settings.storagePid = NEW_blogFolder

.. note::

       If you have multiple folder or root pages for your blog posts your have
       to add all root pages to :typoscript:`plugin.tx_blog.settings.storagePid`
       as a comma separated list. The first value must be the value of NEW_blogFolder

4) Configure storage PIDs via PageTSConfig:

.. code-block:: ts

   TCEFORM.pages.tags.PAGE_TSCONFIG_ID =
   TCEFORM.pages.authors.PAGE_TSCONFIG_ID =
   TCEFORM.pages.categories.PAGE_TSCONFIG_ID =


Frontend Routing Setup
^^^^^^^^^^^^^^^^^^^^^^

The extension provides a frontend route enhancer configuration that you can include it in your site configuration.

.. code-block:: yaml

   imports:
     - { resource: "EXT:blog/Configuration/Routes/Default.yaml" }

Feel free to modify or enhance this configuration, feedback is welcome.


Plugin types
------------

The following plugins are available after installing the extension.


List of Posts by Date
^^^^^^^^^^^^^^^^^^^^^

Displays a list of blog posts ordered by date. All non-hidden, non-deleted and non-archived posts are shown in the list.

.. figure:: ../Images/Frontend/list.png
   :scale: 50%

   Frontend view of blog post list.

.. figure:: ../Images/Plugins/list.png

   Backend view of blog post list.


List by Tag
^^^^^^^^^^^^

Allows the users to show all posts tagged with a specific keyword.

.. image:: ../Images/Plugins/byTags.png


List by Category
^^^^^^^^^^^^^^^^

If you add this element and you have selected a category on the categories tab, it will show an overview of posts for
that category. If you have no categories selected, it will show an overview of categories.

.. image:: ../Images/Plugins/byCategory.png


List by Author
^^^^^^^^^^^^^^

Displays all posts belonging to the chosen author.

.. image:: ../Images/Plugins/byAuthor.png


List of related posts
^^^^^^^^^^^^^^^^^^^^^

Based on the categories and tags of the current post, it will show a list of related posts. This overview should only be
placed on a Blog detail page.

.. image:: ../Images/Plugins/relatedPosts.png


Archive
^^^^^^^

The archive plugin displays all posts categorized by year and month.

.. image:: ../Images/Plugins/archive.png


Other plugin types
^^^^^^^^^^^^^^^^^^

Additionally to the list plugin types there are several others meant to give you the maximum flexibility. If you are using the
templates included in the extension you won't need them as they represent parts you'd normally want to have at fixed positions
in your templates. For special circumstances we provide these plugins as standalone versions so you can use them in every
way you want:


Sidebar
"""""""

The sidebar contains links enabling the user to quickly navigate your blog. It shows an overview of recent posts and comments,
categories, tags and archive links.

.. figure:: ../Images/Frontend/sidebar.png
   :scale: 50%

   Sidebar of a blog


Metadata
""""""""
Displays post meta data, like date, tags, category...


Authors
"""""""
Displays post authors, like name, title, avatar, social links...


Comments / Comment Form
"""""""""""""""""""""""

Displays the comment form and comments to a post - be aware that commenting in general has to be globally enabled and the
respective post should have the commenting flag set.


Creating Categories and Tags
----------------------------

Categories are the default TYPO3 categories you probably already know.

Create a new category:

* Go to the list module
* Click on the page where you want to create the new category
* Click on the "new record" button on the top and choose category
* Enter a title for the category and choose a possible parent
* Click "Save"

Tags are blog specific records. Creating a new tag works in the same way as creating categories does:

* Go to list module
* Click on the page where you want to create the new tag
* Enter a title for the tag
* Click "Save"


AvatarProvider
--------------

The default AvatarProvider is the `GravatarProvider`, this means the avatar of an author is received from gravatar.com.
The extension provides also an `ImageProvider` for local stored images.

But you can also implement your own AvatarProvider:

1) Create a class which implements the `AvatarProviderInterface`.
2) Add your provider to the TCA field "avatar_provider" to make it selectable in the author record
