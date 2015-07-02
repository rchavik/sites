<?php

use Croogo\Core\Nav;

Nav::add('extensions.children.sites', array(
	'title' => 'Sites',
	'url' => array(
        'prefix' => 'admin',
		'plugin' => 'Sites',
		'controller' => 'Sites',
		'action' => 'index',
	),
));
