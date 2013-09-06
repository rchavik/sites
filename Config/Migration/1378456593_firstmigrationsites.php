<?php

App::uses('CakeMigration', 'Migrations.Lib');
App::uses('Sites', 'Sites.Lib');

class FirstMigrationSites extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'site_domains' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'domain' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
					'modified_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'modified' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'id' => array('column' => 'id', 'unique' => 1),
						'ix_sites_name' => array('column' => array('site_id', 'domain'), 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'site_metas' => array(
					'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'robots' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'keywords' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'site_id', 'unique' => 1),
						'pk_site_metas' => array('column' => 'site_id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'sites' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'tagline' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'locale' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'status' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
					'timezone' => array('type' => 'integer', 'null' => true, 'default' => '0'),
					'theme' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
					'modified_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'modified' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
					'default' => array('type' => 'integer', 'null' => true, 'default' => '0'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'id' => array('column' => 'id', 'unique' => 1),
						'ix_site_title' => array('column' => 'slug', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'sites_blocks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'block_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'created_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'id' => array('column' => 'id', 'unique' => 1),
						'ix_sites_blocks' => array('column' => array('site_id', 'block_id'), 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'sites_forum_categories' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'forum_category_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'created_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'id' => array('column' => 'id', 'unique' => 1),
						'ix_sites_nodes' => array('column' => array('site_id', 'forum_category_id'), 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'sites_links' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'link_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'created_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'id' => array('column' => 'id', 'unique' => 1),
						'ix_sites_links' => array('column' => array('site_id', 'link_id'), 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'sites_nodes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'site_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
					'node_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
					'created_by' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'id' => array('column' => 'id', 'unique' => 1),
						'ix_sites_nodes' => array('column' => array('site_id', 'node_id'), 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'site_domains', 'site_metas', 'sites', 'sites_blocks', 'sites_forum_categories', 'sites_links', 'sites_nodes'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		if ($direction == 'down') {
			return false;
		}

		if ($direction == 'up') {
			if (defined('FULL_BASE_URL')) {
				$parsed = parse_url(FULL_BASE_URL);
				if (!empty($parsed['host']) && $parsed['host'] !== 'localhost') {
					$_SERVER['HTTP_HOST'] = $parsed['host'];
				}
			}
			if (!isset($_SERVER['HTTP_HOST'])) {
				throw new CakeException('environment variable HTTP_HOST missing. Please use the Extensions plugin from the backend to activate this plugin.');
			}
		}
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		if ($direction == 'up') {
			$this->loadBaseline();
		}
		return true;
	}

/**
 * Insert baseline data (All Sites record) and create an entry for original site
 */
	public function loadBaseline() {
		$Site = ClassRegistry::init('Sites.Site');
		$Site->create();
		$domain = env('HTTP_HOST');
		if (empty($domain)) {
			$domain = 'your-site.com';
		}

		$data = array(
			'Site' => array(
				'id' => Sites::ALL_SITES,
				'title' => 'All Sites',
				'default' => false,
			),
		);
		$Site->id = Sites::ALL_SITES;
		if ($Site->exists()) {
			$count = $Site->SiteDomain->find('count', array(
				'conditions' => array(
					'SiteDomain.site_id' => Sites::ALL_SITES,
				)
			));
			if ($count > 0) {
				unset($data['SiteDomain']);
			}
		}
		$Site->saveAll($data);

		$site = $Site->findByTitle(Configure::read('Site.title'));
		if (empty($site)) {
			$data = array(
				'Site' => array(
					'title' => Configure::read('Site.title'),
					'tagline' => Configure::read('Site.tagline'),
					'email' => Configure::read('Site.email'),
					'locale' => Configure::read('Site.locale'),
					'status' => Configure::read('Site.status'),
					'timezone' => Configure::read('Site.timezone'),
					'theme' => Configure::read('Site.theme'),
					'default' => true,
				),
				'SiteDomain' => array(
					0 => array(
						'domain' => $domain,
					),
				),
			);
			$data = $Site->create($data);
			$Site->saveAll($data);
		}
	}

}
