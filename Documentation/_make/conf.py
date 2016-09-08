# -*- coding: utf-8 -*-

# mb, 2015-10-01, 2016-09-04

# This file lives at https://github.com/marble/typo3-docs-typo3-org-resources/blob/master/userroot/scripts/bin/conf-2015-10.py
# Check for a new version!

# 2016-09-04 update extlinks Forge and Review
# 2016-05-27 turn off smartypants

# Generic conf.py for ALL projects.
# Project specific settings should be in:
# - Documentation/Settings.cfg (maintained by user)
# - MAKEDIR/Defaults.sh        (maintained by admin)
# - MAKEDIR/buildsettings.sh   (maintained by admin)
# - MAKEDIR/Overrides.cfg      (maintained by admin)

from cStringIO import StringIO
import codecs
import ConfigParser
import os
import sys
import t3SphinxThemeRtd

# enable highlighting for PHP code not between <?php ... ?> by default
from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer
lexers['php'] = PhpLexer(startinline=True)
lexers['php-annotations'] = PhpLexer(startinline=True)

# a dictionary to take notes while we do this processing
notes = {}

# settings from Overrides.cfg
OVERRIDES = {}


# PART 1: preparations

# the dictionary of variables of this module 'conf.py'
G = globals()

class WithSection:

    def __init__(self, fp, sectionname):
        self.fp = fp
        self.sectionname = sectionname
        self.prepend = True

    def readline(self):
        if self.prepend:
            self.prepend = False
            return '[' + self.sectionname + ']\n'
        else:
            return self.fp.readline()

# get from 'buildsettings.sh'

# ConfigParser needs a section. Let's invent one.
section = 'build'
config = ConfigParser.RawConfigParser()
f1name = 'buildsettings.sh'
with codecs.open(f1name, 'r', 'utf-8') as f1:
    config.readfp(WithSection(f1, section))

# Required:
MASTERDOC = config.get(section, 'MASTERDOC')
BUILDDIR = config.get(section, 'BUILDDIR')
LOGDIR = config.get(section, 'LOGDIR')

# find absolute path to conf.py(c)
confpyabspath = None
try:
    confpyabspath = os.path.abspath(__file__)
except:
    import inspect
    confpyabspath = os.path.abspath(inspect.getfile(inspect.currentframe()))

if os.path.isabs(MASTERDOC):
    masterdocabspath = os.path.normpath(MASTERDOC)
else:
    masterdocabspath = os.path.normpath(os.path.join(confpyabspath, '..', MASTERDOC))

if os.path.exists(masterdocabspath + '.rst'):
    pass
elif os.path.exists(masterdocabspath[:-len('README')] + 'Index.rst'):
    MASTERDOC = MASTERDOC[:-len('README')] + 'Index'
    masterdocabspath = masterdocabspath[:-len('README')] + 'Index'

if not os.path.exists(masterdocabspath + '.rst'):
    sys.stdout.write('Can\'t find MASTERDOC ' + masterdocabspath + '.rst\n')
    sys.exit(1)

if os.path.isabs(LOGDIR):
    logdirabspath = LOGDIR
else:
    logdirabspath = os.path.abspath(LOGDIR)
logdirabspath = os.path.normpath(logdirabspath)

# the absolute path to Documentation/
projectabspath = os.path.normpath(os.path.join(masterdocabspath, '..'))

# the absolute path to Documentation/Settings.cfg
settingsabspath = projectabspath + '/' + 'Settings.cfg'
notes['Settings.cfg exists'] = os.path.exists(settingsabspath)

defaultsabspath = os.path.normpath(os.path.join(confpyabspath, '..', 'Defaults.cfg'))
notes['Defaults.cfg exists'] = os.path.exists(defaultsabspath)

overridesabspath = os.path.normpath(os.path.join(confpyabspath, '..', 'Overrides.cfg'))
notes['Overrides.cfg exists'] = os.path.exists(overridesabspath)

