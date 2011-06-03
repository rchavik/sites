<?php

Croogo::hookBehavior('Node', 'Sites.SiteFilter', array(
	'relationship' => array(
		'hasAndBelongsToMany' => array(
			'Site' => array(
				'className' => 'Sites.Site',
				'with' => 'Sites.SitesNode',
				'foreignKey' => 'node_id',
				'associationForeignKey' => 'site_id',
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
				'with' => 'Cakeforum.SitesForumCategory',
				'foreignKey' => 'site_id',
				'associationForeignKey' => 'forum_category_id',
				),
			),
		),
	));
endif;

Croogo::hookComponent('*', 'Sites.Multisite');

Croogo::hookHelper('Nodes', 'Sites.Sites');

Croogo::hookAdminMenu('Sites');

Croogo::hookAdminTab('Nodes/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Nodes/admin_edit', 'Sites', 'sites.sites_selection');
