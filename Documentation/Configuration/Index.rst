.. include:: ../Includes.txt

.. _Configuration:

=============
Configuration
=============

TypoScript Reference
====================

This section covers all settings, which can be defined by TypoScript Constants.

.. contents::
   :local:
   :depth: 2

TYPO3 Blog
----------

Page ID settings
^^^^^^^^^^^^^^^^

====================================== ======= ==========
Property                               Type    Default
====================================== ======= ==========
plugin.tx_blog.settings.blogUid_       int+    0
plugin.tx_blog.settings.authorUid_     int+    0
plugin.tx_blog.settings.categoryUid_   int+    0
plugin.tx_blog.settings.tagUid_        int+    0
plugin.tx_blog.settings.archiveUid_    int+    0
plugin.tx_blog.settings.storagePid_    int+    0
====================================== ======= ==========

plugin.tx_blog.settings.blogUid
"""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.blogUid
   Data type
     int+
   Default
     0
   Description
     **List posts UID:**
     Location of the "Blog: List of posts" plugin. This page UID is the root page for the blog. All blog post pages are located below this page.

plugin.tx_blog.settings.authorUid
"""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.authorUid
   Data type
     int+
   Default
     0
   Description
     **Author UID:**
     Location of the "Blog: Author" plugin. Shows posts by author.

plugin.tx_blog.settings.categoryUid
"""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.categoryUid
   Data type
     int+
   Default
     0
   Description
     **List by category UID:**
     Location of the "Blog: List by category" plugin. Shows all posts from one category.

plugin.tx_blog.settings.tagUid
""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.tagUid
   Data type
     int+
   Default
     0
   Description
     **List by tags UID:**
     Location of the "Blog: List by tags" plugin. Shows all posts from one tag.

plugin.tx_blog.settings.archiveUid
""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.archiveUid
   Data type
     int+
   Default
     0
   Description
     **Archive UID:**
     Location of the "Blog: Archive" plugin. Shows archived posts.

plugin.tx_blog.settings.storagePid
""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.storagePid
   Data type
     int+
   Default
     0
   Description
     **Storage folder:**
     Storage folder of all categories and tags for this blog.

Templates
^^^^^^^^^

=============================================== ========= ==============================================
Property                                        Type      Default
=============================================== ========= ==============================================
plugin.tx_blog.view.templateRootPaths_          string    EXT:blog/Resources/Private/Templates/
plugin.tx_blog.view.partialRootPaths_           string    EXT:blog/Resources/Private/Partials/
plugin.tx_blog.view.layoutRootPaths_            string    EXT:blog/Resources/Private/Layouts/
plugin.tx_blog.view.widget.templateRootPaths_   string    EXT:blog/Resources/Private/Templates/
plugin.tx_blog.view.emails.templateRootPaths_   string    EXT:blog/Resources/Private/Mails/Templates/
plugin.tx_blog.view.emails.partialRootPaths_    string    EXT:blog/Resources/Private/Mails/Partials/
plugin.tx_blog.view.emails.layoutRootPaths_     string    EXT:blog/Resources/Private/Mails/Layouts/
=============================================== ========= ==============================================

plugin.tx_blog.view.templateRootPaths
"""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.templateRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Templates/
   Description
     **Template Root Path:**
     Path to templates folder

plugin.tx_blog.view.partialRootPaths
""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.partialRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Partials/
   Description
     **Partial Root Path:**
     Path to partial folder

plugin.tx_blog.view.layoutRootPaths
"""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.layoutRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Layouts/
   Description
     **Layout Root Path:**
     Path to layout folder

plugin.tx_blog.view.widget.templateRootPaths
""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.widget.templateRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Templates/
   Description
     **Widget-Template Root Path:**
     Path to templates folder

plugin.tx_blog.view.emails.templateRootPaths
""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.emails.templateRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Mails/Templates/
   Description
     **Email-Template Root Path:**
     Path to templates folder

plugin.tx_blog.view.emails.partialRootPaths
"""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.emails.partialRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Mails/Partials/
   Description
     **Email-Partial Root Path:**
     Path to partial folder

