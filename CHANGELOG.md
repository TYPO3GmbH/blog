# 13.0.0

## TASK

- 0b7084a [TASK] Update deprecated github actions
- 32754a3 [TASK] Ensure typo3fluid/fluid 2.15 is available in classic mode
- 3aaa686 [TASK] Update version shields in README
- 1dd7c6e [TASK] Replace INCLUDE_TYPOSCRIPT by @import
- 3f4035d [TASK] Resolve v12 TCA deprecations
- 321664c [TASK] Migrate deprecated phpstan options
- f9869d0 [TASK] Resolve v12 phpstan errors
- fa00afa [TASK] Check return type of findByUid in PostRepository
- 3dfca4f [TASK] Replace deprecated fillDefaultsByPackageName
- 4ca2c2e [TASK] Do not try to read id from POST body in blogpost header renderer
- 5c559af [TASK] Replace deprecated Connection::PARAM_STR_ARRAY
- f402b21 [TASK] Use ContextualFeedbackSeverity for v13
- c19ad73 [TASK] Avoid renderStatic which has been deprecated
- f6f39a1 [TASK] Remove unneeded fluid register(Universal)TagAttribute(s) calls
- 51d2548 [TASK] Drop actions-decline icons
- 7c4a960 [TASK] Adapt GoogleCaptchaValidator for v13
- 3abcbe0 [TASK] Make backend styles light/dark aware for v13
- a5db722 [TASK] Adapt WidgetController for v13
- f6c0945 [TASK] Replace ConfigurationManager->getContentObject for v13
- b5b5d54 [TASK] Add a workaround for too strict typing in TagBuilder
- e37385d [TASK] Make creation wizard context aware
- d3d8999 [TASK] Update to current backend module API
- 85c4716 [TASK] Migrate to ES6 JavaScript modules
- 0f98fac [TASK] Register icons via Configuration/Icons.php
- 60eede4 [TASK] Replace getTwoLetterIsoCode
- 52881e0 [TASK] Correct DataHandlerHookTest namespace to match psr-4
- 4a8c0a2 [TASK] Use phpunit attributes in tests
- 3365532 [TASK] Adapt AvatarViewHelperTest for v13
- 0191ec4 [TASK] Adapt SiteBasedTestCase for v13
- 73e50f5 [TASK] Adapt GravatarViewHelperTest for v13
- 0d0f0cf [TASK] Adapt GravatarProviderTest for v13
- 0c1760f [TASK] Replace Bootstrap::initializeLanguageObject() in tests for v13
- 6ff3fa7 [TASK] Make AbstractUpdate v13 compatible
- 845aae1 [TASK] Replace EMU::addPageTSConfig by Configuration/page.tsconfig
- 2f272d2 [TASK] Register upgrade wizards via attribute
- ee231e0 [TASK] Replace TSFE->tmp->setup by frontend.typoscript attribute
- 160190d [TASK] Adapt CommentFormFactory for v13
- fc1590d [TASK] Drop v11 drawHeaderHook registration
- 8f3c9ba [TASK] Use Configuration/user.tsconfig in v13
- 72506e5 [TASK] Replace deprecated php-cs-fixer setting function_typehint_space
- 9dedafd [TASK] Remove outdated post-autoload-dump script
- cf043e3 [TASK] Mark v13 as supported in ext_emconf
- e4f0f0f [TASK] Update v13 composer dependencies
- 964e3d5 [TASK] Use typo3/testing-framework v9
- 02440f4 [TASK] Start v13 migration
- 466fc12 [TASK] Update github workflows for v13
- f6c03ac [TASK] Prepare README.rst for v13
- 8a46930 [TASK] Provide EXT:form in functional tests

## BUGFIX

- 4f1fc32 [BUGFIX] Fix count view helper usage in setup wizard

## Contributors

- Achim Fritz
- Benjamin Franzke
- Benni Mack

# 12.0.2

## TASK

- c6a2a66 [TASK] Add index for `crdate` fields

## BUGFIX

- 4ba5e6f [BUGFIX] Build correct database query in `StaticDatabaseMapper`

## Contributors

- Andreas Fernandez

# 12.0.1

## BUGFIX

