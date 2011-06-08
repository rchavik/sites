<?php
class SiteDomain extends SitesAppModel {
	var $name = 'SiteDomain';
	var $useDbConfig = 'sites';
	var $useTable = 'site_domains';

	var $belongsTo = array(
		'Site' => array(
			'className' => 'Sites.Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
