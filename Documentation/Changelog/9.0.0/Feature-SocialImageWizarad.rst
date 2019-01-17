.. include:: ../../Includes.txt

==========================
Feature: SocialImageWizard
==========================

Description
===========

The blog add a new wizard to the media field of blog posts.
The button "Open Social Image Wiazrd" opens a modal window with a wizard to create social media images.
The wizard puts the title of the blog post and the author to the image. The text can be changed.
To customize the layout auf the images, it is possible to override the filter and define an own skin.
With PageTS-Config it is possible to define custom files:

.. code-block:: tsconfig

    mod.SocialImageWizard {
        dataSource {
            filter = EXT:my_template/Resources/Public/JavaScript/SocialImageWizard/Filter.json
            skin = EXT:my_template/Resources/Public/JavaScript/SocialImageWizard/Skin.json
        }
    }

The information from this json files will be automatic applied to the fabric configuration.

Impact
======

You can now create social images within the TYPO3 backend, download and/or store the images in the blog post.

.. index:: Backend