if 0:
    # Better stop with exitcode=1 if there is no 'Settings.cfg' file
    if not os.path.exists(settingsabspath):
        sys.stdout.write('Settings.cfg not found\n')
        sys.exit(1)

# user settings
US = {}

# Documentation/Settings.cfg
# read user settings and keep them in normal dictionary US
if notes['Settings.cfg exists']:
    config = ConfigParser.RawConfigParser()
    config.readfp(codecs.open(settingsabspath, 'r', 'utf-8'))
    for s in config.sections():
        US[s] = {}
        for o in config.options(s):
            US[s][o] = config.get(s,o)

# If MAKEDIR/Defaults.cfg exists:
# Get defaults for settings that ARE NOT in Settings.cfg
if notes['Defaults.cfg exists']:
    config = ConfigParser.RawConfigParser()
    config.readfp(codecs.open(defaultsabspath, 'r', 'utf-8'))
    for s in config.sections():
        US[s] = US.get(s, {})
        for o in config.options(s):
            if not US[s].has_key(o):
                US[s][o] = config.get(s,o)

# some more preparations

extensions_to_be_loaded = [
    'sphinx.ext.extlinks',
    'sphinx.ext.ifconfig',
    'sphinx.ext.intersphinx',
    'sphinxcontrib.t3fieldlisttable',
    'sphinxcontrib.t3tablerows',
    'sphinxcontrib.t3targets',
]

# Legal extensions will be loaded if requested in Settings.cfg
legal_extensions = [
    'sphinx.ext.autodoc',
    'sphinx.ext.coverage',
    'sphinx.ext.mathjax',
    'sphinx.ext.todo',
    'sphinxcontrib.googlechart',
    'sphinxcontrib.googlemaps',
    'sphinxcontrib.httpdomain',
    'sphinxcontrib.numfig',
    'sphinxcontrib.slide',
    'sphinxcontrib.youtube',
    # to be extended ...
]

# Extensions to be loaded are legal of course.
# Just let's be clear.
for e in extensions_to_be_loaded:
    if not e in legal_extensions:
        legal_extensions.append(e)


# PART 2: provide defaults

# 'first class' defaults first: not derived from others

project     = u"The Project's Title"
copyright   = u'Since 1990 By The Authors And Copyright Holders'
t3shortname = u't3shortname'
t3author    = u'The Author(s)'
description = u'This is project \'' + project + '\''

version = '0.0'
release = '0.0.0'

html_theme_options = {}
html_theme_options['github_branch']        = ''  # latest'
html_theme_options['github_commit_hash']   = ''  # 'a2e479886bfa7e866dbb5bfd6aad77355f567db0'
html_theme_options['github_repository']    = ''  # 'TYPO3-Documentation/TYPO3CMS-Reference-Typoscript'
html_theme_options['github_revision_msg']  = ''  # '<a href="https://github.com/TYPO3-Documentation/t3SphinxThemeRtd' + '/commit/' +'a2e479886bfa7e866dbb5bfd6aad77355f567db0' + '" target="_blank">' + 'a2e47988' + '</a>'
html_theme_options['github_sphinx_locale'] = ''  # ?
html_theme_options['project_contact']      = ''  # 'mailto:documentation@typo3.org'
html_theme_options['project_discussions']  = ''  # 'http://lists.typo3.org/cgi-bin/mailman/listinfo/typo3-project-documentation'
html_theme_options['project_home']         = ''  # some url
html_theme_options['project_issues']       = ''  # 'https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-Typoscript/issues'
html_theme_options['project_repository']   = ''  # 'https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-Typoscript.git'

if 0 and 'enable this as soon as t3SphinxTheme knows the settings':
    html_theme_options['project_has_settings_cfg' ] = True if notes['Settings.cfg exists' ] else False
    html_theme_options['project_has_defaults_cfg' ] = True if notes['Defaults.cfg exists' ] else False
    html_theme_options['project_has_overrides_cfg'] = True if notes['Overrides.cfg exists'] else False

