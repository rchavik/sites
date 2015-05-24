<?php 

class SiteSchema extends CakeSchema {

	public $name = 'Site';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $sites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'length' => 255, 'null' => true),
		'slug' => array('type' => 'string', 'length' => 255, 'null' => true),
		'description' => array('type' => 'text', 'length' => 512, 'null' => true),
		'tagline' => array('type' => 'string', 'length' => 128, 'null' => true),
		'email' => array('type' => 'string', 'length' => 128, 'null' => true),
		'locale' => array('type' => 'string', 'length' => 20, 'null' => true),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'timezone' => array('type' => 'integer', 'null' => true, 'default' => 0),
		'theme' => array('type' => 'string', 'length' => 255, 'null' => true),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'timestamp', 'null' => true),
		'modified_by' => array('type' => 'string', 'length' => 36),
		'modified' => array('type' => 'timestamp', 'null' => true),
		'default' => array('type' => 'integer', 'null' => true, 'default' => 0),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_site_title' => array(
				'column' => array('slug'),
				'unique' => true,
			),
		),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
			'engine' => 'InnoDb'
		),
	);


	public $site_metas = array(
		'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'robots' => array('type' => 'string', 'length' => 100, 'null' => true),
		'keywords' => array('type' => 'string', 'length' => 255, 'null' => true),
		'description' => array('type' => 'text', 'length' => 500, 'null' => true),
		'indexes' => array(
			'pk_site_metas' => array('column' => array('site_id'), 'unique' => true),
		),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
		),
	);

	public $site_domains = array(
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

	public $sites_nodes = array(
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

	public $sites_blocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'site_id' => array('type' => 'integer', 'null' => false),
		'block_id' => array('type' => 'integer', 'null' => 'false'),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_sites_blocks' => array(
				'column' => array('site_id', 'block_id'),
				'unique' => true,
			),
		),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
			'engine' => 'InnoDb'
		),
	);

	public $sites_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'site_id' => array('type' => 'integer', 'null' => false),
		'link_id' => array('type' => 'integer', 'null' => 'false'),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_sites_links' => array(
				'column' => array('site_id', 'link_id'),
				'unique' => true,
			),
		),
		'tableParameters' => array(
			'charset' => 'utf8',
			'collate' => 'utf8_unicode_ci',
			'engine' => 'InnoDb'
		),
	);

	public $sites_forum_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'site_id' => array('type' => 'integer', 'null' => false),
		'forum_category_id' => array('type' => 'integer', 'null' => 'false'),
		'created_by' => array('type' => 'string', 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'id' => array('column' => array('id'), 'unique' => true),
			'ix_sites_nodes' => array(
				'column' => array('site_id', 'forum_category_id'),
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
