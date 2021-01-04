Upgrading from blog 9.x.x
=========================

Template overrides
------------------

If you are upgrading from blog 9.x.x and you are overriding default templates with templates in your sitepackage, please make sure that if you have code like this:

  .. code-block:: ts

     <f:render section="content" arguments="{_all}" />

  you replace it with:

  .. code-block:: ts

     <f:render section="Content" arguments="{_all}" />

  If you neglect to correct this situation before executing the upgrade on the blog extension, you will see the follwing error message:

  .. figure:: ../Images/Upgrading/template_override_error.png


Dedicated featured image provided
---------------------------------

The new featured image field will now be the preferred way to set an article image. Since the media field could contain any asset the new featured image field is dedicated to images. You can configure the width and height through typoscript constants.

  .. code-block:: ts

     plugin.tx_blog.settings.post.featuredImage.width = 1140
     plugin.tx_blog.settings.post.featuredImage.height= 400c
     plugin.tx_blog.settings.lists.featuredImage.width = 1140
     plugin.tx_blog.settings.lists.featuredImage.height= 400


Social share options dropped
----------------------------

The social share links are rarely used and no implementation is provided by the blog extension itself. The option is removed without replacement. Of course you can still use an extension like the Shariff implementation for TYPO3 in your custom templates.


Respect PageTsConfig limitation for authors
-------------------------------------------

From now on the PAGE_TSCONFIG_ID is respected for authors in the backend. If you have not configured a storage pid for this records before please adjust your configuration.

TsConfig Example:

  .. code-block:: ts

     TCEFORM.pages.authors.PAGE_TSCONFIG_ID = 59


Fontawesome dependency removed
------------------------------

All Icons are now delivered by default as svgs and are rendered inline, this makes them easy to style and adjust. New templates have been introduced that only delivers the markup for the icons. This can be overwritten if you want to exchange the icons used. Default avatar size was also slightly increased to better match renderings.

Templates added:

* Partials/General/BlogIcons.html
* Partials/General/SocialIcons.html

Templates changed:

* Partials/Archive/Menu.html
* Partials/Post/Author.html
* Partials/Post/Meta.html
* Templates/Post/ListPostsByAuthor.html
* Templates/Post/ListPostsByCategory.html
* Templates/Post/ListPostsByDate.html
* Templates/Post/ListPostsByTag.htm


Introduce blog categories
-------------------------

The behavior of blog categories is now streamlined with categories that can be selected within the page records. Without touching or limiting normal categories. Blog categories only show other blog categories within the parent selector box, that are created in the same directory. Note: SEO content is only available for blog categories, not (anymore) for default categories.


MetaService obsolete
--------------------

The meta service is obsolete since TYPO3 v9 and is replaced through the usage of the MetaTag-API from core. To migrate to the new API you just need to remove all usages of the MetaService.


New metadata rendering (modernized)
-----------------------------------

The metadata implementation for authors, categories, tags, publish date and comments were really hard to customize. It was used in multiple places and was also reliant on font awesome for icons. To provide a better out of the box experience the templates were completely refactored and rebuilt from the ground up. A generic set was introduced that provides a lot of flexibility without the need to touch the templates at all. This set is now replacing all current usages of the metadata. The old metadata plugin will now throw a deprecation message and is planned to be removed with Version 11. Instead of using the old one, there are now two new plugins for post header and post footer that can be configured individually through TypoScript constants. While the post header plugin will also render the post title, the post footer will only render the metadata for now. Also, the list rendering of posts has now two dedicated sections for rendering the metadata.

Each section like authors or categories can be configured per position. If you do not want to have a section rendered at all, you can also simply disable it. If comments are disabled for a post, the comment section will not be rendered.

We are now shipping 3 different layouts you can choose from that will change the look of how the metadata will be displayed.

Simple:
Is a compact version, showing icon and value in one line.

Condensed:
In addition to the icon and value, there is now also a prefix visible.

Extended:
Prefix and value are now in separate lines. You will find settings for this in the constant editor.