plugin.tx_blog.view.emails.layoutRootPaths
""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.view.emails.layoutRootPaths
   Data type
     string
   Default
     EXT:blog/Resources/Private/Mails/Layouts/
   Description
     **Email-Layout Root Path:**
     Path to layout folder

Listings
^^^^^^^^

================================================================ ========= ===========
Property                                                         Type      Default
================================================================ ========= ===========
plugin.tx_blog.settings.lists.pagination.itemsPerPage_           int+      10
plugin.tx_blog.settings.lists.pagination.insertAbove_            int+      0
plugin.tx_blog.settings.lists.pagination.insertBelow_            int+      1
plugin.tx_blog.settings.lists.pagination.maximumNumberOfLinks_   int+      10
plugin.tx_blog.settings.lists.posts.maximumDisplayedItems_       int+      0
plugin.tx_blog.settings.lists.posts.dateFormat_                  string    %d.%m.%Y
plugin.tx_blog.settings.latestPosts.limit_                       int+      3
plugin.tx_blog.settings.relatedPosts.limit_                      int+      5
plugin.tx_blog.settings.relatedPosts.categoryMultiplier_         int+      1
plugin.tx_blog.settings.relatedPosts.tagMultiplier_              int+      1
================================================================ ========= ===========

plugin.tx_blog.settings.lists.pagination.itemsPerPage
"""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.pagination.itemsPerPage
   Data type
     int+
   Default
     10
   Description
     **Number of post that should be displayed per page:**

plugin.tx_blog.settings.lists.pagination.insertAbove
""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.pagination.insertAbove
   Data type
     int+
   Default
     0
   Description
     **Show the pagination above the posts:**

plugin.tx_blog.settings.lists.pagination.insertBelow
""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.pagination.insertBelow
   Data type
     int+
   Default
     1
   Description
     **Show the pagination below the posts:**

plugin.tx_blog.settings.lists.pagination.maximumNumberOfLinks
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.pagination.maximumNumberOfLinks
   Data type
     int+
   Default
     10
   Description
     **Maximum number of links in the pagination:**

plugin.tx_blog.settings.lists.posts.maximumDisplayedItems
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.posts.maximumDisplayedItems
   Data type
     int+
   Default
     0
   Description
     **Maximum displayed items:**
     Maximum number of posts to be displayed (0 = no limit).

plugin.tx_blog.settings.lists.posts.dateFormat
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.posts.dateFormat
   Data type
     string
   Default
     %d.%m.%Y
   Description
     **Date format:**
     The format for the list items (default: %d.%m.%Y).

plugin.tx_blog.settings.latestPosts.limit
"""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.latestPosts.limit
   Data type
     int+
   Default
     3
   Description
     **Limit:**
     The limit of displayed items (default: 3).

plugin.tx_blog.settings.relatedPosts.limit
""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.relatedPosts.limit
   Data type
     int+
   Default
     5
   Description
     **Limit:**
     The limit of displayed items (default: 5).

plugin.tx_blog.settings.relatedPosts.categoryMultiplier
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.relatedPosts.categoryMultiplier
   Data type
     int+
   Default
     1
   Description
     **Category Multiplier:**
     The multiplier for categories (default: 1).

plugin.tx_blog.settings.relatedPosts.tagMultiplier
""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.relatedPosts.tagMultiplier
   Data type
     int+
   Default
     1
   Description
     **Tag Multiplier:**
     The multiplier for tags (default: 1).

Listings: Archive
^^^^^^^^^^^^^^^^^

================================================== ========== ==========
Property                                           Type       Default
================================================== ========== ==========
plugin.tx_blog.settings.archive.showCounter_       boolean    1
plugin.tx_blog.settings.archive.yearDateFormat_    string     %Y
plugin.tx_blog.settings.archive.monthDateFormat_   string     %B
================================================== ========== ==========

