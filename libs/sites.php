<?php

class Sites {

	const ALL_SITES = 1;

	private static $_site = array();

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
		if (empty(self::$_site) || $siteId !== null) {
			self::$_site = $_this->_getSite($siteId);
		} elseif (empty(self::$_site)) {
			self::$_site = $_this->_getSite($siteId);
		}
		$_this->_overrideSetting(array(
			'title', 'tagline', 'theme', 'timezone', 'locale', 'status',
			));

		return self::$_site;
	}

	function _getSite($siteId) {

		$options = array(
			'recursive' => false,
			'fields' => array('id', 'title', 'tagline', 'theme', 'timezone', 'locale', 'status'),
			'joins' => array(
				array(
					'table' => 'site_domains',
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

		$site_obj = ClassRegistry::init('Sites.Site');
		$site = $site_obj->find('first', $options);
		if (empty($site)) {
			$site = $site_obj->find('first', array(
				'recursive' => false,
				'fields' => array('id', 'title', 'tagline', 'theme', 'timezone', 'locale', 'status'),
				'joins' => array(
					array(
						'table' => 'site_domains',
						'alias' => 'SiteDomain',
						'conditions' => array(
							'SiteDomain.site_id = Site.id',
							),
						),
					),
				'conditions' => array( 'Site.default' => 1 ),
			));
		}
		return $site;
	}

}
?>
