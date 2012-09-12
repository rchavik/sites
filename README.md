Sites Plugin Version 0.3
------------------------

This plugin enables multi-site support for Croogo (Original statement by the original author "rchavik"). This is an alternative version with a simpler and more comfortable GUI, some bugfixes and the possibility to choose a default site on your own. The default site represents the site that is going to be rendered in case there is no valid domain/subdomain/whatever specified.

On activation the database is automatically created and a default site is set up. Enjoy!

Configuration
-------------

1. Setup a new datasource named `sites` in croogo database configuration.

   You can use the same physical database as croogo, but `sites` datasource
   needs to be present since all plugin models will use this.

   Eg:

```
<?php

		class DATABASE_CONFIG {
			var $default = array(
				'driver' => 'mysql',
				'database' => 'croogo',
				...
				);

			var $sites = array(
				'driver' => 'mysql',
				'database' => 'croogo',
				...
				);
		}
```

2. Activate the plugin

   Don't forget to cross your fingers.

Link in a multisite environment
-------------------------------

The default menu helper generate menu link using a relative url. For some items,
you would need to have an absolute url in the link.  To achieve this, select the
site that applies to the Link and set `absolute=1` in the link's `params` field.

Canonical Url
-------------

You can use `SitesHelper::canonical()` to output a canonical url in your layout.


Known Bugs
----------

At the moment, there are no known bugs. Feel free to fork or to notify.

Requirements
------------

Croogo (tested on 1.5) - http://croogo.org/

Good luck and have fun.
-- rchavik (& bumuckl)