html_use_opensearch = '' # like: 'https://docs.typo3.org/typo3cms/TyposcriptReference/0.0'  no trailing slash!

highlight_language = 'php'
html_use_smartypants = False
language = None
master_doc = 'Index'
pygments_style = 'sphinx'
source_suffix = ['.rst', '.md']
todo_include_todos = False

# make a copy (!)
extensions = extensions_to_be_loaded[:]

extlinks = {}
extlinks['forge' ] = ('https://forge.typo3.org/issues/%s', 'Forge #')
extlinks['issue' ] = ('https://forge.typo3.org/issues/%s', 'Issue #')
extlinks['review'] = ('https://review.typo3.org/%s', 'Review #')

intersphinx_mapping = {}


# PART 3: apply user settings

def updateModuleGlobals(GLOBALS, US):
    if US.has_key('general'):
        GLOBALS.update(US['general'])

    # allow comma separated values like: .rst,.md
    if type(GLOBALS['source_suffix']) in [type(''), type(u'')]:
        GLOBALS['source_suffix'] = GLOBALS['source_suffix'].split(',')

    # add extensions from user settings if legal
    if US.has_key('extensions'):
        for k,e in US['extensions'].items():
            if not e in GLOBALS['extensions']:
                if (e in legal_extensions) or (US is OVERRIDES):
                    GLOBALS['extensions'].append(e)

    if US.has_key('extlinks'):
        for k, v in US['extlinks'].items():
            # untested!
            # we expect:
            #     forge = https://forge.typo3.org/issues/%s | forge:
            GLOBALS['extlinks'][k] = (v.split('|')[0].strip(), v.split('|')[1].strip())

    if US.has_key('intersphinx_mapping'):
        for k, v in US['intersphinx_mapping'].items():
            GLOBALS['intersphinx_mapping'][k] = (v, None)

    if US.has_key('html_theme_options'):
        for k, v in US['html_theme_options'].items():
            GLOBALS['html_theme_options'][k] = v

    LD = US.get('latex_documents', {})
    GLOBALS['latex_documents'] = [(
        LD.get('source_start_file') if LD.get('source_start_file') else  master_doc,
        LD.get('target_name')       if 0                           else  'PROJECT' + '.tex',
        LD.get('title')             if LD.get('title')             else  project,
        LD.get('author')            if LD.get('author')            else  t3author,
        LD.get('documentclass')     if 0                           else 'manual'
    )]

    LE = US.get('latex_elements', {})
    GLOBALS['latex_elements'] = {
        'papersize': LE.get('papersize') if 0 else 'a4paper',
        'pointsize': LE.get('pointsize') if 0 else '10pt',
        'preamble' : LE.get('preamble' ) if 0 else '\\usepackage{typo3}',
        # for more see: http://sphinx-doc.org/config.html#confval-latex_elements
    }

    MP = US.get('man_pages', {})
    GLOBALS['man_pages'] = [(
        MP.get('source_start_file') if MP.get('source_start_file') else  master_doc,
        MP.get('name')              if MP.get('name')              else  project,
        MP.get('description')       if MP.get('description')       else  description,
        [ MP.get('authors')         if MP.get('authors')           else  t3author ],
        MP.get('manual_section')    if MP.get('manual_section')    else  1
    )]

    TD = US.get('texinfo_documents', {})
    GLOBALS['texinfo_documents'] =[(
        TD.get('source_start_file') if TD.get('source_start_file') else master_doc,
        TD.get('target_name')       if TD.get('target_name')       else t3shortname,
        TD.get('title')             if TD.get('title')             else project,
        TD.get('author')            if TD.get('author')            else t3author,
        TD.get('dir_menu_entry')    if TD.get('dir_menu_entry')    else project,
        TD.get('description')       if TD.get('description')       else description,
        TD.get('category')          if TD.get('category')          else 'Miscellaneous'
    )]
    return

