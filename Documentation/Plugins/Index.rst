.. include:: ../Includes.txt

.. _Plugins:

=======
Plugins
=======


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


Latest posts
""""""""""""
This plugin is new. It allows to configure how many of the latest news shall be displayed in a list with the same format as the list of posts plugin.


Header and Footer
"""""""""""""""""
These two plugins are also new. They are meant to be used solely inside a post and if you apply these plugins in a different context, you will get an error message in the frontend. All meta data is now displayed with either one of the two plugins or through a combination of both.


Metadata
""""""""
This plugin is the old way of dealing with metadata and is currently deprecated. You are recommended to use Header and/or Footer to display meta data, like date, tags and category. The metadata plugin wil be removed in the upcoming version of the Blog extension.


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

Enable sharing
--------------
No implementation is provided by the blog extension itself. Of course you can still use an extension like the Shariff implementation for TYPO3 in your custom templates.


AvatarProvider
--------------
The default AvatarProvider is the GravatarProvider, this means the avatar of an author is received from gravatar.com. The extension provides also an ImageProvider for local stored images.

But you can also implement your own AvatarProvider:

1. Create a class which implements the AvatarProviderInterface.
2. Add your provider to the TCA field “avatar_provider” to make it selectable in the author record

**Note:** Since v10 the proxying of gravatar loading is used which means that TYPO3 downloads the gravatar, stores it on the filesystem and delivers the image locally from typo3temp. This is privacy related and useful if users didn't give their consent for fetching gravatars client side.
