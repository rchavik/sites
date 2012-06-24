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

Croogo::hookComponent('*', 'Sites.Multisite');

Croogo::hookHelper('Nodes', 'Sites.Sites');

Croogo::hookAdminTab('Nodes/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Nodes/admin_edit', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Attachments/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Attachments/admin_edit', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Blocks/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Blocks/admin_edit', 'Sites', 'sites.sites_selection');

require 'admin_menu.php';
