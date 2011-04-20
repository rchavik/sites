<?php
class Site extends SitesAppModel {
	var $name = 'Site';
	var $displayField = 'name';

	var $hasMany = array(
		'SiteDomain' => array(
			'className' => 'Sites.SiteDomain',
			'foreignKey' => 'site_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
			),
		);

	var $hasAndBelongsToMany = array(
		'Node' => array(
			'className' => 'Node',
			'joinTable' => 'sites_nodes',
			'foreignKey' => 'site_id',
			'associationForeignKey' => 'node_id',
			'dependent' => true,
			),
		);

}