plugin.tx_blog.settings.archive.showCounter
"""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.archive.showCounter
   Data type
     boolean
   Default
     1
   Description
     **Show counter:**
     If enabled, the count of posts is visible (default: 1).

plugin.tx_blog.settings.archive.yearDateFormat
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.archive.yearDateFormat
   Data type
     string
   Default
     %Y
   Description
     **Year format:**
     The format of the year (default: %Y).

plugin.tx_blog.settings.archive.monthDateFormat
"""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.archive.monthDateFormat
   Data type
     string
   Default
     %B
   Description
     **Month format:**
     The format of the month (default: %B).

Widget: Comment
^^^^^^^^^^^^^^^

================================================= ======= ==========
Property                                          Type    Default
================================================= ======= ==========
plugin.tx_blog.settings.widgets.comments.limit_   int+    5
================================================= ======= ==========

plugin.tx_blog.settings.widgets.comments.limit
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.comments.limit
   Data type
     int+
   Default
     5
   Description
     **Limit:**
     The limit of displayed items (default: 5).

Widget: Recent posts
^^^^^^^^^^^^^^^^^^^^

==================================================== ======= ==========
Property                                             Type    Default
==================================================== ======= ==========
plugin.tx_blog.settings.widgets.recentposts.limit_   int+    5
==================================================== ======= ==========

plugin.tx_blog.settings.widgets.recentposts.limit
"""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.recentposts.limit
   Data type
     int+
   Default
     5
   Description
     **Limit:**
     The limit of displayed items (default: 5).

Widget: Tags
^^^^^^^^^^^^

=============================================== ======= ==========
Property                                        Type    Default
=============================================== ======= ==========
plugin.tx_blog.settings.widgets.tags.limit_     int+    20
plugin.tx_blog.settings.widgets.tags.minSize_   int+    100
plugin.tx_blog.settings.widgets.tags.maxSize_   int+    100
=============================================== ======= ==========

plugin.tx_blog.settings.widgets.tags.limit
""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.tags.limit
   Data type
     int+
   Default
     20
   Description
     **Limit:**
     The limit of displayed items (default: 20).

plugin.tx_blog.settings.widgets.tags.minSize
""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.tags.minSize
   Data type
     int+
   Default
     100
   Description
     **Minimum size:**
     The minimum size of the font (default: 100).

plugin.tx_blog.settings.widgets.tags.maxSize
""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.tags.maxSize
   Data type
     int+
   Default
     100
   Description
     **Maximum size:**
     The maximum size of the font (default: 200).

Widget: Archive
^^^^^^^^^^^^^^^

========================================================== ========== ==========
Property                                                   Type       Default
========================================================== ========== ==========
plugin.tx_blog.settings.widgets.archive.showCounter_       boolean    1
plugin.tx_blog.settings.widgets.archive.groupByYear_       boolean    1
plugin.tx_blog.settings.widgets.archive.groupByMonth_      boolean    1
plugin.tx_blog.settings.widgets.archive.yearDateFormat_    string     %Y
plugin.tx_blog.settings.widgets.archive.monthDateFormat_   string     %B
========================================================== ========== ==========

plugin.tx_blog.settings.widgets.archive.showCounter
"""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.archive.showCounter
   Data type
     boolean
   Default
     1
   Description
     **Show counter:**
     If enabled, the count of posts is visible (default: 1).

