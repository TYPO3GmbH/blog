#! /usr/bin/env python

# See http://mbless.de/blog/2015/04/22/livereload-to-please-the-web-developer.html
# to learn about the purpose of this file.

import os
ospj = os.path.join
from livereload import Server, shell

def ignore(filePath):
    keep = True
    if keep and filePath.startswith('../_make'):
        keep = False
    return not keep

server = Server()
server.watch('..', func=shell('make html'), delay=None, ignore=ignore)
cwd = os.getcwd()
webroot = ospj(cwd,'build')
print 'webroot: ', webroot
server.serve(root=webroot)