- 965792c [BUGFIX] Article publish date is always replaced by current timestamp (#283)

## Contributors

- LeoniePhiline

# 12.0.0

## BREAKING

- 56d36ce [!!!][BUGFIX] Ensure author avatars are fetched in the correct size
- e1ebf49 [!!!][BUGFIX] Drop unused argument in gravatar viewhelper
- d0e489c [!!!][TASK] Drop never implemented feuser comment author
- 19901f9 [!!!][TASK] Drop deprecated metadata plugin

## TASK

- 36cf5b5 [TASK] Update assets in standalone example
- 635a926 [TASK] Update readme
- f2e4965 [TASK] Declare compatibility with TYPO3 v12 (#274)
- e2bb2aa [TASK] Make Frontend FlashMessages compatible with v12 (#280)
- d8ef266 [TASK] Make MailContent compatible with v12 (#279)
- 4a4e9be [TASK] Adjust phpstan config to do not check generic types
- b1f2ecd [TASK] Drop unused getTypoScriptFrontendController method in PostController
- 5906436 [TASK] Make massupdate compatible with v12 (#278)
- 4e606be [TASK] Update Datatables
- ef00e7a [TASK] Make BackendController compatible with v12
- 388b433 [TASK] Adapt unit test config file
- 627f1b8 [TASK] Avoid warning in TestDataProcessor
- cc7d5ae [TASK] Do not show display deprecations on functional tests
- da26ea3 [TASK] Make post controller compatible with v12
- 6cc22d8 [TASK] Make page and record header information compatible with v12 (#277)
- febec30 [TASK] Use mock for RequestFactory in GravatarResourceResolverTest
- 5f7bfce [TASK] Make page type restriction removal for comments compatible with v12
- 3a778e6 [TASK] Allow experimental installation with TYPO3 v12
- 5330f75 [TASK] Make backend module registration compatible with v12
- f9fcfdb [TASK] Import namespaces in ext_localconf and ext_tables
- 8056c0f [TASK] Streamline type annotations
- 8c19ab9 [TASK] Respect type not nullable in GravatarProvider
- 84333b9 [TASK] Respect repository return types used in BackendController
- 7939ce0 [TASK] Cleanup PostController
- dec9d38 [TASK] Make return types of repositories more strict
- c61fb3f [TASK] Make CommentFormFactory compatible with v12
- ccd105e [TASK] Cleanup CommentFormFactory
- c4eea49 [TASK] Make GravatarProvider compatible with v12
- 97ecdbf [TASK] Make Query compatible with v12 (#276)
- 14494f4 [TASK] Cleanup Author
- 9ce412a [TASK] Cleanup Category
- 48f5986 [TASK] Cleanup Post
- b48b057 [TASK] Remove obsolete mm table definitions
- 5e88518 [TASK] Cleanup Tag
- d55f740 [TASK] Cleanup CategoryRepository
- f79dab1 [TASK] Cleanup PostRepository
- 68c7bf4 [TASK] Cleanup TagRepository
- 0be8ce9 [TASK] Drop request backports
- b77f22d [TASK] Cleanup DataHandlerHook
- 9135697 [TASK] Cleanup CommentRepository
- 56d7d77 [TASK] Cleanup CommentFormFinisher and CommentService
- 116d2b9 [TASK] Avoid object manager GoogleCaptchaValidator factory
- 88c3139 [TASK] Avoid object manager CommentFormFactory factory
- 1856998 [TASK] Simplyfy access to configuration in ContentListOptionsViewHelper
- 499463e [TASK] Minor cleanups
- 8225019 [TASK] Cleanup Notifications
- c5a1b37 [TASK] CGL
- ba45490 [TASK] Cleanup BlogPagination
- 8c64946 [TASK] Cleanup StaticDatabaseMapper
- f98d485 [TASK] Cleanup SetupService
- e648771 [TASK] Cleanup BackendController
- bbc8c0e [TASK] Ignore phpstan typecast errors for int and bool
- f625b56 [TASK] Minor Cleanups
- 46e6e38 [TASK] Cleanup ViewHelpers
- c99a58a [TASK] Avoid empty() and be more strict in comparisons
- eeea228 [TASK] Handle not existing requests in backend link viewhelpers
- ca72a1a [TASK] Add phpstan but allow failure during ci
- 2eda105 [TASK] Avoid object manager in ContentListOptionsViewHelper
- f1b7598 [TASK] Minor cleanups
- 127af4a [TASK] Avoid object manager in post model
- f5a9125 [TASK] Adapt expectations for backend link viewhelpers
- c49f988 [TASK] Streamline backend link viewhelpers
- 544bac4 [TASK] Make renderFluidTemplateInTestSite mimic extbase request
- 4080a0f [TASK] Make SiteBasedTestCase compatible with v12
- 778b69b [TASK] Add tests for link viewhelpers
- e9ad4ca [TASK] Remove ObjectManager from avatar provider
- 1fbde27 [TASK] Move backend post header to dedicated renderer
- 4de4bcd [TASK] Drop obsolete typoscript extbase persistance config
- d0e489c [!!!][TASK] Drop never implemented feuser comment author
- 99af3da [TASK] Streamline formatting of yaml files
- 19901f9 [!!!][TASK] Drop deprecated metadata plugin
- 2f3e193 [TASK] Cleanup TCA
- 48d26ec [TASK] Drop some docheader and use ?? instead of ?:
- f8737ee [TASK] Drop all @noinspection comments
- 3c87b53 [TASK] Modernize update scripts and cover by functional tests
- b40af59 [TASK] Remove coverage from functional tests
- fb35a32 [TASK] Update testing framework
- dfb29fb [TASK] Update phplint
- 94c2999 [TASK] Drop @noinspection PhpInternalEntityUsedInspection
- a24f3a9 [TASK] Update dev requirements for bootstrap package and extension helper
- eee0e19 [TASK] Ignore .cache files
- cebdc49 [TASK] Adjust editorconfig
- 6a5c1d1 [TASK] Drop coveralls reporting
- f154874 [TASK] Adjust ci matrix to include php 8.1, 8.2 and mysql 8.0
- d5156de [TASK] Set php development version to 8.2
- 8fbe597 [TASK] Add allow-plugins
- 3a7eb40 [TASK] Update npm dependencies
- f4eb557 [TASK] Adapt php requirement
- 17939be [TASK] Allow PHP 8.0 (#235)
- e81d04d [TASK] Drop v10 support (#232)

## BUGFIX

- 2749ab4 [BUGFIX] Return interface on comment update
- 4aee32b [BUGFIX] Make setup wizard compatible with v12
- d91a86d [BUGFIX] Add CommentFormFactory to services
- f8b0c7a [BUGFIX] Correct request parameter checks
- 52e2d14 [BUGFIX] Correct namespace of ContentListOptionsViewHelperTest
- af7551b [BUGFIX] Respect storage pid for categories
- 8278f9d [BUGFIX] Extbase should not map avatar
- 0eeacbb [BUGFIX] CGL
- af4d21c [BUGFIX] CGL
- 718bbf2 [BUGFIX] Dynamic call to static method
- c209790 [BUGFIX] Set default values to models
- c612e6f [BUGFIX] Correct initial setup to store comment on target post page
- bc4fee2 [REVERT][BUGFIX] Do not overwrite storage pid of comments
- c810437 [BUGFIX] Do not overwrite storage pid of comments
- 75a19cf [BUGFIX] Typo
- 24f1f0b [BUGFIX] Correct configuration type for MailContent
- 9466f9c [BUGFIX] Handle author rss links with detail pages
- 86037cf [BUGFIX] Exclude various dev-only files from dist archives (#271)
- 3b25643 [BUGFIX] PHP 8 argument type errors (#273)
- 7b7196f [BUGFIX] Correct flaky test
- 612cd6d [BUGFIX] Use correct class in docheader
- 50e88af [BUGFIX] Set request to UriBuilder after reset
- 832ce1e [BUGFIX] Correct namespaces of link functional tests
- 28725db [BUGFIX] Correct test namespaces
- 8587ea1 [BUGFIX] CGL
- 56d36ce [!!!][BUGFIX] Ensure author avatars are fetched in the correct size
- e1ebf49 [!!!][BUGFIX] Drop unused argument in gravatar viewhelper
- beb2b89 [BUGFIX] Adapt extension loading in gravatar provider test
- d08bd32 [BUGFIX] Correct namespace for functional tests
- b9aa130 [BUGFIX] Avoid $this->renderingContext->getControllerContext()->getUriBuilder()
- cedcb1c [BUGFIX] Use type language
- cdd6b25 [BUGFIX] Add missing return type to initializeArguments()
- a64617a [BUGFIX] Remove obsolete showRemovedLocalizationRecords
- 5be3c93 [BUGFIX] Deprecation: TYPO3_MODE and TYPO3_REQUESTTYPE constants
- cd70034 [BUGFIX] Ensure all upgrade wizards are registered
- 42c36c8 [BUGFIX] Add missing return types and declare dataprovider static
- 488887a [BUGFIX] Remove sql definition for l18n_diffsource
- c3a2047 [BUGFIX] Adapt structure and fix tests (#275)
- 690f056 [BUGFIX] CGL
- 56fb360 [BUGFIX] Catch PHP8 array key warnings
- 75d1283 [BUGFIX] Remove semicolons from annotations (#250)
- 3d61582 [BUGFIX] Avoid PHP 8.0 warnings (#238)
- ed56de5 [BUGFIX] Correct build matrix
- c978937 [BUGFIX] Correct dependencies

## MISC

- 243fa31 Bump nanoid from 3.1.28 to 3.2.0

## Contributors

- Benjamin Kott
- Benni Mack
- Dominik Dörr
- Elias Häußler
- Ingo Fabbri
- Mathias Schreiber
- dependabot[bot]

# 11.0.0

## BREAKING

- 3ba6b84 [!!!][TASK] Drop unused archive template
- 39666d5 [!!!][TASK] Allow TYPO3 version 11.0 and drop support vor 9.5

## FEATURE

- 00feddf [FEATURE] Add Instagram profile URL (#229)
- 66f4c33 [FEATURE] Add demand plugin (#227)

## TASK

- 6a48fee [TASK] Enable lazy loading for all images
- 655d1cd [TASK] Set default sorting to desc for demand plugin
- fe03be4 [TASK] Add neon files to editorconfig
- 9841a34 [TASK] Disable xdebug by default for dev environment
- b3dd5c0 [TASK] Update dependencies
- 3ba6b84 [!!!][TASK] Drop unused archive template
- 0bffba7 [TASK] Expose more data as attributes
- b190186 [TASK] Remove never used icon within category model
- 8e66e97 [TASK] Use SiteConfiguration for website title in standalone mode
- a869f5a [TASK] Update ddev
- ceac221 [TASK] Update frontend dependencies
- a2f6293 [TASK] Add compatibility for TYPO3 v11 (#199)
- cd8a00a [TASK] Rename comment form explanation hint (#182)
- 8767b93 [TASK] Remove unreachable else because ternary operator condition is always true
- 40f4bca [TASK] Add services configuration (#179)
- 7609ba5 [TASK] Remove outdated TCA definitions (#165)
- 7e186b0 [TASK] Move plugin registration to TCA overrides (#169)
- cc64bbc [TASK] Drop manual cache hash config from link generation
- bba1992 [TASK] Use php version 7.4
- 3f9d4ca [TASK] Remove compat packages for v9.5
- 163a5c0 [TASK] Include 7.2 and 7.3 only on v10.4
- 39666d5 [!!!][TASK] Allow TYPO3 version 11.0 and drop support vor 9.5

## BUGFIX

- 76b2505 [BUGFIX] Ensure that custom categories are restricted to default language
- cb2c710 [BUGFIX] Add missing tsconfig settings for demand plugin
- 333e663 [BUGFIX] Dont use strings as uid for fake content elements (#228)
- 1cb46c7 [BUGFIX] Allow to overwrite properties of google captcha
- 497ea2c [BUGFIX] Cleanup Annotations
- a9103df [BUGFIX] Ensure modal is closed after install is triggered
- aa9ba6c [BUGFIX] Cleanup indention in postcss.config
- b808d42 [BUGFIX] Ensure constant editor shows selected option values
- 99be165 [BUGFIX] Drop latest post flexform config to have typoscript settings respected
- ca37059 [BUGFIX] Correct Pagination (#210)
- 9ac8cb3 [BUGFIX] Ensure setFinisherIdentifier is defined
- a161258 [BUGFIX] Wait for DOM being ready before initializing DataTables
- 60aef51 [BUGFIX] Update vulnerable npm development modules
- ef72282 [BUGFIX] Setup mysql server in docker container
- d61c41d [BUGFIX] Check for pages in extended TCA for sys_category
- 81552dc [BUGFIX] Use full qualified class names for controller references
- 9e2bd7a [BUGFIX] Avoid deprecation call for PageRepository
- 9bfb8cd [BUGFIX] Correct composer version constraints

## MISC

- 5ee8713 Bump tar from 6.1.0 to 6.1.3

## Contributors

- Andreas Fernandez
- Benjamin Kott
- Mathias Brodala
- Susanne Moog
- Torben Hansen
- alexkue
- dependabot[bot]
- helsner

# 10.0.0

## BREAKING

- f17de3e [!!!][FEATURE] Allow to disable the url input in the comment form
- 516976c [!!!][TASK] Decouple archive from sidebar widget
- 5f496c9 [!!!][BUGFIX] Ensure fallback to default templates is always set
- d268ed0 [!!!][TASK] Drop all exclude fields
- 8befd62 [!!!][BUGFIX] Limit tags to configured storage pid
- 6caf365 [!!!][BUGFIX] Limit authors to default language
- b2b058f [!!!][BUGFIX] Respect PageTsConfig limitation for authors
- 2d2dc30 [!!!][TASK] Drop social image wizard and prefer ext:seo (#121)
- 8a34e35 [!!!][TASK] Drop social share options
- 7cd241b [!!!][TASK] Drop obsolete MetaService
- 780f018 [!!!][TASK] Add configuration error note for single view plugins (#94)
- 65affe6 [!!!][TASK] Modernize list renderings
- 28ef430 [!!!][FEATURE] Modernize metadata rendering (#84)
- 4bf2ae8 [!!!][FEATURE] Remove fontawesome dependency
- 407a2af [!!!][TASK] Use TYPO3 Form Framework for comment form (#78)
- de0f9d2 [!!!][TASK] Modernize pagination rendering
- eb85165 [!!!][TASK] Modernize widget content rendering
- f0507bd [!!!][TASK] Do not scale tags size by default
- 8db7276 [!!!][TASK] Modernize widget rendering
- a0b7d31 [!!!][TASK] Modernize post comment rendering
- a17891e [!!!][TASK] Modernize post author rendering
- 3b1fad6 [!!!][TASK] Adapt section names to follow recommendations
- 946f8c1 [!!!][TASK] Always include social image wizard tsconfig
- 70f4470 [!!!][TASK] Remove Google Plus after its shutdown (#68)
- 7fac00a [!!!][TASK] Remove obsolete sidebar headline (#66)
- 50751c5 [!!!][FEATURE] AvatarProvider selectable on author record level
- efd769d [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB]

## FEATURE

- 2ed0cf9 [FEATURE] Add avatars to author listing
- b4c2e8b [FEATURE] Allow user avatars in meta sections
- f17de3e [!!!][FEATURE] Allow to disable the url input in the comment form
- 8be3d09 [FEATURE] Add detail links to overview lists
- c4bec3d [FEATURE] Add backlinks to overview for post listings
- 1ad583c [FEATURE] Pagination templates respect fallback chain
- 0bd05d3 [FEATURE] Refactor gravatar loading (#161)
- 434a50e [FEATURE] Introduce blog categories (#142)
- a829875 [FEATURE] Include featured image in rss feed
- 2e1c159 [FEATURE] Include comment link and authors in rss feed
- c56e1c4 [FEATURE] Integration and Standalone Mode (#125)
- 4a40a31 [FEATURE] Respect language fallbacks when resolving Posts (#134)
- 418d97d [FEATURE] Show post information in backend page header (#135)
- dc8b0e1 [FEATURE] Add latest post plugin with configurable limit (#86)
- c79856c [FEATURE] Add function to get all tags of all articles by one author (#119)
- 8b12146 [FEATURE] Create example comment and author on setup
- b7c1e6f [FEATURE] Provide dedicated featured image
- 9d6c343 [FEATURE] Add the currently selected/filtered tag to TagWidget (#96)
- 28ef430 [!!!][FEATURE] Modernize metadata rendering (#84)
- 4bf2ae8 [!!!][FEATURE] Remove fontawesome dependency
- 737512a [FEATURE] Add schema.org data for blog authors
- 7e4443e [FEATURE] Format new line to paragraph viewhelper
- a055325 [FEATURE] Add pagination to routes (#36)
- 461db54 [FEATURE] Make pagination configurable (#34)
- 931a16e [FEATURE] Add batch processing for comments
- 078d430 [FEATURE] Added possibility to show related posts
- af5d8be [FEATURE] Add data to view
- d352d82 [FEATURE] Add possibility to generate overview of post based on a category set in backend
- 002e432 [FEATURE] Documentation update
- 2536c59 [FEATURE] Documentation update and php_cs dist from master
- 1e29b73 [FEATURE] Set a details page per specific author. If no details page is set it reverts to the default behaviour.
- 8e0ca35 [FEATURE] Add current category to widget view
- d5804a3 [FEATURE] Add posts to category model
- 9945e18 [FEATURE] Realurl configuration for RSS feed url(s)
- 50751c5 [!!!][FEATURE] AvatarProvider selectable on author record level
- 12b874f [FEATURE] Comments form: use html5 input types for email and url fields
- 1f1edbd [FEATURE] Add support for disqus.com
- 47d501f [FEATURE] Add notification system
- 765b3d2 [FEATURE] Auto approve comments after first approval
- ca2cfe7 [FEATURE] Introduce publish date and migrate crdate
- d7f4ff4 [FEATURE] Add and replace relations
- 4b99e68 [WIP][FEATURE] Social Image Wizard
- a0e5e68 [FEATURE] Add setting for blogSetup to comments sidebar widget

## TASK

- 8048d74 [TASK] Add publishing TER workflow
- 5fb0adb [TASK] Use standalone php-cs-fixer for ci
- 61db6df [TASK][COMMUN-39] Update Documentation (#178)
- 6523f35 [TASK] Bump ini from 1.3.5 to 1.3.7 (#175)
- 54d701d [TASK] Update CI Setup (#171)
- 516976c [!!!][TASK] Decouple archive from sidebar widget
- 2152304 [TASK] Add pages migration for featured_image
- aacef52 [TASK] Raise dependencies
- 01533a8 [TASK] Update frontend packages
- 2384465 [TASK] Test Coveralls (#163)
- 1d906d3 [TASK] Update dev dependencies
- a3061fe [TASK] Update dependencies
- 6375c02 [TASK] Limit builds to ^9.5 and ^10.4
- b2722ad [TASK] Allow typo3/testing-framework ^6.2
- 35b2c50 [TASK] Add roles for main content area
- d268ed0 [!!!][TASK] Drop all exclude fields
- 9c8962d [TASK] Include typo3/cms-beuser as dev dependency
- 78192a9 [TASK] Update build dependencies
- 9e240bb [TASK] Make module positioning compatible with TYPO3 10.4.x
- 36416bd [TASK] Improve ci workflow (#132)
- 634986e [TASK] Move extension icon to Resources/Public/Icons
- 271f90e [TASK] Update ddev to 1.13.1
- 569c2ff [TASK] Improve backend modules
- d17e2a4 [TASK] Update dependencies
- 63b87ad [TASK] Extend setup dataset
- 49eb77b [TASK] Update frontend stack
- ff20605 [TASK] Add setup as dev dependency
- 11736e4 [TASK] Adjust requirements
- c7945bb [TASK] Remove obsolete _make settings for documentation
- e904aa5 [TASK] Update ddev to 1.12.1
- 65991fa [TASK] Remove tempfs to avoid problems on linux runners
- c4f5e61 [TASK] Fix link in README.md
- aefa047 [TASK] Add link to documentation in README.md
- 2d2dc30 [!!!][TASK] Drop social image wizard and prefer ext:seo (#121)
- d53312a [TASK] Add translations for authors (#118)
- 29541dd [TASK] Move to GitHub Actions instead of Travis (#117)
- b4e4ac4 [TASK] Cleanup pages tca
- 192c6e7 [TASK] Compile backend amd modules with webpack
- 4c07790 [TASK] Update all icons
- fd16da9 [TASK] Split blog backend modules
- 8a34e35 [!!!][TASK] Drop social share options
- 06ed9f2 [TASK] Move frontend css sources
- 7cd241b [!!!][TASK] Drop obsolete MetaService
- 780f018 [!!!][TASK] Add configuration error note for single view plugins (#94)
- 48d408d [TASK] Add related posts to test setup
- ce1607a [TASK] Add language menu to test setup
- 8238f74 [TASK] Update dev dependencies
- 5242101 [TASK] Update ddev to 1.10.1
- 3bfffdd [TASK] Set extension key in composer.json
- 6d9bc40 [TASK] Move development app dir into .build folder
- 236b692 [TASK] Move cache to tmpfs for dev environment
- 09e8f18 [TASK] Raise v10 dependency to allow dev-master
- e1efb6d [TASK] Add seo extension as dev requirement
- 65affe6 [!!!][TASK] Modernize list renderings
- a330d19 [TASK] Update ddev to 1.9.1
- 6fb4621 [TASK] Update build dependencies
- f52b38a [TASK] Improve development template
- 8af468e [TASK] Sort language files
- 8a4a954 [TASK] Add typo3/cms-belog as development dependency
- 407a2af [!!!][TASK] Use TYPO3 Form Framework for comment form (#78)
- 6d5d630 [TASK] Add typo3/cms-rte-ckeditor as development requirement
- de0f9d2 [!!!][TASK] Modernize pagination rendering
- 97cab12 [TASK] Streamline language files
- eb85165 [!!!][TASK] Modernize widget content rendering
- f0507bd [!!!][TASK] Do not scale tags size by default
- 8db7276 [!!!][TASK] Modernize widget rendering
- 5cab2ab [TASK] Wrap post authors
- a0b7d31 [!!!][TASK] Modernize post comment rendering
- a17891e [!!!][TASK] Modernize post author rendering
- 65cf485 [TASK] Move typoscript css to file
- 3b1fad6 [!!!][TASK] Adapt section names to follow recommendations
- 61c3203 [TASK] Streamline pagination html template
- 85bc399 [TASK] Streamline html templates and register global blog viewhelpers
- 946f8c1 [!!!][TASK] Always include social image wizard tsconfig
- 75c75a5 [TASK] Make 10.0.x compatible with TYPO3 9.5.x
- 70f4470 [!!!][TASK] Remove Google Plus after its shutdown (#68)
- dfc4767 [TASK] Replace config.persistence.classes typoscript configuration (#71)
- ca13a91 [TASK] Set default indent style to spaces
- 3a23ac0 [TASK] Add tstemplate as dev dependencies
- 5b9c567 [TASK] Add lowlevel and filelist as dev dependencies
- 7fac00a [!!!][TASK] Remove obsolete sidebar headline (#66)
- 410b4ed [TASK] Display requirements in readme as table
- 9c76127 [TASK] Update ddev to 1.7.1
- 52f6e2f [TASK] Remove .travis.yaml from archive
- 5ccb9d4 [TASK] Remove .travis.yaml from archive
- 3f6cc42 [TASK] Add fontawesome to development setup
- 2476717 [TASK] We just pretend we're unbreakable
- ad6b9ff [TASK] Enable xdebug for ddev and add vscode debug config
- c29b179 [TASK] Set development environment
- 3d066d1 [TASK] Update ddev to 1.6.0
- 5474602 [TASK] Add config to ignored folders
- d183441 [TASK] Add extension-helper as dev dependency to generate releases
- 2697526 [TASK] Improve readme (#22)
- 14c748e [TASK] Add GitHub issue templates
- 50e0f15 [TASK] Update documentation for github
- 09ab08a [TASK] Setup travis
- 09f712b [TASK] Adjust and improve documentation Resolves: EXTBLOG-151 Releases: master, 9.1, 9.0
- 49c8d1b [TASK] Add test package
- 789836d [TASK] Add ddev testing instance
- b64390f [TASK] Remove useless comment blocks
- b99510d [TASK] Avoid endless waiting for database connection
- d2b6a4c [TASK] Add more constants Resolves: EXTBLOG-141 Releases: master, 9.0
- eee5e2d [TASK] Add nl2br VH for comments text Resolves: EXTBLOG-132 Releases: master
- a3c915e [TASK] Move Updates to Classes/Updates Resolves: EXTBLOG-143 Releases: master
- 87040de [TASK] Move test builds into dedicated folder Resolves: EXTBLOG-136 Releases: master, 9.0, 8.7
- c95d417 [TASK] Change git clone url in documentation
- 2359116 [TASK] Prepare v9 release
- b8bdd89 [TASK] Code cleanups and v9 change
- 563a10e [TASK] Raise core version constraints
- 072ff89 [TASK] Add phpunit coverage paths to bamboo
- e176e2f [TASK] Change PHP CS Fixer config
- 1ace08b [TASK] Update  README.md
- adf5516 [TASK] Update README.md
- 637cf79 [TASK] Added documentation for list by category
- 4e7ef81 [TASK] Fix bamboo setup
- 193aabd [TASK] bamboo setup
- 2bc412e [TASK] Fix CGL issues
- d109449 [TASK] Refactor Unit Tests
- 6353a74 [TASK] Add .gitattributes file to repository
- 1860680 [TASK] Add all composer depencies
- 1672e62 [TASK] Update to 9.3.*@dev
- 95ddef0 [TASK] Update to 9.3.x-dev
- 229ab42 [TASK] Update to 9.3.x-dev
- f06781a [TASK] Change version constraint for master
- 3d95406 [TASK] Add sorting for tags in backend
- 647458a [TASK] Add build status badge
- a4db8a9 [TASK] Require typo3/cms-install
- 24223f7 [TASK] Add README.md file
- 2de7fec [TASK] Refactor ViewHelpers to be compatible with latest master
- 427a644 [TASK] Remove old ArrayUtility class
- 79843cd [TASK] Add links to composer.json
- faeebd8 [TASK] Optimize icons
- 8e17304 [TASK] Add MetaServiceTest
- fca2a1a [TASK] Optimize auto setup
- bbffb36 [TASK] Move first blog post into data folder
- e791784 [TASK] Remove pages_language_overlay configuration
- 9c0a85b [TASK] Add @lazy attribute to posts property for authors
- cf1c641 [TASK] Add rst file
- 95c4a29 [TASK] Define a default filter and skin set
- 1526c85 [TASK] Configure the data sources by PageTS
- 50952db [TASK] Fix version contraint
- 64ca4d3 [TASK] Load json configs from data attribute
- 174e9f8 [TASK] Move skin into JSON config file
- 6fbbb13 [TASK] Move filter into JSON config file
- 796aba3 [TASK] Fix event registration and some cleanups
- 0d3d4b4 [TASK] Fix step panels
- 34cc688 [TASK] Fix layout of table
- d76c606 [TASK] Use FormDataCompiler to get information from TCA
- 13ef97a [TASK] Refactor the step handling
- 089b316 [TASK] Fix layout and markup
- 1c6e783 [TASK] ADJUSTED POSITIONING OF ELEMENTS
- 6844194 [TASK] Refactroing of canvas code
- da03a75 [TASK] Add step 2/3 and cleanup the code
- deb9e6a [TASK] Adjusted layout and added adjustment sliders
- 65e3a9b [TASK] Get fields from TCA
- ff611e8 [TASK] Fix Layouts of Images
- 98d754e [TASK] Add save logic
- 52cddb2 [TASK] Add Fabric Tooling
- eb5baad [TASK] Make canvas responsive
- 504a0dc [TASK] add markup in controller and open model in full width
- 8a1819d [TASK] Add RequireJsModule
- 6deba1e [TASK] Change version number
- dbe1018 [TASK] Prepare release 8.7.0
- d399f99 [TASK] Prepare release 8.7.0
- efd769d [!!!][TASK] Remove usage of $GLOBALS[TYPO3_DB]
- 77724ec [TASK] Use GeneralUtility::getIndpEnv('REMOTE_ADDR')
- d14e6bb [TASK] Prepare UnitTests.xml
- 6d86fa2 [TASK] Raise core version requirements
- 6c9d413 [TASK] Use non namespaced test classes for compabitility
- 20b25a0 [TASK] Extract find comment functionality in new function
- eb6b8bb [TASK] Implement subtitle field in post model
- d8cb2bb [TASK] Adjust the rst file
- 2d7df6e [TASK] Enabled recursive and pages field for all post plugins
- 93712d9 [TASK] Don't set the defaultConstraints for the storage PID in the initialize because this is only executed the first time. Also setting the storagePid as a defaultConstraint is causing issues.
- 0007d12 [TASK] Use empty check insteaf of count
- aeeddc3 [TASK] Only check rootline when no storagePids are set through TypoScript or plugin-settings
- 061fea3 [TASK] Removed unused property
- d20044e [TASK] Add possibility to select storage pid for overview of blog posts
- 5718dca [TASK] Added changelog for feature 35
- 106437e [TASK] Removed unused property
- e4df4de [TASK] Add possibility to select storage pid for overview of blog posts
- 2a2c692 [TASK] Prepare next development version

## BUGFIX

- 48e9e81 [BUGFIX] Bundle PSR-Packages for non Composer mode (#181)
- d1d42da [BUGFIX] Enforce ArchiveViewHelper to return a string (#180)
- f9d3c1a [BUGFIX] Cast pageUid in RedirectFinisher to string (#173)
- 5cd5a40 [BUGFIX] Never forget to check again after you have done your "optimizations"
- 65af1b7 [BUGFIX] Correct position of content on tag view
- 97513a6 [BUGFIX] Use author detail links for profile
- 5f496c9 [!!!][BUGFIX] Ensure fallback to default templates is always set
- d79d63d [BUGFIX] Use noreply as default email address (#159)
- 9b635b4 [BUGFIX] Correct route configuration for archive links (#151)
- 5a83f5c [BUGFIX] respect pages.l18n_cfg in all cases
- 9cc737a [BUGFIX] Ensure setup is creating categories of type blog
- 1a3d936 [BUGFIX] Only extend site site configuration hook if it exists.
- a6d2520 [BUGFIX] Ensure boolean is returned after sending
- f931f5d [BUGFIX] Make mailer compatible with 10.4 (#141)
- 418e497 [BUGFIX] Use different icon for blog pages defined as root
- 8befd62 [!!!][BUGFIX] Limit tags to configured storage pid
- 6caf365 [!!!][BUGFIX] Limit authors to default language
- b2b058f [!!!][BUGFIX] Respect PageTsConfig limitation for authors
- 08d3aa4 [BUGFIX] Do not render fluid namespace helper in rss feed
- 48f83e9 [BUGFIX] Ensure standalone title is linking to the correct root page
- c7a5809 [BUGFIX] Ensure setup creates site configuration
- 31ef29d [BUGFIX] Show hidden posts in backend module
- 90a6bfc [BUGFIX] Do not use relative paths for css includes
- 530b522 [BUGFIX] Remove discus includes on non single post related templates
- 45e8720 [BUGFIX] Correct constraint for fetching posts by year
- a7eab9a [BUGFIX] Add typecasts for page types
- be20e4d [BUGFIX] Remove obsolete language fields for blog comments
- 4260ba2 [BUGFIX] Fix a small typo (#124)
- 346e0d7 [BUGFIX] Enable language synchonization for featured image
- e7e5a4d [BUGFIX] Use actions badge instead of removed travis
- 5f82cbe [BUGFIX] Use correct constants for feature image
- b5e5e81 [BUGFIX] Correct cgl
- 302bc13 [BUGFIX] Use MetaTag API (#89)
- e463e74 [BUGFIX] Limit author posts to blog posts and default language  (#69)
- e52368b [BUGFIX] Make CategoryViewHelper compatible with v10
- 995f942 [BUGFIX] Make TagViewHelper compatible with v10
- d260966 [BUGFIX] Make PostViewHelper compatible to v10
- 62169de [BUGFIX] Remove obsolete fields and enable cropping for author images
- bfba7a7 [BUGFIX] Remove display condition for slug fields of custom records (#43)
- 404dc89 [BUGFIX] Correct development template
- 36b4f45 [BUGFIX] Set default doktype for post model (#83)
- 4abea18 [BUGFIX] Make testing setup compatible with latest testing framework versions
- 933d046 [BUGFIX] Use settings.lists in documentation
- 0546781 [BUGFIX] Use LocalizationUtility instead of LanguageService
- 6b3f3e8 [BUGFIX] Use correct identifier for publish date update
- ca4753b [BUGFIX] Only execute publish date update when fields exist
- 430e165 [BUGFIX] Use correct identifier for month and year update
- 42c3318 [BUGFIX] Only execute month and year update when fields exist
- e057225 [BUGFIX] Check if tag does exist before accessing properties
- 1391d14 [BUGFIX] Check if category does exist before accessing properties
- d90101f [BUGFIX] Check if author does exist before accessing properties
- cd1c276 [BUGFIX] Do not include google captcha when disabled in settings
- 41669b9 [BUGFIX] Respect translation settings in archive widget (#77)
- 420b435 [BUGFIX] Use correct column type for comment sorting by date in backend
- 72ef1e2 [BUGFIX] Use correct column type for post sorting by date in backend
- 49a0085 [BUGFIX] Use publishDate for date sorting in backend module
- c8bda4e [BUGFIX] Ensure tag link viewhelper always returns a string
- 298f193 [BUGFIX] Add missing comment id attribute for section links
- d427276 [BUGFIX] Disallow multiple assignments of authors to a post (#70)
- f695236 [BUGFIX] Respect configured size in Avatar ImageProvider (#74)
- cfbacfa [BUGFIX] Add severity classes to flash messages (#76)
- e673790 [BUGFIX] Correct travis cgl fixer config
- f27c98e [BUGFIX] Correct cgl and remove obsolete php_versions file
- abdf3b5 [BUGFIX] Add crdate field configuration for extbase
- 1b4303d [BUGFIX] Use today as publishing date for new blog entries (#59)
- 31f63fc [BUGFIX] Add plugins to new content element wizard (#61)
- d1658ef [BUGFIX] Remove storage constraint from finding current post (#63)
- c93b65f [BUGFIX] Only add storage constraint if pages could be resolved (#65)
- 654abdc [BUGFIX] Avoid exception when accessing uninitialized settings (#50)
- 5c38906 [BUGFIX] Set format for comments rss feed (#56)
- 7a7145b [BUGFIX] Correct fluid namespace definitions - fixes #51 (#52)
- ab732a0 [BUGFIX] Allow language synchronization (#48)
- d3767ea [BUGFIX] Fix language sensitivity of getCurrentPost (#47)
- 552556c [BUGFIX] Fix column width for comment actions column
- 2fe9b8c [BUGFIX] Resolve endless loop when calling archive without params (#35)
- f248dca [BUGFIX] Set addQueryStringMethod again to avoid faulty strict mode
- d5821e1 [BUGFIX] Generate correct link to blog rss channel
- 726a3c4 [BUGFIX] Make route-enhancer configuration work (#29)
- ec79f88 [BUGFIX] Introduce path-segments for tags, author and category - fixes #31 (#32)
- 4da3299 [BUGFIX] Remove outdated realurl information and use route enhancer (#30)
- cd4c7e4 [BUGFIX] LinkViewHelper must set correct controller context (#28)
- 28c77ac [BUGFIX] Add extension name to uriFor in all ViewHelpers (#6)
- 09b617f [BUGFIX] Fix #24: TypyError exception when calling PostRepository::findRelatedPosts() (#25)
- 72c2bc7 [BUGFIX] Exclude .github folder from export
- a155ef9 [BUGFIX] Remove limitToPages setting from default routes config
- c77a935 [BUGFIX] Let the SocialImageWizard working again Resolves: EXTBLOG-154 Releases: master, 9.1, 9.0
- 239255e [BUGFIX] Correct composer dependencies
- 5c4afc3 [BUGFIX] Ensure type safety for ViewHelper calling ImageService The ImageService::getImage requires a string as first and a boolean as third parameter. The Image ViewHelpers must respect this requirement. related to https://review.typo3.org/59608
- 983c870 [BUGFIX] Respect l18n_cfg setting in PostRespository
- 3205c87 [BUGFIX] Improve performance Resolves: EXTBLOG-142 Releases: master
- c4174ea [BUGFIX] Remove extension installer Resolves: EXTBLOG-133, EXTBLOG-144 Releases: master, 9.0
- 3ab687f [BUGFIX] Make entries in filter unique Resolves: EXTBLOG-146 Releases: master, 9.0, 8.7
- 8751143 [BUGFIX] Avoid unnessesary post casting to object in comment form
- c139485 [BUGFIX] TE-109: show only default language tags in BE forms Resolves: EXTBLOG-146, TE-109 Releases: master, 9.0, 8.7
- ce947b6 [BUGFIX] Cleanup TCA
- 35031da [BUGFIX] Make plugins cached and use lazy loading for relations
- 82f6f9a [BUGFIX] Use .typoscript fileending for typoscript files Resolves: EXTBLOG-140 Releases: master
- a8e8779 [BUGFIX] Fix broken annotation
- db2a4e0 [BUGFIX] Remove build folder for each PHP version
- 242ec5e [BUGFIX] Fix wrong code-block syntax
- 15eb22e [BUGFIX] Remove composer.lock from repository Resolves: EXTBLOG-137 Releases: master, 9.0, 8.7
- 4363f5c [BUGFIX] Add editor config to ensure streamlined indentions Resolves: EXTBLOG-135 Releases: master, 9.0, 8.7
- 0d77934 [BUGFIX] Adjust gitattributes file Resolves: EXTBLOG-134 Releases: master, 9.0, 8.7
- 69aa0e4 [BUGFIX] Make a category posts lazy Releases: master, 9.0
- 0f51f97 [BUGFIX] Cast timestamp to int Releases: master, 9.0, 8.7
- acd3f53 [BUGFIX] Change category icon size Reöeases: master
- 7987c84 [BUGFIX] Cast return type of CategoryViewHelper
- e8c5fef [BUGFIX] Remove cache tagging for archive widget, which make no sense
- 1499ad9 [BUGFIX] Prevent bypassing re-captcha check
- 2b6b413 [BUGFIX] Use repository instead of model to retrieve posts by category
- 1faba4b [BUGFIX] fix only extension classes
- f17bdc4 [BUGFIX] Fix log file name
- 78ae97a [BUGFIX] Tag and clear cache for all relevant changes
- 3a0d585 [BUGFIX] Add missing storage pid condition
- cfa6cae [BUGFIX] Fix wrong condition for comment status
- 4d0edc4 [BUGFIX] Exception in sidebar plugin without tags
- f58a9d6 [BUGFIX] Fix wrong markup for pagination
- 4dd1ba1 [BUGFIX] Add missing label
- 425b65e [BUGFIX] Fix wording of category label
- 2ff5eb4 [BUGFIX] Add missing label for SEO tab
- cbb99af [BUGFIX] Fix wrong size of icons in PageTree
- 61a9aa9 [BUGFIX] Override category config only for blog pages
- ce58275 [BUGFIX] Fix broken unit tests
- 41d35f8 [BUGFIX] Call parent::initializeArguments(); for all ViewHelpers
- b51a09b [BUGFIX] Remove old ArrayUtility class
- 48dec0e [BUGFIX] Change license in composer.json
- 60e8698 [BUGFIX] SetupWizard breaks composer based installations
- 9cdf96d [BUGFIX] Fix SetupSerice, remove restricition container
- c65a604 [BUGFIX] Install EXT:rx_shariff with EXT:blog_template
- b9a8e99 [BUGFIX] Fix typo in description
- d82a8ba [BUGFIX] Fix broken SQL statement for comments
- 3479cf6 [BUGFIX] Fix SQL typo and statement for TagRepository
- 5d74a29 [BUGFIX] Add an additional check before validating re-captcha
- af51794 [BUGFIX] Streamline settings
- aaae16c [BUGFIX] Respect sys_language in comment count
- 11aab5a [BUGFIX] Fix metadata plugin rendering
- 803e2bb [BUGFIX]  Respect language in comments widget
- fe0558f [BUGFIX] Force pid of comments to post uid
- 8a89856 [BUGFIX] Fixed small bug causing error in backendmodule when selecting one blogSetup

## MISC

- 8952cc1 Add documentation regarding the configuration of storage PIDs (#103)
- 0b50517 Update Crowdin configuration file
- 5521b42 [CLEANUP] Remove never used add comment tempalte
- ba739c6 EXTBLOG-60 - Update Recent comments widget
- 630a5aa Fix typo orderBy
- 14e62bc Add the missing orderBy clause.
- c632418 Fix SQL typo and statement for TagRepository
- f491f8e Update Documentation/Changelog/master/Important-88-Remove-GLOBALS-TYPO3_DB.rst
- a2f46b8 Author string translated
- 209dfdc Translation of Widgets
- b1cf339 Category widget template translated
- f903717 [TAKS] Change version contraint of core
- 878a3d0 EXTBLOG-60 - Update Recent comments widget
- cf81777 [BUGIFX] Respect sys_language in comment count

## Contributors

- Alexander Schnitzler
- Andreas Fernandez
- Andreas Fernandez
- Andreas Sommer
- Anja Leichsenring
- Anja Leichsenring
- Benjamin Kott
- Benjamin Kott
- Benjamin Kott
- David Steeb
- David Steeb
- Dmitry Dulepov
- Frank Naegler
- Frank Nägler
- Frank Nägler
- Georg Ringer
- Gregor Favre
- Haythem Labbassi
- Henrik Elsner
- Luca Kredel
- MK-42
- Mathias Brodala
- Mathias Schreiber
- Physikbuddha
- Richard Haeser
- Son-Tung Ngo
- Susanne Moog
- Susanne Moog
- Susi
- TYPO3Inc
- Tim Spiekerkötter
- braun_wo
- dependabot[bot]
- jboesche
- rickvanriel

# 1.3.0

## FEATURE

- 9b43823 [FEATURE] Reload page tree after setup is done

## TASK

- c2f21b1 [TASK] Prepare release 1.3.0
- e053ddf [TASK] Provide dedicated UnitTests.xml for TYPO3 versions
- 5656629 [TASK] Raise version contraint for TYPO3 v8 LTS
- f4ca4a7 [TASK] Add option for default gravatar image
- 3afaecd [TASK] Some small cleanups
- 948b014 [TASK] call initializeObject in contructor
- c3027ea [TASK] Adjust composer requirements
- da35fae [TASK] Remove composer.lock
- daf7a20 [TASK] Set new dev version
- 2f2ed81 [TASK] Remove composer.lock
- cf4d477 [TASK] Set new dev version

## BUGFIX

- c7d95ad [BUGFIX] Fix rst file
- 5c8abf3 [BUGFIX] Prevent exception if post is not available
- 14ae5fd [BUGFIX] Remove renderType which not avaible in 7.6
- dc95276 [BUGFIX] Split up backend modules
- eb96a1b [BUGFIX] Fix broken contraint building
- 7676a03 [BUGFIX] Show only active comments in widget
- 1fb5246 [BUGFIX] Satisfy phpunit v.4

## MISC

- 5d8ab8b Translation added
- bdbd19f EXTBLOG-79, Check if post is avaliable added
- a0b4f60 Label added
- 4e4486c EXTBLOG-78, Post title issue fixed
- ff4b60f UnitTests.xml edited online with Bitbucket
- 9ea5944 Provide adjusted path to UnitTestBootstrap
- bb5dfdf EXTBLOG-77, Anpassung RealUrlAuto-Config-Hook, Reset der vorherigen Änderungen
- 5a0f04b Render links on translated tags with localized uids
- b538913 Documentation update for default value
- 27df337 EXTBLOG-68, Limit setting for number of posts in the recent posts widget
- 9bbace0 Update composer.json

## Contributors

- Anja Leichsenring
- Anja Leichsenring
- Frank Naegler
- braun_wo

# 1.2.0

## FEATURE

- 36890b7 [FEATURE] Introduce `maximumItems` setting in recent posts list plug-in
- d7a670a [FEATURE] Add author relations
- 951153b [FEATURE] Add blog filter to posts view
- 64585ec [FEATURE] Add backend module for blog comment management
- 07200d2 [FEATURE] Add custom filter per column
- b2fe7b2 [FEATURE] Add backend module for blog post management
- 44140cf [FEATURE] Preprocess URL field in comment action
- 711fd31 [FEATURE] Add spam protection (honeypot) to comment form

## TASK

- 76f6593 [TASK] Update version number for release 1.2.0
- 9cb6911 [TASK] Prepare documentation for release 1.2.0
- 7635e4e [TASK] Update homepage URL
- 23aee4a [TASK] Update description in composer.json
- 3bbdaa9 [TASK] Update version number for release 1.2.0
- 4b5c7df [TASK] Prepare documentation for release 1.2.0
- 88fbf82 [TASK] Remove ViewHelper
- fbe0a14 [TASK] Adjust status check
- d93eae0 [TASK] Add method to get only active comments
- 1186ebc [TASK] Add method to get only active comments
- 9e6e6d6 [TASK] Optimize RSS feed and fix date format
- dc6315f [TASK] Raise core version constraint
- f7f859c [TASK] Set default value of setting `lists.posts.maximumDisplayedItems` to 0
- 649740c [TASK] Add `lists.posts.maximumDisplayedItems` TypoScript setting
- 9519dc5 [TASK] Fix phpunit requirement to 5.7.5
- 799f2f1 [TASK] Change author in ext_emconf
- 7309628 [TASK] Change title of category, tag and author pages
- 3a4fa77 [TASK] Change version name and core dependency
- a25c9c6 [TASK] Add required fields marker to the template
- c951e3d [TASK] Add status for comments
- a3f2872 [TASK] Add database and TCA defintion for author
- cdf6ff4 [TASK] Optimize init process
- 056b5e5 [TASK] Add rst file for this feature
- 92027af [TASK] Optimize init process
- b0ff849 [TASK] Add rst file for this feature
- 58b667a [TASK] Fixes for 7.6
- 10630a2 [TASK] Refactor backend module
- 4533b7e [TASK] Raise typo3 requirement to 8.5
- 18e6a95 [TASK] Remove call to deprecated function extRelPath()
- c4abccd [TASK] Improve the documentation for setup without wizard
- 32ab58b [TASK] Replace TYPO3_MODE check
- af09178 [TASK] Add author field to the model
- b6c67c0 [TASK] Remove unsued and invalid TypoeScript setting

## BUGFIX

- 41567f9 [BUGFIX] Use initializeObject insteaf of __construct method to prevent caching issues
- 6ce3bde [BUGFIX] Add extension information to provide exception
- 3b9cf1f [BUGFIX] Adjust bootstrap file in PhpUnit config files
- 936a75f [BUGFIX] Remove duplicate method
- b454184 [BUGFIX] Update phpunit version and composer.lock file
- 2922741 [BUGFIX] Use namespaced TestCase file
- 68187a3 [BUGFIX] Add default implementation in Extbase container for avatar provider
- 2bcc6c8 [BUGFIX] Using the ObjectManager to resolve the configuration
- 886c16e [BUGFIX] remove unknown attribute data
- cfdd013 [BUGFIX] Change typenum for author feeds
- b403a1b [BUGFIX] Change typenum for author feeds
- 8db0944 [BUGFIX] Fix typo in realurl config
- ad15b79 [BUGFIX] Fix wrong parameter
- cfdb7c1 [BUGFIX] Fix syntax errors in template
- 1579c40 [BUGFIX] Use PROPER CSS linking syntax
- 649297e [BUGFIX] Add missing namespace
- 5ff6d18 [BUGFIX] Fix broken icon in localisation view
- 1c9aff4 [BUGFIX] Fix broken icon in selectfield of pagetype
- aa48e82 [BUGFIX] Correct constants of storagePid
- 2291f2a [BUGFIX] Set correct constants path
- ad2dcbe [BUGFIX] Setup Wizard does not replace UIDs in contstants
- f2149f0 [BUGFIX] Respect -1 (all languages) if comments.respectPostLanguageId = 1
- 2c0af39 [BUGFIX] Use cHash for category, tags and archive
- 2e22fed [BUGFIX] Allow itemprop property
- 9c0ddc0 [BUGFIX] Change URL of gravatar to HTTPS
- 44bd015 [BUGFIX] Define templateRootPath on level 0

## MISC

- 3da66a4 Fix duplicate method getActiveComments
- ebcb79e Removal of unused code
- 5831b59 EXTBLOG-61 - Update comments views and counts when comments.moderation is on
- 4cf8a43 EXTBLOG-67, Only get tags that are not hidden or deleted.
- 0340f94 Add TCA migrations
- 7b091d3 Apply TCA migrations
- 51b0312 Apply TCA migrations
- 6d23267 [DOC] Add changelog entry for EXTBLOG-62
- c652a48 [DOC] Add documentation for setting `list.posts.maximumDisplayedItems`
- 5a7546f [CLEANUP] Use `int` cast instead of `intval`
- 075f5f0 [REMOVAL] Remove FlexForm for `PostController`
- d246ac1 Removal of unused code
- f26eefa EXTBLOG-61 - Update comments views and counts when comments.moderation is on
- 9b403ee Update Classes/Controller/BackendController.php
- b2ca40f [HOTFIX] Add honeypot field to database
- 09ad7d3 Update Classes/Controller/BackendController.php

## Contributors

- Anja Leichsenring
- Anja Leichsenring
- Boris Schauer
- Frank Naegler
- Frank Nägler
- Jan Helke
- Mathias Schreiber
- Nathan Boiron
- Romain Canon
- braun_wo

# 1.1.0

## TASK

- 4d9ae77 [TASK] Prepare release 1.1.0
- 267e30e [TASK] Raise core dependency

## Contributors

- Frank Naegler

# 1.0.0

## FEATURE

- fb2b39a [FEATURE] Translate comments
- dfc78e5 [FEATURE] Make tags translatable
- b418148 [FEATURE] Change creation date of post in backend
- c479702 [FEATURE] RSS-Feeds
- cf2904f [FEATURE] Convenience: Tag/Category/Date list without arguments
- 4ad3972 [FEATURE] Archive Posts
- 3316df3 [FEATURE] Add pagination to default template
- 47ba426 [FEATURE] Setup Wizard
- aa4f86a [FEATURE] Provide empty output
- fa022ec [FEATURE] add media Image
- 1eafe00 [FEATURE] Add tags
- 1c2cf32 [FEATURE] Add ViewHelper to link inside blog context
- caecb4b [FEATURE] Add SEO: Metadata
- 8191eae [FEATURE] Shariff Sharer
- 30bb1b2 [FEATURE] Add archive widget
- ec5e93c [FEATURE] Add comments widget
- 56a7e91 [FEATURE] Create comment form
- ee84cb9 [FEATURE] Add comments settings
- ebfad1e [FEATURE] Add category widget
- ae635d0 [FEATURE] Add SVG icons
- 807944e [FEATURE] Add metadata plugin
- 60e5dc4 [FEATURE] Define tag model
- 501e6f2 [FEATURE] Template structure
- d62bf6a [FEATURE] Define comment model
- 50a5478 [FEATURE] Add basic unit tests
- 8f91dcb [FEATURE] Add basic unit tests
- 702289c [FEATURE] Define category model
- 0de74b7 [FEATURE] Define tag model
- 6f13dff [FEATURE] Basic Setup & TCA defintion

## TASK

- c77b208 [TASK] Change composer name and version
- da26d35 [TASK] Add documentation about realurl
- 9a6cae3 [TASK] Change link to service desk
- 61bb5f8 [TASK] Add TYPO3_MODE check to all global scope files
- 42ec52e [TASK] Code cleanups
- c62e361 [TASK] Cleanup ext_localconf.php and ext_tables.php
- fe58454 [TASK] Cleanup BackendController
- bb370d8 [TASK] Add more documentation
- 6d02668 [TASK] Make settings configurable with constant editor.
- fe71500 [TASK] Make settings configurable with constant editor.
- c147287 [TASK] Add documentation
- b8e3617 [TASK] Remove tt_content fields not needed for plugins
- d7ff0c2 [TASK] Refactor patch
- d7fdce1 [TASK] Cleanup templates
- 5e14ebb [TASK] Change comments handling for commentsAction
- c011155 [TASK] Fix typos
- b63f8d5 [TASK] Fix CGL issues
- 58770fd [TASK] Remove unused PersistenceManager
- 840dde0 [TASK] Fix broken CSS class
- 9711e48 [TASK] Optimize tests
- fb62109 [TASK] change franks test and controller foo ;)
- 2a4b219 [TASK] Restructure tempplates
- 2512686 [TASK] Add composer.json file
- e484dd9 [TASK] Add OSX stuff to gitignore
- 3976dc0 [TASK] Add composer.json file
- 6a39619 [TASK] Add OSX stuff to gitignore
- 4c1dd4e [TASK] Change typo3 version constraints
- 77c0b9c Revert "[TASK] Enforce strict types"
- cb6a97d [TASK] Enforce strict types
- 8faabb3 [TASK] Add comment for testing

## BUGFIX

- dd9e53f [BUGFIX] Add missing comma in ext_tables.sql
- 72fb886 [BUGFIX] Fox broken comment view
- 6aa960e [BUGFIX] Don’t cache flash message
- 9233c2b [BUGFIX] Use LocalizationUtility instead of LanguageService
- f73adc2 [BUGFIX] Ensure $GLOBALS[’LANG’] ist set
- 5189ef1 [BUGFIX] Add renderType to select
- e222758 [BUGFIX] set fallback if TSFE not set
- 76042a4 [BUGFIX] get PageId from TSFE

## MISC

- 2bb86b6 Correct more typos
- 67847bc Correct typo
- 3d34529 Cleanup Post Model
- 2d97a2b [EXTBLOG-1] Trigger Setup

## Contributors

- Anja Leichsenring
- Frank Naegler
- Jan Helke
- Mark Houben
- Susanne Moog

