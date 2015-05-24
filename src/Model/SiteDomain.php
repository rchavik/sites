<?php
class SiteDomain extends SitesAppModel {

	public $useTable = 'site_domains';

	public $belongsTo = array(
		'Site' => array(
			'className' => 'Sites.Site',
			'foreignKey' => 'site_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		)
	);

	public $validate = array(
		'domain' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Domain must not be empty',
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Domain must be unique',
			),
		),
	);

}
