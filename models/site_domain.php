<?php
class SiteDomain extends SitesAppModel {
	var $name = 'SiteDomain';
	//var $useDbConfig = 'default';

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
