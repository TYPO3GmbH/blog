# 8.7.6

## TASK
- [TASK] Update ddev to 1.9.1 2fb88eb
- [TASK] Update ddev to 1.7.1 f7b3170
- [TASK] Remove .travis.yaml from archive dc755dd

## BUGFIX
- [BUGFIX] Remove obsolete fields and enable cropping for author images b31a526
- [BUGFIX] Set default doktype for post model (#83) 6155665
- [BUGFIX] Use settings.lists in documentation 310189f
- [BUGFIX] Avoid exception when comment is not set a098b27
- [BUGFIX] Only execute month and year update when fields exist 6e07854
- [BUGFIX] Check if tag does exist before accessing properties f1a3f49
- [BUGFIX] Check if category does exist before accessing properties 6b9189d
- [BUGFIX] Check if author does exist before accessing properties 20efb0e
- [BUGFIX] Do not include google captcha when disabled in settings 9a0643e
- [BUGFIX] Use correct column type for comment sorting by date in backend 63239b6
- [BUGFIX] Use correct column type for post sorting by date in backend 66292b1
- [BUGFIX] Add missing comment id attribute for section links c973a76
- [BUGFIX] Respect configured size in Avatar ImageProvider (#74) 89bf706
- [BUGFIX] Add severity classes to flash messages (#76) 694e7ad
- [BUGFIX] Correct travis cgl fixer config eacac9f
- [BUGFIX] Use today as publishing date for new blog entries (#59) 8f47217
- [BUGFIX] Remove storage constraint from finding current post (#63) a3d6c1d
- [BUGFIX] Only add storage constraint if pages could be resolved (#65) c3b0cc5
- [BUGFIX] Avoid exception when accessing uninitialized settings (#50) ea0f3a4
- [BUGFIX] Set format for rss feeds (#55) 59943b9
- [BUGFIX] Fix format detection for feed data (#54) a29cdc8
- [BUGFIX] Correct fluid namespace definitions - fixes #51 (#52) 57317d9

# 8.7.4

## TASK
- [TASK] Add fontawesome to development setup e774019
- [TASK] Add extension-helper as dev dependency to generate releases 551ea13
- [TASK] Set development environment 8e4a6f9
- [TASK] Update ddev to 1.6.0 0c807e6
- [TASK] Update documentation for github 9d7925e
- [TASK] Setup travis 0f7436d
- [TASK] Add test package and ddev 643abf0

## BUGFIX
- [BUGFIX] Resolve endless loop when calling archive without params (#35) 4271208
- [BUGFIX] LinkViewHelper must set correct controller context (#28) 98659cf
- [BUGFIX] Remove platform override, symfony polyfill and add php requirement f9ebb28
- [BUGFIX] Return Type Declaration void is unsupported in PHP 7.0 - fixes #16 d9a6806
- [BUGFIX] Add extension name to uriFor in all ViewHelpers (#6) 5bca0ec
- [BUGFIX][EXTBLOG-152] Allow typo3fluid/fluid in versions 2.3 and above 3678e3d

# 8.7.3

## TASK
- [TASK] Change version to 8.7.3 5201618
- [TASK] Avoid endless waiting for database connection 45e4748
- [TASK] Move test builds into dedicated folder 5111341
- [TASK] Change git clone url in documentation 1934c70
- [BUGFIX] Fix wrong update registration and check instance before adding cache tags * [TASK] Check return type of blog post query before adding cache tags * [BUGFIX] Remove reference to non existing class for upgrade wizard 6512da7

## BUGFIX
- [BUGFIX] Respect l18n_cfg setting in PostRespository 37414f9
- [BUGFIX] Add missing @lazy annotation 11e205a
- [BUGFIX] Make entries in filter unique 0f80596
- [BUGFIX] Avoid unnessesary post casting to object in comment form 6f47696
- [BUGFIX] TE-109: show only default language tags in BE forms 3738984
- [BUGFIX] Cleanup TCA 14a270f
- [BUGFIX] Make plugins cached and use lazy loading for relations c8b4b79
- [BUGFIX] Remove build folder for each PHP version fe23b4a
- [BUGFIX] Fix wrong code-block syntax 1a5ac8a
- Revert "[BUGFIX] Disable tests with PHP 7.1" 7407536
- [BUGFIX] Disable tests with PHP 7.1 45d9b90
- [BUGFIX] Pin symfony/polyfill-php70 to 1.8.0 218306c
- [BUGFIX] Pin symfony/polyfill-php70 to 1.9.0 b9c2ec5
- [BUGFIX] Pin php-cs-fixer to 2.12 f0c04ca
- [BUGFIX] Fix broken composer.json file f833548
- [BUGFIX] Remove composer.lock from repository 9a7b73a
- [BUGFIX] Add editor config to ensure streamlined indentions Resolves: EXTBLOG-135 Releases: master, 9.0, 8.7 60a6311
- [BUGFIX] Adjust gitattributes file Resolves: EXTBLOG-134 Releases: master, 9.0, 8.7 70fdd16
- [BUGFIX] Cast timestamp to int Releases: master, 9.0, 8.7 a8526d3
- [BUGFIX] Change category icon size Reöeases: master 62863c7
- [BUGFIX] Fix wrong update registration and check instance before adding cache tags * [TASK] Check return type of blog post query before adding cache tags * [BUGFIX] Remove reference to non existing class for upgrade wizard 6512da7

# 8.7.2

## BREAKING
- [!!!][FEATURE] AvatarProvider selectable on author record level 4a86408
- [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB] 2600c4e

## FEATURE
- [FEATURE] Added possibility to show related posts 55650a4
- [FEATURE] Add data to view 93e6ce1
- [FEATURE] Set a details page per specific author. If no details page is set it reverts to the default behaviour. ea043b2
- [FEATURE] Add possibility to generate overview of post based on a category set in backend 6379e8c
- [FEATURE] Documentation update c20ac27
- [!!!][FEATURE] AvatarProvider selectable on author record level 4a86408
- [FEATURE] Add current category to widget view 274ddbc
- [FEATURE] Add posts to category model b67efe5
- [FEATURE] Add setting for blogSetup to comments sidebar widget a0e5e68

## TASK
- [TASK] Change PHP CS Fixer config 119ce70
- [TASK] Change PHP CS Fixer config 225430e
- [TASK] Added documentation for list by category 0faf8d3
- [TASK] Fix CGL issues 5ddffec
- [TASK] Fix bamboo setup 4ab5fb1
- [TASK] Fix CGL issues 7ed6fea
- [TASK] Added fields for blog creation date to the pages_language_overlay records 784c37b
- [TASK] Fix PHP version contraints 8b856b1
- [TASK] Exclude vendor from linter 0afb2da
- [TASK] Exclude vendor from linter 2477abd
- [TASK] Fix CGL issues 197bb66
- [TASK] bamboo setup c3b13e7
- [TASK] Add .gitattributes file to repository 2472752
- [TASK] Add sorting for tags in backend 2fbb87e
- [TASK] Add build status badge b6879b6
- [TASK] Change verison number for next development sprint 4b146ff
- [TASK] Change verison number for next release baba41d
- [TASK] Add README.md file f64ec7c
- [TASK] Add links to composer.json 71588e8
- [TASK] Optimize icons 6035176
- [TASK] Optimize icons 4dcf088
- [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB] 2600c4e
- [TASK] Use GeneralUtility::getIndpEnv('REMOTE_ADDR') 9be88fe
- [TASK] Change version number be129a2
- [TASK] Prepare release 8.7.0 77f3d0c
- [TASK] Change version number f9bf6ef
- [TASK] Prepare release 8.7.0 1e7f087
- [TASK] Prepare UnitTests.xml e7354c7
- [TASK] Prepare release 8.7.0 8340bf8
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
- [BUGFIX] Change version number acd5e86
- [BUGFIX] Fix changelogs / documentation 36c948a
- [BUGFIX] Fix changelogs / documentation e60366d
- [BUGFIX] Remove cache tagging for archive widget, which make no sense 7769a33
- [BUGFIX] Prevent bypassing re-captcha check c4889ed
- [BUGFIX] Use repository instead of model to retrieve posts by category e6b2a8a
- [BUGFIX] fix only extension classes 5b87f29
- [BUGFIX] Fix log file name b958933
- [BUGFIX] Author view helper fix Cherry picking for v8.7 fix 213eb59
- [BUGFIX] Remove tags and authors fields from page_language_overlay f48263a
- [BUGFIX] Tag and clear cache for all relevant changes d61a8de
- [BUGFIX] Add missing storage pid condition 1bea110
- [BUGFIX] Exception in sidebar plugin without tags 50e37d2
- [BUGFIX] Fix wrong markup for pagination f9e92f7
- [BUGFIX] Add missing labels 94dca57
- [BUGFIX] Add missing label 928b1f1
- [BUGFIX] Fix wording of category label 93058c9
- [BUGFIX] Add missing label for SEO tab d14aba3
- [BUGFIX] Fix wrong size of icons in PageTree a54bd61
- [BUGFIX] Override category config only for blog pages 4d791fc
- [BUGFIX] Change license in composer.json fb083c2
- [BUGFIX] SetupWizard breaks composer based installations 497669a
- [BUGFIX] Fix SetupSerice, remove restricition container 886022f
- [BUGFIX] Install EXT:rx_shariff with EXT:blog_template d604087
- [BUGFIX] Fix typo in description 4a4dd46
- [BUGFIX] Fix broken SQL statement for comments 7d9dcbe
- [BUGFIX] Fix SQL typo and statement for TagRepository decf984
- [BUGFIX] Add an additional check before validating re-captcha 02329cd
- [BUGFIX] Streamline settings 35aa786
- [BUGFIX] Respect sys_language in comment count aaae16c
- [BUGFIX] Fix metadata plugin rendering 11aab5a
- [BUGFIX]  Respect language in comments widget 803e2bb
- [BUGFIX] Force pid of comments to post uid fe0558f
- [BUGFIX] Fixed small bug causing error in backendmodule when selecting one blogSetup 8a89856

## MISC
- Update Documentation/Changelog/master/Important-88-Remove-GLOBALS-TYPO3_DB.rst 59b55a8
- EXTBLOG-60 - Update Recent comments widget 469b4a8
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

