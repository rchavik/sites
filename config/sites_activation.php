<?php

class SitesActivation {
	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		App::import('Model', 'CakeSchema');
		App::import('Model', 'ConnectionManager');
		App::import('Libs', 'Sites.sites');
		include_once(APP.'plugins'.DS.'sites'.DS.'config'.DS.'schema'.DS.'schema.php');
		$db = ConnectionManager::getDataSource('sites');

		//Get all available tables
		$tables = $db->listSources();

		$CakeSchema = new CakeSchema();
		$SiteSchema = new SitesSchema();

		foreach ($SiteSchema->tables as $table => $config) {
			if (!in_array($table, $tables)) {
				$db->execute($db->createSchema($SiteSchema, $table));
			}
		}

		//Ignore the cache since the tables wont be inside the cache at this point
		//$db->cacheSources = false;
		@unlink(TMP . 'cache' . DS . 'models/cake_model_' . ConnectionManager::getSourceName($db). '_' . $db->config["database"] . '_list');
		$db->sources(true);

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
		$controller->Site->saveAll($data);

	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
	}

}