Example Configuration for the postheader position:

  .. code-block:: ts

     plugin.tx_blog.settings.meta.postheader {
      enable = 1
      modifier = simple
      elements {
          authors {
              enable = 0
          }
          categories {
              enable = 0
          }
          tags {
              enable = 1
          }
          published {
              enable = 1
              format = %d.%m.%Y
          }
          comments {
              enable = 1
          }
        }
     }

     Templates added:

     * Partials/Meta/Default.html
     * Partials/Meta/Elements/Authors.html
     * Partials/Meta/Elements/Categories.html
     * Partials/Meta/Elements/Comments.html
     * Partials/Meta/Elements/Published.html
     * Partials/Meta/Elements/Tags.html
     * Partials/Meta/ListFooter.html
     * Partials/Meta/ListHeader.html
     * Partials/Meta/PostFooter.html
     * Partials/Meta/PostHeader.html
     * Partials/Meta/Rendering/Group.html
     * Partials/Meta/Rendering/Item.html
     * Partials/Meta/Rendering/Section.html
     * Templates/Post/Footer.html
     * Templates/Post/Header.html

     Templates changed:

     * Partials/General/BlogIcons.html
     * Partials/List/Post.html
     * Templates/Post/Metadata.html


Limit authors to default language
---------------------------------

We are now limiting the selection of authors to the default langauge, since translations are fetched automaticly, if available

Limit tags to configured storage pid

Listing of tags is now restricted to the configured storage pid. If you want to use tags from additional storages please adjust your configuration accordingly.

TypoScript Constants Example:

  .. code-block:: ts

     plugin.tx_blog.settings.storagePid = 0,666


Social image wizard dropped (prefer ext:seo)
--------------------------------------------

We are dropping the social image wizard and rely on the editor to create custom images if necessary. The feature predated the core SEO-Initiative that now handles social images through dedicated fields. We are strongly recommending using core handling instead of the media fields.

The wizard itself had several drawbacks, it was hard to configure and was not able to handle high-resolution images.


New list rendering (modernized)
-------------------------------

To provide more flexibility, all default post list templates have been reworked. They all now share a common markup with modifiers for the different plugins.

In previous versions the templates were already listening to a variable class, but it was never set nor could could it be set without overriding the templates. All controller that render lists are now assigning a variable named type to these templates.

* ListPostsByAuthor -> postlist--byauthor
* ListPostsByCategory-> postlist--bycategory
* ListPostsByDate -> postlist--bydate
* ListPostsByTag -> postlist--bytag
* ListRecentPosts -> postlist--recent
* RelatedPosts --> postlist--related

Templates changed:

* Partials/List.html
* Partials/List/Post.html
* Templates/Post/ListPostsByAuthor.html
* Templates/Post/ListPostsByCategory.html
* Templates/Post/ListPostsByDate.html
* Templates/Post/ListPostsByTag.html


New widget rendering (modernized)
---------------------------------

The widget rendering has been completely reworked and is now more easy to customize without overwriting the templates. Title rendering has been moved to the main layout, you can now use the new section "Title" to set the widget title. If you have overwritten the widget templates or added new ones that makes use of the "Widgets" layout you need to add this new section.

Migration:

remove:

  .. code-block:: ts

     <h3 class="widget-title">[TITLE]</h3>

add:

  .. code-block:: ts

     <f:section name="Title">[TITLE]</f:section>

Templates changed:

* Layouts/Widget.html
* Templates/Post/Sidebar.html
* Templates/Widget/Archive.html
* Templates/Widget/Categories.html
* Templates/Widget/Comments.html
* Templates/Widget/Feed.html
* Templates/Widget/RecentPosts.html
* Templates/Widget/Tags.html


New widget content rendering (modernized)
-----------------------------------------

The widget content rendering has been completely reworked and is now more easy to customize without overwriting the templates. The archive template does not use the `Archive/Menu` partial anymore. It now has a dedicated template to not reflect template changes that are meant to be for a different rendering location.

RSS links have been removed to declutter the default view for the sidebar. Links to the RSS feeds still exist in their dedicated single views.

Templates changed:

* Templates/Widget/Archive.html
* Templates/Widget/Categories.html
* Templates/Widget/Comments.html
* Templates/Widget/Feed.html
* Templates/Widget/RecentPosts.html
* Templates/Widget/Tags.html


New pagination rendering (modernized)
-------------------------------------

