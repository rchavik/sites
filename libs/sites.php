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

	public function currentSite($siteId = null) {
		$_this = Sites::getInstance();
		if (! self::$_site) {
			self::$_site = $_this->_getSite($siteId);
		} else {
			if (self::$_site['Site']['id'] != $siteId) {
				self::$_site = $_this->_getSite($siteId);
			}
		}
		if (! empty(self::$_site['Site']['theme'])) {
			Configure::write('Site.theme', self::$_site['Site']['theme']);
		}
		return self::$_site;
	}

	function _getSite($siteId) {

		$options = array(
			'recursive' => false,
			'fields' => array('id', 'theme'),
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

		return ClassRegistry::init('Sites.Site')->find('first', $options);
	}

}
?>