# NOW!
# This is where the magic happens! We update this module's globals()
# with the user settings US. That has the same effect as if the
# settings had been part of this conf.py

updateModuleGlobals(G, US)


# define if not existing

if not G.has_key('epub_author')      : epub_author    = t3author
if not G.has_key('epub_copyright')   : epub_copyright = copyright
if not G.has_key('epub_publisher')   : epub_publisher = t3author
if not G.has_key('epub_title')       : epub_title     = project
if not G.has_key('htmlhelp_basename'): htmlhelp_basename = t3shortname


# PART 4: Overrides from 'conf.py'

# Now we set some overrides

exclude_patterns = ['_make']
html_last_updated_fmt = '%b %d, %Y %H:%M'
html_static_path = []
html_theme = 't3SphinxThemeRtd'
html_theme_path = [ t3SphinxThemeRtd.get_html_theme_path() ]
pygments_style = 'sphinx'
templates_path = []
today_fmt = '%Y-%m-%d %H:%M'


# IMPORTANT SWITCH: Rendering for our server!
html_theme_options['docstypo3org'] = True


# 'published' means in the following context: Available under that
# name in the GlobalContext of Jinja2 templating. Example: if
# 'show_copyright' is in the published it can be used in the Jinja2
# template like:
#     {{ show_copyright }}


# 'html_show_copyright' is published as 'show_copyright'
html_show_copyright = True

# published as 'theme_show_copyright'
html_theme_options['show_copyright'] = True


# published as 'theme_show_last_updated
html_theme_options['show_last_updated'] = True


# published as 'theme_show_revision'
html_theme_options['show_revision'] = True


# published as 'show_source'
html_show_sourcelink = True

# published as 'theme_show_sourcelink'
html_theme_options['show_sourcelink'] = True


# published as 'show_sphinx'
html_show_sphinx = True

# published as 'theme_show_sphinx'
html_theme_options['show_sphinx'] = True


# published as 'use_opensearch' (set above already)
# html_use_opensearch = html_use_opensearch
# '' is published as 'theme_use_opensearch
# no trailing slash!
if not html_theme_options.has_key('use_opensearch'):
    html_theme_options['use_opensearch'] = ''
elif type(html_theme_options['use_opensearch']) in [type(''), type(u'')]:
    html_theme_options['use_opensearch'] = html_theme_options['use_opensearch'].rstrip('/')

# ? html_use_opensearch = html_theme_options['use_opensearch']

# PART 5: Finally: Overrides.cfg has the last word
#
# .. attention::
#
#    This file is under control of the admin. Make sure its
#    contents makes sense!
#
# If MAKEDIR/Overrides.cfg exists:
# Set all settings thereby overriding existing ones.
# So the admin has the last word

if notes['Overrides.cfg exists']:
    config = ConfigParser.RawConfigParser()
    config.readfp(codecs.open(overridesabspath, 'r', 'utf-8'))
    for s in config.sections():
        OVERRIDES[s] = OVERRIDES.get(s, {})
        for o in config.options(s):
            OVERRIDES[s][o] = config.get(s,o)


# AGAIN!
# Let the magic happen. This time we apply 'overrides' to the module's globals()
updateModuleGlobals(G, OVERRIDES)

# As other modules of Sphinx check the values of conf.py let's do
# a bit of housekeeping und remove helper vars that aren't needed any more.

for k in ['f1', 'f1name', 'o', 'contents',
    'extensions_to_be_loaded', 'section', 'legal_extensions',
    'config', 'US', 'item', 's', 'v', 'e', 'notes']:
    if G.has_key(k):
        del G[k]
del k

settingsLogFile = logdirabspath + '/Settings.pprinted.txt'

if 0 and 'dump resulting settings':
    import pprint
    pprint.pprint(globals())

if 1 and 'dump resulting settings to file':
    import pprint
    f2 = codecs.open(settingsLogFile, 'w', 'utf-8')
    pprint.pprint(globals(), stream=f2)
    f2.close()
    del f2