The pagination rendering has been completely reworked and is now more easy to customize without overwriting the templates. Bootstrap specific markup has been removed. In addition to a new template, a11y has been enhanced. We are now providing descriptive labels for the pagination entries. A set of new language labels have been introduced that you are now also able to customize to your needs.

New labels:

* pagination.aria.label: Page navigation
* pagination.next -> Next
* pagination.previous: Previous
* pagination.aria.current.page: Current page, page %s
* pagination.aria.goto.page: Go to page %s
* pagination.aria.goto.next: Go to next page
* pagination.aria.goto.previous: Go to previous page

Templates changed:

* Templates/ViewHelpers/Widget/Paginate/Index.html


TYPO3 Form Framework for comment form now used
----------------------------------------------

The required form markup can vary a lot depending on the frontend implementation of the instance. To ease the blog integration in all kinds of frontends we decided to make use of the form framework of TYPO3. By using the form framework the blog will automatically respect the already configured forms of the typo3 instance. This will remove the necessity to provide custom form templates for the comment form of the blog extension. This will also mean, thats its no longer possible to adjust the comment form directly, since this is now generated through the form framework API.

During the migration it was noticed that the google captcha implementation is currently only compatible with v2, this was added to the label for now to avoid configuration confusions while generating API Keys at google.

Adjusted Templates:

* Templates/Comment/Form.html

New Templates:

* Partials/Comments/Form/Closed.html
* Partials/Comments/Form/Disqus.html
* Partials/Comments/Form/Local.html
* Partials/Form/GoogleCaptcha.html


Configuration error note for single view plugins added
------------------------------------------------------

To prevent the usage of plugins that should only be used on post views we are now adding additional checks for those. If no post could be resolved - also means if the plugin is used on pages that do not match the `Constants::DOKTYPE_BLOG_POST` - the plugins will now return a new message to make the miss usage visible.

**A possible configuration error was detected. No matching post could be obtained.  Make sure that this plugin is only used on a post.**

The following plugins will now show this message if no post could be obtained:

The following plugins will now show this message if no post could be obtained:

* Authors
* Footer
* Header
* Metadata
* RelatedPosts

Templates added:

* Layouts/Post.html

Templates changed:

* Templates/Comment/Comments.html
* Templates/Comment/Form.html
* Templates/Post/Authors.html
* Templates/Post/Footer.html
* Templates/Post/Header.html
* Templates/Post/Metadata.html
* Templates/Post/RelatedPosts.html


New post author rendering (modernized)
--------------------------------------

The author rendering has been completely reworks and is now more easy to customize without overwriting the templates. Bootstrap and FontAwesome specific classes were completely removed and we now deliver some basic css to achieve better results. Rendering is now more resilient and only renders elements if necessary. Each element can be identified through specific classes on the markup. Flexbox is used for alignment and can be used to reorder the rendering without touching the templates. Icons for social links now are now delivered by default as svgs and are rendered inline, this makes them easy to style and adjust. A new template has been introduced that only delivers the markup for the icons. This can be overwritten if you want to exchange the icons used. Default avatar size was also slightly increased to better match renderings.

Configuration changed:

* avatar.provider.size: 64 -> 72

Templates changed or added:

* Partials/General/SocialIcons.html
* Partials/Post/Author.html
* Templates/Post/Authors.html


New post comment rendering (modernized)
---------------------------------------

The post comment rendering has been completely reworks and is now more easy to customize without overwriting the templates. Bootstrap specific classes were completely removed and we now deliver some basic css to achieve better results. Schema.org attributes were adjusted to respect the latest recommendations for user comments. And a new option was added to make the display date format configurable through typoscript.

Configuration added:

* comments.date.format = %B %e, %Y

Templates changed or added:

* Partials/Comment/Comment.html
* Templates/Comment/Comments.html


Reduced tags size by default
----------------------------

The default size for `widgets.tags.maxSize` has been reduced from 200 to 100 to unset the default scaling. To reenable the tag scaling inthe widget please adjust the min-/maxSize to your preferred settings. In addition the fallback sizes have been also adjusted to reflect these default typoscript settings.


Exclude fields dropped
----------------------

All backend users now are NOT prevented from editing the field unless they are members of a backend user group with this field added as an “Allowed Excludefield” (or “admin” user).