plugin.tx_blog.settings.widgets.archive.groupByYear
"""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.archive.groupByYear
   Data type
     boolean
   Default
     1
   Description
     **Group by year:**
     If enabled, the posts are grouped by year (default: 1).

plugin.tx_blog.settings.widgets.archive.groupByMonth
""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.archive.groupByMonth
   Data type
     boolean
   Default
     1
   Description
     **Group by month:**
     If enabled, the posts are grouped by year and month (default: 1).

plugin.tx_blog.settings.widgets.archive.yearDateFormat
""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.archive.yearDateFormat
   Data type
     string
   Default
     %Y
   Description
     **Year format:**
     The format of the year (default: %Y).

plugin.tx_blog.settings.widgets.archive.monthDateFormat
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.widgets.archive.monthDateFormat
   Data type
     string
   Default
     %B
   Description
     **Month format:**
     The format of the month (default: %B).

Comments
^^^^^^^^

================================================================ ================== ============
Property                                                         Type               Default
================================================================ ================== ============
plugin.tx_blog.settings.comments.active_                         boolean            1
plugin.tx_blog.settings.comments.features.urls_                  boolean            0
plugin.tx_blog.settings.comments.moderation_                     options[0,1,2]     0
plugin.tx_blog.settings.comments.respectPostLanguageId_          options[0,1,-1]    1
plugin.tx_blog.settings.comments.date.format_                    string             %B %e, %Y
plugin.tx_blog.settings.comments.disqus_                         boolean            0
plugin.tx_blog.settings.comments.disqus.shortname_               string
plugin.tx_blog.settings.comments.google_recaptcha_               boolean            0
plugin.tx_blog.settings.comments.google_recaptcha.website_key_   string
plugin.tx_blog.settings.comments.google_recaptcha.secret_key_    string
================================================================ ================== ============

plugin.tx_blog.settings.comments.active
"""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.active
   Data type
     boolean
   Default
     1
   Description
     **Enable Comments:**
     Activate comments as a general feature

plugin.tx_blog.settings.comments.features.urls
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.features.urls
   Data type
     boolean
   Default
     0
   Description
     **Enable Urls:**
     Activate the url field in the comment form and output the submitted url

plugin.tx_blog.settings.comments.moderation
"""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.moderation
   Data type
     options[0,1,2]
   Default
     0
   Description
     **Comments moderation mode:**
     0 = no moderation, 1 = moderation active, 2 = moderation only on first comment

plugin.tx_blog.settings.comments.respectPostLanguageId
""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.respectPostLanguageId
   Data type
     options[0,1,-1]
   Default
     1
   Description
     **Respect post_language_id:**
     0 = show all comments also on translated posts, 1 = show only comments written in current language or language all (-1)

plugin.tx_blog.settings.comments.date.format
""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.date.format
   Data type
     string
   Default
     %B %e, %Y
   Description
     **Date format:**
     The format for the comments (default: %B %e, %Y).

plugin.tx_blog.settings.comments.disqus
"""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.disqus
   Data type
     boolean
   Default
     0
   Description
     **Enable Disqus:**
     Use disqus instead of internal comments?

plugin.tx_blog.settings.comments.disqus.shortname
"""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.disqus.shortname
   Data type
     string
   Description
     **Disqus shortname:**
     The shortname / forum id of your disqus setup.

plugin.tx_blog.settings.comments.google_recaptcha
"""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.google_recaptcha
   Data type
     boolean
   Default
     0
   Description
     **Google Recaptcha v2:**
     Enable google recaptcha for comments?

plugin.tx_blog.settings.comments.google_recaptcha.website_key
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.google_recaptcha.website_key
   Data type
     string
   Description
     **Google Recaptcha Website-Key:**

plugin.tx_blog.settings.comments.google_recaptcha.secret_key
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.comments.google_recaptcha.secret_key
   Data type
     string
   Description
     **Google Recaptcha Secrete-Key:**

Authors
^^^^^^^

========================================================== ======================= ==========
Property                                                   Type                    Default
========================================================== ======================= ==========
plugin.tx_blog.settings.authors.avatar.provider.size_      int+                    72
plugin.tx_blog.settings.authors.avatar.provider.default_   string                  mm
plugin.tx_blog.settings.authors.avatar.provider.rating_    options[g, pg, r, x]    g
========================================================== ======================= ==========

plugin.tx_blog.settings.authors.avatar.provider.size
""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.authors.avatar.provider.size
   Data type
     int+
   Default
     72
   Description
     **Author Avatar Size:**
     The size in px for the author avatar

plugin.tx_blog.settings.authors.avatar.provider.default
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.authors.avatar.provider.default
   Data type
     string
   Default
     mm
   Description
     **Author Avatar Default:**
     The default image for an author avatar

