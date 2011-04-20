<?php

class SitesActivation {
	public function beforeActivation(&$controller) {
		return true;
	}

    public function onActivation(&$controller) {
		$Site = ClassRegistry::init('Sites.Site');

		$site = $Site->create(array(
			'id' => Sites::ALL_SITES,
			'name' => 'All Sites',
			'theme' => 'default',
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