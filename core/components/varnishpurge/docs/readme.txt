Varnish Purge
=============
Version: 1.0.2-beta (2013-05-16)
Authors: Dan Gibbs <dan@goldcoastmedia.co.uk>

This plugin helps to keep your MODx website up to date when using MODx with Varnish.

Optionally purge documents, objects or the entire domain from Varnish when:
- A document is saved/updated (to clear that page from the cache)
- The MODx cache is cleared (to clear the entire domains cache)

Your Varnish VCL must be configured to allow purge requests to be made
from the server that your MODx installation resides on. See the documentation
for more information.

Git repo: https://github.com/GoldCoastMedia/modx-varnish-purge

Documentation
-------------
Full detailed documentation available at: 
http://www.goldcoastmedia.co.uk/tools/modx-varnish-purge

Gold Coast Media Ltd