plugin.tx_blog.settings.authors.avatar.provider.rating
""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.authors.avatar.provider.rating
   Data type
     options[g, pg, r, x]
   Default
     g
   Description
     **Define the gravatar rating for images:**
      g: suitable for display on all websites with any audience type.
      pg: may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
      r: may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
      x: may contain hardcore sexual imagery or extremely disturbing violence.

Notifications
^^^^^^^^^^^^^

============================================================================= ========== =======================
Property                                                                      Type       Default
============================================================================= ========== =======================
plugin.tx_blog.settings.notifications.email.senderName_                       string     TYPO3 Blog
plugin.tx_blog.settings.notifications.email.senderMail_                       string     no-reply@example.com
plugin.tx_blog.settings.notifications.CommentAddedNotification.author_        boolean    1
plugin.tx_blog.settings.notifications.CommentAddedNotification.admin_         boolean    1
plugin.tx_blog.settings.notifications.CommentAddedNotification.admin.email_   string     admin@example.com
============================================================================= ========== =======================

plugin.tx_blog.settings.notifications.email.senderName
""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.notifications.email.senderName
   Data type
     string
   Default
     TYPO3 Blog
   Description
     **Sender name:**
     Global sender name for notifications

plugin.tx_blog.settings.notifications.email.senderMail
""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.notifications.email.senderMail
   Data type
     string
   Default
     no-reply@example.com
   Description
     **Sender mail:**
     Global sender email address for notifications

plugin.tx_blog.settings.notifications.CommentAddedNotification.author
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.notifications.CommentAddedNotification.author
   Data type
     boolean
   Default
     1
   Description
     **Author notifications:**
     Send notification to author of a blog post

plugin.tx_blog.settings.notifications.CommentAddedNotification.admin
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.notifications.CommentAddedNotification.admin
   Data type
     boolean
   Default
     1
   Description
     **Admin notifications:**
     Send notification to admin of the blog

plugin.tx_blog.settings.notifications.CommentAddedNotification.admin.email
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.notifications.CommentAddedNotification.admin.email
   Data type
     string
   Default
     admin@example.com
   Description
     **Admin mail:**
     Global admin (receiver) email address for notifications

TYPO3 Blog: Post
----------------

Featured Image
^^^^^^^^^^^^^^

==================================================== ========= ==========
Property                                             Type      Default
==================================================== ========= ==========
plugin.tx_blog.settings.post.featuredImage.width_    string    1140
plugin.tx_blog.settings.post.featuredImage.height_   string    400c
==================================================== ========= ==========

plugin.tx_blog.settings.post.featuredImage.width
""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.post.featuredImage.width
   Data type
     string
   Default
     1140
   Description
     **Width:**

