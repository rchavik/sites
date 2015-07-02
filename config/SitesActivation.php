<?php

class SitesActivation {
	public function beforeActivation(&$controller) {
		if (defined('FULL_BASE_URL')) {
			$parsed = parse_url(FULL_BASE_URL);
			if (!empty($parsed['host']) && $parsed['host'] !== 'localhost') {
				$_SERVER['HTTP_HOST'] = $parsed['host'];
			}
		}
		if (!isset($_SERVER['HTTP_HOST'])) {
			throw new CakeException('environment variable HTTP_HOST missing. Please use the Extensions plugin from the backend to activate this plugin.');
		}
		return true;
	}

	public function onActivation(&$controller) {
		CakePlugin::load('Sites');
		App::import('Model', 'CakeSchema');
		App::import('Model', 'ConnectionManager');
		App::uses('Sites', 'Sites.Lib');
		include_once(APP.'Plugin'.DS.'Sites'.DS.'Config'.DS.'Schema'.DS.'schema.php');
		$db = ConnectionManager::getDataSource('default');

		//Get all available tables
		$tables = $db->listSources();

		$CakeSchema = new CakeSchema();
		$SiteSchema = new SiteSchema();

		foreach ($SiteSchema->tables as $table => $config) {
			if (!in_array($table, $tables)) {
				$db->execute($db->createSchema($SiteSchema, $table));
			}
		}

		//Ignore the cache since the tables wont be inside the cache at this point
		//$db->cacheSources = false;
		@unlink(TMP . 'cache' . DS . 'models/cake_model_' . ConnectionManager::getSourceName($db). '_' . $db->config["database"] . '_list');
		$db->listSources();

		//Insert "ALL SITES"
		$controller->loadModel('Sites.Site');
		$controller->Site->create();
		$data = array(
			'Site' => array(
				'id' => Sites::ALL_SITES,
				'title' => 'All Sites',
				'tagline' => Configure::read('Site.tagline'),
				'email' => Configure::read('Site.email'),
				'locale' => Configure::read('Site.locale'),
				'status' => Configure::read('Site.status'),
				'timezone' => Configure::read('Site.timezone'),
				'theme' => Configure::read('Site.theme'),
				'default' => 1,
			),
			'SiteDomain' => array(
				0 => array(
					'site_id' => Sites::ALL_SITES,
					'domain' => $_SERVER["HTTP_HOST"],
				),
			),
		);

		$controller->Site->id = Sites::ALL_SITES;
		if ($controller->Site->exists()) {
			$count = $controller->Site->SiteDomain->find('count', array(
				'conditions' => array(
					'SiteDomain.site_id' => Sites::ALL_SITES,
				)
			));
			if ($count > 0) {
				unset($data['SiteDomain']);
			}
		}
		$controller->Site->saveAll($data);
	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
	}

}