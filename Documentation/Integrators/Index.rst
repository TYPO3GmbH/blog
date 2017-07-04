Blogging for Integrators
========================


TypoScript Reference
--------------------

This section covers all settings, which can be defined by TypoScript.

.. contents::
   :local:
   :depth: 1

Settings (plugin.tx_blog.settings)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: ts-properties

   ==================================== ====================================== =============== ===============
   Property                             Title                                  Type            Default
   ==================================== ====================================== =============== ===============
   blogUid_                             UID of the blog start page             int             0
   categoryUid_                         UID of the category page               int             0
   tagUid_                              UID of the tag page                    int             0
   archiveUid_                          UID of the archive page                int             0
   authorUid_                           UID of the author page                 int             0
   storagePid_                          UID of the storage folder              int             0
   sidebarWidgets_                      List of active sidebar widgets         array           see description
   `list.posts.maximumDisplayedItems`_  Maximum posts to be displayed in list  int             0
   `list.posts.dateFormat`_             The date format for post lists         string          %d.%m.%Y
   widgets_                             Widget specific configuration          array           see description
   `comments.active`_                   Activate comments feature              int             1
   `comments.moderation`_               Activate comments moderation           int             0
   `comments.respectPostLanguageId`_    Respect language of post               int             1
   `authors.avatar.provider`_           AvatarProvider specific settings       array           see description
   ==================================== ====================================== =============== ===============

.. _tsBlogUid:

blogUid
"""""""
.. container:: table-row

   Property
         blogUid
   Data type
         int
   Description
         Define the uid of the blog start page.


.. _tsCategoryUid:

categoryUid
"""""""""""
.. container:: table-row

   Property
         categoryUid
   Data type
         int
   Description
         Define the uid of the category page.


.. _tsTagUid:

tagUid
""""""
.. container:: table-row

   Property
         tagUid
   Data type
         int
   Description
         Define the uid of the tag page.


.. _tsArchiveUid:

archiveUid
""""""""""
.. container:: table-row

   Property
         archiveUid
   Data type
         int
   Description
         Define the uid of the archive page.


.. _tsAuthorUid:

authorUid
"""""""""
.. container:: table-row

   Property
         authorUid
   Data type
         int
   Description
         Define the uid of the author page.


.. _tsStoragePid:

storagePid
""""""""""
.. container:: table-row

   Property
         storagePid
   Data type
         int
   Description
         Define the uid of the storage folder, which contains the categories and tags.


.. _tsSidebarWidgets:

sidebarWidgets
""""""""""""""
.. container:: table-row

   Property
         sidebarWidgets
   Data type
         array
   Description
         Define all active sidebar widgets and the ordering.

         The default active widgets:

         .. code-block:: ts

            plugin.tx_blog.settings.sidebarWidgets {
               10 = tt_content.list.20.blog_recentpostswidget
               20 = tt_content.list.20.blog_categorywidget
               30 = tt_content.list.20.blog_tagwidget
               40 = tt_content.list.20.blog_commentswidget
               50 = tt_content.list.20.blog_archivewidget
            }

         You can simply add and remove widgets, also pure TypoScript widgets are possible.
         All you need is to add the TypoScript path to this setting.


.. _tsListPostsMmaximumDisplayedItems:

list.posts.maximumDisplayedItems
""""""""""""""""""""""""""""""""
.. container:: table-row

   Property
         list.posts.maximumDisplayedItems
   Data type
         int
   Description
         Defines how many blog posts will be displayed in lists. Default is ``0``, which means no limit is applied.


.. _tsListPostDateFormat:

list.posts.dateFormat
"""""""""""""""""""""
.. container:: table-row

   Property
         list.posts.dateFormat
   Data type
         string
   Description
         Define the date format for blog posts in lists. Default: %d.%m.%Y


.. _tsWidgets:

widgets
"""""""
.. container:: table-row

   Property
         widgets
   Data type
         array
   Description
         Define widgets specific configuration. Please see the separate table `Settings (plugin.tx_blog.settings.widgets)`_.


.. _tsCommentsActive:

comments.active
"""""""""""""""
.. container:: table-row

   Property
         comments.active
   Data type
         int
   Description
         Activate the comments feature generally. Default: 1


.. _tsCommentsModeration:

comments.moderation
"""""""""""""""""""
.. container:: table-row

   Property
         comments.moderation
   Data type
         int
   Description
         Activate the comments moderation feature generally. Default: 0
         This means, any comment must be approved, before it is visible in the frontend.


.. _tsCommentsRespectPostLanguageId:

comments.respectPostLanguageId
""""""""""""""""""""""""""""""
.. container:: table-row

   Property
         comments.respectPostLanguageId
   Data type
         int
   Description
         In case of a multi language setup, the comments created in the frontend will be stored with a relation
         to the blog post (page) and with an relation to the current language.
         If this value is 0, all comments will we shown on all blog posts in each language.
         If this value is 1, comments will only be shown if blog post language id AND comment language id match or comment language id is -1 (which means all).

.. _tsAuthorsAvatarProvider:

