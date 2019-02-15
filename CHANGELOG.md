# 9.1.1

## FEATURE
- [FEATURE] Add pagination to routes (#36) 129441c
- [FEATURE] Make pagination configurable (#34) 5b97ffc

## TASK
- [TASK] Add fontawesome to development setup cd561c6
- [TASK] Enable xdebug for ddev and add vscode debug config 06c3a90
- [TASK] Add extension-helper as dev dependency to generate releases 4ab11f7
- [TASK] Set development environment 0bc3871
- [TASK] Update ddev to 1.6.0 8840f6b
- [TASK] Add config to ignored folders 7bfa54f
- [TASK] Update documentation for github 09e1ae8
- [TASK] Setup travis 08a7298
- [TASK] Adjust and improve documentation Resolves: EXTBLOG-151 Releases: master, 9.1, 9.0 2348246
- [TASK] Add test package and ddev f2c4449

## BUGFIX
- [BUGFIX] Resolve endless loop when calling archive without params (#35) 35218dc
- [BUGFIX] Set addQueryStringMethod again to avoid faulty strict mode 568bed5
- [BUGFIX] Generate correct link to blog rss channel 97edc74
- [BUGFIX] Make route-enhancer configuration work (#29) 46d5a05
- [BUGFIX] Introduce path-segments for tags, author and category - fixes #31 (#32) 9a07321
- [BUGFIX] Remove outdated realurl information and use route enhancer (#30) d09ba68
- [BUGFIX] LinkViewHelper must set correct controller context (#28) 11ad2f2
- [BUGFIX] Add extension name to uriFor in all ViewHelpers (#6) 83b25d9
- [BUGFIX] Fix #24: TypyError exception when calling PostRepository::findRelatedPosts() (#25) eba1bca
- [BUGFIX] Remove limitToPages setting from default routes config dc30d8c
- [BUGFIX] Let the SocialImageWizard working again Resolves: EXTBLOG-154 Releases: master, 9.1, 9.0 72bf836
- [BUGFIX] Add missing export-ignore for .ddev configuration 2968a7f
- [BUGFIX][EXTBLOG-152] Allow typo3fluid/fluid in versions 2.5 and above 4ed9833

# 9.1.0

## BREAKING
- [!!!][FEATURE] AvatarProvider selectable on author record level 50751c5
- [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB] efd769d

## FEATURE
- [FEATURE] Add batch processing for comments 931a16e
- [FEATURE] Added possibility to show related posts 078d430
- [FEATURE] Add data to view af5d8be
- [FEATURE] Add possibility to generate overview of post based on a category set in backend d352d82
- [FEATURE] Documentation update 002e432
- [FEATURE] Documentation update and php_cs dist from master 2536c59
- [FEATURE] Set a details page per specific author. If no details page is set it reverts to the default behaviour. 1e29b73
- [FEATURE] Add current category to widget view 8e0ca35
- [FEATURE] Add posts to category model d5804a3
- [FEATURE] Realurl configuration for RSS feed url(s) 9945e18
- [!!!][FEATURE] AvatarProvider selectable on author record level 50751c5
- [FEATURE] Comments form: use html5 input types for email and url fields 12b874f
- [FEATURE] Add support for disqus.com 1f1edbd
- [FEATURE] Add notification system 47d501f
- [FEATURE] Auto approve comments after first approval 765b3d2
- [FEATURE] Introduce publish date and migrate crdate ca2cfe7
- [FEATURE] Add and replace relations d7f4ff4
- [WIP][FEATURE] Social Image Wizard 4b99e68
- [FEATURE] Add setting for blogSetup to comments sidebar widget a0e5e68

## TASK
- [TASK] Change version to 9.1.0 5251849
- [TASK] Remove useless comment blocks b64390f
- [TASK] Avoid endless waiting for database connection b99510d
- [TASK] Add more constants Resolves: EXTBLOG-141 Releases: master, 9.0 d2b6a4c
- [TASK] Add nl2br VH for comments text Resolves: EXTBLOG-132 Releases: master eee5e2d
- [TASK] Move Updates to Classes/Updates Resolves: EXTBLOG-143 Releases: master a3c915e
- [TASK] Move test builds into dedicated folder Resolves: EXTBLOG-136 Releases: master, 9.0, 8.7 87040de
- [TASK] Change git clone url in documentation c95d417
- [TASK] Prepare v9 release 2359116
- [TASK] Code cleanups and v9 change b8bdd89
- [TASK] Raise core version constraints 563a10e
- [TASK] Add phpunit coverage paths to bamboo 072ff89
- [TASK] Change PHP CS Fixer config e176e2f
- [TASK] Update  README.md 1ace08b
- [TASK] Update README.md adf5516
- [TASK] Added documentation for list by category 637cf79
- [TASK] Fix bamboo setup 4e7ef81
- [TASK] bamboo setup 193aabd
- [TASK] Fix CGL issues 2bc412e
- [TASK] Refactor Unit Tests d109449
- [TASK] Add .gitattributes file to repository 6353a74
- [TASK] Add all composer depencies 1860680
- [TASK] Update to 9.3.*@dev 1672e62
- [TASK] Update to 9.3.x-dev 95ddef0
- [TASK] Update to 9.3.x-dev 229ab42
- [TASK] Change version constraint for master f06781a
- [TASK] Add sorting for tags in backend 3d95406
- [TASK] Add build status badge 647458a
- [TASK] Require typo3/cms-install a4db8a9
- [TASK] Add README.md file 24223f7
- [TASK] Refactor ViewHelpers to be compatible with latest master 2de7fec
- [TASK] Remove old ArrayUtility class 427a644
- [TASK] Add links to composer.json 79843cd
- [TASK] Optimize icons faeebd8
- [TASK] Add MetaServiceTest 8e17304
- [TASK] Optimize auto setup fca2a1a
- [TASK] Move first blog post into data folder bbffb36
- [TASK] Remove pages_language_overlay configuration e791784
- [TASK] Add @lazy attribute to posts property for authors 9c0a85b
- [TASK] Add rst file cf1c641
- [TASK] Define a default filter and skin set 95c4a29
- [TASK] Configure the data sources by PageTS 1526c85
- [TASK] Fix version contraint 50952db
- [TASK] Load json configs from data attribute 64ca4d3
- [TASK] Move skin into JSON config file 174e9f8
- [TASK] Move filter into JSON config file 6fbbb13
- [TASK] Fix event registration and some cleanups 796aba3
- [TASK] Fix step panels 0d3d4b4
- [TASK] Fix layout of table 34cc688
- [TASK] Use FormDataCompiler to get information from TCA d76c606
- [TASK] Refactor the step handling 13ef97a
- [TASK] Fix layout and markup 089b316
- [TASK] ADJUSTED POSITIONING OF ELEMENTS 1c6e783
- [TASK] Refactroing of canvas code 6844194
- [TASK] Add step 2/3 and cleanup the code da03a75
- [TASK] Adjusted layout and added adjustment sliders deb9e6a
- [TASK] Get fields from TCA 65e3a9b
- [TASK] Fix Layouts of Images ff611e8
- [TASK] Add save logic 98d754e
- [TASK] Add Fabric Tooling 52cddb2
- [TASK] Make canvas responsive eb5baad
- [TASK] add markup in controller and open model in full width 504a0dc
- [TASK] Add RequireJsModule 8a1819d
- [TASK] Change version number 6deba1e
- [TASK] Prepare release 8.7.0 dbe1018
- [TASK] Prepare release 8.7.0 d399f99
- [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB] efd769d
- [TASK] Use GeneralUtility::getIndpEnv('REMOTE_ADDR') 77724ec
- [TASK] Prepare UnitTests.xml d14e6bb
- [TASK] Raise core version requirements 6d86fa2
- [TASK] Use non namespaced test classes for compabitility 6c9d413
- [TASK] Extract find comment functionality in new function 20b25a0
- [TASK] Implement subtitle field in post model eb6b8bb
- [TASK] Adjust the rst file d8cb2bb
- [TASK] Enabled recursive and pages field for all post plugins 2d7df6e
- [TASK] Don't set the defaultConstraints for the storage PID in the initialize because this is only executed the first time. Also setting the storagePid as a defaultConstraint is causing issues. 93712d9
- [TASK] Use empty check insteaf of count 0007d12
- [TASK] Only check rootline when no storagePids are set through TypoScript or plugin-settings aeeddc3
- [TASK] Removed unused property 061fea3
- [TASK] Add possibility to select storage pid for overview of blog posts d20044e
- [TASK] Added changelog for feature 35 5718dca
- [TASK] Removed unused property 106437e
- [TASK] Add possibility to select storage pid for overview of blog posts e4df4de
- [TASK] Prepare next development version 2a2c692

## BUGFIX
- [BUGFIX] Respect l18n_cfg setting in PostRespository 983c870
- [BUGFIX] Improve performance Resolves: EXTBLOG-142 Releases: master 3205c87
- [BUGFIX] Remove extension installer Resolves: EXTBLOG-133, EXTBLOG-144 Releases: master, 9.0 c4174ea
- [BUGFIX] Make entries in filter unique Resolves: EXTBLOG-146 Releases: master, 9.0, 8.7 3ab687f
- [BUGFIX] Avoid unnessesary post casting to object in comment form 8751143
- [BUGFIX] TE-109: show only default language tags in BE forms Resolves: EXTBLOG-146, TE-109 Releases: master, 9.0, 8.7 c139485
- [BUGFIX] Cleanup TCA ce947b6
- [BUGFIX] Make plugins cached and use lazy loading for relations 35031da
- [BUGFIX] Use .typoscript fileending for typoscript files Resolves: EXTBLOG-140 Releases: master 82f6f9a
- [BUGFIX] Fix broken annotation a8e8779
- [BUGFIX] Remove build folder for each PHP version db2a4e0
- [BUGFIX] Fix wrong code-block syntax 242ec5e
- [BUGFIX] Remove composer.lock from repository Resolves: EXTBLOG-137 Releases: master, 9.0, 8.7 15eb22e
- [BUGFIX] Add editor config to ensure streamlined indentions Resolves: EXTBLOG-135 Releases: master, 9.0, 8.7 4363f5c
- [BUGFIX] Adjust gitattributes file Resolves: EXTBLOG-134 Releases: master, 9.0, 8.7 0d77934
- [BUGFIX] Make a category posts lazy Releases: master, 9.0 69aa0e4
- [BUGFIX] Cast timestamp to int Releases: master, 9.0, 8.7 0f51f97
- [BUGFIX] Change category icon size Reöeases: master acd3f53
- [BUGFIX] Cast return type of CategoryViewHelper 7987c84
- [BUGFIX] Remove cache tagging for archive widget, which make no sense e8c5fef
- [BUGFIX] Prevent bypassing re-captcha check 1499ad9
- [BUGFIX] Use repository instead of model to retrieve posts by category 2b6b413
- [BUGFIX] fix only extension classes 1faba4b
- [BUGFIX] Fix log file name f17bdc4
- [BUGFIX] Tag and clear cache for all relevant changes 78ae97a
- [BUGFIX] Add missing storage pid condition 3a0d585
- [BUGFIX] Fix wrong condition for comment status cfa6cae
- [BUGFIX] Exception in sidebar plugin without tags 4d0edc4
- [BUGFIX] Fix wrong markup for pagination f58a9d6
- [BUGFIX] Add missing label 4dd1ba1
- [BUGFIX] Fix wording of category label 425b65e
- [BUGFIX] Add missing label for SEO tab 2ff5eb4
- [BUGFIX] Fix wrong size of icons in PageTree cbb99af
- [BUGFIX] Override category config only for blog pages 61a9aa9
- [BUGFIX] Fix broken unit tests ce58275
- [BUGFIX] Call parent::initializeArguments(); for all ViewHelpers 41d35f8
- [BUGFIX] Remove old ArrayUtility class b51a09b
- [BUGFIX] Change license in composer.json 48dec0e
- [BUGFIX] SetupWizard breaks composer based installations 60e8698
- [BUGFIX] Fix SetupSerice, remove restricition container 9cdf96d
- [BUGFIX] Install EXT:rx_shariff with EXT:blog_template c65a604
- [BUGFIX] Fix typo in description b9a8e99
- [BUGFIX] Fix broken SQL statement for comments d82a8ba
- [BUGFIX] Fix SQL typo and statement for TagRepository 3479cf6
- [BUGFIX] Add an additional check before validating re-captcha 5d74a29
- [BUGFIX] Streamline settings af51794
- [BUGFIX] Respect sys_language in comment count aaae16c
- [BUGFIX] Fix metadata plugin rendering 11aab5a
- [BUGFIX]  Respect language in comments widget 803e2bb
- [BUGFIX] Force pid of comments to post uid fe0558f
- [BUGFIX] Fixed small bug causing error in backendmodule when selecting one blogSetup 8a89856

## MISC
- EXTBLOG-60 - Update Recent comments widget ba739c6
- Fix typo orderBy 630a5aa
- Add the missing orderBy clause. 14e62bc
- Fix SQL typo and statement for TagRepository c632418
- Update Documentation/Changelog/master/Important-88-Remove-GLOBALS-TYPO3_DB.rst f491f8e
- Author string translated a2f46b8
- Translation of Widgets 209dfdc
- Category widget template translated b1cf339
- [TAKS] Change version contraint of core f903717
- EXTBLOG-60 - Update Recent comments widget 878a3d0
- [BUGIFX] Respect sys_language in comment count cf81777

# 1.3.0

## FEATURE
- [FEATURE] Reload page tree after setup is done 9b43823

## TASK
- [TASK] Prepare release 1.3.0 c2f21b1
- [TASK] Provide dedicated UnitTests.xml for TYPO3 versions e053ddf
- [TASK] Raise version contraint for TYPO3 v8 LTS 5656629
- [TASK] Add option for default gravatar image f4ca4a7
- [TASK] Some small cleanups 3afaecd
- [TASK] call initializeObject in contructor 948b014
- [TASK] Adjust composer requirements c3027ea
- [TASK] Remove composer.lock da35fae
- [TASK] Set new dev version daf7a20
- [TASK] Remove composer.lock 2f2ed81
- [TASK] Set new dev version cf4d477

## BUGFIX
- [BUGFIX] Fix rst file c7d95ad
- [BUGFIX] Prevent exception if post is not available 5c8abf3
- [BUGFIX] Remove renderType which not avaible in 7.6 14ae5fd
- [BUGFIX] Split up backend modules dc95276
- [BUGFIX] Fix broken contraint building eb96a1b
- [BUGFIX] Show only active comments in widget 7676a03
- [BUGFIX] Satisfy phpunit v.4 1fb5246

## MISC
- Translation added 5d8ab8b
- EXTBLOG-79, Check if post is avaliable added bdbd19f
- Label added a0b4f60
- EXTBLOG-78, Post title issue fixed 4e4486c
- UnitTests.xml edited online with Bitbucket ff4b60f
- Provide adjusted path to UnitTestBootstrap 9ea5944
- EXTBLOG-77, Anpassung RealUrlAuto-Config-Hook, Reset der vorherigen Änderungen bb5dfdf
- Render links on translated tags with localized uids 5a0f04b
- Documentation update for default value b538913
- EXTBLOG-68, Limit setting for number of posts in the recent posts widget 27df337
- Update composer.json 9bbace0

# 1.2.0

## FEATURE
- [FEATURE] Introduce `maximumItems` setting in recent posts list plug-in 36890b7
- [FEATURE] Add author relations d7a670a
- [FEATURE] Add blog filter to posts view 951153b
- [FEATURE] Add backend module for blog comment management 64585ec
- [FEATURE] Add custom filter per column 07200d2
- [FEATURE] Add backend module for blog post management b2fe7b2
- [FEATURE] Preprocess URL field in comment action 44140cf
- [FEATURE] Add spam protection (honeypot) to comment form 711fd31

## TASK
- [TASK] Update version number for release 1.2.0 76f6593
- [TASK] Prepare documentation for release 1.2.0 9cb6911
- [TASK] Update homepage URL 7635e4e
- [TASK] Update description in composer.json 23aee4a
- [TASK] Update version number for release 1.2.0 3bbdaa9
- [TASK] Prepare documentation for release 1.2.0 4b5c7df
- [TASK] Remove ViewHelper 88fbf82
- [TASK] Adjust status check fbe0a14
- [TASK] Add method to get only active comments d93eae0
- [TASK] Add method to get only active comments 1186ebc
- [TASK] Optimize RSS feed and fix date format 9e6e6d6
- [TASK] Raise core version constraint dc6315f
- [TASK] Set default value of setting `lists.posts.maximumDisplayedItems` to 0 f7f859c
- [TASK] Add `lists.posts.maximumDisplayedItems` TypoScript setting 649740c
- [TASK] Fix phpunit requirement to 5.7.5 9519dc5
- [TASK] Change author in ext_emconf 799f2f1
- [TASK] Change title of category, tag and author pages 7309628
- [TASK] Change version name and core dependency 3a4fa77
- [TASK] Add required fields marker to the template a25c9c6
- [TASK] Add status for comments c951e3d
- [TASK] Add database and TCA defintion for author a3f2872
- [TASK] Optimize init process cdf6ff4
- [TASK] Add rst file for this feature 056b5e5
- [TASK] Optimize init process 92027af
- [TASK] Add rst file for this feature b0ff849
- [TASK] Fixes for 7.6 58b667a
- [TASK] Refactor backend module 10630a2
- [TASK] Raise typo3 requirement to 8.5 4533b7e
- [TASK] Remove call to deprecated function extRelPath() 18e6a95
- [TASK] Improve the documentation for setup without wizard c4abccd
- [TASK] Replace TYPO3_MODE check 32ab58b
- [TASK] Add author field to the model af09178
- [TASK] Remove unsued and invalid TypoeScript setting b6c67c0

## BUGFIX
- [BUGFIX] Use initializeObject insteaf of __construct method to prevent caching issues 41567f9
- [BUGFIX] Add extension information to provide exception 6ce3bde
- [BUGFIX] Adjust bootstrap file in PhpUnit config files 3b9cf1f
- [BUGFIX] Remove duplicate method 936a75f
- [BUGFIX] Update phpunit version and composer.lock file b454184
- [BUGFIX] Use namespaced TestCase file 2922741
- [BUGFIX] Add default implementation in Extbase container for avatar provider 68187a3
- [BUGFIX] Using the ObjectManager to resolve the configuration 2bcc6c8
- [BUGFIX] remove unknown attribute data 886c16e
- [BUGFIX] Change typenum for author feeds cfdd013
- [BUGFIX] Change typenum for author feeds b403a1b
- [BUGFIX] Fix typo in realurl config 8db0944
- [BUGFIX] Fix wrong parameter ad15b79
- [BUGFIX] Fix syntax errors in template cfdb7c1
- [BUGFIX] Use PROPER CSS linking syntax 1579c40
- [BUGFIX] Add missing namespace 649297e
- [BUGFIX] Fix broken icon in localisation view 5ff6d18
- [BUGFIX] Fix broken icon in selectfield of pagetype 1c9aff4
- [BUGFIX] Correct constants of storagePid aa48e82
- [BUGFIX] Set correct constants path 2291f2a
- [BUGFIX] Setup Wizard does not replace UIDs in contstants ad2dcbe
- [BUGFIX] Respect -1 (all languages) if comments.respectPostLanguageId = 1 f2149f0
- [BUGFIX] Use cHash for category, tags and archive 2c0af39
- [BUGFIX] Allow itemprop property 2e22fed
- [BUGFIX] Change URL of gravatar to HTTPS 9c0ddc0
- [BUGFIX] Define templateRootPath on level 0 44bd015

## MISC
- Fix duplicate method getActiveComments 3da66a4
- Removal of unused code ebcb79e
- EXTBLOG-61 - Update comments views and counts when comments.moderation is on 5831b59
- EXTBLOG-67, Only get tags that are not hidden or deleted. 4cf8a43
- Add TCA migrations 0340f94
- Apply TCA migrations 7b091d3
- Apply TCA migrations 51b0312
- [DOC] Add changelog entry for EXTBLOG-62 6d23267
- [DOC] Add documentation for setting `list.posts.maximumDisplayedItems` c652a48
- [CLEANUP] Use `int` cast instead of `intval` 5a7546f
- [REMOVAL] Remove FlexForm for `PostController` 075f5f0
- Removal of unused code d246ac1
- EXTBLOG-61 - Update comments views and counts when comments.moderation is on f26eefa
- Update Classes/Controller/BackendController.php 9b403ee
- [HOTFIX] Add honeypot field to database b2ca40f
- Update Classes/Controller/BackendController.php 09ad7d3

# 1.1.0

## TASK
- [TASK] Prepare release 1.1.0 4d9ae77
- [TASK] Raise core dependency 267e30e

# 1.0.0

## FEATURE
- [FEATURE] Translate comments fb2b39a
- [FEATURE] Make tags translatable dfc78e5
- [FEATURE] Change creation date of post in backend b418148
- [FEATURE] RSS-Feeds c479702
- [FEATURE] Convenience: Tag/Category/Date list without arguments cf2904f
- [FEATURE] Archive Posts 4ad3972
- [FEATURE] Add pagination to default template 3316df3
- [FEATURE] Setup Wizard 47ba426
- [FEATURE] Provide empty output aa4f86a
- [FEATURE] add media Image fa022ec
- [FEATURE] Add tags 1eafe00
- [FEATURE] Add ViewHelper to link inside blog context 1c2cf32
- [FEATURE] Add SEO: Metadata caecb4b
- [FEATURE] Shariff Sharer 8191eae
- [FEATURE] Add archive widget 30bb1b2
- [FEATURE] Add comments widget ec5e93c
- [FEATURE] Create comment form 56a7e91
- [FEATURE] Add comments settings ee84cb9
- [FEATURE] Add category widget ebfad1e
- [FEATURE] Add SVG icons ae635d0
- [FEATURE] Add metadata plugin 807944e
- [FEATURE] Define tag model 60e5dc4
- [FEATURE] Template structure 501e6f2
- [FEATURE] Define comment model d62bf6a
- [FEATURE] Add basic unit tests 50a5478
- [FEATURE] Add basic unit tests 8f91dcb
- [FEATURE] Define category model 702289c
- [FEATURE] Define tag model 0de74b7
- [FEATURE] Basic Setup & TCA defintion 6f13dff

## TASK
- [TASK] Change composer name and version c77b208
- [TASK] Add documentation about realurl da26d35
- [TASK] Change link to service desk 9a6cae3
- [TASK] Add TYPO3_MODE check to all global scope files 61bb5f8
- [TASK] Code cleanups 42ec52e
- [TASK] Cleanup ext_localconf.php and ext_tables.php c62e361
- [TASK] Cleanup BackendController fe58454
- [TASK] Add more documentation bb370d8
- [TASK] Make settings configurable with constant editor. 6d02668
- [TASK] Make settings configurable with constant editor. fe71500
- [TASK] Add documentation c147287
- [TASK] Remove tt_content fields not needed for plugins b8e3617
- [TASK] Refactor patch d7ff0c2
- [TASK] Cleanup templates d7fdce1
- [TASK] Change comments handling for commentsAction 5e14ebb
- [TASK] Fix typos c011155
- [TASK] Fix CGL issues b63f8d5
- [TASK] Remove unused PersistenceManager 58770fd
- [TASK] Fix broken CSS class 840dde0
- [TASK] Optimize tests 9711e48
- [TASK] change franks test and controller foo ;) fb62109
- [TASK] Restructure tempplates 2a4b219
- [TASK] Add composer.json file 2512686
- [TASK] Add OSX stuff to gitignore e484dd9
- [TASK] Add composer.json file 3976dc0
- [TASK] Add OSX stuff to gitignore 6a39619
- [TASK] Change typo3 version constraints 4c1dd4e
- Revert "[TASK] Enforce strict types" 77c0b9c
- [TASK] Enforce strict types cb6a97d
- [TASK] Add comment for testing 8faabb3

## BUGFIX
- [BUGFIX] Add missing comma in ext_tables.sql dd9e53f
- [BUGFIX] Fox broken comment view 72fb886
- [BUGFIX] Don’t cache flash message 6aa960e
- [BUGFIX] Use LocalizationUtility instead of LanguageService 9233c2b
- [BUGFIX] Ensure $GLOBALS[’LANG’] ist set f73adc2
- [BUGFIX] Add renderType to select 5189ef1
- [BUGFIX] set fallback if TSFE not set e222758
- [BUGFIX] get PageId from TSFE 76042a4

## MISC
- Correct more typos 2bb86b6
- Correct typo 67847bc
- Cleanup Post Model 3d34529
- [EXTBLOG-1] Trigger Setup 2d97a2b

