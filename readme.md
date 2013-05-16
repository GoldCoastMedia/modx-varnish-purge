Varnish Purge for MODx Revolution
=================================

A MODx *Revolution* plugin that automatically purges pages when they are updated.
This plugin allows you to automatically send optional HTTP PURGE requests when:
- A document is saved/updated (to clear that page from the cache)
- The MODx cache is cleared (to clear the entire domains cache)

**Your Varnish VCL must be configured to allow purge requests to be made
from the server that your MODx installation resides on. See below for an example.**

Installation
-----------
- Install via MODx Package Manager.
- In the MODx Manager go to *System > System Setting*. Find *varnishpurge* and configure.

HTTP Purging
-----------
This is an example for allowing HTTP based purging locally. Please refer
to the official documentation. **Example only (3.0.3)**

```
# Allow purging locally (NOTE: you will need to add the servers remote IP)
acl purge {
	"localhost";
	"127.0.0.1";
}

sub vcl_recv {
	...
	
	if (req.request == "PURGE") {
		if (!client.ip ~ purge) {
			error 405 "Method not allowed.";
		}
		return (lookup);
	}
	
	...
}

sub vcl_hit {
	...
	
	if (req.request == "PURGE") {
		purge;
		error 200 "Purged.";
	}
	
	...
}

sub vcl_miss {
	...
	
	if (req.request == "PURGE") {
		purge;
		error 200 "Purged.";
	}
	
	...
}

```

Documentation
------------
Full detailed documentation available at:
http://www.goldcoastmedia.co.uk/tools/modx-varnish-purge
