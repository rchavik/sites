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
		$db = ConnectionManager::getDataSource('default');
		
		//Get all available tables
		$tables = $db->listSources();
		
		$CakeSchema = new CakeSchema();
		$SiteSchema = new SitesSchema();
        
        if (!in_array('sites', $tables)) {
        	$db->execute($db->createSchema($SiteSchema, 'sites'));
        }
        if (!in_array('site_domains', $tables)) {
        	$db->execute($db->createSchema($SiteSchema, 'site_domains'));
        }
        if (!in_array('sites_nodes', $tables)) {
        	$db->execute($db->createSchema($SiteSchema, 'sites_nodes'));
        }
        
        //Insert "ALL SITES"
	
		$Site = ClassRegistry::init('Sites.Site');
		$Site->create();
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
				'site_id' => Sites::ALL_SITES,
				'domain' => env('HTTP_HOST'),
			),
		);
		$Site->saveAll($data);
		
		/*$db->execute($db->rawQuery(
			'INSERT INTO sites ( id, title, tagline, email, locale, status, timezone, theme, default ) VALUES( 
			"1",
			"All Sites",
			"' . Configure::read('Site.tagline') . '",
			"' . Configure::read('Site.email') . '",
			"' . Configure::read('Site.locale') . '",
			"' . Configure::read('Site.status') . '",
			"' . Configure::read('Site.timezone') . '",
			"' . Configure::read('Site.theme') . '",
			"1"
			)'
		));*/
    }

    public function beforeDeactivation(&$controller) {
        return true;
    }

    public function onDeactivation(&$controller) {
    }

}