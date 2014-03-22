<?php

App::uses('CakeEventListener', 'Event');
App::uses('CroogoRouter', 'Croogo.Lib');
App::uses('Sites', 'Sites.Lib');
App::uses('StringConverter', 'Croogo.Lib/Utility');

/**
 * Sites Event Handler
 *
 * @category Event
 * @package  Sites
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class SitesEventHandler implements CakeEventListener {

/**
 * implementedEvents
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Sites.startRoutes' => array(
				'callable' => 'setupSiteRoutes',
			),
		);
	}

/**
 * Setup Site routes
 */
	public function setupSiteRoutes($event) {
		$site = Sites::currentSite();
		if (empty($site['Site']['home_url'])) {
			return;
		}

		static $converter;
		if ($converter === null) {
			$converter = new StringConverter();
		}

		$homeUrl = $converter->linkStringToArray($site['Site']['home_url']);
		if ($homeUrl) {
			CroogoRouter::connect('/', $homeUrl);
		}
	}

}
