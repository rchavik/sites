<?php

class SitesActivation {
	public function beforeActivation(&$controller) {
		return true;
	}

    public function onActivation(&$controller) {
		App::import('Libs', 'Sites.sites');
		$Site = ClassRegistry::init('Sites.Site');

		$site = $Site->create(array(
			'id' => Sites::ALL_SITES,
			'name' => 'All Sites',
			'tagline' => Configure::read('Site.tagline'),
			'email' => Configure::read('Site.email'),
			'locale' => Configure::read('Site.locale'),
			'status' => Configure::read('Site.status'),
			'timezone' => Configure::read('Site.timezone'),
			'theme' => Configure::read('Site.theme'),
			)
		);
		$Site->save($site);
    }

    public function beforeDeactivation(&$controller) {
        return true;
    }

    public function onDeactivation(&$controller) {
    }

}