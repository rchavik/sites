<?php 

class SitesSchema extends CakeSchema {

	var $name = 'Sites';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $sites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255, 'null' => true),
		'slug' => array('type' => 'string', 'length' => 255, 'null' => true),
		'description' => array('type' => 'text', 'length' => 512, 'null' => true),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'timestamp', 'null' => true),
		'modified_by' => array('type' => 'string', 'length' => 36),
		'modified' => array('type' => 'timestamp', 'null' => true),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_sites_name' => array(
				'column' => array('name'),
				'unique' => true,
				),
			),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
			'engine' => 'InnoDb'
			),
		);

	var $site_domains = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'site_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'domain' => array('type' => 'string', 'length' => 255, 'null' => false),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'timestamp', 'null' => true),
		'modified_by' => array('type' => 'string', 'length' => 36),
		'modified' => array('type' => 'timestamp', 'null' => true),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_sites_name' => array(
				'column' => array('site_id', 'domain'),
				'unique' => true,
				),
			),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
			'engine' => 'InnoDb'
			),
		);

	var $sites_nodes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'site_id' => array('type' => 'integer', 'null' => false),
		'node_id' => array('type' => 'integer', 'null' => 'false'),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_sites_nodes' => array(
				'column' => array('site_id', 'node_id'),
				'unique' => true,
				),
			),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
			'engine' => 'InnoDb'
			),
		);

}