plugin.tx_blog.settings.post.featuredImage.height
"""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.post.featuredImage.height
   Data type
     string
   Default
     400c
   Description
     **Height:**

Post Header
^^^^^^^^^^^

========================================================================= =============================================== ===========
Property                                                                  Type                                            Default
========================================================================= =============================================== ===========
plugin.tx_blog.settings.meta.postheader.enable_                           boolean                                         1
plugin.tx_blog.settings.meta.postheader.modifier_                         options[simple, condensed, extended, modern]    simple
plugin.tx_blog.settings.meta.postheader.elements.authors.enable_          boolean                                         1
plugin.tx_blog.settings.meta.postheader.elements.authors.avatar.enable_   boolean                                         0
plugin.tx_blog.settings.meta.postheader.elements.authors.avatar.size_     int+                                            20
plugin.tx_blog.settings.meta.postheader.elements.categories.enable_       boolean                                         0
plugin.tx_blog.settings.meta.postheader.elements.tags.enable_             boolean                                         0
plugin.tx_blog.settings.meta.postheader.elements.published.enable_        boolean                                         1
plugin.tx_blog.settings.meta.postheader.elements.published.format_        string                                          %d.%m.%Y
plugin.tx_blog.settings.meta.postheader.elements.comments.enable_         boolean                                         1
========================================================================= =============================================== ===========

plugin.tx_blog.settings.meta.postheader.enable
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.enable
   Data type
     boolean
   Default
     1
   Description
     **Display meta information in the header:**

plugin.tx_blog.settings.meta.postheader.modifier
""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.modifier
   Data type
     options[simple, condensed, extended, modern]
   Default
     simple
   Description
     **Meta information display style:**

plugin.tx_blog.settings.meta.postheader.elements.authors.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.authors.enable
   Data type
     boolean
   Default
     1
   Description
     **Show authors in the meta section:**

plugin.tx_blog.settings.meta.postheader.elements.authors.avatar.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.authors.avatar.enable
   Data type
     boolean
   Default
     0
   Description
     **Enable author avatars in the meta section:**

plugin.tx_blog.settings.meta.postheader.elements.authors.avatar.size
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.authors.avatar.size
   Data type
     int+
   Default
     20
   Description
     **Size of the author avatars:**
     The size in px for the author avatar

plugin.tx_blog.settings.meta.postheader.elements.categories.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.categories.enable
   Data type
     boolean
   Default
     0
   Description
     **Show categories in the meta section:**

plugin.tx_blog.settings.meta.postheader.elements.tags.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.tags.enable
   Data type
     boolean
   Default
     0
   Description
     **Show tags in the meta section:**

plugin.tx_blog.settings.meta.postheader.elements.published.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.published.enable
   Data type
     boolean
   Default
     1
   Description
     **Show the publish date in the meta section:**

plugin.tx_blog.settings.meta.postheader.elements.published.format
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.published.format
   Data type
     string
   Default
     %d.%m.%Y
   Description
     **Published date format:**
     Default: %d.%m.%Y

plugin.tx_blog.settings.meta.postheader.elements.comments.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postheader.elements.comments.enable
   Data type
     boolean
   Default
     1
   Description
     **Show comments in the meta section:**

Post Footer
^^^^^^^^^^^

========================================================================= =============================================== ===========
Property                                                                  Type                                            Default
========================================================================= =============================================== ===========
plugin.tx_blog.settings.meta.postfooter.enable_                           boolean                                         1
plugin.tx_blog.settings.meta.postfooter.modifier_                         options[simple, condensed, extended, modern]    simple
plugin.tx_blog.settings.meta.postfooter.elements.authors.enable_          boolean                                         0
plugin.tx_blog.settings.meta.postfooter.elements.authors.avatar.enable_   boolean                                         0
plugin.tx_blog.settings.meta.postfooter.elements.authors.avatar.size_     int+                                            20
plugin.tx_blog.settings.meta.postfooter.elements.categories.enable_       boolean                                         1
plugin.tx_blog.settings.meta.postfooter.elements.tags.enable_             boolean                                         1
plugin.tx_blog.settings.meta.postfooter.elements.published.enable_        boolean                                         0
plugin.tx_blog.settings.meta.postfooter.elements.published.format_        string                                          %d.%m.%Y
plugin.tx_blog.settings.meta.postfooter.elements.comments.enable_         boolean                                         0
========================================================================= =============================================== ===========

plugin.tx_blog.settings.meta.postfooter.enable
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.enable
   Data type
     boolean
   Default
     1
   Description
     **Display meta information in the footer:**

plugin.tx_blog.settings.meta.postfooter.modifier
""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.modifier
   Data type
     options[simple, condensed, extended, modern]
   Default
     simple
   Description
     **Meta information display style:**

plugin.tx_blog.settings.meta.postfooter.elements.authors.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.authors.enable
   Data type
     boolean
   Default
     0
   Description
     **Show authors in the meta section:**

plugin.tx_blog.settings.meta.postfooter.elements.authors.avatar.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.authors.avatar.enable
   Data type
     boolean
   Default
     0
   Description
     **Enable author avatars in the meta section:**

plugin.tx_blog.settings.meta.postfooter.elements.authors.avatar.size
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.authors.avatar.size
   Data type
     int+
   Default
     20
   Description
     **Size of the author avatars:**
     The size in px for the author avatar

plugin.tx_blog.settings.meta.postfooter.elements.categories.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.categories.enable
   Data type
     boolean
   Default
     1
   Description
     **Show categories in the meta section:**

plugin.tx_blog.settings.meta.postfooter.elements.tags.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.tags.enable
   Data type
     boolean
   Default
     1
   Description
     **Show tags in the meta section:**

plugin.tx_blog.settings.meta.postfooter.elements.published.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.published.enable
   Data type
     boolean
   Default
     0
   Description
     **Show the publish date in the meta section:**

plugin.tx_blog.settings.meta.postfooter.elements.published.format
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.published.format
   Data type
     string
   Default
     %d.%m.%Y
   Description
     **Published date format:**
     Default: %d.%m.%Y

plugin.tx_blog.settings.meta.postfooter.elements.comments.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.postfooter.elements.comments.enable
   Data type
     boolean
   Default
     0
   Description
     **Show comments in the meta section:**

TYPO3 Blog: List
----------------

Featured Image
^^^^^^^^^^^^^^

===================================================== ========= ==========
Property                                              Type      Default
===================================================== ========= ==========
plugin.tx_blog.settings.lists.featuredImage.width_    string    1140
plugin.tx_blog.settings.lists.featuredImage.height_   string    400c
===================================================== ========= ==========

plugin.tx_blog.settings.lists.featuredImage.width
"""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.featuredImage.width
   Data type
     string
   Default
     1140
   Description
     **Width:**

