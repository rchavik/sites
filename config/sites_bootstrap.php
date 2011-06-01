<?php

Croogo::hookBehavior('Node', 'Sites.SiteFilter', array(
	'relationship' => array(
		'hasAndBelongsToMany' => array(
			'Site' => array(
				'className' => 'Sites.Site',
				'with' => 'Sites.SitesNode',
				'foreignKey' => 'site_id',
				'associationForeignKey' => 'node_id',
				),
			),
		),
	));

Croogo::hookComponent('*', 'Sites.Multisite');

Croogo::hookHelper('Nodes', 'Sites.Sites');

Croogo::hookAdminMenu('Sites');

Croogo::hookAdminTab('Nodes/admin_add', 'Sites', 'sites.sites_selection');
Croogo::hookAdminTab('Nodes/admin_edit', 'Sites', 'sites.sites_selection');
