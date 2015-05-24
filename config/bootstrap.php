<?php

Croogo::hookBehavior('Node', 'Sites.SiteFilter', array(
	'relationship' => array(
		'hasAndBelongsToMany' => array(
			'Site' => array(
				'className' => 'Sites.Site',
				'with' => 'Sites.SitesNode',
				'foreignKey' => 'node_id',
				'associationForeignKey' => 'site_id',
				'unique' => 'keepExisting',
			),
		),
	),
));

Croogo::hookBehavior('Block', 'Sites.SiteFilter', array(
	'relationship' => array(
		'hasAndBelongsToMany' => array(
			'Site' => array(
				'className' => 'Sites.Site',
				'with' => 'Sites.SitesBlock',
				'foreignKey' => 'block_id',
				'associationForeignKey' => 'site_id',
				'unique' => 'keepExisting',
				'joinTable' => 'sites_blocks',
			),
		),
	),
));

Croogo::hookBehavior('Link', 'Sites.SiteFilter', array(
	'relationship' => array(
		'hasAndBelongsToMany' => array(
			'Site' => array(
				'className' => 'Sites.Site',
				'with' => 'Sites.SitesLink',
				'foreignKey' => 'link_id',
				'associationForeignKey' => 'site_id',
				'unique' => 'keepExisting',
				'joinTable' => 'sites_links',
			),
		),
	),
));

if (Configure::read('Cakeforum.name') !== false):
Croogo::hookBehavior('ForumCategory', 'Sites.SiteFilter', array(
	'relationship' => array(
		'hasAndBelongsToMany' => array(
			'Site' => array(
				'className' => 'Sites.Site',
				'with' => 'Sites.SitesForumCategory',
				'foreignKey' => 'forum_category_id',
				'associationForeignKey' => 'site_id',
			),
		),
	),
));
Croogo::hookComponent('ForumCategories', 'Sites.SiteFilter');
endif;

Croogo::hookComponent('*', array(
	'Sites.Multisite' => array(
		'priority' => 5,
	)
));

Croogo::hookHelper('*', 'Sites.Sites');

// uncomment this line to use absolute url for menu links
// alternatively, you can hook this helper later via other plugins
// Croogo::hookHelper('*', 'Sites.SitesMenus');

Croogo::hookAdminTab('Nodes/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Nodes/admin_edit', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Attachments/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Attachments/admin_edit', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Blocks/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Blocks/admin_edit', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Links/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Links/admin_edit', 'Sites', 'sites.sites_selection');

$cacheConfig = Cache::config('_cake_model_');
$cacheConfig = Hash::merge($cacheConfig['settings'], array(
	'prefix' => 'sites_',
	'path' => CACHE . 'queries',
	'duration' => '+1 hour',
));
Cache::config('sites', $cacheConfig);

require 'admin_menu.php';
