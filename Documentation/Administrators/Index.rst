Blogging for Administrators
===========================


Installation
------------

The extension needs to be installed as any other extension of TYPO3 CMS:

#. Switch to the module “Extension Manager”.

#. Get the extension

   #. **Get it from the Extension Manager:** Press the “Retrieve/Update”
      button and search for the extension key *blog* and import the
      extension from the repository.

   #. **Get it from typo3.org:** You can always get current version from
      `https://typo3.org/extensions/repository/view/blog/current/
      <https://typo3.org/extensions/repository/view/blog/current/>`_ by
      downloading either the t3x or zip version. Upload
      the file afterwards in the Extension Manager.

   #. **Use composer**: Use `composer require T3G/blog`.

Latest version from git
-----------------------
You can get the latest version from git by using the git command:

.. code-block:: bash

   git clone ssh://git@bitbucket.typo3.com:7999/ext/blog.git


Setup
-----

Use the Setup Wizard
^^^^^^^^^^^^^^^^^^^^

The Setup Wizard creates the recommended pagetree and it will add all configurations and plugins you need.

To create a new blog setup, follow these steps:

1. Click on the blog admin module
2. Click on the "Setup a new blog" button

.. figure:: ../Images/Backend/setup_wizard_1.png

   Create a new blog setup structure

3. Enter a title for the blog setup
4. If the extension "blog_template" is installed, you can use the provided template by enabling the checkbox.
   If the extension "blog_template" is **not** installed, you can install and use it by enabling the checkbox.
5. Click on the "Setup" button, to create the blog setup.

.. figure:: ../Images/Backend/setup_wizard_2.png

   Modal with setup options

6. If the success message appears, the setup is done. Go to your page tree (maybe reload the tree) and you will see the generated page structure.

.. figure:: ../Images/Backend/setup_wizard_3.png

   The generated page structure

The Setup Wizard creates the following pages for you:

- Rootpage (hidden by default, contains the TypoScript and PageTS-Config)
- > Data (a folder to hold categories and tags)
- > Category (this page is used to show blog posts, related to single category, or a category overview)
- > Tag (this page is used to show blog posts, related to single tag, or a tag overview)
- > Archive (this page is the archive, it lists all blog posts by given date (month and year, or year only)
- > First blog post (yes, a first blog post, as an example)


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

Displays all posts belonging to the chosen category.

.. image:: ../Images/Plugins/byCategory.png


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
Displays post meta data, like date, tags, category, sharing links...


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

To enable sharing go to the page properties of your blog entry and set the check box "Sharing enabled"