plugin.tx_blog.settings.lists.featuredImage.height
""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.lists.featuredImage.height
   Data type
     string
   Default
     400c
   Description
     **Height:**

Element Header
^^^^^^^^^^^^^^

========================================================================= =============================================== ===========
Property                                                                  Type                                            Default
========================================================================= =============================================== ===========
plugin.tx_blog.settings.meta.listheader.enable_                           boolean                                         1
plugin.tx_blog.settings.meta.listheader.modifier_                         options[simple, condensed, extended, modern]    simple
plugin.tx_blog.settings.meta.listheader.elements.authors.enable_          boolean                                         0
plugin.tx_blog.settings.meta.listheader.elements.authors.avatar.enable_   boolean                                         0
plugin.tx_blog.settings.meta.listheader.elements.authors.avatar.size_     int+                                            20
plugin.tx_blog.settings.meta.listheader.elements.categories.enable_       boolean                                         0
plugin.tx_blog.settings.meta.listheader.elements.tags.enable_             boolean                                         0
plugin.tx_blog.settings.meta.listheader.elements.published.enable_        boolean                                         1
plugin.tx_blog.settings.meta.listheader.elements.published.format_        string                                          %d.%m.%Y
plugin.tx_blog.settings.meta.listheader.elements.comments.enable_         boolean                                         1
========================================================================= =============================================== ===========

plugin.tx_blog.settings.meta.listheader.enable
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.enable
   Data type
     boolean
   Default
     1
   Description
     **Display meta information in the header:**

plugin.tx_blog.settings.meta.listheader.modifier
""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.modifier
   Data type
     options[simple, condensed, extended, modern]
   Default
     simple
   Description
     **Meta information display style:**

plugin.tx_blog.settings.meta.listheader.elements.authors.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.authors.enable
   Data type
     boolean
   Default
     0
   Description
     **Show authors in the meta section:**

plugin.tx_blog.settings.meta.listheader.elements.authors.avatar.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.authors.avatar.enable
   Data type
     boolean
   Default
     0
   Description
     **Enable author avatars in the meta section:**

plugin.tx_blog.settings.meta.listheader.elements.authors.avatar.size
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.authors.avatar.size
   Data type
     int+
   Default
     20
   Description
     **Size of the author avatars:**
     The size in px for the author avatar

plugin.tx_blog.settings.meta.listheader.elements.categories.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.categories.enable
   Data type
     boolean
   Default
     0
   Description
     **Show categories in the meta section:**

