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
		'SiteContents' => array(
			'className' => 'Sites.SitesNode',
			'foreignKey' => 'site_id',
			'dependent' => true,
		),
	);

}