authors.avatar.provider
"""""""""""""""""""""""
.. container:: table-row

   Property
         authors.avatar.provider
   Data type
         array
   Description
         Define AvatarProvider specific configuration. Please see the separate table for the default GravatarProvider `GravatarProvider Settings (plugin.tx_blog.settings.authors.avatar.provider)`_.
         To get more info about AvatarProviders, please see the AvatarProviders section in :doc:`../Administrators/Index`



Settings (plugin.tx_blog.settings.widgets)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: ts-properties

   ==================================== ====================================== =============== ===============
   Property                             Title                                  Type            Default
   ==================================== ====================================== =============== ===============
   `comments.limit`_                    Limit of visible comments              int             5
   `comments.blogSetup`_                blog setup pid for this widget         int             null
   `tags.limit`_                        Limit of visible tags                  int             20
   `tags.minSize`_                      Minimum size in percent                int             100
   `tags.maxSize`_                      Maximum size in percent                int             200
   `archive.showCounter`_               Show count of posts                    int             1
   `archive.groupByYear`_               Group by year                          int             1
   `archive.groupByMonth`_              Group by month                         int             1
   `archive.yearDateFormat`_            Format of the year                     string          %Y
   `archive.monthDateFormat`_           Format of the month                    string          %B
   `recentposts.limit`_                 Maximum number of posts to be shown    int             5
   ==================================== ====================================== =============== ===============

.. _tsWidgetsCommentsLimit:

comments.limit
""""""""""""""
.. container:: table-row

   Property
         comments.limit
   Data type
         int
   Description
         Define the limit of visible comments.


.. _tsWidgetsCommentsBlogSetup:

comments.blogSetup
""""""""""""""""""
.. container:: table-row

   Property
         comments.blogSetup
   Data type
         int
   Description
         Define the blogSetup (storage pid) of blog to show comments from.

.. _tsWidgetsTagsLimit:

tags.limit
""""""""""
.. container:: table-row

   Property
         tags.limit
   Data type
         int
   Description
         Define the limit of visible tags.


.. _tsWidgetsTagsMinSize:

tags.minSize
""""""""""""
.. container:: table-row

   Property
         tags.minSize
   Data type
         int
   Description
         Define the minimum size in percent for a tag.



.. _tsWidgetsTagsMaxSize:

tags.maxSize
""""""""""""
.. container:: table-row

   Property
         tags.maxSize
   Data type
         int
   Description
         Define the maximum size in percent for a tag.


.. _tsWidgetsArchiveShowCounter:

archive.showCounter
"""""""""""""""""""
.. container:: table-row

   Property
         archive.showCounter
   Data type
         int
   Description
         Define if the count of posts is visible in the links or not.


.. _tsWidgetsArchiveGroupByYear:

archive.groupByYear
"""""""""""""""""""
.. container:: table-row

   Property
         archive.groupByYear
   Data type
         int
   Description
         Define if the widget should show links for each year or not.
         This setting can be used in combination with :typoscript:`plugin.tx_blog.settings.widgets.archive.groupByMonth`


.. _tsWidgetsArchiveGroupBymonth:

archive.groupByMonth
""""""""""""""""""""
.. container:: table-row

   Property
         archive.groupByMonth
   Data type
         int
   Description
         Define if the widget should show links for each month or not.
         This setting can be used in combination with :typoscript:`plugin.tx_blog.settings.widgets.archive.groupByYear`


.. _tsWidgetsArchiveYearDateFormat:

archive.yearDateFormat
""""""""""""""""""""""
.. container:: table-row

   Property
         archive.yearDateFormat
   Data type
         int
   Description
         Define the format of the year link.


.. _tsWidgetsArchiveMonthDateFormat:

archive.monthDateFormat
"""""""""""""""""""""""
.. container:: table-row

   Property
         archive.monthDateFormat
   Data type
         int
   Description
         Define the format of the year link.

.. _tsWidgetsRecentPostsLimit:

recentposts.limit
"""""""""""""""""
.. container:: table-row

   Property
         recentposts.limit
   Data type
         int
   Description
         Define a maximum number of posts shown in the recent posts widget. Default: 5
         There is no limit if the setting is not present or set to: 0.


GravatarProvider Settings (plugin.tx_blog.settings.authors.avatar.provider)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: ts-properties

   ==================================== ====================================== =============== ===============
   Property                             Title                                  Type            Default
   ==================================== ====================================== =============== ===============
   `size`_                              Size in pixel                          int             64
   `default`_                           Default image                          string          mm
   `rating`_                            Gravatar rating                        string          g
   ==================================== ====================================== =============== ===============


.. _tsSize:

size
""""
.. container:: table-row

   Property
         size
   Data type
         int
   Description
         Define the size of the gravatar icon.


.. _tsDefault:

default
"""""""
.. container:: table-row

   Property
         default
   Data type
         string
   Description
         Define the default image, can be an absolute URL or one of the default gravatar icons:
         404, mm, identicon, monsterid, wavatar, retro, blank


.. _tsRating:

rating
""""""
.. container:: table-row

   Property
         rating
   Data type
         string
   Description
         Define the gravatar rating for images:
         g: suitable for display on all websites with any audience type.
         pg: may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
         r: may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
         x: may contain hardcore sexual imagery or extremely disturbing violence.
