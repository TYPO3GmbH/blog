# 11.0.0

## BREAKING

- [!!!][TASK] Drop unused archive template 3ba6b84
- [!!!][TASK] Allow TYPO3 version 11.0 and drop support vor 9.5 39666d5

## FEATURE

- [FEATURE] Add Instagram profile URL (#229) 00feddf
- [FEATURE] Add demand plugin (#227) 66f4c33

## TASK

- [TASK] Enable lazy loading for all images 6a48fee
- [TASK] Set default sorting to desc for demand plugin 655d1cd
- [TASK] Add neon files to editorconfig fe03be4
- [TASK] Disable xdebug by default for dev environment 9841a34
- [TASK] Update dependencies b3dd5c0
- [!!!][TASK] Drop unused archive template 3ba6b84
- [TASK] Expose more data as attributes 0bffba7
- [TASK] Remove never used icon within category model b190186
- [TASK] Use SiteConfiguration for website title in standalone mode 8e66e97
- [TASK] Update ddev a869f5a
- [TASK] Update frontend dependencies ceac221
- [TASK] Add compatibility for TYPO3 v11 (#199) a2f6293
- [TASK] Rename comment form explanation hint (#182) cd8a00a
- [TASK] Remove unreachable else because ternary operator condition is always true 8767b93
- [TASK] Add services configuration (#179) 40f4bca
- [TASK] Remove outdated TCA definitions (#165) 7609ba5
- [TASK] Move plugin registration to TCA overrides (#169) 7e186b0
- [TASK] Drop manual cache hash config from link generation cc64bbc
- [TASK] Use php version 7.4 bba1992
- [TASK] Remove compat packages for v9.5 3f9d4ca
- [TASK] Include 7.2 and 7.3 only on v10.4 163a5c0
- [!!!][TASK] Allow TYPO3 version 11.0 and drop support vor 9.5 39666d5

## BUGFIX

- [BUGFIX] Ensure that custom categories are restricted to default language 76b2505
- [BUGFIX] Add missing tsconfig settings for demand plugin cb2c710
- [BUGFIX] Dont use strings as uid for fake content elements (#228) 333e663
- [BUGFIX] Allow to overwrite properties of google captcha 1cb46c7
- [BUGFIX] Cleanup Annotations 497ea2c
- [BUGFIX] Ensure modal is closed after install is triggered a9103df
- [BUGFIX] Cleanup indention in postcss.config aa9ba6c
- [BUGFIX] Ensure constant editor shows selected option values b808d42
- [BUGFIX] Drop latest post flexform config to have typoscript settings respected 99be165
- [BUGFIX] Correct Pagination (#210) ca37059
- [BUGFIX] Ensure setFinisherIdentifier is defined 9ac8cb3
- [BUGFIX] Wait for DOM being ready before initializing DataTables a161258
- [BUGFIX] Update vulnerable npm development modules 60aef51
- [BUGFIX] Setup mysql server in docker container ef72282
- [BUGFIX] Check for pages in extended TCA for sys_category d61c41d
- [BUGFIX] Use full qualified class names for controller references 81552dc
- [BUGFIX] Avoid deprecation call for PageRepository 9e2bd7a
- [BUGFIX] Correct composer version constraints 9bfb8cd

## MISC

- Bump tar from 6.1.0 to 6.1.3 5ee8713

# 10.0.0

## BREAKING

- [!!!][FEATURE] Allow to disable the url input in the comment form f17de3e
- [!!!][TASK] Decouple archive from sidebar widget 516976c
- [!!!][BUGFIX] Ensure fallback to default templates is always set 5f496c9
- [!!!][TASK] Drop all exclude fields d268ed0
- [!!!][BUGFIX] Limit tags to configured storage pid 8befd62
- [!!!][BUGFIX] Limit authors to default language 6caf365
- [!!!][BUGFIX] Respect PageTsConfig limitation for authors b2b058f
- [!!!][TASK] Drop social image wizard and prefer ext:seo (#121) 2d2dc30
- [!!!][TASK] Drop social share options 8a34e35
- [!!!][TASK] Drop obsolete MetaService 7cd241b
- [!!!][TASK] Add configuration error note for single view plugins (#94) 780f018
- [!!!][TASK] Modernize list renderings 65affe6
- [!!!][FEATURE] Modernize metadata rendering (#84) 28ef430
- [!!!][FEATURE] Remove fontawesome dependency 4bf2ae8
- [!!!][TASK] Use TYPO3 Form Framework for comment form (#78) 407a2af
- [!!!][TASK] Modernize pagination rendering de0f9d2
- [!!!][TASK] Modernize widget content rendering eb85165
- [!!!][TASK] Do not scale tags size by default f0507bd
- [!!!][TASK] Modernize widget rendering 8db7276
- [!!!][TASK] Modernize post comment rendering a0b7d31
- [!!!][TASK] Modernize post author rendering a17891e
- [!!!][TASK] Adapt section names to follow recommendations 3b1fad6
- [!!!][TASK] Always include social image wizard tsconfig 946f8c1
- [!!!][TASK] Remove Google Plus after its shutdown (#68) 70f4470
- [!!!][TASK] Remove obsolete sidebar headline (#66) 7fac00a
- [!!!][FEATURE] AvatarProvider selectable on author record level 50751c5
- [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB] efd769d

## FEATURE

- [FEATURE] Add avatars to author listing 2ed0cf9
- [FEATURE] Allow user avatars in meta sections b4c2e8b
- [!!!][FEATURE] Allow to disable the url input in the comment form f17de3e
- [FEATURE] Add detail links to overview lists 8be3d09
- [FEATURE] Add backlinks to overview for post listings c4bec3d
- [FEATURE] Pagination templates respect fallback chain 1ad583c
- [FEATURE] Refactor gravatar loading (#161) 0bd05d3
- [FEATURE] Introduce blog categories (#142) 434a50e
- [FEATURE] Include featured image in rss feed a829875
- [FEATURE] Include comment link and authors in rss feed 2e1c159
- [FEATURE] Integration and Standalone Mode (#125) c56e1c4
- [FEATURE] Respect language fallbacks when resolving Posts (#134) 4a40a31
- [FEATURE] Show post information in backend page header (#135) 418d97d
- [FEATURE] Add latest post plugin with configurable limit (#86) dc8b0e1
- [FEATURE] Add function to get all tags of all articles by one author (#119) c79856c
- [FEATURE] Create example comment and author on setup 8b12146
- [FEATURE] Provide dedicated featured image b7c1e6f
- [FEATURE] Add the currently selected/filtered tag to TagWidget (#96) 9d6c343
- [!!!][FEATURE] Modernize metadata rendering (#84) 28ef430
- [!!!][FEATURE] Remove fontawesome dependency 4bf2ae8
- [FEATURE] Add schema.org data for blog authors 737512a
- [FEATURE] Format new line to paragraph viewhelper 7e4443e
- [FEATURE] Add pagination to routes (#36) a055325
- [FEATURE] Make pagination configurable (#34) 461db54
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

- [TASK] Add publishing TER workflow 8048d74
- [TASK] Use standalone php-cs-fixer for ci 5fb0adb
- [TASK][COMMUN-39] Update Documentation (#178) 61db6df
- [TASK] Bump ini from 1.3.5 to 1.3.7 (#175) 6523f35
- [TASK] Update CI Setup (#171) 54d701d
- [!!!][TASK] Decouple archive from sidebar widget 516976c
- [TASK] Add pages migration for featured_image 2152304
- [TASK] Raise dependencies aacef52
- [TASK] Update frontend packages 01533a8
- [TASK] Test Coveralls (#163) 2384465
- [TASK] Update dev dependencies 1d906d3
- [TASK] Update dependencies a3061fe
- [TASK] Limit builds to ^9.5 and ^10.4 6375c02
- [TASK] Allow typo3/testing-framework ^6.2 b2722ad
- [TASK] Add roles for main content area 35b2c50
- [!!!][TASK] Drop all exclude fields d268ed0
- [TASK] Include typo3/cms-beuser as dev dependency 9c8962d
- [TASK] Update build dependencies 78192a9
- [TASK] Make module positioning compatible with TYPO3 10.4.x 9e240bb
- [TASK] Improve ci workflow (#132) 36416bd
- [TASK] Move extension icon to Resources/Public/Icons 634986e
- [TASK] Update ddev to 1.13.1 271f90e
- [TASK] Improve backend modules 569c2ff
- [TASK] Update dependencies d17e2a4
- [TASK] Extend setup dataset 63b87ad
- [TASK] Update frontend stack 49eb77b
- [TASK] Add setup as dev dependency ff20605
- [TASK] Adjust requirements 11736e4
- [TASK] Remove obsolete _make settings for documentation c7945bb
- [TASK] Update ddev to 1.12.1 e904aa5
- [TASK] Remove tempfs to avoid problems on linux runners 65991fa
- [TASK] Fix link in README.md c4f5e61
- [TASK] Add link to documentation in README.md aefa047
- [!!!][TASK] Drop social image wizard and prefer ext:seo (#121) 2d2dc30
- [TASK] Add translations for authors (#118) d53312a
- [TASK] Move to GitHub Actions instead of Travis (#117) 29541dd
- [TASK] Cleanup pages tca b4e4ac4
- [TASK] Compile backend amd modules with webpack 192c6e7
- [TASK] Update all icons 4c07790
- [TASK] Split blog backend modules fd16da9
- [!!!][TASK] Drop social share options 8a34e35
- [TASK] Move frontend css sources 06ed9f2
- [!!!][TASK] Drop obsolete MetaService 7cd241b
- [!!!][TASK] Add configuration error note for single view plugins (#94) 780f018
- [TASK] Add related posts to test setup 48d408d
- [TASK] Add language menu to test setup ce1607a
- [TASK] Update dev dependencies 8238f74
- [TASK] Update ddev to 1.10.1 5242101
- [TASK] Set extension key in composer.json 3bfffdd
- [TASK] Move development app dir into .build folder 6d9bc40
- [TASK] Move cache to tmpfs for dev environment 236b692
- [TASK] Raise v10 dependency to allow dev-master 09e8f18
- [TASK] Add seo extension as dev requirement e1efb6d
- [!!!][TASK] Modernize list renderings 65affe6
- [TASK] Update ddev to 1.9.1 a330d19
- [TASK] Update build dependencies 6fb4621
- [TASK] Improve development template f52b38a
- [TASK] Sort language files 8af468e
- [TASK] Add typo3/cms-belog as development dependency 8a4a954
- [!!!][TASK] Use TYPO3 Form Framework for comment form (#78) 407a2af
- [TASK] Add typo3/cms-rte-ckeditor as development requirement 6d5d630
- [!!!][TASK] Modernize pagination rendering de0f9d2
- [TASK] Streamline language files 97cab12
- [!!!][TASK] Modernize widget content rendering eb85165
- [!!!][TASK] Do not scale tags size by default f0507bd
- [!!!][TASK] Modernize widget rendering 8db7276
- [TASK] Wrap post authors 5cab2ab
- [!!!][TASK] Modernize post comment rendering a0b7d31
- [!!!][TASK] Modernize post author rendering a17891e
- [TASK] Move typoscript css to file 65cf485
- [!!!][TASK] Adapt section names to follow recommendations 3b1fad6
- [TASK] Streamline pagination html template 61c3203
- [TASK] Streamline html templates and register global blog viewhelpers 85bc399
- [!!!][TASK] Always include social image wizard tsconfig 946f8c1
- [TASK] Make 10.0.x compatible with TYPO3 9.5.x 75c75a5
- [!!!][TASK] Remove Google Plus after its shutdown (#68) 70f4470
- [TASK] Replace config.persistence.classes typoscript configuration (#71) dfc4767
- [TASK] Set default indent style to spaces ca13a91
- [TASK] Add tstemplate as dev dependencies 3a23ac0
- [TASK] Add lowlevel and filelist as dev dependencies 5b9c567
- [!!!][TASK] Remove obsolete sidebar headline (#66) 7fac00a
- [TASK] Display requirements in readme as table 410b4ed
- [TASK] Update ddev to 1.7.1 9c76127
- [TASK] Remove .travis.yaml from archive 52f6e2f
- [TASK] Remove .travis.yaml from archive 5ccb9d4
- [TASK] Add fontawesome to development setup 3f6cc42
- [TASK] We just pretend we're unbreakable 2476717
- [TASK] Enable xdebug for ddev and add vscode debug config ad6b9ff
- [TASK] Set development environment c29b179
- [TASK] Update ddev to 1.6.0 3d066d1
- [TASK] Add config to ignored folders 5474602
- [TASK] Add extension-helper as dev dependency to generate releases d183441
- [TASK] Improve readme (#22) 2697526
- [TASK] Add GitHub issue templates 14c748e
- [TASK] Update documentation for github 50e0f15
- [TASK] Setup travis 09ab08a
- [TASK] Adjust and improve documentation Resolves: EXTBLOG-151 Releases: master, 9.1, 9.0 09f712b
- [TASK] Add test package 49c8d1b
- [TASK] Add ddev testing instance 789836d
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

- [BUGFIX] Bundle PSR-Packages for non Composer mode (#181) 48e9e81
- [BUGFIX] Enforce ArchiveViewHelper to return a string (#180) d1d42da
- [BUGFIX] Cast pageUid in RedirectFinisher to string (#173) f9d3c1a
- [BUGFIX] Never forget to check again after you have done your "optimizations" 5cd5a40
- [BUGFIX] Correct position of content on tag view 65af1b7
- [BUGFIX] Use author detail links for profile 97513a6
- [!!!][BUGFIX] Ensure fallback to default templates is always set 5f496c9
- [BUGFIX] Use noreply as default email address (#159) d79d63d
- [BUGFIX] Correct route configuration for archive links (#151) 9b635b4
- [BUGFIX] respect pages.l18n_cfg in all cases 5a83f5c
- [BUGFIX] Ensure setup is creating categories of type blog 9cc737a
- [BUGFIX] Only extend site site configuration hook if it exists. 1a3d936
- [BUGFIX] Ensure boolean is returned after sending a6d2520
- [BUGFIX] Make mailer compatible with 10.4 (#141) f931f5d
- [BUGFIX] Use different icon for blog pages defined as root 418e497
- [!!!][BUGFIX] Limit tags to configured storage pid 8befd62
- [!!!][BUGFIX] Limit authors to default language 6caf365
- [!!!][BUGFIX] Respect PageTsConfig limitation for authors b2b058f
- [BUGFIX] Do not render fluid namespace helper in rss feed 08d3aa4
- [BUGFIX] Ensure standalone title is linking to the correct root page 48f83e9
- [BUGFIX] Ensure setup creates site configuration c7a5809
- [BUGFIX] Show hidden posts in backend module 31ef29d
- [BUGFIX] Do not use relative paths for css includes 90a6bfc
- [BUGFIX] Remove discus includes on non single post related templates 530b522
- [BUGFIX] Correct constraint for fetching posts by year 45e8720
- [BUGFIX] Add typecasts for page types a7eab9a
- [BUGFIX] Remove obsolete language fields for blog comments be20e4d
- [BUGFIX] Fix a small typo (#124) 4260ba2
- [BUGFIX] Enable language synchonization for featured image 346e0d7
- [BUGFIX] Use actions badge instead of removed travis e7e5a4d
- [BUGFIX] Use correct constants for feature image 5f82cbe
- [BUGFIX] Correct cgl b5e5e81
- [BUGFIX] Use MetaTag API (#89) 302bc13
- [BUGFIX] Limit author posts to blog posts and default language  (#69) e463e74
- [BUGFIX] Make CategoryViewHelper compatible with v10 e52368b
- [BUGFIX] Make TagViewHelper compatible with v10 995f942
- [BUGFIX] Make PostViewHelper compatible to v10 d260966
- [BUGFIX] Remove obsolete fields and enable cropping for author images 62169de
- [BUGFIX] Remove display condition for slug fields of custom records (#43) bfba7a7
- [BUGFIX] Correct development template 404dc89
- [BUGFIX] Set default doktype for post model (#83) 36b4f45
- [BUGFIX] Make testing setup compatible with latest testing framework versions 4abea18
- [BUGFIX] Use settings.lists in documentation 933d046
- [BUGFIX] Use LocalizationUtility instead of LanguageService 0546781
- [BUGFIX] Use correct identifier for publish date update 6b3f3e8
- [BUGFIX] Only execute publish date update when fields exist ca4753b
- [BUGFIX] Use correct identifier for month and year update 430e165
- [BUGFIX] Only execute month and year update when fields exist 42c3318
- [BUGFIX] Check if tag does exist before accessing properties e057225
- [BUGFIX] Check if category does exist before accessing properties 1391d14
- [BUGFIX] Check if author does exist before accessing properties d90101f
- [BUGFIX] Do not include google captcha when disabled in settings cd1c276
- [BUGFIX] Respect translation settings in archive widget (#77) 41669b9
- [BUGFIX] Use correct column type for comment sorting by date in backend 420b435
- [BUGFIX] Use correct column type for post sorting by date in backend 72ef1e2
- [BUGFIX] Use publishDate for date sorting in backend module 49a0085
- [BUGFIX] Ensure tag link viewhelper always returns a string c8bda4e
- [BUGFIX] Add missing comment id attribute for section links 298f193
- [BUGFIX] Disallow multiple assignments of authors to a post (#70) d427276
- [BUGFIX] Respect configured size in Avatar ImageProvider (#74) f695236
- [BUGFIX] Add severity classes to flash messages (#76) cfbacfa
- [BUGFIX] Correct travis cgl fixer config e673790
- [BUGFIX] Correct cgl and remove obsolete php_versions file f27c98e
- [BUGFIX] Add crdate field configuration for extbase abdf3b5
- [BUGFIX] Use today as publishing date for new blog entries (#59) 1b4303d
- [BUGFIX] Add plugins to new content element wizard (#61) 31f63fc
- [BUGFIX] Remove storage constraint from finding current post (#63) d1658ef
- [BUGFIX] Only add storage constraint if pages could be resolved (#65) c93b65f
- [BUGFIX] Avoid exception when accessing uninitialized settings (#50) 654abdc
- [BUGFIX] Set format for comments rss feed (#56) 5c38906
- [BUGFIX] Correct fluid namespace definitions - fixes #51 (#52) 7a7145b
- [BUGFIX] Allow language synchronization (#48) ab732a0
- [BUGFIX] Fix language sensitivity of getCurrentPost (#47) d3767ea
- [BUGFIX] Fix column width for comment actions column 552556c
- [BUGFIX] Resolve endless loop when calling archive without params (#35) 2fe9b8c
- [BUGFIX] Set addQueryStringMethod again to avoid faulty strict mode f248dca
- [BUGFIX] Generate correct link to blog rss channel d5821e1
- [BUGFIX] Make route-enhancer configuration work (#29) 726a3c4
- [BUGFIX] Introduce path-segments for tags, author and category - fixes #31 (#32) ec79f88
- [BUGFIX] Remove outdated realurl information and use route enhancer (#30) 4da3299
- [BUGFIX] LinkViewHelper must set correct controller context (#28) cd4c7e4
- [BUGFIX] Add extension name to uriFor in all ViewHelpers (#6) 28c77ac
- [BUGFIX] Fix #24: TypyError exception when calling PostRepository::findRelatedPosts() (#25) 09b617f
- [BUGFIX] Exclude .github folder from export 72c2bc7
- [BUGFIX] Remove limitToPages setting from default routes config a155ef9
- [BUGFIX] Let the SocialImageWizard working again Resolves: EXTBLOG-154 Releases: master, 9.1, 9.0 c77a935
- [BUGFIX] Correct composer dependencies 239255e
- [BUGFIX] Ensure type safety for ViewHelper calling ImageService The ImageService::getImage requires a string as first and a boolean as third parameter. The Image ViewHelpers must respect this requirement. related to https://review.typo3.org/59608 5c4afc3
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

- Add documentation regarding the configuration of storage PIDs (#103) 8952cc1
- Update Crowdin configuration file 0b50517
- [CLEANUP] Remove never used add comment tempalte 5521b42
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