plugin.tx_blog.settings.meta.listheader.elements.tags.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.tags.enable
   Data type
     boolean
   Default
     0
   Description
     **Show tags in the meta section:**

plugin.tx_blog.settings.meta.listheader.elements.published.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.published.enable
   Data type
     boolean
   Default
     1
   Description
     **Show the publish date in the meta section:**

plugin.tx_blog.settings.meta.listheader.elements.published.format
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.published.format
   Data type
     string
   Default
     %d.%m.%Y
   Description
     **Published date format:**
     Default: %d.%m.%Y

plugin.tx_blog.settings.meta.listheader.elements.comments.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listheader.elements.comments.enable
   Data type
     boolean
   Default
     1
   Description
     **Show comments in the meta section:**

Element Footer
^^^^^^^^^^^^^^

========================================================================= =============================================== ===========
Property                                                                  Type                                            Default
========================================================================= =============================================== ===========
plugin.tx_blog.settings.meta.listfooter.enable_                           boolean                                         1
plugin.tx_blog.settings.meta.listfooter.modifier_                         options[simple, condensed, extended, modern]    simple
plugin.tx_blog.settings.meta.listfooter.elements.authors.enable_          boolean                                         1
plugin.tx_blog.settings.meta.listfooter.elements.authors.avatar.enable_   boolean                                         0
plugin.tx_blog.settings.meta.listfooter.elements.authors.avatar.size_     int+                                            20
plugin.tx_blog.settings.meta.listfooter.elements.categories.enable_       boolean                                         0
plugin.tx_blog.settings.meta.listfooter.elements.tags.enable_             boolean                                         1
plugin.tx_blog.settings.meta.listfooter.elements.published.enable_        boolean                                         0
plugin.tx_blog.settings.meta.listfooter.elements.published.format_        string                                          %d.%m.%Y
plugin.tx_blog.settings.meta.listfooter.elements.comments.enable_         boolean                                         0
========================================================================= =============================================== ===========

plugin.tx_blog.settings.meta.listfooter.enable
""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.enable
   Data type
     boolean
   Default
     1
   Description
     **Display meta information in the footer:**

plugin.tx_blog.settings.meta.listfooter.modifier
""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.modifier
   Data type
     options[simple, condensed, extended, modern]
   Default
     simple
   Description
     **Meta information display style:**

plugin.tx_blog.settings.meta.listfooter.elements.authors.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.authors.enable
   Data type
     boolean
   Default
     1
   Description
     **Show authors in the meta section:**

plugin.tx_blog.settings.meta.listfooter.elements.authors.avatar.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.authors.avatar.enable
   Data type
     boolean
   Default
     0
   Description
     **Enable author avatars in the meta section:**

plugin.tx_blog.settings.meta.listfooter.elements.authors.avatar.size
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.authors.avatar.size
   Data type
     int+
   Default
     20
   Description
     **Size of the author avatars:**
     The size in px for the author avatar

plugin.tx_blog.settings.meta.listfooter.elements.categories.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.categories.enable
   Data type
     boolean
   Default
     0
   Description
     **Show categories in the meta section:**

plugin.tx_blog.settings.meta.listfooter.elements.tags.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.tags.enable
   Data type
     boolean
   Default
     1
   Description
     **Show tags in the meta section:**

plugin.tx_blog.settings.meta.listfooter.elements.published.enable
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.published.enable
   Data type
     boolean
   Default
     0
   Description
     **Show the publish date in the meta section:**

plugin.tx_blog.settings.meta.listfooter.elements.published.format
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.published.format
   Data type
     string
   Default
     %d.%m.%Y
   Description
     **Published date format:**
     Default: %d.%m.%Y

plugin.tx_blog.settings.meta.listfooter.elements.comments.enable
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. container:: table-row

   Property
     plugin.tx_blog.settings.meta.listfooter.elements.comments.enable
   Data type
     boolean
   Default
     0
   Description
     **Show comments in the meta section:**

