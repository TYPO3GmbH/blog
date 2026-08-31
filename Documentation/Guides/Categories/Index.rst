.. include:: ../../Includes.txt

.. _GuideCategories:

==========
Categories
==========

Create a new Category
---------------------

.. rst-class:: bignums

   1. Go to the list module
   2. Click on the page where you want to create the new category
   3. Click on the "new record" button on the top and choose category
   4. Enter a title for the category and choose a possible parent
   5. Click "Save"

.. _GuideCategoriesTargetPage:

Use an own page for a category
------------------------------

By default the blog renders every category on the automatically generated
category page, for example :file:`/blog/category/my-category`. If editors
should be able to arrange additional content around the post listing of a
category, a regular page can be used instead.

.. rst-class:: bignums

   1. Create a page and add the "Blog: List by category" plugin to it
   2. Assign the category to that plugin (field "Categories")
   3. Open the category record and select the page in the field "Category page"
   4. Click "Save"

From now on

*  every link to that category points to the assigned page,
*  the automatically generated category URL redirects to the assigned page
   with a permanent redirect,
*  the RSS feed of the category is still delivered by the automatically
   generated category page.

Categories without an assigned page are not affected and keep using the
automatically generated category page.

If the overview of all categories is maintained as an own page as well, set
the page id in the site settings. The automatically generated overview then
redirects to that page:

.. code-block:: yaml
   :linenos:

   plugin:
      tx_blog:
         settings:
            categoryOverviewUid: ID_of_Page_Category_Overview
