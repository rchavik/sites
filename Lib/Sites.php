<?php

class Sites {

	const ALL_SITES = 1;

	private static $_site = array();

	protected static $_sessionKey = 'Sites.current';

	public function &getInstance() {
		static $instance = null;
		if (! $instance) {
			$instance = new Sites;
		}
		return $instance;
	}

	private function _overrideSetting($key) {
		if (is_string($key)) {
			$keys = array($key);
		} else {
			$keys = $key;
		}
		foreach ($keys as $key) {
			if (! empty(self::$_site['Site'][$key])) {
				Configure::write('Site.' . $key, self::$_site['Site'][$key]);
			}
		}
	}

	public function currentSite($siteId = null) {
		$_this =& Sites::getInstance();
		self::$_site = $_this->_getSite($siteId);
		$_this->_overrideSetting(array(
			'title', 'tagline', 'theme', 'timezone', 'locale', 'status',
			));
		CakeSession::write(self::$_sessionKey, self::$_site);
		return self::$_site;
	}

	function _getSite($siteId = null) {
		$Site = ClassRegistry::init('Sites.Site');
		$SiteDomain = $Site->SiteDomain;
		$siteDomainTable = $SiteDomain->getDataSource()->fullTableName($SiteDomain, true, true);
		$options = array(
			'recursive' => false,
			'fields' => array('id', 'title', 'tagline', 'theme', 'timezone', 'locale', 'status'),
			'joins' => array(
				array(
					'table' => $siteDomainTable,
					'alias' => 'SiteDomain',
					'conditions' => array(
						'SiteDomain.site_id = Site.id',
						),
					),
				),
			);

		if (empty($siteId)) {
			$options['joins'][0]['conditions']['SiteDomain.domain LIKE'] = '%' . env('HTTP_HOST');
		} else {
			$options['conditions'] = array('Site.id' => $siteId);
		}

		$site = $Site->find('first', $options);
		if (empty($site)) {
			$site = $Site->find('first', array(
				'recursive' => false,
				'fields' => array('id', 'title', 'tagline', 'theme', 'timezone', 'locale', 'status'),
				'joins' => array(
					array(
						'table' => $siteDomainTable,
						'alias' => 'SiteDomain',
						'conditions' => array(
							'SiteDomain.site_id = Site.id',
							),
						),
					),
				'conditions' => array( 'Site.default' => 1 ),
			));
		}
		if ($siteId === null && CakeSession::check(self::$_sessionKey) && $active = CakeSession::read(self::$_sessionKey)) {
			if ($site['Site']['id'] == Sites::ALL_SITES) {
				$site = $active;
			}
		}
		return $site;
	}

}
?>
