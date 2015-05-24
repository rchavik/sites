<?php

CroogoNav::add('extensions.children.sites', array(
	'title' => 'Sites',
	'url' => array(
		'plugin' => 'sites',
		'admin' => true,
		'controller' => 'sites',
		'action' => 'index',
	),
));
