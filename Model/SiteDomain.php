<?php
class SiteDomain extends SitesAppModel {

	public $useTable = 'site_domains';

	public $belongsTo = array(
		'Site' => array(
			'className' => 'Sites.Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
