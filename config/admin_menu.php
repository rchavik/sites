<?php

use Croogo\Croogo\CroogoNav;

CroogoNav::add('extensions.children.sites', array(
	'title' => 'Sites',
	'url' => array(
        'prefix' => 'admin',
		'plugin' => 'Sites',
		'controller' => 'Sites',
		'action' => 'index',
	),
));
